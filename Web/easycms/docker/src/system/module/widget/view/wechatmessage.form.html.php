<?php if(!defined("RUN_MODE")) die();?>
<tr>
  <th><?php echo $lang->widget->lblNum;?></th>
  <td><?php echo html::input('params[limit]', $widget ? zget($widget->params, 'limit', 8) : 8, "class='form-control w-300px'");?></td>
</tr>
