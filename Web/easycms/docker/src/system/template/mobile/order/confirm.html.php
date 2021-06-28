{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The confirm view file of order for mobile template of chanzhiEPS.
 * The file should be used as ajax content
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     order
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.simple')}
{!js::set('currencySymbol', $currencySymbol)}
{!js::set('createdSuccess', $lang->order->createdSuccess)}
{!js::set('goToPay', $lang->order->goToPay)}
<div class='panel order-panel'>
  {if(!empty($products))}
    <form id='confirmOrderForm' action='{!helper::createLink('order', 'create')}' method='post'>
      <div class='panel-body'>
        <div class='bg-gray-pale'><strong>{!$lang->order->address}</strong></div>
        {if(!empty($addresses))}
        <div class='order-address'>
          {!html::hidden("deliveryAddress", $addresses[0]->id)}
          <div class='address-top'>
            <span>{$lang->address->contact}：</span>
            <span class='show-contact'>{$addresses[0]->contact}</span>
            <span class='show-phone right'>{!substr($addresses[0]->phone, 0, 3) . '****' . substr($addresses[0]->phone, -4)}</span>
          </div>
          <div class='address-body'><span>{$lang->address->browse}：</span><span class='show-address'>{$addresses[0]->address}</span></div>
        </div>
        {else}
        {!html::hidden("createAddress", '1')}
        {/if}
        <!--{!html::a(helper::createLink('address', 'addressList'), $lang->address->selected, "class='btn default btn-link'")}-->
        <button type='button' class='btn default btn-link' data-toggle='modal' data-remote='{!helper::createLink('address', 'addressList')}'>{$lang->address->selected}</button>
      </div>
      <div class='panel-body'>
        <div class='bg-gray-pale'><strong>{!$lang->order->productInfo} ({!count($products)})</strong></div>
        <div class='cards condensed cards-list'>
          {$total = 0}
          {foreach($products as $productID => $product)}
            {$productLink = helper::createLink('product', 'view', "id=$productID", "category={{$product->categories[$product->category]->alias}}&name=$product->alias")}
            <div class='card card-block'>
                <div class='card-image'>
                  {if(empty($product->image))}
                    {$productName = helper::substr($product->name, 10, '...')}
                    {$imgColor = $product->id * 57 % 360}
                    <div class='media-holder'>
                      <div class='media-placeholder' style='background-color: hsl({$imgColor}, 60%, 80%); color: hsl({$imgColor}, 80%, 30%);' data-id='{$product->id}'>
                        {$productName}
                      </div>
                    </div>
                  {else}
                    {!html::image($control->loadModel('file')->printFileURL($product->image->primary, 'middleURL'), "title='{{$product->name}}' alt='{{$product->name}}'")}
                  {/if}
                </div>
                <div class='card-body'>
                  <div class='product-title'>{!html::a($productLink, $product->name)}</div>
                  <div class='product-price'>{$lang->order->price}
                    {if($product->promotion != 0)}
                      {$price = $product->promotion}
                      <span>{!echo $currencySymbol . $product->promotion}</span>&nbsp;
                      <span class='text-muted text-line-through'>{!echo $currencySymbol . $product->price}</span>
                    {else}
                      {$price = $product->price}
                      <span>{!echo $currencySymbol . $product->price}</span>
                    {/if}
                    {!html::hidden("price[$product->id]", $price)}
                    {$amount = $product->count * $price}
                    {$total += $amount}
                  </div>
                  <div class='product-amount'>{$lang->order->amount}<strong class='text-danger'>{$currencySymbol}<span class='amount'>{$amount}</span></strong></div>
                  <div class='product-count'>
                    <div>{$lang->order->count}</div>
                    <div class='input-group input-group-sm input-number'>
                      <div class='btn-update btn-minus'><i class='icon icon-minus'></i></div>
                        <input type='number' class='btn-number text-center' value='{$product->count}' data-price='{$price}' id='count[{$product->id}]' name='count[{$product->id}]'>
                      <div class='btn-update btn-plus'><i class='icon icon-plus'></i></div>
                    </div>
                    {!html::hidden("product[$product->id]", $product->id)}
                  </div>
                </div>
            </div>
          {/foreach}
        </div>
        <hr class='space'>
        <div class='alert bg-primary-pale'>
          {!printf($lang->order->selectProducts, count($products))}
          {!printf($lang->order->totalToPay, $currencySymbol . $total)}
        </div>
      </div>
      <div class='panel-body'>
        <div class='alert bg-gray-pale'><strong>{!$lang->order->note}</strong></div>
        <div>{!html::textarea('note', '', "class='form-control' rows=1 placeholder='{{$lang->order->placeholder->note}}'")}</div>
      </div>
      <footer class="appbar fix-bottom" id='footer' data-ve='navbar' data-type='mobile_bottom'>
        <div class='footer-right'>
          <div class='right-btn'>
            {!html::submitButton($lang->order->submit, 'btn-order-submit btn danger')}
          </div>
          <div class='right-total'>{!printf($lang->order->amountToPay, $currencySymbol . $total)}</div>
        </div>
      </footer>
    </form>
  {else}
    <div class='panel-body'>
      <div class='alert bg-warning-pale text-center'>
        <p><i class='icon-smile icon-x3'></i></p>
        {$lang->order->noProducts}
      </div>
      <hr class='space'>
      <div class='row'>
        <div class='col-6'>
          {!html::a(helper::createLink('cart', 'browse', 'source=product'), $lang->order->goToCart, "class='btn primary block'")}
        </div>
        <div class='col-6'>
          {!html::a(helper::createLink('index', 'index'), $lang->cart->goHome, "class='btn default block'")}
        </div>
      </div>
    </div>
  {/if}
</div>

{include TPL_ROOT . 'common/form.html.php'}
{noparse}
<script>
+(function($){
    'use strict';

    var minDelta = 20;

    $.fn.numberInput = function(){
        return $(this).each(function(){
            var $input = $(this);
            $input.on('click', '.btn-minus, .btn-plus', function(){
                var $val = $input.find('.btn-number, [type="number"]');
                var val = parseInt($val.val());
                val = Math.max(1, $(this).hasClass('btn-minus') ? (val - 1) : (val + 1));
                $val.val(val).trigger('change');
            });
        });
    };

    $(function(){$('.input-number').numberInput();});
}(Zepto));

$(function()
{
    var caculateTotal = function()
    {
        statAll();
    };

    $('.btn-number').on('change', function()
    {
        caculateTotal();
    });

    var $confirmOrderForm = $('#confirmOrderForm');
    $confirmOrderForm.ajaxform({onResultSuccess: function(response)
    {
        $.messager.success('{$lang->order->createdSuccess}');
        window.location.href = response.locate ? response.locate : orderBrowseLink;
    }
    });
});

statAll();
function statAll()
{
    var amount = 0;
    var total = 0;
    $('.card').each(function()
    {
        var price = $(this).find('.btn-number').data('price');
        var number = $(this).find('.btn-number').val();
        $(this).find('.amount').text(parseFloat(price*number).toFixed(2)); 
        total += parseFloat($(this).find('.amount').html()); 
    });
    total = total.toFixed(2);
    $('#amount').html($('#amount').html().substr(0,1) + total);
    $('#total').html($('#total').html().substr(0,1) + total);

}
</script>
{/noparse}
