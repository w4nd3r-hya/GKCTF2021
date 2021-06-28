{if(!defined("RUN_MODE"))} {!die()} {/if}
{noparse}
<style>
ul.user-control-nav > li > a{ padding:8px 18px;}
ul.user-control-nav > li.nav-icon > a{border-top:none; border-bottom:dashed 1px #ddd;}
ul.user-control-nav > li.nav-icon.active > a{border-bottom:none}
ul.user-control-nav > li.nav-icon:last-child > a{ border-bottom:1px solid #DDD;}

.nav-secondary > li.active > a,
.nav-secondary > li.active > a:hover,
.nav-secondary > li.active > a:focus,
.nav-primary > li.active > a,
.nav-primary > li.active > a:hover,
.nav-primary > li.active > a:focus {background-color: #2277da; border-color: #2277da}
.nav-secondary > li > a:hover, .nav-primary > li > a:hover {border-color: #3684e0}
</style>
{/noparse}
{$control->loadModel('user')->fixMenus()}
{$extView = $control->getExtViewFile(TPL_ROOT . 'user/side.html.php')}
{if($extView)}
{include $extView}
{@return helper::cd()}
{/if}
<div class='col-md-2'>
  {if(!commonModel::isAvailable('shop'))}
    {@unset($control->config->user->navGroups->desktop->order)}
  {/if}
  {if(!commonModel::hasOnlinePayment())}
    {@unset($lang->user->control->menus['recharge'])}
  {/if}
  {foreach($control->config->user->navGroups->desktop as $group => $items)}
  <ul class='nav nav-primary nav-stacked user-control-nav'>
    {if(isset($lang->user->navGroups->$group))}
      <li class='nav-heading'> {$lang->user->navGroups->$group}</li>
    {/if}
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
      {if(!commonModel::isAvailable($module))}{continue}{/if}
      {if($module == $control->app->getModuleName() && $method == $control->app->getMethodName())}
      {$class .= 'active'}
      {/if}
      {!echo '<li class="nav-icon ' . $class . '">' . html::a($control->createLink($module, $method, $params), $label) . '</li>'}
    {/foreach}
  </ul>
  {/foreach}
</div>
