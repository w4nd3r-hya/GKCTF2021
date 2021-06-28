<?php if(!defined("RUN_MODE")) die();?>
<?php include '../../common/header.modal.html.php'; ?>
<form method='post' action='<?php echo inlink('checkEmail');?>' id='ajaxForm'>
  <table class='table table-form'>
    <tr>
      <th class='w-80px'><?php echo $lang->user->email;?></th>
      <td><?php echo html::input('email', $user->email, "class='form-control'");?></td>
      <td><?php echo html::a($this->createLink('admin', 'sendCodeByApi'), $lang->user->getCertifyCode, "id='mailSender' class='btn btn-xs'");?></td>
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
<?php include '../../common/footer.modal.html.php'; ?>
