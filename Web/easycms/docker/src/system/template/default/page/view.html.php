{if(!defined("RUN_MODE"))} {!die()} {/if}
{if($page->onlyBody)}
  {include TPL_ROOT . 'common/header.lite.html.php'}
  {!js::set('pageID', $page->id)}
  {!css::internal($page->css)}
  {!js::execute($page->js)}
  {!echo $page->content}
{else}
  {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
  {!js::set('pageID', $page->id)}
  {!css::internal($page->css)}
  {!js::execute($page->js)}
  {!js::set('pageLayout', $control->block->getLayoutScope('page_view', $page->id))}
  {$common->printPositionBar($page)}
  <div class='row blocks' data-region='page_view-topBanner'>{$control->block->printRegion($layouts, 'page_view', 'topBanner', true)}</div>
  <div class='row' id='columns' data-page='page_view'>
    {if(!empty($layouts['page_view']['side']) and !empty($sideFloat) && $sideFloat != 'hidden')}
      <div class="col-md-{!echo 12 - $sideGrid} col-main{if($sideFloat === 'left')} pull-right {/if}">
    {else}
      <div class="col-md-12">
    {/if}
      <div class='row blocks' data-region='page_view-top'>{$control->block->printRegion($layouts, 'page_view', 'top', true)}</div>
      <div class='article' id='page{!echo $page->id}' data-ve='page'>
        <header>
          <h1>{!echo $page->title}</h1>
        </header>
        <section class='article-content'>
          {!echo $page->content}
        </section>
        {if(!empty($page->files))}
        <section>{$control->loadModel('file')->printFiles($page->files)}</section>
        {/if}
        {if($page->keywords)}
        <footer>
          <p class='small'><strong class="text-muted">{!echo $lang->article->keywords}</strong><span class="article-keywords">{!echo $lang->colon . $page->keywords}</span></p>
        </footer>
        {/if}
      </div>
      <div class='row blocks' data-region='page_view-bottom'>{$control->block->printRegion($layouts, 'page_view', 'bottom', true)}</div>
    </div>
    {if(!empty($layouts['page_view']['side']) and !(empty($sideFloat) || $sideFloat === 'hidden'))}
    <div class='col-md-{!echo $sideGrid} col-side'><side class='page-side blocks blocks' data-region='page_view-side'>{$control->block->printRegion($layouts, 'page_view', 'side')}</side></div>
    {/if}
  </div>
  <div class='row blocks' data-region='page_view-bottomBanner'>{$control->block->printRegion($layouts, 'page_view', 'bottomBanner', true)}</div>
  {if(strpos($page->content, '<embed ') !== false)} {include TPL_ROOT . 'common/video.html.php'} {/if}
  {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
{/if}
