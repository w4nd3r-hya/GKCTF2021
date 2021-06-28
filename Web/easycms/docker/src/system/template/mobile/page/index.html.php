{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The index view file of page for mobile template of chanzhiEPS.
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
<div class='block-region region-top blocks' data-region='page_index-top'>{$control->loadModel('block')->printRegion($layouts, 'page_index', 'top')}</div>
<div class='panel panel-section'>
  <div class='panel-heading'>
    <div class='title'><strong>{$control->lang->page->list}</strong></div>
  </div>
  <div class='cards condensed cards-list' id='pageList'>
    {foreach($pages as $page)}
      {$url = inlink('view', "id=$page->id", "name=$page->alias")}
      <a class='card' href='{$url}' id='page{$page->id}' data-ve='page'>
        <div class='card-heading'>
          <h5>{$page->title}</h5>
        </div>
        <div class='table-layout'>
          <div class='table-cell'>
            <div class='card-content text-muted small'>{!helper::substr($page->summary, 60, '...')}</div>
            <div class='card-footer small text-muted'>
              <span title="{$lang->article->views}"><i class='icon-eye-open'></i> {$page->views}</span>
              {if(!empty($page->comments))}
                &nbsp;&nbsp; <span title="{$lang->article->comments}"><i class='icon-comments-alt'></i> {$page->comments}</span> &nbsp;
              {/if}
              &nbsp;&nbsp; <span title="{$lang->article->addedDate}"><i class='icon-time'></i> {!substr($page->addedDate, 0, 10)}</span>
            </div>
          </div>
          {if(!empty($page->image))}
            <div class='table-cell thumbnail-cell'>
              {$title = $page->image->primary->title ? $page->image->primary->title : $page->title}
              {$page->image->primary->objectType = 'article'}
              {!html::image($control->loadModel('file')->printFileURL($page->image->primary, 'smallURL'), "title='{{$title}}' class='thumbnail'")}
            </div>
          {/if}
        </div>
      </a>
    {/foreach}
  </div>
</div>

<div class='block-region region-bottom blocks' data-region='page_index-bottom'>{$control->loadModel('block')->printRegion($layouts, 'page_index', 'bottom')}</div>

{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
