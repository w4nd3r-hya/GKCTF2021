{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The index view file of blog for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
{if(!empty($category->id))} {!js::set('pageLayout', $control->block->getLayoutScope('blog_index', $category->id))} {/if}
{if(isset($articleIdList))}
  <script>{!echo "place" . md5(time()). "='" . $config->idListPlaceHolder . $articleIdList . $config->idListPlaceHolder . "';"}</script>
{else}
  <script>{!echo "place" . md5(time()) . "='" . $config->idListPlaceHolder . '' . $config->idListPlaceHolder . "';"}</script>
{/if}
<div class='block-region blocks region-top' data-region='blogbrowse-top'>{$control->loadModel('block')->printRegion($layouts, 'blog_index', 'top')}</div>
<div class='panel panel-section panel-category-article'>
  <div class='block-title vertical-center'>
    <strong class="vertical-center block-title-align">
      <span class='vertical-line'></span>
      <span class="block-title-text">{! isset($category) ? $category->name : $lang->blog->common}</span>
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
    {foreach($articles as $article)}
      {if(isset($pageID) and $pageID > 1)}
      <div class='divider'></div>
      {/if}
      {@$i++}
      {$url = helper::createLink('blog', 'view', "id=$article->id", "category={{$article->category->alias}}&name=$article->alias")}
      <div class='article-item vertical-center article-align'>
        <div class="article-content">
          <div class='vertical-start'>
            <strong class="article-title">
              <label class="label-hot vertical-center">{$lang->label->hot}</label>
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
              {$pubTime = strtotime($article->addedDate)}
              {$pubTimeLen = time() - $pubTime}
              {if($pubTimeLen > 86400)}
                {!substr($article->addedDate, 0, 10)}
              {else}
                {$minute = floor($pubTimeLen / 60)}
                {$hour = floor($pubTimeLen / 3600)}
                {if($hour == 0)}
                  {!$minute == 1 ? $lang->date->oneMinuteAgo : $minute . $lang->date->minutesAgo}
                {else}
                  {!$hour == 1 ? $lang->date->oneHourAgo : $hour . $lang->date->hoursAgo}
                {/if}
              {/if}
            </span>
          </div>
        </div>
        <div class='article-img'>
          {if(!empty($article->image))}
          {$title = $article->image->primary->title ? $article->image->primary->title : $article->title}
          {$article->image->primary->objectType = 'article'}
          {!html::image($control->loadModel('file')->printFileURL($article->image->primary, 'smallURL'), "title='{{$title}}' class='thumbnail'")}
          {/if}
        </div>
      </div>
      {if($i < count($articles))} <div class='divider'></div> {/if}
    {/foreach}
  </div>
</div>

{$pager->createPullUpJS('#articles', $lang->mobile->pullUpHint)}

<div class='block-region blocks region-bottom' data-region='blogbrowse-bottom'>{$control->loadModel('block')->printRegion($layouts, 'blog_index', 'bottom')}</div>

{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
