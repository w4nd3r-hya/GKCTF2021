{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The edit view file of thread module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
*}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{include TPL_ROOT . 'common/kindeditor.html.php'}
{$common->printPositionBar($board, $thread)}
{$colorPlates = ''}
{foreach(explode('|', $lang->colorPlates) as $value)}
  {$colorPlates .= "<div class='color color-tile' data='#" . $value . "'><i class='icon-ok'></i></div>"}
{/foreach}

<div class="panel">
  <div class="panel-heading"><strong><i class="icon-edit"></i> {!echo $lang->thread->edit . $lang->colon . $thread->title}</strong></div>
  <div class="panel-body">
    <form method='post' class='form-horizontal' id='editForm' enctype='multipart/form-data'>
      <div class='form-group'>
        <label class='col-md-1 col-sm-2 control-label'>{!echo $lang->thread->title}</label>
        <div class='col-md-11 col-sm-10'>
          {$readonly = $thread->readonly ? 'checked' : ''}
          {if($canManage)}
            <div class='input-group'>
              {!html::input('title', $thread->title, "class='form-control'")}
              <div class='input-group-addon colorplate clearfix'>
                <div class='input-group color active' data="{!echo $thread->color}">
                  <label class='input-group-addon'>{!echo $lang->color}</label>
                  {!html::input('color', $thread->color, "class='form-control input-color text-latin' placeholder='" . $lang->colorTip . "'")}
                  <span class='input-group-btn'>
                    <button type='button' class='btn dropdown-toggle' data-toggle='dropdown'> <i class='icon icon-question'></i> <span class='caret'></span></button>
                    <div class='dropdown-menu colors'>
                      {!echo $colorPlates}
                    </div>
                  </span>
                </div>
              </div>
              {if($control->app->user->admin == 'super')}
              <span class='input-group-addon'>
                <label class='checkbox-inline'>
                  {$checked = $thread->link ? 'checked' : ''}
                  {!echo "<input type='checkbox' name='isLink' id='isLink' value='1' {{$checked}}/><span>{{$lang->thread->isLink}}</span>"}
                </label>
              </span>
              {/if}
              <span class='input-group-addon threadInfo'>
                <label class='checkbox-inline'>
                  {!echo "<input type='checkbox' name='readonly' value='1' $readonly/><span>{{$lang->thread->readonly}}</span>"}
                </label>
              </span>
              <span class='input-group-addon threadInfo'>
                {$discussion = $thread->discussion ? 'checked' : ''}
                <label class='checkbox-inline'>
                  <input type='checkbox' name='discussion' value='1' {$discussion}/><span>{$lang->thread->discussion}</span>
                </label>
              </span>
            </div>
        {else}
          {!html::input('title', $thread->title, "class='form-control'")}
        {/if}
        </div>
      </div>
      <div class='threadInfo'>
        <div class='form-group'>
          <label class='col-md-1 col-sm-2 control-label'>{!echo $lang->thread->content}</label>
          <div class='col-md-11 col-sm-10'>{!html::textarea('content', htmlspecialchars($thread->content), "rows='15' class='form-control'")}</div>
        </div>
        <div class='form-group'>
          <label class='col-md-1 col-sm-2 control-label'>{!echo $lang->thread->file}</label>
          <div class='col-md-11 col-sm-10'>
            {$control->thread->printFiles($thread, $canManage = true)}
            {!echo $control->fetch('file', 'buildForm')}
          </div>
        </div>
        <div class='form-group hiding' id='captchaBox'></div>
      </div>
      {if($control->app->user->admin == 'super')}
      <div class='form-group link'>
        <label class='col-md-1 col-sm-2 control-label'>{!echo $lang->thread->link}</label>
        <div class='col-md-11 col-sm-10 required'>{!html::input('link', $thread->link, "class='form-control' placeholder='{{$lang->thread->placeholder->link}}'")}</div>
      </div>
      {/if}
      <div class='form-group'>
        <label class='col-md-1 col-sm-2'></label>
        <div class='col-md-11 col-sm-10'>{!html::submitButton() . html::backButton();}</div>
      </div>
    </form>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
