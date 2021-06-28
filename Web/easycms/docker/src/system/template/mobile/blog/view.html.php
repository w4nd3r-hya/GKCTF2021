{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The view file of article for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.simple')}
{include TPL_ROOT . 'common/files.html.php'}
{!js::set('path', $article->path)}
{!js::set('categoryID', $category->id)}
{!js::set('categoryPath', explode(',', trim($category->path, ',')))}
{!css::internal($article->css)}
{!js::execute($article->js)}
{!js::set('pageLayout', $control->block->getLayoutScope('article_view', $article->id))}
<div class='block-region region-article-view-top blocks' data-region='article_view-top'>{$control->loadModel('block')->printRegion($layouts, 'blog_view', 'top')}</div>
<div class="panel article-detail">
  <div class='article-heading'>
    <div class='article-title horizontal-center'>
      <h2>{$article->title}</h2>
    </div>
    <div class='caption text-muted vertical-center article-author'>
      <div class="avatar vertical-center">
        {if(empty($author->avatar))}
        <i class="icon icon-user icon-10x"></i>
        {else}
        <img src="{$author->avatar}" alt="">
        {/if}
      </div>
      <div class="article-ext">
        <span class="authorName">{$article->author}</span>
        <span class="addedDate">{!formatTime($article->addedDate)}</span>
      </div>
    </div>
  </div>
  <div class='article' id="article{$article->id}" data-ve='article'>
    {if($article->summary)}
      <section class='abstract hide bg-gray-pale small with-padding'><strong>{$lang->article->summary}</strong>{$lang->colon} {$article->summary}</section>
    {/if}
    <div class='article-content-section'>
      <section class='article-content'> {$article->content} </section>
    </div>
    {if(!empty($article->files))}
      <section class="article-files"> {$control->loadModel('file')->printFiles($article->files)} </section>
    {/if}
  </div>
  {@extract($prevAndNext)}
  <ul class='pager pager-justify'>
    {if($prev)}
      <li class='previous'>{!html::a(inlink('view', "id=$prev->id", "category={{$category->alias}}&name={{$prev->alias}}"), '<i class="icon-arrow-left"></i> ' . $lang->article->previous, "title='{{$prev->title}}'")}</li>
    {else}
      <li class='previous disabled'><a href='###'><i class='icon-arrow-left'></i> {!print($lang->article->none)}</a></li>
    {/if}
    {if($next)}
      <li class='next'>{!html::a(inlink('view', "id=$next->id", "category={{$category->alias}}&name={{$next->alias}}"), $lang->article->next . ' <i class="icon-arrow-right"></i>', "title='{{$next->title}}'")}</li>
    {else}
      <li class='next disabled'><a href='###'>{!print($lang->article->none)}<i class='icon-arrow-right'></i></a></li>
    {/if}
  </ul>
</div>

{if(commonModel::isAvailable('message'))}
  <div class='commentBox' id='commentBox'>
    {$control->fetch('message', 'comment', "objectType=article&objectID={{$article->id}}")}
  </div>
{/if}

<div class='block-region region-article-view-bottom blocks' data-region='article_view-bottom'>
  {$control->loadModel('block')->printRegion($layouts, 'blog_view', 'bottom')}
</div>
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
