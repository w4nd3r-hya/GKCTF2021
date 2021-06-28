{if(!defined("RUN_MODE"))} {!die()} {/if}
{$formOnly = (isset($control->config->site->front) and $control->config->site->front == 'login')}
{if($formOnly)}
  {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header.lite')}
{else}
  {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{/if}
{!js::import($jsRoot . 'md5.js')}
{!js::import($jsRoot . 'fingerprint/fingerprint.js')}
{!js::set('random', $control->session->random)}
<div class='panel panel-body' id='login'>
  <div class='row'>
    <div class='panel' id='login-pure'>
      <div id='login-region'>
        <div class='panel-heading'><span>{$lang->user->login->welcome}</span></div>
        <div class='panel-body'>
          <form method='post' id='ajaxForm' role='form' data-checkfingerprint='1'>
            <div class='form-group hiding'><div id='formError' class='alert alert-danger'></div></div>
            <div class='form-group'>{!html::input('account','',"placeholder='{{$lang->user->inputAccountOrEmail}}' class='form-control input-lg'")}</div>
            <div class='form-group'>{!html::password('password','',"placeholder='{{$lang->user->inputPassword}}' class='form-control input-lg'")}</div>
            {if(zget($control->config->site, 'captcha', 'auto') == 'open')}
            <div class='form-group'>
              <div class='row' id='captchaBox'>{!echo $control->loadModel('guarder')->create4Comment(false)}</div>
            </div>
            {/if}
            {!html::submitButton($lang->user->login->common, 'btn btn-primary btn-wider btn-lg btn-block')} 
            {!html::hidden('referer', $referer)}
            {include TPL_ROOT . 'user/oauthlogin.html.php'}
            <span class='regAndReset pull-right'>
            {if($config->mail->turnon and $control->config->site->resetPassword == 'open')}
              {!html::a(inlink('resetpassword'), $lang->user->recoverPassword, "id='reset-pass'")}
            {/if}
            {if(!$formOnly)}
              {!html::a(inlink('register'), $lang->user->register->instant, "id='register'")}
            {/if}
            </span>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
{if($formOnly)}
  {if($config->debug)}
    {!js::import($jsRoot . 'jquery/form/min.js')}
  {/if}
  {if(isset($pageJS))}
    {!js::execute($pageJS)}
  {/if}
  <style>
    html{height: 100%}
    body{height: 100%}
    #login{height: 100%; background-color: #F7F7F7; box-shadow: none; margin: 0; border: none;}
  </style>
  </body>
  </html>
{else}
  {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
{/if}
