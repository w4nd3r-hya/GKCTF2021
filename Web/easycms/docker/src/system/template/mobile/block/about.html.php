{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
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
/php*}
{$block->content = json_decode($block->content)}
<div id="block{$block->id}" class='panel panel-block panel-block-about {$blockClass}'>
  <div class='panel-heading'>
    <strong>{!echo $icon . $block->title}</strong>
    {if(!empty($block->content->moreText) and !empty($block->content->moreUrl))}
      <div class='pull-right'>{!html::a($block->content->moreUrl, $block->content->moreText, "data-toggle='modal' data-type='ajax'")}</div>
    {/if}
  </div>
  <div class='panel-body'>
    <div class='article-content'>{$config->company->desc}</div>
  </div>
</div>
