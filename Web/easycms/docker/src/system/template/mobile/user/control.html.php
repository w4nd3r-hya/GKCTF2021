{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The control view file of user for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.simple')}
<div class='tag-block user-image'>
  {if($app->user->account == 'guest')}
  <div class='tag' data-url="{$control->createLink('user', 'login')}">
    {!html::image($config->webRoot . 'theme/mobile/common/img/default-head.png')}
    <a class='tag-body' href="{$control->createLink('user', 'login')}">
      <div class='tag-title'>
        <div>{$lang->user->unlogin}</div>
        <div>{$lang->user->clickLogin}</div>
      </div> 
  {else}
  <div class='tag' data-url="{$control->createLink('user', 'profile')}">
    {!html::image($config->webRoot . 'theme/mobile/common/img/default-head.png')}
    <a class='tag-body' href="{$control->createLink('user', 'profile')}">
      <div class='tag-title'>
        <div>{$user->realname}</div>
        <div>{$user->email}</div>
      </div>
  {/if}
      <div class='tag-right'>
      {!html::image($config->webRoot . 'theme/mobile/common/img/right.png')}
      </div>
    </a>
  </div>
</div>
{if(commonModel::isAvailable('score'))}
<div class='tag-block user-score'>
  <div class='tag' data-url="{$control->createLink('user', 'score')}">
    <a class='tag-body' href="{$control->createLink('user', 'score')}">
      <div class='tag-title'>
        <div>
          {$lang->user->myScore}
        </div>
      </div>
      <div class='tag-right'>
        {!html::image($config->webRoot . 'theme/mobile/common/img/right.png')}
      </div>
    </a>
  </div>
</div>
<div class='tag-block user-recharge'>
  <div class='tag'>
    <div class='tag-score keepleft'>
      {if($app->user->account == 'guest')}
      <div class='score-number'>0</div>
      {else}
      <div class='score-number'>{$user->score}</div>
      {/if}
      <div class='score-title'>{$lang->user->totalScore}</div>
    </div> 
    <div class='tag-score'>
      {if($app->user->account == 'guest')}
      <div class='score-number'>0</div>
      {else}
      <div class='score-number'>{$user->rank}</div>
      {/if}
      <div class='score-title'>{$lang->user->levelScore}</div>
    </div> 
    {if(commonModel::hasOnlinePayment())}
    <div class='btn-recharge' data-url='{$control->createLink('score', 'buyscore')}'>{$lang->user->scoreRecharge}</div>
    {/if}
  </div>
</div>
{/if}
{$control->loadModel('user')->fixMenus()}
{foreach($control->config->user->navGroups->mobile as $group => $items)}
<ul class='nav nav-primary user-control-nav nav-stacked'>
  {$navs = explode(',', $items)}
  {foreach($navs as $nav)}
    {$class = ''}
    {$menu = zget($lang->user->control->menus, $nav, '')}
    {if(empty($menu))} {continue} {/if}
    {@list($label, $module, $method) = explode('|', $menu)}
    {$module = strtolower($module)}
    {$method = strtolower($method)}
    {$menuInfo = explode('|', $menu)}
    {$params   = zget($menuInfo, 3 ,'')}
    {if(!commonModel::isAvailable($module))} {continue} {/if}
    {if($module == $control->app->getModuleName() && $method == $control->app->getMethodName())} {$class .= 'active'} {/if}
    <li class="{$class}">{!html::a($control->createLink($module, $method, $params), $label, "class='btn default'")}</li>
  {/foreach}
</ul>
{/foreach}
<script>
$(function()
{
    $(document).on('click', '.tag, .btn-recharge', function()
    {
        if($(this).attr('data-url'))
        {
            window.location.href= $(this).attr('data-url');
        }
    });
});
</script>

{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
