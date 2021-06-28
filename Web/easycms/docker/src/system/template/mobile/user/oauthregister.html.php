{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
<div class='panel-section'>
  <div class='panel-heading'><strong>{$lang->user->oauth->lblProfile}</strong></div>
  <div class='panel-body'>
    <form method='post' class='ajaxform'>
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
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
