{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The cart view of cart module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     cart 
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.simple')}
{!js::set('currencySymbol', $currencySymbol)}
{if($source == 'bottom')}
<style>
  #footer {bottom:51px}
</style>
{/if}
<div class='panel panel-section'>
  <div class='panel-heading page-header'>
    <div class='title'>{if(!empty($products))} {$cartProducts = count($products)}{else}{$cartProducts = 0}{/if}{!printf($lang->order->cartProducts, $cartProducts)}</div>
    <div class='opt admin'>{$lang->order->manage}</div>
    <div class='opt complete hide'>{$lang->order->finish}</div>
  </div>
  {if(!empty($products))}
    <form action='{!helper::createLink('order', 'confirm')}' method='post'>
      <div class='cards condensed cards-list'>
      {$total = 0}
      {foreach($products as $productID => $product)}
        {$productLink = helper::createLink('product', 'view', "id=$productID", "category={{$product->categories[$product->category]->alias}}&name=$product->alias")}
        <div class='card'>
          <div class='table-layout'>
            <div class='checkarea'>
              <input class='check-product' type='checkbox' name='product[]' value='{$product->id}'>
              <label for='buyMethod'></label>
            </div>
            <a href='{$productLink}'>
              <div class='showcase'>
                {if(empty($product->image))}
                  {$productName = helper::substr($product->name, 10, '...')}
                  {$imgColor = $product->id * 57 % 360}
                  <div class='media-holder'>
                    <div class='media-placeholder' style='background-color: hsl({$imgColor}, 60%, 80%); color: hsl({$imgColor}, 80%, 30%);' data-id='{$product->id}'>
                      {$productName}
                    </div>
                  </div>
                {else}
                  {$product->image->primary->objectType = 'product'}
                  {!html::image($control->loadModel('file')->printFileURL($product->image->primary, 'middleURL'), "title='{{$product->name}}' alt='{{$product->name}}'")}
                {/if}
              </div>
            </a>
            <div class='table-cell'>
              <table class='table table-layout table-condensed'>
                <tbody>
                  <tr>
                    <td colspan='3'>
                      <div class='product-title'>
                        <strong>{!html::a($productLink, $product->name)}</strong>
                      </div>
                      <!--<div class='pull-right'>
                        {!html::a(inlink('delete', "product={{$product->id}}"), $lang->delete, "class='deleter text-primary'")}
                        {!html::hidden("product[]", $product->id)}
                      </div>-->
                    </td>
                  </tr>
                  <tr>
                    <th class='small'>{$lang->order->price}</th>
                    <td colspan='2'>
                      {if($product->promotion != 0)}
                        {$price = $product->promotion}
                        <span>{!echo $currencySymbol . $product->promotion}</span>&nbsp;
                        <small class='text-muted text-line-through'>{!echo $currencySymbol . $product->price}</small>
                      {else}
                        {$price  = $product->price}
                        <span>{!echo $currencySymbol . $product->price}</span>
                      {/if}
                      {!html::hidden("price[$product->id]", $price)}
                      {$amount = $product->count * $price}
                      {$total += $amount}
                    </td>
                  </tr>
                  <tr>
                    <th class='small'>{$lang->order->amount}</th>
                    <td class='product-price'>
                      <strong class='text-danger'>{$currencySymbol}<span class='product-amount'>{$amount}</span></strong>
                    </td>
                    <td>
                      <div class='input-group input-group-sm input-number'>
                        <div class='btn-update btn-minus'><i class='icon icon-minus'></i></div>
                        <input type='number' class='btn-number text-center' value='{$product->count}' data-price='{$price}' id='count[{$product->id}]' name='count[{$product->id}]'>
                        <div class='btn-update btn-plus'><i class='icon icon-plus'></i></div>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      {/foreach}
      </div>
      <footer class="appbar fix-bottom" id='footer' data-ve='navbar' data-type='mobile_bottom'>
      <div class='footer-left'>
        <div class='checkarea'>
            <input type='checkbox' id='checkAll'>
            <label>{$lang->selectAll}</label>
        </div>
      </div>          
      <div class='footer-right'>
        <div class='right-btn'>
          {!html::submitButton($lang->cart->goAccount, 'btn-order-submit')}
          <button type='button' class='btn-order-delete hide'>{$lang->delete}</button>
        </div>
        <div class='right-btn span'>
          <div class='total'>
            <span>{!printf($lang->order->statistics, 0, $currencySymbol . '0')}</span>
          </div>
        </div>
      </div>
      </footer>
    </form>
  {else}
    <div class='panel-body'>
      <div class='alert bg-warning-pale text-center'>
        <p><i class='icon-smile icon-x3'></i></p>
        {$lang->cart->noProducts}
      </div>
      <hr class='space'>
      <div class='row'>
        <div class='col-6'>
          {!html::a(helper::createLink('product', 'browse', 'category=0'), $lang->cart->pickProducts, "class='btn primary block'")}
        </div>
        <div class='col-6'>
          {!html::a(helper::createLink('index', 'index'), $lang->cart->goHome, "class='btn default block'")}
        </div>
      </div>
    </div>
  {/if}
</div>
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

    $('#checkAll').on('click', function()
    {
        $('.check-product').each(function()
        {
            $(this).prop("checked", $('#checkAll').prop("checked"));
        });
        statAll();
    });

    $('.check-product').on('click', function()
    {
        var status = true;
        $('.check-product').each(function()
        {
            if(!$(this).prop("checked"))
            {
                $('#checkAll').prop("checked", false);
                status = false;
            }
        })
        if(status)
        {
            $('#checkAll').prop("checked", true);
        }
        statAll();
    });

    $('.opt.admin').on('click', function()
    {
        $(this).siblings().show();
        $(this).hide();
        $('.total').find('span').hide();
        $('.btn-order-submit').hide();
        $('.btn-order-delete').show();
    });

    $('.opt.complete').on('click', function()
    {
        $(this).siblings().show();
        $(this).hide();
        $('.total').find('span').show();
        $('.btn-order-submit').show();
        $('.btn-order-delete').hide();
    });

    $('.btn-order-delete').on('click', function()
    {
        var products = '';
        $('.check-product:checked').each(function()
        {
            products += $(this).val() + ',';
        });
        $.getJSON(createLink('cart', 'batchdelete', 'products=' + products), function(data) 
        {
            window.location.reload();
        });
    });
});

statAll();
function statAll()
{
    var amount = 0;
    var total = 0;
    $('.check-product').each(function()
    {
        var price = $(this).parent().parent().find('.btn-number').data('price');
        var number = $(this).parent().parent().find('.btn-number').val();
        $(this).parent().parent().find('.product-amount').text(parseFloat(price*number).toFixed(2)); 
        if($(this).prop("checked"))
        {
            amount += 1;
            total += parseFloat($(this).parent().parent().find('.product-amount').html()); 
        }
    });
    total = total.toFixed(2);
    $('#amount').prev().html(amount);
    $('#amount').html($('#amount').html().substr(0,1) + total);

}
</script>
{include TPL_ROOT . 'common/form.html.php'}
{if($source == 'bottom')}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
{/if}
