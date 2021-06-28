{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
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
*}
{$content  = json_decode($block->content)}
{$product  = $model->loadModel('product')->getByID($content->product)}
{if(!empty($product))}
  {$category = array_shift($product->categories)}
  {$alias    = !empty($category) ? $category->alias : ''}
  {$url      = helper::createLink('product', 'view', "id=$product->id", "category={{$alias}}&name={{$product->alias}}")}
  {$product->image->primary->objectType = 'product'}
  {$image = $model->loadModel('file')->printFileURL($product->image->primary, 'middleURL')}
  <div id="block{!echo $block->id}" class='panel panel-block {!echo $blockClass}'>
    <div class='panel-body'>
      <div class='card'>
        <div class='media' style='background-image: url({$image});'>
          {!html::image($image, "title='{{$product->name}}]' alt='{{$product->name}}'")}
        </div>
        <div class='card-heading'>
          {if(isset($content->showCategory) and $content->showCategory == 1)}
            {if($content->categoryName == 'abbr')}
              {$categoryName = '[' . ($category->abbr ? $category->abbr : $category->name) . '] '}
              {!html::a(helper::createLink('product', 'browse', "categoryID={{$category->id}}", "category={{$category->alias}}"), $categoryName)}
            {else}
              {!html::a(helper::createLink('product', 'browse', "categoryID={{$category->id}}", "category={{$category->alias}}"), '[' . $category->name . '] ')}
            {/if}
          {/if}
          <strong>{!html::a($url, $product->name)}</strong>
          <span class='text-latin'>
          {if(!$product->unsaleable)}
            {if($product->negotiate)}
              {!echo "&nbsp;&nbsp;"}
              {!echo "<strong class='text-danger'>" . $lang->product->negotiate . '</strong>'}
            {else}
              {if($product->promotion != 0)}
                {!echo "&nbsp;&nbsp;<strong class='text-danger'>" . $config->product->currencySymbol . $product->promotion . '</strong>'}
                {if($product->price != 0)}
                  {!echo "&nbsp;&nbsp;<del class='text-muted'>" . $config->product->currencySymbol . $product->price .'</del>'}
                {/if}
              {else}
                {if($product->price != 0)}
                  {!echo "<span class='text-muted'> " . $config->product->currencySymbol . "</span> "}
                  {!echo "<strong class='text-important'>" . $product->price . '</strong>&nbsp;&nbsp;'}
                {/if}
              {/if}
            {/if}
          {/if}
          </span>
        </div>
        <div class='card-content text-muted'>{!echo helper::substr(strip_tags($product->desc), 80)}</div>
      </div>
    </div>
  </div>
{/if}
