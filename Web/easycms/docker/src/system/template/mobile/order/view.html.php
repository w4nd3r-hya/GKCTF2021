{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The view view of order module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     order 
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{noparse}
<style>
#orderDetailTable {margin-bottom: 0;}
#orderDetailTable > tbody > tr > th {text-align: right; width: 90px;}
#orderDetailTable > tbody > tr > th,
#orderDetailTable > tbody > tr > td {border: none;}
</style>
{/noparse}
<table class='table' id='orderDetailTable'>
  <tbody>
    <tr>
      <th>{$lang->order->productInfo}</th>
      <td>
          {foreach($products as $product)}
            <div>
              <span>{!html::a(commonModel::createFrontLink('product', 'view', "id=$product->productID"), $product->productName, "target='_blank'")}</span>
              <span>{!echo $lang->order->price . $lang->colon . $product->price . ' ' . $lang->order->count . $lang->colon . $product->count}</span>
            </div>
          {/foreach}
        </dl>
      </td>
    </tr>
    {if($type == 'shop')}
      <tr>
        <th>{$lang->order->expressInfo}</th>
        <td>
        {if($order->deliveryStatus !== 'not_send')}
          {!echo $control->order->expressInfo($order) . '&nbsp;' . $order->waybill}
        {else}
          {$lang->order->noRecord}
        {/if}
        </td>
      </tr>
      <tr>
        <th>{$lang->order->address}</th>
        <td>
          {$address = json_decode($order->address)}
          {!echo $address->contact . ',' . $address->address . ',' . str2Entity($address->phone) . ',' . $address->zipcode}
        </td>
      </tr> 
    {/if}
    <tr>
      <th>{$lang->order->account}</th>
      <td>{!zget($users, $order->account, $order->account)}</td>
    </tr> 
    <tr>
      <th>{$lang->order->status}</th>
      <td>{$control->order->processStatus($order)}</td>
    </tr> 
    <tr>
      <th>{$lang->order->amount}</th>
      <td class='text-price'>{$order->amount}</td>
    </tr> 
    <tr>
      <th>{$lang->order->payment}</th>
      <td>{!zget($lang->order->paymentList, $order->payment)}</td>
    </tr> 
    <tr>
      <th>{$lang->order->note}</th>
      <td>{$order->note}</td>
    </tr> 
    <tr>
      <th>{$lang->order->createdDate}</th>
      <td>{$order->createdDate}</td>
    </tr> 
    {if($order->payment != 'COD' and ($order->paidDate > $order->createdDate))}
      <tr>
        <th>{$lang->order->paidDate}</th>
        <td>{$order->paidDate}</td>
      </tr> 
    {/if}
    {if($order->deliveriedDate > $order->createdDate)}
      <tr>
        <th>{$lang->order->deliveriedDate}</th>
        <td>{$order->deliveriedDate}</td>
      </tr> 
    {/if}
    {if($order->confirmedDate > $order->deliveriedDate)}
      <tr>
        <th>{$lang->order->confirmedDate}</th>
        <td>{$order->confirmedDate}</td>
      </tr> 
    {/if}
    {if($order->payment == 'COD' and ($order->paidDate > $order->createdDate))}
      <tr>
        <th>{$lang->order->paiedDate}</th>
        <td>{$order->paiedDate}</td>
      </tr> 
    {/if}
  </tbody>
</table>
