{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The apply refund view file of order for mobile template of chanzhiEPS.
 * The file should be used as ajax content
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
<div class='modal-dialog'>
  <div class='modal-content'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span></button>
      <h5 class='modal-title'><i class='icon-pencil'></i> {$lang->order->applyRefund}</h5>
    </div>
    <div class='modal-body'>
      <form method='post' id='applyRefundForm' action="{!inlink('applyRefund', "orderID={{$orderID}}")}">
        <div class='form-group'>
          <label for='comment'>{$lang->order->comment}</label>
          {!html::textarea('comment', '', "class='form-control' rows='3'")}
        </div>
        <div class='form-group'>
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
    var $applyRefundForm = $('#applyRefundForm');
    $applyRefundForm.ajaxform({onSuccess: function(response)
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
