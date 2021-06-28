{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{$path = isset($category->pathNames) ? array_keys($category->pathNames) : array(0)}
{!js::set('path', $path)}
{!js::set('categoryID', $category->id)}
{!js::set('pageLayout', $control->block->getLayoutScope('product_browse', $category->id))}
{$common->printPositionBar($category, isset($product) ? $product : '')}
{!js::set('defaultMode', $config->product->browseType)}
{if(isset($productList))}
  <script>{!echo "place" . md5(time()). "='" . $config->idListPlaceHolder . $productList. $config->idListPlaceHolder . "';"}</script>
{else}
  <script>{!echo "place" . md5(time()) . "='" . $config->idListPlaceHolder . '' . $config->idListPlaceHolder . "';"}</script>
{/if}
<div class='row blocks' data-region='product_browse-topBanner'>{$control->block->printRegion($layouts, 'product_browse', 'topBanner', true)}</div>
<div class='row' id='columns' data-page='product_browse'>
  {if(!empty($layouts['product_browse']['side']) and !empty($sideFloat) && $sideFloat != 'hidden')}
  <div class="col-md-{!echo 12 - $sideGrid} col-main{!echo $sideFloat === 'left' ? ' pull-right' : ''}" id='mainContainer'>
  {else}
  <div class='col-md-12' id='mainContainer'>
  {/if}
    <div class='list list-condensed' id='products'>
      <div class='row blocks' data-region='product_browse-top'>{$control->block->printRegion($layouts, 'product_browse', 'top', true)}</div>
      <header id='productHeader'>
        <strong><i class='icon-th'></i> {!echo $category->name}</strong>
         {!echo "<div class='header'>" . html::a('javascript:;', $lang->product->orderBy->time, "data-field='order' class='order setOrder'") . "</div>"}
         {!echo "<div class='header'>" . html::a('javascript:;', $lang->product->orderBy->hot, "data-field='views' class='views setOrder'") . "</div>"}
        <div class='pull-right btn-group' id="modeControl">
          {foreach($lang->product->listMode as $mode => $text)}
            {!html::a("javascript:;", $text, "data-mode='$mode' class='btn'")}
          {/foreach}
        </div>
      </header>
      {include $control->loadModel('ui')->getEffectViewFile('default', 'product', 'browse.card')}
      {include $control->loadModel('ui')->getEffectViewFile('default', 'product', 'browse.list')}
      <footer class='clearfix'>
        {$pager->show('right', 'short')}
      </footer>
    </div>
    <div class='row blocks' data-region='product_browse-bottom'>{$control->block->printRegion($layouts, 'product_browse', 'bottom', true)}</div>
  </div>
  {if(!empty($layouts['product_browse']['side']) and !(empty($sideFloat) || $sideFloat === 'hidden'))}
  <div class='col-md-{!echo $sideGrid} col-side'>
    <side class='page-side blocks' data-region='product_browse-side'>{$control->block->printRegion($layouts, 'product_browse', 'side')}</side>
  </div>
  {/if}
</div>
<div class='row blocks' data-region='product_browse-bottomBanner'>{$control->block->printRegion($layouts, 'product_browse', 'bottomBanner', true)}</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
