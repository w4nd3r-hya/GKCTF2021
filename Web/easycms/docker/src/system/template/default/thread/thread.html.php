{if(!defined("RUN_MODE"))} {!die()} {/if}
<div class='panel thread'>
  <div class='panel-heading'>
    <i class='icon-comment-alt pull-left'></i>
    <div class='panel-actions'>
      {if($thread->readonly)} <span class='label'><i class='icon-lock'></i>{$lang->thread->readonly}</span> {/if}
    </div>
    <strong>{$thread->title}</strong>
    <div class='text-muted'>{$thread->addedDate}</div>
  </div>
  <table class='table'>
    <tr>
      <td class='speaker'>
        {if(isset($speakers[$thread->author]))}
          {$control->thread->printSpeaker($speakers[$thread->author])}
        {else}
          {$thread->author}
        {/if}
      </td>
      <td id='{$thread->id}' class='thread-wrapper'>
        <div class='thread-content article-content'>{$thread->content}</div>
        {if(!empty($thread->files))}
          <div class='article-files'>{$control->thread->printFiles($thread, $control->thread->canManage($board->id, $thread->author))}</div>
        {/if}
      </td>
    </tr>
  </table>
  <div class='thread-foot'>
    {if(commonModel::isAvailable('score') and !empty($thread->scoreSum))}
      <span >{!sprintf($lang->thread->scoreSum, $thread->scoreSum)}</span>
    {/if}
    {if($thread->editor)}
      <small class='text-muted'>{!printf($lang->thread->lblEdited, $thread->editorRealname, $thread->editedDate)}</small>
    {/if}
    <div class='pull-right thread-actions'>
      {if($control->app->user->account != 'guest')}
        {if($control->thread->canManage($board->id))}
          <span class='thread-more-actions'>
            {!html::a(inlink('stick', "thread=$thread->id"), "<i class='icon-flag-alt'></i> " . zget($lang->thread->sticks, $thread->stick), "data-toggle='modal'")}
            {if(commonModel::isAvailable('score') and $control->thread->canManage($board->id))}
              {$account = helper::safe64Encode($thread->author)}
              {!html::a(inlink('addScore', "account={{$account}}&objectType=thread&objectID={{$thread->id}}"), $lang->thread->score, "data-toggle=modal")}
            {/if}
            {if($thread->hidden)}
              {!html::a(inlink('switchstatus',   "threadID=$thread->id"), '<i class="icon-eye-open"></i> ' . $lang->thread->show, "class='switcher'")}
            {else}
              {!html::a(inlink('switchstatus',   "threadID=$thread->id"), '<i class="icon-eye-close"></i> ' . $lang->thread->hide, "class='switcher'")}
            {/if}
            {!html::a(inlink('delete', "threadID=$thread->id"), '<i class="icon-trash"></i> ' . $lang->delete, "class='deleter'")}
            {!html::a(inlink('transfer',   "threadID=$thread->id"), '<i class="icon-location-arrow"></i> ' . $lang->thread->transfer, "data-toggle='modal'")}
          </span>
        {/if}
        {if($control->thread->canManage($board->id, $thread->author))} {!html::a(inlink('edit', "threadID=$thread->id"), '<i class="icon-pencil"></i> ' . $lang->edit)} {/if}
        <a href='#reply' class='thread-reply-btn'><i class='icon-reply'></i> {$lang->reply->common}</a>
      {else}
         <a href="{$control->createLink('user', 'login', 'referer=' . helper::safe64Encode($control->app->getURI(true) . '#reply'))}" class="thread-reply-btn"><i class="icon-reply"></i> {$lang->reply->common}</a>
      {/if}
    </div>
  </div>
</div>
