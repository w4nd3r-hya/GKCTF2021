<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>

<?php echo die(); ?>

<?php } ?>


<?php $isSearchAvaliable=$this->var['isSearchAvaliable'] = commonModel::isAvailable('search');?> 
<?php $setting=$this->var['setting']           = !empty($block->content) ? json_decode($block->content) : new stdclass();?>

<?php $device=$this->var['device']            = $model->app->clientDevice;?>

<?php $template=$this->var['template']          = $model->config->template->{$device}->name;?>

<?php $theme=$this->var['theme']             = $model->config->template->{$device}->theme;?>

<?php $logoSetting=$this->var['logoSetting']       = isset($model->config->site->logo) ? json_decode($model->config->site->logo) : new stdclass();?>

<?php $logo=$this->var['logo']              = '';?>


<?php if(isset($logoSetting->$template->themes->all)){ ?>

<?php $logo=$this->var['logo'] = $logoSetting->$template->themes->all;?>

<?php } ?>

<?php if(isset($logoSetting->$template->themes->$theme)){ ?>

<?php $logo=$this->var['logo'] = $logoSetting->$template->themes->$theme;?>

<?php } ?>


<?php if($logo != ''){ ?>

<?php $logo->extension = $model->loadModel('file')->getExtension($logo->pathname);$this->var['logo'] = $logo;?>

<?php } ?>



<?php $setting->top             = isset($setting->top) ? $setting->top : new stdclass();$this->var['setting'] = $setting;?>

<?php $setting->middle          = isset($setting->middle) ? $setting->middle : new stdclass();$this->var['setting'] = $setting;?>

<?php $setting->bottom          = zget($setting, 'bottom', 'nav');$this->var['setting'] = $setting;?>

<?php $setting->top->left       = zget($setting->top, 'left', '');$this->var['setting'] = $setting;?>

<?php $setting->top->right      = zget($setting->top, 'right', 'login');$this->var['setting'] = $setting;?>

<?php $setting->middle->left    = zget($setting->middle, 'left', 'logo');$this->var['setting'] = $setting;?>

<?php $setting->middle->center  = zget($setting->middle, 'center', 'slogan');$this->var['setting'] = $setting;?>

<?php $setting->middle->right   = zget($setting->middle, 'right', 'search');$this->var['setting'] = $setting;?>

<?php $setting->compatible      = zget($setting, 'compatible', '0');$this->var['setting'] = $setting;?>

<?php $setting->topLeftContent  = zget($setting, 'topLeftContent', '');$this->var['setting'] = $setting;?>

<?php $setting->topRightContent = zget($setting, 'topRightContent', '');$this->var['setting'] = $setting;?>


<div data-ve='block' data-id="<?php echo $block->id;?>">
  <?php if($setting->compatible){ ?>

    <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'header.default'));?>

  <?php }else{ ?>

    <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($model->loadModel('ui')->getEffectViewFile('default', 'block', 'header.layout'));?>

<?php } ?>

</div>
