<?php if(!defined("RUN_MODE")) die();?>
<?php include '../../common/view/header.admin.html.php';?>
<div class='panel'>
  <div class='panel-heading' style='height:39px;'>
    <ul id='typeNav' class='nav nav-tabs pull-left'>
      <li class='<?php echo $type == 'valid' ? 'active' : '';?>' data-type='internal' ><?php echo html::a(inlink('admin', "type=valid"), $lang->file->fileList);?></li>
      <li class='<?php echo $type == 'invalid' ? 'active' : '';?>' data-type='internal' ><?php echo html::a(inlink('admin', "type=invalid"), $lang->file->invalidFile);?></li>
    </ul>
    <?php if($type == 'invalid'):?>
      <div class='panel-actions'>
        <?php echo html::a(inlink('deleteAllInvalid'), $lang->file->clearAllInvalid, "class='btn btn-primary deleter pull-right'");?>
      </div>
    <?php endif;?>
  </div>
  <?php if($type == 'valid'):?>
  <form method='post' id='ajaxForm' action='<?php echo inlink('batchdelete');?>'>
    <table class='table table-hover table-striped tablesorter table-fixed' id='orderList'>
      <thead>
        <tr class='text-center'>
          <th class=' w-60px'><?php echo $lang->file->id;?></th>
          <th><?php echo $lang->file->source;?></th>
          <th><?php echo $lang->file->sourceURI;?></th>
          <th class='w-60px'><?php echo $lang->file->extension;?></th>
          <th class='w-80px'><?php echo $lang->file->size;?></th>
          <th class='w-100px'><?php echo $lang->file->addedBy;?></th>
          <th class='w-160px'><?php echo $lang->file->addedDate;?></th>
          <th class='w-80px'><?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($files as $file):?>
          <tr class='text-center text-middle'>
            <td>
              <input type='checkbox' name='fileList[]'  value='<?php echo $file->id;?>'/>
              <?php echo $file->id;?>
            </td>
            <td class='text-center'>
              <?php 
                if($file->isImage and $file->existStatus == 'yes')
                {
                  echo html::a(helper::createLink('file', 'download', "fileID=$file->id"), html::image($this->file->printFileURL($file), "class='image-small'"), "target='_blank' data-toggle='lightbox'");
                }
                else
                {
                  echo html::a(inlink('download', "id=$file->id"), $file->title, "target='_blank'");
                }
              ?>
            </td>
            <td class='text-left 
              <?php 
                if(isset($file->existStatus)) 
                {
                  echo $file->existStatus == 'no' ? 'red' : ''; 
                }
              ?>'>
              <?php echo $file->pathname;?>
            </td>
            <td><?php echo $file->extension;?></td>
            <td><?php echo number_format($file->size / 1024 , 1) . 'K';?></td>
            <td><?php echo isset($file->addedBy) ? $file->addedBy : '';?></td>
            <td><?php echo $file->addedDate;?></td>
            <td class='text-center'>
              <?php
              commonModel::printLink('file', 'edit',   "fileID=$file->id", $lang->edit, "data-toggle='modal'");
              commonModel::printLink('file', 'delete', "fileID=$file->id", $lang->delete, "class='deleter'");
              ?>
            </td>
          </tr>
        <?php endforeach;?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan='8'>
            <div class='pull-left'>
              <div class='btn-group'><?php echo html::selectButton();?></div>
              <?php echo html::submitButton($lang->delete);?>
              <?php echo $lang->file->fileTip;?>
            </div>
            <?php $pager->show('right', 'full');?>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
  <?php else:?>
  <form method='post' id='ajaxForm' action='<?php echo inlink('batchdeleteinvalid');?>'>
    <table class='table table-hover table-striped tablesorter table-fixed' id='orderList'>
      <thead>
        <tr class='text-center'>
          <th><?php echo $lang->file->common;?></th>
          <th class='w-100px'><?php echo $lang->file->extension;?></th>
          <th class='w-100px'><?php echo $lang->file->size;?></th>
          <th class='w-160px'><?php echo $lang->file->addedDate;?></th>
          <th class='w-100px'><?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($files as $file):?>
          <tr class='text-center text-middle'>
            <td class='text-left'>
              <input type='checkbox' name='fileList[]'  value='<?php echo $file->pathname;?>'/>
              <?php echo $file->pathname;?>
            </td>
            <td><?php echo $file->extension;?></td>
            <td><?php echo number_format($file->size / 1024 , 1) . 'K';?></td>
            <td><?php echo $file->addedDate;?></td>
            <td class='text-center'>
              <?php 
                $pathname = urlencode($file->pathname);
                commonModel::printLink('file', 'deleteInvalidFile', "pathname=" . $pathname, $lang->delete, "class='deleter'");
              ?>
            </td>
          </tr>
        <?php endforeach;?>
      </tbody>
      <tfoot>
        <tr>
          <td colspan='5'>
            <div class='pull-left'>
              <div class='btn-group'><?php echo html::selectButton();?></div>
              <?php echo html::submitButton($lang->delete);?>
            </div>
            <?php $pager->show('right', 'full');?>
          </td>
        </tr>
      </tfoot>
    </table>
  </form>
  <?php endif;?>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
