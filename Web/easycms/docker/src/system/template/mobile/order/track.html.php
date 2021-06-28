{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php*}
/**
 * The track view file of order for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
<div class='modal-dialog'>
  <div class='modal-content'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span></button>
      <h5 class='modal-title'>{$lang->order->track}</h5>
    </div>
    <div class='modal-body'>
      <table class='table table-layout'>
        <tbody>
          <tr>
            <th class='small'>{$lang->order->address}</th>
            <td>{$fullAddress}</td>
          </tr>
          <tr>
            <th class='small'>{$lang->order->deliveriedDate}</th>
            <td>{$order->deliveriedDate}</td>
          </tr>
          <tr>
            <th class='small'>{$lang->order->express}</th>
            <td>{if(!empty($order->express))} {$expressList[$order->express]} {/if}</td>
          </tr>
          <tr>
            <th class='small'>{$lang->order->waybill}</th>
            <td>{$order->waybill}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
