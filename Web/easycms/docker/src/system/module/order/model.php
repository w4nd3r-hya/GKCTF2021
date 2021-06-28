<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of order module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class orderModel extends model
{
    /**
     * Get order by ID.
     * 
     * @param  int    $id 
     * @access public
     * @return object
     */
    public function getByID($id)
    {
        return $this->dao->select('*')->from(TABLE_ORDER)->where('id')->eq($id)->fetch();
    }

    /**
     * Get order list.
     * 
     * @param  string    $mode 
     * @param  mix       $value 
     * @param  string    $orderBy 
     * @param  object    $pager 
     * @access public
     * @return array
     */
    public function getList($type = 'all', $mode, $value, $orderBy = 'id_desc', $pager = null)
    {
        $confirmLimitDays = $this->config->shop->confirmLimit;
        $expireLimitDays  = isset($this->config->shop->expireLimit) ? $this->config->shop->expireLimit : 30;

        if($confirmLimitDays)
        {
            $deliveryDate = date('Y-m-d H:i:s', time() - 24 * 60 * 60 * $confirmLimitDays);

            $this->dao->update(TABLE_ORDER)
                ->set('deliveryStatus')->eq('confirmed')
                ->set('last')->eq(helper::now())
                ->where('deliveryStatus')->eq('send')
                ->andWhere('deliveriedDate')->le($deliveryDate)
                ->andWhere('status')->ne('finished')
                ->exec();
        }

        if($expireLimitDays)
        {
            $createdDate  = date('Y-m-d H:i:s', time() - 24 * 60 * 60 * $expireLimitDays);
         
            $this->dao->update(TABLE_ORDER)
                ->set('status')->eq('expired')
                ->set('last')->eq(helper::now())
                ->where('payStatus')->eq('not_paid')
                ->andWhere('status')->ne('deleted')
                ->andWhere('status')->ne('expired')
                ->andWhere('createdDate')->le($createdDate)
                ->exec();
        }
        
        $orders = $this->dao->select('*')->from(TABLE_ORDER)
            ->where(1)
            ->andWhere('status')->ne('deleted')
            ->beginIf(!empty($type) and $type != 'all')->andWhere('type')->eq($type)->fi()
            ->beginIf($mode != 'all' and $mode != 'status' and $mode != 'account')->andWhere('status')->eq('normal')->fi()
            ->beginIf($mode == 'account')->andWhere('account')->eq($value)->fi()
            ->beginIf($mode == 'status')->andWhere('status')->eq($value)->fi()
            ->beginIf($mode == 'payStatus')->andWhere('payStatus')->eq($value)->fi()
            ->beginIf($mode == 'deliveryStatus' and $value !='not_send' )->andWhere('deliveryStatus')->eq($value)->fi()
            ->beginIf($mode == 'deliveryStatus' and $value =='not_send')
            ->andWhere("deliveryStatus = 'not_send' and (payStatus='paid' or payment='COD')")
            ->fi()
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll('id');
        
        $products = $this->dao->select('*')->from(TABLE_ORDER_PRODUCT)->where('orderID')->in(array_keys($orders))->fetchGroup('orderID');

        foreach($orders as $order)
        {
            if(isset($products[$order->id]))
            {
                foreach($products[$order->id] as $product)
                {
                    $images = $this->loadModel('file')->getByObject('product', $product->productID, $isImage = true);
                    if(empty($images[0])) continue;
                    $product->image = new stdclass();
                    if(!empty($images[0])) $product->image->primary = $images[0];
                }
            }
            $order->products = isset($products[$order->id]) ? $products[$order->id] : array();
        }
        return $orders;
    }

    /**
     * Create an order.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $order = fixer::input('post')
            ->add('account', $this->app->user->account)
            ->add('createdDate', helper::now())
            ->add('last', helper::now())
            ->add('payStatus', 'not_paid')
            ->add('status', 'normal')
            ->add('deliveryStatus', 'not_send')
            ->add('type', 'shop')
            ->get();

        $address = $this->dao->select('*')->from(TABLE_ADDRESS)->where('id')->eq($this->post->deliveryAddress)->andWhere('account')->eq($this->app->user->account)->fetch();
        $order->address = helper::jsonEncode($address);
 
        if($this->post->createAddress)
        {
            $address = $this->createAddress();
            if(!$address) return array('result' => 'fail', 'message' => dao::getError());
            $order->address = helper::jsonEncode($address);
        }

        $this->dao->insert(TABLE_ORDER)
            ->data($order, 'createAddress,deliveryAddress,zipcode,phone,contact,price,count,product')
            ->autocheck()
            ->batchCheck($this->config->order->require->create, 'notempty')
            ->exec();
			
        if(dao::isError()) return array('result' => 'fail', 'message' => dao::getError());

        $orderID = $this->dao->lastInsertID();

        $this->loadModel('action')->create('order', $orderID, 'Created');

        $goods = new stdclass();
        $goods->orderID = $orderID;
        
        if(!$this->post->product)
        {
            $this->clearOrder($orderID);
            return array('result' => 'fail', 'message' => $this->lang->order->noProducts);
        }

        /* Save products of the order and compute order amount. */
        $amount = 0;
        foreach($this->post->product as $product)
        {
            $product = $this->dao->select('*')->from(TABLE_PRODUCT)->where('id')->eq($product)->fetch();
            if(empty($product)) continue;

            $goods->productID   = $product->id; 
            $goods->productName = $product->name; 
            $goods->count       = $this->post->count[$product->id];

            if(isset($this->config->product->stock) && $this->config->product->stock)
            {
                if($product->amount < $goods->count)
                {
                    $this->clearOrder($orderID);
                    return array('result' => 'fail', 'message' => sprintf($this->lang->order->lowStocks, $goods->productName));
                }
            }

            $goods->price = $product->promotion > 0 ? $product->promotion : $product->price; 
            if(!$goods->price) continue;

            $amount += $goods->price * $goods->count;

            $this->dao->insert(TABLE_ORDER_PRODUCT)->data($goods)->autoCheck()->exec();
        }

        /* Check valid products count. */
        $productCout = $this->dao->select("count(*) as count")->from(TABLE_ORDER_PRODUCT)->where('orderID')->eq($orderID)->fetch('count');
        if(!$productCout)  return array('result' => 'fail', 'message' => $this->lang->order->noProducts);

        $this->dao->update(TABLE_ORDER)->set('amount')->eq($amount)->where('id')->eq($orderID)->exec();
        $this->dao->delete()->from(TABLE_CART)->where('account')->eq($this->app->user->account)->andWhere('product')->in($this->post->product)->exec();
      
        if(!dao::isError()) return $orderID;
    }

    /**
     * Create address from order.
     * 
     * @access public
     * @return void
     */
    public function createAddress()
    {
        $address = new stdclass();
        $this->loadModel('address');
        $post = fixer::input('post')->get();
        $address->account = $this->app->user->account;
        $address->address = $post->address;
        $address->contact = $post->contact;
        $address->phone   = $post->phone;
        $address->zipcode = $post->zipcode;

        $this->dao->insert(TABLE_ADDRESS)->data($address)->check('phone', 'phone')->batchCheck($this->config->address->require->create, 'notempty')->exec();
        if(dao::isError()) return false;
        return $address;
    }

    /**
     * Create pay link of an order.
     * 
     * @param  object $order
     * @access public
     * @return void
     */
    public function createPayLink($order, $type = '')
    {
        if($order->payment == 'alipay' or $order->payment == 'alipaySecured') return $this->createAlipayLink($order, $type);
        if($order->payment and is_callable(array($this, "create{$order->payment}Link"))) return call_user_func(array($this,"create{$order->payment}Link"), $order, $type);
        return helper::createLink('order', 'check', "orderID=$order->id");
    }

    /**
     * Get the human order id.
     * 
     * @param  int    $rawOrderID 
     * @access public
     * @return int
     */
    public function getHumanOrder($rawOrderID)
    {
        $order = $this->getByID($rawOrderID);
        if(!empty($order->humanID)) return $order->humanID;
        $humanID = date('ym') . str_pad($rawOrderID, 7, '0', STR_PAD_LEFT) . mt_rand(10, 99);
        $this->dao->update(TABLE_ORDER)->set('humanID')->eq($humanID)->where('id')->eq($rawOrderID)->exec();
        return $humanID;
    }

    /**
     * Get the raw order id.
     * 
     * @param  int    $humanOrder 
     * @access public
     * @return int
     */
    public function getRawOrder($humanOrder)
    {
        return (int)substr($humanOrder, 4, 7);
    }

    /**
     * Get wechatpay config.
     * 
     * @param  string $type 
     * @access public
     * @return void
     */
    public function getWechatpayConfig($type = '')
    {
        if(empty($this->config->wechatpay->appid)) return false;

        $notifyURL = empty($type) ? inlink('processorder', "type=wechatpay&mode=notify") : helper::createLink($type, 'processorder', "type=wechat&mode=notify");

        $wechatpayConfig = array();
        $wechatpayConfig['appid']       = $this->config->wechatpay->appid;
        $wechatpayConfig['mch_id']      = $this->config->wechatpay->mch_id;
        $wechatpayConfig['apikey']      = $this->config->wechatpay->apikey;
        $wechatpayConfig['appsecret']   = $this->config->wechatpay->appsecret;
        $wechatpayConfig['notify_url']  = getWebRoot(true) . ltrim($notifyURL, '/');
        $wechatpayConfig['device_info'] = 'WEB';

        return $wechatpayConfig;
    }

    /**
     * Create a alipay link. 
     * 
     * @param  object $order
     * @access public
     * @return string
     */
    public function createAlipayLink($order, $type = '')
    {
        if($type == 'shop') $type = 'order';

        $clientDevice = isset($this->app->clientDevice) ? $this->app->clientDevice : 'desktop';

        $this->app->loadClass('alipay', true);
        $alipayConfig = $order->payment == 'alipay' ? $this->config->alipay->direct : $this->config->alipay->secured;

        if($clientDevice == 'mobile') $alipayConfig->service = 'alipay.wap.create.direct.pay.by.user';

        /* Create right link that module is not order in order-browse page, such as score. */
        $notifyURL = empty($type) ? inlink('processorder', "type=alipay&mode=notify") : helper::createLink($type, 'processorder', "type=alipay&mode=notify");
        $returnURL = empty($type) ? inlink('processorder', "type=alipay&mode=return") : helper::createLink($type, 'processorder', "type=alipay&mode=return");
        $showURL   = helper::createLink('order', 'check', "orderID={$order->id}");

        $alipayConfig->notifyURL = commonModel::getSysURL() . $notifyURL;
        $alipayConfig->returnURL = commonModel::getSysURL() . $returnURL;
        $alipayConfig->showURL   = $clientDevice == 'mobile' ? commonModel::getSysURL() . $showURL : ''; 
        $alipayConfig->pid       = isset($this->config->alipay->pid)   ? $this->config->alipay->pid : '';
        $alipayConfig->key       = isset($this->config->alipay->key)   ? $this->config->alipay->key : '';
        $alipayConfig->email     = isset($this->config->alipay->email) ? $this->config->alipay->email : '';
        $alipayConfig->device    = $clientDevice; 
        
        $alipay  = new alipay($alipayConfig);
        $subject = $this->getSubject($order->id);
        $extend  = "TRANS_MEMO^{$this->app->siteCode}/{$order->type}/{$this->app->user->account}/{$this->app->user->realname}/{$this->app->user->company}|ISV^";

        return $alipay->createPayLink($this->getHumanOrder($order->id),  $subject, $order->amount, $body = '', $extra = '', $extend);
    }

    /**
     * Create wechatPay link.
     * 
     * @param  string $order
     * @param  string $type
     * @access public
     * @return void
     */
    public function createWechatPayLink($order, $type = '')
    {
        return helper::createLink('order', 'wechatpay', "orderID=$order->id&type=$type");
    }

    /**
     * Get order id from the alipay return.
     * 
     * @param  string $mode  return|notify
     * @access public
     * @return object
     */
    public function getOrderFromAlipay($mode = 'return')
    {
        $this->app->loadClass('alipay', true);
        $alipay = new alipay($this->config->alipay);

        $orderID = 0;
        if($mode == 'return')
        {
            unset($_GET['type']);
            unset($_GET['mode']);
            if($alipay->checkNotify($_GET) and ($this->get->trade_status == 'TRADE_FINISHED' or $this->get->trade_status == 'TRADE_SUCCESS' or $this->get->trade_status == 'WAIT_SELLER_SEND_GOODS'))
            {
                $orderID = $this->get->out_trade_no;
                $sn      = $this->get->trade_no;
            }
        }
        elseif($mode == 'notify')
        {
            if($alipay->checkNotify($_POST) and ($this->post->trade_status == 'TRADE_FINISHED' or $this->post->trade_status == 'TRADE_SUCCESS' or $this->get->trade_status == 'WAIT_SELLER_SEND_GOODS'))
            {
                $orderID = $this->post->out_trade_no;
                $sn      = $this->post->trade_no;
            }
        }

        if($orderID) $orderID = $this->getRawOrder($orderID);
        $order = $this->getByID($orderID);

        if(!$order) return false;

        $order->sn = $sn;
        return $order;
    }

    /**
     * Get order from wechatpay.
     * 
     * @param  string mode 
     * @access public
     * @return void
     */
    public function getOrderFromWechatpay($mode)
    {
        $this->app->loadClass('wechatpay', true);
        $wechatpay = new wechatpay($this->getWechatpayConfig());
        $data      = $wechatpay->get_back_data();

        if($data['return_code'] == 'SUCCESS')
        {
            $orderID = $data['out_trade_no'];
            if(!$orderID) return false;

            $orderID = $this->getRawOrder($orderID);
            $order = $this->getByID($orderID);

            if(!$order) return false;

            $order->sn = $data['transaction_id'];
            return $order;
        }
        return false;
    }

    /**
     * Save the request date from alipay to log file.
     * 
     * @access public
     * @return void
     */
    public function saveAlipayLog()
    {
        $content = date('Y-m-d H:i:s') . "\n";
        foreach($_POST as $key => $val) $content .= "$key = $val\n";
        $content .= "----------------\n";
        $logFile = $this->app->getTmpRoot() . 'log/alipay.log';
        $handle = fopen($logFile, 'a');
        fwrite($handle, $content);
        fclose($handle);
    }

    /**
     * Save wechatPay log. 
     * 
     * @access public
     * @return void
     */
    public function saveWechatpayLog()
    {   
        $content = date('Y-m-d H:i:s') . "\n";
        foreach($_POST as $key => $val) $content .= "$key = $val\n";
        $content .= "----------------\n";
        $logFile = $this->app->getTmpRoot() . 'log/wechatpay.log';
        $handle = fopen($logFile, 'a');
        fwrite($handle, $content);
        fclose($handle);
    }

    /**
     * Process an order.
     * 
     * @param  object $order
     * @access public
     * @return bool
     */
    public function processOrder($order)
    {
        if($order->payStatus == 'paid') return true;

        $this->dao->update(TABLE_ORDER)
            ->set('sn')->eq($order->sn)
            ->set('payStatus')->eq('paid')
            ->set('paidDate')->eq(helper::now())
            ->set('last')->eq(helper::now())
            ->where('id')->eq($order->id)->exec();

        if(dao::isError()) return false;
        $this->loadModel('action')->create('order', $order->id, 'Paid');

        if(!empty($order->type) && is_callable(array($this, "process{$order->type}Order"))) call_user_func(array($this, "process{$order->type}Order"), $order);
        return true;
    }

    /**
     * Process ccore order.
     * 
     * @param  int    $order 
     * @access public
     * @return void
     */
    public function processScoreOrder($order)
    {
        $result = $this->loadModel('score')->processOrder($order);
    }

    /**
     * Fix stocks of an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function fixStocks($orderID)
    {
        $goodsList = $this->dao->select('*')->from(TABLE_ORDER_PRODUCT)->where('orderID')->eq($orderID)->fetchAll();

        foreach($goodsList as $goods)
        {
            $product = $this->dao->select('*')->from(TABLE_PRODUCT)->where('id')->eq($goods->productID)->fetch();
            $stock = $product->amount - $goods->count;
            $this->dao->update(TABLE_PRODUCT)->set("amount")->eq($stock)->where('id')->eq($goods->productID)->exec();
        }

        return !dao::isError();
    }

    /**
     * Process status of and order.
     * 
     * @param  int    $order 
     * @access public
     * @return void
     */
    public function processStatus($order)
    {
        if($order->status == 'finished') return $this->lang->order->statusList['finished'];
        if($order->status == 'canceled') return $this->lang->order->statusList['canceled'];
        if($order->status == 'expired')  return $this->lang->order->statusList['expired'];
    
        if($order->payment == 'COD') return $this->lang->order->statusList[$order->deliveryStatus];

        if($order->payment != 'COD')
        {
            if($order->payStatus == 'paid') return $this->lang->order->statusList[$order->deliveryStatus];
            return $this->lang->order->statusList[$order->payStatus];
        }
    }

    /**
     * Update status after pay.
     * 
     * @param  int    $orderID 
     * @param  int    $status 
     * @access public
     * @return void
     */
    public function updatePayStatus($orderID, $status)
    {
        $this->dao->update(TABLE_ORDER)
            ->set('payStatus')->eq($status)
            ->set('last')->eq(helper::now())
            ->where('id')->eq($orderID)
            ->exec();
    }

    /**
     * Finish an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return bool
     */
    public function finish($orderID)
    {
        $this->dao->update(TABLE_ORDER)
            ->set('status')->eq('finished')
            ->set('finishedDate')->eq(helper::now())
            ->set('finishedBy')->eq($this->app->user->account)
            ->set('last')->eq(helper::now())
            ->where('id')->eq($orderID)
            ->exec();

        if(dao::isError()) return false;

        $this->loadModel('action')->create('order', $orderID, 'Finished');
        return !dao::isError();
    }

    /**
     * cancel an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function cancel($orderID)
    {
        $this->dao->update(TABLE_ORDER)
            ->set('status')->eq('canceled')
            ->set('last')->eq(helper::now())
            ->where('id')->eq($orderID)
            ->andWhere('account')->eq($this->app->user->account)
            ->exec();

        if(dao::isError()) return false;

        $this->loadModel('action')->create('order', $orderID, 'Canceled');
        return !dao::isError();
    }

    /**
     * Pay an order backend.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function pay($orderID)
    {
        $this->dao->update(TABLE_ORDER)
            ->set('payStatus')->eq('paid')
            ->set('sn')->eq($this->post->sn)
            ->set('paidDate')->eq($this->post->paidDate)
            ->set('last')->eq(helper::now())
            ->where('id')->eq($orderID)
            ->exec();
        return !dao::isError();
    }


    /**
     * Print goods of an order.
     * 
     * @param  string    $order 
     * @access public
     * @return string
     */
    public function printGoods($order)
    {
        if(!empty($order->type) && is_callable(array($this, "print{$order->type}Goods"))) return call_user_func(array($this, "print{$order->type}Goods"), $order);
        $goodsInfo = '';
        foreach($order->products as $product)
        {
            $goodsInfo .= "<div class='text-left'>";
            $goodsInfo .= '<span>' . $product->productName . '</span>';
            $goodsInfo .= "</div>";
        }
        return $goodsInfo;
    }

    /**
     * Print goods info of shop order.
     * 
     * @param  int    $order 
     * @access public
     * @return string
     */
    public function printShopGoods($order)
    {
        if(empty($order->products)) return '';
        foreach($order->products as $product)
        {
            $goodsInfo  = "<div class='text-left'>";
            $goodsInfo .= '<span>' . html::a(commonModel::createFrontLink('product', 'view', "id={$product->productID}"), $product->productName, "target='_blank'") . '</span>';
            $goodsInfo .= ' &times; ' . $product->count . '</div>';
        }
        return $goodsInfo;
    }

    /**
     * Print goods info of score order.
     * 
     * @param  int    $order 
     * @access public
     * @return void
     */
    public function printScoreGoods($order)
    {
        if(empty($order->products)) return '';
        $goods = current($order->products);
        $goods->productName = $goods->productName;
        return $goods->productName;
    }

    /**
     * Print actions of an order.
     * 
     * @param  string    $order 
     * @access public
     * @return string
     */
    public function printActions($order, $btnLink = false)
    {
        $this->commonLink = array();
        $this->commonLink['savePayment'] = true;
        $this->commonLink['cancelLink']  = true;

        $toggle = $btnLink ? '' : "data-toggle='modal'";

        if(RUN_MODE == 'admin')
        {
            $class = $btnLink ? 'btn btn-ajax-loader' : '';
            
            /* View order link */ 
            if(!$btnLink) echo html::a(inlink('view', "orderID=$order->id&btnLink=false"), $this->lang->order->view, $toggle);
            
            if($this->commonLink['savePayment'])
            {
                /* Save payment link. */
                $disabled = ($order->status == 'normal' and $order->payStatus == 'not_paid') ? '' : "disabled='disabled'";
                echo $disabled ? html::a('javascript:;', $this->lang->order->return, "$disabled  class='$class'") : html::a(inlink('savepayment', "orderID=$order->id"), $this->lang->order->return, "{$toggle} class='$class'"); 
            }

            /* Delete order link. */
            $disabled = ($order->status == 'expired' or $order->status == 'canceled' or $order->status == 'finished' or $order->payStatus == 'refunded') ? '' : "disabled='disabled'";
            echo $disabled ? html::a('javascript:;', $this->lang->order->delete, "$disabled class='$class'") : html::a(inlink('delete', "orderID=$order->id"), $this->lang->order->delete, " class='$class deleter'"); 
        }

        if(RUN_MODE == 'front')
        {
            $isMobile = ($this->app->clientDevice == 'mobile');
            
            /* View order link. */
            $disabled = ($order->status == 'normal' or $order->status == 'finished') ? '' : "disabled='disabled'";
            $class    = $isMobile ? "  btn btn-link " : "";
            echo $disabled ? '' : html::a(inlink('view', "orderID=$order->id"), $this->lang->order->view, "{$toggle} class='$class'"); 
            
            if($this->commonLink['cancelLink'])
            {
                /* Cancel link. */
                $disabled = ($order->deliveryStatus == 'not_send' and $order->payStatus == 'not_paid' and $order->status == 'normal') ? '' : "disabled='disabled'";
                $class    = $isMobile ? "  btn btn-link " : "";
                echo $disabled ? '' : html::a(helper::createLink('order', 'cancel', "orderID=$order->id"), $this->lang->order->cancel, "data-rel='" . helper::createLink('order', 'cancel', "orderID={$order->id}") . "' class='cancelLink {$class}'" );
            }

            /* Delete order link. */
            $disabled = $order->status == 'expired' ? '' : "disabled='disabled'";
            $class = $isMobile ? "  btn btn-link " : "";
            echo $disabled ? '' : html::a(inlink('delete', "orderID=$order->id"), $this->lang->order->delete, "class='deleter $class'"); 
        }

        if(!empty($order->type) && is_callable(array($this, "print{$order->type}Actions"))) call_user_func(array($this, "print{$order->type}Actions"), $order, $btnLink);
    }

    /**
     * Print actions buttons of shop order.
     * 
     * @param  object    $order 
     * @param  bool      $btnLink 
     * @access public
     * @return string
     */
    public function printShopActions($order, $btnLink = false)
    {
        $toggle = $btnLink ? '' : "data-toggle='modal'";

        if(RUN_MODE == 'admin' )
        {
            $class = $btnLink ? 'btn btn-ajax-loader' : '';

            /* Edit link. */
            $disabled = ($order->status == 'normal' and $order->payStatus != 'refunded') ? '' : "disabled = 'disabled'";
            echo $disabled ? html::a('javascript:;', $this->lang->order->edit, "$disabled  class='$class'") : html::a(inlink('edit', "orderID=$order->id"), $this->lang->order->edit, "{$toggle} class='$class'");
            
            /* Edit price link */
            $disabled = ($order->status == 'normal' and $order->payStatus !== 'paid') ? '' : "disabled='disabled'";
            echo $disabled ? html::a('javascript:;', $this->lang->order->editPrice, "$disabled class='$class'") : html::a(helper::createLink('order', 'editprice', "orderID=$order->id"), $this->lang->order->editPrice, "class='$class' {$toggle}");
           
            /* Send link. */
            $disabled = ($order->status == 'normal' and $order->deliveryStatus == 'not_send' and ($order->payment == 'COD' or ($order->payment != 'COD' and $order->payStatus == 'paid'))) ? '' : "disabled='disabled'"; 
            echo $disabled ?  html::a('javascript:;', $this->lang->order->delivery, "$disabled class='$class'") : html::a(helper::createLink('order', 'delivery', "orderID=$order->id"), $this->lang->order->delivery, "{$toggle} class='$class'");

            /* Refund link. */
            $disabled = ($order->deliveryStatus != 'confirmed' and $order->status == 'normal' and ($order->payStatus == 'paid' or $order->payStatus == 'refunding')) ? '' : "disabled='disabled'"; 
            echo $disabled ?  html::a('javascript:;', $this->lang->order->refund, "$disabled class='$class'") : html::a(helper::createLink('order', 'refund', "orderID=$order->id"), $this->lang->order->refund, "{$toggle} class='$class'");

            /* Finish link. */
            $disabled = ($order->status == 'normal' and $order->payStatus == 'paid' and $order->deliveryStatus == 'confirmed' and $order->status != 'finished' and $order->status != 'canceled') ? '' : "disabled='disabled'";
            echo $disabled ? html::a('javascript:;', $this->lang->order->finish, "$disabled class='$class'"): html::a('javascript:;', $this->lang->order->finish, "data-rel='" . helper::createLink('order', 'finish', "orderID=$order->id") . "' class='finisher $class'");
        }

        if(RUN_MODE == 'front' and $order->status == 'normal')
        {
            $class = $this->app->clientDevice == 'mobile' ? " btn btn-link " : "";
             
            /* Pay link. */
            $disabled = ($order->payment != 'COD' and $order->payStatus == 'not_paid' and $order->status != 'canceled') ? '' : "disabled='disabled'";
            echo $disabled ? '' : html::a($this->createPayLink($order, $order->type), $this->lang->order->pay, "target='_blank' class='btn-goToPay $class'");

            /* Edit link. */
            $disabled = ($order->deliveryStatus == 'not_send' and $order->payStatus != 'refunded') ? '' : "disabled='disabled'";
            echo $disabled ? '' : html::a(inlink('edit', "orderID={$order->id}"), $this->lang->order->edit, "{$toggle} class='$class'");

            /* Track link. */
            $disabled = ($order->deliveryStatus != 'not_send') ? '' : "disabled='disabled'";
            echo $disabled ? '' : html::a(inlink('track', "orderID={$order->id}"), $this->lang->order->track, "data-rel='" . helper::createLink('order', 'track', "orderID=$order->id") . "' data-toggle='modal' class='$class'");

            /* Refund link. */
            $disabled = ($order->payStatus == 'paid' and $order->deliveryStatus != 'confirmed') ? '' : "disabled='disabled'";
            echo $disabled ? '' : html::a(inlink('applyRefund', "orderID={$order->id}"), $this->lang->order->applyRefund, "class='applyRefund $class' data-toggle='modal'");

            /* Confirm link. */
            $disabled = ($order->deliveryStatus == 'send' and $order->payStatus == 'paid') ? '' : "disabled='disabled'";
            echo $disabled ? '' : html::a('javascript:;', $this->lang->order->confirmReceived, "data-rel='" . helper::createLink('order', 'confirmDelivery', "orderID=$order->id") . "' class='confirmDelivery $class'");
        }
    }

    /**
     * Print action buttons of score order.
     * 
     * @param  object    $order 
     * @param  bool      $btnLink 
     * @access public
     * @return string
     */
    public function printScoreActions($order, $btnLink)
    {
        if(RUN_MODE == 'front' and $order->status == 'normal') 
        {
            $class = $this->app->clientDevice == 'mobile' ? " btn btn-link " : "";
            
            /* Pay link. */
            $disabled = ($order->payment != 'COD' and $order->payStatus != 'paid') ? '' : "disabled='disabled'";
            echo $disabled ? '' : html::a($this->createPayLink($order, $order->type), $this->lang->order->pay, "target='_blank' class='btn-go2pay $class'");
        }
    }

    /**
     * Confirm delivery.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function confirmDelivery($orderID)
    {
        $this->dao->update(TABLE_ORDER)
            ->set('deliveryStatus')->eq('confirmed')
            ->set('confirmedDate')->eq(helper::now())
            ->set('last')->eq(helper::now())
            ->where('id')->eq($orderID)
            ->andWhere('account')->eq($this->app->user->account)
            ->exec();

        if(dao::isError()) return false;

        $this->loadModel('action')->create('order', $orderID, 'ConfirmedDelivery');
        return !dao::isError();
    }

    /**
     * Get order by id 
     * 
     * @param  int    $rawOrder 
     * @access public
     * @return object
     */
    public function getOrderByRawID($rawOrder)
    {
        $order = $this->dao->select('*')->from(TABLE_ORDER)->where('id')->eq((int)$rawOrder)->fetch();
        if(!$order) return false;
        $order->humanOrder = $this->getHumanOrder($order->id);
        return $order;
    }

    /**
     * Get order by id 
     * 
     * @param  int    $humanOrder 
     * @access public
     * @return object
     */
    public function getOrderByHumanID($humanOrder)
    {
        $rawOrder = $this->getRawOrder($humanOrder);
        return $this->getOrderByRawID($rawOrder);
    }

    /**
     * Delivery products of an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function delivery($orderID)
    {
        $order = $this->getByID($orderID);

        $delivery = fixer::input('post')
            ->add('deliveriedBy', $this->app->user->account)
            ->add('deliveryStatus', 'send')
            ->add('last', helper::now())
            ->get();

        $this->dao->update(TABLE_ORDER)->data($delivery)->where('id')->eq($orderID)->exec();

        if(dao::isError()) return array('result' => 'fail', 'message' => dao::getError());

        $this->loadModel('action')->create('order', $orderID, 'Deliveried');

        if(isset($this->config->product->stock) and $this->config->product->stock)
        {
            $goodsList = $this->dao->select('*')->from(TABLE_ORDER_PRODUCT)->where('orderID')->eq($orderID)->fetchAll();
            foreach($goodsList as $goods)
            {
                $product = $this->dao->select('*')->from(TABLE_PRODUCT)->where('id')->eq($goods->productID)->fetch();
                if($product->amount < $goods->count)
                {
                    return array('result' => 'fail', 'message' => strip_tags(sprintf($this->lang->order->lowStocks, $goods->productName)));
                }
            }
        }

        if(isset($this->config->product->stock) and $this->config->product->stock) $this->fixStocks($orderID);

        return array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin'));
    }

    /**
     * postDeliveryToAlipay 
     * 
     * @param  int    $order 
     * @access public
     * @return void
     */
    public function postDeliveryToAlipay($order)
    {
        $this->app->loadClass('alipay', true);

        $alipayConfig = $this->config->alipay->secured;
        $alipayConfig->pid   = $this->config->alipay->pid;
        $alipayConfig->key   = $this->config->alipay->key;
        $alipayConfig->email = $this->config->alipay->email;
        
        $alipay = new alipay($alipayConfig);
        $expressList = $this->loadModel('tree')->getPairs(0, 'express');
        $express     = zget($expressList, $this->post->express);
        return $alipay->postDelivery($order->sn, $express, $this->post->waybill);
    }

    /**
     * Get product infomation posted to buy.
     * 
     * @param  string $product 
     * @param  int    $count 
     * @access public
     * @return void
     */
    public function getPostedProducts($product, $count = 0)
    {
        $productIdList  = (array) $product;

        /* Get products(use groupBy to distinct products).  */
        $products = $this->dao->select('t1.*, t2.category')->from(TABLE_PRODUCT)->alias('t1')
            ->leftJoin(TABLE_RELATION)->alias('t2')->on('t1.id = t2.id')
            ->where('t1.id')->in($productIdList)
            ->andWhere('t2.type')->eq('product')
            ->beginIF(RUN_MODE == 'front')->andWhere('t1.status')->eq('normal')->fi()
            ->fetchAll('id');

        if(empty($products)) return array();

        /* Get categories for these products. */
        $categories = $this->dao->select('t2.id, t2.name, t2.alias, t1.id AS product')
            ->from(TABLE_RELATION)->alias('t1')
            ->leftJoin(TABLE_CATEGORY)->alias('t2')->on('t1.category = t2.id')
            ->where('t2.type')->eq('product')
            ->andWhere('t1.id')->in(array_keys($products))
            ->fetchGroup('product', 'id');

        /* Assign categories to it's product. */
        foreach($products as $product) $product->categories = !empty($categories[$product->id]) ? $categories[$product->id] : array();

        /* Get images for these products. */
        $images = $this->loadModel('file')->getByObject('product', array_keys($products), $isImage = true);
        
        /* Assign images to it's product. */
        foreach($products as $product)
        {
            if($_POST) $product->count = $this->post->count[$product->id];
            if(!$_POST) $product->count = $count;
            if(empty($images[$product->id])) continue;
            $product->image = new stdclass();
            if(isset($images[$product->id]))  $product->image->list = $images[$product->id];
            if(!empty($product->image->list)) $product->image->primary = $product->image->list[0];
        }
        
        return $products;
    }

    /**
     * Save settings. 
     * 
     * @access public
     * @return void
     */
    public function saveSetting()
    {
        $errors = array();
        if(!$this->post->payment) $errors = $this->lang->order->paymentRequired;
        if(!$this->post->confirmLimit) $errors['confirmLimit'] = array($this->lang->order->confirmLimitRequired);
        if(in_array('alipay', $this->post->payment) and strlen($this->post->pid) != 16) $errors['pid'] = array($this->lang->order->placeholder->pid);
        if(in_array('alipay', $this->post->payment) and strlen($this->post->key) != 32) $errors['key'] = array($this->lang->order->placeholder->key);
        if(in_array('alipay', $this->post->payment) and !validater::checkEmail($this->post->email)) $errors['email'] = array(sprintf($this->lang->error->email, $this->lang->order->alipayEmail));
        if(in_array('wechatpay', $this->post->payment))
        {
            $wechatpaySetting = $this->post->wechat;
            foreach($wechatpaySetting as $item => $value)
            {
                if(empty($value)) $errors["wechat_$item"] = array(zget($this->lang->order->placeholder, $item));
            }
        }

        if(!empty($errors)) return array('result' => 'fail', 'message' => $errors);

        $shopSetting = array();
        $shopSetting['payment']      = join(',', $this->post->payment);
        $shopSetting['confirmLimit'] = $this->post->confirmLimit;
        $shopSetting['expireLimit']  = $this->post->expireLimit;
        $this->loadModel('setting')->setItems('system.common.shop', $shopSetting);

        $alipaySetting = array();
        $alipaySetting['pid']   = $this->post->pid;
        $alipaySetting['key']   = $this->post->key;
        $alipaySetting['email'] = $this->post->email;
        $result = $this->loadModel('setting')->setItems('system.common.alipay', $alipaySetting);

        if(!empty($wechatpaySetting)) $this->loadModel('setting')->setItems('system.common.wechatpay', $wechatpaySetting);
        
        return array('result' => 'success', 'message' => $this->lang->saveSuccess);
    }

    /**                                                                                                         
     * Display express info.                                                                                    
     *                                                                                                          
     * @param $order                                                                                            
     * @access public                                                                                           
     * @return string                                                                                           
     */                                                                                                         
     public function expressInfo($order='')                                                                     
     {                                                                                                          
         $expressList = $this->loadModel('tree')->getPairs(0, 'express');                                       
         $expressInfo = zget($expressList, $order->express);                                                    
         return $expressInfo;                                                                                   
     }

    /**
     * Clear an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return bool
     */
    public function clearOrder($orderID)
    {
        $this->dao->delete()->from(TABLE_ORDER)->where('id')->eq($orderID)->exec();
        if(dao::isError()) return false;
        $this->dao->delete()->from(TABLE_ORDER_PRODUCT)->where('orderID')->eq($orderID)->exec();
        return !dao::isError();
    }

    /**
     * Get lastest orders 
     * 
     * @access public
     * @return array 
     */
    public function getOrders()
    {
        $orders = $this->dao->select('*')->from(TABLE_ORDER)
            ->where('createdDate')->like(date("Y-m-d") . '%')
            ->orderBy('`createdDate` desc')
            ->limit(5)
            ->fetchAll();

        return $orders;
    }

    /**
     * Get products of order.
     *
     * @param  int    $orderID
     * @access public
     * @return array
     */
    public function getOrderProducts($orderID)
    {
        return $this->dao->select('*')->from(TABLE_ORDER_PRODUCT)
            ->where('orderID')->eq($orderID)
            ->fetchAll();
    }

    /**
     * Set order payment.
     *
     * @param  int    $orderID
     * @param  int    $payment
     * @access public
     * @return void
     */
    public function setPayment($orderID, $payment)
    {
        $this->dao->update(TABLE_ORDER)
            ->set('payment')->eq($payment)
            ->set('last')->eq(helper::now())
            ->where('id')->eq($orderID)
            ->exec();
        return !dao::isError();
    }

    /**
     * Get the subject of order.
     *
     * @param  int    $orderID
     * @access public
     * @return void
     */
    public function getSubject($orderID)
    {
        $products = $this->dao->select('id,productName')->from(TABLE_ORDER_PRODUCT)->where('orderID')->eq($orderID)->fetchPairs();
        if(count($products) == 1) return current($products);

        return sprintf($this->lang->order->payInfo, $this->config->site->name, date('Y-m-d'));
    }

    /**
     * Get the show url of order
     *
     * @param  int $orderID
     * @access public 
     * @return string
     */ 
    public function getShowUrl($orderID)
    {
        return commonModel::getSysURL() . helper::createLink('order', 'check', "orderID=$orderID");
    }
    /** 
     * Save the save pay data
     *
     * @access public
     * @param  int
     * @return array
     */
    public function savePayment($orderID)
    {   
        $data = fixer::input('post')->add('last', helper::now())->get();

        $order     = $this->getByID($orderID);
        $order->sn = $data->sn;
        $this->processOrder($order);

        $this->dao->update(TABLE_ORDER)
            ->data($data)
            ->batchCheck($this->config->order->require->savepay, 'notempty')
            ->where('id')->eq($orderID)
            ->exec();

        return !dao::isError();
    }

    /**
     * Refund an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return bool
     */
    public function refund($orderID)
    {
        $this->dao->update(TABLE_ORDER)
            ->set('refundSN')->eq($this->post->sn)
            ->set('payStatus')->eq('refunded')
            ->set('last')->eq(helper::now())
            ->where('id')->eq($orderID)
            ->exec();

        if(dao::isError()) return false;

        $this->loadModel('action')->create('order', $orderID, 'Refunded', $this->post->comment, $this->post->amount);
        return !dao::isError();
    }

    /**
     * Apply refund.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function applyRefund($orderID)
    {
        $this->dao->update(TABLE_ORDER)->set('payStatus')->eq('refunding')->set('last')->eq(helper::now())->where('id')->eq($orderID)->exec();
        if(dao::isError()) return false;

        $this->loadModel('action')->create('order', $orderID, 'applyRefunded', $this->post->comment);
        return !dao::isError();
    }

    /**
     * Edit the order
     * 
     * @access public
     * @param  string
     * @return array
     */
    public function edit($orderID)
    {   
        $data = fixer::input('post')->get();
        $content = new stdclass();
        
        $order = $this->getByID($orderID);

        if(RUN_MODE == 'admin' and isset($data->count))
        {
            foreach($data->count as $goodsID => $count)
            {
                if($count > 0)
                {
                    $this->dao->update(TABLE_ORDER_PRODUCT)->set('count')->eq($count)->where('id')->eq($goodsID)->exec();
                }
                if($count == '0')
                {
                    $this->dao->delete()->from(TABLE_ORDER_PRODUCT)->where('id')->eq($goodsID)->exec();
                }
            }
            $totalAmount = $this->computeOrderAmount($orderID);
            if($totalAmount != $order->amount)
            {
                $this->dao->update(TABLE_ORDER)->set('amount')->eq($totalAmount)->where('id')->eq($orderID)->exec();
            }
        }
        
        $address['account'] = $this->app->user->account;
        $address['address'] = $data->address;
        $address['contact'] = $data->contact;
        $address['phone']   = $data->phone;
        $address['zipcode'] = $data->zipcode;
        $address['lang']    = $this->app->clientLang;
        $address = json_encode($address);

        $content->address = $address; 

        if($order->deliveryStatus === 'send')
        {   
            $content->express        = $data->express;
            $content->waybill        = $data->waybill;
            $content->deliveriedDate = $data->deliveriedDate;
            $content->deliveriedBy   = $this->app->user->account;
        }
        
        $content->note = $data->note;
        $content->last = helper::now();
        
        $this->dao->update(TABLE_ORDER)->data($content)->where('id')->eq($orderID)->exec();

        $orderAddress   = json_decode($order->address);
        $contentAddress = json_decode($content->address);

        unset($order->address);
        unset($content->address);

        $order->contact = $orderAddress->contact;
        $order->address = $orderAddress->address;
        $order->phone   = $orderAddress->phone;
        $order->zipcode = $orderAddress->zipcode;

        $content->contact = $contentAddress->contact;
        $content->address = $contentAddress->address;
        $content->phone   = $contentAddress->phone;
        $content->zipcode = $contentAddress->zipcode;

        return commonModel::createChanges($order, $content);
    }

    /**
     * Edit price of an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return bool
     */
    public function editPrice($orderID)
    {
        $this->dao->update(TABLE_ORDER)->set('amount')->eq($this->post->amount)->set('last')->eq(helper::now())->where('id')->eq($orderID)->exec();
        return !dao::isError();
    }


    /**
     * Delete the order
     * 
     * @access public
     * @param  string
     * @return bool
     */
    public function deleteOrder($orderID)
    {
        $this->dao->update(TABLE_ORDER)
            ->set('status')->eq('deleted')
            ->set('last')->eq(helper::now())
            ->where('id')->eq($orderID)
            ->exec();
        return !dao::isError(); 
    }

    /**
     * Compute the total amount of order 
     *
     * @access public
     * @param  string
     * @return int
     */
    public function computeOrderAmount($orderID)
    {
        $products = $this->getOrderProducts($orderID);
        $amount   = 0;
        foreach($products as $product)
        {
            $amount += $product->count * $product->price;
        }
        return $amount;
    }
}
