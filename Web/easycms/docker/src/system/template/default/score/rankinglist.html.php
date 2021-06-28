{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{$common->printPositionBar('rankingList')}
<div class='panel'>
  <div class='panel-heading' id='nav-heading'>
    {if(count($control->config->score->ruleNav) > 1)}
    <ul id='typeNav' class='nav nav-tabs'>
    {foreach($control->config->score->ruleNav as $nav)}
      <li data-type='internal' {!echo $type == $nav ? "class='active'" : ''}>
        {!html::a(inlink($nav), $lang->score->$nav)}
      </li>
    {/foreach}
    </ul>
    {else}
      <strong>{!echo $lang->score->rule}</strong>
    {/if}
  </div>
  <div class='panel-body'>
    <div class='row'>
      <div class='col-md-3'>
        <div class='panel'>
    	  <div class='panel-heading'>{$lang->score->totalRank}</div>
          <div class='panel-body'>
            <dl>
              {$i = 1}
              {foreach($allScore as $ranking)}
              {if($ranking->account == 'guest')} {continue} {/if}
              <dt>
                <span class='strong'>Top{!echo $i}</span>
                {$basicInfo = $users[$ranking->account]}
                {$basicInfo->realname}
              </dt>
              <dd>{!echo $ranking->score}</dd>
              {@$i++}
              {/foreach}
            </dl>
          </div>
        </div>
      </div>
      <div class='col-md-3'>
        <div class='panel'>
          <div class='panel-heading'>{$lang->score->monthRank}</div>
          <div class='panel-body'>
            <dl>
              {$i = 1}
              {foreach($monthScore as $ranking)}
              {if($ranking->account == 'guest')} {continue} {/if}
              <dt>
                <span class='strong'>Top{!echo $i}</span>
                {$ranking->account = trim($ranking->account)}
                {$basicInfo = $users[$ranking->account]}
                {$basicInfo->realname}
              </dt>
              <dd>{!echo $ranking->sumScore}</dd>
              {@$i++}
              {/foreach}
            </dl>
          </div>
        </div>
      </div>
      <div class='col-md-3'>
        <div class='panel'>
          <div class='panel-heading'>{$lang->score->weekRank}</div>
          <div class='panel-body'>
            <dl>
              {$i = 1}
              {foreach($weekScore as $ranking)}
                {if($ranking->account == 'guest')} {continue} {/if}
                <dt>
                  <span class='strong'>Top{$i}</span>
                  {$ranking->account = trim($ranking->account)}
                  {$basicInfo = $users[$ranking->account]}
                  {$basicInfo->realname}
                </dt>
                <dd>{$ranking->sumScore}</dd>
                {@$i++}
              {/foreach}
            </dl>
          </div>
        </div>
      </div>
      <div class='col-md-3'>
        <div class='panel'>
          <div class='panel-heading'>{$lang->score->dayRank}</div>
          <div class='panel-body'>
            <dl>
              {$i = 1}
              {foreach($dayScore as $ranking)}
                {if($ranking->account == 'guest')} {continue} {/if}
                <dt>
                  <span class='strong'>Top{!echo $i}</span>
                  {$ranking->account = trim($ranking->account)}
                  {$basicInfo = $users[$ranking->account]}
                  {$basicInfo->realname}
                </dt>
                <dd>{!echo $ranking->sumScore}</dd>
                {@$i++}
              {/foreach}
            </dl>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
