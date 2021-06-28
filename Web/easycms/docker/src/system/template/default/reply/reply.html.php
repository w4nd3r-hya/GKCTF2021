{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The reply view file of reply module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     reply
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{if($control->thread->hasManagePriv($control->app->user->account, $board->owners)) $config->thread->editor->editreply['tools'] = 'full'}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{include TPL_ROOT . 'common/kindeditor.html.php'}
{$common->printPositionBar($board, $thread)}
<form method='post' id='ajaxForm' enctype='multipart/form-data'>
  <table class='table table-form'>
    <caption>{!echo $lang->thread->editReply}</caption>
    <tr>
      <th class='w-100px'>{!echo $lang->reply->content}</th>
      <td>
        {!html::textarea('content', htmlspecialchars($reply->content), "rows=20 class='area-1' tabindex=1")}
      </td>
    </tr>
    <tr>
      <th>{!echo $lang->thread->file}</th>
      <td>
        {if($reply->files)}
          {foreach($reply->files as $file)}
            {!html::a($file->fullURL, $file->title . '.' . $file->extension, "target='_blank'") . ' ' . html::linkButton('Ｘ', inlink('deleteFile', "fileID=$file->id&objectID=$reply->id&objectType=reply"), 'btn btn-default', '', 'hiddenwin')}
          {/foreach}
          {$control->fetch('file', 'buildForm')}
        {/if}
      </td>
    </tr>
    <tr>
      <th></th>
      <td colspan='2' align='center'>{!html::submitButton('', 'btn btn-primary', 'onclick="return checkGarbage(\'content\')" tabindex=2' ) . html::backButton()}</td></tr>
  </table>
</form>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
