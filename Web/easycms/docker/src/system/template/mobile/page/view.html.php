{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The view file of page for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     page
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
{include TPL_ROOT . 'common/files.html.php'}
{!js::set('pageID', $page->id)}
{!css::internal($page->css)}
{!js::execute($page->js)}
<div class='block-region region-top blocks' data-region='page_view-top'>{$control->loadModel('block')->printRegion($layouts, 'page_view', 'top')}</div>
<div id='page' data-id='{$page->id }'>
<div class='appheader'>
  <div class='heading'>
    <h2>{$page->title}</h2>
  </div>
</div>

<div class='panel-section article'>
  <div class='panel-body'>
    <hr class="space">
    <section class='article-content'>
      {$page->content}
    </section>
  </div>
  {if(!empty($page->files))}
    <section class="article-files">
      {$control->loadModel('file')->printFiles($page->files)}
    </section>
  {/if}
  <div class='panel-footer'>
    <div class='article-moreinfo clearfix'>
      {if($page->keywords)}
        <p class='small'><strong class="text-muted">{$lang->article->keywords}</strong><span class="article-keywords">{$lang->colon}{$page->keywords}</span></p>
      {/if}
    </div>
  </div>
</div>
</div>
<div class='block-region region-bottom blocks' data-region='page_view-bottom'>{$control->loadModel('block')->printRegion($layouts, 'page_view', 'bottom')}</div>
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
