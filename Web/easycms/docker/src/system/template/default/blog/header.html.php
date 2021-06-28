{if(!defined("RUN_MODE"))} {!die()} {/if}
{if($extView = $control->getExtViewFile(TPL_ROOT . 'blog/header.html.php'))} {include $extView} {@return helper::cd()}{/if}
{$navs       = $control->loadModel('nav')->getNavs('desktop_blog')}
<!DOCTYPE html>
{if(!empty($config->oauth->sina))}
<html lang='{!echo $app->getClientLang()}' xmlns:wb="http://open.weibo.com/wb" class='m-{!echo $thisModuleName} m-{!echo $thisModuleName}-{!echo $thisMethodName}'>
{else}
<html lang='{!echo $app->getClientLang()}' class='m-{!echo $thisModuleName} m-{!echo $thisModuleName}-{!echo $thisMethodName}'>
{/if}
<head>
  <meta name="renderer" content="webkit">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="Cache-Control" content="no-transform" />
  {if(isset($mobileURL))} <link rel="alternate" media="only screen and (max-width: 640px)" href="{!echo $sysURL . '/' . ltrim($mobileURL, '/')}"> {/if}
  {if(isset($sourceURL))} <link rel="canonical" href="{!echo $sysURL . ltrim($sourceURL, '/')}" > {/if}
  {if(!isset($title))}    {$title    = ''}{/if}
  {if(!empty($title))}    {$title   .= $lang->minus}{/if}
  {if(!isset($keywords))} {$keywords = $config->site->keywords}{/if}
  {if(!isset($desc))}     {$desc     = $config->site->desc}{/if}

  {!html::title($title . $config->site->name)}
  {!html::meta('keywords',    strip_tags($keywords))}
  {!html::meta('description', strip_tags($desc))}
  {if(isset($control->config->site->meta))} {!echo $control->config->site->meta} {/if}

  {!css::import($webRoot . 'zui/css/min.css')}
  {!css::import($themeRoot . 'common/style.css')}

  {$customCssFile = $control->loadModel('ui')->getCustomCssFile(CHANZHI_TEMPLATE, CHANZHI_THEME)}
  {if(file_exists($customCssFile))} {!css::import($control->ui->getThemeCssUrl(CHANZHI_TEMPLATE, CHANZHI_THEME), '', $version = false)} {/if}

  {!js::exportConfigVars()}
  {!js::set('theme', array('template' => CHANZHI_TEMPLATE, 'theme' => CHANZHI_THEME, 'device' => $control->app->clientDevice))}
  {if($config->debug)}
    {!js::import($jsRoot . 'jquery/min.js')}
    {!js::import($jsRoot . 'zui/min.js')}
    {!js::import($jsRoot . 'chanzhi.js')}
    {!js::import($jsRoot . 'my.js')}
  {else}
    {if($control->config->cdn->open == 'open')}
      {!js::import($control->config->cdn->host . $control->config->version . '/js/chanzhi.all.js', $version = false)}
    {else}
      {!js::import($jsRoot . 'chanzhi.all.js')}
    {/if}
  {/if}

  {if(isset($pageCSS))} {!css::internal($pageCSS)} {/if}

  {!echo isset($control->config->site->favicon) ? html::icon(json_decode($control->config->site->favicon)->webPath) : html::icon($webRoot . 'favicon.ico')}
  {!html::rss($control->createLink('rss', 'index', '', '', 'xml'), $config->site->name)}
  {!js::set('lang', $lang->js)}
  {if(!empty($config->oauth->sina))}                        {$sina = json_decode($config->oauth->sina)}{/if}
  {if(!empty($config->oauth->qq))}                          {$qq = json_decode($config->oauth->qq)}{/if}
  {if(!empty($sina->verification))}                         {$sina->verification} {/if}
  {if(!empty($qq->verification))}                           {$qq->verification}{/if}
  {if(empty($sina->verification) && !empty($sina->widget))} {!js::import('https://tjs.sjs.sinajs.cn/open/api/js/wb.js')}{/if}

  <!--[if lt IE 9]>
    {if($config->debug)}
      {!js::import($jsRoot . 'html5shiv/min.js')}
      {!js::import($jsRoot . 'respond/min.js')}
    {else}
      {!js::import($jsRoot . 'chanzhi.all.ie8.js')}
    {/if}
  <![endif]-->
  <!--[if lt IE 10]>
      {if($config->debug)}  {!js::import($jsRoot . 'jquery/placeholder/min.js')} {/if}
      {if(!$config->debug)} {!js::import($jsRoot . 'chanzhi.all.ie9.js')} {/if}
  <![endif]-->

  {$baseCustom = isset($control->config->template->custom) ? json_decode($control->config->template->custom, true) : array()}
  {if(!empty($baseCustom[CHANZHI_TEMPLATE][CHANZHI_THEME]['js']))} {!js::execute($baseCustom[CHANZHI_TEMPLATE][CHANZHI_THEME]['js'])} {/if}
