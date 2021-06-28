{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
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
/php*}
<div class='modal-dialog'>
  <div class='modal-content'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span></button>
      <h5 class='modal-title'><i class='icon-pencil'></i> {$lang->order->edit}</h5>
    </div>
    <div class='modal-body'>
      <form method='post' id='editOrderForm' action="{!inlink('edit', "orderID={{$order->id}}")}">
        {$address = json_decode($order->address)}
        <div class='form-group pad-label-left'>
          {!html::input('contact', $address->contact, "class='form-control'")}
          <label for='contact'>{$lang->order->contact}</label>
        </div>
        <div class='form-group pad-label-left'>
          {!html::input('phone', $address->phone, "class='form-control'")}
          <label for='phone'>{$lang->order->phone}</label>
        </div>
        <div class='form-group pad-label-left'>
          {!html::input('address', $address->address, "class='form-control'")}
          <label for='address'>{$lang->order->address}</label>
        </div>
        <div class='form-group pad-label-left'>
          {!html::input('zipcode', $address->zipcode, "class='form-control'")}
          <label for='zipcode'>{$lang->order->zipcode}</label>
        </div>
        <div class='form-group pad-label-left'>
          {!html::input('note', $order->note, "class='form-control'")}
          <label for='note'>{$lang->order->frontNote}</label>
        </div>
        <div class='form-group form-group-actions'>
          {!html::submitButton('', 'btn block primary')}
        </div>
      </form>
    </div>
  </div>
</div>
{noparse}
<script>
$(function()
{
    var $editOrderForm = $('#editOrderForm');
    $editOrderForm.ajaxform({onSuccess: function(response)
    {
        if(response.result == 'success')
        {
            $.closeModal();
        }
    }
    });
});
</script>
{/noparse}
