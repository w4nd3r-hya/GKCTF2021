<?php if(!defined("RUN_MODE")) die();?>
<?php include '../../common/view/header.admin.html.php';?>
<?php js::import($jsRoot . 'zeroclipboard/zeroclipboard.min.js');?>
<?php js::set('copySuccess', $lang->file->copySuccess);?>
<?php js::set('noFlashTip', $lang->file->noFlashTip);?>
<div id='mainMenu'>
  <div class='container'>
    <ul class='nav nav-underline' id='navMenu'>
      <?php
      echo "<li>" . html::a($this->createLink('ui', 'component'), $lang->ui->component) . '</li>';
      echo '<li>' . html::a($this->createLink('ui', 'effect'), $lang->effect->common) . '</li>';
      echo "<li class='active'>" . html::a($this->createLink('file', 'browsesource'), $lang->file->sourceList) . '</li>';
      ?>  
    </ul>
  </div>
</div>
<div class='panel'>
  <div class='panel-heading'>
    <?php $template = $this->config->template->{$this->app->clientDevice}->name;?>
    <?php $theme    = $this->config->template->{$this->app->clientDevice}->theme;?>
    <?php commonModel::printLink('file', 'browse', "objectType=source&objectID={$template}_{$theme}", $lang->file->uploadSource . '<i class="icon icon-upload-alt"></i>', "data-toggle='modal' class='radius-btn'");?>
    <?php echo html::a('javascript:;', $lang->file->batchSelect, "class='btn radius-btn batchSelect hide'")?>
    <div class="btn-group pull-right">
      <?php echo html::a('javascript:void(-1)', "<i class='icon icon-list-ul'></i>", "class='list-view'")?>
      <?php echo html::a('javascript:void(0)', "<i class='icon icon-th-large'></i>", "class='image-view'")?>
    </div>
  </div>
  <form action='<?php echo $this->createLink('file', 'batchDelete');?>' method='post' class='deleteForm'>
    <div id='imageView' class='panel-body'>
      <ul class='files-list clearfix'>
      <?php foreach($files as $file):?>
          <?php
          $imageHtml = '';
          $fileHtml  = '';
          $fullURL   = html::input('', $file->fullURL, "size='" . strlen($file->fullURL) . "' style='border:none; background:none;' onmouseover='this.select()'");
          $imagePath = $this->file->printFileURL($file);
          if($file->isImage)
          {
              $imageHtml .= "<li class='file-image file-{$file->extension}'>";
              $imageHtml .= html::a(helper::createLink('file', 'download', "fileID=$file->id&mose=left"), html::image($imagePath), "target='_blank' data-toggle='lightbox'");
              $imageHtml .= "<div class='file-source'><div class='input-group'>";
              $imageHtml .= "<span class='input-group-addon checkboxBox hidden'><input type='checkbox' name='fileList[]' value='<?php echo $file->id;?>' /></span>";
              $imageHtml .= "<input disabled='disabled' id='fullURL{$file->id}' type='text' value='{$imagePath}' class='form-control file-url'/><span class='input-group-btn'><button class='copyBtn btn' data-clipboard-target='fullURL{$file->id}'>{$lang->copy}</button></span></div></div>";
              $imageHtml .= "<div class='file-actions'>";
              $imageHtml .= html::a(helper::createLink('file', 'deletesource', "id=$file->id"), "<i class='icon-trash'></i>", "class='deleter'");
              $imageHtml .= html::a(helper::createLink('file', 'editsource', "id=$file->id"), "<i class='icon-pencil'></i>", "data-toggle='modal' data-title='{$lang->file->editSource}'");
              $imageHtml .= '</div>';
              $imageHtml .= '</li>';
          }
          else
          {
              $file->title = $file->title . ".$file->extension";
              $fileHtml .= "<li class='file file-{$file->extension}'>";
              $fileHtml .= html::a(helper::createLink('file', 'download', "fileID=$file->id&mouse=left"), $file->title, "target='_blank'");
              $fileHtml .= "<div class='file-source'><div class='input-group'>";
              $fileHtml .= "<span class='input-group-addon checkboxBox hidden'><input type='checkbox' name='fileList[]' value='<?php echo $file->id;?>' /></span>";
              $fileHtml .= "<input disabled='disabled' id='fullURL{$file->id}' type='text' value='{$imagePath}' class='form-control file-url'/><span class='input-group-btn'><button class='copyBtn btn' data-clipboard-target='fullURL{$file->id}'>{$lang->copy}</button></span></div></div>";
              $fileHtml .= "<span class='file-actions'>";
              $fileHtml .= html::a(helper::createLink('file', 'deletesource', "id=$file->id"), "<i class='icon-trash'></i>", "class='deleter'");
              $fileHtml .= html::a(helper::createLink('file', 'editsource', "id=$file->id"), "<i class='icon-edit'></i>", "data-toggle='modal' data-title='{$lang->file->editSource}'");
              $fileHtml .= '</span>';
              $fileHtml .= '</li>';
          }
          if($imageHtml or $fileHtml) echo $imageHtml . $fileHtml;
          ?>
      <?php endforeach;?>
      </ul>
      <div class='clearfix'>
        <?php if($files):?>
        <div class='actions pull-left hidden'>
          <label class="checkbox-inline">
            <input type="checkbox" class="checkAll" value='imageView' />
            <?php echo $lang->selectAll;?>
          </label>
          <?php echo html::submitButton($lang->delete, "btn radius-btn", "onclick='return confirm(\"{$lang->js->confirmDelete}\")'")?>
        </div>
        <?php endif;?>
        <?php $pager->show();?>
      </div>
    </div>
  </form>
  <form action='<?php echo $this->createLink('file', 'batchDelete');?>' method='post' class='deleteForm'>
    <div id='listView' class='hide'>
      <table class='table'>
        <thead>
          <tr class='text-center'>
            <th colspan='2'><?php echo $lang->file->source;?></th>
            <th><?php echo $lang->file->sourceURI;?></th>
            <th class='w-150px'><?php echo $lang->file->addedBy;?></th>
            <th class='w-160px'><?php echo $lang->file->addedDate;?></th>
            <th class='w-150px'><?php echo $lang->actions;?></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($files as $file):?>
          <tr class='text-center text-middle'>
            <td>
              <input type="checkbox" name="fileList[]" value="<?php echo $file->id;?>" />
            </td>
            <td class='text-left'>
              <?php
              if($file->isImage)
              {
                  echo html::a(inlink('download', "id=$file->id"), html::image($this->file->printFileURL($file, 'smallURL'), "class='image-small' title='{$file->title}'"), "data-toggle='lightbox' target='_blank'");
              }
              else
              {
                  echo html::a(inlink('download', "id=$file->id"), $file->title, "target='_blank'");
              }
              ?>
            </td>
            <td class='text-left'><?php echo $this->file->printFileURL($file);?></td>
            <td><?php echo isset($users[$file->addedBy]) ? $users[$file->addedBy] : '';?></td>
            <td><?php echo $file->addedDate;?></td>
            <td class='text-center'>
              <?php
              commonModel::printLink('file', 'editsource',   "id=$file->id", $lang->edit, "data-toggle='modal' class='btn'");
              commonModel::printLink('file', 'deletesource', "id=$file->id", $lang->delete, "class='deleter btn'");
              ?>
            </td>
          </tr>
          <?php endforeach;?>
        </tbody>
        <tfoot>
          <tr>
            <td class='text-left' colspan='2'>
              <?php if($files):?>
              <label class="checkbox-inline">
                <input type="checkbox" class="checkAll" value='listView' />
                <?php echo $lang->selectAll;?>
              </label>
              <?php echo html::submitButton($lang->delete, "btn radius-btn", "onclick='return confirm(\"{$lang->js->confirmDelete}\")'")?>
              <?php endif;?>
            </td>
            <td colspan='8'><?php $pager->show();?></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </form>
</div>
<script type="text/javascript">
var copyBtns = $('.copyBtn');
var clip = new ZeroClipboard(copyBtns);
clip.on('aftercopy', function(){$.zui.messager.success(v.copySuccess); });
</script>
<?php include '../../common/view/footer.admin.html.php';?>
