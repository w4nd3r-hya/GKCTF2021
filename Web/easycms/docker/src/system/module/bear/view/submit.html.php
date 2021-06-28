<?php if(!defined("RUN_MODE")) die();?>
<?php include '../../common/view/header.modal.html.php';?>
<form method='post' id='ajaxForm' action='<?php echo inlink("submit", "objectType={$objectType}&objectID={$objectID}");?>'>
  <table class='table table-form'>
    <tr>
      <th class='w-130px'><?php echo $lang->bear->submitType;?></th>
      <td class='w-p40'>
        <?php echo html::radio("type", $lang->bear->submitTypes, 'batch', "");?>
      </td>
      <td></td>
    </tr>
    <tr>
      <th></td>
      <td colspan='2'><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.modal.html.php';?>
