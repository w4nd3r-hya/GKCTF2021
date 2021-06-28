<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of widget module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     widget
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class widget extends control
{
    /**
     * Create a widget.
     * 
     * @param  string $type 
     * @access public
     * @return void
     */
    public function create($type = '')
    {
        if($_POST)
        {
            $this->widget->create($type);
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::geterror()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('admin', 'index')));
        }

        $this->view->title = $this->lang->widget->create;
        $this->view->type  = $type;
        $this->view->modalWidth  = '700';
        $this->display();
    }

    /**
     * edit a widget. 
     * 
     * @param  int    $id 
     * @access public
     * @return void
     */
    public function edit($id, $type = '')
    {
        if($_POST)
        {
            $this->widget->update($id);
            if(dao::isError())  $this->send(array('result' => 'fail', 'message' => dao::geterror()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->createLink('admin', 'index')));
        }

        $widget = $this->widget->getByID($id);
        $hiddenWidgets = $this->widget->getHiddenWidgets();

        if($type) $widget->type = $type;
        $this->view->widget     = $widget;
        $this->view->title      = $this->lang->widget->editWidget;
        $this->view->type       = $widget->type;
        $this->view->modalWidth = 700;
        $this->display();
    }

    /**
     * Print widget. 
     *
     * @param  int    $widget 
     * @access public
     * @return void
     */
    public function printWidget($widget)
    {
        $widget = $this->widget->getByID($widget);
        if(empty($widget)) return false;

        if($widget->type == 'commonMenu') $this->view->articleCategories = $this->loadModel('tree')->getOptionMenu('article', 0, $removeRoot = true); 
        $this->app->loadClass('pager', true);
        $this->view->widget = $widget;       
        $this->display();
    }

    /**
     * Sort block.
     * 
     * @param  string    $oldOrder 
     * @param  string    $newOrder 
     * @param  string    $module 
     * @access public
     * @return void
     */
    public function sort($orders, $app = 'sys')
    {
        $orders    = explode(',', $orders);
        $blockList = $this->widget->getWidgetList($app);
        
        foreach ($orders as $order => $blockID)
        {
            $block = $blockList[$blockID];
            if(!isset($block)) continue;
            $block->order = $order + 1;
            $this->dao->replace(TABLE_WIDGET)->data($block)->exec();
        }

        if(dao::isError()) $this->send(array('result' => 'fail'));
        $this->send(array('result' => 'success'));
    }

    /**
     * Resize block
     * @param  integer $id
     * @access public
     * @return void
     */
    public function resize($id, $grid = 4)
    {
        $block = $this->widget->getByID($id);
        if($block)
        {
            $block->params = helper::jsonEncode($block->params);
            $block->grid   = $grid;
            $this->dao->replace(TABLE_WIDGET)->data($block)->exec();
            if(dao::isError()) $this->send(array('result' => 'fail'));
            $this->send(array('result' => 'success'));
        }
        else
        {
            $this->send(array('result' => 'fail'));
        }
    }

    /**
     * Delete widget 
     * 
     * @param  int    $index 
     * @param  string $sys 
     * @param  string $type 
     * @access public
     * @return void
     */
    public function delete($id)
    {
        $this->dao->delete()->from(TABLE_WIDGET)->where('`id`')->eq($id)->andWhere('account')->eq($this->app->user->account)->exec();
        if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success', 'locate' => helper::createLink('admin')));
    }
}
