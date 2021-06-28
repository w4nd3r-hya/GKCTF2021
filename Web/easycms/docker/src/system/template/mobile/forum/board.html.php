{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The board view file of forum for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     forum
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.simple')}
<div class='block-region region-top blocks' data-region='forum_board-top'>{$control->loadModel('block')->printRegion($layouts, 'forum_board', 'top')}</div>
<div class='panel-section'>
  {if(count($threads) > 5 && $control->forum->canPost($board))}
    <div class='panel-heading'>
      {!html::a($control->createLink('thread', 'post', "boardID=$board->id"), '<i class="icon-pencil"></i>&nbsp;&nbsp;' . $lang->forum->post, "class='btn primary block' data-toggle='modal'")}
    </div>
  {/if}

  <div class='thread-list'>
    <div class='sticks'>
    {foreach($sticks as $thread)}
      {$style = ($thread->color or $thread->stickBold) ? "style='" : ''}
      {$style .= $thread->color ? "color:{{$thread->color}};" : ''}
      {$style .= $thread->stickBold ? "font-weight:bold;" : ''}
      {$style .= ($thread->color or $thread->stickBold) ? "'" : ''}
      <div class='thread'>
        <div class='header'>
          <a href='{$control->createLink("thread", "view", "id=$thread->id")}' data-ve='thread' id='thread{$thread->id}'>
            <span class='title' {$style}>
              <span class='text-danger'>[{$lang->thread->stick}]</span>
              {$thread->title}
            </span>
          </a>
          {if($control->thread->canManage($board->id, $thread->author))}
          <div class='operations'>
            <span class='trigger'>
              <i class='circle'></i>
              <i class='circle'></i>
              <i class='circle'></i>
            </span>
            <div class='options hidden'>
              {if($control->thread->canManage($board->id))}
                {!html::a($control->createLink('thread', 'stick', "thread=$thread->id"), "{{$lang->thread->sticks[$thread->stick]}}", "data-toggle='modal'")}
                {if(commonModel::isAvailable('score') and $control->thread->canManage($board->id))}
                  {@$account = helper::safe64Encode($thread->author)}
                  {!html::a($control->createLink('thread', 'addScore', "account={{$account}}&objectType=thread&objectID={{$thread->id}}"), $lang->thread->score, "data-toggle=modal class='text-muted'")}
                {/if}
                {if($thread->hidden)}
                  {!html::a($control->createLink('thread', 'switchstatus',   "threadID=$thread->id"), $lang->thread->show, "class='switcher ajaxaction'")}
                {else}
                  {!html::a($control->createLink('thread', 'switchstatus',   "threadID=$thread->id"), $lang->thread->hide, "class='switcher ajaxaction'")}
                {/if}
                {!html::a($control->createLink('thread', 'delete', "threadID=$thread->id"), $lang->delete, "class='deleter'")}
                {!html::a($control->createLink('thread', 'transfer',   "threadID=$thread->id"), $lang->thread->transfer, "data-toggle='modal'")}
              {/if}
              {if($control->thread->canManage($board->id, $thread->author))} {!html::a($control->createLink('thread', 'edit', "threadID=$thread->id"), $lang->edit, 'data-toggle="modal"')} {/if}
            </div>
          </div>
          {/if}
        </div>
        <a href='{$control->createLink("thread", "view", "id=$thread->id")}' data-ve='thread' id='thread{$thread->id}'>
          <div class='{if(!empty($thread->image))}content{else}content-no-img{/if}'>
            <div class='left'>
              <span class='{if(!empty($thread->image))}desc{else}desc-no-img{/if}'>{!strip_tags($thread->content)}</span>
              <div class='ext'>
                <span class='views'>{!html::image($config->webRoot . 'theme/mobile/default/comments.png')} {$thread->replies}</span>
                <span class='pub-time'>{!substr($thread->addedDate, 0, 10)}</span>
              </div>
            </div>
            {if(!empty($thread->image))}
            <div class='img'>
              {$title = $thread->image->primary->title ? $thread->image->primary->title : $thread->title}
              {$thread->image->primary->objectType = 'thread'}
              {!html::image($control->loadModel('file')->printFileURL($thread->image->primary, 'middleURL'), "title='{{$title}}' class='thumbnail'")}
            </div>
            {/if}
          </div>
        </a>
      </div>
      {@unset($threads[$thread->id])}
    {/foreach}
    </div>

    <div class='threads'>
    {foreach($threads as $thread)}
      {$style = $thread->color ? " style='color:{{$thread->color}}'" : ''}
      <div class='thread'>
        <div class='header'>
          <a href='{$control->createLink("thread", "view", "id=$thread->id")}' data-ve='thread' id='thread{$thread->id}'>
            <span class='title' {$style}>{$thread->title}</span>
          </a>
          {if($control->thread->canManage($board->id, $thread->author))}
          <div class='operations'>
            <span class='trigger'>
              <i class='circle'></i>
              <i class='circle'></i>
              <i class='circle'></i>
            </span>
            <div class='options hidden'>
              {if($control->thread->canManage($board->id))}
                {!html::a($control->createLink('thread', 'stick', "thread=$thread->id"), "{{$lang->thread->sticks[$thread->stick]}}", "data-toggle='modal'")}
                {if(commonModel::isAvailable('score') and $control->thread->canManage($board->id))}
                  {@$account = helper::safe64Encode($thread->author)}
                  {!html::a($control->createLink('thread', 'addScore', "account={{$account}}&objectType=thread&objectID={{$thread->id}}"), $lang->thread->score, "data-toggle=modal class='text-muted'")}
                {/if}
                {if($thread->hidden)}
                  {!html::a($control->createLink('thread', 'switchstatus',   "threadID=$thread->id"), $lang->thread->show, "class='switcher ajaxaction'")}
                {else}
                  {!html::a($control->createLink('thread', 'switchstatus',   "threadID=$thread->id"), $lang->thread->hide, "class='switcher ajaxaction'")}
                {/if}
                {!html::a($control->createLink('thread', 'delete', "threadID=$thread->id"), $lang->delete, "class='deleter'")}
                {!html::a($control->createLink('thread', 'transfer',   "threadID=$thread->id"), $lang->thread->transfer, "data-toggle='modal'")}
              {/if}
              {if($control->thread->canManage($board->id, $thread->author))} {!html::a($control->createLink('thread', 'edit', "threadID=$thread->id"), $lang->edit, 'data-toggle="modal"')} {/if}
            </div>
          </div>
          {/if}
        </div>
        <a href='{$control->createLink("thread", "view", "id=$thread->id")}' data-ve='thread' id='thread{$thread->id}'>
          <div class='{if(!empty($thread->image))}content{else}content-no-img{/if}'>
            <div class='left'>
              <span class='{if(!empty($thread->image))}desc{else}desc-no-img{/if}'>{!strip_tags($thread->content)}</span>
              <div class='ext'>
                <span class='views'>{!html::image($config->webRoot . 'theme/mobile/default/comments.png')} {$thread->replies}</span>
                <span class='pub-time'>{!substr($thread->addedDate, 0, 10)}</span>
              </div>
            </div>
            {if(!empty($thread->image))}
            <div class='img'>
              {$title = $thread->image->primary->title ? $thread->image->primary->title : $thread->title}
              {$thread->image->primary->objectType = 'thread'}
              {!html::image($control->loadModel('file')->printFileURL($thread->image->primary, 'middleURL'), "title='{{$title}}' class='thumbnail'")}
            </div>
            {/if}
          </div>
        </a>
      </div>
    {/foreach}
    </div>
  </div>

  <div class='panel-footer'>
    {$pager->createPullUpJS('.threads', $lang->mobile->pullUpHint)}
  </div>
  {if($control->forum->canPost($board))}
    <footer class="appbar fix-right" data-ve='navbar' data-type='mobile_bottom'>
      {!html::a($control->createLink('thread', 'post', "boardID=$board->id"), html::image($config->webRoot . 'theme/mobile/default/posting.png'), "data-toggle='modal'")}
    </footer>
  {/if}
</div>
<div class='block-region region-bottom blocks' data-region='forum_board-bottom'>{$control->loadModel('block')->printRegion($layouts, 'forum_board', 'bottom')}</div>
{include TPL_ROOT . 'common/form.html.php'}
{if(isset($pageJS))} {!js::execute($pageJS)} {/if}
