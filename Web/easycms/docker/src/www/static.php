<?php
/**
 * The router file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2017 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     商业软件非免费软件
 * @author      Gang Liu <liugang@cnezsoft.com> 
 * @package     chanzhiEPS
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/* Turn off error reporting first. */
error_reporting(0);

/* Start output buffer. */
ob_start();

/* Define the run mode as admin. */
define('RUN_MODE', 'front');

/* Load the framework.*/
include 'loader.php';

/* Instance the app. */
$app = router::createApp('chanzhi', $systemRoot);
$config = $app->config;

if(!isset($_GET['key']) or $_GET['key'] != $config->site->static->key) die(helper::jsonEncode(array('result' => 'fail', 'message' => 'KEY ERROR!')));

if(isset($_GET['lang']))
{
    $clientLang = $_GET['lang'];
    if(strpos(",{$config->enabledLangs},", ",$clientLang,") === false) die(helper::jsonEncode(array('result' => 'fail', 'message' => 'INVALID LANGUAGE!')));

    if($clientLang != $config->defaultLang)
    {
        $app->clientLang = $clientLang;
        $app->fixLangConfig();
    }
}

if(isset($_GET['device']))
{
    $device = $_GET['device'];
    if($device != 'desktop' && $device != 'mobile') die(helper::jsonEncode(array('result' => 'fail', 'message' => 'INVALID CLIENT DEVICE!')));
    $app->clientDevice = $device;
}

$common = $app->loadCommon();

/* Change the request settings. */
$config->frontRequestType = $config->requestType;
$config->requestType      = 'PATH_INFO'; 
$config->default->module  = 'site';
$config->default->method  = 'createStaticFiles';

/* Run it. */
$app->parseRequest();

if($app->getModuleName() != strtolower($config->default->module) or $app->getMethodName() != strtolower($config->default->method)) die(helper::jsonEncode(array('result' => 'fail', 'message' => 'ACCESS DENIED!')));

$common->checkPriv();
$app->loadModule();

/* Flush the buffer. */
echo helper::removeUTF8Bom(ob_get_clean());
