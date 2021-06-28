<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The setting view file of bear module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     bear
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class="icon-plus"></i> <?php echo $lang->bear->setting;?></strong>
  </div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm'>
      <table class='table table-form w-p50'>
        <tr>
          <th class='w-100px'><?php echo $lang->bear->type;?></th>
          <td><?php echo html::select('type', $lang->bear->typeList, zget($this->config->bear, 'type', 3), "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->bear->name;?></th>
          <td><?php echo html::input('name', zget($this->config->bear, 'name', ''), "class='form-control'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->bear->appID;?></th>
          <td><?php echo html::input('appID', zget($this->config->bear, 'appID', ''), "class='form-control' placeholder='{$lang->bear->placeholder->appID}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->bear->token;?></th>
          <td><?php echo html::input('token', zget($this->config->bear, 'token', ''), "class='form-control' placeholder='{$lang->bear->placeholder->token}'");?></td>
        </tr>
        <tr>
          <th><?php echo $lang->bear->autoSync;?></th>
          <td><?php echo html::checkbox('autoSync', $lang->bear->syncObjects, zget($this->config->bear, 'autoSync', ''));?></td>
        </tr>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
