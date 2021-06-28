{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{$common->printPositionBar($control->app->getModuleName())}
<div class='row blocks' data-region='company_index-topBanner'>{$control->block->printRegion($layouts, 'company_index', 'topBanner', true)}</div>
<div class='row' id='columns' data-page='company_index'>
  {if(!empty($layouts['company_index']['side']) and !empty($sideFloat) && $sideFloat != 'hidden')}
  <div class="col-md-{!echo 12 - $sideGrid} col-main {if($sideFloat === 'left')} pull-right {/if}">
  {else}
  <div class="col-md-12">
  {/if}
    <div class='row blocks' data-region='company_index-top'>{$control->block->printRegion($layouts, 'company_index', 'top', true)}</div>
    <div class='panel' id='company'>
      <div class='panel-heading'><strong><i class='icon-group'></i> {$lang->aboutUs}</strong></div>
      <div class="panel-body">
        <div class='article-content'>
          {$company->content}
        </div>
      </div>
    </div>
    <div class='row blocks' data-region='company_index-bottom'>{$control->block->printRegion($layouts, 'company_index', 'bottom', true)}</div>
  </div>
  {if(!empty($layouts['company_index']['side']) and !(empty($sideFloat) || $sideFloat === 'hidden'))}
  <div class='col-md-{!echo $sideGrid} col-side'><side class='page-side blocks' data-region='company_index-side'>{$control->block->printRegion($layouts, 'company_index', 'side')}</side></div>
  {/if}
</div>
<div class='row blocks' data-region='company_index-bottomBanner'>{$control->block->printRegion($layouts, 'company_index', 'bottomBanner', true)}</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
