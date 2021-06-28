{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The reset password mail view file of user module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     User
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
{$resetUrlTip = sprintf($control->lang->user->resetmail->resetUrl, $control->config->site->name, $control->server->http_host)}
{$mailContent = <<<EOT}
<html>
<head>
{noparse}
<style type='text/css'>
body{margin:0; padding:0;}
div{padding-left:30px;} 
</style>
{/noparse}
</head>
<body>
<div style='margin-top:20px;'>
  <p>
    {$control->lang->user->resetmail->account} {$account}
    <br>
    {$resetUrlTip}
    <br>
  <a href='{$resetURL}' target='_blank'>{$resetURL}</a>
  </p>
</div>
<div style='height:20px;border-bottom:1px solid #ddd;'></div>
<div style='margin:20px 0 0 0 ;'>{$control->lang->user->resetmail->notice}</div>
</body>
</html>
{EOT}
