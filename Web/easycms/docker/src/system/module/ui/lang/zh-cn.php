<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The ui module zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ui
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->ui->common = "界面";

$lang->ui->component       = '常用组件';
$lang->ui->clientDesktop   = '桌面';
$lang->ui->clientMobile    = '移动';
$lang->ui->logo            = 'Logo';
$lang->ui->favicon         = '小图标';
$lang->ui->setLogo         = "标志设置";
$lang->ui->setTemplate     = '模板设置';
$lang->ui->manageTemplate  = '模板管理';
$lang->ui->manageTheme     = '主题管理';
$lang->ui->installTemplate = '导入模板';
$lang->ui->exportTheme     = '导出主题';
$lang->ui->addTheme        = '添加主题';
$lang->ui->setTheme        = '主题设置';
$lang->ui->setDevice       = '设备设置';
$lang->ui->setFavicon      = "Favicon设置";
$lang->ui->deleteFavicon   = "不显示Favicon";
$lang->ui->deleteLogo      = "删除Logo";
$lang->ui->others          = "其他设置";
$lang->ui->productView     = "产品点击量";
$lang->ui->viewMode        = "视图模式";
$lang->ui->QRCode          = "移动二维码";
$lang->ui->execInfo        = "运行信息";
$lang->ui->templateName    = "模板";
$lang->ui->currentTheme    = '当前主题';
$lang->ui->internalTheme   = '内置主题';
$lang->ui->uploadPackage   = '上传主题包';
$lang->ui->installTheme    = '导入主题';
$lang->ui->importedBlocks  = '导入区块';
$lang->ui->matchedBlock    = '对应区块';
$lang->ui->createBlock     = '导入新区块';
$lang->ui->useOldBlock     = '使用已有区块';
$lang->ui->themeStore      = '主题市场';
$lang->ui->themeList       = '主题列表';
$lang->ui->help            = "帮助";
$lang->ui->deleteLogo      = "删除Logo";
$lang->ui->setCode         = "代码";
$lang->ui->editTemplate    = "编辑模板";
$lang->ui->installedThemes = "已安装主题";
$lang->ui->enableTheme     = "使用此主题";
$lang->ui->industry        = "行业";
$lang->ui->byIndustry      = "行业筛选";
$lang->ui->offcial         = "官方";
$lang->ui->score           = "积分";
$lang->ui->reset           = "重置为默认";
$lang->ui->themePackage    = "待导入主题包";
$lang->ui->refreshPage     = "刷新页面";
$lang->ui->mobileBottomNav = '移动版底部导航';
$lang->ui->searchTheme     = '搜索已安装主题';

$lang->ui->uploadLogo             = "上传Logo";
$lang->ui->uploadFavicon          = "上传小图标";
$lang->ui->noStyleTag             = "请填写全局CSS样式代码，不需要&lt;style&gt;&lt;/style&gt;标签";
$lang->ui->noJsTag                = "请填写全局JS代码，不需要&lt;script&gt;&lt;/script&gt;标签";
$lang->ui->setLogoFailed          = "设置Logo失败";
$lang->ui->noSelectedFile         = "获取上传图片失败，可能是图片大小超出上传限制";
$lang->ui->notAlloweFileType      = "请选择正确的%s文件";
$lang->ui->suitableLogoSize       = '最佳高度范围：%s，最佳宽度范围：%s';
$lang->ui->faviconHelp            = "请上传.ico图标文件。<a href='%s' target='_blank'>帮助</a>";
$lang->ui->exportedSuccess        = '导出成功';
$lang->ui->deleteThemeSuccess     = '删除主题成功';
$lang->ui->deleteThemeFail        = '删除主题失败';
$lang->ui->fileRequired           = '请选择一个文件';
$lang->ui->importThemeSuccess     = '导入主题成功';
$lang->ui->packagePathUnwriteable = '上传目录：%s 不可写';
$lang->ui->selectSourceImage      = '从素材库选择';
$lang->ui->rebuildThumbs          = '重新生成缩略图';
$lang->ui->packagePathTip         = '请将主题包的zip文件上传至 %s 目录，进行安装。';
$lang->ui->gdHelp                 = '查看安装方式';
$lang->ui->gdTip                  = '蝉知图片水印功能需要安装php-gd扩展才能使用。';
$lang->ui->effectError            = '导入特效失败，请检查您的特效是否正常，查看地址：http://www.chanzhi.org/effect';
$lang->ui->errorGetEffect         = '获取特效失败，可能是网络方面的原因，请检查您的特效是否正常，查看地址：http://www.chanzhi.org/effect';
$lang->ui->deleteFaviconFail      = '删除 %s 失败。';
$lang->ui->lengthOverflow         = '内容长度 %s 字节。请保持长度不超过65535字节，否则会导致部分内容丢失。';

