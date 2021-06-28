<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The block module zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->block->common          = '区块布局';
$lang->block->id              = '编号';
$lang->block->title           = '名称';
$lang->block->amount          = '数量';
$lang->block->limit           = '总数量';
$lang->block->recPerRow       = '每行数量';
$lang->block->type            = '类型';
$lang->block->htmlcode        = 'html代码';
$lang->block->phpcode         = 'php代码';
$lang->block->content         = '内容';
$lang->block->moreLink        = '更多链接';
$lang->block->page            = '页面';
$lang->block->regionList      = '区域列表';
$lang->block->select          = '请选择区块';
$lang->block->categories      = '分类';
$lang->block->showImage       = '图文';
$lang->block->showInfo        = '显示描述';
$lang->block->infoAmount      = '最多显示';
$lang->block->character       = '字';
$lang->block->maxWidth        = '最大宽度';
$lang->block->showCategory    = '显示类目';
$lang->block->showBoard       = '显示版块';
$lang->block->showTime        = '显示时间';
$lang->block->showPrice       = '显示价格';
$lang->block->showViews       = '显示浏览次数';
$lang->block->titleAlign      = '标题对齐方式';
$lang->block->product         = '产品';
$lang->block->slide           = '幻灯片';
$lang->block->titleless       = '无标题';
$lang->block->borderless      = '无边框';
$lang->block->icon            = '图标';
$lang->block->padding         = '内边距';
$lang->block->border          = '边框';
$lang->block->grid            = '宽度';
$lang->block->probability     = '概率';
$lang->block->more            = '更多';
$lang->block->color           = '颜色';
$lang->block->backgroundColor = '背景颜色';
$lang->block->textColor       = '文字颜色';
$lang->block->borderColor     = '边框颜色';
$lang->block->linkColor       = '链接颜色';
$lang->block->iconColor       = '图标颜色';
$lang->block->heading         = '标题栏';
$lang->block->content         = '内容';
$lang->block->background      = '背景';
$lang->block->custom          = '自定义';
$lang->block->preview         = '样式预览';
$lang->block->textExample     = '区块文字样式示例，<a href="###">链接示例</a>';
$lang->block->customStyleTip  = '在这里调整区块的颜色及背景';
$lang->block->style           = '样式';
$lang->block->sort            = '排序';
$lang->block->class           = 'css类名';
$lang->block->subRegion       = '子布局';
$lang->block->currentLayout   = '当前布局：%s';
$lang->block->renameLayout    = '方案重命名';
$lang->block->planName        = '方案名称';
$lang->block->saveLayoutAs    = '复制布局：%s';
$lang->block->defaultPlan     = '默认方案';
$lang->block->image           = '图片';
$lang->block->uploadImage     = '上传图片';
$lang->block->all             = '所有区块';

$lang->block->layout            = '布局';
$lang->block->logoPosition      = 'Logo';
$lang->block->navPosition       = '导航';
$lang->block->searchbarPosition = '搜索框';
$lang->block->sloganPosition    = '站点口号';
$lang->block->childBlock        = '子区块';

$lang->block->header = new stdclass();

$lang->block->header->top         = new stdclass();
$lang->block->header->top->common = '页眉';
$lang->block->header->top->left   = '左栏';
$lang->block->header->top->center = '中间';
$lang->block->header->top->right  = '右栏';

$lang->block->header->middle         = new stdclass();
$lang->block->header->middle->common = '中间';
$lang->block->header->middle->left   = '左栏';
$lang->block->header->middle->center = '中间';
$lang->block->header->middle->right  = '右栏';

$lang->block->header->bottom         = new stdclass();
$lang->block->header->bottom->common = '下栏';

$lang->block->header->top->leftOptions['']       = '不显示';
$lang->block->header->top->leftOptions['slogan'] = '站点口号';
$lang->block->header->top->leftOptions['custom'] = '自定义';

$lang->block->header->top->rightOptions['']               = '不显示';
$lang->block->header->top->rightOptions['login']          = '登录注册 + 语言切换';
$lang->block->header->top->rightOptions['search']         = '搜索框';
$lang->block->header->top->rightOptions['loginAndSearch'] = '登录注册语言 + 搜索框';
$lang->block->header->top->rightOptions['searchAndLogin'] = '搜索框 + 登录注册语言';
$lang->block->header->top->rightOptions['custom']         = '自定义';

$lang->block->header->middle->leftOptions['']     = '不显示';
$lang->block->header->middle->leftOptions['logo'] = 'Logo';

$lang->block->header->middle->centerOptions['']       = '不显示';
$lang->block->header->middle->centerOptions['slogan'] = '站点口号';
$lang->block->header->middle->centerOptions['nav']    = '导航';

$lang->block->header->middle->rightOptions['']       = '不显示';
$lang->block->header->middle->rightOptions['search'] = '搜索框';

$lang->block->header->bottomOptions['']             = '不显示';
$lang->block->header->bottomOptions['nav']          = '导航';
$lang->block->header->bottomOptions['navAndSearch'] = '导航 + 搜索框';

