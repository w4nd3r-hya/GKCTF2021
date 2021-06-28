{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='row'>
  {include TPL_ROOT . 'user/side.html.php'}
  <div class='col-md-10'>
    <div class='panel'>
      <div class='panel-heading'><strong>{$lang->score->confirm}</strong></div>
      <table class='table'>
        <tr>
          <th>{$lang->score->id}</th>
          <th>{$lang->score->product}</th>
          {if(!empty($order->ip))} <th>IP</th> {/if}
          {if(!empty($order->hostID))} <th>MAC</th> {/if}
          <th width='50'>{$lang->score->amount}</th>
        </tr>
        <tr class='text-center'> 
          <td>{$order->humanOrder}</td>
          <td>{$order->subject}</td>
          {if(!empty($order->ip))} <td>{$order->ip}</td> {/if}
          {if(!empty($order->hostID))} <td>{$order->hostID}</td> {/if}
          <td>{$order->amount}</td>
        </tr>
        <tr class='text-center'>
          <td colspan='5'>{!html::a($payLink, $lang->score->alipay, "class='btn btn-primary btn-lg'")}</td>
        </tr>
      </table>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
