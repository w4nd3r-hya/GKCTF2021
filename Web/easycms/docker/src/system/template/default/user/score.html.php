{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='row'>
  {include TPL_ROOT . 'user/side.html.php'}
  <div class='col-md-10'>
    <div class='panel'>
      <div class='panel-heading'>
        <strong class='red'>{!printf($lang->score->lblTotal, $user->score, $user->rank)}</strong>
        <div class='panel-actions'>
          {if(commonModel::hasOnlinePayment())}
            {!html::a($control->createLink('score', 'buyScore'), $control->lang->user->buyScore, "class='btn btn-primary'")}
          {/if}
        </div>
      </div>
      <table class='table table-hover table-striped'>
        <thead>
          <tr>
            <th class='w-80px'>{$lang->score->id}</th>
            <th class='w-100px'>{$lang->score->time}</th>
            <th class='w-150px'>{$lang->score->method}</th>
            <th class='w-150px'>{$lang->score->count}</th>
            <th class='w-150px'>{$lang->score->before}</th>
            <th class='w-150px'>{$lang->score->after}</th>
            <th>{$lang->score->note}</th>
          </tr>
        </thead>
        <tbody>
          {foreach($scores as $score)}
            <tr>
              <th>{$score->id}</th>
              {$score->time = substr($score->time, 0, 10)}
              <td>{$score->time}</td>
              <td>{!echo $score->type == 'punish' ? $lang->score->methods[$score->type] : $lang->score->methods[$score->method]}</td>
              <td>{!echo ($score->type == 'in' ? '+' : '-') . $score->count}</td>
              <td>{$score->before}</td>
              <td>{$score->after}</td>
              <td>{$score->note}</td>
            </tr>  
          {/foreach}
        </tbody>
        <tfoot>
          <tr>
            <td colspan='7' class='a-right'>{$pager->show()}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
