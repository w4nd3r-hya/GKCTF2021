<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The ui module zh-tw file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ui
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->ui->common = "界面";

$lang->ui->component       = '常用組件';
$lang->ui->clientDesktop   = '桌面';
$lang->ui->clientMobile    = '移動';
$lang->ui->logo            = 'Logo';
$lang->ui->favicon         = '小表徵圖';
$lang->ui->setLogo         = "標誌設置";
$lang->ui->setTemplate     = '模板設置';
$lang->ui->manageTemplate  = '模板管理';
$lang->ui->manageTheme     = '主題管理';
$lang->ui->installTemplate = '導入模板';
$lang->ui->exportTheme     = '導出主題';
$lang->ui->addTheme        = '添加主題';
$lang->ui->setTheme        = '主題設置';
$lang->ui->setDevice       = '設備設置';
$lang->ui->setFavicon      = "Favicon設置";
$lang->ui->deleteFavicon   = "不顯示Favicon";
$lang->ui->deleteLogo      = "刪除Logo";
$lang->ui->others          = "其他設置";
$lang->ui->productView     = "產品點擊量";
$lang->ui->viewMode        = "視圖模式";
$lang->ui->QRCode          = "移動二維碼";
$lang->ui->execInfo        = "運行信息";
$lang->ui->templateName    = "模板";
$lang->ui->currentTheme    = '當前主題';
$lang->ui->internalTheme   = '內置主題';
$lang->ui->uploadPackage   = '上傳主題包';
$lang->ui->installTheme    = '導入主題';
$lang->ui->importedBlocks  = '導入區塊';
$lang->ui->matchedBlock    = '對應區塊';
$lang->ui->createBlock     = '導入新區塊';
$lang->ui->useOldBlock     = '使用已有區塊';
$lang->ui->themeStore      = '主題市場';
$lang->ui->themeList       = '主題列表';
$lang->ui->help            = "幫助";
$lang->ui->deleteLogo      = "刪除Logo";
$lang->ui->setCode         = "代碼";
$lang->ui->editTemplate    = "編輯模板";
$lang->ui->installedThemes = "已安裝主題";
$lang->ui->enableTheme     = "使用此主題";
$lang->ui->industry        = "行業";
$lang->ui->byIndustry      = "行業篩選";
$lang->ui->offcial         = "官方";
$lang->ui->score           = "積分";
$lang->ui->reset           = "重置為預設";
$lang->ui->themePackage    = "待導入主題包";
$lang->ui->refreshPage     = "刷新頁面";
$lang->ui->mobileBottomNav = '移動版底部導航';
$lang->ui->searchTheme     = '搜索已安裝主題';

$lang->ui->uploadLogo             = "上傳Logo";
$lang->ui->uploadFavicon          = "上傳小表徵圖";
$lang->ui->noStyleTag             = "請填寫全局CSS樣式代碼，不需要&lt;style&gt;&lt;/style&gt;標籤";
$lang->ui->noJsTag                = "請填寫全局JS代碼，不需要&lt;script&gt;&lt;/script&gt;標籤";
$lang->ui->setLogoFailed          = "設置Logo失敗";
$lang->ui->noSelectedFile         = "獲取上傳圖片失敗，可能是圖片大小超出上傳限制";
$lang->ui->notAlloweFileType      = "請選擇正確的%s檔案";
$lang->ui->suitableLogoSize       = '最佳高度範圍：%s，最佳寬度範圍：%s';
$lang->ui->faviconHelp            = "請上傳.ico表徵圖檔案。<a href='%s' target='_blank'>幫助</a>";
$lang->ui->exportedSuccess        = '導出成功';
$lang->ui->deleteThemeSuccess     = '刪除主題成功';
$lang->ui->deleteThemeFail        = '刪除主題失敗';
$lang->ui->fileRequired           = '請選擇一個檔案';
$lang->ui->importThemeSuccess     = '導入主題成功';
$lang->ui->packagePathUnwriteable = '上傳目錄：%s 不可寫';
$lang->ui->selectSourceImage      = '從素材庫選擇';
$lang->ui->rebuildThumbs          = '重新生成縮略圖';
$lang->ui->packagePathTip         = '請將主題包的zip檔案上傳至 %s 目錄，進行安裝。';
$lang->ui->gdHelp                 = '查看安裝方式';
$lang->ui->gdTip                  = '蟬知圖片水印功能需要安裝php-gd擴展才能使用。';
$lang->ui->effectError            = '導入特效失敗，請檢查您的特效是否正常，查看地址：http://www.chanzhi.org/effect';
$lang->ui->errorGetEffect         = '獲取特效失敗，可能是網絡方面的原因，請檢查您的特效是否正常，查看地址：http://www.chanzhi.org/effect';
$lang->ui->deleteFaviconFail      = '刪除 %s 失敗。';
$lang->ui->lengthOverflow         = '內容長度 %s 位元組。請保持長度不超過65535位元組，否則會導致部分內容丟失。';

