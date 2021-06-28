<?php
/* Set the error reporting. */
error_reporting(E_ALL);

/* Start output buffer. */
ob_start();

/* Define the run mode as front. */
define('RUN_MODE', 'xuanxuan');

/* Load the framework. */
include 'xuanxuanloader.php';

/* Log the time and define the run mode. */
$startTime = getTime();

/* Run the app. */
$appName = 'chanzhi';
$app     = xuanxuan::createApp($appName, $systemRoot, 'xuanxuan');

$app->loadCommon();
$app->parseRequest();
$app->loadModule();

/* Flush the buffer. */
echo helper::removeUTF8Bom(ob_get_clean());
