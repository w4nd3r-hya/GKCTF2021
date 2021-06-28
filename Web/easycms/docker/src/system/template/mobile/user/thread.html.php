{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The thread view file of user for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.simple')}
<div class='panel-section'>
  <div class='panel-heading'>
    <div class='title strong'>{$lang->user->thread}</div>
  </div>
  <div class='cards condensed cards-list' id='thread'>
    {foreach($threads as $thread)}
      <a href='{!$control->createLink('thread', 'view', "id=$thread->id")}' class='card'>
        <div class='card-fix'>
          <div class='card-body'>
            <div class='card-left'>
              <div class='card-top'>
                <div class='card-title'>{$thread->title}</div>
                <div class='card-theard'>{$thread->boardName}</div>
              </div>
              <div class='pub-time'>
                <div class='card-content text-muted'>
                  {$lang->thread->postedDate}：{!substr($thread->addedDate, 5, -3)}
                </div>
                {if($thread->replies)}
                  <div class='card-footer text-muted'>
                    {$lang->thread->lastReply}：{!substr($thread->repliedDate, 5, -3) . ' ' . $thread->repliedByRealname}
                  </div>
                {/if}
              </div>
            </div>
            <div class='reply middle thumbnail-cell text-right'>
              <div class='counter text-center'><div class='title text-danger'>{$thread->replies}</div><div class='caption text-muted small'>{$lang->thread->replyCount}</div></div>
              </div>
          </div>
        </div>
      </a>
    {/foreach}
  </div>
  {$pager->createPullUpJS('#thread', $lang->mobile->pullUpHint)}
</div>
