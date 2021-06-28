<?php if(!defined("RUN_MODE")) die();?>
<?php 
$lang->admin->common        = '後台管理';
$lang->admin->index         = '首頁';
$lang->admin->checked       = '已認證';

$lang->admin->getEmailCodeByApi  = '獲取郵箱驗證碼';
$lang->admin->getMobileCodeByApi = '獲取手機驗證碼';

$lang->admin->shortcuts = new stdclass();
$lang->admin->shortcuts->common             = '快捷入口';
$lang->admin->shortcuts->articleCategories  = '文章類目';
$lang->admin->shortcuts->article            = '發佈文章';
$lang->admin->shortcuts->product            = '添加產品';
$lang->admin->shortcuts->feedback           = '處理反饋';
$lang->admin->shortcuts->site               = '站點設置';
$lang->admin->shortcuts->logo               = 'LOGO設置';
$lang->admin->shortcuts->company            = '公司信息';
$lang->admin->shortcuts->contact            = '聯繫方式';

$lang->admin->thread       = '最新帖子';
$lang->admin->order        = '最新訂單';
$lang->admin->feedback     = '最新反饋';

$lang->admin->adminEntry     = '警告：您現在的管理入口還是預設的admin.php，建議將admin.php改名以增強系統安全!';

$lang->admin->connectApiFail = "不能連接到蟬知社區，請檢查您的網絡設置後 <a href='javascritp:loaction.reload()'>重試</a>。";
$lang->admin->registerInfo   = "站點已經綁定到蟬知賬號%s，%s";
$lang->admin->registerPage   = '登記頁面';
$lang->admin->rebind         = "重新綁定";
$lang->admin->bindedInfo     = '蟬知社區賬號信息';

$lang->js->confirmRebind = "確認要重新綁定蟬知賬號？";

$lang->admin->community = new stdclass();
$lang->admin->community->common     = '蟬知社區';
$lang->admin->community->caption    = '沒有蟬知社區賬號？馬上註冊一個!';
$lang->admin->community->lblAccount = '請設置您的用戶名，英文字母和數字的組合，三位以上。';
$lang->admin->community->lblPasswd  = '請設置您的密碼。數字和字母的組合，六位以上。';
$lang->admin->community->submit     = '註冊';
$lang->admin->community->success    = "註冊賬戶成功";
$lang->admin->community->update     = "更新資料";

$lang->admin->bind = new stdclass();
$lang->admin->bind->caption = '已有蟬知社區賬號，輸入用戶名密碼進行綁定！';
$lang->admin->bind->submit  = '綁定賬號';
$lang->admin->bind->success = "關聯賬戶成功";
