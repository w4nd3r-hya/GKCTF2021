<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The setpage view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
  <form class='ve-form' id='ajaxForm' method='post'>
    <table class='table table-form w-p90'>
      <tbody>
        <tr>
          <th class='w-120px'><?php echo $lang->block->sideGrid ?></th>
          <td>
            <?php echo html::select('sideGrid', $lang->ui->theme->sideGridList, $sideGrid, "class='form-control'");?>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->block->sideFloat ?></th>
          <td>
            <?php echo html::select('sideFloat', $lang->ui->theme->sideFloatList, $sideFloat, "class='form-control'");?>
          </td>
        </tr>
        <tr>
          <th></th><td><?php echo html::submitButton();?></td>
        </tr>
      </tbody>
    </table>
  </form>
</div>
<div>
<?php js::set('key', $key);?>
<?php include '../../common/view/footer.modal.html.php';?>
