{if(!defined("RUN_MODE"))} {!die()} {/if}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<div class='panel panel-body'>
  <div class='panel' id='reset'>
    <div class='panel-heading'><strong>{$lang->user->sendRecoverEmail}</strong></div>
    <div class='panel-body'>
      <form method='post' id='ajaxForm'>
        <div class='form-group'>
          {!html::input('account', '', "class='form-control' placeholder='{{$lang->user->inputAccountOrEmail}}'")}
        </div>
        {!html::submitButton($lang->user->submit,'btn btn-primary btn-block')}
      </form>
    </div>
  </div>  
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
