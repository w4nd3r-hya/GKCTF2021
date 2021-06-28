{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The reply view file of message for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     message
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
<div class='modal-dialog'>
  <div class='modal-content'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span></button>
      <h5 class='modal-title'><i class='icon-reply'></i> {$lang->message->reply}</h5>
    </div>
    <div class='modal-body'>
      <form id='replyForm' method='post' action="{!inlink('reply', "messageID=$message->id")}">
        <div class='form-group'>
          {!html::textarea('content', '', "class='form-control' rows='5' placeholder='{{$lang->message->content}}'")}
        </div>
        {if($control->session->user->account == 'guest')}
          <div class="form-group">
            {!html::input('from', '', "class='form-control' placeholder='{{$lang->message->from}}'")}
          </div>
          <div class="form-group">
            {!html::input('email', '', "class='form-control' placeholder='{{$lang->message->email}}'")}
          </div>
        {else}
          <div class='form-group'>
            <span class='signed-user-info'>
              <i class='icon-user text-muted'></i> <strong>{$control->session->user->realname}</strong>
              {!html::hidden('from', $control->session->user->realname)}
              {if($control->session->user->email != '')}
                <span class='text-muted'>&nbsp;({!str2Entity($control->session->user->email)})</span>
                {!html::hidden('email', $control->session->user->email)}
              {/if}
            </span>
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
{if(isset($pageJS))} {!js::execute($pageJS)} {/if}
{noparse}
<script>
$(function()
{
    var $replyForm  = $('#replyForm'),
        $commentBox = $('#commentBox');
    $replyForm.ajaxform({onSuccess: function(response)
    {
        if(response.result == 'success')
        {
            $.closeModal();
            if($.isFunction($.refreshCommentList))
            {
                setTimeout($.refreshCommentList, 200);
            }
        }
        if(response.reason == 'needChecking')
        {
            $replyForm.find('.captcha-box').html(Base64.decode(response.captcha)).removeClass('hide');
        }
    } });

    $commentBox.find('.pager').on('click', 'a', function()
    {
        $commentBox.load($(this).attr('href'));
        return false;
    });
});
</script>
{/noparse}
