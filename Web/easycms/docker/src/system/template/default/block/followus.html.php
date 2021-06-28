{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
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
*}
{$block->content = json_decode($block->content)}
{$publicList = $model->loadModel('wechat')->getList()}
{if(!empty($publicList))}
<div id="block{!echo $block->id}" class='panel panel-block hidden-sm hidden-xs {!echo $blockClass}'>
  <div class='panel-heading'>
    <strong>{!echo $icon . $block->title}</strong>
    {if(!empty($block->content->moreText) and !empty($block->content->moreUrl))}
    <div class='pull-right'>{!html::a($block->content->moreUrl, $block->content->moreText)}</div>
    {/if}
  </div>
  <table class='w-p100'>
    {foreach($publicList as $public)}
    {if(!$public->qrcode)} {continue} {/if}
    <tr class='text-center'>
      <td class='wechat-block'>
        <div class='name'><i class='icon-weixin'>&nbsp;</i>{!echo $public->name}</div>
        <div class='qrcode'>{!html::image($public->qrcode, "class='w-220px'")}</div>
      </td>
    </tr>
    {/foreach}
  </table>
</div>
{/if}
