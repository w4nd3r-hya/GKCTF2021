{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The browse view file of address for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     address
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
<style>
.address-manage {
    width: 100%;
    background-color: #ffffff;
    text-align: right;
    font-size: 18px;
    padding: 8px 10px;
    justify-content: flex-end;
}

.address-list {
    margin: 12px;
    border-radius: 3px;
    padding: 13px 10px;
}

.address-list .panel-body {
    padding: 0;
}

.address-list .browse {
    margin-left: 3px;
    font-size: 16px;
}

.address-list .address {
    color: #333333;
    font-size: 12px;
}

.address-list .vertical-center {
    display: flex;
    display: -webkit-flex;
    align-items: center;
}

.address-list .alignment-address {
    justify-content: space-between;
}

.address-list .alignment-delete {
    margin-top: 8px;
    justify-content: space-between;
}

.address-list .vertical-line {
    float: left;
    width: 2px;
    height: 12px;
    background: #3C77FE;
}

.address-list .divider {
    height: 1px;
    width: 100%;
    background-color: #e5e5e5;
}

.address-list .edit-button a {
    margin-right: -26px;
    float: right;
    font-size: 14px;
    color: #666666;
    width: 40px;
}

.address-list .address-default {
    text-align: center;
    font-size: 12px;
    width: 35px;
    margin-left: 20px;
    border-radius: 3px;
    background-color: #E0E9FF;
}

.address-list .with-appbar-top {
    background-color: #F4F3F4;
}

.address-list .checkbox-circle {
    position: relative;
}

.address-list .checkbox-circle label {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 50%;
    cursor: pointer;
    height: 15px;
    width: 15px;
    right: 0px;
    left: -3px;
    top: 3px;
    position: absolute;
}

.address-list .checkbox-circle label:after {
    border: 2px solid #ffffff;
    border-top: none;
    border-right: none;
    content: "";
    height: 4px;
    width: 7px;
    top: 4px;
    left: 3px;
    opacity: 0;
    position: absolute;
    transform: rotate(-45deg);
}

.address-list .checkbox-circle input[type="checkbox"] {
    visibility: hidden;
}

.address-list .checkbox-circle input[type="checkbox"]:checked + label {
    background-color: #1e74fc;
    border-color: #1e74fc;
}

.address-list .checkbox-circle input[type="checkbox"]:checked + label:after {
    opacity: 1;
}

.address-list .all-delete span {
    margin: 1px 0 0 10px;
}

.address-list .create-center {
    text-align: center;
}

.address-list .item {
    display: flex;
}

.address-list .item-checkbox {
    display: none;
    margin-right: 10px;
}

.address-list .create-btn {
    margin-top: 8px;
    color: #3280fc;
    border:1px solid #3280fc;
    background: white;
    height: 31px;
    width: 35%;
    border-radius: 3px;
    font-size: 1.5rem;
    padding: 0px;
    line-height: 30px;
}

.address-list .delete-btn {
    color: #3280fc;
    border: 1px solid #3280fc;
    background: white;
    height: 31px;
    width: 17%;
    border-radius: 3px;
    text-align: center;
    justify-content: center;
}

.address-list .address-edit {
    margin: 12px 0;
    width: 95%;
    line-height: 30px;
}

.address-list .address-edit .name {
    display: block;
    width: 66px;
    font-size: 14px;
    font-weight: 400;
}

.address-list .address-edit .phone {
    font-size: 14px;
    color: #333333;
}
</style>
<div class='block-region region-all-top blocks' data-region='all-top'>
  <nav class='appnav fix-top appnav-auto' id='appnav' data-ve='navbar' data-type='mobile_top' style='top:0px;background:#fff;box-shadow: 0 0px 0px;height:48px'>
    <div class='mainnav' style='padding:8px 7px'>
      <div class='both-sides left' style='width:43px'>
        <div class='icon-block left'>
          <a href='javascript:#' data-dismiss="modal">{!html::image($config->webRoot . 'theme/mobile/common/img/left.png')}</a>
        </div>
      </div>
      <div class='middle-title'>{!isset($mobileTitle) ? $mobileTitle : $lang->detail}</div>
    </div>
    <div class='subnavs fade'> {$subnavs} </div>
  </nav>
</div>
<div class='block-region region-all-banner blocks' data-region='all-banner'>
  {$control->block->printRegion($layouts, 'all', 'banner')}
</div>
<div class='panel address-list'>
  <div class='panel-body'>
    <div class='title strong vertical-center'>
      <span class='vertical-line'></span><span class='browse'>{$lang->address->browse}</span>
    </div>
    <div id='addressListWrapper'>
      <div class='list container' id='addressList'>
        {@$i=0}
        {foreach($addresses as $address)}
          {@$i++}
          {$checked = isset($checked) ? '' : 'checked'}
          <div class='item'>
            <div class='vertical-center'>
              <label class='checkbox-circle item-checkbox'>
                <input type='checkbox' id='checkbox{$i}' name='deliveryAddress'  value='{$address->id}'>
                <label for='checkbox{$i}'></label>
              </label>
            </div>
            <div class='address-edit'>
              <div class='vertical-center'>
                <strong class='name'>{$address->contact}</strong>
                <span class='phone'>{!substr_replace($address->phone, '****', 3, 4)}</span>
                {if(zget($address, 'isDefault', 0))}
                <span class='address-default text-primary'>{$lang->address->default}</span>
                {/if}
              </div>
              <div class='vertical-center alignment-address'>
                <span class='address'> {$address->address} </span>
              </div>
            </div>
          </div>
          {if($i < count($addresses))}
          <div class='divider'></div>
          {/if}
        {/foreach}
      </div>
    </div>
    <div class='bottom-operator'>
      <div class='{if(count($addresses) == 0)}create-center{/if}'>
        {!html::a(helper::createLink('address', 'browse', "id={{$address->id}}"), $lang->address->manageAddress, "class='btn create-btn'")}
      </div>
    </div>
  </div>
</div>
<script>
$(function()
{
    $('.item').on('click', function()
    {
        $('#deliveryAddress').val($(this).find('input').val());
        $('.show-contact').html($(this).find('.name').html());
        $('.show-phone').html($(this).find('.phone').html());
        $('.show-address').html($(this).find('.address').html());
        $('#triggerModal').modal('hide');
    })
});
</script>
