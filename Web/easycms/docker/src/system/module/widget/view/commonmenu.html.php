<?php if(!defined("RUN_MODE")) die();?>
<div class='shortcutGroup'>
<?php 
  $this->app->loadLang('admin');
  if(!empty($articleCategories)) echo html::a($this->createLink('article', 'create'), $lang->admin->shortcuts->article, "class='btn btn-default'");
  else echo html::a($this->createLink('tree', 'browse',"type=article"), $lang->admin->shortcuts->articleCategories, "class='btn btn-default'")
?>
<?php echo html::a($this->createLink('product', 'create'),     $lang->admin->shortcuts->product,  "class='btn btn-default'");?>
<?php echo html::a($this->createLink('message', 'admin'),      $lang->admin->shortcuts->feedback, "class='btn btn-default'");?>  
<?php echo html::a($this->createLink('site',    'setBasic'),   $lang->admin->shortcuts->site,     "class='btn btn-default'");?>
<?php echo html::a($this->createLink('company', 'setBasic'),   $lang->admin->shortcuts->company,  "class='btn btn-default'");?>
<?php echo html::a($this->createLink('company', 'setcontact'), $lang->admin->shortcuts->contact,  "class='btn btn-default'")?>  
</div>
