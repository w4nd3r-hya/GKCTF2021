<?php if(!defined("RUN_MODE")) die();?>
<?php
$lang->book->common        = '手冊';
$lang->book->list          = '手冊列表';
$lang->book->articles      = '文檔導航';
$lang->book->backtolist    = '返回手冊列表';
$lang->book->articleAmount = '%d文章';

$lang->book->admin      = '手冊列表';
$lang->book->info       = '手冊介紹';
$lang->book->createBook = '添加手冊';
$lang->book->create     = '添加';
$lang->book->catalog    = '章節';
$lang->book->edit       = '編輯';
$lang->book->sort       = '排序';
$lang->book->setting    = '設置';
$lang->book->index      = '首頁';
$lang->book->more       = '更多';

$lang->book->searchResults     = '搜索結果';
$lang->book->inputArticleTitle = '請輸入文章標題';

$lang->book->id          = '編號';
$lang->book->type        = '類型';
$lang->book->status      = '狀態';
$lang->book->link        = '連結';
$lang->book->isLink      = '跳轉';
$lang->book->parent      = '章節';
$lang->book->author      = '作者';
$lang->book->editor      = '編輯者';
$lang->book->addedDate   = '發佈時間';
$lang->book->editedDate  = '編輯時間';
$lang->book->title       = '標題';
$lang->book->keywords    = '關鍵詞';
$lang->book->summary     = '簡介';
$lang->book->content     = '內容';
$lang->book->alias       = '別名';
$lang->book->order       = '排序';
$lang->book->views       = '閲讀';
$lang->book->files       = '附件';
$lang->book->images      = '圖片';
$lang->book->chapterList = '目錄';
$lang->book->articleList = '文章';
$lang->book->fullScreen  = '全屏顯示';

$lang->book->typeList['book']    = '手冊';
$lang->book->typeList['chapter'] = '章節';
$lang->book->typeList['article'] = '文章';

$lang->book->statusList['normal'] = '正常';
$lang->book->statusList['draft']  = '草稿';

$lang->book->chapterTypeList['home'] = '只在首頁顯示';
$lang->book->chapterTypeList['left'] = '一直顯示在左側';

$lang->book->fullScreenList['1'] = '是';
$lang->book->fullScreenList['0'] = '否';

$lang->book->lblAddedDate = '添加時間：<strong>%s</strong> ';
$lang->book->lblAuthor    = '作者：<strong>%s</strong> ';
$lang->book->lblViews     = '閲讀：<strong>%s</strong> ';
$lang->book->lblEditor    = '最後編輯：%s 于 %s ';

$lang->book->none     = '沒有了';
$lang->book->chapter  = '返回目錄';
$lang->book->back2Top = '返回頂部';
$lang->book->goHome   = '返迴首頁';

$lang->book->aliasRepeat   = '別名: %s 不能重複添加。';
$lang->book->confirmDelete = "<span class='text-danger'>此操作將刪除該手冊所有章節和文章，確認刪除?</span>";

$lang->book->note = new stdclass();
$lang->book->note->addedDate = '可以延遲到選定的時間發佈。';
$lang->book->note->link      = '請輸入連結，可以是站外連結';