$lang->ui->deviceList = new stdclass();
$lang->ui->deviceList->desktop = "<i class='icon icon-desktop'></i> 桌面";
$lang->ui->deviceList->mobile  = "<i class='icon icon-tablet'></i> 移动";

$lang->ui->productViewList[1] = '显示';
$lang->ui->productViewList[0] = '不显示';

$lang->ui->QRCodeList[1] = '显示';
$lang->ui->QRCodeList[0] = '不显示';

$lang->ui->execInfoOptions['show'] = '显示';
$lang->ui->execInfoOptions['hide'] = '不显示';

$lang->ui->logoList['current'] = '当前主题';
$lang->ui->logoList['all']     = '所有主题';

$lang->ui->deleteThemeList['blue']       = '蓝色';
$lang->ui->deleteThemeList['brightdark'] = '蝉憩';
$lang->ui->deleteThemeList['flat']       = '清泉';
$lang->ui->deleteThemeList['tree']       = '蝉之树';
$lang->ui->deleteThemeList['colorful']   = '缤纷';

$lang->ui->template = new stdclass();
$lang->ui->template->name            = '名称';
$lang->ui->template->code            = '代码';
$lang->ui->template->version         = '版本';
$lang->ui->template->author          = '作者';
$lang->ui->template->charge          = '费用';
$lang->ui->template->chanzhiVersion  = '兼容版本';
$lang->ui->template->desc            = '简介';
$lang->ui->template->theme           = '主题';
$lang->ui->template->license         = '版权';
$lang->ui->template->preview         = '效果图';
$lang->ui->template->availableThemes = '<strong>%s</strong> 款可用主题';
$lang->ui->template->currentTheme    = '正在使用 <strong>%s</strong>';
$lang->ui->template->changeTheme     = '切换主题';
$lang->ui->template->apply           = '应用模板';
$lang->ui->template->current         = '当前模板';
$lang->ui->template->conflicts       = "警告！已有名为<strong> %s </strong> 的模板。";
$lang->ui->template->override        = "覆盖并安装";
$lang->ui->template->reupload        = "重新上传";
$lang->ui->template->installSuccess  = '恭喜，模板上传成功';
$lang->ui->template->manageTemplate  = '设置模板';
$lang->ui->template->manageBlock     = '设置区块';
$lang->ui->template->enable          = '启用';
$lang->ui->template->reload          = '刷新页面';
$lang->ui->template->doInstall       = '确认安装';
$lang->ui->template->info            = '模板信息';
$lang->ui->template->demo            = '演示网址';
$lang->ui->template->qq              = 'QQ';
$lang->ui->template->email           = 'Email';
$lang->ui->template->site            = 'site';

$lang->ui->appearance         = '外观';
$lang->ui->custom             = '自定义';
$lang->ui->themeSaved         = '主题配置已保存';
$lang->ui->unWritable         = "不能生成样式文件，请检查 %s目录的权限";
$lang->ui->codeHolder         = "字母加数字组合成的主题代号";
$lang->ui->unWritableFile     = "不能生成样式文件，请检查 %s文件的权限";
$lang->ui->openMobileTemplate = "确认开启移动模板？";

$lang->ui->blocks2Merge  = "可合并区块";
$lang->ui->blocks2Create = "新创建区块";

