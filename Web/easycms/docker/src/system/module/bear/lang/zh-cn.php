<?php if(!defined("RUN_MODE")) die();?>
<?php
$lang->bear->common     = '熊掌号';
$lang->bear->setting    = '熊掌号设置';
$lang->bear->name       = '熊掌号名称';
$lang->bear->type       = '类型';
$lang->bear->appID      = 'appID';
$lang->bear->token      = 'Token';
$lang->bear->autoSync   = '自动同步';
$lang->bear->submitType = '推送类型';

$lang->bear->id       = '编号';
$lang->bear->time     = '提交时间';
$lang->bear->url      = '资源地址';
$lang->bear->auto     = '自动同步';
$lang->bear->status   = '状态';
$lang->bear->response = '提交结果';
$lang->bear->account  = '提交人';

$lang->bear->begin         = '开始时间';
$lang->bear->end           = '结束时间';
$lang->bear->submit        = '提交资源';
$lang->bear->log           = '提交日志';
$lang->bear->batchSubmit   = '批量提交资源';
$lang->bear->submitSuccess = '资源提交成功';
$lang->bear->submitFail    = '资源提交失败';
$lang->bear->submitResult  = "提交成功，新提交<span class='text-success'> %s </span> 条记录；";

$lang->bear->notices = array();
$lang->bear->notices['not_same_site'] = " %s 不是熊掌号绑定的域名。";
$lang->bear->notices['not_valid']     = "不合法的url列表。";

$lang->bear->submitTypes = array();
$lang->bear->submitTypes['realtime'] = '新增';
$lang->bear->submitTypes['batch']    = '历史';

$lang->bear->syncObjects = new stdclass;
$lang->bear->syncObjects->article = '文章';
$lang->bear->syncObjects->product = '产品';
$lang->bear->syncObjects->blog    = '博客';
$lang->bear->syncObjects->page    = '单页';

$lang->bear->placeholder = new stdclass;
$lang->bear->placeholder->appID = '您的熊掌号唯一识别ID';
$lang->bear->placeholder->token = '在搜索资源平台申请的推送用的准入密钥';

$lang->bear->typeList = array();
$lang->bear->typeList[1] = '个人';
$lang->bear->typeList[2] = '媒体';
$lang->bear->typeList[3] = '企业';
$lang->bear->typeList[4] = '政府';
$lang->bear->typeList[5] = '其他组织';

$lang->bear->logModes = new stdclass();
$lang->bear->logModes->yesterday = '昨日';
$lang->bear->logModes->today    = '今日';
$lang->bear->logModes->weekly   = '最近一周';
$lang->bear->logModes->monthly  = '最近30天';

$lang->bear->submitStatusList = array();
$lang->bear->submitStatusList['success'] = '成功';
$lang->bear->submitStatusList['fail']    = '失败';
