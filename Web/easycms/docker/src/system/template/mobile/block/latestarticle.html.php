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
{$articles = $model->loadModel('article')->$method(empty($content->category) ? 0 : $content->category, $content->limit)}
{$articles = $model->loadModel('article')->computeComments($articles)}
{if(isset($content->image))} {$articles = $model->loadModel('file')->processImages($articles, 'article')} {/if}
<style>
#block{$block->id} .card .thumbnail-cell {padding-left: 8px; padding-right: 0}
#block{$block->id} .card .table-cell + .thumbnail-cell {padding-right: 8px; padding-left: 0}
</style>
<div id="block{$block->id}" class='panel panel-block {$blockClass} block{$block->id}'>
  <div class='panel-body'>
    <div class='block-title'>
      <strong class="vertical-center block-title-align">
        {if(empty($icon))}
        <span class='vertical-line'></span>
        {else}
        {$icon}
        {/if}
        <span class="block-title-text">{!$block->title}</span>
      </strong>
      {if(isset($content->moreText) and isset($content->moreUrl))}
      <div class='pull-right'>{!html::a($content->moreUrl, $content->moreText)}</div>
      {/if}
    </div>
    <div class='list'>
    {if(isset($content->image))}
      {$imageURL = !empty($content->imageSize) ? $content->imageSize . 'URL' : 'smallURL'}
      {@$i=0}
      {foreach($articles as $article)}
        {@$i++}
        {$url = helper::createLink('article', 'view', "id=$article->id", "category={{$article->category->alias}}&name=$article->alias")}
        <div class='article-item vertical-center article-align'>
          {if($content->imagePosition == 'left' && !empty($article->image))}
          <div class='article-img'>
            {$thumbnailTitle = $article->image->primary->title ? $article->image->primary->title : $article->title}
            {$article->image->primary->objectType = 'article'}
            {$thumbnailLink = html::a($url, html::image($model->loadModel('file')->printFileURL($article->image->primary, $imageURL), "title='{{$thumbnailTitle}}' class='thumbnail'" ))}
            {$thumbnail = "<div class='table-cell thumbnail-cell' style='max-width: 100%;'>{{$thumbnailLink}}</div>"}
            {$thumbnail}
          </div>
          {/if}
          <div class="{if(empty($article->image))}article-content-height{else}article-content{/if}">
            <div class='vertical-start'>
              <strong class="article-title">
                {if($i==1)}
                <label class="label-hot vertical-center">
                  {if($method == 'getLatest')}
                    {$lang->label->latest}
                  {else}
                    {$lang->label->hot}
                  {/if}
                </label>
                {/if}
                {!html::a($url, $article->title, "style='color:{{$article->titleColor}}'")}
                {if($article->sticky && (!formatTime($article->stickTime) || $article->stickTime > date('Y-m-d H:i:s')))}
                  <span class='text-danger'><i class="icon icon-arrow-up"></i></span>
                {/if}
              </strong>
            </div>
            <div class='article-ext'>
              <span class='views'>
                {$article->views}{$lang->article->views}
              </span>
              <span class='comments'>
                {!html::a($url, html::image($config->webRoot . 'theme/mobile/default/comments.png'))}&nbsp;{$article->comments}
              </span>
              {if(isset($content->showCategory) and $content->showCategory == 1)}
              <span class="category">
                {if($content->categoryName == 'abbr')}
                  {$categoryName = $article->category->abbr ? $article->category->abbr : $article->category->name}
                  {!html::a(helper::createLink('article', 'browse', "categoryID={{$article->category->id}}", "category={{$article->category->alias}}"), $categoryName)}
                {else}
                  {$article->category->name}
                {/if}
              </span>
              {/if}
            </div>
          </div>
          {if($content->imagePosition == 'right' && !empty($article->image))}
          <div class='article-img'>
            {$thumbnailTitle = $article->image->primary->title ? $article->image->primary->title : $article->title}
            {$article->image->primary->objectType = 'article'}
            {$thumbnailLink = html::a($url, html::image($model->loadModel('file')->printFileURL($article->image->primary, $imageURL), "title='{{$thumbnailTitle}}' class='thumbnail'" ))}
            <div class='table-cell thumbnail-cell' style='max-width: 100%;'>{$thumbnailLink}</div>
          </div>
          {/if}
        </div>
        {if($i < count($articles))} <div class='divider'></div> {/if}
      {/foreach}
    {else}
      {@$i=0}
      {foreach($articles as $article)}
        {@$i++}
        {$url = helper::createLink('article', 'view', "id=$article->id", "category={{$article->category->alias}}&name=$article->alias")}
        <div class='article-item vertical-center article-align'>
          <div class="article-content-height">
            <div class='vertical-start'>
              <strong class="article-title">
                {if($i==1)}
                <label class="label-hot vertical-center">
                  {if($method == 'getLatest')}
                    {$lang->label->latest}
                  {else}
                    {$lang->label->hot}
                  {/if}
                </label>
                {/if}
                {!html::a($url, $article->title, "style='color:{{$article->titleColor}}'")}
                {if($article->sticky && (!formatTime($article->stickTime) || $article->stickTime > date('Y-m-d H:i:s')))}
                <span class='text-danger'><i class="icon icon-arrow-up"></i></span>
                {/if}
              </strong>
            </div>
            <div class='article-ext'>
              <span class='views'>
                {$article->views}{$lang->article->views}
              </span>
              <span class='comments'>
                {!html::a($url, html::image($config->webRoot . 'theme/mobile/default/comments.png'))}&nbsp;{$article->comments}
              </span>
              {if(isset($content->showCategory) and $content->showCategory == 1)}
              <span class="category">
                {if($content->categoryName == 'abbr')}
                  {$categoryName = $article->category->abbr ? $article->category->abbr : $article->category->name}
                  {!html::a(helper::createLink('article', 'browse', "categoryID={{$article->category->id}}", "category={{$article->category->alias}}"), $categoryName)}
                {else}
                  {$article->category->name}
                {/if}
              </span>
              {/if}
            </div>
          </div>
        </div>
        {if($i < count($articles))}
        <div class='divider'></div>
        {/if}
      {/foreach}
    {/if}
    </div>
  </div>
