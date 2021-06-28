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
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.lite')}
  <style>
    body {padding-top:48px}
    body.with-appnav.with-appbar-top {padding-top:48px}
    .appnav {border-bottom:0px}
    .appbar.fix-top {border-bottom:0px}
    .both-sides {border: 1px solid rgba(0,0,0,0.08);border-radius:20px}
    .both-sides.left {float:left;height:32px;width:87px;line-height:28px}
    .both-sides.right {float:right}
    .both-sides .icon-block {float:left;width:42px;text-align:center}
    .both-sides .icon-block.left img {width:10px;height:17.5px}
    .both-sides .icon-block.home img {width:17px;height:17px}
    .both-sides .divider-line {margin:6.75px 0px;border-left:1px solid #ddd;float:left;height:18.5px}
    .middle-title {width:50%;margin:0 auto;line-height:32px;font-size:1.8rem;text-align:center;font-weight:600}
  {if(!empty($source) && $source == 'bottom')}
    .both-sides.left{display:none}
  {/if} 
  </style>
  <div class='block-region region-all-top blocks' data-region='all-top'>
    <nav class='appbar fix-top appnav-auto' id='appnav' data-ve='navbar' data-type='mobile_top' style='top:0px;box-shadow: 0 0px 0px;height:48px'>
      <div class='mainnav' style='padding:8px 7px'>
        <div class='both-sides left'>
          <div class='icon-block left'>
            <a href='javascript:window.history.back();'>{!html::image($config->webRoot . 'theme/mobile/common/img/left.png')}</a>
          </div>
          <div class='divider-line'></div>
          <div class='icon-block home'>
            <a href='{$control->config->webRoot}'>{!html::image($config->webRoot . 'theme/mobile/common/img/home.png')}</a>
          </div>
        </div>
        <div class='middle-title'>{!isset($mobileTitle) ? $mobileTitle : $lang->detail}</div>
      </div>
      {if(!empty($subnavs))}
      <div class='subnavs fade'>
        {$subnavs}
      </div>
      {/if}
    </nav>
  </div>
  <div class='block-region region-all-banner blocks' data-region='all-banner'>
    {$control->block->printRegion($layouts, 'all', 'banner')}
  </div>
{/if}
