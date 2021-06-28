{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The index view file of message module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     message
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
*}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{!js::set('showDetail', $control->lang->message->showDetail)}
{!js::set('hideDetail', $control->lang->message->hideDetail)}
{$common->printPositionBar()}
<div class='row blocks' data-region='message_index-topBanner'>{$control->block->printRegion($layouts, 'message_index', 'topBanner', true)}</div>
<div class='row' id='columns' data-page='message_index'>
  {if(!empty($layouts['message_index']['side']) and !empty($sideFloat) && $sideFloat != 'hidden')}
  <div class="col-md-{!echo 12 - $sideGrid} col-main {if($sideFloat === 'left')} pull-right {/if}">
  {else}
  <div class="col-md-12">
  {/if}
    <div class='row blocks' data-region='message_index-top'>{$control->block->printRegion($layouts, 'message_index', 'top', true)}</div>
    {if(!empty($messages))}
    {$class = 'success'}
    {foreach($messages as $number => $message)}
    {$class = $class == 'success' ? '' : 'success'}
    <div class='w-p100 panel comment-item commment-panel' id="comment{$message->id}">
      <div class='panel-heading content-heading'>
        <span class='text-special'> {!echo $message->from}</span>
        <span class='text-muted'> {!echo $message->date}</span>
        {!html::a($control->createLink('message', 'reply', "messageID=$message->id"), $lang->message->reply, "class='pull-right' data-toggle='modal' data-type='iframe' data-icon='reply' data-title='{{$lang->message->reply}}'")}
      </div>
      <div class='panel-body'>{!echo nl2br($message->content)}</div>
      {$control->message->getFrontReplies($message)}
    </div>
    {/foreach}
    {/if}
    <div class='text-right'><div class='pager clearfix'>{$pager->show('right', 'short')}</div></div>
    <div class='panel panel-form'>
      <div class='panel-heading'><strong><i class='icon-comment-alt'></i> {!echo $lang->message->post}</strong></div>
      <div class='panel-body'>
        <form method='post' class='form-horizontal' id='commentForm' action="{!echo $control->createLink('message', 'post', 'type=message')}">
          {$from   = $control->session->user->account == 'guest' ? '' : $control->session->user->realname}
          {$phone  = $control->session->user->account == 'guest' ? '' : $control->session->user->phone}
          {$mobile = $control->session->user->account == 'guest' ? '' : $control->session->user->mobile}
          {$qq     = $control->session->user->account == 'guest' ? '' : $control->session->user->qq}
          {$email  = $control->session->user->account == 'guest' ? '' : $control->session->user->email}
          <div class='form-group'>
            <label for='from' class='col-sm-1 control-label'>{!echo $lang->message->from}</label>
            <div class='col-sm-5 required'>
              {!html::input('from', $from, "class='form-control'")}
            </div>
          </div>
          <div class='form-group'>
            <label for='phone' class='col-sm-1 control-label'>{!echo $lang->message->phone}</label>
            <div class='col-sm-5'>
              {!html::input('phone', $phone, "class='form-control'")}
            </div>
            <div class='col-sm-6'><div class='help-block'><small class='text-important'>{!echo $lang->message->contactHidden}</small></div></div>
          </div>
          <div class='form-group'>
            <label for='mobile' class='col-sm-1 control-label'>{!echo $lang->message->mobile}</label>
            <div class='col-sm-5'>
              {!html::input('mobile', $mobile, "class='form-control'")}
            </div>
          </div>
          <div class='form-group'>
            <label for='qq' class='col-sm-1 control-label'>{!echo $lang->message->qq}</label>
             <div class='col-sm-5'>
              {!html::input('qq', $qq, "class='form-control'")}
            </div>
          </div>
          <div class='form-group'>
            <label for='email' class='col-sm-1 control-label'>{!echo $lang->message->email}</label>
            <div class='col-sm-5'>
              {!html::input('email', '', "class='form-control'")}
            </div>
            <div class='col-sm-5'>
              <label class='checkbox-inline'><input type='checkbox' name='receiveEmail' value='1' checked /> {!echo $lang->comment->receiveEmail}</label>
            </div>
          </div>
          <div class='form-group'>
            <label for='content' class='col-sm-1 control-label'>{!echo $lang->message->content}</label>
            <div class='col-sm-11 required'>
              {!html::textarea('content', '', "class='form-control' rows='3'")}
              {!html::hidden('objectType', 'message')}
              {!html::hidden('objectID', 0)}
            </div>
          </div>
          {if(zget($control->config->site, 'captcha', 'auto') == 'open')}
          <div class='form-group' id='captchaBox'>
            {!echo $control->loadModel('guarder')->create4Comment()}
          </div>
          {else}
          <div class='form-group hiding' id='captchaBox'></div>
          {/if}
          <div class='form-group'>
            <div class='col-sm-1'></div>
            <div class='col-sm-11'><label class='checkbox-inline'><input type='checkbox' name='secret' value='1' />{!echo $lang->message->secret}</label></div>
          </div>
          <div class='form-group'>
            <div class='col-sm-1'></div>
            <div class='col-sm-11 col-sm-offset-1'>
              <span>{!html::submitButton($lang->message->submit)}</span>
              <span><small class="text-important">{!echo $lang->message->needCheck}</small></span>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class='row blocks' data-region='message_index-bottom'>{$control->block->printRegion($layouts, 'message_index', 'bottom', true)}</div>
  </div>
  {if(!empty($layouts['message_index']['side']) and !(empty($sideFloat) || $sideFloat === 'hidden'))}
  <div class='col-md-{!echo $sideGrid} col-side'>
    <div class='nav'>
    <a href='#commentForm' class='btn btn-primary btn-lg w-p100'><i class='icon-comment-alt'></i> {!echo $lang->message->post}</a>
    </div>
    <side class='blocks' data-region='message_index-side'>{$control->block->printRegion($layouts, 'message_index', 'side')}</side>
  </div>
  {/if}
</div>
<div class='row blocks' data-region='message_index-bottomBanner'>{$control->block->printRegion($layouts, 'message_index', 'bottomBanner', true)}</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
