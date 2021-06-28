<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The file module zh-tw file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     file
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->file->common        = '附件';
$lang->file->upload        = '上傳附件';
$lang->file->browse        = '附件列表';
$lang->file->imageList     = '圖片列表';
$lang->file->download      = '下載附件';
$lang->file->edit          = '編輯';
$lang->file->primary       = '封面';
$lang->file->name          = '名稱';
$lang->file->admin         = '附件管理';
$lang->file->setPrimary    = '設為封面';
$lang->file->cancelPrimary = '取消封面';
$lang->file->deny          = '禁止';
$lang->file->allow         = '允許';
$lang->file->toggle        = '切換';
$lang->file->label         = '標題：';
$lang->file->lblInfo       = '<i>(類型：%s, 大小：%s, 添加于：%s，下載%s次)</i>';
$lang->file->limit         = "(<span class='text-danger'>%sM以內</span>)";
$lang->file->source        = '素材';
$lang->file->sourceList    = '素材庫';
$lang->file->uploadSource  = '上傳素材';
$lang->file->sourceURI     = '地址';
$lang->file->deleteSource  = '刪除素材';
$lang->file->editSource    = '編輯素材';
$lang->file->selectImage   = '選擇素材';
$lang->file->fileList      = '檔案列表';
$lang->file->invalidFile   = '無效檔案';
$lang->file->batchSelect   = '批量選擇';

$lang->file->setWatermark      = '設置圖片水印';
$lang->file->watermark         = '圖片水印';
$lang->file->watermarkContent  = '內容';
$lang->file->watermarkSize     = '大小';
$lang->file->watermarkColor    = '顏色';
$lang->file->watermarkOpacity  = '透明度';
$lang->file->watermarkPosition = '位置';
$lang->file->rebuildWatermark  = '重新生成圖片水印';
$lang->file->rebuildWatermarks = "已完成 %s";

$lang->file->watermarkPositionList = array();
$lang->file->watermarkPositionList['topLeft']      = '左上';
$lang->file->watermarkPositionList['topMiddle']    = '中上';
$lang->file->watermarkPositionList['topRight']     = '右上';
$lang->file->watermarkPositionList['middleLeft']   = '中左';
$lang->file->watermarkPositionList['middleMiddle'] = '正中';
$lang->file->watermarkPositionList['middleRight']  = '中右';
$lang->file->watermarkPositionList['bottomLeft']   = '左下';
$lang->file->watermarkPositionList['bottomMiddle'] = '中下';
$lang->file->watermarkPositionList['bottomRight']  = '右下';

$lang->file->id        = '編號';
$lang->file->title     = '名稱';
$lang->file->pathname  = '存儲路徑';
$lang->file->extension = '類型';
$lang->file->size      = '大小';
$lang->file->addedBy   = '上傳者';
$lang->file->addedDate = '上傳日期';
$lang->file->public    = '匿名下載';
$lang->file->downloads = '下載次數';
$lang->file->score     = '所需積分';
$lang->file->setScore  = '設置積分';
$lang->file->lblInfo   = '您現在共有積分：<strong class="red">%s</strong>';
$lang->file->confirm   = '下載此插件需要您 %s 積分';

$lang->file->publics[0] = '需要登錄';
$lang->file->publics[1] = '允許';

$lang->file->sort        = '排序';
$lang->file->edit        = '編輯';
$lang->file->editFile    = '更改附件';
$lang->file->fileManager = '檔案管理';

$lang->file->viewType[0] = '圖片';
$lang->file->viewType[1] = '列表';

$lang->file->errorUnwritable  = '上傳目錄不可寫，無法上傳附件。';
$lang->file->noAccess         = '不允許訪問。';
$lang->file->invalidParameter = '參數無效。';
$lang->file->unWritable       = '目錄不可寫或不存在。';
$lang->file->uploadForbidden  = '附件上傳功能已禁用。';
$lang->file->sizeLimit        = "<p class='text-danger'>附件大小不能大於%sM</p>";
$lang->file->sameName         = "已存在同名檔案，更改失敗";
$lang->file->nameEmpty        = "檔案名不能為空";
$lang->file->copySuccess      = "已複製到剪貼板";
$lang->file->evilChar         = "包含非法字元";
$lang->file->rebuildThumbs    = "已完成 %s";
$lang->file->noFlashTip       = "Flash插件被禁用，請手動複製";
$lang->file->fontNotDownload  = "字型檔沒有下載成功";
$lang->file->fontPosition     = '圖片水印功能需要下載字型檔到 %s 目錄。';

$lang->file->updateInvalidFiles = '更新列表';
$lang->file->clearAllInvalid    = '刪除全部';
$lang->file->fileTip            = '提示：紅色代表資料庫中有檔案記錄，但是檔案實際已經被刪除';
$lang->file->productTip         = '請上傳長寬比一致的圖片，保證頁面的美觀';

$lang->file->dragFile    = '請拖拽檔案到此處';
$lang->file->addFile     = '添加檔案';
$lang->file->beginUpload = '開始上傳';

$lang->file->watermarkList = array();
$lang->file->watermarkList['open']  = '開啟';
$lang->file->watermarkList['close'] = '關閉';

$lang->file->image = array();
$lang->file->image['width']  = '寬度';
$lang->file->image['height'] = '高度';