$lang->ui->deviceList = new stdclass();
$lang->ui->deviceList->desktop = "<i class='icon icon-desktop'></i> 桌面";
$lang->ui->deviceList->mobile  = "<i class='icon icon-tablet'></i> 移動";

$lang->ui->productViewList[1] = '顯示';
$lang->ui->productViewList[0] = '不顯示';

$lang->ui->QRCodeList[1] = '顯示';
$lang->ui->QRCodeList[0] = '不顯示';

$lang->ui->execInfoOptions['show'] = '顯示';
$lang->ui->execInfoOptions['hide'] = '不顯示';

$lang->ui->logoList['current'] = '當前主題';
$lang->ui->logoList['all']     = '所有主題';

$lang->ui->deleteThemeList['blue']       = '藍色';
$lang->ui->deleteThemeList['brightdark'] = '蟬憩';
$lang->ui->deleteThemeList['flat']       = '清泉';
$lang->ui->deleteThemeList['tree']       = '蟬之樹';
$lang->ui->deleteThemeList['colorful']   = '繽紛';

$lang->ui->template = new stdclass();
$lang->ui->template->name            = '名稱';
$lang->ui->template->code            = '代碼';
$lang->ui->template->version         = '版本';
$lang->ui->template->author          = '作者';
$lang->ui->template->charge          = '費用';
$lang->ui->template->chanzhiVersion  = '兼容版本';
$lang->ui->template->desc            = '簡介';
$lang->ui->template->theme           = '主題';
$lang->ui->template->license         = '版權';
$lang->ui->template->preview         = '效果圖';
$lang->ui->template->availableThemes = '<strong>%s</strong> 款可用主題';
$lang->ui->template->currentTheme    = '正在使用 <strong>%s</strong>';
$lang->ui->template->changeTheme     = '切換主題';
$lang->ui->template->apply           = '應用模板';
$lang->ui->template->current         = '當前模板';
$lang->ui->template->conflicts       = "警告！已有名為<strong> %s </strong> 的模板。";
$lang->ui->template->override        = "覆蓋並安裝";
$lang->ui->template->reupload        = "重新上傳";
$lang->ui->template->installSuccess  = '恭喜，模板上傳成功';
$lang->ui->template->manageTemplate  = '設置模板';
$lang->ui->template->manageBlock     = '設置區塊';
$lang->ui->template->enable          = '啟用';
$lang->ui->template->reload          = '刷新頁面';
$lang->ui->template->doInstall       = '確認安裝';
$lang->ui->template->info            = '模板信息';
$lang->ui->template->demo            = '演示網址';
$lang->ui->template->qq              = 'QQ';
$lang->ui->template->email           = 'Email';
$lang->ui->template->site            = 'site';

