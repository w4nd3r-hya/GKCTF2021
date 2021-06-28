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
<form class='form-condensed' action="<?php echo inlink('note', "fileName=$fileName")?>" method='post' id='ajaxForm'>
  <table class='w-p100'>
    <tr>
      <td>
        <div class='input-group'>
          <?php $note = isset($config->backup->note->{$fileName}) ? $config->backup->note->{$fileName} : '';?>
          <?php echo html::input('note', $note, "class='form-control'");?>
        </div>
      </td>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.modal.html.php';?>
