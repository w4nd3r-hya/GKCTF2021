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
{include TPL_ROOT . 'common/header.modal.html.php'}
<table class='table table-form'>
  <tr>
    <th class='w-80px'>{!echo $lang->order->productInfo}</th>
    <td>
      {foreach($products as $product)}
      <div>
        <span>{!html::a(commonModel::createFrontLink('product', 'view', "id=$product->productID"), $product->productName, "target='_blank'")}</span>
        <span>{!echo $lang->order->price . $lang->colon . $product->price . ' ' . $lang->order->count . $lang->colon . $product->count}</span>
      </div>
      {/foreach}
    </td>
  </tr>
  {if($type == 'shop')}
  <tr>
    <th class='w-80px'>{!echo $lang->order->expressInfo}</th>
    <td>
    {if($order->deliveryStatus !== 'not_send')} 
      {!echo $control->order->expressInfo($order) . '&nbsp;' . $order->waybill}
    {else}
      {$lang->order->noRecord}
    {/if}
    </td>
  </tr>
  <tr>
    <th class='w-80px'>{!echo $lang->order->address}</th>
    <td>
      {$address = json_decode($order->address)}
      {!echo $address->contact . ',' . $address->address . ',' . str2Entity($address->phone) . ',' . $address->zipcode}
    </td>
  </tr> 
  {/if}
  <tr>
    <th class='w-80px'>{!echo $lang->order->account}</th>
    <td>{!zget($users, $order->account, $order->account)}</td>
  </tr> 
  <tr>
    <th>{!echo $lang->order->status}</th>
    <td>{!echo $control->order->processStatus($order)}</td>
  </tr> 
  <tr>
    <th>{!echo $lang->order->amount}</th>
    <td>{!echo $order->amount}</td>
  </tr> 
  <tr>
    <th>{!echo $lang->order->payment}</th>
    <td>{!zget($lang->order->paymentList, $order->payment)}</td>
  </tr> 
  <tr>
    <th class='w-80px'>{!echo $lang->order->note}</th>
    <td>{!echo $order->note}</td>
  </tr> 
  <tr>
    <th>{!echo $lang->order->createdDate}</th>
    <td>{!echo $order->createdDate}</td>
  </tr> 
  {if($order->payment != 'COD' and ($order->paidDate > $order->createdDate))}
  <tr>
    <th>{!echo $lang->order->paidDate}</th>
    <td>{!echo $order->paidDate}</td>
  </tr> 
  {/if}
  {if($order->deliveriedDate > $order->createdDate)}
  <tr>
    <th>{!echo $lang->order->deliveriedDate}</th>
    <td>{!echo $order->deliveriedDate}</td>
  </tr> 
  {/if}
  {if($order->confirmedDate > $order->deliveriedDate)}
  <tr>
    <th>{!echo $lang->order->confirmedDate}</th>
    <td>{!echo $order->confirmedDate}</td>
  </tr> 
  {/if}
  {if($order->payment == 'COD' and ($order->paidDate > $order->createdDate))}
  <tr>
    <th>{!echo $lang->order->paiedDate}</th>
    <td>{!echo $order->paiedDate}</td>
  </tr> 
  {/if}
</table>
{include TPL_ROOT .'/common/footer.modal.html.php'}
