{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The edit view file of user for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.simple')}
<style>
.modal-content {border:0px}
</style>
<div class='modal-dialog'>
  <div class='modal-content'>
    <div class='modal-body'>
      <form id='editProfileForm' method='post' action="{!inlink('edit')}" data-checkfingerprint='1'>
        <div class='form-group form-pad-list'>
          <div class='form-group pad-label-left'>
            {if($field == 'realname')}
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
                {!html::input($field, $user->$field, "class='form-control'")}
                <label for='{$field}'>{$lang->user->$field}</label>
              {/if}
            {elseif(strpos('qq,phone,zipcode', $field) !== false)}
              <input type='number' id='{$field}' name='{$field}' value='{$user->$field}' class='form-control'/>
              <label for='{$field}'>{$lang->user->$field}</label>
            {else}
              {!html::input($field, $user->$field, "class='form-control'")}
              <label for='{$field}'>{$lang->user->$field}</label>
            {/if}
            {!html::input('field', $field, "class='hide'")}
          </div>
        </div>
        <div class='form-group'>
          {!html::submitButton('', 'btn primary block')}
        </div>
      </form>
    </div>
  </div>
</div>
{noparse}
<script>
$(function()
{
    var $editProfileForm = $('#editProfileForm');
    $editProfileForm.ajaxform({onSuccess: function(response)
    {
        if(response.result == 'success')
        {
            $.closeModal();
        }
    }
    });
});
</script>
{/noparse}
