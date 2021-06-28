{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The featured product front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
/php*}
{$content  = json_decode($block->content)}
{$product  = $model->loadModel('product')->getByID($content->product)}
{if(!empty($product))}
  {$category = array_shift($product->categories)}
  {$alias    = !empty($category) ? $category->alias : ''}
  {$url      = helper::createLink('product', 'view', "id=$product->id", "category=$alias&name={{$product->alias}}")}
  <div id="block{$block->id}" class='panel panel-block {$blockClass} with-cards'>
    <div class='panel-body no-padding'>
      <div class='card card-block'>
        <a href='{$url}' class='card-img'>
          <img class='lazy' alt='{$product->name}' title='{$product->name}' data-src='{$product->image->primary->middleURL}'>
        </a>
        <div class='card-heading'>
          {if(isset($content->showCategory) and $content->showCategory == 1)}
            {if($content->categoryName == 'abbr')}
              {$categoryName = '[' . ($category->abbr ? $category->abbr : $category->name) . '] '}
              {!html::a(helper::createLink('product', 'browse', "categoryID={{$category->id}}", "category={{$category->alias}}"), $categoryName, "class='text-special'")}
            {else}
              {!html::a(helper::createLink('product', 'browse', "categoryID={{$category->id}}", "category={{$category->alias}}"), '[' . $category->name . '] ', "class='text-special'")}
            {/if}
          {/if}
          <strong>{$product->name}</strong>
          <div class='product-price'>
          {if(!$product->unsaleable)}
            {if($product->negotiate)}
              <strong class='text-danger'>{$lang->product->negotiate}</strong>
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
          </div>
          <div class='product-desc text-muted small'>{!helper::substr(strip_tags($product->desc), 80)}</div>
        </div>
      </div>
    </div>
  </div>
{/if}
