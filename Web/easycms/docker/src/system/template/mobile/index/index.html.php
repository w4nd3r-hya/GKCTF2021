{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The index view file for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     index
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}

<div id='focus'>
  <div id='focusTop' class='block-region blocks focus-top' data-region='index_index-top'>
    {$control->block->printRegion($layouts, 'index_index', 'top', false)}
  </div>
  <div id='focusMiddle' class='block-region blocks focus-middle' data-region='index_index-middle'>
    {$control->block->printRegion($layouts, 'index_index', 'middle', false)}
  </div>
  <div id='focusBottom' class='block-region blocks focus-bottom' data-region='index_index-bottom'>
    {$control->block->printRegion($layouts, 'index_index', 'bottom', false)}
  </div>
</div>

{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
