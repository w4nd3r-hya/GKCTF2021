<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The file module zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->file->common        = 'File';
$lang->file->upload        = 'Upload ';
$lang->file->browse        = 'File';
$lang->file->imageList     = 'Image';
$lang->file->download      = 'Download';
$lang->file->edit          = 'Edit';
$lang->file->primary       = 'Cover';
$lang->file->name          = 'Title';
$lang->file->admin         = 'Manage';
$lang->file->setPrimary    = 'Set as Cover';
$lang->file->cancelPrimary = 'Remove Cover';
$lang->file->deny          = 'Disable';
$lang->file->allow         = 'Enable';
$lang->file->toggle        = 'Switch';
$lang->file->label         = 'Title';
$lang->file->lblInfo       = '<i>(Type %s, Size %s, Added on %s，Download %s times)</i>';
$lang->file->limit         = "(<span class='text-danger'> <= %sM</span>)";
$lang->file->source        = 'Source';
$lang->file->sourceList    = 'Source List';
$lang->file->uploadSource  = 'Upload';
$lang->file->sourceURI     = 'URL';
$lang->file->deleteSource  = 'Delete';
$lang->file->editSource    = 'Edit';
$lang->file->selectImage   = 'Select';
$lang->file->fileList      = 'List';
$lang->file->invalidFile   = 'Invalid File';
$lang->file->batchSelect   = 'Batch select';

$lang->file->setWatermark      = 'Set Watermark';
$lang->file->watermark         = 'watermark';
$lang->file->watermarkContent  = 'Text';
$lang->file->watermarkSize     = 'Font Size';
$lang->file->watermarkColor    = 'color';
$lang->file->watermarkOpacity  = 'Opacity';
$lang->file->watermarkPosition = 'Position';
$lang->file->rebuildWatermark  = 'Rebuild Watermarks';
$lang->file->rebuildWatermarks = "Finished %s";

$lang->file->watermarkPositionList = array();
$lang->file->watermarkPositionList['topLeft']      = 'Top Left';
$lang->file->watermarkPositionList['topMiddle']    = 'Top Middle';
$lang->file->watermarkPositionList['topRight']     = 'Top Right';
$lang->file->watermarkPositionList['middleLeft']   = 'Middle ';
$lang->file->watermarkPositionList['middleMiddle'] = 'Right in the Middle';
$lang->file->watermarkPositionList['middleRight']  = 'Middle Right';
$lang->file->watermarkPositionList['bottomLeft']   = 'Bottom Left';
$lang->file->watermarkPositionList['bottomMiddle'] = 'Bottom Middle';
$lang->file->watermarkPositionList['bottomRight']  = 'Bottom Right';

$lang->file->id        = 'ID';
$lang->file->title     = 'Title';
$lang->file->pathname  = 'Path';
$lang->file->extension = 'Type';
$lang->file->size      = 'Size';
$lang->file->addedBy   = 'Uploaded By';
$lang->file->addedDate = 'Uploaded On';
$lang->file->public    = 'Anonymous Download';
$lang->file->downloads = 'Download';
$lang->file->score     = 'Points Required';
$lang->file->setScore  = 'Points Settings';
$lang->file->lblInfo   = 'Your points is <strong class="red">%s</strong>';
$lang->file->confirm   = 'It costs you %s points to download this plug-in.';

$lang->file->publics[0] = 'Please login';
$lang->file->publics[1] = 'Enable';

$lang->file->sort        = 'Sort';
$lang->file->edit        = 'Edit';
$lang->file->editFile    = 'Edit File';
$lang->file->fileManager = 'Manage File';

$lang->file->viewType[0] = 'Image';
$lang->file->viewType[1] = 'List';

$lang->file->errorUnwritable  = 'Uploaded directory is not writable. Uploading failed.';
$lang->file->noAccess         = 'Access is denied.';
$lang->file->invalidParameter = 'Invalid Parameter';
$lang->file->unWritable       = 'The directory is not writable.';
$lang->file->uploadForbidden  = 'Uploading is disabled';
$lang->file->sizeLimit        = "<p class='text-danger'>File size should be <= %sM</p>";
$lang->file->sameName         = "File with the same name has existed. Change failed";
$lang->file->nameEmpty        = "File name should not be blank.";
$lang->file->copySuccess      = "Copy to clipboard";
$lang->file->evilChar         = "Invalid Character";
$lang->file->rebuildThumbs    = "%s has been finished.";
$lang->file->noFlashTip       = "Flash extension is forbidden. Please do the paste manually";
$lang->file->fontNotDownload  = "Download Font faild";
$lang->file->fontPosition     = 'To build watermark requires font file in %s path。';

$lang->file->updateInvalidFiles = 'Update Invalid List';
$lang->file->clearAllInvalid    = 'Delete All Invalid Files';
$lang->file->fileTip            = 'Tips: Red means the file has been deleted with data in database';
$lang->file->productTip         = 'Please upload the images they have the same aspect ratio.';

$lang->file->dragFile      = 'Please drag files here';
$lang->file->addFile       = 'Add';
$lang->file->beginUpload   = 'Upload';

$lang->file->watermarkList = array();
$lang->file->watermarkList['open']  = 'On';
$lang->file->watermarkList['close'] = 'Off';

$lang->file->image = array();
$lang->file->image['width']  = 'Width';
$lang->file->image['height'] = 'Height';
