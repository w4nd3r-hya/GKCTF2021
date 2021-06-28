{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The comment view file of message for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     message
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}

{if(isset($pageCSS))} {!css::internal($pageCSS)} {/if}
<div class='comments panel'>
  {include $control->loadModel('ui')->getEffectViewFile('mobile', 'message', 'list')}
  <div class='comment-post vertical-center'>
    <form class='comment-form vertical-center' method='post' id='commentForm' action='{$control->createLink("message", "post", "type=comment")}'>
      <div class='form-group required'>
        <input class="comment-input" type="text" name="content" id="commentContent" value="" rows="5" placeholder="&nbsp&nbsp{$lang->message->inputPlaceholder}">
        {!html::hidden('objectType', $objectType)}
        {!html::hidden('objectID', $objectID)}
      </div>
      <div class='form-group'>
        <input type="submit" id="submitComment" value="{$lang->message->post}" data-loading="{$lang->message->submitting}...">
      </div>
    </form>
  </div>
</div>

{include TPL_ROOT . 'common/form.html.php'}