<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The html widget form view file of widget module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     widget
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php $config->widget->editor->create =  array('id' => 'content', 'tools' => 'simple', 'filterMode' => false); ?>
<?php $config->widget->editor->edit   =  array('id' => 'content', 'tools' => 'simple', 'filterMode' => false); ?>
<?php include '../../common/view/kindeditor.html.php';?>
<tr>
  <th><?php echo $lang->widget->content;?></th>
  <td colspan='2'>
  <textarea class='form-control' name='params[content]' id="content" rows='10'><?php if(isset($widget)) echo $widget->params->content?></textarea>
  </td>
</tr>
