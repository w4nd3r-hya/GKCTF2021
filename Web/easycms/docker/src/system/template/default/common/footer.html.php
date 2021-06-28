{if(!defined("RUN_MODE"))} {!die()} {/if}
  <div class='blocks all-bottom row' data-region='all-bottom'>
  {!$control->block->printRegion($layouts, 'all', 'bottom', true)}
  </div>
  </div></div>
  {* End div.page-content then div.page-wrapper in header.html.php *}
  <footer id='footer' class='clearfix'>
    <div class='wrapper'>
      <div id='footNav'>
        {!html::a(helper::createLink('sitemap', 'index'), '<i class=\'icon-sitemap\'></i> ' . $lang->sitemap->common, "class='text-linki'")}
        {if(empty($config->links->index) && !empty($config->links->all))}
        {!html::a(helper::createLink('links', 'index'), "<i class='icon-link'></i> " . $lang->link)}
        {/if}
      </div>
      <span id='copyright'>
       {$copyright=empty($config->site->copyright) ? '' : $config->site->copyright . '-'}
       {$contact=json_decode($config->company->contact)}
       {$company=(empty($contact->site) or $contact->site == $control->server->http_host) ? $config->company->name : html::a('http://' . $contact->site, $config->company->name, "target='_blank'")}
       &copy; {$copyright} {!echo date('Y')} {$company} &nbsp;&nbsp;
      </span>
      <span id='icpInfo'>
        {if(!empty($config->site->icpLink) and !empty($config->site->icpSN))}
          {!html::a(strpos($config->site->icpLink, 'http://') !== false ? $config->site->icpLink : 'http://' . $config->site->icpLink, $config->site->icpSN, "target='_blank'")}
        {/if}
        {if(empty($config->site->icpLink) and !empty($config->site->icpSN))}
          {$config->site->icpSN}
        {/if}
        {if(!empty($config->site->policeLink) and !empty($config->site->policeSN))}
          {!html::a(strpos($config->site->policeLink, 'http://') !== false ? $config->site->policeLink : 'http://' . $config->site->policeLink, html::image($webRoot . 'theme/default/default/images/main/police.png'), "target='_blank'")}
        {/if}
      </span>
      <div id='powerby'>
          {!commonModel::printPowerdBy()}
      </div>
      {if($config->site->execInfo == 'show')} {$config->execPlaceholder} {/if}
    </div>
  </footer>
  {if($config->debug)}
    {!js::import($jsRoot . 'jquery/form/min.js')}
  {/if}
  {if(isset($pageJS))}
  {!js::execute($pageJS)}
  {/if}
  {$extPath=TPL_ROOT . 'common' . DS . 'ext' . DS}
  {$extHookRule=$extPath . 'footer.front.*.hook.php'}
  {$extHookFiles=glob($extHookRule)}
  {foreach($extHookFiles as $hook)}
  {include $hook}
  {/foreach}
<a href='#' id='go2top' class='icon-arrow-up' data-toggle='tooltip' title='{$lang->back2Top}'></a>
</div>{* end "div.page-container" in "header.html.php" *}
{$qrcodeTpl=$control->loadModel('ui')->getEffectViewFile('default', 'common', 'qrcode')}
{include $qrcodeTpl}
<div class='hide'>{!$control->loadModel('block')->printRegion($layouts, 'all', 'footer')}</div>
{if(commonModel::isAvailable('shop'))}
  {$cartTpl=TPL_ROOT . 'common/cart.html.php'}
  {include $cartTpl}
{/if}
{$logTpl=TPL_ROOT . 'common/log.html.php';}
{include $logTpl}
{if($app->user->account != 'guest' and commonModel::isAvailable('score') and (!isset($config->site->resetMaxLoginDate) or $config->site->resetMaxLoginDate < date('Y-m-d')))}
  <script>$.get(createLink('score', 'resetMaxLogin'));</script>
{/if}
</body>
</html>
