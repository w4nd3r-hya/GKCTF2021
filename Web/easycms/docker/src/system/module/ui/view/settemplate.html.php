<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The settheme view file of ui module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     ui
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php js::set('custom', $lang->ui->custom);?>
<?php $currentTheme    = $this->config->template->{$this->app->clientDevice}->theme; ?>
<?php $currentTemplate = $this->config->template->{$this->app->clientDevice}->name; ?>
<div id='mainMenu'>
  <div class='container'>
    <ul class='nav nav-underline' id='navMenu'>
      <li class='active'><?php echo html::a(inlink('setTemplate'), $lang->ui->files->default->user['thread']);?></li>
      <li><?php echo html::a(inlink('themestore'), $lang->ui->themeStore);?></li>
    </ul>
    <ul class='nav nav-pills' id='deviceMenu'>
      <li<?php if($this->session->device != 'mobile') echo " class='active'";?>><?php echo html::a($this->createLink('ui', 'setDevice', "device=desktop"), '<i class="icon icon-desktop"></i> ' . $lang->ui->clientDesktop);?></li>
      <li<?php if($this->session->device == 'mobile') echo " class='active'";?>><?php echo html::a($this->createLink('ui', 'setDevice', "device=mobile"), '<i class="icon icon-tablet"></i> ' . $lang->ui->clientMobile);?></li>
    </ul>
  </div>
</div>
<div id='main' class='container'>
  <div id='mainHeader'>
    <ul class='nav nav-dots pull-left' id='typeNav'>
      <li data-type='internal' class='active'><?php echo html::a('#internalSection', $lang->ui->installedThemes, "data-toggle='tab' class='active'");?></li>
      <?php if($app->clientLang != 'en'):?>
      <li data-type='internal'><?php echo html::a('#packageSection', $lang->ui->installTheme, "data-toggle='tab'");?></li>
      <?php endif;?>
    </ul>
  </div>
  <div id='mainContent' class='tab-content'>
    <section class='cards cards-borderless themes tab-pane active' id='internalSection'>
      <!--form method='post' class='actions search-form'>
        <div class='input-control search-box search-box-circle has-icon-left has-icon-right'>
          <input id='searchTheme' type='search' class='form-control search-input' name='searchTheme' value='<?php echo $this->post->searchTheme;?>' placeholder='<?php echo $lang->ui->searchTheme;?>'>
          <label for='inputSearchTheme' class='input-control-icon-left search-icon'><i class='icon icon-search'></i></label>
          <a href='javascript:;' class='input-control-icon-right search-clear-btn'><i class='icon icon-remove'></i></a>
        </div>
      </form -->
      <?php foreach($template['themes'] as $code => $theme):?>
      <?php $url = $this->createLink('ui', 'setTemplate', "template={$template['code']}&theme={$code}&custom=1");?>
      <?php $templateRoot = $webRoot . 'template/' . $template['code'] . '/';?>
      <?php $isCurrent =  $currentTheme === $code; ?>
      <div class='col-lg-1_5 col-md-3 col-sm-6'>
        <div class='card theme <?php if($isCurrent) echo 'current';?>' data-url='<?php echo $url?>'>
          <i class='icon-ok icon'></i>
          <?php echo html::a($url, html::image($webRoot . 'theme/' . $template['code'] . '/' . $code . '/preview.png'), "class='media-wrapper theme-img' data-url=$url");?>
          <div class='theme-name text-ellipsis'>
            <?php echo $theme;?>
          </div>
          <div class='actions'>
            <?php echo html::a($this->createLink('visual', 'design'), '<i class="icon icon-cog"> </i>' . $lang->ui->custom, 'class="btn btn-success btn-mini btn-custom"')?>
            <?php if(!in_array("$currentTemplate.$code", $this->config->ui->systemThemes)) commonModel::printLink('ui', 'deleteTheme', "template={$currentTemplate}&theme={$code}", "<span class='icon-trash'></span>", "title='{$lang->delete}' class='deleter btn btn-link btn-mini' data-type='ajax' data-backdrop='true'") ?>
          </div>
        </div>
      </div>
      <?php endforeach;?>
    </section>
    <?php if($app->clientLang != 'en'):?>
    <section class='tab-pane' id='packageSection'>
      <div class='text-center text-muted load-icon' style='padding: 50px'><i class='icon icon-2x icon-spinner icon-spin'></i></div>
    </section>
    <?php endif;?>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