$lang->ui->theme = new stdclass();
$lang->ui->theme->reset                                = '重置';
$lang->ui->theme->upgrade                              = '升级';
$lang->ui->theme->installed                            = '已安装';
$lang->ui->theme->online                               = '在线主题';
$lang->ui->theme->default                              = '默认';
$lang->ui->theme->all                                  = '全部';
$lang->ui->theme->noTheme                              = '此分类下没有主题';
$lang->ui->theme->resetTip                             = '确认重置所有外观设置？';
$lang->ui->theme->sizeTip                              = '默认单位为像素，如1px';
$lang->ui->theme->colorTip                             = '如: red 或 #FFF';
$lang->ui->theme->positionTip                          = '如: 100px, 50%, left, top, center';
$lang->ui->theme->backImageTip                         = '图片地址，如: image.jpg';
$lang->ui->theme->extraStyle                           = 'CSS';
$lang->ui->theme->extraScript                          = 'Javascript';
$lang->ui->theme->customStyleTip                       = '样式表支持Less语法。';
$lang->ui->theme->customScriptTip                      = '已包含 jQuery 1.9.0。';

$lang->ui->theme->borderStyleList['none']              = '无边框';
$lang->ui->theme->borderStyleList['solid']             = '实线';
$lang->ui->theme->borderStyleList['dashed']            = '虚线';
$lang->ui->theme->borderStyleList['dotted']            = '点线';
$lang->ui->theme->borderStyleList['double']            = '双线条';

$lang->ui->theme->imageRepeatList['repeat']            = '默认';
$lang->ui->theme->imageRepeatList['repeat']            = '重复';
$lang->ui->theme->imageRepeatList['repeat-x']          = 'X轴重复';
$lang->ui->theme->imageRepeatList['repeat-y']          = 'Y轴重复';
$lang->ui->theme->imageRepeatList['no-repeat']         = '不重复';

$lang->ui->theme->fontWeightList['inherit']            = '默认';
$lang->ui->theme->fontWeightList['normal']             = '正常';
$lang->ui->theme->fontWeightList['bold']               = '加粗';

$lang->ui->theme->fontList['inherit']                  = '默认';
$lang->ui->theme->fontList['SimSun']                   = '宋体';
$lang->ui->theme->fontList['FangSong']                 = '仿宋';
$lang->ui->theme->fontList['SimHei']                   = '黑体';
$lang->ui->theme->fontList['Microsoft YaHei']          = '微软雅黑';
$lang->ui->theme->fontList['Arial']                    = 'Arial';
$lang->ui->theme->fontList['Courier']                  = 'Courier';
$lang->ui->theme->fontList['Console']                  = 'Console';
$lang->ui->theme->fontList['Tahoma']                   = 'Tahoma';
$lang->ui->theme->fontList['Verdana']                  = 'Verdana';
$lang->ui->theme->fontList['ZenIcon']                  = '图标字体 ZenIcon';

$lang->ui->theme->fontSizeList['inherit']              = '默认';
$lang->ui->theme->fontSizeList['12px']                 = '12px';
$lang->ui->theme->fontSizeList['13px']                 = '13px';
$lang->ui->theme->fontSizeList['14px']                 = '14px';
$lang->ui->theme->fontSizeList['15px']                 = '15px';
$lang->ui->theme->fontSizeList['16px']                 = '16px';
$lang->ui->theme->fontSizeList['18px']                 = '18px';
$lang->ui->theme->fontSizeList['20px']                 = '20px';
$lang->ui->theme->fontSizeList['24px']                 = '24px';

$lang->ui->theme->navbarLayoutList['false']            = '普通';
$lang->ui->theme->navbarLayoutList['true']             = '自适应宽度';

$lang->ui->theme->sideFloatList['right']  = '靠右';
$lang->ui->theme->sideFloatList['left']   = '靠左';
$lang->ui->theme->sideFloatList['hidden'] = '不显示';

$lang->ui->theme->sideGridList[2]        = "1/6";
$lang->ui->theme->sideGridList[3]        = "1/4";
$lang->ui->theme->sideGridList[4]        = "1/3";
$lang->ui->theme->sideGridList[6]        = "1/2";

$lang->ui->theme->underlineList['none']                = '无';
$lang->ui->theme->underlineList['underline']           = '带下划线';

$lang->ui->theme->searchLabels = new stdclass();
$lang->ui->theme->searchLabels->sales  = '购买最多';
$lang->ui->theme->searchLabels->latest = '最新';
$lang->ui->theme->searchLabels->hot    = '最热';
$lang->ui->theme->searchLabels->rand   = '推荐';
$lang->ui->theme->searchLabels->free   = '免费';

