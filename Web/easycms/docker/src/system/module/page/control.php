<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of page module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     page
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class page extends control
{
    /**
     * The index page.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $pages = $this->loadModel('article')->getList('page', 0, $orderBy = 'editedDate DESC');
        $title = $this->lang->page->list;
        
        $this->view->title = $title;
        $this->view->pages = $pages;
        $this->view->mobileURL  = helper::createLink('page', 'index', '', '', 'mhtml');
        $this->view->desktopURL = helper::createLink('page', 'index', '', '', 'html');

        $this->display();
    }

    /**
     * View an page.
     * 
     * @param  int      $pageID 
     * @access public
     * @return void
     */
    public function view($pageID)
    {
        $pageID = urldecode($pageID);
        $page   = $this->loadModel('article')->getPageByID($pageID);
        if(!$page) die($this->fetch('errors', 'index'));

        if($page->link) helper::header301($page->link);

        $this->view->title      = $page->title;
        $this->view->keywords   = trim($page->keywords);
        $this->view->desc       = $page->summary;
        $this->view->page       = $page;
        $this->view->mobileURL  = helper::createLink('page', 'view', "pageID=$pageID", "name=$page->alias", 'mhtml');
        $this->view->desktopURL = helper::createLink('page', 'view', "pageID=$pageID", "name=$page->alias", 'html');
        $this->view->layouts    = $this->loadModel('block')->getPageBlocks('page', 'view', $page->id);
        $this->view->sideGrid   = $this->loadModel('ui')->getThemeSetting('sideGrid', 3);
        $this->view->sideFloat  = $this->ui->getThemeSetting('sideFloat', 'right');

        if($this->app->clientDevice == 'desktop') 
        {
            $this->view->canonicalURL = helper::createLink('page', 'view', "pageID=$pageID", "name={$page->alias}", 'html'); 
        }
        else
        {
            $this->view->canonicalURL = helper::createLink('page', 'view', "pageID=$pageID", "name=$page->alias", 'mhtml'); 
        }
        $this->display();
    }
}
