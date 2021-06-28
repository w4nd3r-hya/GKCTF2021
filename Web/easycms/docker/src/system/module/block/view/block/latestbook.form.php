<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The book form view file of block module of chanzhiEPS.
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
  <th><?php echo $lang->block->sort;?></th>
  <td><?php echo html::select('params[sort]', $this->lang->block->book->sortList, isset($block->content->sort) ? $block->content->sort : 'order', "class='form-control chosen'");?></td>
</tr>
<tr>
  <th><?php echo $lang->block->book->showType;?></th>
  <td><?php echo html::select('params[showType]', $this->lang->block->book->showTypeList, isset($block->content->showType) ? $block->content->showType : 'block', "class='form-control chosen'");?></td>
</tr>
<tr>
  <th><?php echo $lang->block->limit;?></th>
  <td><?php echo html::input('params[limit]', isset($block->content->limit) ? $block->content->limit : 6, "class='form-control'");?></td>
</tr>
<tr class='recperrow hide'>
  <th><?php echo $lang->block->recPerRow;?></th>
  <td><?php echo html::input('params[recPerRow]', isset($block->content->recPerRow) ? $block->content->recPerRow : 1, "class='form-control'");?></td>
</tr>
