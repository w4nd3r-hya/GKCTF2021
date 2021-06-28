{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
{$common->printPositionBar($control->app->getModuleName())}
<div class='panel' id='links'>
  <div class='panel-heading'><strong><i class='icon-link'></i> {$lang->links->common}</strong></div>
  <div class='panel-body'>{$links->all}</div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