$lang->ui->appearance         = '外觀';
$lang->ui->custom             = '自定義';
$lang->ui->themeSaved         = '主題配置已保存';
$lang->ui->unWritable         = "不能生成樣式檔案，請檢查 %s目錄的權限";
$lang->ui->codeHolder         = "字母加數字組合成的主題代號";
$lang->ui->unWritableFile     = "不能生成樣式檔案，請檢查 %s檔案的權限";
$lang->ui->openMobileTemplate = "確認開啟移動模板？";

$lang->ui->blocks2Merge  = "可合併區塊";
$lang->ui->blocks2Create = "新創建區塊";

$lang->ui->theme = new stdclass();
$lang->ui->theme->reset                                = '重置';
$lang->ui->theme->upgrade                              = '升級';
$lang->ui->theme->installed                            = '已安裝';
$lang->ui->theme->online                               = '在綫主題';
$lang->ui->theme->default                              = '預設';
$lang->ui->theme->all                                  = '全部';
$lang->ui->theme->noTheme                              = '此分類下沒有主題';
$lang->ui->theme->resetTip                             = '確認重置所有外觀設置？';
$lang->ui->theme->sizeTip                              = '預設單位為像素，如1px';
$lang->ui->theme->colorTip                             = '如: red 或 #FFF';
$lang->ui->theme->positionTip                          = '如: 100px, 50%, left, top, center';
$lang->ui->theme->backImageTip                         = '圖片地址，如: image.jpg';
$lang->ui->theme->extraStyle                           = 'CSS';
$lang->ui->theme->extraScript                          = 'Javascript';
$lang->ui->theme->customStyleTip                       = '樣式表支持Less語法。';
$lang->ui->theme->customScriptTip                      = '已包含 jQuery 1.9.0。';

$lang->ui->theme->borderStyleList['none']              = '無邊框';
$lang->ui->theme->borderStyleList['solid']             = '實線';
$lang->ui->theme->borderStyleList['dashed']            = '虛線';
$lang->ui->theme->borderStyleList['dotted']            = '點線';
$lang->ui->theme->borderStyleList['double']            = '雙線條';

$lang->ui->theme->imageRepeatList['repeat']            = '預設';
$lang->ui->theme->imageRepeatList['repeat']            = '重複';
$lang->ui->theme->imageRepeatList['repeat-x']          = 'X軸重複';
$lang->ui->theme->imageRepeatList['repeat-y']          = 'Y軸重複';
$lang->ui->theme->imageRepeatList['no-repeat']         = '不重複';

$lang->ui->theme->fontWeightList['inherit']            = '預設';
$lang->ui->theme->fontWeightList['normal']             = '正常';
$lang->ui->theme->fontWeightList['bold']               = '加粗';

$lang->ui->theme->fontList['inherit']                  = '預設';
$lang->ui->theme->fontList['SimSun']                   = '宋體';
$lang->ui->theme->fontList['FangSong']                 = '仿宋';
$lang->ui->theme->fontList['SimHei']                   = '黑體';
$lang->ui->theme->fontList['Microsoft YaHei']          = '微軟雅黑';
$lang->ui->theme->fontList['Arial']                    = 'Arial';
$lang->ui->theme->fontList['Courier']                  = 'Courier';
$lang->ui->theme->fontList['Console']                  = 'Console';
$lang->ui->theme->fontList['Tahoma']                   = 'Tahoma';
$lang->ui->theme->fontList['Verdana']                  = 'Verdana';
$lang->ui->theme->fontList['ZenIcon']                  = '表徵圖字型 ZenIcon';

$lang->ui->theme->fontSizeList['inherit']              = '預設';
$lang->ui->theme->fontSizeList['12px']                 = '12px';
$lang->ui->theme->fontSizeList['13px']                 = '13px';
$lang->ui->theme->fontSizeList['14px']                 = '14px';
$lang->ui->theme->fontSizeList['15px']                 = '15px';
$lang->ui->theme->fontSizeList['16px']                 = '16px';
$lang->ui->theme->fontSizeList['18px']                 = '18px';
$lang->ui->theme->fontSizeList['20px']                 = '20px';
$lang->ui->theme->fontSizeList['24px']                 = '24px';

