{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The about front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Yidong wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
*}
{$block->content = json_decode($block->content)}
<div id="block{!echo $block->id}" class='hidden'>
  {$block->content->content}
</div>
