<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The block module zh-tw file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->block->common          = '區塊佈局';
$lang->block->id              = '編號';
$lang->block->title           = '名稱';
$lang->block->amount          = '數量';
$lang->block->limit           = '總數量';
$lang->block->recPerRow       = '每行數量';
$lang->block->type            = '類型';
$lang->block->htmlcode        = 'html代碼';
$lang->block->phpcode         = 'php代碼';
$lang->block->content         = '內容';
$lang->block->moreLink        = '更多連結';
$lang->block->page            = '頁面';
$lang->block->regionList      = '區域列表';
$lang->block->select          = '請選擇區塊';
$lang->block->categories      = '分類';
$lang->block->showImage       = '圖文';
$lang->block->showInfo        = '顯示描述';
$lang->block->infoAmount      = '最多顯示';
$lang->block->character       = '字';
$lang->block->maxWidth        = '最大寬度';
$lang->block->showCategory    = '顯示類目';
$lang->block->showBoard       = '顯示版塊';
$lang->block->showTime        = '顯示時間';
$lang->block->showPrice       = '顯示價格';
$lang->block->showViews       = '顯示瀏覽次數';
$lang->block->titleAlign      = '標題對齊方式';
$lang->block->product         = '產品';
$lang->block->slide           = '幻燈片';
$lang->block->titleless       = '無標題';
$lang->block->borderless      = '無邊框';
$lang->block->icon            = '表徵圖';
$lang->block->padding         = '內邊距';
$lang->block->border          = '邊框';
$lang->block->grid            = '寬度';
$lang->block->probability     = '概率';
$lang->block->more            = '更多';
$lang->block->color           = '顏色';
$lang->block->backgroundColor = '背景顏色';
$lang->block->textColor       = '文字顏色';
$lang->block->borderColor     = '邊框顏色';
$lang->block->linkColor       = '連結顏色';
$lang->block->iconColor       = '表徵圖顏色';
$lang->block->heading         = '標題欄';
$lang->block->content         = '內容';
$lang->block->background      = '背景';
$lang->block->custom          = '自定義';
$lang->block->preview         = '樣式預覽';
$lang->block->textExample     = '區塊文字樣式示例，<a href="###">連結示例</a>';
$lang->block->customStyleTip  = '在這裡調整區塊的顏色及背景';
$lang->block->style           = '樣式';
$lang->block->sort            = '排序';
$lang->block->class           = 'css類名';
$lang->block->subRegion       = '子佈局';
$lang->block->currentLayout   = '當前佈局：%s';
$lang->block->renameLayout    = '方案重命名';
$lang->block->planName        = '方案名稱';
$lang->block->saveLayoutAs    = '複製佈局：%s';
$lang->block->defaultPlan     = '預設方案';
$lang->block->image           = '圖片';
$lang->block->uploadImage     = '上傳圖片';
$lang->block->all             = '所有區塊';

$lang->block->layout            = '佈局';
$lang->block->logoPosition      = 'Logo';
$lang->block->navPosition       = '導航';
$lang->block->searchbarPosition = '搜索框';
$lang->block->sloganPosition    = '站點口號';
$lang->block->childBlock        = '子區塊';

$lang->block->header = new stdclass();

$lang->block->header->top         = new stdclass();
$lang->block->header->top->common = '頁眉';
$lang->block->header->top->left   = '左欄';
$lang->block->header->top->center = '中間';
$lang->block->header->top->right  = '右欄';

$lang->block->header->middle         = new stdclass();
$lang->block->header->middle->common = '中間';
$lang->block->header->middle->left   = '左欄';
$lang->block->header->middle->center = '中間';
$lang->block->header->middle->right  = '右欄';

$lang->block->header->bottom         = new stdclass();
$lang->block->header->bottom->common = '下欄';

$lang->block->header->top->leftOptions['']       = '不顯示';
$lang->block->header->top->leftOptions['slogan'] = '站點口號';
$lang->block->header->top->leftOptions['custom'] = '自定義';

$lang->block->header->top->rightOptions['']               = '不顯示';
$lang->block->header->top->rightOptions['login']          = '登錄註冊 + 語言切換';
$lang->block->header->top->rightOptions['search']         = '搜索框';
$lang->block->header->top->rightOptions['loginAndSearch'] = '登錄註冊語言 + 搜索框';
$lang->block->header->top->rightOptions['searchAndLogin'] = '搜索框 + 登錄註冊語言';
$lang->block->header->top->rightOptions['custom']         = '自定義';

$lang->block->header->middle->leftOptions['']     = '不顯示';
$lang->block->header->middle->leftOptions['logo'] = 'Logo';

$lang->block->header->middle->centerOptions['']       = '不顯示';
$lang->block->header->middle->centerOptions['slogan'] = '站點口號';
$lang->block->header->middle->centerOptions['nav']    = '導航';

$lang->block->header->middle->rightOptions['']       = '不顯示';
$lang->block->header->middle->rightOptions['search'] = '搜索框';

$lang->block->header->bottomOptions['']             = '不顯示';
$lang->block->header->bottomOptions['nav']          = '導航';
$lang->block->header->bottomOptions['navAndSearch'] = '導航 + 搜索框';

