<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The upgrade module English file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $Id: en.php 5119 2013-07-12 08:06:42Z wyd621@gmail.com $
 * @link        http://www.chanzhi.org
 */
$lang->upgrade->common  = 'Upgrade';

$lang->upgrade->result  = 'Backup Result';
$lang->upgrade->fail    = 'Backup failed!';
$lang->upgrade->success = 'Backed up!';
$lang->upgrade->tohome  = 'Back to Home';

$lang->upgrade->backup        = 'Data Backup';
$lang->upgrade->prepair       = 'Prepare to upgrade';
$lang->upgrade->selectVersion = 'Confirm current version';
$lang->upgrade->confirm       = 'Confirm SQL statement';
$lang->upgrade->execute       = 'Confirm';
$lang->upgrade->next          = 'Next';
$lang->upgrade->updateLicense = 'Zsite 4.0 has swtiched to Z PUBLIC LICENSE(ZPL) 1.2.';

$lang->upgrade->deleteTips   = 'Delete files. The commands in Linux are:<br />';
$lang->upgrade->deleteDir    = '<code>rm -fr %s</code>';
$lang->upgrade->deleteFile   = '<code>rm %s</code>';
$lang->upgrade->afterDeleted = '<br />Refresh after delete.';

$lang->upgrade->backupData = <<<EOT
<pre>
<strong>Use phpMyAdminor mysqldump to backup database.</strong>
<textarea class='autoSelect w-500px red' readonly rows='1' > mysqldump -u %s -p%s %s > chanzhi.sql </textarea>
</pre>
EOT;

$lang->upgrade->createSlidePath = <<<EOT
<div class='alert'> Please create a silde directory <b>%s</b> and turn on the permission to write in this directory. </div>
EOT;

$lang->upgrade->chmodThemePath = <<<EOT
<div class='alert'> Please turn on the wirte permission of <b>%s</b> and continuee. </div>
EOT;

$lang->upgrade->chmodCustomConfig = <<<EOT
<div class='alert'> Please turn on the wirte permission of <b>%s</b> and continuee. </div>
EOT;

$lang->upgrade->versionNote = " Please choose the right version, or it might cause data loss.";

include 'version.php';
