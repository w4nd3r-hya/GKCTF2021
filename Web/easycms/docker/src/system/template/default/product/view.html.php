{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{!js::set('path',  $product->path)}
{!js::set('objectType', 'product')}
{!js::set('productID', $product->id)}
{!js::set('objectID', $product->id)}
{!js::set('categoryID', $category->id)}
{!js::set('categoryPath', explode(',', trim($category->path, ',')))}
{!js::set('addToCartSuccess', $lang->product->addToCartSuccess)}
{!js::set('gotoCart', $lang->product->gotoCart)}
{!js::set('goback', $lang->product->goback)}
{!js::set('stockOpened', $stockOpened)}
{!js::set('stock', $product->amount)}
{!css::internal($product->css)}
{!js::execute($product->js)}
{!js::set('pageLayout', $control->block->getLayoutScope('product_view', $product->id))}
{$common->printPositionBar($category, $product)}
<div class='row blocks' data-region='product_view-topBanner'>{$control->block->printRegion($layouts, 'product_view', 'topBanner', true)}</div>
<div class='row' id='columns' data-page='product_view'>
  {if(!empty($layouts['product_view']['side']) and !empty($sideFloat) && $sideFloat != 'hidden')}
    <div class="col-md-{!echo 12 - $sideGrid} col-main{!echo ($sideFloat === 'left') ? ' pull-right' : ''}">
  {else}
    <div class='col-md-12'>
  {/if}
    <div class='row blocks' data-region='product_view-top'>{$control->block->printRegion($layouts, 'product_view', 'top', true)}</div>
    <div class='panel panel-body panel-product' id='product' data-id='{$product->id}'>
      <div class='row'>
        {if(!empty($product->image->list))}
          <div class='col-sm-5' id='productImageWrapper'>
            <div class='product-image media-wrapper' id='productImage'>
              {$title = $product->image->primary->title ? $product->image->primary->title : $product->name}
              {!html::image($control->loadModel('file')->printFileURL($product->image->primary), "title='$title' alt='$product->name'")}
              <div class='image-zoom-region'></div>
            </div>
            {if(count($product->image->list) > 1)}
              <div class='product-image-menu-wrapper' id='imageMenuWrapper'>
                <button type='button' class='btn btn-link btn-img-scroller btn-prev-img'><i class="icon icon-chevron-left"></i></button>
                <button type='button' class='btn btn-link btn-img-scroller btn-next-img'><i class="icon icon-chevron-right"></i></button>
                <div class='product-image-menu clearfix' id='imageMenu'>
                  {foreach($product->image->list as $image)}
                  {$title = $image->title ? $image->title : $product->name}
                  <div class="product-image-wrapper">
                    <div class='product-image little-image'>
                      {!html::image($control->file->printFileURL($image), "title='{{$title}}' alt='{{$product->name}}'")}
                    </div>
                  </div>
                  {/foreach}
                </div>
              </div>
            {/if}
          </div>
          <div class='col-sm-7'>
        {else}
        <div class='col-md-12'>
        {/if}
          <div class='product-property{!echo empty($product->image->list) ? ' product-lack-img' : ''}'>
            <h1 class='header-dividing'>{$product->name}</h1>
            <ul class='list-unstyled meta-list'>
              {$attributeHtml = ''}
              {if(!$product->unsaleable)}
                {if($product->negotiate)}
                  {$attributeHtml .= "<li id='priceItem'><span class='meta-name'>" . $lang->product->price . "</span>"}
                  {$attributeHtml .= "<span class='meta-value'><span class='text-danger text-lg text-latin'>" . $lang->product->negotiate . "</span></li>"}
                {else}
                  {if($product->promotion != 0)}
                    {if($product->price != 0)}
                      {$attributeHtml .= "<li id='priceItem'><span class='meta-name'>" . $lang->product->price . "</span>"}
                      {$attributeHtml .= "<span class='meta-value'><span class='text-muted text-latin'>" . $config->product->currencySymbol . "</span> <del><strong class='text-latin'>" . $product->price . "</del></strong></span></li>"}
                    {/if}
                    {$attributeHtml .= "<li id='promotionItem'><span class='meta-name'>" . $lang->product->promotion . "</span>"}
                    {$attributeHtml .= "<span class='meta-value'><span class='text-muted text-latin'>" . $config->product->currencySymbol . "</span> <strong class='text-danger text-latin text-lg'>" . $product->promotion . "</strong></span></li>"}
                  {elseif($product->price != 0)}
                    {$attributeHtml .= "<li id='priceItem'><span class='meta-name'>" . $lang->product->price . "</span>"}
                    {$attributeHtml .= "<span class='meta-value'><span class='text-muted text-latin'>" . zget($lang->product->currencySymbols, $config->product->currency, '￥') . "</span> <strong class='text-important text-latin text-lg'>" . $product->price . "</strong></span></li>"}
                  {/if}
                {/if}
              {/if}
              {if($product->amount and isset($config->product->stock))}
                {$attributeHtml .= "<li id='amountItem'><span class='meta-name'>" . $lang->product->stock . "</span>"}
                {$attributeHtml .= "<span class='meta-value'>" . $product->amount . " <small>" . $product->unit . "</small></span></li>"}
              {/if}
              {if($product->brand)}
                {$attributeHtml .= "<li id='brandItem'><span class='meta-name'>" . $lang->product->brand . "</span>"}
                {$attributeHtml .= "<span class='meta-value'>" . $product->brand . " <small>" . $product->model . "</small></span></li>"}
              {/if}
              {if(!$product->brand and $product->model)}
                {$attributeHtml .= "<li id='modelItem'><span class='meta-name'>" . $lang->product->model . "</span>"}
                {$attributeHtml .= "<span class='meta-value'>" . $product->model . "</span></li>"}
              {/if}
              {if($product->color)}
                {$attributeHtml .= "<li><span class='meta-name'>" . $lang->product->color . "</span>"}
                {$attributeHtml .= "<span class='meta-value'>" . $product->color . "</span></li>"}
              {/if}
              {if($product->origin)}
                {$attributeHtml .= "<li><span class='meta-name'>" . $lang->product->origin . "</span>"}
                {$attributeHtml .= "<span class='meta-value'>" . $product->origin . "</span></li>"}
              {/if}
              {foreach($product->attributes as $attribute)}
                {if(empty($attribute->label) and empty($attribute->value))} {continue} {/if}
                  {$attributeHtml .= "<li><span class='meta-name'>" . $attribute->label . "</span>"}
                {if(strpos($attribute->value, 'http://') === 0 or strpos($attribute->value, 'https://') === 0)}
                  {$attributeHtml .= "<span class='meta-value'>" . html::a($attribute->value, $attribute->value, "target='_blank'") . "</span></li>"}
                {else}
                  {$attributeHtml .= "<span class='meta-value'>" . $attribute->value . "</span></li>"}
                {/if}
              {/foreach}
              {$attributeHtml}
            </ul>
            {if(empty($attributeHtml))} <div class="product-summary">{$product->desc}</div> {/if}
            {if(!$product->unsaleable and commonModel::isAvailable('shop') and !$product->mall)}
              {if($product->negotiate)}
              <span id='buyBtnBox'>
                {!html::a(helper::createLink('company', 'contact'), $lang->product->contact, "class='btn btn-primary'")}
              </span>
            {else}
              {if(!$stockOpened or $product->amount > 0)}
                <ul class='list-unstyled meta-list'>
                  <li id='countBox'>
                    <span class='meta-name'>{$lang->product->count}</span>
                    <span class='meta-value'>
                      <span class='input-group'>
                        <span class='input-group-addon'><i class='icon icon-minus'></i></span>
                        {!html::input('count', 1, "class='form-control'")}
                        <span class='input-group-addon'><i class='icon icon-plus'></i></span>
                      </span>
                    </span>
                  </li>
                </ul>
              {/if}
              <span id='buyBtnBox'>
                {if($stockOpened and $product->amount < 1)}
                  <label class='btn-soldout'>{$lang->product->soldout}</label>
                {else}
                  <label class='btn-buy'>{$lang->product->buyNow}</label>
                  <label class='btn-cart'>{$lang->product->addToCart}</label>
                {/if}
              </span>
              {/if}
            {/if}
            {if(!$product->unsaleable and $product->mall and !$product->negotiate)}
              <hr>
              <div class='btn-gobuy'>
                {!html::a(inlink('redirect', "id={{$product->id}}"), $lang->product->buyNow, "class='btn btn-lg btn-primary' target='_blank'")}
              </div>
            {/if}
          </div>
        </div>
      </div>
      <h5 class='header-dividing'><i class='icon-file-text-alt text-muted'></i> {$lang->product->content}</h5>
      <div class='article-content'>
        {$product->content}
      </div>
      <div class="article-files">
        {$control->loadModel('file')->printFiles($product->files)}
      </div>
    </div>
    <div class='row blocks' data-region='product_view-bottom'>{$control->block->printRegion($layouts, 'product_view', 'bottom', true)}</div>
    {if(commonModel::isAvailable('message'))}
    <div id='comments'>
      <div id='commentBox'>
        {!echo $control->fetch('message', 'comment', "objectType=product&objectID={{$product->id}}")}
      </div>
      {!html::a('', '', "name='comment'")}
    </div>
    {/if}
  </div>
  {if(!empty($layouts['product_view']['side']) and !(empty($sideFloat) || $sideFloat === 'hidden'))}
  <div class='col-md-{$sideGrid} col-side'>
    <side class='page-side blocks' data-region='product_view-side'>{$control->block->printRegion($layouts, 'product_view', 'side')}</side>
  </div>
  {/if}
</div>
<div class='row blocks' data-region='product_view-bottomBanner'>{$control->block->printRegion($layouts, 'product_view', 'bottomBanner', true)}</div>
{include TPL_ROOT . 'common/video.html.php'}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
