<?php if(!defined("RUN_MODE")) die();?>
<?php
$lang->bear->common     = 'Baidu bear';
$lang->bear->setting    = 'Bear setting';
$lang->bear->name       = 'Bear name';
$lang->bear->type       = 'Type';
$lang->bear->appID      = 'appID';
$lang->bear->token      = 'Token';
$lang->bear->autoSync   = 'Auto Submit';
$lang->bear->submitType = 'Submit type';

$lang->bear->id       = 'ID';
$lang->bear->time     = 'Submit on';
$lang->bear->url      = 'Url';
$lang->bear->auto     = 'Auto';
$lang->bear->status   = 'Status';
$lang->bear->response = 'Response';
$lang->bear->account  = 'Submit by';

$lang->bear->begin         = 'Start Date';
$lang->bear->end           = 'End Date';
$lang->bear->submit        = 'Submit';
$lang->bear->log           = 'Submit log';
$lang->bear->batchSubmit   = 'Batch Submit';
$lang->bear->submitSuccess = 'Submitted.';
$lang->bear->submitFail    = 'Submitting failed.';
$lang->bear->submitResult  = "Dine. Added <span class='text-success'> %s </span> records；";

$lang->bear->notices = array();
$lang->bear->notices['not_same_site'] = " %s domain error.";
$lang->bear->notices['not_valid']     = "Not valid URL.";

$lang->bear->submitTypes = array();
$lang->bear->submitTypes['realtime'] = 'New';
$lang->bear->submitTypes['batch']    = 'history';

$lang->bear->syncObjects = new stdclass;
$lang->bear->syncObjects->article = 'article';
$lang->bear->syncObjects->product = 'product';
$lang->bear->syncObjects->blog    = 'blog';
$lang->bear->syncObjects->page    = 'page';

$lang->bear->placeholder = new stdclass;
$lang->bear->placeholder->appID = 'The ID of baidu bear';
$lang->bear->placeholder->token = 'Key for Push Application on Baidu Bear';

$lang->bear->typeList = array();
$lang->bear->typeList[1] = 'personal';
$lang->bear->typeList[2] = 'media';
$lang->bear->typeList[3] = 'enterprise';
$lang->bear->typeList[4] = 'government';
$lang->bear->typeList[5] = 'other';

$lang->bear->logModes = new stdclass();
$lang->bear->logModes->yesterday = 'yesterday';
$lang->bear->logModes->today     = 'today';
$lang->bear->logModes->weekly    = 'In 7 days';
$lang->bear->logModes->monthly   = 'In 30 days';

$lang->bear->submitStatusList = array();
$lang->bear->submitStatusList['success'] = 'success';
$lang->bear->submitStatusList['fail']    = 'fail';
