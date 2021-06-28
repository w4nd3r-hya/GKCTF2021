<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The install module English file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     install
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->install->common  = 'Install';
$lang->install->next    = 'Next';
$lang->install->pre     = 'Back';
$lang->install->reload  = 'Refresh';
$lang->install->error   = 'Error';

$lang->install->start            = 'Install';
$lang->install->keepInstalling   = 'Continue installation';
$lang->install->welcome          = 'Thank you for choosing Zsite, the powerful CMS!';
$lang->install->license          = 'License';
$lang->install->desc             = <<<EOT
<p>With Zsite, you can do</p>
<blockquote>
  <ul>
    <li><strong>Branding</strong>: build official website and promote your brand to the world.</li>
    <li><strong>Marketing</strong>: SEO, Email, Wechat, weibo, etc.</li>
    <li><strong>E-commerce</strong>: product demonstration and online sales.</li>
    <li><strong>CRM</strong>: aftersales support and maintain clients.</li>
  </ul>
</blockquote>
EOT;

$lang->install->newVersion = "Note: Zsite has released <span id='version'></span> on <span id='releaseDate'></span>.<a href='' target='_blank' id='upgradeLink'>Download Now!</a>";

$lang->install->choice     = 'You can choose';
$lang->install->checking   = 'System Checkup';
$lang->install->ok         = 'Pass(√)';
$lang->install->fail       = 'Failed(×)';
$lang->install->loaded     = 'Loaded';
$lang->install->unloaded   = 'Not Loaded';
$lang->install->exists     = 'Directory exists. ';
$lang->install->notExists  = 'Directory does not exist. ';
$lang->install->writable   = 'Directory is writable ';
$lang->install->notWritable= 'Directory is not writable ';
$lang->install->phpINI     = 'PHP .ini file';
$lang->install->checkItem  = 'Item';
$lang->install->current    = 'Config';
$lang->install->result     = 'Result';
$lang->install->action     = 'Modification';

$lang->install->phpVersion = 'PHP version';
$lang->install->phpFail    = 'PHP version >= 5.2';

$lang->install->pdo          = 'PDO';
$lang->install->pdoFail      = 'Change PHP .ini file and load PDO extension.';
$lang->install->pdoMySQL     = 'PDO_MySQL';
$lang->install->pdoMySQLFail = 'Change PHP .ini file and load pdo_mysql extension.';
$lang->install->tmpRoot      = 'Temporary Directory';
$lang->install->dataRoot     = 'Upload Directory';
$lang->install->mkdir        = '<p>"%s" must be created. Command for Linux: <br /> <code>mkdir -p %s</code></p>';
$lang->install->chmod        = '"%s" must be writable. Command for Linux: <br /><code>chmod o=rwx -R %s</code>';

$lang->install->settingDB      = 'Database Settings';
$lang->install->dbHost         = 'Database Host';
$lang->install->dbHostNote     = 'If you have no access to 127.0.0.1, try localhost.';
$lang->install->dbPort         = 'Database Port';
$lang->install->dbUser         = 'Database User';
$lang->install->dbPassword     = 'Database Password';
$lang->install->dbName         = 'Database Name';
$lang->install->dbPrefix       = 'Table Prefix';
$lang->install->createDB       = 'Auto Create Database';
$lang->install->clearDB        = 'Clear data if tables exist.';
$lang->install->importDemoData = 'Import demo data';

$lang->install->errorDBName        = "'.' is not allowed in database name.";
$lang->install->errorConnectDB     = 'Database connection failed. ';
$lang->install->errorCreateDB      = 'Database creation failed.';
$lang->install->errorDBExists      = 'Database exists. Go back and check the "Clear Data", then try it again.';
$lang->install->errorCreateTable   = 'Table creation failed.';

$lang->install->setConfig  = 'Database Config';
$lang->install->key        = 'Key';
$lang->install->value      = 'Value';
$lang->install->saveConfig = 'Save Config';
$lang->install->save2File  = '<span class="red">Configuration file is not writable. </span> Copy the lines above and save it to "<strong> %s </strong>".';
$lang->install->saved2File = 'Configuration files has been saved to " <strong>%s</strong> ". You can modify this file later.';
$lang->install->errorNotSaveConfig = 'Configuration is not saved.';

$lang->install->setAdmin = 'Set Administrator';
$lang->install->account  = 'Account';
$lang->install->password = 'Password';
$lang->install->errorEmptyPassword = 'Password is required!';

$lang->install->success    = "Installed!";
$lang->install->visitAdmin = 'Admin Login';
