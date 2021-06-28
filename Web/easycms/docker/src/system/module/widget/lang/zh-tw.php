<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The zh-tw file of widget module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     widget 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->widget->common = '區塊';
$lang->widget->title  = '區塊名稱';
$lang->widget->style  = '外觀';
$lang->widget->type   = '類型';
$lang->widget->grid   = '寬度';
$lang->widget->color  = '顏色';
$lang->widget->status = '狀態';

$lang->widget->message = '留言';
$lang->widget->comment = '評論';
$lang->widget->reply   = '回覆';

$lang->widget->create    = '創建區塊';
$lang->widget->hidden    = '隱藏';
$lang->widget->lblWidget = '區塊';
$lang->widget->lblRss    = 'RSS地址';
$lang->widget->lblNum    = '條數';
$lang->widget->content   = '內容';

$lang->widget->params = new stdclass();
$lang->widget->params->name  = '參數名稱';
$lang->widget->params->value = '參數值';

$lang->widget->createWidget        = '添加區塊';
$lang->widget->editWidget          = '編輯區塊';
$lang->widget->ordersSaved         = '排序已保存';
$lang->widget->confirmRemoveWidget = '確定移除區塊【{0}】嗎？';

$lang->widget->dynamic     = '最新動態';
$lang->widget->dynamicInfo = "%s, %s <em>%s</em> %s <a href='%s'>%s</a>。";

$lang->widget->default = array();
$lang->widget->default['1']['title'] = '最新訂單';
$lang->widget->default['1']['type']  = 'latestOrder';
$lang->widget->default['1']['grid']  = 4;

$lang->widget->default['2']['title'] = '最新帖子';
$lang->widget->default['2']['type']  = 'latestThread';
$lang->widget->default['2']['grid']  = 4;

$lang->widget->default['3']['title'] = '反饋';
$lang->widget->default['3']['type']  = 'message';
$lang->widget->default['3']['grid']  = 4;

$lang->widget->default['4']['title'] = '最新投稿';
$lang->widget->default['4']['type']  = 'submission';
$lang->widget->default['4']['grid']  = 4;

$lang->widget->default['5']['title'] = '快捷入口';
$lang->widget->default['5']['type']  = 'commonMenu';
$lang->widget->default['5']['grid']  = 4;

$lang->widget->default['6']['title'] = '蟬知動態';
$lang->widget->default['6']['type']  = 'chanzhiDynamic';
$lang->widget->default['6']['grid']  = 4;

$lang->widget->typeList = new stdclass();
$lang->widget->typeList->latestOrder    = '最新訂單';
$lang->widget->typeList->latestThread   = '最新帖子';
$lang->widget->typeList->message        = '反饋';
$lang->widget->typeList->wechatMessage  = '微信留言';
$lang->widget->typeList->submission     = '最新投稿';
$lang->widget->typeList->chanzhiDynamic = '蟬知動態';
$lang->widget->typeList->commonMenu     = '快捷入口';
$lang->widget->typeList->html           = '自定義';