</div>

<style>
  .block{$block->id} {
    border-radius: 4px;
    padding: 13px 10px;
  }

  .block{$block->id} .panel-body {
    padding: 0 0;
  }

  .block{$block->id} .vertical-center {
    display: flex;
    display: -webkit-flex;
    align-items: center;
  }

  .block{$block->id} .vertical-start {
    display: flex;
    display: -webkit-flex;
    align-items: flex-start;
  }

  .block{$block->id} .vertical-line {
    float: left;
    width: 2px;
    height: 14px;
    background: #3C77FE;
  }

  .block{$block->id} .block-title-text {
    font-size: 16px;
    margin-left: 3px;
  }

  .block{$block->id} .block-title-align {
    justify-content: flex-start;
  }

  .block{$block->id} .article-item {
    margin: 12px 0 12px 0;
    line-height: 22px;
  }

  .block{$block->id} .divider {
    height: 1px;
    width: 100%;
    background-color: #e5e5e5;
  }

  .block{$block->id} .article-align {
    justify-content: space-between;
  }

  .block{$block->id} .article-title {
    margin: -4px 7px 0 0;
    font-size: 14px;
  }

  .block{$block->id} .article-content {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    min-height: 78px;
    width: 100%;
  }
  .block{$block->id} .article-content-height {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    width: 100%;
    min-height: 40px;
  }

  .block{$block->id} .article-ext {
    margin-bottom: -6px;
  }

  .block{$block->id} .article-img {
    margin-right: 10px;
  }

  .block{$block->id} .article-img img{
    max-width: unset;
    width: 104px;
    height: 78px;
    border-radius: 3px;
  }

  .block{$block->id} .label-hot {
    height: 14px;
    border-radius: 2px;
    background-color: #F73035;
    font-size: 12px;
    color: #ffffff;
    text-align: center;
    display: inline-flex;
  }

  .block{$block->id} .views {
    font-size: 12px;
    color: #EF7340;
  }

  .block{$block->id} .comments {
    margin-left: 19px;
    font-size: 12px;
  }

  .block{$block->id} .comments img {
    width: 12px;
    height: 12px;
    margin-bottom: 2px;
  }

  .block{$block->id} .category {
    padding: 2px 3px;
    border-radius: 2px;
    margin-left: 15px;
    color: #0049FF;
    font-size: 12px;
    text-align: center;
  }

  .block{$block->id} .category a{
    color: #0049FF;
  }
</style>
