{if(!defined("RUN_MODE"))} {!die()} {/if}
{if(helper::isAjaxRequest())}
  {if(isset($pageCSS))} {!echo css::internal($pageCSS)} {/if}
  <div class="modal-dialog" style="width:{!echo empty($modalWidth) ? 1000 : $modalWidth}px;">
    <div class="modal-content">
      <div class="modal-header">
        {!html::closeButton()}
        <strong class="modal-title">{if(!empty($title))} {$title} {/if}</strong>
        {if(!empty($subtitle))} <small>{$subtitle}</small> {/if}
      </div>
      <div class="modal-body">
{else}
  {if($extView = $control->getExtViewFile(TPL_ROOT . 'common/header.html.php'))}
    {include $extView}
    {@return helper::cd()}
  {/if}
  {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header.lite')}
  <div class='page-container'>
    <div class='blocks' data-region='all-top'>{$control->block->printRegion($layouts, 'all', 'top')}</div>
    <div class='page-wrapper'>
      <div class='page-content'>
        <div class='blocks row' data-region='all-banner'>{$control->block->printRegion($layouts, 'all', 'banner', true)}</div>
{/if}
