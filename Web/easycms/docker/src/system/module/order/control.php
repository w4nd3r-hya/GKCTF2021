<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of order of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     order 
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class order extends control
{
    /**
     * Order confirm page.
     * 
     * @param  int    $product 
     * @param  int    $count 
     * @access public
     * @return void
     */
    public function confirm($product = 0, $count = 0)
    {
        $this->loadModel('product');
        $this->app->loadLang('cart');
        $referer    = helper::safe64Encode(inlink('confirm', "product={$product}&count={$count}"));
        $mobileURL  = helper::createLink('order', 'confirm', "product=$product&count=$count", '', 'mhtml');
        $desktopURL = helper::createLink('order', 'confirm', "product=$product&count=$count", '', 'html');

        if($_POST) $referer = helper::safe64Encode($this->createLink('cart', "browse"));
        if($this->app->user->account == 'guest') $this->locate($this->createLink('user', 'login', "referer={$referer}"));

        if($_POST) $product = $this->post->product;
        $this->view->products = $this->order->getPostedProducts($product, $count);

        $this->view->title          = $this->lang->order->confirm;
        $this->view->mobileTitle    = $this->lang->order->confirm;
        $this->view->addresses      = $this->loadModel('address')->getListByAccount($this->app->user->account);
        $this->view->currencySymbol = $this->config->product->currencySymbol;
        $this->view->mobileURL      = $mobileURL;
        $this->view->desktopURL     = $desktopURL;
        $this->display();
    }

    /**
     * Create an order.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        $return = $this->order->create();
        /* If return is array send it directly. */
        if(is_array($return)) $this->send($return);

        /* IF payment is alipay, goto pay page. */
        if(is_numeric($return) and $return) $orderID = $return;
        $order = $this->order->getByID($orderID);

        if(empty($order)) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('check', "orderID=$orderID")));
    }

    /**
     * View an order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function view($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($order->account != $this->app->user->account and $this->app->user->admin != 'super') die(js::locate('back'));

        $this->view->title    = $this->lang->order->view;
        $this->view->order    = $order;
        $this->view->type     = $order->type;
        $this->view->products = $this->order->getOrderProducts($orderID);
        $this->view->users    = $this->loadModel('user')->getPairs();
        $this->display();
    }

    /**
     * Check order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function check($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($order->account != $this->app->user->account) die(js::locate('back'));

        $inWechat = false;
        if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) $inWechat = true;

        $this->app->loadModuleConfig('product');

        $paymentList = explode(',', $this->config->shop->payment);
        foreach($paymentList as $payment)
        {
            $paymentOptions[$payment] = $this->lang->order->paymentList[$payment] . "<label for='buyMethod' class='redio-label'></label>";
        }

        if($inWechat && $paymentOptions['alipay']) unset($paymentOptions['alipay']);
        if($order->type != 'shop') unset($paymentOptions['COD']);

        $this->view->title          = $this->lang->order->check;
        $this->view->mobileTitle    = $this->lang->order->check;
        $this->view->order          = $order;
        $this->view->inWechat       = $inWechat;
        $this->view->products       = $this->order->getOrderProducts($orderID);
        $this->view->paymentList    = $paymentOptions;
        $this->view->currencySymbol = $this->config->product->currencySymbol;
        $this->display();
    }
 
    /**
     * Admin orders in my order.
     * 
     * @access public
     * @return void
     */
    public function admin($type = 'shop', $mode = 'all', $param = '', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 15,  $pageID = 1)
    {
        if(!commonModel::isAvailable('shop')) unset($this->lang->order->menu->express);
        $this->app->loadClass('pager', $static = true);
        $this->app->loadLang('product');
        $this->app->loadModuleConfig('product');

        $pager = new pager($recTotal, $recPerPage, $pageID);

        if(!commonModel::isAvailable('score')) unset($this->lang->order->types['score']);
        $this->view->title          = $this->lang->order->common;
        $this->view->orders         = $this->order->getList($type, $mode, $param, $orderBy, $pager);
        $this->view->pager          = $pager;
        $this->view->type           = $type;
        $this->view->orderBy        = $orderBy;
        $this->view->mode           = $mode;
        $this->view->param          = $param;
        $this->view->users          = $this->loadModel('user')->getPairs();
        $this->view->currencySymbol = $this->config->product->currencySymbol;
        $this->display();
    }

    /**
     * Track order delivery.
     * 
     * @param  int    $ordeID 
     * @access public
     * @return void
     */
    public function track($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($order->account != $this->app->user->account) die(js::locate('back'));
        $this->view->order       = $order;
        $this->view->title       = $this->lang->order->track;
        $this->view->expressList = $this->loadModel('tree')->getPairs(0, 'express');

        $address = json_decode($order->address);
        $this->view->subtitle    = "<span class='text-important'>" . $address->contact . '[' . str2Entity($address->phone) . ']' . $address->address . $address->zipcode . "</span>";
        $this->view->fullAddress = $this->view->subtitle;
        $this->view->mobileURL   = helper::createLink('order', 'track', "orderID=$orderID", '', 'mhtml');
        $this->view->desktopURL  = helper::createLink('order', 'track', "orderID=$orderID", '', 'html');

        $this->display();
    }

    /**
     * Pay order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function pay($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($order->payStatus == 'paid') $this->send(array('result' => 'success', 'message' => $this->lang->order->statusList['paid'], 'locate' => inlink('browse')));
 
        if($_POST)
        {
            $payment = $this->post->payment;
            $result  = $this->order->setPayment($orderID, $payment);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            if($payment == 'COD')
            {
                if($this->app->clientDevice == 'mobile')
                {
                    $this->send(array('result' => 'success', 'locate' => inlink('browse'), 'payment' => 'COD'));
                }
                else
                {
                    $this->locate(inlink('browse'));
                }
            }
            else
            {
                $order->payment = $payment;
                if($this->app->clientDevice == 'mobile')
                {
                    $this->send(array('result' => 'success', 'locate' => $this->order->createPayLink($order), 'payment' => $payment));
                }
                else
                {
                    $this->locate($this->order->createPayLink($order));
                }
            }
        }
    }

    /**
     * Wechat pay.
     * 
     * @param  int    $orderID 
     * @param  string $type 
     * @access public
     * @return void
     */
    public function wechatpay($orderID, $type = '')
    {
        $order = $this->order->getByID($orderID);

        if($order->payStatus == 'paid')
        {
            $order = $this->order->getOrderByRawID($orderID);

            $this->view->order  = $order;
            $this->view->result = true;

            $this->display('order', 'processorder');
        }
        else
        {
            $this->app->loadClass('wechatpay', true);
            $wechatConfig = $this->order->getWechatpayConfig();
            $wechatpay = new wechatPay($wechatConfig);

            $subject = $this->order->getSubject($orderID);
            $tradeID = uniqid('order' . $orderID . 'wechat');

            if($this->app->clientDevice != 'mobile')
            {
                $this->view->url = $wechatpay->getCodeUrl($subject, $tradeID, $order->amount * 100, 0);
            }
            else
            {
                $h5api = isset($this->config->wechatpay->h5api) ? $this->config->wechatpay->h5api : 'close';

                if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false || $h5api == 'close')
                {
                    $openID = $this->loadModel('user')->getOpenID($this->app->user->account, 'wechat');
                    if(!$openID)
                    {
                        $currentURL  = helper::createLink('order', 'wechatpay', "orderID=$orderID&type=$type");
                        $currentURL  = base64_encode($currentURL);
                        $redirectURL = getWebRoot(true) .  ltrim(helper::createLink('user', 'wechatbind', "url=$currentURL"), '/');

                        $this->locate($wechatpay->getAuthURL($redirectURL));
                    }
                    $config = $wechatpay->getJSAPIConfig($subject, $tradeID, $order->amount * 100, $openID);
                    $this->view->payConfig = $config;
                }
                else
                {
                    $tradeID = $this->order->getHumanOrder($orderID);

                    $params = array();
                    $params['body']             = $subject;
                    $params['out_trade_no']     = $tradeID;
                    $params['total_fee']        = $order->amount * 100;
                    $params['spbill_create_ip'] = $this->server->remote_addr; 
                    $params['notify_url']       = commonModel::getSysUrl() . inlink('processorder', "type=wechat&mode=notify");
                    $params['trade_type']       = 'MWEB';

                    $result = $wechatpay->unifiedOrder($params);
                    if($result['return_code'] == 'SUCCESS')
                    {   
                        $redirectURL = urlencode(commonModel::getSysUrl() . inlink('wechatpay', "orderID=$orderID&type=referer"));
                        $mwebUrl = $result['mweb_url'] . '&redirect_url=' . $redirectURL;
                    }
                }
            }

            $this->app->loadModuleConfig('product');

            $this->view->order          = $order;
            $this->view->tradeID        = $tradeID;
            $this->view->openLink       = !empty($mwebUrl) ? $mwebUrl : '';
            $this->view->type           = $type;
            $this->view->currencySymbol = $this->config->product->currencySymbol;

            $this->display();
        }
    }

    /**
     * Delivery order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function delivery($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($order->payment != 'COD' and $order->payStatus != 'paid') die($this->lang->order->statusList['not_paid']);
        if($order->payment == 'COD' and $order->deliveryStatus != 'not_send') die($this->lang->order->statusList['send']);

        if($_POST)
        {
            if($order->payment == 'alipaySecured') $this->order->postDeliveryToAlipay($order);
            $result = $this->order->delivery($orderID);
            $this->send($result);
        }

        $this->view->order       = $order;
        $this->view->title       = $this->lang->order->delivery;
        $this->view->expressList = $this->loadModel('tree')->getOptionMenu('express');

        $address = json_decode($order->address);
        $this->view->subtitle = "<span class='text-important'>" . $address->contact . '[' . str2Entity($address->phone) . ']' . $address->address . $address->zipcode . "</span>";

        $this->display();
    }

    /**
     * Confirm delivery.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function cancel($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($order->account != $this->app->user->account) die(js::locate('back'));

        if($order->deliveryStatus != 'send' and $order->payStatus != 'paid') 
        {
            $result =  $this->order->cancel($orderID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->order->cancelSuccess));
            $this->send(array('result' => 'fail', 'message' => dao::geterror()));
        }
        $this->send(array('result' => 'fail', 'message' => $lang->fail));
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
        $order = $this->order->getByID($orderID);
        if($order->account != $this->app->user->account) die(js::locate('back'));

        $result = $this->order->confirmDelivery($orderID);
        if($result) $this->send(array('result' => 'success', 'message' => $this->lang->order->deliveryConfirmed));
        $this->send(array('result' => 'fail', 'message' => dao::geterror()));
    }

    /**
     * Browse orders in my order.
     * 
     * @access public
     * @return void
     */
    public function browse($recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        $this->view->orders = $this->order->getList('all', 'account', $this->app->user->account, 'id_desc', $pager);
        $this->view->pager  = $pager;

        $this->app->loadLang('product');
        $this->app->loadModuleConfig('product');
        $this->view->currencySymbol = $this->config->product->currencySymbol;

        $this->view->title       = $this->lang->order->browse;
        $this->view->mobileTitle = $this->lang->order->browse;
        $this->view->mobileURL   = helper::createLink('order', 'browse', '', '', 'mhtml');
        $this->view->desktopURL  = helper::createLink('order', 'browse', '', '', 'html');
        $this->display();
    }
   
    /**
     * Process order.
     * 
     * @param  string $type
     * @param  string $mode
     * @access public
     * @return object
     */
    public function processOrder($type = 'alipay', $mode = 'return')
    {
        if($type == 'alipay')
        {
            $this->processAlipayOrder($mode);
        }
        else if($type == 'wechat')
        {
            $this->processWechatpayOrder($mode);
        }
        $this->display('order', zget($this->config->order->processViews, $this->view->order->type, 'processorder')); 
    }

    /**
     * Process alipay order.
     * 
     * @param  string $mode 
     * @access public
     * @return void
     */
    public function processAlipayOrder($mode = 'return')
    {
        $this->app->loadClass('alipay', true);
        $alipay = new alipay($this->config->alipay);

        /* Get the orderID from the alipay. */
        $order = $this->order->getOrderFromAlipay($mode);
        if(!$order)
        {
            $orderID = 0;
            if($mode == 'return' and ($this->get->trade_status == 'TRADE_FINISHED' or $this->get->trade_status == 'TRADE_SUCCESS'))
            {
                $orderID = $this->get->out_trade_no;
            }
            elseif($mode == 'notify' and ($this->post->trade_status == 'TRADE_FINISHED' or $this->post->trade_status == 'TRADE_SUCCESS'))
            {
                $orderID = $this->post->out_trade_no;
            }

            if($orderID) $orderID = $this->order->getRawOrder($orderID);
            $order = $this->order->getByID($orderID);

            if(!$order) die('STOP');
        }

        /* Process the order. */
        $result = $this->order->processOrder($order);

        /* Notify mode. */
        if($mode == 'notify')
        {
            $this->order->saveAlipayLog();
            if($result) die('success');
            die('fail');
        }

        /* Return model. */
        $order = $this->order->getOrderByRawID($order->id);

        $this->view->order  = $order;
        $this->view->result = $result;

        return $order;
    }

    /**
     * Process wechatpay order.
     * 
     * @param  string $mode 
     * @access public
     * @return void
     */
    public function processWechatpayOrder($mode = 'return')
    {
        /* Get the orderID from the wechatpay. */
        $order = $this->order->getOrderFromWechatpay($mode);
        if(!$order) die('STOP!');

        /* Process the order. */
        $result = $this->order->processOrder($order);

        /* Notify mode. */
        if($mode == 'notify')
        {
            $this->order->saveWechatpayLog();
            if($result) die('success');
            die('fail');
        }
    }

    /**
     * Finish order. 
     * 
     * @param  string    $orderID 
     * @access public
     * @return void
     */
    public function finish($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($order->status == 'finished') die($this->lang->order->statusList[$order->status]);
        if($order->payStatus != 'paid') die($this->lang->order->statusList[$order->payStatus]);
        if($order->deliveryStatus == 'not_send') die($this->lang->order->statusList[$order->deliveryStatus]);
        $result = $this->order->finish($orderID);
        if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        $this->send(array('result' => 'fail', 'message' => dao::geterror()));
    }

    /**
     * Redirect to payLink.
     * 
     * @access public
     * @return void
     */
    public function redirect()
    {
        die(js::locate($this->post->payLink));
    }
    
    /** 
     * Edit the return of order.
     * 
     * @access public
     * @param  int
     * @return array
     */
    public function savePayment($orderID)
    {   
        if($_POST)
        {   
            $result = $this->order->savePayment($orderID);
            if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->loadModel('action')->create('order', $orderID, 'SavedPayment', $this->post->snm, $this->post->amount);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }   
        $this->view->order = $this->order->getByID($orderID);
        $this->view->title = $this->lang->order->savePay;
        $this->display();
    }   

    /**
     * Order refund.
     * 
     * @param  int    $orderID 
     * @access public
     * @return void
     */
    public function refund($orderID)
    {
        if($_POST)
        {
            $result = $this->order->refund($orderID);
            if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $this->view->title = $this->lang->order->refund;
        $this->view->order = $this->order->getByID($orderID);
        $this->display();
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
        $order = $this->order->getByID($orderID);
        if($order->account != $this->app->user->account) die(js::locate('back'));

        if($_POST)
        {
            $result = $this->order->applyRefund($orderID);
            if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
        }

        $this->view->title   = $this->lang->order->applyRefund;
        $this->view->orderID = $orderID;
        $this->display();
    }

    /**
     * Edit the order
     *
     * @access public
     * @param  string
     * @return void
     */
    public function edit($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($this->app->user->admin != 'super' and $order->account != $this->app->user->account) die(js::locate('back'));

        if($_POST)
        {
            $changes = $this->order->edit($orderID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));

            if(!empty($changes))
            {
                $actionID = $this->loadModel('action')->create('order', $orderID, 'Edited');
                $this->action->logHistory($actionID, $changes);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }
        $this->view->expressList = $this->loadModel('tree')->getOptionMenu('express');
        $this->view->order       = $order;
        $this->view->products    = $this->order->getOrderProducts($orderID);
        $this->view->title       = $this->lang->order->edit;
        $this->display();
    }

    /**
     * Edit price.
     * 
     * @access public
     * @return void
     */
    public function editPrice($orderID)
    {
        if($_POST)
        {   
            $result = $this->order->editPrice($orderID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }   

        $this->view->title = $this->lang->order->editPrice;
        $this->view->order = $this->order->getByID($orderID);
        $this->display();
    }
    
    /**
     * Delete the order
     *
     * @access public
     * @param  string
     * @return void
     */
    public function delete($orderID)
    {
        $order = $this->order->getByID($orderID);
        if($this->app->user->admin != 'super' and $order->account != $this->app->user->account) die(js::locate('back'));

        $result = $this->order->deleteOrder($orderID);
        if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success', 'message' => $this->lang->deleteSuccess));
    }

    /**
     * Qrcode.
     * 
     * @param  string    $url 
     * @access public
     * @return void
     */
    public function qrcode($url)
    {
        $url = base64_decode($url);
        header("Content-Type: image/png");

        $this->app->loadClass('qrcode', true);
        echo qrcode::png($url, false, QR_ECLEVEL_L, 4);
    }

    /**
     * Ajax check order.
     * 
     * @param  int    $orderID 
     * @access public
     * @return string
     */
    public function ajaxCheckOrder($orderID)
    {
        $order = $this->order->getByID($orderID);
        echo $order->payStatus;
    }

    /**
     * Ajax query.
     * 
     * @param  int    $orderID 
     * @param  int    $tradeID 
     * @access public
     * @return void
     */
    public function ajaxQuery($orderID, $tradeID)
    {
        $this->app->loadClass('wechatpay', true);
        $wechatConfig = $this->order->getWechatpayConfig();
        $wechatpay = new wechatPay($wechatConfig);

        $data = $wechatpay->orderQuery(null, $tradeID);
        if($data['trade_state'] == 'SUCCESS') $this->order->updatePayStatus($orderID, 'paid');

        echo json_encode($data);
    }
}
