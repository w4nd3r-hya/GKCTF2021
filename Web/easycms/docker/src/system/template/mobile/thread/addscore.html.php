{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The award score view file of thread module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     Thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
<div class='modal-dialog'>
  <div class='modal-content'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span></button>
      <h5 class='modal-title'><i class='icon-pencil'></i> {$lang->thread->score}</h5>
    </div>
    <div class='modal-body'>
      <form id='addScoreForm' method='post' action='{!$control->createLink('thread', 'addscore', "account=$account&objectType=$objectType&objectID=$objectID")}'>
        <div class='form-group'>
          <label for='count' class='control-label'>{$lang->score->count}</label>
          {!html::input('count', '', "class='form-control'")}
        </div>
        <div class='form-group'>
          <label for='note' class='control-label'>{!$lang->score->note}</label>
          {!html::textarea('note', '', "class='form-control' rows='2'")}
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
    var $addScoreForm = $('#addScoreForm');
    $addScoreForm.ajaxform({onSuccess: function(response)
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
