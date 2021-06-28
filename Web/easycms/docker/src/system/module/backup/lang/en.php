<?php if(!defined("RUN_MODE")) die();?>
<?php
$lang->backup->common   = 'Backup';
$lang->backup->index    = 'Home';
$lang->backup->history  = 'Bachup History';
$lang->backup->delete   = 'Delete';
$lang->backup->backup   = 'Back Up';
$lang->backup->restore  = 'Restore';
$lang->backup->change   = 'Hold Time';
$lang->backup->changeAB = 'Change';
$lang->backup->note     = 'Note';
$lang->backup->reserve  = 'Reserve Backup';
$lang->backup->reserved = 'Reserved';

$lang->backup->time  = 'Hold Time';
$lang->backup->files = 'Files';
$lang->backup->size  = 'Size';

$lang->backup->waitting       = '<span id="backupType"></span>Processing. Please wait...';
$lang->backup->confirmDelete  = 'Do you want to delete the backup?';
$lang->backup->confirmRestore = 'Do you want to restore the backup?';
$lang->backup->holdDays       = ' back up last %s days';

$lang->backup->success = new stdclass();
$lang->backup->success->backup  = 'Done!';
$lang->backup->success->restore = 'Restored!';

$lang->backup->error = new stdclass();
$lang->backup->error->noWritable     = "<code>%s</code> is not writable! Please check the permission, or it cannot be backed up!";
$lang->backup->error->noDelete       = "%s cannot be deleted. Please update the permission or manually delete it.";
$lang->backup->error->restoreSQL     = "Database restoration failed. Error %s";
$lang->backup->error->restoreFile    = "File restoration failed. Error %s";
$lang->backup->error->backupFile     = "File backup failed. Error %s";
$lang->backup->error->backupTemplate = "Template backup failed. Error %s";

$lang->js->backuping = 'Backing up...';
$lang->js->restoring = 'Restoring...';
