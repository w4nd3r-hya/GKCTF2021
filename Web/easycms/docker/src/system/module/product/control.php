<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of product module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class product extends control
{

    public function __construct()
    {
        parent::__construct();
        if(RUN_MODE == 'admin' and $this->app->getMethodName() != 'setting')
        {
            $this->view->treeModuleMenu = $this->loadModel('tree')->getTreeMenu('product', 0, array('treeModel', 'createAdminLink'));
            $this->view->treeManageLink = html::a(helper::createLink('tree', 'browse', "type=product"), $this->lang->tree->manage);
        }
    }

    /**
     * Index page of product module.
     * 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function index($pageID = 1)
    {
        /* Display browse page. */
        $this->locate($this->inlink('browse', "categoryID=0&pageID={$pageID}"));
    }

    /** 
     * Browse product in front.
     * 
     * @param int    $categoryID   the category id
     * @param int    $pageID       current page id
     * @access public
     * @return void
     */
    public function browse($categoryID = 0, $pageID = 1)
    {  
        $category   = $this->loadModel('tree')->getByID($categoryID, 'product');
        $categoryID = is_numeric($categoryID) ? $categoryID : zget($category, 'id', 0);
        if($category && $category->link) helper::header301($category->link);

        if($this->app->clientDevice == 'desktop') 
        {
            $recPerPage = !empty($this->config->site->productRec) ? $this->config->site->productRec : $this->config->product->recPerPage;
        }
        else
        {
            $recPerPage = !empty($this->config->site->productMobileRec) ? $this->config->site->productMobileRec : $this->config->product->recPerPage;
        }

        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, $recPerPage, $pageID);

        $orderBy    = isset($_COOKIE['productOrderBy'][$categoryID]) ? $_COOKIE['productOrderBy'][$categoryID] : 'order_desc';
        $orderField = str_replace('_asc', '', $orderBy);
        $orderField = str_replace('_desc', '', $orderField);
        if(!in_array($orderField, array('id', 'views', 'order'))) $orderBy = 'order_desc';

        $products   = $this->product->getList($this->tree->getFamily($categoryID, 'product'), $orderBy, $pager);
        $products   = $this->loadModel('file')->processImages($products, 'product');

        if(!$category and $categoryID != 0) die($this->fetch('errors', 'index'));

        if($categoryID == 0)
        {
            $category = new stdclass();
            $category->id       = 0;
            $category->desc     = '';
            $category->alias    = '';
            $category->name     = $this->lang->product->home;
            $category->keywords = '';
        }

        $this->session->set('productCategory', $category->id);

        $productList = '';
        foreach($products as $product) $productList .= $product->id . ',';
        $this->view->productList = $productList;

        $this->view->title      = $category->name;
        $this->view->keywords   = trim($category->keywords);
        $this->view->desc       = strip_tags($category->desc) . ' ';
        $this->view->category   = $category;
        $this->view->products   = $products;
        $this->view->pager      = $pager;
        $this->view->pageID     = $pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->contact    = $this->loadModel('company')->getContact();
        $this->view->mobileURL  = helper::createLink('product', 'browse', "categoryID=$categoryID&pageID=$pageID", "category=$category->alias", 'mhtml');
        $this->view->desktopURL = helper::createLink('product', 'browse', "categoryID=$categoryID&pageID=$pageID", "category=$category->alias", 'html');
        $this->view->layouts    = $this->loadModel('block')->getPageBlocks('product', 'browse', $category->id);
        $this->view->sideGrid   = $this->loadModel('ui')->getThemeSetting('sideGrid', 3);
        $this->view->sideFloat  = $this->ui->getThemeSetting('sideFloat', 'right');

        if($this->app->clientDevice == 'desktop') 
        {
            $this->view->canonicalURL = helper::createLink('product', 'browse', "categoryID=$categoryID&pageID=$pageID", "category={$category->alias}", 'html'); 
        }
        else
        {
            $this->view->canonicalURL = helper::createLink('product', 'browse', "categoryID=$categoryID&pageID=$pageID", "category={$category->alias}", 'mhtml'); 
        }
        $this->display();
    }

    /**
     * Browse product in admin.
     * 
     * @param int    $categoryID  the category id
     * @param string $orderBy     the order by
     * @param int    $recTotal 
     * @param int    $recPerPage 
     * @param int    $pageID 
     * @access public
     * @return void
     */
    public function admin($categoryID = '', $orderBy = 'order_desc', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {   
        /* Set the session. */
        $this->session->set('productList', $this->app->getURI(true));

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
        
        $families = '';
        if($categoryID) $families = $this->loadModel('tree')->getFamily($categoryID, 'product');
        $products = $this->product->getList($families, $orderBy, $pager);
        
        $this->loadModel('block');

        $this->view->title      = $this->lang->product->common;
        $this->view->products   = $products;
        $this->view->pager      = $pager;
        $this->view->categoryID = $categoryID;
        $this->view->orderBy    = $orderBy;
        $this->view->template   = $this->config->template->{$this->app->clientDevice}->name;
        $this->display();
    }   

    /**
     * Create a product.
     * 
     * @param int    $categoryID  
     * @access public
     * @return void
     */
    public function create($categoryID = '')
    {
        $categories = $this->loadModel('tree')->getOptionMenu('product', 0, $removeRoot = true);
        if(empty($categories))
        {
            $this->view->reason = $this->lang->product->noCategoriesTip;
            $this->view->locate = helper::createLink('tree', 'browse', "type=product");
            $this->display('common', 'redirect');
            die();
        }

        if($_POST)
        {
            $productID = $this->product->create();       
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::getError()));

            $currentCategoryID = current($this->post->categories);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate'=>inlink('admin', "categoryID=$currentCategoryID")));
        }

        $maxID = $this->dao->select('max(id) as maxID')->from(TABLE_PRODUCT)->fetch('maxID');

        if($categoryID) $this->view->currentCategory = $this->tree->getByID($categoryID, 'product');

        $this->view->title      = $this->lang->product->create;
        $this->view->categoryID = $categoryID;
        $this->view->categories = $categories;
        $this->view->order      = $maxID + 1;
        $this->display();
    }

    /**
     * Edit a product.
     * 
     * @param  int $productID 
     * @access public
     * @return void
     */
    public function edit($productID)
    {
        $categories = $this->loadModel('tree')->getOptionMenu('product', 0, $removeRoot = true);
        if(empty($categories))
        {
            die(js::alert($this->lang->tree->noCategories) . js::locate($this->createLink('tree', 'browse', 'type=product')));
        }

        if($_POST)
        {
            $this->product->update($productID);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
        }

        $product = $this->product->getByID($productID);

        if(empty($product->attributes))
        {
            $attribute = new stdclass();
            $attribute->order = 0;
            $attribute->label = '';
            $attribute->value = '';

            $product->attributes = array($attribute);
        }

        $this->view->title      = $this->lang->product->edit;
        $this->view->product    = $product;
        $this->view->categories = $categories;

        $this->display();
    }

    /**
     * Change status 
     * 
     * @param  int    $productID 
     * @param  string $status 
     * @access public
     * @return void
     */
    public function changeStatus($productID, $status)
    {
        $this->dao->update(TABLE_PRODUCT)->set('status')->eq($status)->where('id')->eq($productID)->exec();

        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success', 'locate' => $this->server->http_referer));
    }

    /**
     * View a product.
     * 
     * @param int $productID 
     * @access public
     * @return void
     */
    public function view($productID)
    {
        $product = $this->product->getByID($productID);
        if(!$product) die($this->fetch('errors', 'index'));

        /* fetch first category for display. */
        $category = array_slice($product->categories, 0, 1);
        $category = $category[0]->id;

        $currentCategory = $this->session->productCategory;
        if($currentCategory > 0)
        {
            if(isset($product->categories[$currentCategory]))
            {
                $category = $currentCategory;  
            }
            else
            {
                foreach($product->categories as $productCategory)
                {
                    if(strpos($productCategory->path, $currentCategory)) $category = $productCategory->id;
                }
            }
        }
        $category = $this->loadModel('tree')->getByID($category, 'product');

        $this->view->title       = $product->name . ' - ' . $category->name;
        $this->view->mobileTitle = $this->lang->product->view;
        $this->view->keywords    = trim(trim($product->keywords . ' - ' . $category->keywords), '-');
        $this->view->desc        = strip_tags($product->desc);
        $this->view->product     = $product;
        $this->view->prevAndNext = $this->product->getPrevAndNext($product->order, $category->id);
        $this->view->category    = $category;
        $this->view->contact     = $this->loadModel('company')->getContact();
        $this->view->stockOpened = isset($this->config->product->stock) && $this->config->product->stock == 1;
        $this->view->mobileURL   = helper::createLink('product', 'view', "productID=$productID", "category=$category->alias&name=$product->alias", 'mhtml');
        $this->view->desktopURL  = helper::createLink('product', 'view', "productID=$productID", "category=$category->alias&name=$product->alias", 'html');
        $this->view->layouts     = $this->loadModel('block')->getPageBlocks('product', 'view', $product->id);
        $this->view->sideGrid    = $this->loadModel('ui')->getThemeSetting('sideGrid', 3);
        $this->view->sideFloat   = $this->ui->getThemeSetting('sideFloat', 'right');
        
        if($this->app->clientDevice == 'desktop') 
        {
            $this->view->canonicalURL = helper::createLink('product', 'view', "productID=$productID", "category={$category->alias}&name={$product->alias}", 'html'); 
        }
        else
        {
            $this->view->canonicalURL = helper::createLink('product', 'view', "productID=$productID", "category={$category->alias}&name={$product->alias}", 'mhtml'); 
        }

        $this->display();
    }

    /**
     * Delete a product.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function delete($productID)
    {
        if($this->product->delete($productID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Set css.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function setCss($productID)
    {
        if($_POST)
        {
            if($this->product->setCss($productID)) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title   = $this->lang->product->css;
        $this->view->product = $this->product->getByID($productID);
        $this->display();
    }


    /**
     * Set js.
     * 
     * @param  int      $productID 
     * @access public
     * @return void
     */
    public function setJs($productID)
    {
        if($_POST)
        {
            if($this->product->setJs($productID)) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title   = $this->lang->product->js;
        $this->view->product = $this->product->getByID($productID);
        $this->display();
    }

    /**
     * Redirect mall of product.
     * 
     * @param  int    $productID 
     * @access public
     * @return void
     */
    public function redirect($productID)
    {
        $product = $this->product->getByID($productID);
        helper::header301(htmlspecialchars_decode($product->mall, ENT_QUOTES));
    }

    /**
     * Set currency and stock.
     * 
     * @access public
     * @return void
     */
    public function setting()
    {
        $this->lang->menuGroups->product = 'orderSetting';
        if(commonModel::isAvailable('shop')) $this->app->loadLang('order');
        if($_POST)
        {
            $result = $this->product->saveSetting();
            if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            if(commonModel::isAvailable('shop'))   $this->send($this->loadModel('order')->saveSetting());
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }

        $this->view->title = $this->lang->product->setting;
        $this->display();
    }
}
