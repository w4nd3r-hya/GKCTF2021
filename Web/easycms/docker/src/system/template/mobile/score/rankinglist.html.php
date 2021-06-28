{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
{$common->printPositionBar('rankingList')}
<div class='row'>
  <div class='col-md-3'>
    <div class='panel'>
	  <div class='panel-heading'>{$lang->score->totalRank}</div>
      <div class='panel-body'>
        <dl>
          <dt><strong><span>{$lang->score->rank}</span>{$lang->score->username}</strong></dt>
		  <dd class='strong'>{$lang->score->common}</dd>
          {$i = 1}
          {foreach($allScore as $ranking)}
            {if($ranking->account == 'guest')} {continue} {/if}
            <dt>
              <span class='strong'>Top{$i}</span>
              {$basicInfo = $users[$ranking->account]}
              {$basicInfo->realname}
            </dt>
            <dd>{$ranking->score}</dd>
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
          <dt><strong><span>{$lang->score->rank}</span>{$lang->score->username}</strong></dt>
          <dd class='strong'>{$lang->score->common}</dd>
          {$i = 1}
          {foreach($monthScore as $ranking)}
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
      <div class='panel-heading'>{$lang->score->weekRank}</div>
      <div class='panel-body'>
        <dl>
          <dt><strong><span>{$lang->score->rank}</span>{$lang->score->username}</strong></dt>
          <dd class='strong'>{$lang->score->common}</dd>
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
          <dt><strong><span>{$lang->score->rank}</span>{$lang->score->username}</strong></dt>
          <dd class='strong'>{$lang->score->common}</dd>
          {$i = 1}
          {foreach($dayScore as $ranking)}
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
</div>
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