$lang->ui->groups = new stdclass();
$lang->ui->groups->basic  = '基本样式';
$lang->ui->groups->navbar = '导航条';
$lang->ui->groups->block  = '区块';
$lang->ui->groups->button = '按钮';
$lang->ui->groups->header = '页眉';
$lang->ui->groups->footer = '页脚';

$lang->ui->color          = '颜色';
$lang->ui->colorset       = '配色';
$lang->ui->pageBackground = '页面背景';
$lang->ui->pageText       = '页面文字';
$lang->ui->aLink          = '普通链接';
$lang->ui->aVisited       = '已访问链接';
$lang->ui->aHover         = '高亮链接';
$lang->ui->underline      = '下划线';
$lang->ui->transparent    = '透明';
$lang->ui->none           = '无';

$lang->ui->layout        = '布局';
$lang->ui->navbar        = '导航条';
$lang->ui->panel         = '子面板';
$lang->ui->menuBorder    = '菜单边框';
$lang->ui->submenuBorder = '子菜单边框';
$lang->ui->menuNormal    = '菜单普通';
$lang->ui->menuHover     = '菜单高亮';
$lang->ui->menuActive    = '菜单选中';
$lang->ui->submenuNormal = '子菜单普通';
$lang->ui->submenuHover  = '子菜单高亮';
$lang->ui->submenuActive = '子菜单选中';
$lang->ui->heading       = '标题';
$lang->ui->body          = '主体';
$lang->ui->background    = '背景';
$lang->ui->button        = '按钮';
$lang->ui->text          = '文字';
$lang->ui->column        = '分栏';
$lang->ui->sideFloat     = '侧边栏布局';
$lang->ui->sideGrid      = '侧边栏宽度';
$lang->ui->height        = '高度';

$lang->ui->primaryColor    = '基色';
$lang->ui->backcolor       = '背景色';
$lang->ui->forecolor       = '前景色';
$lang->ui->backgroundImage = '背景图片';
$lang->ui->repeat          = '重复方式';
$lang->ui->position        = '位置';
$lang->ui->style           = '样式';
$lang->ui->fontSize        = '字号';
$lang->ui->fontFamily      = '字体';
$lang->ui->fontWeight      = '加粗';
$lang->ui->layout          = '布局';
$lang->ui->border          = '边框';
$lang->ui->borderColor     = '边框颜色';
$lang->ui->borderWidth     = '边框宽度';
$lang->ui->width           = '宽度';
$lang->ui->radius          = '圆角';
$lang->ui->linkColor       = '链接颜色';
$lang->ui->linkFontSize    = '链接字号';
$lang->ui->default         = '普通';
$lang->ui->primary         = '主要';
$lang->ui->info            = '信息';
$lang->ui->danger          = '危险';
$lang->ui->warning         = '警告';
$lang->ui->success         = '积极';
$lang->ui->removeDirFaild  = "<h4>以下目录删除失败</h4><pre>%s</pre> <div class='text-important'>请手动删除，或者设置这些文件的可写权限后继续。</div>";
$lang->ui->padding         = '边距';
$lang->ui->left            = '左边距';
$lang->ui->right           = '右边距';
$lang->ui->top             = '上边距';
$lang->ui->bottom          = '下边距';

$lang->ui->importType    = '导入方式';
$lang->js->importTip     = "只导入主题的风格和样式";
$lang->js->fullImportTip = "将会导入测试数据以及替换站点文章、产品等数据";

$lang->ui->importTypes = new stdclass();
$lang->ui->importTypes->theme = '导入样式';
$lang->ui->importTypes->full  = '导入样式和数据';

