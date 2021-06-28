<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of address of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     address 
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class address extends control
{
    /**
     * Browse products in my address.
     * 
     * @access public
     * @return void
     */
    public function browse()
    {
        $this->app->loadLang('user');
        $this->view->title       = $this->lang->address->browse;
        $this->view->mobileTitle = $this->lang->address->browse;
        $this->view->addresses   = $this->address->getListByAccount($this->app->user->account);
        $this->view->mobileURL   = helper::createLink('address', 'browse', '', '', 'mhtml');
        $this->view->desktopURL  = helper::createLink('address', 'browse', '', '', 'html');
        $this->display();
    }

    /**
     * Browse products in order confirm.
     * 
     * @access public
     * @return void
     */
    public function addressList()
    {
        $this->app->loadLang('user');
        $this->view->title      = $this->lang->address->browse;
        $this->view->addresses  = $this->address->getListByAccount($this->app->user->account);
        $this->view->mobileURL  = helper::createLink('address', 'addresslist', '', '', 'mhtml');
        $this->view->desktopURL = helper::createLink('address', 'addresslist', '', '', 'html');
        $this->display();
    }

    /**
     * Create an address.
     * 
     * @access public
     * @return void
     */
    public function create()
    {
        if($_POST)
        {
            $result = $this->address->create();
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->display();
    }

    /**
     * Edit an address.
     * 
     * @param  int    $id 
     * @access public
     * @return void
     */
    public function edit($id)
    {
        $address = $this->address->getByID($id);
        if(!$address or $address->account != $this->app->user->account) die();

        if($_POST)
        {
            $result = $this->address->update($id);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('browse')));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }
        $this->view->address = $address;
        $this->display();
    }

    /**
     * Delete address.
     * 
     * @param  string    $ids
     * @access public
     * @return void
     */
    public function delete($ids)
    {
        if(empty($ids)) $this->send(array('result' => 'fail', 'message' => $this->lang->address->deleteEmptyIDs));

        $this->dao->delete()->from(TABLE_ADDRESS)->where('id')->in($ids)->andWhere('account')->eq($this->app->user->account)->exec();
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success', 'message' => $this->lang->deleteSuccess, 'locate' => inlink('browse')));
    }
}
