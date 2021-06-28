<?php if(!defined("RUN_MODE")) die();?>
<?php include '../../common/view/header.modal.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<form method='post' id='ajaxForm' action='<?php echo inlink("stick", "articleID={$article->id}");?>'>
  <table class='table table-form'>
    <tr>
      <th class='w-80px'><?php echo $lang->article->stick;?></th>
      <td><?php echo html::radio('sticky', $lang->article->sticks, $article->sticky);?></td>
    </tr>
    <tr class="<?php if($article->sticky == 0) echo 'hide';?>">
      <th class='w-80px'><?php echo $lang->article->stickBold;?></th>
      <td>
        <?php $checked = $article->stickBold ? 'checked' : '';?>
        <?php echo "<input type='checkbox' name='stickBold' id='stickBold' value='1' {$checked} />";?>
      </td>
    </tr>
    <tr class="<?php if($article->sticky == 0) echo 'hide';?>">
      <th class='w-80px'><?php echo $lang->article->stickTime;?></th>
      <td>
        <div class='input-append date'>
          <?php echo html::input('stickTime', formatTime($article->stickTime), "class='form-control form-datetime'");?>
          <span class='add-on'><button class='btn btn-default' type='button'><i class='icon-calendar'></i></button></span>
        </div>
      </td>
    </tr>
    <tr>
      <td></td>
      <td colspan='2'><?php echo html::submitButton();?></td>
    </tr>
  </table>
</form>
<?php include '../../common/view/footer.modal.html.php';?>