$lang->ui->theme->encryptTip = new stdclass();
$lang->ui->theme->encryptTip->common    = '提示：';
$lang->ui->theme->encryptTip->zend      = '您导入的主题是zend方式加密的，需要环境安装Zend Guard Loader解密程序，<a href="http://www.chanzhi.org/book/chanzhieps/133.html" target="_blank">Zend Guard Loader安装文档</a> 。';
$lang->ui->theme->encryptTip->ioncube   = '导入的主题是ioncube软件加密的，需要环境安装ioncube扩展，<a href="http://www.chanzhi.org/book/chanzhieps/189.html" target="_blank">ioncube扩展安装文档</a> 。';
$lang->ui->theme->encryptTip->noZend    = '您没有安装Zend Guard Loader解密程序。';
$lang->ui->theme->encryptTip->noIoncube = '您没有安装ioncube扩展。';
$lang->ui->theme->encryptTip->none      = '您还没有安装任何解密程序。';

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
$lang->ui->folderList->common  = '全局文件';
$lang->ui->folderList->index   = '首页';
$lang->ui->folderList->block   = '区块';
$lang->ui->folderList->article = '文章';
$lang->ui->folderList->product = '产品';
$lang->ui->folderList->search  = '搜索';
$lang->ui->folderList->order   = '订单';
$lang->ui->folderList->user    = '会员';
$lang->ui->folderList->message = '评论留言';
$lang->ui->folderList->forum   = '论坛';

$lang->ui->folderAlias = new stdclass();
$lang->ui->folderAlias->blog   = 'article';
$lang->ui->folderAlias->page   = 'article';
$lang->ui->folderAlias->thread = 'forum';
$lang->ui->folderAlias->reply  = 'forum';

$lang->ui->settingList['display']   = '显示设置';
$lang->ui->settingList['browse']    = '列表设置';
$lang->ui->settingList['thumb']     = '缩略图设置';
$lang->ui->settingList['watermark'] = '图片水印';

$lang->ui->files = new stdclass();
$lang->ui->files->default = new stdclass();

$lang->ui->files->default->common = array();
$lang->ui->files->default->common['header.lite']  = 'header';
$lang->ui->files->default->common['header']       = '头部';
$lang->ui->files->default->common['qrcode']       = '二维码';
$lang->ui->files->default->common['footer']       = '页脚';
$lang->ui->files->default->common['header.modal'] = '弹窗页头';
$lang->ui->files->default->common['footer.modal'] = '弹窗底部';

$lang->ui->files->default->index = array();
$lang->ui->files->default->index['index'] = '首页';

$lang->ui->files->default->block = array();
$lang->ui->files->default->block['about']           = '公司简介';
$lang->ui->files->default->block['articletree']     = '文章类目';
$lang->ui->files->default->block['blogtree']        = '博客类目';
$lang->ui->files->default->block['contact']         = '联系我们';
$lang->ui->files->default->block['featuredproduct'] = '推荐产品';
$lang->ui->files->default->block['followus']        = '关注我们';
$lang->ui->files->default->block['header']          = '头部';
$lang->ui->files->default->block['header.default']  = '兼容模式头部';
$lang->ui->files->default->block['header.layout']   = '自定义头部';
$lang->ui->files->default->block['hotarticle']      = '热门文章';
$lang->ui->files->default->block['hotproduct']      = '热门产品';
$lang->ui->files->default->block['htmlcode']        = 'html源码';
$lang->ui->files->default->block['html']            = '自定义';
$lang->ui->files->default->block['latestarticle']   = '最新文章';
$lang->ui->files->default->block['latestblog']      = '最新博客';
$lang->ui->files->default->block['latestproduct']   = '最新产品';
$lang->ui->files->default->block['latestthread']    = '最新帖子';
$lang->ui->files->default->block['links']           = '友情链接';
$lang->ui->files->default->block['logo']            = 'logo区域';
$lang->ui->files->default->block['nav']             = '导航条';
$lang->ui->files->default->block['pagelist']        = '单页列表';
$lang->ui->files->default->block['phpcode']         = 'php源码';
$lang->ui->files->default->block['producttree']     = '产品类目';
$lang->ui->files->default->block['searchbar']       = '搜索条';
$lang->ui->files->default->block['slide']           = '幻灯片';
$lang->ui->files->default->block['slogan']          = '站点口号';
$lang->ui->files->default->block['usermenu']        = '登录信息';

$lang->ui->files->default->article = array();
$lang->ui->files->default->article['browse'] = '文章列表';
$lang->ui->files->default->article['view']   = '文章详情';

