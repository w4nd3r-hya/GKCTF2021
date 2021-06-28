{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The html block form view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
*}
{if(!is_object($block->content))} {$block->content = json_decode($block->content)} {/if}
<div id="block{!echo $block->id}" class='panel panel-block {!echo $blockClass}'>
  <div class='panel-heading'>
    <strong>{!echo $icon . $block->title}</strong>
    {if(!empty($block->content->moreText) and !empty($block->content->moreUrl))}
      <div class='pull-right'>{!html::a($block->content->moreUrl, $block->content->moreText)}</div>
    {/if}
  </div>
  <div class='panel-body'>{$block->content->content}</div>
</div>
