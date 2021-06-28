<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The public form items of widget of RanZhi.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      guanxiying <guanxiying@xirangit.com>
 * @package     widget
 * @version     $Id$
 * @link        http://www.ranzhico.com
 */
?>
<?php $this->loadModel('widget', 'sys');?>
<tr>
  <th class='w-100px'><?php echo $lang->widget->name?></th>
  <td><?php echo html::input('title', $widget ? $widget->title : '', "class='form-control'")?></td>
</tr>
<tr>
  <th><?php echo $lang->widget->style;?></th>
  <td>
    <div class='w-240px'>
      <div class='input-group'>
        <span class='input-group-addon'><?php echo $lang->widget->grid;?></span>
        <?php echo html::select('grid', $config->widget->gridOptions, $widget ? $widget->grid : 4, "class='form-control'")?>
        <div class='input-group-btn widget'>
          <?php $btn = isset($widget->params->color) ? 'btn-' . $widget->params->color : 'btn-default'?>
          <button type='button' class="btn <?php echo $btn;?> dropdown-toggle" data-toggle='dropdown'>
            <?php echo $lang->widget->color;?> <span class='caret'></span>
          </button>
          <?php echo html::hidden('params[color]', isset($widget->params->color) ? $widget->params->color : 'default');?>
          <div class='dropdown-menu buttons'>
            <li><button type='button' data-id='default' class='btn btn-widget btn-default'>&nbsp;</li>
            <li><button type='button' data-id='primary' class='btn btn-widget btn-primary'>&nbsp;</li>
            <li><button type='button' data-id='warning' class='btn btn-widget btn-warning'>&nbsp;</li>
            <li><button type='button' data-id='danger' class='btn btn-widget btn-danger'>&nbsp;</li>
            <li><button type='button' data-id='success' class='btn btn-widget btn-success'>&nbsp;</li>
            <li><button type='button' data-id='info' class='btn btn-widget btn-info'>&nbsp;</li>
          </div>
        </div>
      </div>
    </div>
  </td>
</tr>
