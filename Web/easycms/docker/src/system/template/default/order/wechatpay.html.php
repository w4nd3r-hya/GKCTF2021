{if(!defined("RUN_MODE"))} {!die()} {/if}
{include TPL_ROOT . 'common/header.html.php'}
{!js::set('orderID', $order->id)}
{!js::set('tradeID', $tradeID)}
{!js::set('payStatus', $order->payStatus)}
<div class='panel'>            
  <div class='panel-heading'>
    <strong>{$lang->order->scanCode}</strong>
    <div class='panel-actions'>{!echo $currencySymbol . ' ' . $order->amount}</div>
  </div>
  <div class='panel-body'>
    <div class='row'>
      <div class='col-md-6 wechat'>
        <div class='title'>{$lang->order->wechatpay}</div>
        <div class='qrcode'>
          {$url = base64_encode($url)}
          <div class='qrcode-img'>{!html::image($control->createLink('order', 'qrcode', "url=$url"))}</div>
          <div class='qrcode-warning'></div>
        </div>
        <div class="tip">
          <i class="icon"></i>{$lang->order->wechatScan}
        </div>
      </div>
      <div class='col-md-6 mobile'>
        <div class='img'></div>
      </div>
    </div>
  </div>
</div>
{include TPL_ROOT . 'common/footer.html.php'}
