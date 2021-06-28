{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The message view file of user for mobile template of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header.simple')}
<div class='panel-section'>
  <div class='panel-heading'>
    {!printf($lang->user->message->unread, $unreadCount)}
  </div>
  <div class='panel-body' id='cardListWarpper'>
    <div class='cards cards-list' id='cardList'>
    {foreach($messages as $message)}
      <div class='card card-block' {if(!$message->readed)} href='{$control->createLink("message", "view", "message=$message->id")}'{/if} onclick='cardClick(this)'>
        <div class='avatar'>
        {!html::image($config->webRoot . 'theme/mobile/common/img/default-head.png')}
        {if(!$message->readed)}
          <div class='dot'></div>
        {/if}
        </div>
        <div class='content'>
          <div class='symbol'>
            <strong>{$message->from}</strong> &nbsp;
            <small class='text-muted'>{!substr($message->date, 5)}</small>
          </div>
          <div class='text-body'>{$message->content}</div>
        </div>
        <div class='card-footer'>
          <div class="pull-right">
            {!html::a($control->createLink('message', 'batchDelete'), $lang->delete, "class='delete text-danger' onclick='delCard(this);return false;' data-id='{{$message->id}}'")}
          </div>
        </div>
      </div>
    {/foreach}
    </div>
    {$pager->createPullUpJS('#cardList', $lang->mobile->pullUpHint, helper::createLink('user', 'message', "recTotal=$pager->recTotal&recPerPage=$pager->recPerPage&pageID=\$ID"))}
  </div>
</div>
<script>
function cardClick(obj)
{  
    var $this   = $(obj);
    $this.find('.dot').hide();
    if($this.find('.text-body').css('max-height') == '40px')
    {
        $this.find('.text-body').css('max-height','200px');
    }
    else
    {
        $this.find('.text-body').css('max-height','40px');
    }
    if(!$this.attr('href')) return false;
    var options = $.extend(
    {
        url: $this.attr('href'),
        onSuccess: function(response){}
    }, $this.data());
    $.ajaxaction(options, $this);
}
function delCard(obj)
{
    var deleteSuccess = '{$lang->deleteSuccess}';
    var $this   = $(obj);
    var options = $.extend(
    {
        method: 'post',
        url: $this.attr('href'), 
        confirm: window.v.lang.confirmDelete,
        data: "messages[]=" + $this.data('id'),
        onResultSuccess: function(response)
        {
            response.locate = null;
            var $card = $this.closest('.card').addClass('fade');
            setTimeout($card.remove(), 300);
            $.messager.success(deleteSuccess);
        }
    }, $this.data());
    $.ajaxaction(options, $this);
}
</script>
{if($source == 'bottom')}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')}
{/if}
