{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{!js::import($jsRoot . 'fingerprint/fingerprint.js')}
<div class="page-user-control">
  <div class="row">
    {include TPL_ROOT . 'user/side.html.php'}
    <div class='col-md-10'>
      <div class='panel'>
        <div class='panel-heading'><strong><i class='icon-edit'></i> {!echo $lang->user->editProfile}</strong></div>
        <div class='panel-body'>
          <form method='post' id='ajaxForm' class='form form-horizontal' data-checkfingerprint='1'>
            <div class='form-group'>
              <label for='realname' class='col-md-2 col-sm-3 control-label'>{!echo $lang->user->realname}</label>
              <div class='col-md-6 col-sm-6'>
                {if($user->admin == 'super')}
                  {if(count(explode(',', $control->config->enabledLangs)) > 1)}
                    <div class='input-group'>
                      {if(strpos($control->config->enabledLangs, 'zh-cn') !== false)}
                        <label class='input-group-addon'>{$config->langs['zh-cn']}</label>
                        {!html::input("realnames[cn]", isset($user->realnames->cn) ? $user->realnames->cn : '', "class='form-control'")}
                      {/if}
                      {if(strpos($control->config->enabledLangs, 'zh-tw') !== false)}
                        <label class='input-group-addon'>{!echo $config->langs['zh-tw']}</label>
                        {!html::input("realnames[tw]", isset($user->realnames->tw) ? $user->realnames->tw : '', "class='form-control'")}
                      {/if}
                      {if(strpos($control->config->enabledLangs, 'en') !== false)}
                        <label class='input-group-addon'>{!echo $config->langs['en']}</label>
                        {!html::input("realnames[en]", isset($user->realnames->en) ? $user->realnames->en : '', "class='form-control'")}
                      {/if}
                    </div>
                  {else}
                    {$clientLang = $control->config->defaultLang}
                    {$clientLang = strpos($clientLang, 'zh-') !== false ? str_replace('zh-', '', $clientLang) : $clientLang}
                    {!html::input("realnames[{{$clientLang}}]", $user->realname, "class='form-control'")}
                  {/if}
                {else}
                  {!html::input('realname', $user->realname, "class='form-control'")}
                {/if}
              </div>
            </div>
            <div class='form-group'>
              <label for='oldPwd' class='col-md-2 col-sm-3 control-label'>{!echo $lang->user->oldPwd}</label>
              <div class='col-md-6 col-sm-6'>
                {!html::password('oldPwd', '', "class='form-control'")}
              </div>
            </div>
            <div class='form-group'>
              <label for='password' class='col-md-2 col-sm-3 control-label'>{!echo $lang->user->password}</label>
              <div class='col-md-6 col-sm-6'>
                {!html::password('password1', '', "class='form-control'")}
              </div>
            </div>
            <div class='form-group'>
              <label for='password2' class='col-md-2 col-sm-3 control-label'>{!echo $lang->user->password2}</label>
              <div class='col-md-6 col-sm-6'>
                {!html::password('password2', '', "class='form-control'")}
              </div>
            </div>
            <div class='form-group'>
              <label for='company' class='col-md-2 col-sm-3 control-label'>{!echo $lang->user->company}</label>
              <div class='col-md-6 col-sm-6'>
                {!html::input('company', $user->company, "class='form-control'")}
              </div>
            </div>
            <div class='form-group'>
              <label for='address' class='col-md-2 col-sm-3 control-label'>{!echo $lang->user->address}</label>
              <div class='col-md-6 col-sm-6'>
                {!html::input('address', $user->address, "class='form-control'")}
              </div>
            </div>
            <div class='form-group'>
              <label for='zipcode' class='col-md-2 col-sm-3 control-label'>{!echo $lang->user->zipcode}</label>
              <div class='col-md-6 col-sm-6'>
                {!html::input('zipcode', $user->zipcode, "class='form-control'")}
              </div>
            </div>
            <div class='form-group'>
              <label for='mobile' class='col-md-2 col-sm-3 control-label'>{!echo $lang->user->mobile}</label>
              <div class='col-md-6 col-sm-6'>
                {!html::input('mobile', $user->mobile, "class='form-control'")}
              </div>
            </div>
            <div class='form-group'>
              <label for='phone' class='col-md-2 col-sm-3 control-label'>{!echo $lang->user->phone}</label>
              <div class='col-md-6 col-sm-6'>
                {!html::input('phone', $user->phone, "class='form-control'")}
              </div>
            </div>
            <div class='form-group'>
              <label for='qq' class='col-md-2 col-sm-3 control-label'>{!echo $lang->user->qq}</label>
              <div class='col-md-6 col-sm-6'>
                {!html::input('qq', $user->qq, "class='form-control'")}
              </div>
            </div>
            <div class='form-group'>
              <label for='gtalk' class='col-md-2 col-sm-3 control-label'>{!echo $lang->user->gtalk}</label>
              <div class='col-md-6 col-sm-6'>
                {!html::input('gtalk', $user->gtalk, "class='form-control'")}
              </div>
            </div>
            <div class='form-group'>
              <div class='col-md-6 col-sm-6 col-md-offset-2 col-sm-offset-3'>{!html::submitButton() . html::hidden('token', $token)}</div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
