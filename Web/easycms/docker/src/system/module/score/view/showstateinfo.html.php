<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The showStateInfo view file of score module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     score
 * @version     $Id$
 * @link        http://www.zentao.net
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon-refresh'></i> <?php echo $lang->score->statement;?></strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' enctype='multipart/form-data'>
      <div class='form-group'><label><?php echo $lang->score->stateDesc;?></label></div>
      <div class='from-group'><?php echo html::submitButton($lang->score->statement) . html::hidden('action', 'update');?></div>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
