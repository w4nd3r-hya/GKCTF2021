{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The front login view file of user for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{$isSimpleMode = (isset($control->config->site->front) and $control->config->site->front == 'login')}
{if($isSimpleMode)}
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.lite')}
{else}
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
{/if}
<hr class='space'>
<div class='panel-section'>
  {include TPL_ROOT . 'user/oauthlogin.html.php'}
  <div class='panel-heading'>
    <div class='title'><strong>{$lang->user->login->welcome}</strong></div>
  </div>
  <div class='panel-body'>
  <form method='post' id='loginForm' role='form' data-checkfingerprint='1'>
    <div class='form-group hide form-message alert text-danger bg-danger-pale'>
      <i class='icon icon-info-sign icon-s1'></i>
      <div class='content'></div>
    </div>
    <div class='form-group'>{!html::input('account','',"placeholder='{{$lang->user->inputAccountOrEmail}}' class='form-control'")}</div>
    <div class='form-group'>{!html::password('password','',"placeholder='{{$lang->user->inputPassword}}' class='form-control'")}</div>
    {if(zget($control->config->site, 'captcha', 'auto') == 'open')}
    <div class='form-group'>{!echo $control->loadModel('guarder')->create4Comment(false)}</div>
    {/if}
    <div class='form-group'>{!html::submitButton($lang->user->login->common, 'btn primary block')}</div>
    <div class='form-group'>
      {if($config->mail->turnon and $control->config->site->resetPassword == 'open')} {!html::a(inlink('resetpassword'), $lang->user->recoverPassword, "class='btn btn-link'") . ' '} {/if}
      {if(!$isSimpleMode)} {!html::a(inlink('register'), $lang->user->register->common, "class='btn btn-link'")} {/if}
      {!html::hidden('referer', $referer)}
    </div>
  </form>
  </div>
</div>
{include TPL_ROOT . 'common/form.html.php'}
{if($isSimpleMode)}
    </body>
  </html>
{else}
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
{/if}
