{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The view file of blog view method of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
*}
{include $control->loadModel('ui')->getEffectViewFile('default', 'blog', 'header')}
{$path = !empty($category->pathNames) ? array_keys($category->pathNames) : array()}
{!js::set('path', $path)}
{!js::set('categoryID', $category->id)}
{!js::set('objectType', 'article')}
{!js::set('objectID', $article->id)}
{if(isset($article->css))} {!css::internal($article->css)}  {/if}
{if(isset($article->js))}  {!js::execute($article->js)}     {/if}
{!js::set('pageLayout', $control->block->getLayoutScope('blog_view', $article->id))}
{$root = '<li>' . $control->lang->currentPos . $control->lang->colon .  html::a($control->inlink('index'), $lang->blog->home) . '</li>'}
{$common->printPositionBar($category, $article, '', $root)}
<div class='row blocks' data-region='blog_view-topBanner'>{$control->block->printRegion($layouts, 'blog_view', 'topBanner', true)}</div>
<div class='row' id='columns' data-page='blog_view'>
  {if(!empty($layouts['blog_view']['side']) and !empty($sideFloat) && $sideFloat != 'hidden')} 
    <div class="col-md-{!echo 12 - $sideGrid} col-main{!echo ($sideFloat === 'left') ? 'pull-right' : ''}">
  {else}
    <div class="col-md-12">
  {/if}
    <div class='row blocks' data-region='blog_view-top'>{$control->block->printRegion($layouts, 'blog_view', 'top', true)}</div>
    <div class='article' id='blog' data-id='{!echo $article->id}'>
      <header>
        <h1>{!echo $article->title}</h1>
        <dl class='dl-inline'>
          <dd data-toggle='tooltip' data-placement='top' data-original-title='{!printf($lang->article->lblAddedDate, formatTime($article->addedDate))}'><i class="icon-time icon-large"></i> {!echo formatTime($article->addedDate)}</dd>
          <dd data-toggle='tooltip' data-placement='top' data-original-title='{!printf($lang->article->lblAuthor, $article->author)}'><i class='icon-user icon-large'></i> {!echo $article->author}</dd>
          {if($article->source and $article->source != 'original' and $article->copyURL != '')}
            <dt>{!echo $lang->article->lblSource}</dt>
          {/if}
          {if($article->source == 'article')}
            {$article->copyURL = commonModel::getSysURL() . $control->article->createPreviewLink($article->copyURL)}
            <dd>{!echo $article->copyURL ? html::a($article->copyURL, $article->copySite, "target='_blank'") : $article->copySite}</dd>
          {/if}
          {if($article->source == 'copied')}
            <dd>{!echo $article->copyURL ? html::a($article->copyURL, $article->copySite, "target='_blank'") : $article->copySite}</dd>
          {/if}
          <dd class='pull-right'>
            {if(!empty($control->config->oauth->sina))}
                {$sina = json_decode($control->config->oauth->sina)}
                {if($sina->widget)} {!echo "<div class='sina-widget'>" . $sina->widget . '</div>'} {/if}
            {/if}
            {if($article->source)}<span class='label label-success'>{!echo $lang->article->sourceList[$article->source]}</span>{/if}
            <span class='label label-warning' data-toggle='tooltip' data-placement='top' data-original-title='{!printf($lang->article->lblViews, $config->viewsPlaceholder)}'><i class='icon-eye-open'></i> {!echo $config->viewsPlaceholder}</span>
          </dd>
        </dl>
        {if($article->summary)}
          <section class='abstract'><strong>{!echo $lang->article->summary}</strong>{!echo $lang->colon . $article->summary}</section>
        {/if}
      </header>
      <section class='article-content'>
        {!echo $article->content}
      </section>
      <section>
        {$control->loadModel('file')->printFiles($article->files)}
      </section>
      <footer>
        {if($article->keywords)}
          <p class='small'><strong class='text-muted'>{!echo $lang->article->keywords}</strong><span class='article-keywords'>{!echo $lang->colon . $article->keywords}</span></p>
        {/if}
        {@extract($prevAndNext)}
        <ul class='pager pager-justify'>
          {if($prev)}
            <li class='previous'>{!html::a(inlink('view', "id=$prev->id", "category={{$category->alias}}&name={{$prev->alias}}"), '<i class="icon-arrow-left"></i> ' . $prev->title)}</li>
          {else}
            <li class='preious disabled'><a href='###'><i class='icon-arrow-left'></i> {!print($lang->article->none)}</a></li>
          {/if}
          {if($next)}
            <li class='next'>{!html::a(inlink('view', "id=$next->id", "category={{$category->alias}}&name={{$next->alias}}"), $next->title . ' <i class="icon-arrow-right"></i>')}</li>
          {else}
            <li class='next disabled'><a href='###'> {!print($lang->article->none)}<i class='icon-arrow-right'></i></a></li>
          {/if}
        </ul>
      </footer>
    </div>
    {if(commonModel::isAvailable('message'))}
      <div id='commentBox'>
        {!echo $control->fetch('message', 'comment', "objectType=article&objectID=$article->id")}
      </div>
    {/if}
    <div class='row blocks' data-region='blog_view-bottom'>{$control->block->printRegion($layouts, 'blog_view', 'bottom', true)}</div>
  </div>
  {if(!empty($layouts['blog_view']['side']) and !(empty($sideFloat) || $sideFloat === 'hidden'))}
  <div class='col-md-{!echo $sideGrid} col-side'>
    <side class='page-side'>
      <div class='blocks' data-region='blog_view-side'>{$control->block->printRegion($layouts, 'blog_view', 'side')}</div>
    </side>
  </div>
  {/if}
</div>
<div class='row'>{$control->block->printRegion($layouts, 'blog_view', 'bottomBanner', true)}</div>
{if(strpos($article->content, '<embed ') !== false)} {!include TPL_ROOT . 'common/video.html.php'} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'blog', 'footer')}
