<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The edit view file of order module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<?php include '../../../common/view/datepicker.html.php';?>
<?php $productCount = count($products); $item = 1;?>
<?php js::set('productCount', $productCount);?>
<form method='post' id='editForm' class='form-inline' action="<?php echo inlink('edit', "orderID={$order->id}");?>">
  <table class='table table-form'>
    <tr>
      <th class='w-80px'><?php echo $lang->order->deliveryStatus;?></th>
      <td><?php echo $lang->order->deliverList[$order->deliveryStatus];?></td>
    </tr>
    <?php foreach($products as $goods):?>
    <tr>
      <?php if(!isset($goodsStarted)):?>
      <th rowspan='<?php echo $productCount;?>'><?php echo $lang->order->productInfo;?></th>
      <?php endif;?>
      <td>
        <div class='pull-left' style='padding:8px; padding-left:0;'>
          <span><?php echo html::a(commonModel::createFrontLink('product', 'view', "id=$goods->productID"), $goods->productName, "target='_blank'");?></span>
          <span><?php echo $lang->order->price . $lang->colon . $goods->price ;?></span>
        </div>
        <div class='w-180px pull-left'>
          <div class='input-group'>
            <span class="input-group-addon"><i class='icon icon-minus'> </i></span>
            <?php echo html::input("count[$goods->id]", $goods->count, "class='form-control' data-price='{$goods->price}'"); ?>
            <span class="input-group-addon fix-border"><i class='icon icon-plus'> </i></span>
            <span class="input-group-addon">
              <?php $disabled = $productCount >  1 ? '' : 'disabled'?>
              <?php echo html::a('javascript:;', $lang->delete, "class='{$disabled} product-deleter'");?>
            </span>
          </div>
        </div>
      </td>
      <?php $goodsStarted = true;?>
      </tr>
    <?php endforeach;?>
    <tr>
      <th class='w-80px'><?php echo $lang->order->amount;?></th>
      <td><?php echo html::input('amount', $order->amount, "readonly class='form-control'");?></td>
    </tr>
    <?php if($order->deliveryStatus === 'send'):?>
    <tr>
      <th class='w-80px'><?php echo $lang->order->express;?></th>
      <td><?php echo html::select('express', $expressList, $order->express, "class='form-control'");?></td>
    </tr>
    <tr>
      <th class='w-80px'><?php echo $lang->order->waybill;?></th>
      <td><?php echo html::input('waybill',  $order->waybill, "class='form-control'");?></td>
    </tr>
    <tr>
      <th class='w-80px'><?php echo $lang->order->deliveriedDate;?></th>
      <td>
        <div class="input-append date">
          <?php echo html::input('deliveriedDate', $order->deliveriedDate, "class='form-control'");?>
          <span class='add-on'><button class="btn btn-default" type="button"><i class="icon-calendar"></i></button></span>
        </div>
      </td>
    </tr>
    <?php endif;?>
    <?php if($order->deliveryStatus !== 'confirmed'):?>
    <?php $address = json_decode($order->address);?>
    <tr>
      <th class='w-80px'><?php echo $lang->order->contact;?></th>
      <td><?php echo html::input('contact', $address->contact, "class='form-control'");?></td>
    </tr> 
    <tr>
      <th class='w-80px'><?php echo $lang->order->phone;?></th>
      <td><?php echo html::input('phone', $address->phone, "class='form-control'");?></td>
    </tr> 
    <tr>
      <th class='w-80px'><?php echo $lang->order->address;?></th>
      <td><?php echo html::input('address', $address->address, "class='form-control'");?></td>
    </tr> 
    <tr>
      <th class='w-80px'><?php echo $lang->order->zipcode;?></th>
      <td><?php echo html::input('zipcode', $address->zipcode, "class='form-control'");?></td>
    </tr>
    <?php endif;?> 
    <tr>
      <th class='w-80px'><?php echo $lang->order->note;?></th>
      <td><?php echo html::input('note', $order->note, "class='form-control'");?></td>
    </tr> 
    <tr>
      <th></th>
      <td colspan='2'>
        <?php echo html::submitButton();?>
      </td>
    </tr>
  </table>
</form>
<script>
$(document).ready(function()
{   
    $.setAjaxForm('#editForm', function(data)
    {
        if(data.result == 'success') setTimeout(function(){parent.location.reload()}, 1500);
    }); 
});
</script>
<?php include '../../common/view/footer.modal.html.php';?>
