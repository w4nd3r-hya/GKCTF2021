{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='panel'>
  <div class='panel-heading'><strong>{!echo $lang->user->oauth->lblBind}</strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-horizontal center-block w-p50' role='form'>
      <div class='form-group'>
        <label class='col-sm-2 control-label' for='useraccount'>{!echo $lang->user->account}</label>
        <div class='col-sm-9'>{!html::input('account', '', "class='form-control'")}</div>
      </div>
      <div class='form-group'>
        <label class='col-sm-2 control-label' for='password'>{!echo $lang->user->password}</label>
        <div class='col-sm-9'>{!html::password('password', '', "class='form-control'")}</div>
      </div>
      <div class='form-group'>
        <label class='col-sm-2 control-label'></label>
        <div class='col-sm-9'>{!html::submitButton($lang->login, 'btn btn-success') . html::hidden('referer', $referer)}</div>
      </div>
    </form>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