</head>
<body>
<div class='m-blog page-container page-blog'>
  <header id='header' class='clearfix'>
    <div id='headNav'><div class='wrapper'>{!echo commonModel::printTopBar() . commonModel::printLanguageBar()}</div></div>
    <div id='headTitle'>
      <div class="wrapper">
        {$logoSetting = isset($control->config->site->logo) ? json_decode($control->config->site->logo) : new stdclass()}
        {$logo = false}
        {if(isset($logoSetting->{{CHANZHI_TEMPLATE}}->themes->all))}    {$logo = $logoSetting->{{CHANZHI_TEMPLATE}}->themes->all} {/if}
        {if(isset($logoSetting->{{CHANZHI_TEMPLATE}}->themes->{{CHANZHI_THEME}}))}  {$logo = $logoSetting->{{CHANZHI_TEMPLATE}}->themes->{{CHANZHI_THEME}}} {/if}
        {if($logo)}
          {$logo->extension = $control->loadModel('file')->getExtension($logo->pathname)}
          <div id='siteLogo' data-ve='logo'>
            {!html::a(helper::createLink('index'), html::image($control->loadModel('file')->printFileURL($logo), "class='logo' alt='{{$control->config->company->name}}' title='{{$control->config->company->name}}'"))}
          </div>
        {else}
          <div id='siteName' data-ve='logo'><h2>{!html::a(helper::createLink('index'), $control->config->site->name)}</h2></div>
        {/if}
      </div>
    </div>
    {if(commonModel::isAvailable('search'))}
    <div id='searchbar'>
      <form action='{!echo helper::createLink('search')}' method='get' role='search'>
        <div class='input-group'>
          {$keywords = ($control->app->getModuleName() == 'search') ? $control->session->serachIngWord : ''}
          {!html::input('words', $keywords, "class='form-control' placeholder=''")}
          {if($control->config->requestType == 'GET')}  {!html::hidden($control->config->moduleVar, 'search') . html::hidden($control->config->methodVar, 'index')} {/if}
          <div class='input-group-btn'>
            <button class='btn btn-default' type='submit'><i class='icon icon-search'></i></button>
          </div>
        </div>
      </form>
    </div>
    {/if}
  </header>
  <nav id="blogNav" class="navbar navbar-default" data-ve='navbar' data-type='desktop_blog'>
    <div class='wrapper'>
      <ul class='nav navbar-nav'>
        {foreach($navs as $nav1)}
          {if(empty($nav1->children))}
            <li class='{!echo $nav1->class}'>{!html::a($nav1->url, $nav1->title, "target='$nav1->target'")}</li>
            {else}
            <li class="{!echo $nav1->hover . " " . $nav1->class}">
                {!html::a($nav1->url, $nav1->title . " <b class='caret'></b>", 'class="dropdown-toggle" data-toggle="dropdown"')}
                <ul class='dropdown-menu' role='menu'>
                  {foreach($nav1->children as $nav2)}
                    {if(empty($nav2->children))}
                      <li class='{!echo $nav2->class}'>{!html::a($nav2->url, $nav2->title, "target='$nav2->target'")}</li>
                    {else}
                      <li class='dropdown-submenu {!echo $nav2->class}'>
                        {!html::a($nav2->url, $nav2->title, ($nav2->target != 'modal') ? "target='$nav2->target'" : '')}
                        <ul class='dropdown-menu' role='menu'>
                          {foreach($nav2->children as $nav3)}
                          <li>{!html::a($nav3->url, $nav3->title, ($nav3->target != 'modal') ? "target='$nav3->target'" : '')}</li>
                          {/foreach}
                        </ul>
                      </li>
                    {/if}
                  {/foreach}<!-- end nav2 -->
                </ul>
            </li>
          {/if}
        {/foreach}<!-- end nav1 -->
      </ul>
      {if(!isset($control->config->site->type) or $control->config->site->type != 'blog')}
        <ul class="nav navbar-nav navbar-right">
          <li>{!html::a(helper::createLink('index'), '<i class="icon-home icon-large"></i> ' . $lang->siteHome)}</li>
        </ul>
      {/if}
    </div>
  </nav>

  <div class='page-wrapper'>
    <div class='page-content'>
