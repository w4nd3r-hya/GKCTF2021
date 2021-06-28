<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The import success view file of ui module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     ui
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.modal.html.php';?>
<div class='panel-body'>
  <div class='alert alert-success'><h2><?php echo $lang->ui->importThemeSuccess?></h2></div>
</div>
<script>
$(document).ready(function()
{
    setTimeout(function(){location.href= createLink('ui', 'settemplate')}, 4000);
});
</script>
<?php include '../../common/view/footer.modal.html.php';?>
