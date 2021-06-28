<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The currency view file of product module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     product
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php include '../../common/view/header.admin.html.php';?>
<?php include '../../common/view/chosen.html.php';?>
<div class='panel'>
  <div class='panel-heading'><strong><i class='icon icon-cog'> </i><?php echo $lang->product->setting;?></strong></div>
  <div class='panel-body'>
    <form id='ajaxForm' action="<?php echo inlink('setting');?>" method='post' class='form-inline'>
      <table class="table table-form">
        <tr>
          <th class='w-120px'><?php echo $lang->product->currency;?></th>
          <td class='w-200px'><?php echo html::select('currency', $lang->product->currencyList, isset($config->product->currency) ? $config->product->currency : '', "class='chosen'");?></td>
          <td></td>
        </tr>
        <?php if(commonModel::isAvailable('shop')):?>
        <tr>
          <th><?php echo $lang->product->stock;?></th>
          <td class='w-100px'><?php echo html::radio('stock', $lang->product->stockOptions, isset($config->product->stock) ? $config->product->stock : '', "class='checkbox'");?></td>
          <td></td>
        </tr>
        <tr>
          <th><?php echo $lang->order->confirmLimit;?></th> 
          <td>
            <div class='input-group'>
              <?php echo html::input('confirmLimit', isset($this->config->shop->confirmLimit) ? $this->config->shop->confirmLimit: 7, "class='form-control'");?>
              <span class='input-group-addon'><?php echo $lang->order->days;?></span>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->order->expireLimit;?></th> 
          <td>
            <div class='input-group'>
              <?php echo html::input('expireLimit', isset($this->config->shop->expireLimit) ? $this->config->shop->expireLimit: 30, "class='form-control'");?>
              <span class='input-group-addon'><?php echo $lang->order->days;?></span>
            </div>
          </td>
        </tr>
        <tr>
          <th><?php echo $lang->order->payment;?></th> 
          <?php unset($lang->order->paymentList['offlinepay']);?>
          <td colspan='2'><?php echo html::checkbox('payment', $lang->order->paymentList, isset($this->config->shop->payment) ? $this->config->shop->payment : 'COD,alipay', "class='checkbox'");?></td>
        </tr>
        <tr class='alipay-item'>
          <th><?php echo $lang->order->alipayParam;?></th>
          <td colspan='2'>
            <div class='input-group'>
              <span class='input-group-addon w-110px'><?php echo $lang->order->alipayPid;?></span>
              <?php echo html::input('pid', isset($this->config->alipay->pid) ? $this->config->alipay->pid : '', "class='form-control' placeholder='{$lang->order->placeholder->pid}'" );?>
              </div>
            <div class='input-group'>
              <span class='input-group-addon w-110px'><?php echo $lang->order->alipayKey;?></span>
              <?php echo html::input('key', isset($this->config->alipay->key) ? $this->config->alipay->key : '', "class='form-control' placeholder='{$lang->order->placeholder->key}'" );?>
            </div>
            <div class='input-group'>
              <span class='input-group-addon w-110px'><?php echo $lang->order->alipayEmail;?></span>
              <?php echo html::input('email', isset($this->config->alipay->email) ? $this->config->alipay->email : '', "class='form-control' placeholder='{$lang->order->placeholder->email}'" );?>
            </div>
          </td>
        </tr>
        <tr class='wechatpay-item'>
          <th><?php echo $lang->order->wechatpayParam;?></th>
          <td colspan='2'>
            <div class='input-group'>
              <span class='input-group-addon w-110px'><?php echo $lang->order->wechatpayAppid;?></span>
              <?php echo html::input('wechat[appid]', isset($this->config->wechatpay->appid) ? $this->config->wechatpay->appid : '', "class='form-control' placeholder='{$lang->order->placeholder->appid}'" );?>
              <?php echo html::hidden('wechat_appid');?>
            </div>
            <div class='input-group'>
              <span class='input-group-addon w-110px'><?php echo $lang->order->wechatpayMchid;?></span>
              <?php echo html::input('wechat[mch_id]', isset($this->config->wechatpay->mch_id) ? $this->config->wechatpay->mch_id : '', "class='form-control' placeholder='{$lang->order->placeholder->mchid}'" );?>
              <?php echo html::hidden('wechat_mch_id');?>
            </div>
            <div class='input-group'>
              <span class='input-group-addon w-110px'><?php echo $lang->order->wechatpayApiKey;?></span>
              <?php echo html::input('wechat[apikey]', isset($this->config->wechatpay->apikey) ? $this->config->wechatpay->apikey : '', "class='form-control' placeholder='{$lang->order->placeholder->apikey}'" );?>
              <?php echo html::hidden('wechat_apikey');?>
            </div>
            <div class='input-group'>
              <span class='input-group-addon w-110px'><?php echo $lang->order->wechatpayAppSecret;?></span>
              <?php echo html::input('wechat[appsecret]', isset($this->config->wechatpay->appsecret) ? $this->config->wechatpay->appsecret : '', "class='form-control' placeholder='{$lang->order->placeholder->appsecret}'");?>
              <?php echo html::hidden('wechat_appsecret');?>
            </div>
            <div class='input-group'>
              <span class='input-group-addon w-110px'><?php echo $lang->order->wechatpayH5Status;?></span>
              <div class="form-control">
                <?php echo html::radio('wechat[h5api]', $lang->product->h5api, isset($this->config->wechatpay->h5api) ? $this->config->wechatpay->h5api : 'close', "class='checkbox'");?>
                <?php echo html::hidden('wechat_h5api');?>
              </div>
            </div>
          </td>
        </tr>
        <tr class='paypal-item'>
          <th><?php echo $lang->order->paypalParam;?></th>
          <td colspan='2'>
            <div class='input-group'>
              <span class='input-group-addon w-110px'><?php echo $lang->order->paypalAccount;?></span>
              <?php echo html::input('paypal[account]', isset($this->config->paypal->account) ? $this->config->paypal->account : '', "class='form-control' placeholder='{$lang->order->placeholder->account}'" );?>
              <?php echo html::hidden('paypal_account');?>
            </div>
         </td>
        </tr>
        <?php endif;?>
        <tr>
          <th></th>
          <td><?php echo html::submitButton();?></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php include '../../common/view/footer.admin.html.php';?>
