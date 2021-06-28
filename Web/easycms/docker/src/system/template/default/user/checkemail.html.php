{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='panel panel-body'>
  <div class='panel' id='checkEmail'>
    <div class='panel-heading'><strong>{!echo $lang->user->checkEmail}</strong></div>
    <div class='panel-body'>
      <form method='post' action='{!inlink('checkEmail')}' id='ajaxForm'>
        <table class='table table-form'>
          <tr>
            <th>{$lang->user->email}</th>
            <td>{!html::input('email', $user->email, "class='form-control'")}</td>
            <td>{!html::a($control->createLink('mail', 'sendmailcode'), $lang->user->getEmailCode, "id='mailSender' class='btn btn-xs'")}</td>
          </tr>
          <tr>
            <th>{$lang->user->captcha}</th>
            <td>{!html::input('captcha', '', "class='form-control'")}</td>
          </tr>
          <tr>
            <th></th>
            <td>{!html::submitButton() . html::hidden('referer', $referer)}</td>
          </tr>
        </table>
      </form>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
