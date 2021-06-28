<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The remind view file of wechat module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     wechat
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php
$webRoot = $config->webRoot;
$jsRoot  = $webRoot . "js/";
if(isset($pageCSS)) css::internal($pageCSS);
include '../../common/view/chosen.html.php';
?>
<?php if($config->mail->turnon):?>
<form method='post' action='<?php echo inlink('remind', "public={$public->id}");?>' id='ajaxForm'>
  <table class='table table-form'>
    <tr>
      <th class='w-130px'><?php echo $lang->wechat->remindUsers;?></th>
      <td><?php echo html::select('remindUsers[]', $users,  $public->remindUsers, "class='form-control chosen' multiple");?></td>
    </tr>

    <tr>
      <th></th>
      <td><?php echo html::submitButton();?></td>
    </tr>
  </table>
  <div class='alert alert-warning'><?php echo $lang->wechat->remindNotice?></div>
</form>
<?php else:?>
<div class='alert alert-danger'><?php echo $lang->wechat->remindNoMail?></div>
<?php endif;?>
<?php if(isset($pageJS)) js::execute($pageJS);?>
