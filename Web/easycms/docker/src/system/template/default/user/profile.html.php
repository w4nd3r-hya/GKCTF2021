{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{!js::set('confirmUnbind', $lang->user->confirmUnbind)}
<div class='page-user-control'>
  <div class='row'>
    {include TPL_ROOT . 'user/side.html.php'}
    <div class='col-md-10'>
      <div class='panel borderless'>
        <div class='panel-heading borderless'><strong><i class='icon-user'></i> {$lang->user->profile}</strong></div>
          <table class='table table-bordered' id="profileTable">
          <tr>
            <th class='w-100px text-right'>{$lang->user->realname}</th>
            <td>
              {$user->realname}
              {if(isset($user->provider) and isset($user->openID) and strpos($user->account, "{$user->provider}_") === false)}
                <span class='label label-info'>{$lang->user->oauth->typeList[$user->provider]}</span>
              {/if}
            </td>
          </tr>
          <tr>
            <th class='text-right'>{$lang->user->email}</th>
            <td id='emailTD'>{!str2Entity($user->email)}</td>
          </tr>
          <tr>
            <th class='text-right'>{$lang->user->company}</th>
            <td>{$user->company}</td>
          </tr>
          <tr>
            <th class='text-right'>{$lang->user->address}</th>
            <td>{$user->address}</td>
          </tr>
          <tr>
            <th class='text-right'>{$lang->user->zipcode}</th>
            <td>{$user->zipcode}</td>
          </tr>
          <tr>
            <th class='text-right'>{$lang->user->mobile}</th>
            <td id='mobileTD'>{!str2Entity($user->mobile)}</td>
          </tr>
          <tr>
            <th class='text-right'>{$lang->user->phone}</th>
            <td>{!str2Entity($user->phone)}</td>
          </tr>
          <tr>
            <th class='text-right'>{$lang->user->qq}</th>
            <td>{!str2Entity($user->qq)}</td>
          </tr>
          <tr>
            <th class='text-right'>{$lang->user->gtalk}</th>
            <td>{$user->gtalk}</td>
          </tr>
          <tr>
            <td class='borderless text-center' id='btnBox' colspan='2'>
              {!html::a(inlink('edit'), $lang->user->editProfile, "class='btn'")}
              {!html::a(inlink('setemail'), $lang->user->setEmail, "class='btn'")}
              {if(isset($user->provider) and isset($user->openID))}
                {if(strpos($user->account, "{$user->provider}_") === false)}
                  {$openID  = helper::safe64Encode($user->openID)} 
                  {$unionID = helper::safe64Encode($user->unionID)} 
                  {!html::a(inlink('oauthUnbind', "account=$user->account&provider=$user->provider&openID=$openID&unionID=$unionID"), $lang->user->oauth->lblUnbind, "class='btn unbind'")}
                {else}
                  {!html::a(inlink('oauthRegister'), $lang->user->oauth->lblProfile, "class='btn'")}
                  {!html::a(inlink('oauthBind'), $lang->user->oauth->lblBind, "class='btn'")}
                {/if}
              {/if}
            </td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
