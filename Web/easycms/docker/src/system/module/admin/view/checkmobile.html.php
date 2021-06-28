<?php if(!defined("RUN_MODE")) die();?>
<?php include $app->getModuleRoot() . 'common/view/header.modal.html.php';?>
<form method='post' action='<?php echo inlink('checkMobile');?>' id='ajaxForm'>
  <table class='table table-form'>
    <tr>
      <th class='w-80px'><?php echo $lang->user->mobile;?></th>
      <td><?php echo html::input('mobile', $user->mobile, "class='form-control'");?></td>
      <td><?php echo html::a($this->createLink('admin', 'sendCodeByApi'), $lang->user->getCertifyCode, "id='smsSender' class='btn btn-xs'");?></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->captcha;?></th>
      <td><?php echo html::input('captcha', '', "class='form-control'");?></td>
    </tr>
    <tr>
      <th></th>
      <td><?php echo html::submitButton() . html::hidden('referer', $referer);?></td>
    </tr>
  </table>
</form>
<?php include $app->getModuleRoot() . 'common/view/footer.modal.html.php';?>
