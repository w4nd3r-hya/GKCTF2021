<?php
/* Set the error reporting. */
error_reporting(E_ALL);

/* Start output buffer. */
ob_start();

/* Define the run mode as front. */
define('RUN_MODE', 'upgrade');

/* Load the framework. */
include 'xuanxuanloader.php';

/* Log the time and define the run mode. */
$startTime = getTime();

/* Run the app. */
$appName = 'chanzhi';
$app     = router::createApp($appName);
$common  = $app->loadCommon();

/* Reset the config params to make sure the upgrade program will be lauched. */
$config->set('requestType',    'GET');
$config->set('default.module', 'upgrade');
$config->set('default.method', 'upgradeXuanxuan');
$app->setDebug();

/* Check the installed version is the latest or not. */
$config->installedVersion = $common->loadModel('upgrade')->getXuanxuanVersion();
if(version_compare($config->xuanxuan->version, $config->installedVersion, '<=')) die(header('location: ../index.php'));

/* Run it. */
$app->parseRequest();
$app->loadModule();

/* Flush the buffer. */
echo helper::removeUTF8Bom(ob_get_clean());
