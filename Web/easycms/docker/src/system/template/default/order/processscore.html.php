{if(!defined("RUN_MODE"))} {!die()} {/if}
{$control->app->loadLang('score')}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header.lite')}
{if($result)}
<div class='container' id='payResult'>
  <div class='modal-dialog w-450px'> 
  <div class='modal-body'><div class='alert alert-success text-center'><h4><i class="text-success icon-ok-sign"></i> {!echo $lang->order->paidSuccess}</h4></div></div>
  <div class='modal-footer'>{!html::a(helper::createLink('user', 'score'), $lang->score->details, "class='btn btn-success'")}</div>
</div>
{else}
<h3 class='text-center text-danger'>{!echo $lang->score->payFail}</h3>
{/if}
</div>
{if(isset($pageJS)) js::execute($pageJS)}
{include TPL_ROOT . 'common/log.html.php'}
</body>
</html>