$lang->ui->theme->navbarLayoutList['false']            = '普通';
$lang->ui->theme->navbarLayoutList['true']             = '自適應寬度';

$lang->ui->theme->sideFloatList['right']  = '靠右';
$lang->ui->theme->sideFloatList['left']   = '靠左';
$lang->ui->theme->sideFloatList['hidden'] = '不顯示';

$lang->ui->theme->sideGridList[2]        = "1/6";
$lang->ui->theme->sideGridList[3]        = "1/4";
$lang->ui->theme->sideGridList[4]        = "1/3";
$lang->ui->theme->sideGridList[6]        = "1/2";

$lang->ui->theme->underlineList['none']                = '無';
$lang->ui->theme->underlineList['underline']           = '帶下劃線';

$lang->ui->theme->searchLabels = new stdclass();
$lang->ui->theme->searchLabels->sales  = '購買最多';
$lang->ui->theme->searchLabels->latest = '最新';
$lang->ui->theme->searchLabels->hot    = '最熱';
$lang->ui->theme->searchLabels->rand   = '推薦';
$lang->ui->theme->searchLabels->free   = '免費';

$lang->ui->groups = new stdclass();
$lang->ui->groups->basic  = '基本樣式';
$lang->ui->groups->navbar = '導航條';
$lang->ui->groups->block  = '區塊';
$lang->ui->groups->button = '按鈕';
$lang->ui->groups->header = '頁眉';
$lang->ui->groups->footer = '頁腳';

$lang->ui->color          = '顏色';
$lang->ui->colorset       = '配色';
$lang->ui->pageBackground = '頁面背景';
$lang->ui->pageText       = '頁面文字';
$lang->ui->aLink          = '普通連結';
$lang->ui->aVisited       = '已訪問連結';
$lang->ui->aHover         = '高亮連結';
$lang->ui->underline      = '下劃線';
$lang->ui->transparent    = '透明';
$lang->ui->none           = '無';

$lang->ui->layout        = '佈局';
$lang->ui->navbar        = '導航條';
$lang->ui->panel         = '子面板';
$lang->ui->menuBorder    = '菜單邊框';
$lang->ui->submenuBorder = '子菜單邊框';
$lang->ui->menuNormal    = '菜單普通';
$lang->ui->menuHover     = '菜單高亮';
$lang->ui->menuActive    = '菜單選中';
$lang->ui->submenuNormal = '子菜單普通';
$lang->ui->submenuHover  = '子菜單高亮';
$lang->ui->submenuActive = '子菜單選中';
$lang->ui->heading       = '標題';
$lang->ui->body          = '主體';
$lang->ui->background    = '背景';
$lang->ui->button        = '按鈕';
$lang->ui->text          = '文字';
$lang->ui->column        = '分欄';
$lang->ui->sideFloat     = '側邊欄佈局';
$lang->ui->sideGrid      = '側邊欄寬度';
$lang->ui->height        = '高度';

$lang->ui->primaryColor    = '基色';
$lang->ui->backcolor       = '背景色';
$lang->ui->forecolor       = '前景色';
$lang->ui->backgroundImage = '背景圖片';
$lang->ui->repeat          = '重複方式';
$lang->ui->position        = '位置';
$lang->ui->style           = '樣式';
$lang->ui->fontSize        = '字型大小';
$lang->ui->fontFamily      = '字型';
$lang->ui->fontWeight      = '加粗';
$lang->ui->layout          = '佈局';
$lang->ui->border          = '邊框';
$lang->ui->borderColor     = '邊框顏色';
$lang->ui->borderWidth     = '邊框寬度';
$lang->ui->width           = '寬度';
$lang->ui->radius          = '圓角';
$lang->ui->linkColor       = '連結顏色';
$lang->ui->linkFontSize    = '連結字型大小';
$lang->ui->default         = '普通';
$lang->ui->primary         = '主要';
$lang->ui->info            = '信息';
$lang->ui->danger          = '危險';
$lang->ui->warning         = '警告';
$lang->ui->success         = '積極';
$lang->ui->removeDirFaild  = "<h4>以下目錄刪除失敗</h4><pre>%s</pre> <div class='text-important'>請手動刪除，或者設置這些檔案的可寫權限後繼續。</div>";
$lang->ui->padding         = '邊距';
$lang->ui->left            = '左邊距';
$lang->ui->right           = '右邊距';
$lang->ui->top             = '上邊距';
$lang->ui->bottom          = '下邊距';

