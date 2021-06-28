{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The page list front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
*}
{* Decode the content and get pages. *}
{$content = json_decode($block->content)}
{$pages   = $model->loadModel('article')->getPageList($content->limit)}
{if(isset($content->image))} {$pages = $model->loadModel('file')->processImages($pages, 'page')} {/if}

<div id="block{!echo $block->id}" class='panel panel-block {!echo $blockClass}'>
  <div class='panel-heading'>
    <strong>{!echo $icon . $block->title}</strong>
    {if(!empty($content->moreText) and !empty($content->moreUrl))}
    <div class='pull-right'>{!html::a($content->moreUrl, $content->moreText)}</div>
    {/if}
  </div>
  {if(isset($content->image))}
    {$pull     = $content->imagePosition == 'right' ? 'pull-right' : 'pull-left'}
    {$imageURL = !empty($content->imageSize) ? $content->imageSize . 'URL' : 'smallURL'}
    <div class='panel-body'>
      <div class='items'>
      {foreach($pages as $page)}
      {$url = helper::createLink('page', 'view', "id=$page->id", "name=$page->alias")}
      <div class='item'>
        <div class='item-heading'><strong>{!html::a($url, $page->title, "style='color:{{$page->titleColor}}'")}</strong></div>
        <div class='item-content'>
          
          <div class='text small text-muted'>
            <div class='media {!echo $pull}' style="max-width: {!echo !empty($content->imageWidth) ? $content->imageWidth . 'px' : '60px'}">
            {if(!empty($page->image))}
              {$title = $page->image->primary->title ? $page->image->primary->title : $page->title}
              {$page->image->primary->objectType = 'article'}
              {!html::a($url, html::image($model->loadModel('file')->printFileURL($page->image->primary, $imageURL), "title='$title' class='thumbnail'" ))}
            {/if}
            </div>
            <strong class='text-important text-nowrap'>
              {if(isset($content->time))} {!echo "<i class='icon-time'></i> " . formatTime($page->addedDate, DT_DATE4)} {/if}
            </strong> 
            &nbsp;{!echo $page->summary}
          </div>
        </div>
      </div>
      {/foreach}
      </div>
    </div>
  {else}
    <div class='panel-body'>
      <ul class='ul-list'>
        {foreach($pages as $page)}
          {$url = helper::createLink('page', 'view', "id={{$page->id}}", "name={{$page->alias}}")}
          {if(isset($content->time))}
          <li>
            {!html::a($url, $page->title, "title='{{$page->title}}' style='color:{{$page->titleColor}}'")}
            <span class='pull-right'>{!substr($page->addedDate, 0, 10)}</span>
          </li>
          {else}
            <li>{!html::a($url, $page->title, "title='{{$page->title}}' style='color:{{$page->titleColor}}'")}</li>
          {/if}
        {/foreach}
      </ul>
    </div>
  {/if}
</div>
