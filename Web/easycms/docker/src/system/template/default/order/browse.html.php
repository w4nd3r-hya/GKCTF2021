{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{!js::set('confirmWarning', $lang->order->confirmWarning)}
{!js::set('cancelWarning',  $lang->order->cancelWarning)}
<div class="page-user-control">
  <div class="row">
    {include TPL_ROOT . 'user/side.html.php'}
    <div class="col-md-10">
      <div class='panel'>
        <div class='panel-heading'>
        <strong><i class="icon-shopping-cart"> </i>{$lang->order->admin}</strong>
        </div>
        <table class='table table-hover tablesorter table-fixed' table-layout='fixed'>
          <thead>
            <tr class='text-center'>
              <td class='w-100px'>{$lang->order->type}</td>
              <td class='w-280px text-left'>{$lang->order->productInfo}</td>
              <td class='w-80px text-right'>{$lang->order->amount}</td>
              <td class='w-80px'>{$lang->product->status}</td>
              <td class='w-80px'>{$lang->order->payStatus}</td>
              <td>{$lang->order->note}</td>
              <td>{$lang->order->last}</td>
              <td class='w-220px'>{$lang->actions}</td>
            </tr>
          </thead>
          <tbody>
            {foreach($orders as $order)}
              {$goodsInfo = $control->order->printGoods($order)}
              <tr>
                <td class='text-center text-middle'>{!zget($lang->order->types, $order->type)}</td>
                <td class='text-middle' title='{!strip_tags($goodsInfo)}'>{$goodsInfo}</td>
                <td class='text-right text-middle'>{!echo $order->amount + $order->balance}</td>
                <td class='text-center text-middle'>
                  {$control->order->processStatus($order)}
                </td>
                <td class='text-center text-middle'>
                  {!zget($lang->order->payStatusList, $order->payStatus, '')}
                </td>
                <td class='text-left' title='{$order->note}'>{$order->note}</td>
                <td class='text-center'>{!echo ($order->last == '0000-00-00 00:00:00') ? '' : formatTime($order->last, 'm-d H:i')}</td>
                <td class='text-left text-middle'>{$control->order->printActions($order)}</td>
              </tr>
            {/foreach}
          </tbody>
          <tfoot><tr><td colspan='8'>{$pager->show()}</td></tr></tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