$lang->ui->importType    = '導入方式';
$lang->js->importTip     = "只導入主題的風格和樣式";
$lang->js->fullImportTip = "將會導入測試數據以及替換站點文章、產品等數據";

$lang->ui->importTypes = new stdclass();
$lang->ui->importTypes->theme = '導入樣式';
$lang->ui->importTypes->full  = '導入樣式和數據';

$lang->ui->theme->encryptTip = new stdclass();
$lang->ui->theme->encryptTip->common    = '提示：';
$lang->ui->theme->encryptTip->zend      = '您導入的主題是zend方式加密的，需要環境安裝Zend Guard Loader解密程序，<a href="http://www.chanzhi.org/book/chanzhieps/133.html" target="_blank">Zend Guard Loader安裝文檔</a> 。';
$lang->ui->theme->encryptTip->ioncube   = '導入的主題是ioncube軟件加密的，需要環境安裝ioncube擴展，<a href="http://www.chanzhi.org/book/chanzhieps/189.html" target="_blank">ioncube擴展安裝文檔</a> 。';
$lang->ui->theme->encryptTip->noZend    = '您沒有安裝Zend Guard Loader解密程序。';
$lang->ui->theme->encryptTip->noIoncube = '您沒有安裝ioncube擴展。';
$lang->ui->theme->encryptTip->none      = '您還沒有安裝任何解密程序。';

$lang->ui->themeColors = array();
$lang->ui->themeColors[] = 'FF2A2A';
$lang->ui->themeColors[] = 'F8F100';
$lang->ui->themeColors[] = '7AE441';
$lang->ui->themeColors[] = '0084FF';
$lang->ui->themeColors[] = 'FF63E8';
$lang->ui->themeColors[] = '964B00';
$lang->ui->themeColors[] = '7F7F7F';
$lang->ui->themeColors[] = '000000';

$lang->ui->folderList = new stdclass();
$lang->ui->folderList->common  = '全局檔案';
$lang->ui->folderList->index   = '首頁';
$lang->ui->folderList->block   = '區塊';
$lang->ui->folderList->article = '文章';
$lang->ui->folderList->product = '產品';
$lang->ui->folderList->search  = '搜索';
$lang->ui->folderList->order   = '訂單';
$lang->ui->folderList->user    = '會員';
$lang->ui->folderList->message = '評論留言';
$lang->ui->folderList->forum   = '論壇';

$lang->ui->folderAlias = new stdclass();
$lang->ui->folderAlias->blog   = 'article';
$lang->ui->folderAlias->page   = 'article';
$lang->ui->folderAlias->thread = 'forum';
$lang->ui->folderAlias->reply  = 'forum';

$lang->ui->settingList['display']   = '顯示設置';
$lang->ui->settingList['browse']    = '列表設置';
$lang->ui->settingList['thumb']     = '縮略圖設置';
$lang->ui->settingList['watermark'] = '圖片水印';

$lang->ui->files = new stdclass();
$lang->ui->files->default = new stdclass();

