{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The page form view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
*/php*}
{@$app->loadLang('message')}

<div id="block{!echo $block->id}" class='panel-block-message panel panel-block {!echo $blockClass}'>
  <div class='panel-heading'><strong>{!echo $icon . $block->title}</strong></div>
  <div class='panel-body'>
    <form method='post' class='form-horizontal' id='messageForm' action="{!echo helper::createLink('message', 'post', 'type=message&block=block','',false)}">
      {$from   = $session->user->account == 'guest' ? '' : $session->user->realname}
      {$mobile = $session->user->account == 'guest' ? '' : $session->user->mobile}
      {$qq     = $session->user->account == 'guest' ? '' : $session->user->qq}
      <div class='form-group'>
        <label for='blockFrom' class='col-sm-2 control-label'>{!echo $lang->message->from}</label>
        <div class='col-sm-10 required'>
          {!html::input('blockFrom', $from, "class='form-control'")}
        </div>
      </div>
      <div class='form-group'>
        <label for='mobile' class='col-sm-2 control-label'>{!echo $lang->message->mobile}</label>
        <div class='col-sm-10'>
          {!html::input('mobile', $mobile, "class='form-control'")}
        </div>
      </div>
      <div class='form-group'>
        <label for='qq' class='col-sm-2 control-label'>{!echo $lang->message->qq}</label>
        <div class='col-sm-10'>
          {!html::input('qq', $qq, "class='form-control'")}
        </div>
      </div>
      <div class='form-group'>
        <label for='blockContent' class='col-sm-2 control-label'>{!echo $lang->message->content}</label>
        <div class='col-sm-10 required'>
          {!html::textarea('blockContent', '', "class='form-control' rows='2'")}
          {!html::hidden('objectType', 'message')}
          {!html::hidden('objectID', 0)}
        </div>
      </div>
      {if(zget($config->site, 'captcha', 'auto') == 'open')}
      <div class='form-group' id='blockCaptchaBox'>
        {!echo $model->loadModel('guarder')->create4Comment(false)}
      </div>
      {else}
      <div class='form-group hiding' id='blockCaptchaBox'></div>
      {/if}
      <div class='form-group' align="center">
        <div class='col-sm-1'></div>
          <div class='col-sm-11 col-sm-offset-1'>
          <span>{!html::submitButton()}</span>
        </div>
      </div>
    </form>
  </div>
</div>

{noparse}
<script>
$(document).ready(function()
{
    $.setAjaxForm('#messageForm', function(response)
    {   
        if(response.result != 'success')
        {   
            if(response.reason == 'needChecking')
            {   
                $('#blockCaptchaBox').html(Base64.decode(response.captcha)).show();
            }
        }   
        else
        {
           location.href=createLink('message', 'index'); 
        }
    }); 
});
</script>
{/noparse}
