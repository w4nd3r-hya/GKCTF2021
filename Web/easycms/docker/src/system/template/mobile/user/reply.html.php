{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The reply view file of user for mobile template of chanzhiEPS.
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
    <div class='title strong'>{$lang->user->reply}</div>
  </div>
  <div class='cards condensed cards-list' id='reply'>
    {foreach($replies as $reply)}
      <a href='{$control->createLink('thread', 'view', "id=$reply->thread") . "#$reply->id"}' class='card'>
        <div class='card-fix'>
          <div class='card-top'>
            <div class='card-title'>{$reply->title}</div>
            <div class='card-theard'>{$reply->boardName}</div>
          </div>
          <div class='card-body'>
            <div class='card-content content'>{$reply->content}</div>
            <div class='card-content text-muted'>
              {!substr($reply->addedDate, 5, -3)}
            </div>
          </div>
        </div>
      </a>
    {/foreach}
  </div>
  {$pager->createPullUpJS('#reply', $lang->mobile->pullUpHint)}
</div>
