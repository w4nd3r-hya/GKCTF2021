<?php if(!defined("RUN_MODE")) die();?>
<?php $this->app->loadLang('order');?>
<tr>
  <th><?php echo $lang->widget->lblNum;?></th>
  <td><?php echo html::input('params[limit]', $widget ? zget($widget->params, 'limit', 8) : 8, "class='form-control w-300px'");?></td>
</tr>
<tr>
  <th><?php echo $lang->order->status;?></th>
  <td><?php echo html::select('params[status]', $lang->order->statusList, $widget ? zget($widget->params, 'status', '') : '', "class='form-control w-300px'");?></td>
</tr>
