{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{!js::set('agreement', (!empty($control->config->site->agreement) and $control->config->site->agreement == 'open') ? 'open' : 'close')}
{!js::import($jsRoot . 'fingerprint/fingerprint.js')}
<div class='panel panel-body' id='reg'>
  <div id='login-region'>
    <div class='panel panel-pure' id='panel-pure'>
      <div class='panel-heading'>
        <div id="heading-title">{!echo $lang->user->register->welcome}</div>
        <div id="heading-login">
         {!echo "<span id='heading-loginTip'>" . $lang->user->register->loginTip . " </span>"}
         {!html::a(inlink('login'), $lang->user->register->login)}
        </div>
      </div>
      <form method='post' id='ajaxForm' class='form-horizontal' role='form' data-checkfingerprint='1'>
        <div class='panel-body'>
          <div class='form-group'>
            <label class='col-sm-3 control-label'>{!echo $lang->user->account}</label>
            <div class='col-sm-9'>{!html::input('account', '', "class='form-control form-control' autocomplete='off' placeholder='" . $lang->user->register->lblAccount . "'")}</div>
          </div>
          <div class='form-group'>
            <label class="col-sm-3 control-label">{!echo $lang->user->realname}</label>
            <div class='col-sm-9'>{!html::input('realname', '', "class='form-control'")}</div>
          </div>
          <div class='form-group'>
            <label class="col-sm-3 control-label">{!echo $lang->user->email}</label>
            <div class='col-sm-9'>{!html::input('email', '', "class='form-control' autocomplete='off'") . ''}</div>
          </div>
          <div class='form-group'>
            <label class="col-sm-3 control-label">{!echo $lang->user->password}</label>
            <div class='col-sm-9'>{!html::password('password1', '', "class='form-control' autocomplate='off' placeholder='" . $lang->user->register->lblPassword . "'")}</div>
          </div>
          <div class='form-group'>
            <label class="col-sm-3 control-label">{!echo $lang->user->password2}</label>
            <div class='col-sm-9'>{!html::password('password2', '', "class='form-control'")}</div>
          </div>
          <div class='form-group'>
            <label class="col-sm-3 control-label">{!echo $lang->user->company}</label>
            <div class='col-sm-9'>{!html::input('company', '', "class='form-control'")}</div>
          </div>
          <div class='form-group'>
            <label class="col-sm-3 control-label">{!echo $lang->user->phone}</label>
            <div class='col-sm-9'>{!html::input('phone', '', "class='form-control'")}</div>
          </div>
          {if(isset($control->config->site->agreement) and $control->config->site->agreement == 'open')}
          <div class='form-group agreement-form'>
            <label class="col-sm-3 control-label"></label>
            <input type='checkbox' id='agreement' name='agreement' value='1'>
            <span>{!echo $lang->user->register->agree . '《'. html::a(helper::createLink('user', 'agreement'), $control->config->site->agreementTitle ? $control->config->site->agreementTitle : $lang->user->register->agreement, "data-toggle='modal'") . '》'}</span>
          </div>
          {/if}
          {if(zget($control->config->site, 'captcha', 'auto') == 'open')}
          {$control->loadModel('guarder')} 
          <div class='form-group'>
            <label class="col-sm-3 control-label">{!echo $lang->guarder->captcha}</label>
            <div class='col-sm-9 row' id='captchaBox'>{!echo $control->guarder->create4Comment(false)}</div>
          </div>
          {/if}
          <div class='form-group'>
            <div class="col-sm-3"></div>
            <div class='col-sm-9'>{!html::submitButton($lang->register,'btn btn-primary btn-block') . html::hidden('referer', $referer)}</div>
          </div>
          <div class='form-group'>
            <div class="col-sm-3"></div>
            <div class='col-sm-9'>{include TPL_ROOT . 'user/oauthlogin.html.php'}</div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
