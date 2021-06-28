{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The browse view file of book for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     book
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
<div class="book-nav">
  {foreach($books as $row)}
  <span class="book {if($row->id == $book->id)}active{/if}">{!html::a($control->createLink('book', 'browse', "nodeID=$row->id", "book=$row->alias"), $row->title)}</span>
  {/foreach}
</div>
<div class="book-chapters">
  <ul class="chapter-tree">
    {$allCatalog}
  </ul>
</div>
{if(isset($pageJS))} {!js::execute($pageJS)} {/if}
