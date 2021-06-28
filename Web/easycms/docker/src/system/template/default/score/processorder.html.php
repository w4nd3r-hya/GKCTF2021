{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{if($result)}
  <h1 class='f-16px text-center green'>{$lang->score->paySuccess} </h1>
  <p class='text-center'>{!html::a($control->createLink('user', 'score'), $lang->score->details, "class='btn'")}</p>
{else}
  <h1 class='f-16px text-center red'>{$lang->score->payFail}</h1>
{/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
