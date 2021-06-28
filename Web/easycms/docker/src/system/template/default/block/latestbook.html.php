{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The latest book front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
*}
{$content = json_decode($block->content)}
{$orderBy = $content->sort == 'order' ? 'order' : 'addedDate_desc'}
{$books   = $model->loadModel('book')->getLatestBookList($content->limit, $orderBy)}
<div id="block{!echo $block->id}" class="panel-cards panel panel-block {!echo $blockClass}">
  <div class='panel-heading'>
    <strong>{!echo $icon} {!echo $block->title}</strong>
    {if(isset($content->moreText) and isset($content->moreUrl))}
    <div class='pull-right'>{!html::a($content->moreUrl, $content->moreText)}</div>
    {/if}
  </div>
  {if($content->showType == 'block')}
    {include TPL_ROOT . 'block' . DS . 'latestbook.block.html.php'}
  {else}
    {include TPL_ROOT . 'block' . DS . 'latestbook.list.html.php'}
  {/if}
</div>
