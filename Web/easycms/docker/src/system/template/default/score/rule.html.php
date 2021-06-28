{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The setCounts view file of score of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     Score
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
{$common->printPositionBar()}
<div class='panel'>
  <div class='panel-heading'>
    {if(count($control->config->score->ruleNav) > 1)}
    <ul id='typeNav' class='nav nav-tabs'>
    {foreach($control->config->score->ruleNav as $nav)}
      <li data-type='internal' {!echo $type == $nav ? "class='active'" : ''}>
        {!html::a(inlink($nav), $lang->score->$nav)}
      </li>
    {/foreach}
    </ul>
    {else}
    <strong>{$lang->score->rule}</strong>
    {/if}
  </div>
  <div class='panel-body'>
    <ol>
      {foreach($config->score->methodOptions as $item => $type)}
        {if($type != 'award' and $type != 'punish')} {continue} {/if}
        {$count = zget($control->config->score->counts, $item, '0')}
        {if($count == '0' or $count == '')} {continue} {/if}
        {if($item == 'expend')} {$item = 'expendproduct'}     {/if}
        {if($item == 'recharge')} {$item = 'rechargebalance'} {/if}
        {$count = ($type == 'award' ? '+' : '-') . $count}
        <li class='w-120px'>
          <span class='method'>{$lang->score->methods[$item]}</span>
          <span class='pull-right {!echo $type == 'award' ? 'green' : 'red'}'>{$count}</span>
        </li>
      {/foreach}
    </ol>
  </div>
</div>
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
