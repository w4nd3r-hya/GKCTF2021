{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
<div class='panel-section'>
  <div class='panel-heading'>
    <div class='title'><strong>{$lang->user->oauth->lblBind}</strong></div>
  </div>
  <div class='panel-body'>
    <form method='post' class='ajaxform' role='form'>
      <div class='form-group'>
        <label class='control-label' for='useraccount'>{$lang->user->account}</label>
        {!html::input('account', '', "class='form-control'")}
      </div>
      <div class='form-group'>
        <label class='control-label' for='password'>{$lang->user->password}</label>
        {!html::password('password', '', "class='form-control'")}
      </div>
      <div class='form-group'>
        {!html::submitButton($lang->login, 'btn primary block') . html::hidden('referer', $referer)}
      </div>
    </form>
  </div>
</div>
{include TPL_ROOT . 'common/form.html.php'}
