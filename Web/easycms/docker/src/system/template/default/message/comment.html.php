{if(!defined("RUN_MODE"))} {!die()} {/if}
{!js::set('objectType', $objectType)}
{!js::set('objectID',   $objectID)}
{!js::set('showDetail',$showDetail)}
{!js::set('hideDetail', $hideDetail)}
{if(isset($pageCSS))} {!css::internal($pageCSS)} {/if}
{if(isset($comments) and $comments)}
  <div class='panel mgb-0'>
    <div class='panel-heading' style="border-bottom-width: 0px;">
      <div class='panel-actions'><a href='#commentForm' class='btn btn-primary'><i class='icon-comment-alt'></i> {$lang->message->post}</a></div>
      <strong>{$lang->message->list}</strong>
    </div>
    <div class='comment-container'>
      {$i = 0}
      {foreach($comments as $number => $comment)}
        <div class='w-p100 panel comment-item comment-panel' id="comment{$comment->id}">
          <div class='panel-heading content-heading'>
            <span class='text-special'>{$comment->from}</span>
            <span class='text-muted'> {$comment->date}</span>
            {!html::a($control->createLink('message', 'reply', "commentID=$comment->id"), $lang->message->reply, "class='pull-right' data-toggle='modal' data-type='iframe' data-icon='reply' data-title='{{$lang->comment->reply}}'")}
          </div>
          <div class='panel-body'>{!nl2br($comment->content)}</div>
          {$control->message->getFrontReplies($comment)}
        </div>
      {/foreach}
      <div class='text-right'>
        <div class='pager clearfix' id='pager'>{$pager->show('right', 'shortest')}</div>
      </div>
    </div>
  </div>
{/if}
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-comment-alt'></i> {$lang->message->post}</strong></div>
  <div class='panel-body'>
    <form method='post' class='form-horizontal' id='commentForm' action="{!$control->createLink('message', 'post', 'type=comment')}">
      {if($control->session->user->account == 'guest')}
        <div class='form-group'>
          <label for='from' class='col-sm-1 control-label'>{$lang->message->from}</label>
          <div class='col-sm-5 required'>
            {!html::input('from', '', "class='form-control'")}
          </div>
        </div>
        <div class='form-group'>
          <label for='email' class='col-sm-1 control-label'>{$lang->message->email}</label>
          <div class='col-sm-5'>
            {!html::input('email', '', "class='form-control'")}
          </div>
          <div class='col-sm-5'>
            <div class='checkbox'>
              <label><input type='checkbox' name='receiveEmail' value='1' checked /> {$lang->comment->receiveEmail}</label>
            </div>
          </div>
        </div>
      {else}
        <div class='form-group'>
          <label for='from' class='col-sm-1 control-label'>{$lang->message->from}</label>
          <div class='col-sm-11'>
            <span class='signed-user-info'>
              <i class='icon-user text-muted'></i> <strong>{$control->session->user->realname }</strong>
              {!html::hidden('from', $control->session->user->realname)}
              {if($control->session->user->email != '')}
                <span class='text-muted'>&nbsp;({!str2Entity($control->session->user->email)})</span>
                {!html::hidden('email', $control->session->user->email)}
              {/if}
            </span>
            <label class='checkbox-inline'><input type='checkbox' name='receiveEmail' value='1' checked /> {$lang->comment->receiveEmail}</label>
          </div>
        </div>
      {/if}
      <div class='form-group'>
        <label for='content' class='col-sm-1 control-label'>{$lang->message->content}</label>
        <div class='col-sm-11 required'>
          {!html::textarea('content', '', "class='form-control'")}
          {!html::hidden('objectType', $objectType)}
          {!html::hidden('objectID', $objectID)}
        </div>
      </div>
      {if(zget($control->config->site, 'captcha', 'auto') == 'open')}
        <div class='form-group' id='captchaBox'>
          {!$control->loadModel('guarder')->create4Comment()}
        </div>
      {else}
        <div class='form-group hiding' id='captchaBox'></div>
      {/if}
       <div class='form-group'>
        <div class='col-sm-11 col-sm-offset-1'>
          <span>{!html::submitButton($lang->message->submit, 'btn btn-primary', 'data-popover-container="false"')}</span>
          <span><small class="text-important">{$lang->comment->needCheck}</small></span>
        </div>
      </div>
    </form>
  </div>
</div>
{if(isset($pageJS))} {!js::execute($pageJS)} {/if}
