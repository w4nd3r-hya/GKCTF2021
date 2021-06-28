<?php if(!defined("RUN_MODE")) die();?>
<?php 
/**
 * The admin view of order module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     order 
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php js::set('finishWarning', $lang->order->finishWarning);?>
<?php if(count($lang->order->types) > 1):?>
<div class='col-md-1'>
  <ul class='nav nav-primary nav-stacked user-control-nav'>
    <?php foreach($lang->order->types as $typeCode => $name):?>
    <?php $class = $type == $typeCode ? 'active' : '';?>
    <?php echo '<li class="' . $class . '">' . html::a(helper::createLink('order', 'admin', "type=$typeCode&mode=all"), $name) . '</li>';?> 
    <?php endforeach;?>
  </ul>
</div>
<?php endif;?>
<div class='<?php echo count($lang->order->types) > 1 ? 'col-md-11' : 'col-md-12'?>'>
  <div class='panel'>
    <div class='panel-heading'>
      <ul id='typeNav' class='nav nav-tabs'>
        <?php foreach($lang->order->searchLabels as $label):?>
        <?php list($title, $params) = explode('|', $label);?>
        <?php $class = strpos(strtolower($this->server->query_string), strtolower($params)) == false ? '' : "class='active'";?>
        <?php parse_str($this->server->query_string, $queryPart);?>
        <?php if(count($queryPart) == 2 and $params == 'mode=all') $class = "class='active'";?>
        <li <?php echo $class;?> data-type='internal' ><?php echo html::a(inlink('admin', "type={$type}&" . $params), $title);?></li>
        <?php endforeach;?>
      </ul> 
    </div>
    <table class='table table-hover table-striped tablesorter table-fixed' id='orderList'>
      <thead>
        <tr class='text-center'>
          <?php $vars = "type=$type&mode=$mode&param={$param}&orderBy=%s&recTotal={$pager->recTotal}&recPerPage={$pager->recPerPage}";?>
          <th class='w-60px'><?php commonModel::printOrderLink('id', $orderBy, $vars, $lang->order->id);?></th>
          <th class='w-80px'><?php commonModel::printOrderLink('type', $orderBy, $vars, $lang->order->type);?></th>
          <th class='w-90px'><?php commonModel::printOrderLink('account', $orderBy, $vars, $lang->order->account);?></th>
          <th><?php echo $lang->order->productInfo;?></th>
          <th class='w-80px'><?php commonModel::printOrderLink('amount', $orderBy, $vars, $lang->order->amount);?></th>
          <th class='w-80px'><?php commonModel::printOrderLink('status', $orderBy, $vars, $lang->product->status);?></th>
          <th class='w-80px'><?php commonModel::printOrderLink('payStatus', $orderBy, $vars, $lang->order->payStatus);?></th>
          <th><?php echo $lang->order->note;?></th>
          <th class='w-100px'><?php echo $lang->order->last;?></th>
          <th class="<?php echo ($this->app->clientLang == 'en') ? 'w-280px' : 'w-250px';?>"><?php echo $lang->actions;?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($orders as $order):?>
        <?php $goodsInfo = $this->order->printGoods($order);?>
        <tr class='text-center text-top'>
          <td><?php echo $order->id;?></td>
          <td> <?php echo zget($lang->order->types, $order->type);?> </td>
          <td><?php echo zget($users, $order->account);?></td>
          <td class='text-left' <?php echo strip_tags($goodsInfo);?>><?php echo $goodsInfo;?> </td>
          <td><?php echo $order->amount;?></td>
          <td><?php echo $this->order->processStatus($order);?></td>
          <td><?php echo zget($lang->order->payStatusList, $order->payStatus, '');?></td>
          <td title='<?php echo $order->note;?>' class='text-left'><?php echo $order->note;?></td>
          <td><?php echo ($order->last == '0000-00-00 00:00:00') ? '' : formatTime($order->last, 'm-d H:i');?></td>
          <td class='text-center'><?php $this->order->printActions($order);?></td>
        </tr>
        <?php endforeach;?>
      </tbody>
      <tfoot><tr><td colspan='10'><?php $pager->show();?></td></tr></tfoot>
    </table>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