$lang->ui->files->default->common = array();
$lang->ui->files->default->common['header.lite']  = 'header';
$lang->ui->files->default->common['header']       = '頭部';
$lang->ui->files->default->common['qrcode']       = '二維碼';
$lang->ui->files->default->common['footer']       = '頁腳';
$lang->ui->files->default->common['header.modal'] = '彈窗頁頭';
$lang->ui->files->default->common['footer.modal'] = '彈窗底部';

$lang->ui->files->default->index = array();
$lang->ui->files->default->index['index'] = '首頁';

$lang->ui->files->default->block = array();
$lang->ui->files->default->block['about']           = '公司簡介';
$lang->ui->files->default->block['articletree']     = '文章類目';
$lang->ui->files->default->block['blogtree']        = '博客類目';
$lang->ui->files->default->block['contact']         = '聯繫我們';
$lang->ui->files->default->block['featuredproduct'] = '推薦產品';
$lang->ui->files->default->block['followus']        = '關注我們';
$lang->ui->files->default->block['header']          = '頭部';
$lang->ui->files->default->block['header.default']  = '兼容模式頭部';
$lang->ui->files->default->block['header.layout']   = '自定義頭部';
$lang->ui->files->default->block['hotarticle']      = '熱門文章';
$lang->ui->files->default->block['hotproduct']      = '熱門產品';
$lang->ui->files->default->block['htmlcode']        = 'html源碼';
$lang->ui->files->default->block['html']            = '自定義';
$lang->ui->files->default->block['latestarticle']   = '最新文章';
$lang->ui->files->default->block['latestblog']      = '最新博客';
$lang->ui->files->default->block['latestproduct']   = '最新產品';
$lang->ui->files->default->block['latestthread']    = '最新帖子';
$lang->ui->files->default->block['links']           = '友情連結';
$lang->ui->files->default->block['logo']            = 'logo區域';
$lang->ui->files->default->block['nav']             = '導航條';
$lang->ui->files->default->block['pagelist']        = '單頁列表';
$lang->ui->files->default->block['phpcode']         = 'php源碼';
$lang->ui->files->default->block['producttree']     = '產品類目';
$lang->ui->files->default->block['searchbar']       = '搜索條';
$lang->ui->files->default->block['slide']           = '幻燈片';
$lang->ui->files->default->block['slogan']          = '站點口號';
$lang->ui->files->default->block['usermenu']        = '登錄信息';

$lang->ui->files->default->article = array();
$lang->ui->files->default->article['browse'] = '文章列表';
$lang->ui->files->default->article['view']   = '文章詳情';

$lang->ui->files->default->article['blog/header'] = '博客頭部';
$lang->ui->files->default->article['blog/index']  = '博客列表';
$lang->ui->files->default->article['blog/view']   = '博客詳情';
$lang->ui->files->default->article['blog/footer'] = '博客底部';

$lang->ui->files->default->article['page/view'] = '單頁';

$lang->ui->files->default->blog = array();
$lang->ui->files->default->blog['header'] = '博客頭部';
$lang->ui->files->default->blog['index']  = '博客列表';
$lang->ui->files->default->blog['view']   = '博客詳情';
$lang->ui->files->default->blog['footer'] = '博客底部';

$lang->ui->files->default->page = array();
$lang->ui->files->default->page['view'] = '單頁';

$lang->ui->files->default->product = array();
$lang->ui->files->default->product['browse']      = '產品列表';
$lang->ui->files->default->product['browse.card'] = '卡片視圖';
$lang->ui->files->default->product['browse.list'] = '列表視圖';
$lang->ui->files->default->product['view']        = '產品詳情';

$lang->ui->files->default->forum = array();
$lang->ui->files->default->forum['index'] = '論壇首頁';
$lang->ui->files->default->forum['board'] = '板塊頁面';

$lang->ui->files->default->forum['thread/view']   = '查看帖子';
$lang->ui->files->default->forum['thread/thread'] = '主題展示';
$lang->ui->files->default->forum['thread/reply']  = '回覆展示';
$lang->ui->files->default->forum['thread/post']   = '發佈主題';
$lang->ui->files->default->forum['reply/reply']   = '回覆表單';

