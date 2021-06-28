{if(!defined("RUN_MODE"))} {!die()} {/if}
{if(helper::isAjaxRequest())}
  {$templateName       = CHANZHI_TEMPLATE}
  {$themeName          = CHANZHI_THEME}
  {$templateRoot       = TPL_ROOT}
  {$templateThemeRoot  = "{{$templateRoot}}theme/"}
  {$templateCommonRoot = "{{$templateThemeRoot}}common/"}
  {$thisModuleName     = $control->app->getModuleName()}
  {$thisMethodName     = $control->app->getMethodName()}
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span></button>
        <h5 class='modal-title'>{!echo !empty($title) ? $title : ''}</h5>
      </div>
      <div class='modal-body'>
{else}
  {if($extView = $control->getExtViewFile(TPL_ROOT . 'common/header.html.php'))} {include $extView} {@return helper::cd()} {/if}
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.lite')}
  <div class='block-region region-all-top blocks' data-region='all-top'>
    {$control->block->printRegion($layouts, 'all', 'top')}
  </div>
  <div class='block-region region-all-banner blocks' data-region='all-banner'>
    {$control->block->printRegion($layouts, 'all', 'banner')}
  </div>
{/if}
