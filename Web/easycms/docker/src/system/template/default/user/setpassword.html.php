{if(!defined("RUN_MODE"))} {!die()} {/if}
{include TPL_ROOT . 'common/header.modal.html.php'}
<form method='post' action='{!inlink('setpassword')}' id='passwordForm' class='form'>
  <table class='table table-form borderless'>
    <tr>
      <th class="col-xs-4">{!echo $lang->user->account}</th>
      <td class="col-xs-6">{!echo $control->app->user->account}</td><td></td>
    </tr>  
    <tr>
      <th>{!echo $lang->user->newPassword}</th>
      <td>{!html::password('password1', '', "class='form-control'")}</td><td></td>
    </tr>  
    <tr>
      <th>{!echo $lang->user->password2}</th>
      <td>{!html::password('password2', '', "class='form-control'")}</td><td></td>
    </tr>  
    <tr><td></td><td>{!html::submitButton()}</td></tr>
  </table>
</form>
{include TPL_ROOT . 'common/footer.modal.html.php'}
