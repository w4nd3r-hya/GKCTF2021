<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The zh-cn file of widget module of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     widget 
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
$lang->widget->common = '区块';
$lang->widget->title  = '区块名称';
$lang->widget->style  = '外观';
$lang->widget->type   = '类型';
$lang->widget->grid   = '宽度';
$lang->widget->color  = '颜色';
$lang->widget->status = '状态';

$lang->widget->message = '留言';
$lang->widget->comment = '评论';
$lang->widget->reply   = '回复';

$lang->widget->create    = '创建区块';
$lang->widget->hidden    = '隐藏';
$lang->widget->lblWidget = '区块';
$lang->widget->lblRss    = 'RSS地址';
$lang->widget->lblNum    = '条数';
$lang->widget->content   = '内容';

$lang->widget->params = new stdclass();
$lang->widget->params->name  = '参数名称';
$lang->widget->params->value = '参数值';

$lang->widget->createWidget        = '添加区块';
$lang->widget->editWidget          = '编辑区块';
$lang->widget->ordersSaved         = '排序已保存';
$lang->widget->confirmRemoveWidget = '确定移除区块【{0}】吗？';

$lang->widget->dynamic     = '最新动态';
$lang->widget->dynamicInfo = "%s, %s <em>%s</em> %s <a href='%s'>%s</a>。";

$lang->widget->default = array();
$lang->widget->default['1']['title'] = '最新订单';
$lang->widget->default['1']['type']  = 'latestOrder';
$lang->widget->default['1']['grid']  = 4;

$lang->widget->default['2']['title'] = '最新帖子';
$lang->widget->default['2']['type']  = 'latestThread';
$lang->widget->default['2']['grid']  = 4;

$lang->widget->default['3']['title'] = '反馈';
$lang->widget->default['3']['type']  = 'message';
$lang->widget->default['3']['grid']  = 4;

$lang->widget->default['4']['title'] = '最新投稿';
$lang->widget->default['4']['type']  = 'submission';
$lang->widget->default['4']['grid']  = 4;

$lang->widget->default['5']['title'] = '快捷入口';
$lang->widget->default['5']['type']  = 'commonMenu';
$lang->widget->default['5']['grid']  = 4;

$lang->widget->default['6']['title'] = '蝉知动态';
$lang->widget->default['6']['type']  = 'chanzhiDynamic';
$lang->widget->default['6']['grid']  = 4;

$lang->widget->typeList = new stdclass();
$lang->widget->typeList->latestOrder    = '最新订单';
$lang->widget->typeList->latestThread   = '最新帖子';
$lang->widget->typeList->message        = '反馈';
$lang->widget->typeList->wechatMessage  = '微信留言';
$lang->widget->typeList->submission     = '最新投稿';
$lang->widget->typeList->chanzhiDynamic = '蝉知动态';
$lang->widget->typeList->commonMenu     = '快捷入口';
$lang->widget->typeList->html           = '自定义';
