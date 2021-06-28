<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The page form view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<tr>
  <th><?php echo $lang->block->limit;?></th>
  <td><?php echo html::input('params[limit]', isset($block->content->limit) ? $block->content->limit : '', "class='text-4 form-control'");?></td>
</tr>
<tr>
  <th><?php echo $lang->block->showImage;?></th>
  <td><input type='checkbox' name='params[image]' <?php if(isset($block->content->image) && $block->content->image) echo 'checked';?> value='1' /></td>
</tr>
<tr class="image <?php echo (isset($block->content->image) and $block->content->image) ? '' : 'hide';?>">
  <th><?php echo $lang->block->image;?></th>
  <td>
    <div class='input-group'>
      <?php echo html::select('params[imagePosition]', $lang->block->imagePositionList, isset($block->content->imagePosition) ? $block->content->imagePosition : '', "class='form-control'");?>
      <span class='input-group-addon fix-border fix-padding'></span>
      <?php echo html::select('params[imageSize]', $lang->block->imageSizeList, isset($block->content->imageSize) ? $block->content->imageSize : '', "class='form-control'");?>
      <span class='input-group-addon fix-border'><?php echo $lang->block->maxWidth;?></span>
      <?php echo html::input('params[imageWidth]', isset($block->content->imageWidth) ? $block->content->imageWidth : '60', "class='form-control'");?>
      <span class='input-group-addon'>px</span>
    </div>
  </td>
</tr>
<tr>
  <th><?php echo $lang->block->showTime;?></th>
  <td><input type='checkbox' name='params[time]' <?php if(isset($block->content->time) && $block->content->time) echo 'checked';?> value='1' /></td>
</tr>
