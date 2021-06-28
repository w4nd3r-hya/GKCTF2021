{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The login view file of block module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Yidong Wang <yidong@cnezsoft.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.zentao.net
 */
*}
{if(!$model->loadModel('user')->isLogon())}
<div id="block{!echo $block->id}" class='panel-block-login panel panel-block {!echo $blockClass}'>
{if(!$model->session->random)} {$model->session->set('random', md5(time() . mt_rand()))} {/if}
{$referer = $app->getURI()}
{!js::import($config->webRoot . 'js/md5.js')}
{!js::import($config->webRoot . 'js/fingerprint/fingerprint.js')}
{!js::set('random', $model->session->random)}
  <div class='panel-heading'><strong>{!echo $icon . $block->title}</strong></div>
  <div class='panel-body'>
    <div style='max-width:500px;margin:0px auto'>
      <form method='post' id='ajaxForm' role='form' data-checkfingerprint='1' style='max-width:500px;margin'>
        <div class='form-group hiding'><div id='formError' class='alert alert-danger'></div></div>
        <div class='form-group'>{!html::input('account','',"placeholder='{{$model->lang->user->inputAccountOrEmail}}' class='form-control'")}</div>
        <div class='form-group'>{!html::password('password','',"placeholder='{{$model->lang->user->inputPassword}}' class='form-control'")}</div>
        {!html::submitButton($model->lang->user->login->common, 'btn btn-primary btn-wider btn-block')} 
      </form>
      <div style='margin:5px 0px;'>
        {if($model->config->mail->turnon and $model->config->site->resetPassword == 'open')} {!html::a(helper::createLink('user', 'resetpassword'), $model->lang->user->recoverPassword, "id='reset-pass' style='margin-left:5px;color:gray;'")} {/if}
        {!html::a(helper::createLink('user', 'register'), $model->lang->user->register->instant, "id='register' style='float:right;right:5px;margin-bottom:8px;'")}
      </div>
      {$control = $model}
      {include TPL_ROOT . 'user/oauthlogin.html.php'}
    </div>
  </div>
</div>
<script>
$(function()
{
    $('.panel-block-login #submit').click(function()
    {
        var $form    = $(this).closest('form');
        var account  = $form.find('#account').val();
        var password = $form.find('#password').val();
        var reg = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z0-9]+$/;
        if(!reg.test(account)) password = md5(md5(md5(password) + account) + v.random);

        fingerprint = getFingerprint();

        loginURL = createLink('user', 'login');
        $.ajax(
        {
            type: "POST",
            data:"account=" + account + '&password=' + password + '&referer=' + encodeURIComponent(self.location.href) + '&fingerprint=' + fingerprint,
            url:loginURL,
            dataType:'json',
            success:function(data)
            {
                if(data.result == 'success') return location.href=data.locate;
                $.ajax(
                {
                    type: "POST",
                    data:"account=" + account + '&password=' + $form.find('#password').val() + '&referer=' + encodeURIComponent(self.location.href) + '&fingerprint=' + fingerprint,
                    url:loginURL,
                    dataType:'json',
                    success:function(data)
                    {
                        if(data.result == 'fail') blockShowError($form.find('#formError'), data.message);
                        if(data.result == 'success') location.href=data.locate;
                        if(typeof(data) != 'object') blockShowError($form.find('#formError'), data);
                    },
                    error:function(data){blockShowError($form.find('#formError'), data.responseText);}
                })
            },
            error:function(data)
            {
                blockShowError($form.find('#formError'), data.responseText)
            }
        })
        return false;
    });
});

function blockShowError(obj, message)
{
    var error = obj.text(message);
    var parent = error.closest('.form-group');
    if(parent.length) parent.show();
    else error.show();
}
</script>
{/if}
