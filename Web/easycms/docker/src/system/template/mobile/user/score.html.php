{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.simple')}
<div class='row'>
  <div class='col-md-10'>
    <div class='panel-section'>
      <div class='panel-heading'>
        <div class='title strong'>{$lang->user->details}</div>
      </div>
      <div class='panel-heading spacing'>
        <div class='tag-block user-recharge'>
          <div class='tag'>
            <div class='tag-score keepleft'>
              {if($app->user->account == 'guest')}
              <div class='score-number'>0</div>
              {else}
              <div class='score-number'>{$user->score}</div>
              {/if}
              <div class='score-title'>{$lang->user->totalScore}</div>
            </div>
            <div class='tag-score'>
              {if($app->user->account == 'guest')}
              <div class='score-number'>0</div>
              {else}
              <div class='score-number'>{$user->rank}</div>
              {/if}
              <div class='score-title'>{$lang->user->levelScore}</div>
            </div>
            {if(commonModel::hasOnlinePayment())}
            {!html::a($control->createLink('score', 'buyScore'), $lang->user->buyScore, "class='btn-recharge' data-toggle='modal'")}
            {/if}
          </div>
        </div>
      </div>
      <div class='panel-body'>
      <table class='table table-hover'>
        <thead>
          <tr>
            <th class='w-100px'>{$lang->score->time}</th>
            <th class='w-150px'>{$lang->score->method}</th>
            <th class='w-150px'>{$lang->score->count}</th>
            <th class='w-150px'>{$lang->score->common}</th>
            <th>{$lang->score->note}</th>
          </tr>
        </thead>
        <tbody id='score'>
          {foreach($scores as $score)}
            <tr>
              {$score->time = substr($score->time,0,10)}
              <td>{$score->time}</td>
              <td>{!echo $score->type == 'punish' ? $lang->score->methods[$score->type] : $lang->score->methods[$score->method]}</td>
              <td>{!echo ($score->type == 'in' ? '+' : '-') . $score->count}</td>
              <td>{$score->after}</td>
              <td>{$score->note}</td>
            </tr>  
          {/foreach}
        </tbody>
        <tfoot>
          <tr><td colspan='8' class='a-right'>
            {$pager->createPullUpJS('#score', $lang->mobile->pullUpHint, helper::createLink('user', 'score', "recTotal=$pager->recTotal&recPerPage=$pager->recPerPage&pageID=\$ID"))}
          </td></tr>
        </tfoot>
      </table>
      </div>
    </div>
  </div>
</div>
{include TPL_ROOT . 'common/form.html.php'}
