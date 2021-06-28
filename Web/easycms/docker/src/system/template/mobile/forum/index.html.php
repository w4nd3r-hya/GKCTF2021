{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The index view file of forum for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     forum
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
<div class='block-region region-top blocks' data-region='forum_index-top'>{$control->loadModel('block')->printRegion($layouts, 'forum_index', 'top')}</div>
<div class='block-top'>
  <div class='row'>
    {foreach($lang->forum->indexModeOptions as $modeCode => $modeName)}
      {$class=($modeCode == $mode) ? 'primary' : ''}
      <div class='col-4'>{!html::a(inlink('index', "mode=$modeCode"), $modeName, "class='btn $class'")}</div>
    {/foreach}
  </div>
</div>
<div class='panel-section'>
  {if($mode == 'latest')}
    <div class='cards cards-list condensed bordered' id='latest'>
      {foreach($threads as $thread)}
        {$style = $thread->color ? " color:{{$thread->color}}" : ''}
        <div class='card-fix white'>
          <a href='{$control->createLink('thread', 'view', "id=$thread->id")}' data-ve='thread' id='thread{$thread->id}'>
            <div class='card-heading'><h5 class='title' style='{$style}'>{$thread->title}</h5></div>
            <div class='card-body-special {if(!empty($thread->image->list[0]))}card-all{/if}'>
              <div class='card-content text-muted'>{!echo strip_tags($thread->content)}</div>
              <div class='card-content text-time'><i class="icon icon-comment-alt"></i> {$thread->replies} &nbsp; {!substr($thread->addedDate, 0, -8)}</div>
            </div>
            {if(!empty($thread->image->list[0]))}
            <div class='table-cell middle thumbnail-cell text-right special'>
              {!html::image($control->loadModel('file')->printFileURL($thread->image->list[0]))}
            </div>
            {/if}
          </a>
        </div>
      {/foreach}
    </div>
    <div class='panel-footer'>{$pager->createPullUpJS('#latest', $lang->mobile->pullUpHint, helper::createLink('forum', 'index', "mode=latest&pageID=\$ID"))}</div>
  {elseif($mode == 'stick')}
    <div class='cards cards-list condensed bordered' id='stick'>
      {foreach($threads as $thread)}
        {$style = $thread->color ? " color:{{$thread->color}}" : ''}
        <div class='card-fix white'>
          <a href='{$control->createLink('thread', 'view', "id=$thread->id")}' data-ve='thread' id='thread{$thread->id}'>
            <div class='card-heading'><h5 class='title' style='{$style}'>{$thread->title}</h5></div>
            <div class='card-body-special {if(!empty($thread->image->list[0]))}card-all{/if}'>
              <div class='card-content text-muted'>{!echo strip_tags($thread->content)}</div>
              <div class='card-content text-time'><i class="icon icon-comment-alt"></i> {$thread->replies} &nbsp; {!substr($thread->addedDate, 0, -8)}</div>
            </div>
            <div class='table-cell middle thumbnail-cell text-right'>
            </div>
          </a>
        </div>
      {/foreach}
    </div>
    <div class='panel-footer'>{$pager->createPullUpJS('#stick', $lang->mobile->pullUpHint, helper::createLink('forum', 'index', "mode=stick&pageID=\$ID"))}</div>
  {else}
    {foreach($boards as $parentBoard)}
      <div class='boards'>
        <div class='panel-heading page-header'>
          <div class='title strong'>{$parentBoard->name}</div>
        </div>
        <div class='panel-body'>
          <div class='cards cards-list'>
          {foreach($parentBoard->children as $childBoard)}
            {$isNewBoard = $control->forum->isNew($childBoard)}
            {$moderators = ''}
            {foreach($childBoard->moderators as $moderator)}
              {if(!empty($moderator))}
                {$moderators .= $moderator . ' '}
              {/if}
            {/foreach}
            <div class='card-fix'>
              <a href='{!inlink('board', "id=$childBoard->id", "category={{$childBoard->alias}}")}'>
                <div class='card-body'>
                  <div class='card-heading'>
                    <h5>
                      {$childBoard->name}
                      {if(!empty($moderators))} {!printf('<small>' . $lang->forum->lblOwner . '</small>', $moderators)} {/if}
                      {if($childBoard->postedBy)}
                        <span class='card-footer small text-muted'>{!substr($childBoard->postedDate, 5, -3) . " {{$childBoard->postedByRealname}}"}</span>
                      {/if}
                    </h5>
                  </div>
                  {if($childBoard->desc)}
                  <div class='card-content text-muted text-smail'>{$childBoard->desc}</div>
                  {/if}
                </div>
                <div class='table-cell middle thumbnail-cell text-right'>
                  <div class='counter text-center'><div class='title text-danger'>{$childBoard->threads}</div><div class='caption text-muted small'>{$lang->forum->threadCount}</div></div>
                </div>
              </a>
            </div>
          {/foreach}
          </div>
        </div>
      </div>
    {/foreach}
  {/if}
</div>
<div class='block-region region-bottom blocks' data-region='forum_index-bottom'>{$control->loadModel('block')->printRegion($layouts, 'forum_index', 'bottom')}</div>
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
