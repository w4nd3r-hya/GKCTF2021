{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The aboutus view file of company for mobile template of chanzhiEPS.
 * The view should be used as ajax content
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     company
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
<div class='block-region region-top no-padding blocks' data-region='company_index-top'>{$control->block->printRegion($layouts, 'company_index', 'top')}</div>

<div class='panel panel-section panel-company'>
    <div class='block-title vertical-center'>
      <strong class="vertical-center block-title-align">
        <span class='vertical-line'></span>
        <span class="block-title-text">{$lang->company->desc}</span>
      </strong>
    </div>
    <div class='company-desc'>
      <div class="title">
        <strong>{$company->name}</strong>
      </div>
      <div class="desc">
        <p>
          {$company->content}
        </p>
      </div>
    </div>
</div>
<div class='block-region region-bottom no-padding blocks' data-region='company_index-bottom'>{$control->block->printRegion($layouts, 'company_index', 'bottom')}</div>

{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
