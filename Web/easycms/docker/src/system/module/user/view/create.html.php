<?php if(!defined("RUN_MODE")) die();?>
<?php include '../../common/view/header.modal.html.php';?>
<?php js::import($jsRoot . 'fingerprint/fingerprint.js');?>
<?php if($pass):?>
<form method='post' action='<?php echo inlink('create')?>' id='ajaxForm' class='form form-inline' data-checkfingerprint='1'>
  <table class='table table-form form-inline'>
    <tr>
      <th><?php echo $lang->user->account;?></th>
      <td>
        <?php echo html::input('account', '', "class='form-control'")?>
      </td><td></td>
    </tr>  
    <tr>
      <th class='w-100px'><?php echo $lang->user->realname;?></th>
      <td>
        <?php echo html::input("realname", '', "class='form-control'")?>
      </td><td></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->type;?></th>
      <td><?php echo html::radio('admin', $lang->user->accountTypeList, 'no', "class='checkbox'")?></td><td></td>
    </tr>
    <tr class="groups" style='display:none'>
      <th><?php echo $lang->user->privilege;?></th>
      <td><?php echo html::checkbox('groups', $groups, '');?></td><td></td>
    </tr>
    <tr>
      <th><?php echo $lang->user->email;?></th>
      <td>
        <?php echo html::input('email', '', "class='form-control'");?>
      </td><td></td>
    </tr>  
    <tr>
      <th><?php echo $lang->user->password;?></th>
      <td>
        <?php echo html::password('password1', '', "class='form-control' autocomplete='off'")?>
      </td><td></td>
    </tr>  
    <tr>
      <th><?php echo $lang->user->password2;?></th>
      <td><?php echo html::password('password2', '', "class='form-control'");?></td><td></td>
    </tr>  
    <tr>
      <th></th>
      <td colspan="2"><?php echo html::submitButton() . html::hidden('token', $token);?></td>
    </tr>
  </table>
</form>        
<?php else:?>
<?php
$url = helper::safe64Encode($this->createLink('user', 'create'));
include '../../guarder/view/validate.html.php';
?>
<?php endif;?>

<?php include '../../common/view/footer.modal.html.php';?>
