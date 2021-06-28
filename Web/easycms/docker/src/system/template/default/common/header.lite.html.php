{if(!defined("RUN_MODE"))} {!die()} {/if}
{if(!defined("RUN_MODE"))} {!die()} {/if}
{$extView=$control->getExtViewFile(TPL_ROOT . 'common/header.lite.html.php')}
{if($extView)}
  {include $extView}
  {@return helper::cd()}
{/if}
{$sysURL=rtrim($sysURL, '/')}
{if(isset($mobileURL))} {$mobileURL=ltrim($mobileURL, '/')} {/if}
<!DOCTYPE html>
<html xmlns:wb="http://open.weibo.com/wb" lang='{$app->getClientLang()}' class='m-{$thisModuleName} m-{$thisModuleName}-{$thisMethodName}'>
<head profile="http://www.w3.org/2005/10/profile">
  <meta charset="utf-8">
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Cache-Control"  content="no-transform">
  {if($app->getClientLang() == 'en')}
    <meta name="Generator" content="Zsite{$config->version} www.zsite.net'">
  {else}
    <meta name="Generator" content="chanzhi{$config->version} www.chanzhi.org'">
  {/if}
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  {if(isset($mobileURL))}
    <link rel="alternate" media="only screen and (max-width: 640px)" href="{$sysURL}/{$mobileURL}">
  {/if}

  {if(isset($sourceURL))}
    <link rel="canonical" href="{$sysURL}/{$sourceURL}" >
  {else}
    {if(isset($canonicalURL))} <link rel="canonical" href="{$sysURL}/{$canonicalURL}" > {/if}
  {/if}
  {if($thisModuleName == 'user' and $thisMethodName == 'deny')} <meta http-equiv='refresh' content="5;url={!helper::createLink('index')}"> {/if} 

  {if(!isset($title))}   {$title    = ''} {/if}
  {if(!empty($title))}   {$title   .= $lang->minus} {/if}
  {if(empty($keywords))} {$keywords = $config->site->keywords} {/if}
  {if(empty($desc))}     {$desc     = $config->site->desc} {/if}

  {!html::title($title . $config->site->name)}
  {!html::meta('keywords', $keywords)}
  {!html::meta('description', $desc)}
  {if(isset($config->site->meta))}{$config->site->meta}{/if}

  {if($config->debug)}
    {!js::import($jsRoot . 'jquery/min.js')}
    {!js::import($jsRoot . 'zui/min.js')}
    {!js::import($jsRoot . 'chanzhi.js')}
    {!js::import($jsRoot . 'my.js')}
    {!css::import($webRoot . 'zui/css/min.css')}
    {!css::import($themeRoot . 'common/style.css')}
    {if(file_exists($customCssFile))} {!css::import($customCssURI, "id='themeStyle'", $version = false)} {/if}
  {else}
    {if($cdnRoot)}
      {!css::import($cdnRoot . '/theme/default/default/chanzhi.all.css', '', $version = false)}
    {else}
      {!css::import($themeRoot . 'default/chanzhi.all.css')}
    {/if}
    {if(file_exists($customCssFile))} {!css::import($customCssURI, "id='themeStyle'", $version = false)} {/if}
    {if($cdnRoot)}
      {!js::import($cdnRoot  . '/js/chanzhi.all.js', $version = false)}
    {else}
      {!js::import($jsRoot     . 'chanzhi.all.js')}
    {/if}
  {/if}
  {if(isset($pageCSS))} {!css::internal($pageCSS)} {/if}
  {!js::exportConfigVars()}
  {!js::set('theme', array('template' => CHANZHI_TEMPLATE, 'theme' => CHANZHI_THEME, 'device' => $app->clientDevice))}
  {!html::icon($favicon)}
  {!html::rss(helper::createLink('rss', 'index', '', '', 'xml'), $config->site->name)}
  
  <!--[if lt IE 9]>
    {if($config->debug)}
      {!js::import($jsRoot . 'html5shiv/min.js')}
      {!js::import($jsRoot . 'respond/min.js')}
    {else}
      {if($cdnRoot)}
  	    <link href="{$cdnRoot}/js/respond/cross-domain/respond-proxy.html" id="respond-proxy" rel="respond-proxy" />
        <link href="/js/respond/cross-domain/respond.proxy.gif" id="respond-redirect" rel="respond-redirect" />
        {!js::import($jsRoot . 'html5shiv/min.js')}
        {!js::import($jsRoot . 'respond/min.js')}
        {!js::import($jsRoot . 'respond/cross-domain/respond.proxy.js')}
      {else}
  	    {!js::import($jsRoot . 'chanzhi.all.ie8.js')}
      {/if}
    {/if}
  <![endif]-->
  <!--[if lt IE 10]>
    {if($config->debug)} {!js::import($jsRoot . 'jquery/placeholder/min.js')} {/if}
    {if(!$config->debug)} {!js::import($jsRoot . 'chanzhi.all.ie9.js')} {/if}
  <![endif]-->
  
  {!js::set('lang', $lang->js)}
  {if(!empty($config->oauth->sina) and !is_object($config->oauth->sina))}
    {$sina=json_decode($config->oauth->sina)}
  {/if}
  {if(!empty($config->oauth->qq) and !is_object($config->oauth->qq))}
    {$qq=json_decode($config->oauth->qq)}
  {/if}
  {if(!empty($sina->verification))} {$sina->verification} {/if}
  {if(!empty($qq->verification))} {$qq->verification} {/if}
  {if(!empty($sina->widget))}
    {!js::import('https://tjs.sjs.sinajs.cn/open/api/js/wb.js')}
  {/if}
  {$baseCustom=isset($config->template->custom) ? json_decode($config->template->custom, true) : array()}
  {if(!empty($baseCustom[CHANZHI_TEMPLATE][CHANZHI_THEME]['js']))}
    {!js::execute($baseCustom[CHANZHI_THEME][CHANZHI_THEME]['js'])}
  {/if}
  {$control->block->printRegion($layouts, 'all', 'header')}
</head>
<body>
{$customCssFile = $control->loadModel('ui')->getCustomCssFile(CHANZHI_TEMPLATE, CHANZHI_THEME)}
{if(!file_exists($customCssFile) or !is_readable($customCssFile))}
  {$resultCustomCss = $control->loadModel('ui')->createCustomerCss(CHANZHI_TEMPLATE, CHANZHI_THEME)}
{/if}
{if(isset($resultCustomCss) and $resultCustomCss['result'] != 'success')}
  {if(!empty($resultCustomCss['message']))}
    <div class='alert alert-danger'> {$lang->customCssError} </div>
  {/if}
{/if}
