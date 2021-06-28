{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The check view of order module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     order 
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
*/php*}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{!js::set('goToPay', $lang->order->goToPay)}
{!js::set('paid', $lang->order->paid)}
<div class='panel order-check'>
  <div class='panel-heading'><strong>{!echo $lang->order->selectPayment}</strong></div>
  <form id='checkForm' action='{!echo helper::createLink('order', 'pay', "orderID=$order->id")}' method='post' target='_blank'>
    <div class='panel-body'>
      <div id='products'>
        <table class='table table-list'>
          <thead>
            <tr class='text-center'>
              <td class='text-left'><strong>{!echo $lang->order->productInfo}</strong></td>
              <td>{!echo $lang->order->count}</td>
              <td>{!echo $lang->order->amount}</td>
            </tr>
          </thead>
          {foreach($products as $productID => $product)}
          <tr>
            <td class='text-left text-middle'>
              {!echo $product->productName}
            </td>
            <td class='w-140px text-middle text-center'>
              <div class='text-count'>{!echo $product->count}</div>
            </td>
            <td class='w-100px text-middle text-danger'> 
              <div class='text-price'>{!echo $currencySymbol . number_format($product->price * $product->count, 2)}</div>
            </td>
          </tr>
          {/foreach}
        </table>
      </div>
      <div id='paymentBox'>
        <h5>{!echo $lang->order->payment}</h5>
        <dl>
          <dd id='payment'>{!html::radio('payment', $paymentList)}</dd>
        </dl>
      </div>
    </div>
    <div class='panel-footer text-right'>
      {!printf($lang->order->totalToPay, $currencySymbol . $order->amount)}
      {!html::submitButton($lang->order->settlement, 'btn-order-submit')}
    </div>
  </form>
  <form class='hide' id='payForm' method='post' action="{!inlink('redirect')}" target='_blank'>
    {!html::hidden('payLink', '')}
    <input class='submitBtn' type='submit' value="{!echo $lang->confirm}" />
  </form>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
