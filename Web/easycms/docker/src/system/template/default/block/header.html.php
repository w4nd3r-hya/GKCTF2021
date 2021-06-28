{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The header view file of block module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
*/
*}
{$isSearchAvaliable = commonModel::isAvailable('search')} 
{$setting           = !empty($block->content) ? json_decode($block->content) : new stdclass()}
{$device            = $model->app->clientDevice}
{$template          = $model->config->template->{{$device}}->name}
{$theme             = $model->config->template->{{$device}}->theme}
{$logoSetting       = isset($model->config->site->logo) ? json_decode($model->config->site->logo) : new stdclass()}
{$logo              = ''}

{if(isset($logoSetting->$template->themes->all))}    {$logo = $logoSetting->$template->themes->all} {/if}
{if(isset($logoSetting->$template->themes->$theme))}  {$logo = $logoSetting->$template->themes->$theme} {/if}

{if($logo != '')} {$logo->extension = $model->loadModel('file')->getExtension($logo->pathname)} {/if}

{* Set default header layout setting. *}
{$setting->top             = isset($setting->top) ? $setting->top : new stdclass()}
{$setting->middle          = isset($setting->middle) ? $setting->middle : new stdclass()}
{$setting->bottom          = zget($setting, 'bottom', 'nav')}
{$setting->top->left       = zget($setting->top, 'left', '')}
{$setting->top->right      = zget($setting->top, 'right', 'login')}
{$setting->middle->left    = zget($setting->middle, 'left', 'logo')}
{$setting->middle->center  = zget($setting->middle, 'center', 'slogan')}
{$setting->middle->right   = zget($setting->middle, 'right', 'search')}
{$setting->compatible      = zget($setting, 'compatible', '0')}
{$setting->topLeftContent  = zget($setting, 'topLeftContent', '')}
{$setting->topRightContent = zget($setting, 'topRightContent', '')}

<div data-ve='block' data-id="{$block->id}">
  {if($setting->compatible)}
    {include $model->loadModel('ui')->getEffectViewFile('default', 'block', 'header.default')}
  {else}
    {include $model->loadModel('ui')->getEffectViewFile('default', 'block', 'header.layout')}
  {/if}
</div>
