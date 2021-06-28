{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The latest article front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
/php*}
{$themeRoot = $model->config->webRoot . 'theme/'}

{$content  = json_decode($block->content)}
{$method   = 'get' . ucfirst(str_replace('article', '', strtolower($block->type)))}
{$articles = $model->loadModel('article')->$method(empty($content->category) ? 0 : $content->category, !empty($content->limit) ? $content->limit : 6)}
{if(isset($content->image))} {$articles = $model->loadModel('file')->processImages($articles, 'article')} {/if}
<div id="block{$block->id}" class='panel panel-block {$blockClass}'>
  <div class='panel-heading'>
    <strong>{!echo $icon . $block->title}</strong>
    {if(isset($content->moreText) and isset($content->moreUrl))}
      <div class='pull-right'>{!html::a($content->moreUrl, $content->moreText)}</div>
    {/if}
  </div>
  {if(isset($content->image))}
    {$pull     = $content->imagePosition == 'right' ? 'pull-right' : 'pull-left'}
    {$imageURL = !empty($content->imageSize) ? $content->imageSize . 'URL' : 'smallURL'}
    <div class='panel-body'>
      <div class='items'>
      {foreach($articles as $article)}
        {$url = helper::createLink('article', 'view', "id=$article->id", "category={{$article->category->alias}}&name=$article->alias")}
        <div class='item'>
          <div class='item-heading'>
            {$blod = ''}
            {if($article->sticky && (!formatTime($article->stickTime) || $article->stickTime > date('Y-m-d H:i:s')) and $article->stickBold)}
            {$blod = 'font-weight:bold;'}
            {/if}
            {if($article->sticky && (!formatTime($article->stickTime) || $article->stickTime > date('Y-m-d H:i:s')))} <span class='red'><i class="icon icon-arrow-up"></i></span>{/if}
            {if(isset($content->showCategory) and $content->showCategory == 1)}
              {if($content->categoryName == 'abbr')}
                {$blockContent    = json_decode($block->content)}
                {$blockCategories = ''}
                {if(isset($blockContent->category))} {$blockCategories = $blockContent->category} {/if}
         
                {$categoryName = $article->category->name}
                {foreach($article->categories as $id => $category)}
                  {if(strpos(",$blockCategories,", ",$id,") !== false)}
                    {$categoryName = $category->name}
                    {break}
                  {/if}
                {/foreach}
       
                {$categoryName = '[' . ($article->category->abbr ? $article->category->abbr : $categoryName) . '] '}
                {!html::a(helper::createLink('article', 'browse', "categoryID={{$article->category->id}}", "category={{$article->category->alias}}"), $categoryName)}
              {else}
                {!echo '[' . $article->category->name . '] '}
              {/if}
            {/if}
            <strong>{!html::a($url, $article->title, "style='color: {{$article->titleColor}}'")}</strong>
          </div>
          <div class='item-content'>
            
            <div class='text small text-muted'>
              <div class='media {$pull}' style="max-width: {!echo !empty($content->imageWidth) ? $content->imageWidth . 'px' : '100px'}">
              {if(!empty($article->image))}
                {$title = $article->image->primary->title ? $article->image->primary->title : $article->title}
                {$article->image->primary->objectType = 'article'}
                {!html::a($url, html::image($model->loadModel('file')->printFileURL($article->image->primary, $imageURL), "title='$title' class='thumbnail'" ))}
              {/if}
              </div>
              <strong class='text-important text-nowrap'>
                {if(isset($content->time))} <i class='icon-time'></i> {!formatTime($article->addedDate, DT_DATE4)} {/if}
              </strong>
              <span>{$article->summary}</span>
            </div>
          </div>
        </div>
      {/foreach}
      </div>
    </div>
  {else}
    <div class='panel-body'>
      <ul class='ul-list'>
        {foreach($articles as $article)}
          {$categoryAlias = isset($article->category->alias) ? $article->category->alias : ''}
          {$alias         = "category={{$categoryAlias}}&name={{$article->alias}}"}
          {$url           = helper::createLink('article', 'view', "id=$article->id", $alias)}
          {if(isset($content->time))}
            <li class='addDataList'>
              <span class='article-list'>
                {if(isset($content->showCategory) and $content->showCategory == 1)}
                  <span class='pull-left category'>
                  {if($content->categoryName == 'abbr')}
                    {$blockContent    = json_decode($block->content)}
                    {$blockCategories = ''}
                    {if(isset($blockContent->category))} {$blockCategories = $blockContent->category} {/if}
                    {$categoryName = ''}
                    {foreach($article->categories as $id => $categorie)}
                      {if(strpos(",$blockCategories,", ",$id,") !== false)}
                        {$categoryName = $categorie->name} {break}
                      {/if}
                    {/foreach}
                    {$categoryName = '[' . ($article->category->abbr ? $article->category->abbr : $categoryName) . '] '}
                    {!html::a(helper::createLink('article', 'browse', "categoryID={{$article->category->id}}", "category={{$categoryAlias}}"), $categoryName)}
                  {else}
                    {!html::a(helper::createLink('article', 'browse', "categoryID={{$article->category->id}}", "category={{$article->category->alias}}"), '[' . $article->category->name . '] ')}
                  {/if}
                  </span>
                {/if}

                {$bold = ''}
                {if($article->sticky && (!formatTime($article->stickTime) || $article->stickTime > date('Y-m-d H:i:s')) and $article->stickBold)}
                {$bold = 'font-weight:bold;'}
                {/if}
                {!html::a($url, $article->title, "title='{{$article->title}}' class='articleTitleA text-nowrap text-ellipsis pull-left' style='{{$bold}}color:{{$article->titleColor}}'")}
                <span class='pull-left sticky'>{if($article->sticky && (!formatTime($article->stickTime) || $article->stickTime > date('Y-m-d H:i:s')))}<span class='red'><i class="icon icon-arrow-up"></i></span>{/if}</span>
              </span>
              <span class='pull-right article-date'>{!substr($article->addedDate, 0, 10)}</span>
            </li>
          {else}
            <li class='notDataList'>
              {if(isset($content->showCategory) and $content->showCategory == 1)}
                <span class='pull-left category'>
                {if($content->categoryName == 'abbr')}
                  {$blockCntent     = json_decode($block->content)}
                  {$blockCategories = ''}
                  {if(isset($blockCntent->category))} {$blockCategories = $blockCntent->category} {/if}
                  {$categoryName = ''}
                  {foreach($article->categories as $id => $categorie)}
                    {if(strpos(",$blockCategories,", ",$id,") !== false)}
                      {$categoryName = $categorie->name} {break}
                    {/if}
                  {/foreach}
                  {$categoryName = '[' . ($article->category->abbr ? $article->category->abbr : $categoryName) . '] '}
                  {!html::a(helper::createLink('article', 'browse', "categoryID={{$article->category->id}}", "category={{$article->category->alias}}"), $categoryName)}
                {else}
                  {!html::a(helper::createLink('article', 'browse', "categoryID={{$article->category->id}}", "category={{$article->category->alias}}"), '[' . $article->category->name . '] ')}
                {/if}
                </span>
              {/if}

              {$bold = ''}
              {if($article->sticky && (!formatTime($article->stickTime) || $article->stickTime > date('Y-m-d H:i:s')) and $article->stickBold)}{$bold = 'font-weight:bold;'}{/if}
              {!html::a($url, $article->title, "title='{{$article->title}}' class='articleTitleB text-nowrap text-ellipsis pull-left' style='{{$bold}}color:{{$article->titleColor}}'")}
              <span class='pull-left sticky'>{if($article->sticky && (!formatTime($article->stickTime) || $article->stickTime > date('Y-m-d H:i:s')))}<span class='red'><i class="icon icon-arrow-up"></i></span>{/if}</span>
            </li>
          {/if}
        {/foreach}
      </ul>
    </div>
  {/if}
