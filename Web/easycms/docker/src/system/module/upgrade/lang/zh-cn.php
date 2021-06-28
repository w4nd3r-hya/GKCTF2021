<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The upgrade module zh-cn file of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     upgrade
 * @version     $$
 * @link        http://www.chanzhi.org
 */
$lang->upgrade->common  = '升级';

$lang->upgrade->result  = '升级结果';
$lang->upgrade->fail    = '升级失败';
$lang->upgrade->success = '升级成功';
$lang->upgrade->tohome  = '返回首页';

$lang->upgrade->backup           = '备份数据';
$lang->upgrade->prepair          = '准备升级';
$lang->upgrade->selectVersion    = '确认升级之前的版本';
$lang->upgrade->confirm          = '确认要执行的SQL语句';
$lang->upgrade->execute          = '确认执行';
$lang->upgrade->next             = '下一步';
$lang->upgrade->updateLicense    = '蝉知 4.0 已更换授权协议至 Z PUBLIC LICENSE(ZPL) 1.2。';

$lang->upgrade->deleteTips   = '需要删除部分文件。linux下面命令为：';
$lang->upgrade->deleteDir    = '<code>rm -fr %s</code>';
$lang->upgrade->deleteFile   = '<code>rm %s</code>';
$lang->upgrade->afterDeleted = '<br />删除以上文件后刷新！';

$lang->upgrade->backupData = <<<EOT
<pre>
<strong>使用phpMyAdmin或者mysqldump命令备份数据库。</strong>
<textarea class='autoSelect w-500px red' readonly rows='1' > mysqldump -u %s -p%s %s > chanzhi.sql </textarea>
</pre>
EOT;

$lang->upgrade->createSlidePath = <<<EOT
<div class='alert'> 请创建幻灯片目录：<b>%s</b> 并开启该目录写权限后继续。 </div>
EOT;

$lang->upgrade->chmodThemePath = <<<EOT
<div class='alert'> 请开启<b>%s</b> 目录写权限后继续。 </div>
EOT;

$lang->upgrade->chmodCustomConfig = <<<EOT
<div class='alert'> 请开启<b>%s</b> 文件写权限后继续 。 </div>
EOT;

$lang->upgrade->versionNote = "务必选择正确的版本，否则会造成数据丢失。";

include 'version.php';
