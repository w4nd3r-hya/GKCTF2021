<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of action module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     action 
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class action extends control
{
    /**
     * browse history actions and records. 
     * 
     * @param  string    $objectType
     * @param  int       $objectID 
     * @param  string    $action
     * @param  string    $from
     * @access public
     * @return void
     */
    public function history($objectType, $objectID, $action = '', $from = 'view')
    {
        $this->view->actions    = $this->action->getList($objectType, $objectID, $action);
        $this->view->objectType = $objectType;
        $this->view->objectID   = $objectID;
        $this->view->users      = $this->loadModel('user')->getPairs();
        $this->view->from       = $from;
        $this->view->behavior   = $action;
        $this->display();
    }

    /**
     * Edit comment of an action.
     * 
     * @param  int    $actionID 
     * @access public
     * @return void
     */
    public function editComment($actionID)
    {
        if(!strip_tags($this->post->lastComment)) $this->send(array('result' => 'success', 'locate' => $this->server->http_referer));
        $this->action->updateComment($actionID);
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => $this->server->http_referer));
    }
}
