{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
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
*}
{$content  = json_decode($block->content)}
{$type     = str_replace('product', '', strtolower($block->type))}
{$method   = 'get' . $type}
{if(empty($content->category))} {$content->category = 0} {/if}
{if(empty($content->limit))}    {$content->limit = 6} {/if}
{$image = isset($content->image) ? true : false}
{$products = $model->loadModel('product')->$method($content->category, $content->limit, $image)}
<div id="block{!echo $block->id}" class="panel-cards panel panel-block {!echo $blockClass}">
  <div class='panel-heading'>
    <strong>{!$icon} {!echo $block->title}</strong>
    {if(isset($content->moreText) and isset($content->moreUrl))}
    <div class='pull-right'>{!html::a($content->moreUrl, $content->moreText)}</div>
    {/if}
  </div>
   {if(isset($content->image))}
     {include TPL_ROOT . 'block' . DS . 'latestproduct.image.html.php'}
   {else}
     {include TPL_ROOT . 'block' . DS . 'latestproduct.noimage.html.php'}
   {/if}
</div>
