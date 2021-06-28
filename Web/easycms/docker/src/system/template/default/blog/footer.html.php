{if(!defined("RUN_MODE"))} {!die()} {/if}
    <div class='row blocks all-bottom' data-region='all-top'>{$control->loadModel('block')->printRegion($layouts, 'all', 'bottom', true)}</div>
  </div></div>{* end .page-content then .page-wrapper in header.html.php *}
  <footer id='footer'>
    <div class='wrapper'>
      <div id='footNav'>
        {!html::a(helper::createLink('rss', 'index', 'type=blog', '', 'xml'), '<i class="icon icon-rss-sign icon-large"></i>', "target='_blank'")}
      </div>
      <span id='copyright'>
        {$copyright = empty($config->site->copyright) ? '' : $config->site->copyright . '-'}
        {!echo "&copy; $copyright" . date('Y') . ' ' . $config->company->name . '&nbsp;&nbsp;'}
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
        {$chanzhiVersion                   = $config->version}
        {$isProVersion                     = strpos($chanzhiVersion, 'pro') !== false}
        {if($isProVersion)} {$chanzhiVersion = str_replace('pro', '', $chanzhiVersion)}{/if}
        {!printf($lang->poweredBy, $config->version, k(), "<span class='" . ($isProVersion ? ' icon-chanzhi-pro' : 'icon-chanzhi') . "'></span> <span class='name'>" . $lang->chanzhiEPSx . '</span>' . $chanzhiVersion)}
      </div>
      {if($control->config->site->execInfo == 'show')} {!echo $control->config->execPlaceholder} {/if}
    </div>
  </footer>
<a href='#' id='go2top' class='icon-arrow-up' data-toggle='tooltip' title='{!echo $lang->back2Top}'></a>
</div>{* end .page-container in header.html.php *}
{include TPL_ROOT . 'common/qrcode.html.php'}
{if($config->debug)} {!js::import($jsRoot . 'jquery/form/min.js')} {/if}
{if(isset($pageJS))} {!js::execute($pageJS)} {/if}
<div class='hide'>{if(RUN_MODE == 'front')} {$control->loadModel('block')->printRegion($layouts, 'all', 'footer')} {/if}</div>
{include TPL_ROOT . 'common/log.html.php'}
</body>
</html>
