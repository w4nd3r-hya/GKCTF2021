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
{$app->loadLang('blog')}
{if(!empty($block->content->fixInNav))}
<div class='block-subscribe hidden'>
  <ul class='nav navbar-nav navbar-right'>
    <li class='nav-system-blog'>
      {!html::a(helper::createLink('rss', 'index', 'type=blog', '', 'xml'), "<i class='icon-rss text-warning'></i> " . $lang->blog->subscribe, "target='_blank'")}
    </li>
  </ul>
</div>
<script>
$('#blogNav ul.navbar-nav').last().after($('.block-subscribe').html());
</script>
{else}
<div id="block{!echo $block->id}" class='panel-pure panel'>
  {!html::a(helper::createLink('rss', 'index', 'type=blog', '', 'xml'), "<i class='icon-rss text-warning'></i> " . $lang->blog->subscribe, "target='_blank' class='btn btn-lg btn-block'")}
</div>
{/if}
