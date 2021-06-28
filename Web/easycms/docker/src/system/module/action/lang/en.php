<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The action en file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     action
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->action->common  = 'Logs';

$lang->action->objectType = 'Type';
$lang->action->objectID   = 'ID';
$lang->action->objectName = 'Details';
$lang->action->actor      = 'Account';
$lang->action->action     = 'Action';
$lang->action->date       = 'Date';

$lang->action->objectTypes['order'] = 'Order';

$lang->action->desc = new stdclass();
$lang->action->desc->common            = '$date, <strong>$action</strong> by <strong>$actor</strong>' . "\n";
$lang->action->desc->created           = '$date, created by <strong>$actor</strong>.';
$lang->action->desc->paid              = '$date, paid by <strong>$actor</strong>.' . "\n";
$lang->action->desc->savedpayment      = '$date, saved payment <strong>$extra</strong> by <strong>$actor</strong>.' . "\n";
$lang->action->desc->applyrefunded     = '$date, <strong>$actor</strong> apply refund.' . "\n";
$lang->action->desc->refunded          = '$date, refunded $extra by <strong>$actor</strong>.' . "\n";
$lang->action->desc->deliveried        = '$date, deliveried by <strong>$actor</strong>.' . "\n";
$lang->action->desc->confirmedDelivery = '$date, confirmed delivery by <strong>$actor</strong>.' . "\n";
$lang->action->desc->edited            = '$date, edited by <strong>$actor</strong>.' . "\n";
$lang->action->desc->finished          = '$date, finished by <strong>$actor</strong>.' . "\n";
$lang->action->desc->canceled          = '$date, canceled by <strong>$actor</strong>.' . "\n";
$lang->action->desc->deleted           = '$date, deleted by <strong>$actor</strong>.' . "\n";
$lang->action->desc->diff1             = 'changed <strong><i>%s</i></strong>, old is "%s", new is "%s".<br />';
$lang->action->desc->diff2             = 'changed <strong><i>%s</i></strong>, the diff is:' . "\n" . "<blockquote>%s</blockquote>" . "\n<div class='hidden'>%s</div>";
$lang->action->desc->diff3             = "changed file name %s to %s.";

/* The action labels. */
$lang->action->label = new stdclass();
$lang->action->label->created           = 'Created';
$lang->action->label->paid              = 'Paid';
$lang->action->label->savedpayment      = 'Saved';
$lang->action->label->applyRefunded     = 'Refund';
$lang->action->label->refunded          = 'Refunded';
$lang->action->label->deliveried        = 'Deliveried';
$lang->action->label->confirmedDelivery = 'Confirmed';
$lang->action->label->edited            = 'Edited';
$lang->action->label->finished          = 'Finished';
$lang->action->label->canceled          = 'Canceled';
$lang->action->label->deleted           = 'Deleted';
$lang->action->label->space             = '　';