$lang->block->admin        = "區塊管理";
$lang->block->pages        = "佈局";
$lang->block->add          = "添加";
$lang->block->insertLink   = '插入';
$lang->block->addChild     = "子區塊";
$lang->block->addRandom    = "隨機區塊";
$lang->block->template     = "模板";
$lang->block->create       = '添加區塊';
$lang->block->browseBlocks = '區塊列表';
$lang->block->browseRegion = '佈局設置';
$lang->block->edit         = '編輯區塊';
$lang->block->view         = '查看區塊';
$lang->block->setPage      = '配置頁面';
$lang->block->setregion    = '配置佈局';
$lang->block->resetRegion  = '恢復預設';
$lang->block->switchPlan   = '切換佈局';
$lang->block->cloneLayout  = '佈局另存為';
$lang->block->switchLayout = '切換佈局';
$lang->block->removeLayout = '刪除佈局方案';
$lang->block->planIsUseing = '此方案正在使用，不能刪除';
$lang->block->noInsertTip  = '插入新選項需要刪除原有的選項';

$lang->block->paddingTop    = '上';
$lang->block->paddingBottom = '下';
$lang->block->paddingLeft   = '左';
$lang->block->paddingRight  = '右';

$lang->block->placeholder                         = new stdclass();
$lang->block->placeholder->moreText               = '區塊右上角文字';
$lang->block->placeholder->moreUrl                = '區塊右上角連結地址';
$lang->block->placeholder->padding                = '0';
$lang->block->placeholder->customStyleTip         = '樣式表支持Less語法，可以用#blockID作為id選擇器。';
$lang->block->placeholder->desktopCustomScriptTip = '已包含 jQuery 1.9.0，可以用#blockID作為id選擇器。';
$lang->block->placeholder->mobileCustomScriptTip  = '支持基本的jQuery語法，可以用#blockID作為id選擇器。';
$lang->block->placeholder->class                  = '多個類名之間用空格隔開';
$lang->block->placeholder->reset                  = '是否恢復此頁面的統一佈局設置？';

$lang->block->gridOptions[0]  = '自動';
$lang->block->gridOptions[6]  = '1/2';
$lang->block->gridOptions[4]  = '1/3';
$lang->block->gridOptions[8]  = '2/3';
$lang->block->gridOptions[3]  = '1/4';
$lang->block->gridOptions[9]  = '3/4';
$lang->block->gridOptions[2]  = '1/6';
$lang->block->gridOptions[10] = '5/6';
$lang->block->gridOptions[12] = '100%';

$lang->block->probabilityOptions[1] = '10%';
$lang->block->probabilityOptions[2] = '20%';
$lang->block->probabilityOptions[3] = '30%';
$lang->block->probabilityOptions[4] = '40%';
$lang->block->probabilityOptions[5] = '50%';
$lang->block->probabilityOptions[6] = '60%';
$lang->block->probabilityOptions[7] = '70%';
$lang->block->probabilityOptions[8] = '80%';
$lang->block->probabilityOptions[9] = '90%';

$lang->block->categoryList['custom']  = '自定義';
$lang->block->categoryList['article'] = '內容';
$lang->block->categoryList['product'] = '產品';
$lang->block->categoryList['system']  = '系統';

$lang->block->pageGroupList['system']   = '系統';
$lang->block->pageGroupList['content']  = '內容';
$lang->block->pageGroupList['product']  = '產品';
$lang->block->pageGroupList['feedback'] = '反饋';

$lang->block->imageSizeList['large']  = '大圖';
$lang->block->imageSizeList['middle'] = '中圖';
$lang->block->imageSizeList['small']  = '小圖';

$lang->block->imagePositionList['left']  = '居左';
$lang->block->imagePositionList['right'] = '居右';

$lang->block->category                = new stdclass();
$lang->block->category->showChildren  = '顯示子分類';
$lang->block->category->fromCurrent   = '當前類目開始';
$lang->block->category->initialExpand = '子分類預設展開';

$lang->block->category->showChildrenList[1] = '是';
$lang->block->category->showChildrenList[0] = '否';

$lang->block->category->fromCurrentList[1] = '是';
$lang->block->category->fromCurrentList[0] = '否';

$lang->block->category->initialExpandList[1] = '是';
$lang->block->category->initialExpandList[0] = '否';

$lang->block->category->showCategoryList['abbr'] = '簡稱';
$lang->block->category->showCategoryList['name'] = '全稱';

$lang->block->slideStyle                 = '展示形式';
$lang->block->slideStyleList['carousel'] = '橫向輪播';
$lang->block->slideStyleList['tile']     = '豎向展開';

$lang->block->navTypeList                = new stdclass();
$lang->block->navTypeList->desktop_top   = '桌面';
$lang->block->navTypeList->desktop_blog  = '博客';
$lang->block->navTypeList->mobile_top    = '移動版頂部';
$lang->block->navTypeList->mobile_bottom = '移動版底部';
$lang->block->navTypeList->mobile_blog   = '移動版博客';

$lang->block->book           = new stdclass();
$lang->block->book->showType = '顯示';

$lang->block->book->sortList['order'] = '排序';
$lang->block->book->sortList['time']  = '時間';

$lang->block->book->showTypeList['block'] = '區塊';
$lang->block->book->showTypeList['list']  = '列表';

$lang->block->sideGrid  = '側邊欄寬度';
$lang->block->sideFloat = '側邊欄位置';

$lang->block->alignList           = array();
$lang->block->alignList['left']   = '居左';
$lang->block->alignList['middle'] = '居中';

$lang->block->imageTypeList           = array();
$lang->block->imageTypeList['wechat'] = '微信二維碼';
$lang->block->imageTypeList['custom'] = '自定義圖片';

$lang->block->subscribe                  = new stdclass();
$lang->block->subscribe->fixInNav        = '固定到導航';
$lang->block->subscribe->fixInNavList    = array();
$lang->block->subscribe->fixInNavList[1] = '是';
$lang->block->subscribe->fixInNavList[0] = '否';

