{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The profile view file of user for mobile template of chanzhiEPS.
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
{!js::import($control->config->webRoot . 'js/fingerprint/fingerprint.js')}
{foreach($control->config->user->infoGroups->mobile as $group => $items)}
<ul class='nav nav-primary user-control-nav nav-stacked'>
  {$navs = explode(',', $items)}
  {foreach($navs as $nav)}
  {if($nav == 'avatar')}
    {$html = html::image($config->webRoot . 'theme/mobile/common/img/default-head.png')}
    {$class = 'btn avatar default'} 
  {else}
    {$html = '<span>' . $user->$nav . '</span>'}
    {$class = 'btn default'} 
  {/if}
  <li>{!html::a($control->createLink('user', 'edit', 'account=&field=' . $nav), $lang->user->$nav . '<i class="icon-chevron-right"></i>' . $html, "class='" . $class . "'")}</li>
  {/foreach}
</ul>
{/foreach}
{include TPL_ROOT . 'common/form.html.php'}