$lang->ui->files->default->article['blog/header'] = '博客头部';
$lang->ui->files->default->article['blog/index']  = '博客列表';
$lang->ui->files->default->article['blog/view']   = '博客详情';
$lang->ui->files->default->article['blog/footer'] = '博客底部';

$lang->ui->files->default->article['page/view'] = '单页';

$lang->ui->files->default->blog = array();
$lang->ui->files->default->blog['header'] = '博客头部';
$lang->ui->files->default->blog['index']  = '博客列表';
$lang->ui->files->default->blog['view']   = '博客详情';
$lang->ui->files->default->blog['footer'] = '博客底部';

$lang->ui->files->default->page = array();
$lang->ui->files->default->page['view'] = '单页';

$lang->ui->files->default->product = array();
$lang->ui->files->default->product['browse']      = '产品列表';
$lang->ui->files->default->product['browse.card'] = '卡片视图';
$lang->ui->files->default->product['browse.list'] = '列表视图';
$lang->ui->files->default->product['view']        = '产品详情';

$lang->ui->files->default->forum = array();
$lang->ui->files->default->forum['index'] = '论坛首页';
$lang->ui->files->default->forum['board'] = '板块页面';

$lang->ui->files->default->forum['thread/view']   = '查看帖子';
$lang->ui->files->default->forum['thread/thread'] = '主题展示';
$lang->ui->files->default->forum['thread/reply']  = '回复展示';
$lang->ui->files->default->forum['thread/post']   = '发布主题';
$lang->ui->files->default->forum['reply/reply']   = '回复表单';

$lang->ui->files->default->user['control']     = '会员中心';
$lang->ui->files->default->user['side']        = '菜单区域';
$lang->ui->files->default->user['deny']        = '权限不足';
$lang->ui->files->default->user['edit']        = '账户编辑';
$lang->ui->files->default->user['login.front'] = '登录';
$lang->ui->files->default->user['message']     = '我的消息';
$lang->ui->files->default->user['profile']     = '个人资料';
$lang->ui->files->default->user['register']    = '注册界面';
$lang->ui->files->default->user['score']       = '积分详情';
$lang->ui->files->default->user['thread']      = '我的主题';

$lang->ui->files->default->order['browse']        = '我的订单';
$lang->ui->files->default->order['check']         = '结算页面';
$lang->ui->files->default->order['confirm']       = '订单确认';
$lang->ui->files->default->order['processorder']  = '支付结果';
$lang->ui->files->default->order['track']         = '物流跟踪';

$lang->ui->files->default->message['index']       = '留言页面';
$lang->ui->files->default->message['comment']     = '评论列表';

$lang->ui->files->default->search['index']        = '搜索结果';

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
$lang->effect->category    = '分类';
$lang->effect->name        = '名称';
$lang->effect->account     = '设计师';
$lang->effect->desc        = '描述';
$lang->effect->score       = '积分';
$lang->effect->content     = '代码';
$lang->effect->image       = '效果图';
$lang->effect->package     = '特效包';
$lang->effect->status      = '状态';
$lang->effect->views       = '浏览';
$lang->effect->downloads   = '下载次数';
$lang->effect->createdTime = '创建时间';

$lang->effect->admin         = '特效管理';
$lang->effect->import        = '导入';
$lang->effect->blockName     = '区块名';
$lang->effect->newBlock      = '导入新区块';
$lang->effect->obtan         = '获取特效';
$lang->effect->imported      = '已导入';
$lang->effect->importSuccess = '导入成功';
$lang->effect->noEffect      = "<code>%s</code> 不可写！请检查该目录权限，否则无法导入。";
$lang->effect->noWritable    = "<code>%s</code> 不可写！请检查该目录权限，否则无法导入。";
$lang->effect->bindCommunity = '蝉知特效只对蝉知社区认证用户开放，请先注册并绑定蝉知社区账号后，获取蝉知特效。';
$lang->effect->noRsults      = "你还没有任何特效，请登录蝉知特效平台，<a href='http://www.chanzhi.org/effect.html' target='_blank'>获取特效</a>。";
$lang->effect->redirecting   = "<span class='text-muted'><span id='countDown'>3</span>秒后跳转到社区账号注册/绑定页面......</span> <a class='btn-redirec' href='%s'><i class='icon icon-hand-right'></i>立即跳转</a>";
