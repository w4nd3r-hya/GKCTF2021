{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The delivery view of order module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     order 
 * @version     $Id$
 * @link        http://www.zentao.net
 */
/php*}
{include TPL_ROOT . 'common/header.modal.html.php'}
<table class='table table-form'>
  <tr>
    <th class='w-100px'>{$lang->order->address}</th>
    <td>{$fullAddress}</td>
  </tr>
  <tr>
    <th class='w-100px'>{$lang->order->deliveriedDate}</th>
    <td>{$order->deliveriedDate}</td>
  </tr>
  <tr>
    <th class='w-100px'>{$lang->order->express}</th>
    <td>{!zget($expressList, $order->express, '')}</td>
  </tr>
  <tr>
    <th class='w-100px'>{$lang->order->waybill}</th>
    <td>{$order->waybill}</td>
  </tr>
</table>
{include TPL_ROOT .'/common/footer.modal.html.php'}