$lang->block->admin        = "区块管理";
$lang->block->pages        = "布局";
$lang->block->add          = "添加";
$lang->block->insertLink   = '插入';
$lang->block->addChild     = "子区块";
$lang->block->addRandom    = "随机区块";
$lang->block->template     = "模板";
$lang->block->create       = '添加区块';
$lang->block->browseBlocks = '区块列表';
$lang->block->browseRegion = '布局设置';
$lang->block->edit         = '编辑区块';
$lang->block->view         = '查看区块';
$lang->block->setPage      = '配置页面';
$lang->block->setregion    = '配置布局';
$lang->block->resetRegion  = '恢复默认';
$lang->block->switchPlan   = '切换布局';
$lang->block->cloneLayout  = '布局另存为';
$lang->block->switchLayout = '切换布局';
$lang->block->removeLayout = '删除布局方案';
$lang->block->planIsUseing = '此方案正在使用，不能删除';
$lang->block->noInsertTip  = '插入新选项需要删除原有的选项';

$lang->block->paddingTop    = '上';
$lang->block->paddingBottom = '下';
$lang->block->paddingLeft   = '左';
$lang->block->paddingRight  = '右';

$lang->block->placeholder                         = new stdclass();
$lang->block->placeholder->moreText               = '区块右上角文字';
$lang->block->placeholder->moreUrl                = '区块右上角链接地址';
$lang->block->placeholder->padding                = '0';
$lang->block->placeholder->customStyleTip         = '样式表支持Less语法，可以用#blockID作为id选择器。';
$lang->block->placeholder->desktopCustomScriptTip = '已包含 jQuery 1.9.0，可以用#blockID作为id选择器。';
$lang->block->placeholder->mobileCustomScriptTip  = '支持基本的jQuery语法，可以用#blockID作为id选择器。';
$lang->block->placeholder->class                  = '多个类名之间用空格隔开';
$lang->block->placeholder->reset                  = '是否恢复此页面的统一布局设置？';

$lang->block->gridOptions[0]  = '自动';
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

$lang->block->categoryList['custom']  = '自定义';
$lang->block->categoryList['article'] = '内容';
$lang->block->categoryList['product'] = '产品';
$lang->block->categoryList['system']  = '系统';

$lang->block->pageGroupList['system']   = '系统';
$lang->block->pageGroupList['content']  = '内容';
$lang->block->pageGroupList['product']  = '产品';
$lang->block->pageGroupList['feedback'] = '反馈';

$lang->block->imageSizeList['large']  = '大图';
$lang->block->imageSizeList['middle'] = '中图';
$lang->block->imageSizeList['small']  = '小图';

$lang->block->imagePositionList['left']  = '居左';
$lang->block->imagePositionList['right'] = '居右';

$lang->block->category                = new stdclass();
$lang->block->category->showChildren  = '显示子分类';
$lang->block->category->fromCurrent   = '当前类目开始';
$lang->block->category->initialExpand = '子分类默认展开';

$lang->block->category->showChildrenList[1] = '是';
$lang->block->category->showChildrenList[0] = '否';

$lang->block->category->fromCurrentList[1] = '是';
$lang->block->category->fromCurrentList[0] = '否';

$lang->block->category->initialExpandList[1] = '是';
$lang->block->category->initialExpandList[0] = '否';

$lang->block->category->showCategoryList['abbr'] = '简称';
$lang->block->category->showCategoryList['name'] = '全称';

$lang->block->slideStyle                 = '展示形式';
$lang->block->slideStyleList['carousel'] = '横向轮播';
$lang->block->slideStyleList['tile']     = '竖向展开';

$lang->block->navTypeList                = new stdclass();
$lang->block->navTypeList->desktop_top   = '桌面';
$lang->block->navTypeList->desktop_blog  = '博客';
$lang->block->navTypeList->mobile_top    = '移动版顶部';
$lang->block->navTypeList->mobile_bottom = '移动版底部';
$lang->block->navTypeList->mobile_blog   = '移动版博客';

$lang->block->book           = new stdclass();
$lang->block->book->showType = '显示';

$lang->block->book->sortList['order'] = '排序';
$lang->block->book->sortList['time']  = '时间';

$lang->block->book->showTypeList['block'] = '区块';
$lang->block->book->showTypeList['list']  = '列表';

$lang->block->sideGrid  = '侧边栏宽度';
$lang->block->sideFloat = '侧边栏位置';

$lang->block->alignList           = array();
$lang->block->alignList['left']   = '居左';
$lang->block->alignList['middle'] = '居中';

$lang->block->imageTypeList           = array();
$lang->block->imageTypeList['wechat'] = '微信二维码';
$lang->block->imageTypeList['custom'] = '自定义图片';

$lang->block->subscribe                  = new stdclass();
$lang->block->subscribe->fixInNav        = '固定到导航';
$lang->block->subscribe->fixInNavList    = array();
$lang->block->subscribe->fixInNavList[1] = '是';
$lang->block->subscribe->fixInNavList[0] = '否';

