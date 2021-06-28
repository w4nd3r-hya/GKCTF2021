<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The view file of backup module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xiragit.com>
 * @package     backup
 * @version     $Id: view.html.php 2568 2012-02-09 06:56:35Z shiyangyangwork@yahoo.cn $
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php if(!empty($error)):?>
<div id="notice" class='alert alert-success'>
  <div class="content"><i class='icon-info-sign'></i> <?php echo $error;?></div>
</div>
<?php endif;?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><?php echo $lang->backup->history?></strong>
    <div class='panel-actions'><?php commonModel::printLink('backup', 'backup', 'reload=yes', $lang->backup->backup, "class='btn btn-primary' id='backupBtn'");?></div>
  </div>
  <div class='pabel-body'>
  <table class='table table-condensed table-bordered table-fixed'>
    <thead>
      <tr>
        <th class='w-300px text-center'><?php echo $lang->backup->time?></th>
        <th><?php echo $lang->backup->files?></th>
        <th class='w-150px text-center'><?php echo $lang->backup->size?></th>
        <th class='w-180px text-center'><?php echo $lang->actions?></th>
      </tr>
    </thead>
    <tbody class='text-center'>
    <?php foreach($backups as $backupFile):?>
      <?php $rowspan = count($backupFile->files);?>
      <?php $i = 0?>
      <?php foreach($backupFile->files as $file => $size):?>
      <tr>
        <?php if($i == 0):?>
        <td <?php if($rowspan > 1) echo "rowspan='$rowspan'"?> class='text-middle'>
          <?php echo date(DT_DATETIME1, $backupFile->time);?>
          <?php
            if(isset($config->backup->note->{$backupFile->name})) 
            {
              echo "<br/>" . $lang->backup->note . " : ";
              echo $config->backup->note->{$backupFile->name};
            }
          ?>
        </td>
        <?php endif;?>
        <td class='text-left' style='padding-left:5px;'><?php echo $file;?></td>
        <td class='text-right'><?php echo $size / 1024 >= 1024 ? round($size / 1024 / 1024, 2) . 'MB' : round($size / 1024, 2) . 'KB';?></td>
        <?php if($i == 0):?>
        <td <?php if($rowspan > 1) echo "rowspan='$rowspan'"?> class='text-middle'>
          <?php
          commonModel::printLink('backup', 'restore', "file=$backupFile->name",  $lang->backup->restore, "class='restore' style='padding-left: 4px;'");
          commonModel::printLink('backup', 'delete', "file=$backupFile->name",  $lang->backup->delete, "class='deleter'");
          echo "<br/>";
          commonModel::printLink('backup', 'note', "file=$backupFile->name",  $lang->backup->note, "data-toggle='modal' class='noter'");
          if(isset($this->config->backup->reservedFiles) and strpos($this->config->backup->reservedFiles, $backupFile->name) !== false)
          {
            commonModel::printLink('backup', 'reserve', "file=$backupFile->name",  $lang->backup->reserved, "class='reserver' disabled='disabled'");
          }
          else
          {
            commonModel::printLink('backup', 'reserve', "file=$backupFile->name",  $lang->backup->reserve, "class='reserver'");
          }
          ?>
        </td>
        <?php endif;?>
      </tr>
      <?php $i++;?>
      <?php endforeach;?>
    <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan='4'>
        <?php printf($lang->backup->holdDays, $config->backup->holdDays)?>
        <?php commonModel::printLink('backup', 'change', '', $lang->backup->changeAB, "data-toggle='modal' data-width='400'");?>
        </td>
      </tr>
    </tfoot>
  </table>
</div>
</div>
<?php js::set('backup', $lang->backup->backup);?>
<?php js::set('restore', $lang->backup->restore);?>
<?php include '../../common/view/footer.admin.html.php';?>
