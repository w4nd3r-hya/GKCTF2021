{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The group block view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
/php*}
<div id="block{$block->id}" class='panel panel-block {$blockClass}'>
  <div class='panel-heading'>
    <strong>{$block->title}</strong>
    {if(isset($content->moreText) and isset($content->moreUrl))}
      <div class='pull-right'>{!html::a($content->moreUrl, $content->moreText)}</div>
    {/if}
  </div>
<script>
$().ready(function()
{
    $('#block{$block->id}').find(".block-tabs").hide();
    $('#block{$block->id}').find(".block-tabs-nav").find('li').click(function()
    {
        index = $(this).index();
        $('#block{$block->id}').find(".block-tabs-nav li").removeClass('active');
        $(this).addClass('active');
        $('#block{$block->id}').find(".block-tabs").hide();
        $('#block{$block->id}').find(".block-tabs").eq(index).show();

    });
    $('#block{$block->id}').find(".block-tabs-nav").find('li').first().click();
})
</script>
<style>
.nav-tabs.block-tabs-nav>li.active>a{border-top: 0; padding-top:9px; border-radius:0;}
.nav-tabs.block-tabs-nav > li:first-child > a{border-left: 0;}
</style>
