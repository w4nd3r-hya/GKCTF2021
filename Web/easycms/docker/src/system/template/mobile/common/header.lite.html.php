{if(!defined("RUN_MODE"))} {!die()} {/if}
{if($extView = $control->getExtViewFile(TPL_ROOT . 'common/header.lite.html.php'))} {include $extView} {@return helper::cd()} {/if}
{$templateName       = CHANZHI_TEMPLATE}
{$themeName          = CHANZHI_THEME}
{$templateRoot       = TPL_ROOT}
{$templateThemeRoot  = "{{$config->webRoot}}theme/mobile/"}
{$templateCommonRoot = "{{$templateThemeRoot}}common/"}
{$thisModuleName     = $app->getModuleName()}
{$thisMethodName     = $app->getMethodName()}
{$thisModuleName     = $app->getModuleName()}
{$thisMethodName     = $app->getMethodName()}
<!DOCTYPE html>
<html xmlns:wb="http://open.weibo.com/wb" lang='{$app->getClientLang()}' class='m-{$thisModuleName} m-{$thisModuleName}-{$thisMethodName}'>
<head profile="http://www.w3.org/2005/10/profile">
  <meta charset="utf-8">
  <meta http-equiv="Cache-Control"  content="no-transform">
  <meta name="Generator" content="{!echo 'chanzhi' . $control->config->version . ' www.chanzhi.org'}">
  <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;" name="viewport" />
  {if(isset($desktopURL))}
    <link rel="alternate" href="{!echo $sysURL . $desktopURL}" >
  {/if}
  {if(isset($sourceURL))}
    <link rel="canonical" href="{!echo $sysURL . $sourceURL}" >
  {elseif(isset($canonicalURL))}
    <link rel="canonical" href="{!echo $sysURL . $canonicalURL}" >
  {/if}
  {if($thisModuleName == 'user' and $thisMethodName == 'deny')}
    <meta http-equiv='refresh' content="5;url='{!helper::createLink('index')}'">
  {/if}
  {if(!isset($title))}   {$title    = ''} {/if}
  {if(!empty($title))}   {$title   .= $lang->minus} {/if}
  {if(empty($keywords))} {$keywords = $config->site->keywords} {/if}
  {if(empty($desc))}     {$desc     = $config->site->desc} {/if}

  {!html::title($title . $config->site->name)}
  {!html::meta('keywords',    strip_tags($keywords))}
  {!html::meta('description', strip_tags($desc))}
  {if(isset($control->config->site->meta))} {$control->config->site->meta} {/if}

  {!js::exportConfigVars()}
  {!js::set('lang', $lang->js)}
  {!js::set('theme', array('template' => $templateName, 'theme' => $themeName, 'device' => $control->app->clientDevice))}
  {if($config->debug)}
    {!js::import($templateCommonRoot . 'js/mzui.all.min.js')}
    {!js::import($templateCommonRoot . 'js/chanzhi.js')}
    {!css::import($templateCommonRoot . 'css/mzui.min.css')}
    {!css::import($templateCommonRoot . 'css/chanzhi.css')}
  {else}
    {!js::import($templateCommonRoot . 'js/mzui.all.min.js')}
    {!js::import($templateCommonRoot . 'js/chanzhi.js')}
    {!css::import($templateCommonRoot . 'css/mzui.min.css')}
    {!css::import($templateCommonRoot . 'css/chanzhi.css')}
  {/if}

  {* Import customed css file if it exists. *}
  {$customCssFile = $control->loadModel('ui')->getCustomCssFile(CHANZHI_TEMPLATE, CHANZHI_THEME)}
  {if(!file_exists($customCssFile) or !is_readable($customCssFile))}
    {$resultCustomCss = $control->loadModel('ui')->createCustomerCss(CHANZHI_TEMPLATE, CHANZHI_THEME)}
  {/if}
  {if(file_exists($customCssFile))} {!css::import($control->ui->getThemeCssUrl(CHANZHI_TEMPLATE, CHANZHI_THEME), "id='themeStyle'", $version = false)} {/if}
  {if(isset($pageCSS))} {!css::internal($pageCSS)} {/if}

  {if(!isset($control->config->site->favicon) and file_exists($control->app->getWwwRoot() . 'favicon.ico'))} {!html::icon($webRoot . 'favicon.ico')} {/if}
  {if(isset($control->config->site->favicon))} {!html::icon(json_decode($control->config->site->favicon)->webPath)} {/if}
  {!html::rss($control->createLink('rss', 'index', '', '', 'xml'), $config->site->name)}
  {if(!empty($config->oauth->sina))} {$sina = json_decode($config->oauth->sina)} {/if}
  {if(!empty($config->oauth->qq))}   {$qq   = json_decode($config->oauth->qq)} {/if}
  {if(!empty($sina->verification))}  {$sina->verification} {/if}
  {if(!empty($qq->verification))}    {$qq->verification} {/if}
  {if(!empty($sina->widget))} {!js::import('https://tjs.sjs.sinajs.cn/open/api/js/wb.js')} {/if}

{$control->block->printRegion($layouts, 'all', 'header')}
</head>
{$top = false}
{foreach($layouts as $blocks)}
  {if(isset($blocks['top']))}
  {foreach($blocks['top'] as $block)}
    {if($block->type == 'header')} {$top = true} {/if}
  {/foreach}
  {/if}
{/foreach}

{if($top)}
  <body class='with-appbar-top with-appbar-bottom with-appnav'>
{else}
  <body class='with-appbar-bottom'>
{/if}
