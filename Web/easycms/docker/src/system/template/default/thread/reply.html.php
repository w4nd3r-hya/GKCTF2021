{if(!defined("RUN_MODE"))} {!die()} {/if}
{foreach($replies as $reply)}
{$floor = $floors[$reply->id]}
<div id = "{!echo $reply->id}" class="panel panel thread reply {!echo $floor%2!=0?'striped':''}">
  <div class='panel-heading'>
    <div class='panel-actions'>
      <strong>{if($floor > 2)}{!echo '#' . $floor} {/if}</strong>
      {!html::a('', '', "name=$floor")}
      {if($floor == 1)}
        <strong class='text-danger'>{!echo $lang->reply->sofa}</strong>
      {elseif($floor == 2)}
        <strong class='text-success'>{!echo $lang->reply->stool}</strong>
      {/if}
    </div>
    <span class='muted'>
      <i class='icon-comment-alt'></i> {!echo $reply->addedDate}
      {if(!$thread->discussion and $reply->reply)}
      {!echo sprintf($lang->thread->replyFloor, zget($floors, $reply->reply))}
      {/if}
    </span>
  </div>
  <table class='table'>
    <tr>
      <td class='speaker'>
        {if(isset($speakers[$reply->author]))}
            {$control->thread->printSpeaker($speakers[$reply->author])}
        {else}
            {!echo $reply->author}
        {/if}
      </td>
      <td id='{!echo $reply->id}' class='thread-wrapper'>
        <div class='thread-content article-content'>{!echo $reply->content}</div>
        {if(!empty($reply->files))}
          <div class='article-files'>{$control->reply->printFiles($reply, $control->thread->canManage($board->id, $reply->author))}</div>
        {/if}
        {if($thread->discussion)}
          {$control->reply->getByReply($reply)}
        {/if}
      </td>
    </tr>
  </table>
  <div class='thread-foot'>
    {if(commonModel::isAvailable('score') and !empty($reply->scoreSum))}
      {!echo sprintf($lang->thread->scoreSum, $reply->scoreSum)}
    {/if}
    {if($reply->editor)}
      <small class='text-muted'>{!printf($lang->thread->lblEdited, $reply->editorRealname, $reply->editedDate)}</small>
    {/if}
    <div class="pull-right reply-actions thread-actions">
    {if($control->app->user->account != 'guest')}
    <span class="thread-more-actions">
      {if(commonModel::isAvailable('score') and $control->thread->canManage($board->id))}
        {$account = helper::safe64Encode($reply->author)}
        {!html::a(inlink('addScore', "account={{$account}}&objectType=reply&objectID={{$reply->id}}"), $lang->thread->score, "data-toggle=modal")}
      {/if}
      {if($control->thread->canManage($board->id))} {!html::a($control->createLink('reply', 'delete', "replyID=$reply->id"), '<i class="icon-trash"></i> ' . $lang->delete, "class='deleter'")} {/if}
      {if($control->thread->canManage($board->id, $reply->author))} {!html::a($control->createLink('reply', 'edit',   "replyID=$reply->id"), '<i class="icon-pencil"></i> ' . $lang->edit)} {/if}
    </span>
    <a href="#reply" data-reply='{!echo $reply->id}' class="thread-reply-btn"><i class="icon-reply"></i> {!echo $lang->reply->common}</a>
    <a href="#reply" data-reply='{!echo $reply->id}' class="thread-reply-btn quote"><i class="icon-quote-left"></i> {!echo $lang->thread->quote}</a>
    {else}
    <a data-reply='{!echo $reply->id}' href="{!echo $control->createLink('user', 'login', 'referer=' . helper::safe64Encode($control->app->getURI(true) . '#' . $reply->id))}" class="thread-reply-btn"><i class="icon-reply"></i> {!echo $lang->reply->common}</a>
    {/if}
    </div>
  </div>
</div>
{/foreach}

<div class='clearfix pager'>{$pager->show('right', 'short')}</div>

{if($thread->readonly)}
<div class='alert alert-info'>{!echo $lang->thread->readonlyMessage}</div>
{elseif($control->session->user->account != 'guest')}
<div class='panel panel-form'>
  <div class='panel-heading'><strong><i class='icon-edit'></i> {!echo $lang->thread->replies}</strong></div>
  <div class='panel-body'>
    <form method='post' enctype='multipart/form-data' id='replyForm' action='{!echo $control->createLink('reply', 'post', "thread=$thread->id")}'>
      <div class='form-group' id='reply'>
        {!html::textarea('content', '', "rows='6' class='form-control'")}
      </div>
      <div class='row'>
        <div class='col-md-8 col-sm-12'>
          {!echo $control->fetch('file', 'buildForm')}
          {if(zget($control->config->site, 'captcha', 'auto') == 'open')}
            <div class='form-group clearfix' id='captchaBox'>{!echo $control->loadModel('guarder')->create4reply()}</div>
          {else}
            <div class='form-group clearfix' id='captchaBox' style='display:none;'></div>
          {/if}
        </div>
      </div>
      
      <div class='form-group'>{!html::submitButton()}</div>
      {!html::hidden('reply', 0)}
    </form>
  </div>
</div>
{/if}
