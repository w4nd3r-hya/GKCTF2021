{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The stick view file of thread for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
<div class='modal-dialog'>
  <div class='modal-content'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span></button>
      <h5 class='modal-title'><i class='icon icon-location-arrow'></i> {$lang->thread->stick}</h5>
    </div>
    <div class='modal-body'>
      <form id='stickForm' method='post' action='{!inlink('stick', "threadID={{$thread->id}}")}'>
        <div class='form-group'>
          <label for='stick' class='control-label'>{$lang->thread->stick}</label>
          {!html::radio('stick', $lang->thread->sticks, $thread->stick)}
        </div>
        <div class="form-group {if($thread->stick == 0)}{!'hide'}{/if}">
          <label for='stickBold' class='control-label'>{$lang->thread->stickBold}</label>
          {$checked = $thread->stickBold ? 'checked' : ''}
          <input type='checkbox' name='stickBold' id='stickBold' value='1' {$checked} />
        </div>
        <div class="form-group {if($thread->stick == 0)}{!'hide'}{/if}">
          <label for='stickTime' class='control-label'>{$lang->thread->stickTime}</label>
          <input type='date' class='input' value='{!formatTime($thread->stickTime)}'>
        </div>
        <div class='form-group'>
          {!html::submitButton('', 'btn primary block')}
        </div>
      </form>
    </div>
  </div>
</div>
{noparse}
<script>
$(function()
{
    var $stickForm = $('#stickForm');
    $stickForm.ajaxform({onSuccess: function(response)
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
