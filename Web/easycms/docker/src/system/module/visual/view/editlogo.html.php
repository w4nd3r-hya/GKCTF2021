<?php if(!defined("RUN_MODE")) die();?>
<?php include "header.html.php"; ?>
<form method='post' action='<?php echo helper::createLink('ui', 'setlogo');?>' class='ve-form mw-800px center-block' enctype='multipart/form-data'>
  <table class='table table-form'>
    <tr>
      <th><?php echo $lang->site->name;?></th>
      <td><?php echo html::input('name', $this->config->site->name, "class='form-control'");?></td><td></td>
    </tr>
    <tr>
      <th>
        <?php echo $lang->ui->logo;?>
      </th>
      <td><?php echo html::file('logo', "class='form-control'");?></td>
      <td><?php echo html::select('theme', $lang->ui->logoList, '', "class='form-control'");?></td>
    </tr>
    <tr>
      <td></td>
      <td colspan='2'>
        <strong class='text-info'>
          <?php if($this->app->clientDevice == 'desktop') printf($lang->ui->suitableLogoSize, '50px-80px', '80px-240px');?>
          <?php if($this->app->clientDevice == 'mobile') printf($lang->ui->suitableLogoSize, '<50px', '50px-200px');?>
        </strong>
      </td>
    </tr>
    <tr><td></td><td colspan='2'><?php if(isset($logo->webPath)) echo html::image($this->loadModel('file')->printFileURL($logo), "class='logo'");?></td></tr>
    <tr>
      <td></td>
      <td colspan='2'>
        <?php echo html::submitButton();?>
      </td>
    </tr>
  </table>
</form>
<?php include "footer.html.php"; ?>
