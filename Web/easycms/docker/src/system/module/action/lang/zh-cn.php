<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The action zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     action
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->action->common = '系统日志';

$lang->action->objectType = '对象类型';
$lang->action->objectID   = '对象ID';
$lang->action->objectName = '对象名称';
$lang->action->actor      = '操作者';
$lang->action->action     = '动作';
$lang->action->date       = '日期';

$lang->action->objectTypes['order'] = '订单';

$lang->action->desc = new stdclass();
$lang->action->desc->common            = '$date, <strong>$action</strong> by <strong>$actor</strong>' . "\n";
$lang->action->desc->created           = '$date, 由 <strong>$actor</strong> 创建。' . "\n";
$lang->action->desc->paid              = '$date, 由 <strong>$actor</strong> 付款。' . "\n";
$lang->action->desc->savedpayment      = '$date, 由 <strong>$actor</strong> 收款，收款金额: <strong>$extra</strong>。' . "\n";
$lang->action->desc->applyrefunded     = '$date, 由 <strong>$actor</strong> 申请退款。' . "\n";
$lang->action->desc->refunded          = '$date, 由 <strong>$actor</strong> 退款$extra。' . "\n";
$lang->action->desc->deliveried        = '$date, 由 <strong>$actor</strong> 发货。' . "\n";
$lang->action->desc->confirmedDelivery = '$date, 由 <strong>$actor</strong> 确认收货。' . "\n";
$lang->action->desc->edited            = '$date, 由 <strong>$actor</strong> 编辑。' . "\n";
$lang->action->desc->finished          = '$date, 由 <strong>$actor</strong> 完成。' . "\n";
$lang->action->desc->canceled          = '$date, 由 <strong>$actor</strong> 取消。' . "\n";
$lang->action->desc->deleted           = '$date, 由 <strong>$actor</strong> 删除。' . "\n";
$lang->action->desc->diff1             = '修改了 <strong><i>%s</i></strong>，旧值为 "%s"，新值为 "%s"。<br />' . "\n";
$lang->action->desc->diff2             = '修改了 <strong><i>%s</i></strong>，区别为：' . "\n" . "<blockquote>%s</blockquote>" . "\n<div class='hidden'>%s</div>";
$lang->action->desc->diff3             = "将文件名 %s 改为 %s 。\n";

/* 用来显示动态信息。*/
$lang->action->label = new stdclass();
$lang->action->label->created           = '创建了';
$lang->action->label->paid              = '付款';
$lang->action->label->savedpayment      = '收款';
$lang->action->label->applyRefunded     = '申请退款';
$lang->action->label->refunded          = '退款';
$lang->action->label->deliveried        = '发货';
$lang->action->label->confirmedDelivery = '确认收货';
$lang->action->label->edited            = '编辑了';
$lang->action->label->finished          = '完成了';
$lang->action->label->canceled          = '取消了';
$lang->action->label->deleted           = '删除了';
$lang->action->label->space             = '　';
