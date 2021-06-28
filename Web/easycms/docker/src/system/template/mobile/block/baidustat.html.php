{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The baidu stat block view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
/php*}
{$block->content = json_decode($block->content)}
<div id="block{$block->id}" class='hidden'>
  {$block->content->content}
</div>
