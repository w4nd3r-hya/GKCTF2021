<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The refund view file of order module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<form method='post' action='<?php echo inlink('refund', "orderID={$order->id}");?>' id='ajaxForm'>
  <table class='table table-form'>
    <tr>
      <th class='w-80px'><?php echo $lang->order->sn;?></th>
      <td><?php echo html::input('sn', '', "class='form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->order->amount;?></th>
      <td><?php echo html::input('amount', '', "class='form-control'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->order->comment;?></th>
      <td><?php echo html::textarea('comment', '', "rows='5' class='form-control'");?></td>
    </tr>
    <tr>
      <th></th>    
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.modal.html.php';?>
