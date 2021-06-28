{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{$common->printPositionBar($control->app->getModuleName())}
<div class='panel' id='links'>
  <div class='panel-heading'><strong><i class='icon-link'></i> {!echo $lang->links->common}</strong></div>
  <div class='panel-body'>{!echo $links->all}</div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
