{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
 * The page list front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
/php*}
{* Decode the content and get pages. *}
{$content = json_decode($block->content)}
{$pages   = $model->loadModel('article')->getPageList($content->limit)}
<div id="block{$block->id}" class='panel panel-block {$blockClass}'>
  <div class='panel-heading'>
    <strong>{!echo $icon . $block->title}</strong>
    {if(!empty($content->moreText) and !empty($content->moreUrl))}
      <div class='pull-right'>{!html::a($content->moreUrl, $content->moreText)}</div>
    {/if}
  </div>
  {if(isset($content->image))}
    <div class='panel-body no-padding'>
      <div class='cards condensed cards-list'>
      {foreach($pages as $page)}
        {$url = helper::createLink('page', 'view', "id=$page->id", "name=$page->alias")}
        <a class='card' href='{$url}'>
          <div class='card-heading' style='color:{$page->titleColor}'><strong>{$page->title}</strong></div>
          <div class='table-layout'>
            <div class='table-cell'>
              <div class='card-content text-muted small'>
                <strong class='text-important'>
                  {if(isset($content->time))} 
                    {!echo "<i class='icon-time'></i>" . formatTime($page->addedDate, DT_DATE4)}
                  {/if}
                </strong> &nbsp;
                {$page->summary}
              </div>
            </div>
            {if(!empty($page->image))}
              <div class='table-cell thumbnail-cell'>
                {$title = $page->image->primary->title ? $page->image->primary->title : $page->title}
                {$page->image->primary->objectType = 'article'}
                {!html::image($model->loadModel('file')->printFileURL($page->image->primary, 'smallURL'), "title='$title' class='thumbnail'" )}
              </div>
            {/if}
          </div>
        </a>
      {/foreach}
      </div>
    </div>
  {else}
    <div class='panel-body no-padding'>
      <div class='list-group simple'>
        {foreach($pages as $page)}
          {$url = helper::createLink('page', 'view', "id=$page->id", "name=$page->alias")}
          {if(isset($content->time))}
            <div class='list-group-item'>
              {!html::a($url, $page->title, "title='$page->title' style='color:{{$page->titleColor}}'")}
              <span class='pull-right text-muted'>{!substr($page->addedDate, 0, 10)}</span>
            </div>
          {else}
            <div class='list-group-item'>{!html::a($url, $page->title, "title='{{$page->title}}' style='color:{{$page->titleColor}}'")}</div>
          {/if}
        {/foreach}
      </div>
    </div>
  {/if}
</div>
