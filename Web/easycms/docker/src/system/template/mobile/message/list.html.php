{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The list view file of message for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     message
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
<div class='comments panel'>
  <div class="{if($objectType == 'message')}message-list{else}comment-list{/if}"   style="{if(!isset($comments) || !$comments)}display:none;{/if}">
      <div class='title vertical-center' style="{if($objectType == 'message')}display:none;{/if}">
        <span class='vertical-line'></span>
        <span class="list-text"> {$lang->message->list} </span>
      </div>
      <div id="commentsListAsync">
        <div id="commentsListWrapper">
          <div class='condensed bordered' id="commentsList">
            {foreach($comments as $number => $comment)}
              <div class='comment'>
                <div class='comment-heading vertical-center'>
                  <div class='left vertical-center'>
                    <div class="avatar vertical-center text-muted">
                      {if(empty($comment->avatar))}
                      <i class="icon icon-user icon-10x"></i>
                      {else}
                      <img src="{$comment->avatar}" alt="">
                      {/if}
                    </div>
                    <div class="comment-ext">
                      <span class="authorName">
                        {if(!empty($comment->realname))}
                          {$comment->realname}
                        {elseif(!empty($comment->from))}
                          {$comment->from}
                        {else}
                          {$lang->message->defaultNickname}
                        {/if}
                      </span>
                      <span class="addedDate">{!formatTime($comment->date)}</span>
                    </div>
                  </div>
                  <div class='actions reply-text'>
                    {!html::a($control->createLink('message', 'reply', "commentID=$comment->id"), $lang->message->reply, "data-toggle='modal' data-type='ajax' data-icon='reply' data-title='{{$lang->message->reply}}'")}
                  </div>
                </div>
                <div class="comment-content">{!nl2br($comment->content)}</div>
                {$control->message->getFrontReplies($comment)}
              </div>
            {/foreach}
          </div>
          <div id="paginator">
            {if($objectType == 'message')}
              {$pager->createPullUpJS('#commentsList', $lang->mobile->pullUpHint)}
            {else}
              {$pager->createPullUpJS('#commentsList', $lang->mobile->pullUpHint, helper::createLink('message', 'comment', 'objectType=' . $objectType . '&objectID=' . $objectID . '&pageID=$ID'))}
            {/if}
          </div>
        </div>
      </div>
  </div>

{include TPL_ROOT . 'common/form.html.php'}
{if(isset($pageJS))} {!js::execute($pageJS)} {/if}
