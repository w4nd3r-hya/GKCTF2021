{if(!defined("RUN_MODE"))} {!die()} {/if}
<div class='thread'>
  <div class='header'>
    <div class='title'>
      <h2 class="vertical-center">
        {$thread->title}
        {if($thread->stick)}
        <span class='bg-danger-pale text-danger stick'>{$lang->thread->stick}</span>
        {/if}
        {if($thread->readonly)}
        <span class='bg-info-pale text-info readonly'>{$lang->thread->readonly}</span>
        {/if}
      </h2>
    </div>
    <div class='sub-content vertical-center'>
      <div class='author vertical-center'>
        <div class='avatar'>
          {if(!empty($thread->authorAvatar))}
          <img src='{$thread->authorAvatar}' alt=''>
          {else}
          <i class='icon icon-user icon-10x'></i>
          {/if}
        </div>
        <div class='ext'>
          <span class='authorName'>{$thread->author}</span>
          <span class='addedDate'>{!formatTime($thread->addedDate)}</span>
        </div>
      </div>
      {if($control->thread->canManage($board->id, $thread->author))}
      <div class='operations'>
        <span class='trigger'>
          <i class='circle'></i>
          <i class='circle'></i>
          <i class='circle'></i>
        </span>
        <div class='options hidden'>
          {if($control->thread->canManage($board->id))}
            {!html::a(inlink('stick', "thread=$thread->id"), "{{$lang->thread->sticks[$thread->stick]}}", "data-toggle='modal'")}
            {if(commonModel::isAvailable('score') and $control->thread->canManage($board->id))}
              {@$account = helper::safe64Encode($thread->author)}
              {!html::a(inlink('addScore', "account={{$account}}&objectType=thread&objectID={{$thread->id}}"), $lang->thread->score, "data-toggle=modal class='text-muted'")}
            {/if}
            {if($thread->hidden)}
              {!html::a(inlink('switchstatus', "threadID=$thread->id"), $lang->thread->show, "class='switcher ajaxaction'")}
            {else}
              {!html::a(inlink('switchstatus', "threadID=$thread->id"), $lang->thread->hide, "class='switcher ajaxaction'")}
            {/if}
            {!html::a(inlink('delete', "threadID=$thread->id"), $lang->delete, "class='deleter'")}
            {!html::a(inlink('transfer', "threadID=$thread->id"), $lang->thread->transfer, "data-toggle='modal'")}
          {/if}
          {if($control->thread->canManage($board->id, $thread->author))} {!html::a(inlink('edit', "threadID=$thread->id"), $lang->edit, 'data-toggle="modal"')} {/if}
        </div>
      </div>
      {/if}
    </div>
  </div>
  <div class='content' id='thread{$thread->id}' data-ve='thread'>
    <section class='detail'> {$thread->content} </section>
    {if(!empty($thread->files))}
    <section class='files'> {$control->loadModel('file')->printFiles($thread->files)} </section>
    {/if}
  </div>
</div>
