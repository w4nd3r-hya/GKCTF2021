{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{$path=array_keys($category->pathNames)}
{!js::set('path', $path)}
{!js::set('categoryID', $category->id)}
{!js::set('pageLayout', $control->block->getLayoutScope('article_browse', $category->id))}
{$common->printPositionBar($category)}
{if(isset($articleList))}
  <script>{!echo "place" . md5(time()). "='" . $config->idListPlaceHolder . $articleList . $config->idListPlaceHolder . "';"}</script>
{else}
  <script>{!echo "place" . md5(time()) . "='" . $config->idListPlaceHolder . '' . $config->idListPlaceHolder . "';"}</script>
{/if}
<div class='row blocks' data-region='article_browse-topBanner'>{$control->block->printRegion($layouts, 'article_browse', 'topBanner', true)}</div>
<div class='row' id='columns' data-page='article_browse'>
  {if(!empty($layouts['article_browse']['side']) and !empty($sideFloat) && $sideFloat != 'hidden')}
  <div class="col-md-{!echo 12 - $sideGrid} col-main{!echo ($sideFloat === 'left') ? ' pull-right' : '' }" id="mainContainer">
  {else}
  <div class="col-md-12" id="mainContainer">
  {/if}
    <div class='list list-condensed' id='articleList'>
    <div class='row blocks' data-region='article_browse-top'>{$control->block->printRegion($layouts, 'article_browse', 'top', true)}</div>
      <header id='articleHeader'>
        <h2>{$category->name}</h2>
        <div class='header'>{!html::a('javascript:;', $lang->article->orderBy->time, "data-field='addedDate' class='addedDate setOrder'")}</div>
        <div class='header'>{!html::a('javascript:;', $lang->article->orderBy->hot, "data-field='views' class='views setOrder'")}</div>
      </header>
      <section class='items items-hover' id='articles'>
        {foreach($articles as $article)}
          {$stick = isset($sticks[$article->id]) ? true : false}
          {$url = inlink('view', "id=$article->id", "category={{$article->category->alias}}&name=$article->alias")}
          <div class='item' id="article{$article->id}" data-ve='article'>
            {if(!empty($article->image))}
              {$pull     = (isset($control->config->article->imagePosition) and $control->config->article->imagePosition == 'left') ? 'pull-left' : 'pull-right'}
              {$imageURL = !empty($control->config->article->imageSize) ? $control->config->article->imageSize . 'URL' : 'smallURL'}
              <div class='media {$pull}'>
                {$maxWidth = !empty($control->config->article->imageWidth) ? $control->config->article->imageWidth . 'px' : '120px'}
                {$title    = $article->image->primary->title ? $article->image->primary->title : $article->title}
                {$article->image->primary->objectType = 'article'}
                {!html::a($url, html::image($control->loadModel('file')->printFileURL($article->image->primary, 'smallURL'), "title='$title' style='max-width:$maxWidth' class='thumbnail'"))}
              </div>
            {/if}
            <div class='item-heading'>
              <div class="text-muted pull-right">
                <span title="{!echo $config->viewsPlaceholder . $article->id . $config->viewsPlaceholder}"><i class='icon-eye-open'></i> {!echo $config->viewsPlaceholder . $article->id . $config->viewsPlaceholder}</span> &nbsp;
                {if(commonModel::isAvailable('message') and $article->comments)}<span title="{$lang->article->comments}"><i class='icon-comments-alt'></i> {$article->comments}</span> &nbsp;{/if}
                <span title="{$lang->article->addedDate}"><i class='icon-time'></i> {!substr($article->addedDate, 0, 10)}</span>
              </div>
              <h4>
                {!echo empty($article->titleColor) ? html::a($url, $article->title) : html::a($url, $article->title, "style='color:$article->titleColor;'")}
                {if($stick)}<span class='label label-danger'>{$lang->article->stick}</span>{/if}
              </h4>
            </div>
            <div class='item-content'>
              <div class='text text-muted'>{!helper::substr($article->summary, 120, '...')}</div>
            </div>
          </div>
        {/foreach}
      </section>
      <footer class='clearfix'>{$pager->show('right', 'short')}</footer>
    </div>
    <div class='row blocks' data-region='article_browse-bottom'>{$control->block->printRegion($layouts, 'article_browse', 'bottom', true)}</div>
  </div>
  {if(!empty($layouts['article_browse']['side']) and !(empty($sideFloat) || $sideFloat === 'hidden'))}
    <div class='col-md-{$sideGrid } col-side'><side class='page-side blocks' data-region='article_browse-side'>{$control->block->printRegion($layouts, 'article_browse', 'side')}</side></div>
  {/if}
</div>
<div class='row blocks' data-region='article_browse-bottomBanner'>{$control->block->printRegion($layouts, 'article_browse', 'bottomBanner', true)}</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
