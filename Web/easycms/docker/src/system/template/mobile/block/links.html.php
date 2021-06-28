{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The link front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
/php*}
{if($app->getModuleName() != 'links' and !empty($config->links->index))}
  <div id="block{$block->id}" class='panel panel-block {$blockClass}'>
    <div class='panel-heading'>
      <strong><i class='icon'>{$icon}</i>{$block->title}</strong>
      <div class='pull-right'>
        {if(trim(strip_tags($config->links->all, '<a>')))}
          {!html::a(helper::createLink('links', 'index'), $lang->more)}
        {/if}
      </div>
    </div>
    <div class='panel-body'>{$config->links->index}</div>
  </div>
{/if}
