<?php
/**
 * The router file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     chanzhiEPS
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/* Turn off error reporting first. */
error_reporting(0);

/* Start output buffer. */
ob_start();

/* Define the run mode as front. */
define('RUN_MODE', 'front');

/* Load the framework. */
include 'loader.php';

/* If static site deployed in localhost. */
if(is_file('static.txt') && isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] == DIRECTORY_SEPARATOR . 'index.php')
{
    helper::import($systemRoot . 'lib/mobile/mobile.class.php');    

    if(class_exists('mobile')) 
    {
        $mobile = new mobile();
        $device = ($mobile->isMobile() and !$mobile->isTablet()) ? 'mobile' : 'desktop';
    }
    else
    {
        $device = 'desktop';
    }

    if($device == 'mobile')
    {
        if(is_file('home.mhtml')) die(file_get_contents('home.mhtml'));
    }
    if(is_file('home.html')) die(file_get_contents('home.html'));
}

if(isset($_GET['requestType']) && $_GET['requestType'] == 'pathinfo') die('pathinfo');

/* Instance the app and run it. */
$app = router::createApp('chanzhi', $systemRoot);
$config = $app->config;

/* Connect to db, load module. */
$common = $app->loadCommon();
$common->checkDomain();

/* Check the reqeust is getconfig or not. Check installed or not. */
if(isset($_GET['mode']) and $_GET['mode'] == 'getconfig') die($app->exportConfig());
if(!isset($config->installed) or !$config->installed) die(header('location: install.php'));

/* Check site status. */
if($app->config->site->status == 'pause')
{
    die("<div style='text-align:center'>" . htmlspecialchars_decode($app->config->site->pauseTip, ENT_QUOTES) . '</div>');
}

$app->parseRequest();
$common->checkPriv();
$app->loadModule();

/* Flush the buffer. */
echo helper::removeUTF8Bom(ob_get_clean());
