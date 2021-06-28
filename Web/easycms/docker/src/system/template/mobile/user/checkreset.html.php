{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
<hr class='space'>
<div class='panel-section'>
  <div class='panel-heading'><strong>{$lang->user->changePassword}</strong></div>
  <div class='panel-body'>
    <form method='post' id='ajaxForm' class='ajaxform'>
      <div class='form-group'>
        <label class='control-label'>{$lang->user->password}</label>
        {!html::password('password1', '', "class='form-control'")}
      </div>
      <div class='form-group'>
        <label class='control-label'>{$lang->user->password2}</label>
        {!html::password('password2', '', "class='form-control'")}
      </div>
      {!html::submitButton($lang->user->submit,'btn primary block') . html::hidden('reset', $reset)}</td>
    </form>
  </div>
</div>  
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
