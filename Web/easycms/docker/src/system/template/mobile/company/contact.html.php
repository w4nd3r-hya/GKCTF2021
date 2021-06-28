{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The contact view file of company for mobile template of chanzhiEPS.
 * The file should be used as ajax content
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     company
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
php*}
{include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')}
<div class='cards borderless with-icon' id='companyContact'>
  {if(!empty($contact->contacts))}
    <div class='card'>
      <i class='icon icon-s3 icon-user bg-important circle'></i>
      <div class='card-content'>
        <small class='text-muted'>{$control->lang->company->contacts}</small>
        <div class='lead'>{$contact->contacts}</div>
      </div>
    </div>
  {/if}
  {if(!empty($contact->phone))}
    <div class='card'>
      <i class='icon icon-s3 icon-phone bg-special circle'></i>
      <div class='card-content'>
        <small class='text-muted'>{$control->lang->company->phone}</small>
        <div class='lead'>{$contact->phone}</div>
      </div>
    </div>
  {/if}
  {if(!empty($contact->email))}
    <div class='card'>
      <i class='icon icon-s3 icon-envelope bg-special circle'></i>
      <div class='card-content'>
        <small class='text-muted'>{$control->lang->company->email}</small>
        <div class='lead'>{$contact->email}</div>
      </div>
    </div>
  {/if}
  {if(!empty($contact->qq))}
    <div class='card'>
      <i class='icon icon-s3 icon-qq bg-info circle'></i>
      <div class='card-content'>
        <small class='text-muted'>{$control->lang->company->qq}</small>
        <div class='lead'>{$contact->qq}</div>
      </div>
    </div>
  {/if}
  {if(!empty($contact->weixin))}
    <div class='card'>
      <i class='icon icon-s3 icon-wechat bg-success circle'></i>
      <div class='card-content'>
        <small class='text-muted'>{$control->lang->company->weixin}</small>
        <div class='lead'>{$contact->weixin}</div>
      </div>
    </div>
  {/if}
  {if(!empty($contact->weibo))}
    <div class='card'>
      <i class='icon icon-s3 icon-weibo bg-danger circle'></i>
      <div class='card-content'>
        <small class='text-muted'>{$control->lang->company->weibo}</small>
        <div class='lead'>{$contact->weibo}</div>
      </div>
    </div>
  {/if}
  {if(!empty($contact->wangwang))}
    <div class='card'>
      <i class='icon icon-s3 icon-comment-alt bg-warning circle'></i>
      <div class='card-content'>
        <small class='text-muted'>{$control->lang->company->wangwang}</small>
        <div class='lead'>{$contact->wangwang}</div>
      </div>
    </div>
  {/if}
  {if(!empty($contact->site))}
    <div class='card'>
      <i class='icon icon-s3 icon-globe bg-primary circle'></i>
      <div class='card-content'>
        <small class='text-muted'>{$control->lang->company->site}</small>
        <div class='lead'>{$contact->site}</div>
      </div>
    </div>
  {/if}
  {if(!empty($contact->address))}
    <div class='card'>
      <i class='icon icon-s3 icon-building bg-gray circle'></i>
      <div class='card-content'>
        <small class='text-muted'>{$control->lang->company->address}</small>
        <div class='lead'>{$contact->address}</div>
      </div>
    </div>
  {/if}
</div>
