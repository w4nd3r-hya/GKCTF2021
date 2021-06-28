{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The wechat qrcode front view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
/php*}
{$block->content = json_decode($block->content)}
{$publicList = $model->loadModel('wechat')->getList()}
{if(!empty($publicList))}
  <div id="block{$block->id}" class='panel panel-block hidden-sm hidden-xs {$blockClass}'>
    <div class='panel-heading'>
      <strong>{!echo $icon . $block->title}</strong>
      {if(!empty($block->content->moreText) and !empty($block->content->moreUrl))}
        <div class='pull-right'>{!html::a($block->content->moreUrl, $block->content->moreText)}</div>
      {/if}
    </div>
    <div class='cards borderless with-icon'>
      {foreach($publicList as $public)}
        <div class='card'>
          <i class='icon icon-s3 icon-wechat bg-success circle'></i>
          <div class='card-content'>
            {if($public->qrcode)}
              <div class='pull-right'>
                <a href='###' class='bg-primary-pale text-primary block' data-toggle='modal' data-type='custom' data-custom="<div class='text-center'>{!html::image($public->qrcode)}</div>" data-icon='qrcode' data-title='{$public->name}'><i class='icon icon-s3 icon-qrcode'></i></a>
              </div>
            {/if}
            <small class="text-muted">{$lang->wechatTip}</small>
            <div class="lead">{$public->name}</div>
          </div>
        </div>
      {/foreach}
    </div>
  </div>
{/if}
