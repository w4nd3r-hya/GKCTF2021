<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The upgrade module zh-tw file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $$
 * @link        http://www.chanzhi.org
 */
$lang->upgrade->common  = '升級';

$lang->upgrade->result  = '升級結果';
$lang->upgrade->fail    = '升級失敗';
$lang->upgrade->success = '升級成功';
$lang->upgrade->tohome  = '返迴首頁';

$lang->upgrade->backup           = '備份數據';
$lang->upgrade->prepair          = '準備升級';
$lang->upgrade->selectVersion    = '確認升級之前的版本';
$lang->upgrade->confirm          = '確認要執行的SQL語句';
$lang->upgrade->execute          = '確認執行';
$lang->upgrade->next             = '下一步';
$lang->upgrade->updateLicense    = '蟬知 4.0 已更換授權協議至 Z PUBLIC LICENSE(ZPL) 1.2。';

$lang->upgrade->deleteTips   = '需要刪除部分檔案。linux下面命令為：';
$lang->upgrade->deleteDir    = '<code>rm -fr %s</code>';
$lang->upgrade->deleteFile   = '<code>rm %s</code>';
$lang->upgrade->afterDeleted = '<br />刪除以上檔案後刷新！';

$lang->upgrade->backupData = <<<EOT
<pre>
<strong>使用phpMyAdmin或者mysqldump命令備份資料庫。</strong>
<textarea class='autoSelect w-500px red' readonly rows='1' > mysqldump -u %s -p%s %s > chanzhi.sql </textarea>
</pre>
EOT;

$lang->upgrade->createSlidePath = <<<EOT
<div class='alert'> 請創建幻燈片目錄：<b>%s</b> 並開啟該目錄寫權限後繼續。 </div>
EOT;

$lang->upgrade->chmodThemePath = <<<EOT
<div class='alert'> 請開啟<b>%s</b> 目錄寫權限後繼續。 </div>
EOT;

$lang->upgrade->chmodCustomConfig = <<<EOT
<div class='alert'> 請開啟<b>%s</b> 檔案寫權限後繼續 。 </div>
EOT;

$lang->upgrade->versionNote = "務必選擇正確的版本，否則會造成數據丟失。";

include 'version.php';
