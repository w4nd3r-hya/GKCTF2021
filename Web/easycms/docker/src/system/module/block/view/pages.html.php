<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The browse view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><?php echo $lang->block->pages;?></strong>
  </div>
  <table class='table' style='margin-top:10px;'>
    <tr>
      <?php $i = 0;?>
      <?php foreach($config->block->pageGroupList as $group => $pageList):?>
      <?php ++$i;?>
      <?php $j = 0;?>
      <td class='w-p25'>
        <?php foreach($pageList as $page):?>
        <div class='panel page-panel'>
          <div class='label label-badge label-<?php echo $group;?>'><?php echo $i . '.' . ++$j;?></div>
          <div class='text-center text-important page-name'><?php echo $lang->block->{$template}->pages[$page];?></div>
          <div class='panel-body text-center'>
            <?php foreach($lang->block->{$template}->regions->{$page} as $region => $regionName):?>
            <?php commonModel::printLink('block', 'setregion', "page={$page}&region=$region", $regionName, "class='btn-region' data-toggle='modal'");?>
            <?php endforeach;?>
          </div>
        </div>
        <?php endforeach;?>
      </td>
      <?php endforeach;?>
    </tr>
  </table>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
