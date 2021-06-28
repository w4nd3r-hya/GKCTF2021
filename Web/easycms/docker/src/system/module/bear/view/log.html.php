<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The log view file of bear module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     bear
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/datepicker.html.php';?>
<div class='panel'>
  <div class='panel-heading'>
    <ul class='nav nav-tabs' id='typeNav'>
      <?php foreach($lang->bear->logModes as $code => $modeName):?>
      <?php $class = $mode == $code ? "class='active'" : '';?>
      <li <?php echo $class?>><?php echo html::a(inlink('log', "mode=$code"), $modeName);?></li>
      <?php endforeach;?>
      <li>
        <form method='get' action="<?php echo inlink('traffic')?>">
          <?php echo html::hidden('m', 'bear') . html::hidden('f', 'log') . html::hidden('mode', 'fixed') . html::hidden('orderBy', $orderBy) . html::hidden('recTotal', 0) . html::hidden('recPerPage', 20), html::hidden('pageID', 0);?>
          <table class='table table-borderless'>
            <tr>
              <td style='padding:4px'>
                <?php echo html::input('begin', $begin, "placeholder='{$lang->bear->begin}' class='form-date w-120px'")?> 
                <?php echo html::input('end', $end, "placeholder='{$lang->bear->end}' class='form-date w-120px'")?>
                <?php echo html::submitButton($lang->search->common, "btn btn-xs btn-info");?>
              </td>
            </tr>
          </table>
        </form>
      </li>
    </ul>
  </div>
  <table class='table table-list'>
    <thead>
      <tr class='text-center'>
        <th><?php echo $lang->bear->id;?></th>
        <th class='text-left'><?php echo $lang->bear->url;?></th>
        <th><?php echo $lang->bear->status;?></th>
        <th><?php echo $lang->bear->response;?></th>
        <th><?php echo $lang->bear->time;?></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($records as $log):?>
      <tr class='text-center'>
        <td class='text-center'><?php echo $log->id;?></td>
        <td class='text-left'><?php echo $log->url;?></td>
        <td><?php echo zget($lang->bear->submitStatusList, $log->status, '');?></td>
        <td><?php echo $log->response;?></td>
        <td><?php echo $log->time;?></td>
      </tr>
      <?php endforeach;?>
      <tr>
        <td class='text-right' colspan="5"><?php echo $pager->show();?></td>
      </tr>
    </tbody>
  </table> 
</div>
<?php include '../../common/view/footer.admin.html.php';?>