$lang->ui->files->default->user['control']     = '會員中心';
$lang->ui->files->default->user['side']        = '菜單區域';
$lang->ui->files->default->user['deny']        = '權限不足';
$lang->ui->files->default->user['edit']        = '賬戶編輯';
$lang->ui->files->default->user['login.front'] = '登錄';
$lang->ui->files->default->user['message']     = '我的消息';
$lang->ui->files->default->user['profile']     = '個人資料';
$lang->ui->files->default->user['register']    = '註冊界面';
$lang->ui->files->default->user['score']       = '積分詳情';
$lang->ui->files->default->user['thread']      = '我的主題';

$lang->ui->files->default->order['browse']        = '我的訂單';
$lang->ui->files->default->order['check']         = '結算頁面';
$lang->ui->files->default->order['confirm']       = '訂單確認';
$lang->ui->files->default->order['processorder']  = '支付結果';
$lang->ui->files->default->order['track']         = '物流跟蹤';

$lang->ui->files->default->message['index']       = '留言頁面';
$lang->ui->files->default->message['comment']     = '評論列表';

$lang->ui->files->default->search['index']        = '搜索結果';

$lang->ui->files->mobile = $lang->ui->files->default;

unset($this->lang->ui->files->mobile->common['qrcode']);
unset($this->lang->ui->files->mobile->common['header.modal']);
unset($this->lang->ui->files->mobile->common['footer.modal']);
unset($this->lang->ui->files->mobile->block['header']);
unset($this->lang->ui->files->mobile->block['header.default']);
unset($this->lang->ui->files->mobile->block['logo']);
unset($this->lang->ui->files->mobile->block['nav']);
unset($this->lang->ui->files->mobile->block['searchbar']);
unset($this->lang->ui->files->mobile->block['slogan']);
unset($this->lang->ui->files->mobile->block['usermenu']);
unset($this->lang->ui->files->mobile->product['browse.card']);
unset($this->lang->ui->files->mobile->product['browse.list']);
unset($this->lang->ui->files->mobile->forum['reply/reply']);

if(!isset($lang->effect)) $lang->effect = new stdclass();

$lang->effect->common      = '特效';
$lang->effect->category    = '分類';
$lang->effect->name        = '名稱';
$lang->effect->account     = '設計師';
$lang->effect->desc        = '描述';
$lang->effect->score       = '積分';
$lang->effect->content     = '代碼';
$lang->effect->image       = '效果圖';
$lang->effect->package     = '特效包';
$lang->effect->status      = '狀態';
$lang->effect->views       = '瀏覽';
$lang->effect->downloads   = '下載次數';
$lang->effect->createdTime = '創建時間';

$lang->effect->admin         = '特效管理';
$lang->effect->import        = '導入';
$lang->effect->blockName     = '區塊名';
$lang->effect->newBlock      = '導入新區塊';
$lang->effect->obtan         = '獲取特效';
$lang->effect->imported      = '已導入';
$lang->effect->importSuccess = '導入成功';
$lang->effect->noEffect      = "<code>%s</code> 不可寫！請檢查該目錄權限，否則無法導入。";
$lang->effect->noWritable    = "<code>%s</code> 不可寫！請檢查該目錄權限，否則無法導入。";
$lang->effect->bindCommunity = '蟬知特效只對蟬知社區認證用戶開放，請先註冊並綁定蟬知社區賬號後，獲取蟬知特效。';
$lang->effect->noRsults      = "你還沒有任何特效，請登錄蟬知特效平台，<a href='http://www.chanzhi.org/effect.html' target='_blank'>獲取特效</a>。";
$lang->effect->redirecting   = "<span class='text-muted'><span id='countDown'>3</span>秒後跳轉到社區賬號註冊/綁定頁面......</span> <a class='btn-redirec' href='%s'><i class='icon icon-hand-right'></i>立即跳轉</a>";
