{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The edit view file of thread for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
<div class='modal-dialog'>
  <div class='modal-content'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span></button>
      <h5 class='modal-title'><i class='icon-pencil'></i> {!echo $lang->thread->edit . $lang->colon . $thread->title}</h5>
    </div>
    <div class='modal-body'>
      <form id='editThreadForm' method='post' action='{$control->createLink('thread', 'edit', "threadID=$thread->id")}'>
        <div class='form-group'>
          {!html::input('title', $thread->title, "class='form-control' placeholder='{{$lang->thread->title}}'")}
        </div>
        <div class='form-group'>
          {!html::textarea('content', $thread->content, "class='form-control' rows='15' placeholder='{{$lang->thread->content}}'")}
        </div>
        {if($canManage)}
          <div class='form-group'>
            <div class="checkbox">
              <label>
                {$readonly = $thread->readonly ? 'checked' : ''}
                <input type='checkbox' name='readonly' value='1' {$readonly}/><span>{$lang->thread->readonly}</span>
              </label>
            </div>
          </div>
        {/if}
        <table style='width: 100%'>
          <tr class='hide captcha-box'></tr>
        </table>
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
    var $editThreadForm = $('#editThreadForm');
    $editThreadForm.ajaxform({onResultSuccess: function(response)
    {
        if(response.result == 'success')
        {
            $.closeModal();
        }
    }, onSuccess: function(response)
    {
        if(response.reason == 'needChecking')
        {
            $editThreadForm.find('.captcha-box').html(Base64.decode(response.captcha)).removeClass('hide');
        }
    }
    });
});
</script>
{/noparse}
