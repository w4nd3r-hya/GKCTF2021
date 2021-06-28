<?php if(!defined("RUN_MODE")) die();?>
<?php
$lang->bear->common     = '熊掌號';
$lang->bear->setting    = '熊掌號設置';
$lang->bear->name       = '熊掌號名稱';
$lang->bear->type       = '類型';
$lang->bear->appID      = 'appID';
$lang->bear->token      = 'Token';
$lang->bear->autoSync   = '自動同步';
$lang->bear->submitType = '推送類型';

$lang->bear->id       = '編號';
$lang->bear->time     = '提交時間';
$lang->bear->url      = '資源地址';
$lang->bear->auto     = '自動同步';
$lang->bear->status   = '狀態';
$lang->bear->response = '提交結果';
$lang->bear->account  = '提交人';

$lang->bear->begin         = '開始時間';
$lang->bear->end           = '結束時間';
$lang->bear->submit        = '提交資源';
$lang->bear->log           = '提交日誌';
$lang->bear->batchSubmit   = '批量提交資源';
$lang->bear->submitSuccess = '資源提交成功';
$lang->bear->submitFail    = '資源提交失敗';
$lang->bear->submitResult  = "提交成功，新提交<span class='text-success'> %s </span> 條記錄；";

$lang->bear->notices = array();
$lang->bear->notices['not_same_site'] = " %s 不是熊掌號綁定的域名。";
$lang->bear->notices['not_valid']     = "不合法的url列表。";

$lang->bear->submitTypes = array();
$lang->bear->submitTypes['realtime'] = '新增';
$lang->bear->submitTypes['batch']    = '歷史';

$lang->bear->syncObjects = new stdclass;
$lang->bear->syncObjects->article = '文章';
$lang->bear->syncObjects->product = '產品';
$lang->bear->syncObjects->blog    = '博客';
$lang->bear->syncObjects->page    = '單頁';

$lang->bear->placeholder = new stdclass;
$lang->bear->placeholder->appID = '您的熊掌號唯一識別ID';
$lang->bear->placeholder->token = '在搜索資源平台申請的推送用的準入密鑰';

$lang->bear->typeList = array();
$lang->bear->typeList[1] = '個人';
$lang->bear->typeList[2] = '媒體';
$lang->bear->typeList[3] = '企業';
$lang->bear->typeList[4] = '政府';
$lang->bear->typeList[5] = '其他組織';

$lang->bear->logModes = new stdclass();
$lang->bear->logModes->yesterday = '昨日';
$lang->bear->logModes->today    = '今日';
$lang->bear->logModes->weekly   = '最近一周';
$lang->bear->logModes->monthly  = '最近30天';

$lang->bear->submitStatusList = array();
$lang->bear->submitStatusList['success'] = '成功';
$lang->bear->submitStatusList['fail']    = '失敗';
