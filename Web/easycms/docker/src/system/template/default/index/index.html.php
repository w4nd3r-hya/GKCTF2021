{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div id='focus' class='block-list'>
  <div class='row focus-top blocks' data-grid='12' data-region='index_index-top'>{$control->block->printRegion($layouts, 'index_index', 'top', true)}</div>
  <div class='row focus-middle blocks' data-grid='4' data-region='index_index-middle'>{$control->block->printRegion($layouts, 'index_index', 'middle', true)}</div>
  <div class='row focus-bottom blocks' data-grid='6' data-region='index_index-bottom'>{$control->block->printRegion($layouts, 'index_index', 'bottom', true)}</div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
