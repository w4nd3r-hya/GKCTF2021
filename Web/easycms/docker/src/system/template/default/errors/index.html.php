{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
/**
 * The error view file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     error
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
*}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')}
<style>
#panel-404 {padding: 40px 80px 60px;}
#panel-404 h1 {margin-bottom: 40px;}
#panel-404 form {max-width: 300px}
.screen-phone #panel-404 {padding: 20px 20px 30px;}
</style>
<div class='panel' id='panel-404'>
  <h1>404 <small> - {!echo $lang->error->pageNotFound}</small></h1>
  <p><small>{!echo $lang->error->searchTip}</small></p>
  <form action='{!echo helper::createLink('search')}' method='get' role='search'>
    <div class='input-group'>
      {$keywords = ($control->app->getModuleName() == 'search') ? $control->session->serachIngWord : ''}
      {!html::input('words', $keywords, "class='form-control' placeholder=''")}
      {if($control->config->requestType == 'GET')}{!html::hidden($control->config->moduleVar, 'search') . html::hidden($control->config->methodVar, 'index')} {/if}
      <div class='input-group-btn'>
        <button class='btn btn-default' type='submit'><i class='icon icon-search'></i></button>
      </div>
    </div>
  </form>
</div>
{!echo $control->fetch('sitemap', 'index', 'onlyBody=yes')}
{include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')}
