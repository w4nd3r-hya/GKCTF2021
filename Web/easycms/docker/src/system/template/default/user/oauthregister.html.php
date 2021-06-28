{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='panel'>
  <div class='panel-heading'><strong>{!echo $lang->user->oauth->lblProfile}</strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='form-horizontal w-p50 center-block'>
      <div class='form-group'>
        <label class='col-sm-2 control-label' for='username'>{!echo $lang->user->account}</label>
        <div class='col-sm-9 required'>{!html::input('account', '', "class='form-control' placeholder='{{$lang->user->register->lblAccount}}'")}</div>
      </div>
      <div class='form-group'>
        <label class='col-sm-2 control-label' for='realname'>{!echo $lang->user->realname}</label>
        <div class='col-sm-9 required'>{!html::input('realname', '', "class='form-control'")}</div>
      </div>
      <div class='form-group'>
        <label class='col-sm-2 control-label' for='email'>{!echo $lang->user->email}</label>
        <div class='col-sm-9 required'>{!html::input('email', '', "class='form-control'")}</div>
      </div>
      <div class='form-group'>
        <label class='col-sm-2 control-label' for='password'>{!echo $lang->user->password}</label>
        <div class='col-sm-9 required'>{!html::password('password1', '', "class='form-control'")}</div>
      </div>
      <div class='form-group'>
        <label class='col-sm-2 control-label' for='password'>{!echo $lang->user->password2}</label>
        <div class='col-sm-9 required'>{!html::password('password2', '', "class='form-control'")}</div>
      </div>
      <div class='form-group'>
        <label class='col-sm-2 control-label'></label>
        <div class='col-sm-9'>{!html::submitButton('', 'btn btn-success') . html::hidden('referer', $referer)}</div>
      </div>
    </form>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
