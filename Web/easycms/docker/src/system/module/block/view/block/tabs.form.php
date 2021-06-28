<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The html block form view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
?>
<?php $template = $this->config->template->{$this->app->clientDevice}->name;?>
<?php $blocks = $this->block->getPairs($template);?>
<tr>
  <th><?php echo $lang->block->childBlock;?></th>
  <td>
    <?php if(isset($block))  echo html::select('params[children][]', $blocks, zget($block->content, 'children'), "class='form-control chosen' multiple");?>
    <?php if(!isset($block)) echo html::select('params[children][]', $blocks, '', "class='form-control chosen' multiple");?>
  </div>
  </td>
</tr>
