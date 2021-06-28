<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The action zh-tw file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     action
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->action->common = '系統日誌';

$lang->action->objectType = '對象類型';
$lang->action->objectID   = '對象ID';
$lang->action->objectName = '對象名稱';
$lang->action->actor      = '操作者';
$lang->action->action     = '動作';
$lang->action->date       = '日期';

$lang->action->objectTypes['order'] = '訂單';

$lang->action->desc = new stdclass();
$lang->action->desc->common            = '$date, <strong>$action</strong> by <strong>$actor</strong>' . "\n";
$lang->action->desc->created           = '$date, 由 <strong>$actor</strong> 創建。' . "\n";
$lang->action->desc->paid              = '$date, 由 <strong>$actor</strong> 付款。' . "\n";
$lang->action->desc->savedpayment      = '$date, 由 <strong>$actor</strong> 收款，收款金額: <strong>$extra</strong>。' . "\n";
$lang->action->desc->applyrefunded     = '$date, 由 <strong>$actor</strong> 申請退款。' . "\n";
$lang->action->desc->refunded          = '$date, 由 <strong>$actor</strong> 退款$extra。' . "\n";
$lang->action->desc->deliveried        = '$date, 由 <strong>$actor</strong> 發貨。' . "\n";
$lang->action->desc->confirmedDelivery = '$date, 由 <strong>$actor</strong> 確認收貨。' . "\n";
$lang->action->desc->edited            = '$date, 由 <strong>$actor</strong> 編輯。' . "\n";
$lang->action->desc->finished          = '$date, 由 <strong>$actor</strong> 完成。' . "\n";
$lang->action->desc->canceled          = '$date, 由 <strong>$actor</strong> 取消。' . "\n";
$lang->action->desc->deleted           = '$date, 由 <strong>$actor</strong> 刪除。' . "\n";
$lang->action->desc->diff1             = '修改了 <strong><i>%s</i></strong>，舊值為 "%s"，新值為 "%s"。<br />' . "\n";
$lang->action->desc->diff2             = '修改了 <strong><i>%s</i></strong>，區別為：' . "\n" . "<blockquote>%s</blockquote>" . "\n<div class='hidden'>%s</div>";
$lang->action->desc->diff3             = "將檔案名 %s 改為 %s 。\n";

/* 用來顯示動態信息。*/
$lang->action->label = new stdclass();
$lang->action->label->created           = '創建了';
$lang->action->label->paid              = '付款';
$lang->action->label->savedpayment      = '收款';
$lang->action->label->applyRefunded     = '申請退款';
$lang->action->label->refunded          = '退款';
$lang->action->label->deliveried        = '發貨';
$lang->action->label->confirmedDelivery = '確認收貨';
$lang->action->label->edited            = '編輯了';
$lang->action->label->finished          = '完成了';
$lang->action->label->canceled          = '取消了';
$lang->action->label->deleted           = '刪除了';
$lang->action->label->space             = '　';
