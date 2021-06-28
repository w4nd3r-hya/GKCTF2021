{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The browse view file of article for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
{$path = array_keys($category->pathNames)}
{!js::import($jsRoot . 'cookie.js')}
{!js::set('path', $path)}
{!js::set('categoryID', $category->id)}
{!js::set('pageLayout', $control->block->getLayoutScope('article_browse', $category->id))}
{if(isset($articleList))}
  <script>{!echo "place" . md5(time()). "='" . $config->idListPlaceHolder . $articleList . $config->idListPlaceHolder . "';"}</script>
{else}
  <script>{!echo "place" . md5(time()) . "='" . $config->idListPlaceHolder . '' . $config->idListPlaceHolder . "';"}</script>
{/if}
<div class='block-region blocks region-top' data-region='article_browse-top'>{$control->loadModel('block')->printRegion($layouts, 'article_browse', 'top')}</div>
<div class='panel panel-section panel-category-article'>
  <div class='block-title vertical-center'>
    <strong class="vertical-center block-title-align">
      <span class='vertical-line'></span>
      <span class="block-title-text">{!$category->name}</span>
    </strong>
    <div class="order-time vertical-center">
      {$lang->article->orderBy->time}&nbsp;
      <div class="order-triangle">
        <span class="up-triangle"></span>
        <span class="down-triangle"></span>
      </div>
    </div>
    <div class="order-hot vertical-center">
      {$lang->article->orderBy->hot}&nbsp;
      <div class="order-triangle">
        <span class="up-triangle"></span>
        <span class="down-triangle"></span>
      </div>
    </div>
  </div>
  <div class='list' id='articles'>
    {$imageURL = !empty($content->imageSize) ? $content->imageSize . 'URL' : 'smallURL'}
    {@$i=0}
    {if($pageID > 1)}
    <div class='divider'></div>
    {/if}
    {foreach($articles as $article)}
      {@$i++}
      {$url = helper::createLink('article', 'view', "id=$article->id", "category={{$article->category->alias}}&name=$article->alias")}
      <div class='article-item vertical-center article-align'>
        {if($config->article->imagePosition == 'left' && !empty($article->image))}
        <div class='article-img left'>
          {$title = $article->image->primary->title ? $article->image->primary->title : $article->title}
          {$article->image->primary->objectType = 'article'}
          {!html::image($control->loadModel('file')->printFileURL($article->image->primary, 'smallURL'), "title='{{$title}}' class='thumbnail'")}
        </div>
        {/if}
        <div class="{if(empty($article->image))}article-content-height{else}article-content{/if}">
          <div class='vertical-start'>
            <strong class="article-title">
              {!html::a($url, $article->title, "style='color:{{$article->titleColor}}'")}
              {if($article->sticky && (!formatTime($article->stickTime) || $article->stickTime > date('Y-m-d H:i:s')))}<span class='text-danger'><i class="icon icon-arrow-up"></i></span> {/if}
            </strong>
          </div>
          <div class='article-ext'>
            <span class='views'>
              {$article->views}{$lang->article->views}
            </span>
            {if(commonModel::isAvailable('message'))}
            <span class='comments'>
              {!html::a($url, html::image($config->webRoot . 'theme/mobile/default/comments.png'))}&nbsp;{$article->comments}
            </span>
            {/if}
            <span class='pub-time'>
              {!formatTime($article->addedDate ,'publish')}
            </span>
          </div>
        </div>
        {if((empty($config->article->imagePosition) || $config->article->imagePosition == 'right') && !empty($article->image))}
        <div class='article-img'>
          {$title = $article->image->primary->title ? $article->image->primary->title : $article->title}
          {$article->image->primary->objectType = 'article'}
          {!html::image($control->loadModel('file')->printFileURL($article->image->primary, 'smallURL'), "title='{{$title}}' class='thumbnail'")}
        </div>
        {/if}
      </div>
      {if($i < count($articles))}
      <div class='divider'></div>
      {/if}
    {/foreach}
  </div>
</div>

{$pager->createPullUpJS('#articles', $lang->mobile->pullUpHint)}

<div class='block-region blocks region-bottom' data-region='article_browse-bottom'>{$control->loadModel('block')->printRegion($layouts, 'article_browse', 'bottom')}</div>

{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
