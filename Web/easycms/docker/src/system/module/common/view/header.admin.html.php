<?php if(!defined("RUN_MODE")) die();?>
<?php if($extView = $this->getExtViewFile(__FILE__)){include $extView; return helper::cd();}?>
<?php $mainMenu = commonModel::createMainMenu($this->moduleName);?>
<?php include 'header.lite.html.php';?>
<nav id='primaryNavbar'>
  <ul class='nav nav-stacked'>
  <?php
  if(!commonModel::isAvailable('shop'))
  {
    if(!commonModel::isAvailable('product'))
    {
      unset($lang->groups->shop);
    }
    else
    {
      $lang->groups->shop = array('title' => "$lang->productMenu", 'link' => 'product|admin|', 'icon' => 'shopping-cart');
    }
  }
  if(!commonModel::isAvailable('user'))
  {
    unset($lang->groups->user);
  }
  foreach ($lang->groups as $menuGroup => $groupSetting)
  {
      $print = false;
      $groupMenus = explode(',', $this->config->menus->$menuGroup);

      list($module, $method, $params) = explode('|', $groupSetting['link']);
      $groupClass = $menuGroup == $this->session->currentGroup ? 'active' : '';
      if($menuGroup == 'design' and $this->session->currentGroup == 'design') $groupClass = 'design';
      $groupUrl = helper::createLink($module, $method, $params);
      echo "<li class='{$groupClass}' data-id='{$menuGroup}'>";
      echo "<a data-toggle='tooltip' href='{$groupUrl}'>{$groupSetting['title']}</a>";
      if($menuGroup == 'design' and $menuGroup == $this->session->currentGroup)
      {
          echo "<ul class='nav nav-sub'>";
          foreach($lang->designMenus as $submenu)
          {
              $active = '';
              list($title, $module, $method) = explode('|', $submenu['link']);
              if((strtolower($method) == strtolower($this->app->methodName) && strtolower($module == $this->app->moduleName)) || (isset($submenu['alias']) && strpos($submenu['alias'], strtolower($this->app->methodName)) !== false)) $active = 'active';

              echo "<li class='active'>";
              echo html::a(helper::createLink($module, $method), $title, "class=$active");
              echo "</li>";
          }
          echo "</ul>";
      }
      echo "</li>";
  }
  ?>
  </ul>
  <?php echo commonModel::createManagerMenu('nav nav-stacked fixed-bottom');?>
</nav>
<?php if($this->session->currentGroup == 'design'):?>
<style> body{ padding-top: 20px !important;} </style>
<?php $templates       = $this->loadModel('ui')->getTemplates(); ?>
<?php $currentTemplate = $this->config->template->{$this->app->clientDevice}->name; ?>
<?php $currentTheme    = $this->config->template->{$this->app->clientDevice}->theme; ?>
<?php $currentDevice   = $this->session->device ? $this->session->device : 'desktop';?>
<ul class='nav navbar-nav navbar-right' id='mainNavbar'>
  <li><?php echo html::a(getHomeRoot(zget($this->config->langsShortcuts, $this->app->getClientLang())), '<i class="icon-home icon-large"></i> ' . $lang->frontHome, "target='_blank' class='navbar-link'");?></li>
  <li class='dropdown'><?php include 'selectlang.html.php';?></li>
</ul>
<?php endif;?>
<?php if($this->session->currentGroup != 'design'):?>
<nav class='navbar navbar-fixed-top' role='navigation' id='mainNavbar'>
  <div class='navbar-header'>
    <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='#mainNavbarCollapse'>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
      <span class='icon-bar'></span>
    </button>
  </div>
  <div class='collapse navbar-collapse' id='mainNavbarCollapse'>
    <?php echo $mainMenu;?>
    <ul class='nav navbar-nav navbar-right'>
      <li><?php echo html::a(getHomeRoot(zget($this->config->langsShortcuts, $this->app->getClientLang())), '<i class="icon-home icon-large"></i> ' . $lang->frontHome, "target='_blank' class='navbar-link'");?></li>
      <li class='dropdown'><?php include 'selectlang.html.php';?></li>
    </ul>
  </div>
</nav>
<?php endif;?>
<div class="clearfix row-main">
  <?php if($this->session->currentGroup == 'home' and strpos('forum,reply', $this->moduleName) !== false and $this->methodName == 'admin'):?>
  <div class='col-md-12'>
  <?php else:?>
  <?php $moduleName = $this->moduleName; ?>
  <?php $menuGroup  = zget($lang->menuGroups, $moduleName);?>
  <?php if(!isset($uiHeader) or !$uiHeader): ?>
    <?php $moduleMenu = commonModel::createModuleMenu($this->moduleName);?>
    <?php if($moduleMenu or !empty($treeModuleMenu)):?>
    <div class='col-md-2'>
      <div class="leftmenu affix hiddden-xs hidden-sm">
        <?php if($moduleMenu) echo $moduleMenu;?>
        <?php if(!empty($treeModuleMenu)):?>
        <div class='panel category-nav'>
          <div class='panel-body'>
            <?php echo $treeModuleMenu;?>
            <?php if(!empty($treeManageLink)):?>
            <div class='text-right'><?php if(commonModel::hasPriv('tree', 'browse')) echo $treeManageLink;?></div>
            <?php endif;?>
          </div>
        </div>
        <?php endif;?>
      </div>
    </div>
    <div class='col-md-10'>
    <?php endif;?>
  <?php else:?>
    <?php if(isset($uiHeader) and $uiHeader) include $this->app->getAppRoot() . 'module/ui/view/header.html.php';?>
    <?php if(!empty($treeModuleMenu)):?>
    <div class='col-md-2'>
      <div class="leftmenu affix hiddden-xs hidden-sm">
        <div class='panel category-nav'>
          <div class='panel-body'>
            <?php echo $treeModuleMenu;?>
            <?php if(!empty($treeManageLink)):?>
            <div class='text-right'><?php if(commonModel::hasPriv('tree', 'browse')) echo $treeManageLink;?></div>
            <?php endif;?>
          </div>
        </div>
      </div>
    </div>
    <div class='col-md-10'>
    <?php endif;?>
  <?php endif;?>
  <?php endif;?>
<?php if($this->session->currentGroup == 'design' and !$config->framework->detectDevice[$this->app->clientLang]):?>
<script>
$(document).ready(function()
{
    $("#mainNavbarCollapse .dropdown-menu a[href*='m=ui&f=setdevice&device=mobile']").click(function()
    {
        var url = $(this).attr('href');
        bootbox.confirm('<?php echo $lang->ui->openMobileTemplate ?>', function(result)
        {
            if(result) location.href = url;
            return true;
        });
        return false;
    });
});
</script>
<?php endif;?>
