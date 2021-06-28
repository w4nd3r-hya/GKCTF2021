<?php if(!defined("RUN_MODE")) die();?>
<tr>
  <th><?php echo $lang->block->subscribe->fixInNav;?></th>
  <td><?php echo html::radio('params[fixInNav]', $lang->block->subscribe->fixInNavList, isset($block->content->fixInNav) ? $block->content->fixInNav : '0');?></td>
</tr>
