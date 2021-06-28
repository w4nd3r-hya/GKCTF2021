{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{!js::set('path', $article->path)}
{!js::set('objectType', 'article')}
{!js::set('objectID', $article->id)}
{!js::set('categoryID', $category->id)}
{!js::set('categoryPath', explode(',', trim($category->path, ',')))}
{if(isset($article->css))} {!css::internal($article->css)} {/if}
{if(isset($article->js))} {!js::execute($article->js)} {/if}
{!js::set('pageLayout', $control->block->getLayoutScope('article_view', $article->id))}
{$common->printPositionBar($category, $article)}
<div class='row blocks' data-region='article_view-topBanner'>{$control->block->printRegion($layouts, 'article_view', 'topBanner', true)}</div>
<div class='row' id='columns' data-page='article_view'>
{if(!empty($layouts['article_view']['side']) and !empty($sideFloat) && $sideFloat != 'hidden')}
  <div class="col-md-{!echo 12 - $sideGrid} col-main{!echo ($sideFloat === 'left') ? ' pull-right' : ''}">
{else}
  <div class='col-md-12'>
{/if}
    <div class='row blocks' data-region='article_view-top'>{$control->block->printRegion($layouts, 'article_view', 'top', true)}</div>
    <div class='article' id='article' data-id='{$article->id}'>
      <header>
        <h1>{$article->title}</h1>
        <dl class='dl-inline'>
          <dd data-toggle='tooltip' data-placement='top' data-original-title='{!printf($lang->article->lblAddedDate, formatTime($article->addedDate))}'><i class='icon-time icon-large'></i> {!formatTime($article->addedDate)}</dd>
          <dd data-toggle='tooltip' data-placement='top' data-original-title='{!printf($lang->article->lblAuthor, $article->author)}'><i class='icon-user icon-large'></i> {$article->author}</dd>
          {if($article->source != 'original' and $article->copyURL != '')}
            <dt>{!echo $lang->article->sourceList[$article->source] . $lang->colon}</dt>
            {if($article->source == 'article')}{$article->copyURL = $sysURL . $control->article->createPreviewLink($article->copyURL)}{/if}
            <dd>{!echo $article->copyURL ? html::a($article->copyURL, $article->copySite, "target='_blank'") : $article->copySite}</dd>
          {else}
            <span class='label label-success'>{$lang->article->sourceList[$article->source]}</span>
          {/if}
          <dd class='pull-right'>
            {if(!empty($control->config->oauth->sina))}
              {$sina = json_decode($control->config->oauth->sina)}
              {if(isset($sina->widget))} <div class='sina-widget'>{$sina->widget}</div> {/if}
            {/if}
            <span class='label label-warning' data-toggle='tooltip' data-placement='top' data-original-title='{!printf($lang->article->lblViews, $config->viewsPlaceholder)}'><i class='icon-eye-open'></i> {$config->viewsPlaceholder}</span>
          </dd>
        </dl>
        {if($article->summary)}
          <section class='abstract'><strong>{$lang->article->summary}</strong>{!echo $lang->colon . $article->summary}</section>
        {/if}
      </header>
      <section class='article-content'>
        {$article->content}
      </section>
      {if(!empty($article->files))}
        <section class="article-files">
          {$control->loadModel('file')->printFiles($article->files)}
        </section>
      {/if}
      <footer>
        <div class='article-moreinfo clearfix'>
          {if($article->editor)}
            {$editor = $control->loadModel('user')->getByAccount($article->editor)}
            {if(!empty($editor))} <p class='text-right pull-right'>{!printf($lang->article->lblEditor, $editor->realname, formatTime($article->editedDate))}</p> {/if}
          {/if}
          {if($article->keywords)} <p class='small'><strong class="text-muted">{$lang->article->keywords}</strong><span class="article-keywords">{!echo $lang->colon . $article->keywords}</span></p> {/if}
        </div>
        {@extract($prevAndNext)}
        <ul class='pager pager-justify'>
        {if($prev)}
          <li class='previous' title='{$prev->title}'>{!html::a(inlink('view', "id=$prev->id", "category={{$category->alias}}&name={{$prev->alias}}"), '<i class="icon-arrow-left"></i> <span>' . $prev->title . '</span>')}</li>
        {else}
          <li class='preious disabled'><a href='###'><i class='icon-arrow-left'></i> {!print($lang->article->none)}</a></li>
        {/if}
        {if($next)}
          <li class='next' title='{$next->title}'>{!html::a(inlink('view', "id=$next->id", "category={{$category->alias}}&name={{$next->alias}}"), '<span>' . $next->title . '</span> <i class="icon-arrow-right"></i>')}</li>
        {else}
          <li class='next disabled'><a href='###'> {!print($lang->article->none)}<i class='icon-arrow-right'></i></a></li>
        {/if}
        </ul>
      </footer>
    </div>
    <div class='row blocks' data-region='article_view-bottom'>{$control->block->printRegion($layouts, 'article_view', 'bottom', true)}</div>
    {if(commonModel::isAvailable('message'))}
    <div id='commentBox'>
      {$control->fetch('message', 'comment', "objectType=article&objectID=$article->id")}
    </div>
    {/if}
  </div>
  {if(!empty($layouts['article_view']['side']) and !(empty($sideFloat) || $sideFloat === 'hidden'))} <div class='col-md-{$sideGrid} col-side'><side class='page-side blocks' data-region='article_view-side'>{$control->block->printRegion($layouts, 'article_view', 'side')}</side></div> {/if}
</div>
<div class='row blocks' data-region='article_view-bottomBanner'>{$control->block->printRegion($layouts, 'article_view', 'bottomBanner', true)}</div>
{if(strpos($article->content, '<embed') !== false)}
  {include TPL_ROOT . 'common/video.html.php'}
{/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
