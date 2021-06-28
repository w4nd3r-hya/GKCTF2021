<?php if(!defined("RUN_MODE")) die();?>
<div id="mainArea" class='cards'>
  <?php foreach($themes as $theme):?>
  <?php $link      = inlink('installtheme', "package={$theme->name}&downLink=&md5=");?>
  <?php $installed = (isset($installedThemes['default'][$theme->name]) or isset($installedThemes['mobile'][$theme->name]));?>
  <div class='col-lg-1_5 col-md-3 col-sm-6'>
    <div class='card'>
      <div class='card-heading' title='<?php echo $theme->name . '.zip'?>'>
        <h5 class='text-ellipsis'><?php echo $theme->name . '.zip';?></h5>
      </div>
      <div class='card-content text-muted small'>
        <span class='span-time'><?php echo "<i class='icon icon-time'> </i>" . $theme->time;?></span> &nbsp;
        <span class='span-size'><?php echo "<i class='icon icon-file'> </i>" . helper::formatKB($theme->size / 1024);?></span>
      </div>
      <div class='card-actions'>
        <?php if($installed) echo "<span class='text-success'><i class='icon icon-ok-sign'></i> {$lang->ui->theme->installed}</span>";?>
        <?php if(!$installed):?>
        <?php echo html::a($link . '&type=theme', $lang->ui->importTypes->theme, "class='btn btn-xs btn-install' data-toggle='modal'");?> &nbsp;
        <?php echo html::a($link . "&type=full",  $lang->ui->importTypes->full, "class='btn btn-xs btn-install btn-full'");?>
        <?php echo html::a($link . "&type=full",  '', "class='hide' data-toggle='modal'");?>
        <?php endif;?>
      </div>
    </div>
  </div>
  <?php endforeach;?>
</div>
<div class='div-tip alert alert-info'>
  <div class='content'><i class="icon icon-info-sign"></i> <?php printf($lang->ui->packagePathTip, $packagePath);?></div>
</div>
<div id="packageSectionActions">
  <?php echo html::a(inlink('uploadTheme'), $lang->ui->uploadPackage . " <i class='icon icon-upload'></i>", "data-toggle='modal' class='btn btn-primary' data-position='80'");?>
</div>
<style>
.theme-panel > .panel-body{padding-top:4px !important; cursor:pointer;}
.theme-panel > .panel-body > .theme-title{font-size:16px; padding: 10px 0; color:#555; font-weight:bold;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;}
.theme-panel .span-size{margin-left:20px;}
.p-actions{margin-right:10px; padding-left:12px;}
.p-actions > i {font-size:13px; padding:4px; font-weight:bold;}
.panel-actions{margin-right: 0px}
</style>
<script>
$().ready(function()
{
    $('.btn-full').click(function()
    {
        var $btn = $(this)
        bootbox.confirm(v.lang.fullImportTip, function(result)
        {
            if(result) $btn.next().click();
        });
        return false;
    });
});
</script>
