<?php if(!defined("RUN_MODE")) die();?>
<?php
$config->bear->apiList = new stdclass();
$config->bear->apiList->posturl = "http://data.zz.baidu.com/urls?appid=%s&token=%s&type=%s";

$config->bear->submitOrder = array();
$config->bear->submitOrder['article'] = 'product';
$config->bear->submitOrder['product'] = 'thread';
$config->bear->submitOrder['thread']  = 'book';
