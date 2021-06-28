{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The modify view file of article for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2016 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
php*}
<div class='modal-dialog'>
  <div class='modal-content'>
    <div class='modal-header'>
      <button type='button' class='close' data-dismiss='modal'><span aria-hidden='true'>×</span></button>
      <h5 class='modal-title'><i class='icon-pencil'></i> {$lang->article->edit}</h5>
    </div>
    <div class='modal-body'>
      <form id='editArticleForm' method='post' action="{!inlink('post')}">
        <div class='row'>
          <div class='col-6'>
            <div class='form-group'>
              <label for='author' class='control-label'>{$lang->article->author}</label>
              {!html::input('author', $article->author, "class='form-control'")}
            </div>
          </div>
          <div class='col-6'>
            <div class='form-group'>
              <label for='source' class='control-label'>{$lang->article->source}</label>
              {!html::select('source', $lang->article->sourceList, $article->source, "class='form-control'")}
            </div>
          </div>
        </div>
        <div class='row hidden' style='margin-bottom: 10px' id='sourceRow'>
          <div class='col-6'>{!html::input('copySite', $article->copySite, "class='form-control' placeholder='{{$lang->article->copySite}}'")}</div>
          <div class='col-6'>{!html::input('copyURL',  $article->copyURL, "class='form-control' placeholder='{{$lang->article->copyURL}}'")}</div>
        </div>
        <div class='form-group'>
          <label for='title' class='control-label'>{$lang->article->title}</label>
          {!html::input('title', $article->title, "class='form-control'")}
        </div>
        <div class='form-group'>
          <label for='keywords' class='control-label'>{$lang->article->keywords}</label>
          {!html::input('keywords', $article->keywords, "class='form-control' placeholder='{{$lang->keywordsHolder}}'")}
        </div>
        <div class='form-group'>
          <label for='summary' class='control-label'>{$lang->article->summary}</label>
          {!html::textarea('summary', $article->summary, "rows='2' class='form-control'")}
        </div>
        <div class='form-group'>
          <label for='content' class='control-label'>{$lang->article->content}</label>
          {!html::textarea('content', $article->content, "rows='10' class='form-control'")}
        </div>
        <div class='form-group'>
          {!html::submitButton('', 'btn primary block')}
        </div>
      </form>
    </div>
  </div>
</div>
{noparse}
<style>
.form-group > .form-control + .form-control {margin-top: 5px}
</style>
<script>
$(function()
{
    $('#source').on('change', function()
    {
        $('#sourceRow').toggleClass('hidden', $(this).val() === 'original');
    });

    var $editArticleForm = $('#editArticleForm');
    $editArticleForm.ajaxform({onSuccess: function(response)
    {
        if(response.result == 'success')
        {
            $.closeModal();
        }
    }
    });
});
</script>
{/noparse}
