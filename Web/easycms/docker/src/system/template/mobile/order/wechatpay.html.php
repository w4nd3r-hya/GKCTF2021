{if(!defined("RUN_MODE"))} {!die()} {/if}
{include TPL_ROOT . 'common/header.html.php'}
{!js::set('orderID', $order->id)}
{!js::set('openLink', $openLink)}
{!js::set('type', $type)}
{!js::set('payConfig', $payConfig)}
{!js::set('orderLink', helper::createLink('order', 'browse'))}
<div class='panel panel-section'>
  <div class='panel-heading page-header'>
    <div class='title'><strong>{$lang->order->invokeWechatpay}</strong></div>
  </div>
  <p>{$lang->order->wechatpayNote}</p>
  {$queryLink = helper::createLink('order', 'ajaxQuery', "orderID={{$order->id}}&tradeID=$tradeID")}
  {!html::commonButton($lang->order->paid, 'btn primary block paid', "rel='$queryLink' onclick='checkPay()'")}
  </form>
</div>
{include TPL_ROOT . 'common/footer.html.php'}
