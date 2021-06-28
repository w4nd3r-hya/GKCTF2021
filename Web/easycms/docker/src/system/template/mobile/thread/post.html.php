{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The post view file of thread for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     thread
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{$isRequestModal = helper::isAjaxRequest()}
{if($isRequestModal)}
  <div class='modal-dialog'>
    <div class='modal-content'>
      <div class='modal-header'>
        <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span></button>
        <h5 class='modal-title'><i class='icon-pencil'></i> {!echo $lang->thread->postTo . ' [ ' . $board->name . ' ]'}</h5>
      </div>
      <div class='modal-body'>
{else}
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
  <hr class='space'>
  <div class='panel-section'>
    <div class='panel-heading'>
      <strong><i class='icon-pencil'></i> {!echo $lang->thread->postTo . ' [ ' . $board->name . ' ]'}</strong>
    </div>
    <div class='panel-body'>
{/if}
<form id='postThreadForm' method='post' action='{$control->createLink('thread', 'post', "boardID=$board->id")}'>
  <div class='form-group'>
    {!html::input($titleInput, '', "class='form-control' placeholder='{{$lang->thread->title}}'")}
  </div>
  <div class='form-group'>
    {!html::textarea($contentInput, '', "class='form-control' rows='15' placeholder='{{$lang->thread->content}}'")}
  </div>
  {if($control->loadModel('file')->canUpload())}
    {* TODO: support upload files *}
  {/if}
  {if($canManage)}
    <div class='form-group'>
      <div class="checkbox">
        <label>
          <input type='checkbox' name='readonly' value='1'/><span>{$lang->thread->readonly}</span>
        </label>
      </div>
    </div>
  {/if}
  <table style='width: 100%'>
    <tr class='hide captcha-box'></tr>
  </table>
  <div class='form-group'>
    {!html::submitButton('', 'btn primary block')}
  </div>
</form>
{if($isRequestModal)}
  </div>{* end of modal-body *}
    </div>{* end of modal-content *}
  </div>{* end of modal-dialog *}
{else}
    </div>{* end of panel-body *}
  </div>{* end of panel-section *}
  {include TPL_ROOT . 'common/form.html.php'}
{/if}
{noparse}
<script>
$(function()
{
    var $postThreadForm = $('#postThreadForm');
    $postThreadForm.ajaxform({onResultSuccess: function(response)
    {
        if(response.result == 'success')
        {
            $.closeModal();
        }
    }, onSuccess: function(response)
    {
        if(response.reason == 'needChecking')
        {
            $postThreadForm.find('.captcha-box').html(Base64.decode(response.captcha)).removeClass('hide');
        }
    }
    });
});
</script>
{/noparse}
