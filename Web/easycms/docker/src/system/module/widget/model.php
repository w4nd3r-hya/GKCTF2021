<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of widget module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     widget
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
class widgetModel extends model
{
    /**
     * Create a new widget.
     * 
     * @param  string    $type 
     * @access public
     * @return void
     */
    public function create($type)
    {
        $order = $this->getLastKey() + 1;
        $data = fixer::input('post')
            ->add('account', $this->app->user->account)
            ->add('hidden', 0)
            ->add('type', $type)
            ->add('order', $order)
            ->setDefault('grid', '4')
            ->setDefault('params', array())
            ->get();
 
        if($type == 'html')
        {
            $data->params['html'] = $data->html;
            unset($data->html);
        }

        $data->params = helper::jsonEncode($data->params);

        $this->dao->replace(TABLE_WIDGET)
            ->data($data, 'uid')
            ->batchCheck($this->config->widget->require->create, 'notempty')
            ->exec();
    }
      
    /**
     * Update a widget.
     * 
     * @param  int    $id 
     * @access public
     * @return void
     */
    public function update($id)
    {
        $data = fixer::input('post')
            ->add('account', $this->app->user->account)
            ->add('hidden', 0)
            ->add('id', $id)
            ->setDefault('grid', '4')
            ->setDefault('params', array())
            ->get();

        if($type == 'html')
        {
            $data->params['html'] = $data->html;
            unset($data->html);
        }

        $data->params = helper::jsonEncode($data->params);

        $this->dao->replace(TABLE_WIDGET)->data($data, 'uid')->exec();
    }

    /**
     * Get content when type is rss 
     * 
     * @param  object    $widget 
     * @access public
     * @return string
     */
    public function getRss($widget)
    {
        if(empty($widget)) return false;
        $http = $this->app->loadClass('http');

        $xml = $http->get(htmlspecialchars_decode($widget->params->link, ENT_QUOTES));

        $xpc = xml_parser_create();
        xml_parse_into_struct($xpc, $xml, $values);
        xml_parser_free($xpc);

        $channelTags = array();
        $itemTags    = array();
        $inItem      = false;
        foreach($values as $value)
        {
            $tag = strtolower($value['tag']);
            if($value['tag'] == 'ITEM' and $value['type'] == 'open')  $inItem = true;
            if($value['tag'] == 'ITEM' and $value['type'] == 'close') $inItem = false;

            /* The level of text node is 3 in channel. */
            if(!$inItem and $value['type'] == 'complete' and $value['level'] == 3) $channelTags[$tag] = isset($value['value']) ? $value['value'] : '';
            /* The level of text node is 4 in item. */
            if($inItem  and $value['type'] == 'complete' and $value['level'] == 4) $itemTags[$tag][]  = isset($value['value']) ? $value['value'] : '';
        }

        $maxNum = $widget->params->num == 0 ? count(current($itemTags)) : $widget->params->num;
        $html   = "<div class='list-group'>";
        for($i = 0; $i < $maxNum; $i++)
        {
            $title = '';
            foreach(array_keys($itemTags) as $tag)
            {
                if($tag == 'title')
                {
                    $title = $itemTags[$tag][$i];
                }
                elseif($tag == 'pubdate')
                {
                    $time = date('n-j H:s',strtotime($itemTags[$tag][$i]));
                    $html .= "<a class='list-group-item' target='_blank' href='{$itemTags['link'][$i]}'><small class='text-muted pull-right'>{$time}</small><h5 class='list-group-item-heading small text-ellipsis'>{$title}</h5></a>";
                }
            }
        }

        return $html . '</div>';
    }

    /**
     * Get widget by ID.
     * 
     * @param  int    $widgetID 
     * @access public
     * @return object
     */
    public function getByID($widgetID)
    {
        $widget = $this->dao->select('*')->from(TABLE_WIDGET)
            ->where('id')->eq($widgetID)
            ->fetch();
        if(empty($widget)) return false;

        $widget->params = json_decode($widget->params);
        if(empty($widget->params)) $widget->params = new stdclass();
        return $widget;
    }

    /**
     * Get last key.
     * 
     * @access public
     * @return int
     */
    public function getLastKey()
    {
        $index = $this->dao->select('`order`')->from(TABLE_WIDGET)
            ->where('account')->eq($this->app->user->account)
            ->orderBy('`order` desc')
            ->limit(1)
            ->fetch('order');
        return $index ? $index : 0;
    }

    /**
     * Get widget list for account.
     * 
     * @access public
     * @return void
     */
    public function getWidgetList()
    {
        return $this->dao->select('*')->from(TABLE_WIDGET)->where('account')->eq($this->app->user->account)
            ->andWhere('hidden')->eq(0)
            ->orderBy('`order`')
            ->fetchAll('order');
    }

    /**
     * Get hidden widgets
     * 
     * @access public
     * @return array
     */
    public function getHiddenWidgets()
    {
        return $this->dao->select('*')->from(TABLE_WIDGET)->where('account')->eq($this->app->user->account)
            ->andWhere('hidden')->eq(1)
            ->orderBy('`order`')
            ->fetchAll('order');
    }

    /**
     * Init widget when account use first. 
     * 
     * @access public
     * @return bool
     */
    public function initWidget()
    {
        $widgets = $this->lang->widget->default;
        $account = $this->app->user->account;

        /* Mark this app has init. */
        $this->loadModel('setting')->setItem("$account.common.site.widgetInited", true);
        foreach($widgets as $index => $widget)
        {
            $widget['order']   = $index;
            $widget['account'] = $account;
            $widget['params']  = isset($widget['params']) ? helper::jsonEncode($widget['params']) : '';

            $this->dao->replace(TABLE_WIDGET)->data($widget)->exec();
        }

        return !dao::isError();
    }
}
