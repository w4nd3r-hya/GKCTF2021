<?php if(!defined("RUN_MODE")) die();?>
<?php
$lang->book->common        = '手册';
$lang->book->list          = '手册列表';
$lang->book->articles      = '文档导航';
$lang->book->backtolist    = '返回手册列表';
$lang->book->articleAmount = '%d文章';

$lang->book->admin      = '手册列表';
$lang->book->info       = '手册介绍';
$lang->book->createBook = '添加手册';
$lang->book->create     = '添加';
$lang->book->catalog    = '章节';
$lang->book->edit       = '编辑';
$lang->book->sort       = '排序';
$lang->book->setting    = '设置';
$lang->book->index      = '首页';
$lang->book->more       = '更多';

$lang->book->searchResults     = '搜索结果';
$lang->book->inputArticleTitle = '请输入文章标题';

$lang->book->id          = '编号';
$lang->book->type        = '类型';
$lang->book->status      = '状态';
$lang->book->link        = '链接';
$lang->book->isLink      = '跳转';
$lang->book->parent      = '章节';
$lang->book->author      = '作者';
$lang->book->editor      = '编辑者';
$lang->book->addedDate   = '发布时间';
$lang->book->editedDate  = '编辑时间';
$lang->book->title       = '标题';
$lang->book->keywords    = '关键词';
$lang->book->summary     = '简介';
$lang->book->content     = '内容';
$lang->book->alias       = '别名';
$lang->book->order       = '排序';
$lang->book->views       = '阅读';
$lang->book->files       = '附件';
$lang->book->images      = '图片';
$lang->book->chapterList = '目录';
$lang->book->articleList = '文章';
$lang->book->fullScreen  = '全屏显示';

$lang->book->typeList['book']    = '手册';
$lang->book->typeList['chapter'] = '章节';
$lang->book->typeList['article'] = '文章';

$lang->book->statusList['normal'] = '正常';
$lang->book->statusList['draft']  = '草稿';

$lang->book->chapterTypeList['home'] = '只在首页显示';
$lang->book->chapterTypeList['left'] = '一直显示在左侧';

$lang->book->fullScreenList['1'] = '是';
$lang->book->fullScreenList['0'] = '否';

$lang->book->lblAddedDate = '添加时间：<strong>%s</strong> ';
$lang->book->lblAuthor    = '作者：<strong>%s</strong> ';
$lang->book->lblViews     = '阅读：<strong>%s</strong> ';
$lang->book->lblEditor    = '最后编辑：%s 于 %s ';

$lang->book->none     = '没有了';
$lang->book->chapter  = '返回目录';
$lang->book->back2Top = '返回顶部';
$lang->book->goHome   = '返回首页';

$lang->book->aliasRepeat   = '别名: %s 不能重复添加。';
$lang->book->confirmDelete = "<span class='text-danger'>此操作将删除该手册所有章节和文章，确认删除?</span>";

$lang->book->note = new stdclass();
$lang->book->note->addedDate = '可以延迟到选定的时间发布。';
$lang->book->note->link      = '请输入链接，可以是站外链接';
