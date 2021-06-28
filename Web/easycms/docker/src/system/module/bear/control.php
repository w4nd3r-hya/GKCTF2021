<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of bear of ChanzhiEPS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     bear
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class bear extends control
{
    /**
     * bear setting function.
     * 
     * @access public
     * @return void
     */
    public function setting()
    {
        if($_POST)
        {
            $result = $this->bear->saveSetting();
            $this->send($result);
        }

        $this->view->title = $this->lang->bear->setting;
        $this->view->bear  = $this->config->bear;
        $this->display();
    }

    /**
     * Submit an object.
     * 
     * @param  string    $objectType 
     * @param  int       $objectID 
     * @access public
     * @return void
     */
    public function submit($objectType, $objectID)
    {
        if($_POST)
        {
            $result = $this->bear->submit($objectType, $objectID, $this->post->type, 'no');
            if($result->success) $this->send(array('result' => 'success', 'message' => $this->lang->bear->submitSuccess, 'locate' => $this->server->http_referer));
            $error = $this->lang->bear->submitFail;
            if(isset($result->not_same_site) and !empty($result->not_same_site)) $error .= $lang->clone . sprintf($this->lang->bear->notices['not_same_site'], join(',', $result->not_same_site)); 
            if(isset($result->not_valid) and !empty($result->not_same_site)) $error .= $lang->clone . $this->lang->bear->notices['not_valid']; 
            $this->send(array('result' => 'fail', 'message' => $error));
        }

        $this->view->title = $this->lang->bear->submit;
        $this->view->objectType = $objectType;
        $this->view->objectID   = $objectID;
        $this->display();
    }

    /**
     * Batch history content.
     * 
     * @param  string   $type 
     * @param  int      $lastID 
     * @access public
     * @return void
     */
    public function batchSubmit($type = 'article', $lastID = '')
    {
        if(helper::isAjaxRequest())
        {
            $result = $this->bear->batchSubmit($type, $lastID);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->bear->submitFail));
            if(isset($result['finished']) and $result['finished'])
            {
                $this->send(array('result' => 'finished', 'message' => $this->lang->bear->submitSuccess));
            }
            else
            {
                $this->send(array('result' => 'unfinished', 'message' => sprintf($this->lang->bear->submitResult, $result['count']),'next' => inlink('batchSubmit', "type={$result['type']}&lastID={$result['lastID']}") ));
            }
        }

        $this->view->title = $this->lang->bear->submit;
        $this->display();
    }

    /**
     * log page.
     * 
     * @param  string $mode 
     * @param  string $orderBy 
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @param  string $begin 
     * @param  string $end 
     * @access public
     * @return void
     */
    public function log($mode = '', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 20, $pageID = 1, $begin = '', $end = '')
    {
        if(!$mode) $mode = date("H") < 10 ? 'yesterday' : 'today';
        $begin = $this->get->begin;
        $end   = $this->get->end;
        $date  = $this->loadModel('stat')->parseDate($mode, $begin, $end);
        $begin = date('Y-m-d', strtotime($date->begin));
        $end   = date('Y-m-d', strtotime($date->end));

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);
    
        $this->view->title   = $this->lang->bear->log;
        $this->view->records = $this->bear->getLogs($begin, $end, $orderBy, $pager);
        $this->view->mode    = $mode;
        $this->view->begin   = $begin;
        $this->view->pager   = $pager;
        $this->view->orderBy = $orderBy;
        $this->view->end     = $end;
        $this->display();
    }
}
