<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The return view file of order module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     mall
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<form method='post' action='<?php echo inlink('savepayment', "orderID={$order->id}");?>' id='editForm'>
  <table class='table table-form'>
    <tr>
      <th class='w-80px'><?php echo $lang->order->payment;?></th>
      <td><?php echo html::select('payment', $lang->order->paymentList, 'offlinepay', "class='form-control'");?></td>
    </tr>
    <tr>
      <th class='w-80px'><?php echo $lang->order->sn;?></th>
      <td><?php echo html::input('sn', '', "class='form-control'");?></td>
    </tr>
    <tr>
      <th class='w-80px'><?php echo $lang->order->savePay;?></th>
      <td><?php echo html::input('amount', $order->amount, "class='form-control'");?></td>
    </tr>
    <tr>
      <th class='w-80px'><?php echo $lang->order->paidDate;?></th>
      <td>
        <div class="input-append date">
        <?php echo html::input('paidDate', date('Y-m-d H:i'), "class='form-control'");?>
        <span class='add-on'><button class="btn btn-default" type="button"><i class="icon-calendar"></i></button></span>
        </div>
      </td>
    </tr>
    <tr>
      <th></th>    
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<script>
$(document).ready(function()
{   
    $.setAjaxForm('#editForm', function(data)
    {
        if(data.result == 'success') setTimeout(function(){parent.location.reload()}, 1000);
    }); 
});
</script>
<?php include '../../common/view/footer.modal.html.php';?>
