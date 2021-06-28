{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
<div class='panel-section'>
  <div class='panel-heading bg-gray-pale'>
    <strong>{$lang->user->oauth->lblProfile}</strong>
    <div class='actions'>{!html::a(inlink('ignoreBind'), $lang->user->oauth->ignore . '>>', "class='text-primary'") . html::hidden('referer', $referer)}</div>
  </div>
  <hr class='space'>
  <div class='panel-body'>
    <form method='post' id='registerForm' class='ajaxform' action='{$control->createLink('user', 'oauthRegister')}' role='form'>
      <div class='form-group'>
        <label class='control-label' for='username'>{$lang->user->account}</label>
        {!html::input('account', '', "class='form-control' placeholder='{{$lang->user->register->lblAccount}}'")}
      </div>
      <div class='form-group'>
        <label class='control-label' for='realname'>{$lang->user->realname}</label>
        {!html::input('realname', '', "class='form-control'")}
      </div>
      <div class='form-group'>
        <label class='control-label' for='email'>{$lang->user->email}</label>
        {!html::input('email', '', "class='form-control'")}
      </div>
      <div class='form-group'>
        <label class='control-label' for='password'>{$lang->user->password}</label>
        {!html::password('password1', '', "class='form-control'")}
      </div>
      <div class='form-group'>
        <label class='control-label' for='password'>{$lang->user->password2}</label>
        {!html::password('password2', '', "class='form-control'")}
      </div>
      <div class='form-group'>
        {!html::submitButton('', 'btn block success') . html::hidden('referer', $referer)}
      </div>
    </form>
  </div>
</div>
<hr>
<div class='panel-section'>
  <div class='panel-heading bg-gray-pale'>
    <strong>{$lang->user->oauth->lblBind}</strong>
    <div class='actions'>{!html::a(inlink('ignoreBind'), $lang->user->oauth->ignore . '>>', "class='text-primary'") . html::hidden('referer', $referer)}</div>
  </div>
  <hr class='space'>
  <div class='panel-body'>
    <form method='post' id='bindForm' class='ajaxform' action='{$control->createLink('user', 'oauthBind')}' role='form'>
      <div class='form-group'>
        <label class='control-label' for='useraccount'>{$lang->user->account}</label>
        {!html::input('account', '', "class='form-control'")}
      </div>
      <div class='form-group'>
        <label class='control-label' for='password'>{$lang->user->password}</label>
        {!html::password('password', '', "class='form-control'")}
      </div>
      <div class='form-group'>
        {!html::submitButton($lang->login, 'btn block success') . html::hidden('referer', $referer)}
      </div>
    </form>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
