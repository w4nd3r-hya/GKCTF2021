{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='panel panel-body'>
  <div class='panel' id='reset'>
    <div class='panel-heading'><strong>{$lang->user->changePassword}</strong></div>
    <div class='panel-body'>
      <form method='post' id='ajaxForm'>
        <div class='form-group row'>
          <label class='col-sm-3 control-label'>{!echo $lang->user->password}</label>
          <div class='col-sm-9'>{!html::password('password1', '', "class='form-control'")}</div>
        </div>
        <div class='form-group row'>
          <label class='col-sm-3 control-label'>{!echo $lang->user->password2}</label>
          <div class='col-sm-9'>{!html::password('password2', '', "class='form-control'")}</div>
        </div>
        {!html::submitButton($lang->user->submit,'btn btn-primary btn-block') . html::hidden('reset', $reset)}</td>
      </form>
    </div>
  </div>
</div>  
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
