{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The hot product front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
/php*}
{$content = json_decode($block->content)}
{$type    = str_replace('product', '', strtolower($block->type))}
{$method  = 'get' . $type}
{if(empty($content->category))} {$content->category = 0} {/if}
{$showImage = isset($content->image) ? true : false}
{$products  = $model->loadModel('product')->$method($content->category, $content->limit, $showImage)}
<div id="block{$block->id}" class="{!echo $showImage ? 'panel-cards with-cards ' : ''} panel panel-block {$blockClass}">
  <div class='panel-heading'>
    <strong>{$icon} {$block->title}</strong>
    {if(isset($content->moreText) and isset($content->moreUrl))}
    <div class='pull-right'>{!html::a($content->moreUrl, $content->moreText)}</div>
    {/if}
  </div>
  {if($showImage)}
    <div class='panel-body no-padding'>
      {$count = count($products)}
      {if($count == 0)} {$count = 1} {/if}
      {$recPerRow = min($count, max(1, zget($content, 'recPerRow', 1)))}
      {@$percent  = 100 / $recPerRow}
      <div class='cards cards-products' data-cols='{$recPerRow}'>
        <style>.col-custom-{$recPerRow} { width: {$percent} %}</style>
        {$index = 0}
        {foreach($products as $product)}
          {$rowIndex = $index % $recPerRow}
          {if($rowIndex === 0)} <div class='row'> {/if}
          <div class='col col-custom-{$recPerRow}' data-rowIndex='{$rowIndex}' data-index='{$index}'>
          {$url = helper::createLink('product', 'view', "id=$product->id", "category={{$product->category->alias}}&name=$product->alias")}
            <div class='card'>
              <a class='card-img-fixed' href='{$url}'>
                {if(empty($product->image))}
                  {$imgColor = $product->id * 57 % 360}
                  <div class='media-placeholder' style='background-color: hsl({$imgColor}, 60%, 80%); color: hsl({$imgColor}, 80%, 30%);' data-id='{$product->id}'>{$product->name}</div>
                {else}
                  {$product->image->primary->objectType =  'product'}
                  {$imageSrc = $model->loadModel('file')->printFileURL($product->image->primary, 'middleURL')}
                  <img class='lazy' alt='{$product->name}' title='{$product->name}' data-src='{$imageSrc}'>
                {/if}
              </a>
              <div class='card-content'>
                {if(isset($content->showCategory) and $content->showCategory == 1)}
                    {if($content->categoryName == 'abbr')}
                        {$categoryName = '[' . ($product->category->abbr ? $product->category->abbr : $product->category->name) . '] '}
                        {!html::a(helper::createLink('product', 'browse', "categoryID={{$product->category->id}}", "category={{$product->category->alias}}"), $categoryName, "class='text-special'")}
                    {else}
                        {!html::a(helper::createLink('product', 'browse', "categoryID={{$product->category->id}}", "category={{$product->category->alias}}"), '[' . $product->category->name . '] ', "class='text-special'")}
                    {/if}
                {/if}
                {if(isset($content->alignTitle) and $content->alignTitle == 'middle')}
                  <div style='text-align:center;'><a href='{$url}'>{$product->name}</a></div>
                {else}
                  <div><a href='{$url}'>{$product->name}</a></div>
                {/if}
                <div class='card-price'>
                {if(!$product->unsaleable)}
                  {if($product->negotiate)}
                    <strong class='text-danger'>{$model->lang->product->negotiate}</strong>
                  {else}
                    {if($product->promotion != 0)}
                      <strong class='text-danger'>{$config->product->currencySymbol} {$product->promotion}</strong>
                      {if($product->price != 0)}
                        &nbsp;&nbsp;<small class='text-muted text-line-through'>{$config->product->currencySymbol} {$product->price}</small>
                      {/if}
                    {elseif($product->price != 0)}
                      <strong class='text-danger'>{$config->product->currencySymbol} {$product->price}</strong>
                    {/if}
                  {/if}
                {/if}
                {if(isset($content->showViews) and $content->showViews)}
                  <span><i class='icon icon-eye-open'></i>{$product->views}</span>
                {/if}
                </div>
              </div>
            </div>
          </div>
          {if($recPerRow === 1 || $rowIndex === ($recPerRow - 1) || $count === ($index + 1))}
            </div>
          {/if}
          {@$index++}
        {/foreach}
      </div>
    </div>
  {else}
  <div class='panel-body no-padding'>
    <div class='list-group simple'>
      {foreach($products as $product)}
        {$url = helper::createLink('product', 'view', "id=$product->id", "category={{$product->category->alias}}&name=$product->alias")}
        <div class='list-group-item'>
          <span class='text-latin pull-right'>
          {if(!$product->unsaleable)}
            {if($product->negotiate)}
              <strong class='text-danger'>{ $model->lang->product->negotiate}</strong>
            {else}
              {if($product->promotion != 0)}
                {if($product->price != 0)}
                   <small class='text-muted text-line-through'>{$config->product->currencySymbol} {$product->price}</small>&nbsp;&nbsp;
                {/if}
                <strong class='text-danger'>{$config->product->currencySymbol}{$product->promotion}</strong>
              {elseif($product->price != 0)}
                 <strong class='text-danger'>{$config->product->currencySymbol} {$product->price}</strong>
              {/if}
            {/if}
          {/if}
          </span>
          {if(isset($content->showCategory) and $content->showCategory == 1)}
            {if($content->categoryName == 'abbr')}
              {$categoryName = '[' . ($product->category->abbr ? $product->category->abbr : $product->category->name) . '] '}
              {!html::a(helper::createLink('product', 'browse', "categoryID={{$product->category->id}}", "category={{$product->category->alias}}"), $categoryName, "class='text-special'")}
            {else}
              {!html::a(helper::createLink('product', 'browse', "categoryID={{$product->category->id}}", "category={{$product->category->alias}}"), '[' . $product->category->name . '] ', "class='text-special'")}
            {/if}
          {/if}
          {!html::a($url, $product->name)}
        </div>
      {/foreach}
    </div>
  </div>
  {/if}
</div>
