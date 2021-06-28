<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The package module en file of ChanZhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@xirangit.com>
 * @package     package
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->package->common        = 'Extension';
$lang->package->browse        = 'View Extensions';
$lang->package->install       = 'Install';
$lang->package->installAuto   = 'Auto Install';
$lang->package->installForce  = 'Force Install';
$lang->package->uninstall     = 'Uninstall';
$lang->package->activate      = 'Activate';
$lang->package->deactivate    = 'Disable';
$lang->package->obtain        = 'Get Extensions';
$lang->package->view          = 'Details';
$lang->package->download      = 'Download';
$lang->package->downloadAB    = 'Download';
$lang->package->upload        = 'Local Installed';
$lang->package->erase         = 'Clear';
$lang->package->upgrade       = 'Upgrade';
$lang->package->agreeLicense  = 'I have read and acknowledged the License';
$lang->package->settemplate   = 'Template Settings';
$lang->package->buy           = 'Buy';

$lang->package->structure   = 'Directory Structure';
$lang->package->installed   = 'Installed';
$lang->package->deactivated = 'Deactivated';
$lang->package->available   = 'Available';

$lang->package->id          = 'ID';
$lang->package->name        = 'Title';
$lang->package->code        = 'Plug-in ID';
$lang->package->version     = 'Version';
$lang->package->compatible  = 'Applicable Version';
$lang->package->latest      = '<small>The lasted verion <strong><a href="%s" target="_blank" class="package">%s</a></strong> is compatible with Zsite <a href="http://api.chanzhi.org/goto.php?item=latest" target="_blank" class="alert-link"><strong>%s</strong></a></small>';
$lang->package->author      = 'Author';
$lang->package->license     = 'License';
$lang->package->intro       = 'Details';
$lang->package->abstract    = 'Introduction';
$lang->package->site        = 'Official Website';
$lang->package->addedTime   = 'Added On';
$lang->package->updatedTime = 'Last Updated';
$lang->package->downloads   = 'Download';
$lang->package->public      = 'Public Download';
$lang->package->compatible  = 'Compatibility';
$lang->package->grade       = 'Rate';
$lang->package->depends     = 'Depedent';

$lang->package->publicList[0] = 'Manual Download';
$lang->package->publicList[1] = 'Download';

$lang->package->compatibleList[0] = 'Unknown';
$lang->package->compatibleList[1] = 'Compatible';

$lang->package->byDownloads   = 'Most Downloaded';
$lang->package->byAddedTime   = 'Latest Added';
$lang->package->byUpdatedTime = 'Last Updated';
$lang->package->bySearch      = 'Search';
$lang->package->byCategory    = 'By Category';
$lang->package->byIndustry    = 'By Industry';
$lang->package->byColor       = 'By Theme';

$lang->package->installFailed            = '%s failed. Error is as below';
$lang->package->uninstallFailed          = 'Uninstall is failed. Error is as below';
$lang->package->confirmUninstall         = 'Uninstall a plug-in will delete/modify related database. Do you want to unistal it?';
$lang->package->noticeBackupDB           = 'Please backup your databse before uninstal!';
$lang->package->installFinished          = 'The plug-in is %sed!';
$lang->package->refreshPage              = 'Refresh';
$lang->package->uninstallFinished        = 'Plug-in has been unistalled.';
$lang->package->deactivateFinished       = 'Plug-in has been deactivated.';
$lang->package->activateFinished         = 'Plug-in has been activated.';
$lang->package->eraseFinished            = 'Plug-in has been cleared.';
$lang->package->unremovedFiles           = 'Some files can not be delteted. Please delete it manually.';
$lang->package->executeCommands          = '<h3> Execute the followings to fix the problem,</h3>';
$lang->package->successDownloadedPackage = 'Plug-in is downloaded.';
$lang->package->successUploadedPackage   = 'Plug-in is uploaded.';
$lang->package->successCopiedFiles       = 'File is copied.';
$lang->package->successInstallDB         = 'Database is installed.';
$lang->package->viewInstalled            = 'View installed Extensions.';
$lang->package->viewAvailable            = 'View available Extensions';
$lang->package->viewDeactivated          = 'View deactivated Extensions.';
$lang->package->backDBFile               = 'Relavant plug-in data is backed up to %s ！';

$lang->package->upgradeExt     = 'Upgrade';
$lang->package->installExt     = 'Install';
$lang->package->upgradeVersion = '(%s has been upgraded to %s)';

$lang->package->types = new stdclass();
$lang->package->types->theme     = 'Theme';
$lang->package->types->extension = 'Extensions';
$lang->package->types->ext       = 'Extensions';
$lang->package->types->patch     = 'Patch';

$lang->package->waring = 'Warning';

$lang->package->errorOccurs                  = 'Error ';
$lang->package->errorGetModules              = 'Get Extensions from www.zsite.net failed. Please check your network and refresh.';
$lang->package->errorGetPackages             = 'Get Extensions from www.zsite.net failed. Please check your network, and go to <a href="http://www.zsite.net/extension" target="_blank" class="alert-link">www.zsite.net</a> to manually download Extensions to install.';
$lang->package->errorDownloadPathNotFound    = 'Download path <strong>%s</strong> does not exist. <br />Excute <strong>mkdir -p %s</strong> in Linux to correct it.';
$lang->package->errorDownloadPathNotWritable = 'Download path <strong>%s</strong>is not writable. <br />Excute <strong>sudo chmod 777 %s</strong>in Linux to correct it.';
$lang->package->errorPackageFileExists       = 'A file named <strong>%s</strong> exists in this download path. <a href="%s" class="btn btn-primary loadInModal">Redo %s</a>';
$lang->package->errorDownloadFailed          = 'Download failed. Please try it again. If failed again, please download it manually, and upload it to install.';
$lang->package->errorMd5Checking             = 'Download file is incomplete. Please try it again. If failed again, please download it manually, and upload it to install.';
$lang->package->errorExtracted               = 'Unzip <strong> %s </strong> failed. It could be an invalid zip file. Error info <br />%s';
$lang->package->errorCheckIncompatible       = 'It is not compatible with Zsite. After %sed, it might be inapplicable. <h3>You can <a href="%s" class="loadInModal">force %s</a> or <a href="#" onclick=parent.location.href="%s"> cancel it.</a></h3>';
$lang->package->errorFileConflicted          = 'It is conflicted with <br />%s. <h3>You can <a href="%s">override</a> or <a href="#" onclick=parent.location.href="%s">cancel it.</a></h3>';
$lang->package->errorPackageNotFound         = ' <strong>%s </strong> is not found. It could be auto downloading failure. Please try it again.';
$lang->package->errorTargetPathNotWritable   = 'Path <strong>%s </strong>is not writable.';
$lang->package->errorTargetPathNotExists     = 'Path <strong>%s </strong>does not exist.';
$lang->package->errorInstallDB               = 'Databse statement execution failed. Error info is %s';
$lang->package->errorConflicts               = 'Conflicted with “%s”!';
$lang->package->errorDepends                 = 'Dependent plug-in<br /><br /> %s is not installed or its version is incompatible.';
$lang->package->errorIncompatible            = 'This plug-in is incompatible with Zsite.';
$lang->package->errorUninstallDepends        = '“%s” is dependent on this plug-in. Do not uninstall it.';

/* Add theme items.*/
$lang->theme->common = 'Theme';
