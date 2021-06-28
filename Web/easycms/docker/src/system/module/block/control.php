<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class block extends control
{
    /**
     * Browse blocks admin.
     * 
     * @access public
     * @return void
     */
    public function admin()
    {
        $template = $this->config->template->{$this->app->clientDevice}->name;
        $this->block->loadTemplateLang($template);

        $this->session->set('blockList', $this->app->getURI());

        $this->view->template = $template;
        $this->view->blocks   = $this->block->getList($template);
        $this->view->title    = $this->lang->block->common;
        $this->display();
    }

    /**
     * Pages admin list.
     * 
     * @access public
     * @return void
     */
    public function pages()
    {
        $template = $this->config->template->{$this->app->clientDevice}->name;
        $theme    = $this->config->template->{$this->app->clientDevice}->theme;
        $this->block->loadTemplateLang($template);

        $this->lang->menuGroups->block = 'ui';

        $this->view->title    = $this->lang->block->pages;
        $this->view->template = $template;
        $this->view->uiHeader = true;
        $this->display();       
    }

    /**
     * Create a block.
     * 
     * @param  string $type    html|php
     * @access public
     * @return void
     */
    public function create($type = 'html')
    {
        $template = $this->config->template->{$this->app->clientDevice}->name;
        $theme    = $this->config->template->{$this->app->clientDevice}->theme;
        $this->block->loadTemplateLang($template);

        if($_POST)
        {
            if($type == 'phpcode' and !$this->loadModel('guarder')->verify()) $this->send(array('result' => 'fail', 'reason' => 'captcha', 'message' => dao::getError()));

            $blockID = $this->block->create($template, $theme);
            if(!dao::isError()) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->inlink('admin'), 'blockID' => $blockID));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title    = $this->lang->block->create;
        $this->view->type     = $type;
        $this->view->template = $template;
        $this->view->theme    = $theme;
        $this->display();
    }

    /**
     * Edit a block.
     * 
     * @param int      $blockID 
     * @param string   $type 
     * @access public
     * @return void
     */
    public function edit($blockID, $type = '')
    {
        $template = $this->config->template->{$this->app->clientDevice}->name;
        $theme    = $this->config->template->{$this->app->clientDevice}->theme;
        $this->block->loadTemplateLang($template);
        $this->app->loadLang('ui');

        if(!$blockID) $this->locate($this->inlink('admin'));

        if($_POST)
        {
            if($this->post->type == 'phpcode' and !$this->loadModel('guarder')->verify()) $this->send(array('result' => 'fail', 'reason' => 'captcha', 'message' => dao::getError()));

            $this->block->update($template, $theme);
            if(!dao::isError()) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title      = $this->lang->block->edit;
        $this->view->template   = $template;
        $this->view->theme      = $theme;
        $this->view->modalWidth = 1100;
        $this->view->block      = $this->block->getByID($blockID);
        $this->view->type       = $this->get->type ? $this->get->type : $this->view->block->type;
        $this->display();
    }

    /**
     * Set the layouts of one region.
     * 
     * @param string   $page 
     * @param string   $region 
     * @access public
     * @return void
     */
    public function setRegion($page, $region, $object = '')
    {
        $template = $this->config->template->{$this->app->clientDevice}->name;
        $theme    = $this->config->template->{$this->app->clientDevice}->theme;
        $this->block->loadTemplateLang($template);

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $result = $this->block->setRegion($page, $region, $object, $template, $theme);

            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate' => $this->server->http_referer));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $blocks = $this->block->getRegionBlocks($page, $region, $object, $template, $theme);
        if(empty($blocks)) $blocks = array(new stdclass());

        $this->view->title        = "<i class='icon-cog'></i> " . $this->lang->block->setPage . ' - '. $this->lang->block->{$template}->pages[$page] . ' - ' . $this->lang->block->$template->regions->{$page}[$region];
        $this->view->modalWidth   = 1100;
        $this->view->page         = $page;
        $this->view->region       = $region;
        $this->view->object       = $object;
        $this->view->blocks       = $blocks;
        $this->view->blockOptions = $this->block->getPairs($template);
        $this->view->template     = $template; 

        $this->display();
    }

    /**
     * Reset region.
     * 
     * @param  string $page 
     * @param  string $object 
     * @access public
     * @return void
     */
    public function resetRegion($page, $object = '')
    {
        $template = $this->config->template->{$this->app->clientDevice}->name;
        $this->dao->delete()->from(TABLE_LAYOUT)
            ->where('page')->eq($page)
            ->andWhere('object')->eq($object)
            ->andWhere('template')->eq($template)
            ->exec();

        if(!dao::isError()) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Delete a block from page region.
     * 
     * @param string $blockID 
     * @access public
     * @return void
     */
    public function delete($blockID)
    {
        $result = $this->block->delete($blockID);

        if($result)  $this->send(array('result' => 'success'));
        if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Show block form.
     * 
     * @param  string  $type 
     * @param  int     $id 
     * @access public
     * @return void
     */
    public function blockForm($type, $id = 0)
    {
        if($id > 0)
        {
            $block = $this->block->getByID($id); 
            $this->view->block = $block;
        }

        $this->view->type = $type;
        $this->display();
    }

    /**
     * Set page columns
     * 
     * @param string $page    like 'article_browse'
     * @access public
     * @return void
     */
    public function setColumns($page, $object = '')
    {
        $theme    = $this->config->template->{$this->app->clientDevice}->theme;
        $template = $this->config->template->{$this->app->clientDevice}->name;
        $params = $this->loadModel('ui')->getCustomParams($template, $theme);

        if($_POST)
        {
            $params['sideGrid']  = $this->post->sideGrid;
            $params['sideFloat'] = $this->post->sideFloat;
            $setting = isset($this->config->template->custom) ? json_decode($this->config->template->custom, true): array();
            $setting[$template][$theme] = $params;

            $result = $this->loadModel('setting')->setItems('system.common.template', array('custom' => helper::jsonEncode($setting)));
            $this->loadModel('setting')->setItems('system.common.template', array('customVersion' => time()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
        }

        $this->view->sideGrid   = $this->ui->getThemeSetting('sideGrid');
        $this->view->sideFloat  = $this->ui->getThemeSetting('sideFloat');
        $this->display();
    }
}
