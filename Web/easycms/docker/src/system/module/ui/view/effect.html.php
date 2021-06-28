<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The admin view file of effect module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     ui
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div id='mainMenu'>
  <div class='container'>
    <ul class='nav nav-underline' id='navMenu'>
    <?php
    echo '<li>' . html::a($this->createLink('ui', 'component'), $lang->ui->component) . '</li>';
    echo '<li class="active">' . html::a($this->createLink('ui', 'effect'), $lang->effect->common, "class='active'") . '</li>';
    $this->app->loadLang('file');
    echo '<li>' . html::a($this->createLink('file', 'browsesource'), $lang->file->sourceList) . '</li>';
    ?>
    </ul>
  </div>
</div>
<div class='panel'>
  <div class='panel-heading'>
    <?php echo html::a($this->config->admin->apiRoot . 'effect.html', $lang->effect->obtan, "target='_blank' class='btn'");?>
  </div>
  <?php if(!empty($effects)):?>
  <table class='table table-hover' id='effects'>
    <thead>
      <tr class='text-left'>
        <th><?php echo $lang->effect->name;?></th>
        <th><?php echo $lang->effect->category;?></th>
        <th class='w-150px'><?php echo $lang->effect->createdTime;?></th>
        <th class='w-180px'><?php echo $lang->actions;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($effects as $record):?>
      <?php $effect = $record->effect;?>
      <?php if(!is_object($effect)) continue;?>
      <?php $viewLink    = $this->config->admin->apiRoot . "effect-view-{$effect->id}-{$record->id}";?> 
      <?php $previewLink = $this->config->admin->apiRoot . 'user-login-'. helper::safe64Encode("/effect-preview-{$effect->id}-{$record->id}");?> 
      <tr class='text-left'>
        <td>
          <?php echo html::a($viewLink, $effect->name, "target='_blank'");?>
          <?php if(isset($blocks[$record->id])) echo "<span title='{$lang->effect->imported}'><i class='icon icon-check-sign'></i></span>";?>
        </td>
        <td><?php echo zget($categories, $effect->category);?></td>
        <td><?php echo $effect->createdTime;?></td>
        <td>
          <?php 
          echo html::a($previewLink, $lang->preview, "target='_blank' class='btn btn-sm'");
          if(!isset($blocks[$record->id]))echo html::a(inlink('importEffect', "id={$record->id}"), $lang->effect->import, "data-toggle='modal' class='btn btn-sm'");
          ?>
        </td> 
      </tr>
      <?php endforeach;?>
    </tbody>
    <tfoot>
      <tr><td colspan='7'><?php echo $pager->get('right', 'simple');?></td></tr>
    </tfoot>
  </table>
</div>
<?php else:?>
<div class='alert alert-info'><?php echo $lang->effect->noRsults?></div>
<?php endif;?>
<?php include '../../common/view/footer.admin.html.php';?>
