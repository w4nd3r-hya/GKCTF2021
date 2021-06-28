<?php if(!class_exists('raintpl')){exit;}?><?php if(!defined("RUN_MODE")){ ?>


<?php echo die(); ?>

<?php } ?>

<?php if(helper::isAjaxRequest()){ ?>


  <?php if(isset($pageCSS)){ ?>


<?php echo css::internal($pageCSS); ?>

<?php } ?>

  <div class="modal-dialog" style="width:<?php echo empty($modalWidth) ? 1000 : $modalWidth; ?>px;">
    <div class="modal-content">
      <div class="modal-header">
        <?php echo html::closeButton(); ?>


        <strong class="modal-title"><?php if(!empty($title)){ ?>


<?php echo $title;?>

<?php } ?></strong>
        <?php if(!empty($subtitle)){ ?>

 <small><?php echo $subtitle;?></small> <?php } ?>

      </div>
      <div class="modal-body">
<?php }else{ ?>

  <?php if($extView = $control->getExtViewFile(TPL_ROOT . 'common/header.html.php')){ ?>


    <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($extView);?>

    <?php return helper::cd(); ?>

<?php } ?>

  <?php $tpl = new RainTPL;$tpl->assign($this->var);$tpl->draw($control->loadModel('ui')->getEffectViewFile('default', 'common', 'header.lite'));?>


  <div class='page-container'>
    <div class='blocks' data-region='all-top'><?php echo $control->block->printRegion($layouts, 'all', 'top');?>

</div>
    <div class='page-wrapper'>
      <div class='page-content'>
        <div class='blocks row' data-region='all-banner'><?php echo $control->block->printRegion($layouts, 'all', 'banner', true);?>

</div>
<?php } ?>

