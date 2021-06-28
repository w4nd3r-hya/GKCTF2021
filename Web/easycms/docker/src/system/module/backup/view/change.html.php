<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The change view file of backup module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xiragit.com>
 * @package     backup
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<form class='form-condensed' action="<?php echo inlink('change')?>" method='post' id='ajaxForm'>
  <table class='w-p100'>
    <tr>
      <td>
        <div class='input-group'>
          <?php echo html::input('holdDays', $config->backup->holdDays, "class='form-control'");?>
          <strong class='input-group-addon'><?php echo $lang->day;?></strong>
        </div>
      </td>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.modal.html.php';?>
