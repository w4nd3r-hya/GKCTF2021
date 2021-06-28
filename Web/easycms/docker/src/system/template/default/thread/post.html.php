{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The post view file of thread module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{if(isset($oauthLoginLink))}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header.lite')}
{!js::set('oauthLoginLink', $oauthLoginLink)}
{!js::set('backLink', $backLink)}
{!js::set('bindWechatTip',  $lang->forum->bindWechatTip)}
{!js::execute($pageJS);}
{else}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{include TPL_ROOT . 'common/kindeditor.html.php'}

{$common->printPositionBar($board)}
{$colorPlates = ''}
{foreach(explode('|', $lang->colorPlates) as $value)}
  {$colorPlates .= "<div class='color color-tile' data='#" . $value . "'><i class='icon-ok'></i></div>"}
{/foreach}

<div class='panel panel-form'>
  <div class='panel-heading'><strong><i class='icon-edit'></i> {!echo $lang->thread->postTo . ' [ ' . $board->name . ' ]'}</strong></div>
  <div class='panel-body'>
    <form method='post' class='form-horizontal' id='threadForm' enctype='multipart/form-data'>
      <div class='form-group'>
        <label class='col-md-1 col-sm-2 control-label'>{$lang->thread->title}</label>
        <div class='col-md-11 col-sm-10'>
          {if($canManage)}
            <div class='input-group'>
              {!html::input($titleInput, '', "class='form-control'")}
              <div class='input-group-addon colorplate clearfix'>
                <div class='input-group color active' data=''>
                  <label class='input-group-addon'>{!echo $lang->color}</label>
                  {!html::input('color', '', "class='form-control input-color text-latin' placeholder='" . $lang->colorTip . "'")}
                  <span class='input-group-btn'>
                    <button type='button' class='btn dropdown-toggle' data-toggle='dropdown'> <i class='icon icon-question'></i> <span class='caret'></span></button>
                    <div class='dropdown-menu colors'>
                      {$colorPlates}
                    </div>
                  </span>
                </div>
              </div>
              {if($control->app->user->admin == 'super')}
                <span class='input-group-addon'>
                  <label class='checkbox-inline'>
                    <input type='checkbox' name='isLink' id='isLink' value='1'/><span>{$lang->thread->isLink}</span>
                  </label>
                </span>
              {/if}
              <span class='input-group-addon threadInfo'>
                <label class='checkbox-inline'>
                  <input type='checkbox' name='readonly' value='1'/><span>{$lang->thread->readonly}</span>
                </label>
              </span>
              <span class='input-group-addon threadInfo'>
                {$checked  = $board->discussion ? "checked='checked'" : ''}
                <label class='checkbox-inline'>
                  <input type='checkbox' name='discussion' value='1' {!echo $checked}/><span>{!echo $lang->thread->discussion}</span>
                </label>
              </span>
            </div>
          {else}
            {!html::input($titleInput, '', "class='form-control'")}
          {/if}
        </div>
      </div>
      <div class='threadInfo'>
        <div class='form-group'>
          <label class='col-md-1 col-sm-2 control-label'>{$lang->thread->content}</label>
          <div class='col-md-11 col-sm-10'>{!html::textarea($contentInput, '', "rows='15' class='form-control'")}</div>
        </div>
        {if($control->loadModel('file')->canUpload())}
          <div class='form-group'>
            <label class='col-md-1 col-sm-2 control-label'>{!echo $lang->thread->file}</label>
            <div class='col-md-7 col-sm-8 col-xs-11'>{!echo $control->fetch('file', 'buildForm')}</div>
          </div>
        {/if}
      </div>
      {if($control->app->user->admin == 'super')}
        <div class='form-group link'>
          <label class='col-md-1 col-sm-2 control-label'>{$lang->thread->link}</label>
          <div class='col-md-11 col-sm-10 required'>{!html::input('link', '', "class='form-control' placeholder='{{$lang->thread->placeholder->link}}'")}</div>
        </div>
      {/if}
      <div class='form-group'>
        {if(zget($control->config->site, 'captcha', 'auto') == 'open')}
          <div class='form-group' id='captchaBox'>
          {!echo $control->loadModel('guarder')->create4thread()}
          </div>
        {else}
          <div class='form-group hiding' id='captchaBox'></div>
        {/if}
        <label class='col-md-1 col-sm-2'></label>
        <div class='col-md-11 col-sm-10'>{!html::submitButton()}</div>
      </div>
    </form>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
{/if}
