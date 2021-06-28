{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The reset password view file of user for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
<hr class='space'>
<div class='panel-section'>
  <div class='panel-heading'>
    <div class='title'><strong>{$lang->user->sendRecoverEmail}</strong></div>
  </div>
  <div class='panel-body'>
    <div id='successMsg' class='hide alert bg-primary-pale text-center'>
      <i class='icon-info-sign icon icon-x3 block'></i>
      <h5>{$lang->user->resetPassword->success}</h5>
    </div> 
    <form method='post' id='resetPwdForm'>
      <div class='form-group hide form-message alert text-danger bg-danger-pale'>
        <i class='icon icon-info-sign icon-s1'></i>
        <div class='content'></div>
      </div>
      <div class='form-group'>
        {!html::input('account', '', "class='form-control' placeholder='{{$lang->user->inputAccountOrEmail}}'")}
      </div>
      <div class='form-group'>
        {!html::submitButton($lang->user->submit,'btn primary block')}
      </div>
    </form>
  </div>
</div>
{include TPL_ROOT . 'common/form.html.php'}
{noparse}
<script>
$(function()
{
    var $form = $('#resetPwdForm'),
        $msg = $('#successMsg');

    $form.ajaxform({onResultSuccess: function()
    {
        $form.addClass('hide');
        $msg.removeClass('hide');
    }
    });
});
</script>
{/noparse}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
