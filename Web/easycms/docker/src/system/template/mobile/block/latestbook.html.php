{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The latest book view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
/php*}
{$content = json_decode($block->content)}
{$orderBy = $content->sort == 'order' ? 'order' : 'addedDate_desc'}
{$books   = $model->loadModel('book')->getLatestBookList($content->limit, $orderBy)}
<div id="block{$block->id}" class="panel-cards panel panel-block {$blockClass}">
  <div class='panel-heading'>
    <strong>{$icon} {$block->title}</strong>
    {if(isset($content->moreText) and isset($content->moreUrl))}
      <div class='pull-right'>{!html::a($content->moreUrl, $content->moreText)}</div>
    {/if}
  </div>
  {if($content->showType == 'block')}
    <div class='panel-body'>
      <div class='cards cards-custom'>
        {foreach($books as $book)}
          {$recPerRow = $content->recPerRow}
          <div class='pull-left with-padding' style="width:{!echo 100 / $recPerRow}%" data-recperrow="{$recPerRow}">
            <div class='card with-margin'>
              <div class='card-heading text-center'>
                {!html::a(helper::createLink('book', 'browse', "nodeID=$book->id", "book=$book->alias") . ($model->get->fullScreen ? "?fullScreen={{$model->get->fullScreen}}" : ''), $book->title)}
              </div>
              <div class='card-content text-muted text-center'>{!strip_tags(htmlspecialchars_decode($book->content))}</div>
              <div class='card-actions'>
                <span class='text-muted'><i class='icon-user'></i> {$book->author}</span>
                <span class='text-muted'><i class='icon-time'></i> {!formatTime($book->addedDate, 'Y-m-d')}</span>
              </div>
            </div>
          </div>
        {/foreach}
      </div>
    </div>
  {else}
    <div class='panel-body'>
      <div class='list-group simple'>
        {foreach($books as $book)}
          <div class='list-group-item'>
            {!html::a(helper::createLink('book', 'browse', "nodeID=$book->id", "book=$book->alias"), $book->title)}
            <span class='pull-right text-muted'>{!substr($book->addedDate, 0, 10)}</span>
          </div>
        {/foreach}
      </div>
    </div>
  {/if}
</div>

{if($content->showType == 'block')}
<style>
.card .card-heading{height: 100px; font-size: 15px; white-space: normal; display: table; width: 100%;}
.card .card-heading a{display: table-cell; vertical-align: middle;}
.card-content{height: 80px;}
.card-actions{position: relative; bottom:5px; left: 5px;}
</style>
{/if}
