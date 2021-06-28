{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The code block view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
*}
<div id="block{!echo $block->id}" class='block'>
{$block->content = is_null(json_decode($block->content)) ? $block->content : json_decode($block->content)}

{if(!is_object($block->content))} {$blockContent = $block->content} {/if}
{if(is_object($block->content))}  {$blockContent = isset($block->content->content) ? $block->content->content : ''} {/if}

{!str_ireplace('#blockID', "#block{{$block->id}}", $blockContent)}
</div>
