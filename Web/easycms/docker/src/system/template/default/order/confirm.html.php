{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The order view of order module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     order 
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
*}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{!js::set('currencySymbol', $currencySymbol)}
{!js::set('checkStock', isset($control->config->product->stock) ? $control->config->product->stock : false)}
{if(!empty($products))}
{$total = 0}
<div class='panel my-order'>
  <div class='panel-heading'><strong>{!echo $lang->order->confirm}</strong></div>
  <form id='confirmForm' action='{!echo helper::createLink('order', 'create')}' method='post'>
    <div class='panel-body'>
      <div id='addressBox'>
        <div>
          <strong>{!echo $lang->order->address}</strong>
          {!html::a(helper::createLink('address', 'create') . ' form', $lang->address->create, "class='createAddress'")}
          {!html::hidden("createAddress", '')}
        </div>
        <div id='addressList'></div>
        <div class='div-create-address hide'>
          <table class='table table-borderless address-form table-list'>
            <tr>
              <td class='w-100px'>{!html::input('contact', '', "class='form-control' placeholder='{{$lang->address->contact}}'")}</td>
              <td class='w-130px'>{!html::input('phone', '', "class='form-control' placeholder='{{$lang->address->phone}}'")}</td>
              <td>{!html::input('address', '', "class='form-control' placeholder='{{$lang->address->address}}'")}</td>
              <td class='w-100px'>{!html::input('zipcode', '', "class='form-control' placeholder='{{$lang->address->zipcode}}'")}</td>
              <td class='w-50px text-middle'><strong class='icon icon-remove' style='cursor:pointer'> </i></td>
            </tr>
          </table>
        </div>
      </div>
      <table class='table table-list'>
        <thead>
          <tr class='text-center'>
            <td class='text-left'><strong>{!echo $lang->order->productInfo}</strong></td>
            <td class='hidden-xs'></td>
            <td class='text-left hidden-xs'>{!echo $lang->order->price}</td>
            <td>{!echo $lang->order->count}</td>
            <td>{!echo $lang->order->amount}</td>
            <td>{!echo $lang->actions}</td>
          </tr>
        </thead>
        {foreach($products as $productID => $product)}
        {$productLink = helper::createLink('product', 'view', "id=$productID", "category={{$product->categories[$product->category]->alias}}&name=$product->alias")}
        <tr>
          <td class='w-100px'>
            {if(!empty($product->image))}
                {$title = $product->image->primary->title ? $product->image->primary->title : $product->name}
                {!html::a($productLink, html::image($control->loadModel('file')->printFileURL($product->image->primary, 'smallURL'), "title='$title' alt='$product->name'"), "class='media-wrapper'")}
            {/if}
            <h6 class='visible-xs'>{!html::a($productLink, '<div class="" data-id="' . $product->id . '">' . $product->name . '</div>', "class='media-wrapper'")}</h6>
          </td>
          <td class='text-left text-middle hidden-xs'>
            {!html::a($productLink, '<div class="" data-id="' . $product->id . '">' . $product->name . '</div>', "class='media-wrapper'")}
          </td>
          <td class='w-100px text-middle hidden-xs'> 
            {if($product->promotion != 0)}
            {$price = $product->promotion}
            <div class='text-muted'><del>{!echo $currencySymbol . $product->price}</del></div>
            <div class='text-price'>{!echo $currencySymbol . $product->promotion}</div>
            {else}
            {$price  = $product->price}
            <div class='text-price'>{!echo $currencySymbol . $product->price}</div>
            {/if}
            {!html::hidden("price[$product->id]", $price)}
            {$amount = $product->count * $price}
            {$total += $amount}
          </td>
          <td class='w-140px text-middle'>
            <div class='input-group'>
              <span class='input-group-addon'><i class='icon icon-minus'></i></span>
              {!html::input("count[$product->id]", $product->count, "data-stock='{{$product->amount}}' class='form-control'")}
              <span class='input-group-addon'><i class='icon icon-plus'></i></span>
            </div>
          </td>
          <td class='w-200px text-center text-middle'>
            <strong class='text-danger'>{!echo $currencySymbol}</strong>
            <strong class='text-danger amountContainer'>{!echo $amount}</strong>
          </td>
          <td class='text-middle text-center'>
            {!html::a(helper::createLink('cart', 'delete', "product={{$product->id}}"), $lang->delete, "class='cartDeleter'")}
            {!html::hidden("product[]", $product->id)}
          </td>
        </tr>
        {/foreach}
        <tr>
          <th class='text-left text-middle'>{!echo $lang->order->note}</th>
          <td colspan='5'>{!html::textarea('note', '', "class='form-control' rows=1")}</td>
        </tr>
      </table>
    </div>
    <div class='panel-footer text-right'>
      {!printf($lang->order->selectProducts, count($products))}
      {!printf($lang->order->totalToPay, $currencySymbol . $total)}
      {!html::submitButton($lang->order->submit, 'btn-order-submit')}
    </div>
  </form>
  <form class='hide' id='payForm' method='post' action="{!inlink('redirect')}" target='_blank'>
    {!html::hidden('payLink', '')}
    <input class='submitBtn' type='submit' value="{!echo $lang->confirm}" />
  </form>
</div>
{else}
<div class='panel'>
  <div class='panel-heading'>
    <strong>{!echo $lang->order->browse}</strong>
  </div>
  <div class='panel-body'>
    {!echo $lang->order->noProducts}
    {!html::a(helper::createLink('product', 'browse'), $lang->order->pickProducts, "class='btn btn-xs btn-primary'")}
    {!html::a(helper::createLink('index', 'index'), $lang->order->goHome, "class='btn btn-xs btn-default'")}
  </div>
</div>
{/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