</div>
{noparse}
<style>
.ul-list .addDataList.withStick{padding-right:126px !important;}
.ul-list .addDataList.withoutStick{padding-right:80px !important;}
.ul-list .notDataList.withStick{padding-right:60px !important;}
.ul-list .notDataList.withoutStick{padding-right:5px !important;}
.articleTitleA{display:inline-block;}
.articleTitleB{display:inline-block;}
.sticky{padding-left: 5px;}
</style>
<script>
{/noparse}
var currentBlockID = {$block->id};

{noparse}
if(typeof($('#block' + currentBlockID).parent('.col').data('grid')) === 'undefined' && $('#block' + currentBlockID).parent('.col').data('probability') === 'undefined')
{
    var grid = $('#block' + currentBlockID).parents('.blocks').data('grid');
    grid = typeof(grid) == 'undefined' ? 12 : grid;

    $('#block' + currentBlockID).parent('.col').attr('data-grid', grid).attr('class', 'col col-' + grid);
}

$('.articleTitleA').each(function()
{
    $(this).css('max-width', $(this).parents('li').width() - $(this).prev('.category').width() - $(this).next('.sticky').width() - $(this).parent().next('.article-date').width() - 10);
})
$('.articleTitleB').each(function()
{
    $(this).css('max-width', $(this).parent('li').width() - $(this).next('.sticky').width() - 10);
})
</script>
{/noparse}
