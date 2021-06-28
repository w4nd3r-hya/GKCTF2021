{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{!js::import($jsRoot . 'fingerprint/fingerprint.js')}
<div class="page-user-control">
  <div class="row">
    {include TPL_ROOT . 'user/side.html.php'}
    <div class='col-md-10'>
      <div class='panel'>
        <div class='panel-heading'><strong><i class='icon-edit'></i> {$lang->user->setEmail}</strong></div>
        <div class='panel-body'>
          <form method='post' id='ajaxForm' class='form form-horizontal' data-checkfingerprint='1'>
            <table class='table talbe-form table-borderless'>
              <tr>
                <th class='text-right w-100px'>{$lang->user->password}</th>
                <td class='w-p50'>{!html::password('oldPwd', '', "class='form-control' placeholder='{{$lang->user->placeholder->password}}'")}</td><td></td>
              </tr>
              <tr>
                <th class='text-right'>{$lang->user->email}</th>
                <td>{!html::input('email', $user->email, "class='form-control'")}</td><td></td>
              </tr>
              <tr>
                <th class='text-right'>{$lang->user->captcha}</th>
                <td>{!html::input('captcha', '', "class='form-control' placeholder='{{$lang->user->placeholder->verifyCode}}'")}</td>
                <td class='text-middle'>{!html::a($control->createLink('mail', 'sendmailcode'), $lang->user->getEmailCode, "id='mailSender' class='btn btn-sm btn-primary'")}</td>
              </tr>
              <tr>
                <th></th>
                <td colspan='2'>{!html::submitButton() . html::hidden('token', $token)}</td>
              </tr>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
