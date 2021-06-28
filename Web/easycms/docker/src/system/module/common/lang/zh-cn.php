<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The common simplified chinese file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     chanzhiEPS
 * @version     $Id$
 * @link        http://www.zentao.net
 */
/* Common sign setting. */
$lang->colon      = '：';
$lang->prev       = '‹';
$lang->next       = '›';
$lang->equal      = '=';
$lang->percent    = '%';
$lang->laquo      = '&laquo;';
$lang->raquo      = '&raquo;';
$lang->minus      = ' - ';
$lang->dollarSign = '￥';
$lang->divider    = "<span class='divider'>{$lang->raquo}</span> ";
$lang->back2Top   = '返<br/>回<br/>顶<br/>部';
$lang->cancel     = '取消';

/*Language shorthand*/
$lang->cn = '简';
$lang->tw = '繁';
$lang->en = 'EN';

$lang->toBeAdded = '待添加';

$lang->about  = '关于蝉知';
$lang->thanks = '致谢';

/* Lang items for xirang. */
$lang->chanzhiEPS     = '蝉知企业门户系统';
$lang->chanzhiEPSx    = '蝉知';
$lang->agreement      = "已阅读并同意<a href='http://zpl.pub/page/zplv12.html' target='_blank'>《Z PUBLIC LICENSE授权协议1.2》</a>。<span class='text-danger'>未经许可，不得去除、隐藏或遮掩蝉知系统的任何标志及链接。</span>";
$lang->poweredBy      = "<a href='http://www.chanzhi.org/?v=%s' target='_blank' title='%s'>%s</a>";
$lang->poweredByAdmin = "<span id='poweredBy'>由 <a href='http://www.chanzhi.org/?v=%s' target='_blank' title='%s'>蝉知企业门户系统 %s</a> 强力驱动！</span>";
$lang->newVersion     = "提示：蝉知系统已于 <span id='releaseDate'></span> 发布 <span id='version'></span>版本。<a href='' target='_blank' id='upgradeLink'>马上下载</a>";
$lang->execInfo       = "<span id='execInfoBar' class='hide'><span class='text-left'>SQL查询：<b>%s</b> 次<br>内存占用：<b>%s</b><br> PHP 执行时间：<b>%s</b> 秒</span></span>";
$lang->customCssError = "不能生成样式文件，如果您是网站管理员，请到网站后台外观管理重新设置样式文件";
$lang->redirecting    = "<span class='text-muted'><span id='countDown'>3</span>秒后跳转到类目管理页面......</span> <a class='btn-redirec' href='%s'><i class='icon icon-hand-right'></i>立即跳转</a>";
$lang->badrequestTips = "<div><div style='padding:30px; margin:80px auto; width:600px; color:#29a8cd; background:#e5f9ff;'>系统检测到您的行为存在异常，请稍后再试，或者联系管理员：<p>电话：%s</p><p>Email: %s</p></div></div>";

/* Global lang items. */
$lang->home             = '首页';
$lang->siteHome         = '网站首页';
$lang->welcome          = '欢迎您，<strong>%s</strong>！';
$lang->messages         = "<strong><i class='icon-comment-alt'></i> %s</strong>";
$lang->todayIs          = '今天是%s，';
$lang->aboutUs          = '关于我们';
$lang->link             = '友情链接';
$lang->frontHome        = '前台';
$lang->forumHome        = '论坛';
$lang->bookHome         = '手册';
$lang->dashboard        = '用户中心';
$lang->visualEdit       = '可视化编辑';
$lang->editMode         = '编辑模式';
$lang->register         = '注册';
$lang->unbind           = '解除绑定';
$lang->bind             = '绑定账号';
$lang->logout           = '退出';
$lang->login            = '登录';
$lang->account          = '帐号';
$lang->password         = '密码';
$lang->changePassword   = '修改密码';
$lang->setEmail         = "邮箱设置";
$lang->setSecurity      = '密保问题';
$lang->forgotPassword   = '忘记密码?';
$lang->currentPos       = '当前位置';
$lang->categoryMenu     = '分类导航';
$lang->wechatTip        = '微信订阅';
$lang->qrcodeTip        = '移动访问';
$lang->language         = '语言';
$lang->custom           = '自定义';
$lang->productMenu      = '产品';
$lang->history          = '历史记录';
$lang->reverse          = '切换顺序';
$lang->transfer         = '转发';

/* Global action items. */
$lang->reset          = '重置';
$lang->edit           = '编辑';
$lang->copy           = '复制';
$lang->hide           = '隐藏';
$lang->delete         = '删除';
$lang->close          = '关闭';
$lang->save           = '保存';
$lang->confirm        = '确认';
$lang->addToBlacklist = '加黑';
$lang->send           = '发送';
$lang->preview        = '预览';
$lang->goback         = '返回';
$lang->more           = '更多';
$lang->refresh        = '刷新';
$lang->actions        = '操作';
$lang->feature        = '未来';
$lang->year           = '年';
$lang->selectAll      = '全选';
$lang->selectReverse  = '反选';
$lang->loading        = '稍候...';
$lang->sending        = '发送中...';
$lang->saveSuccess    = '保存成功';
$lang->setSuccess     = '设置成功';
$lang->createSuccess  = '创建成功';
$lang->sendSuccess    = '发送成功';
$lang->deleteSuccess  = '删除成功';
$lang->fail           = '失败';
$lang->noResultsMatch = '没有匹配的选项';
$lang->alias          = '搜索引擎优化使用，可使用英文或数字';
$lang->keywordsHolder = '多个关键字中间用逗号隔开';
$lang->autoUpgrade    = '自动升级';
$lang->detail         = '详情';

$lang->setOkFile = <<<EOT
<h5>请按照下面的步骤操作以确认您的管理员身份。</h5>
<p>创建 %s 文件。</p>
EOT;

$lang->color       = '颜色';
$lang->colorTip    = '十六进制颜色值';
$lang->colorPlates = '333333|000000|CA1407|45872B|148D00|F25D03|2286D2|D92958|A63268|04BFAD|D1270A|FF9400|299182|63731A|3D4DBE|7382D9|754FB9|F2E205|B1C502|364245|C05036|8A342A|E0DDA2|B3D465|EEEEEE|FFD0E5|D0FFFD|FFFF84|F4E6AE|E5E5E5|F1F1F1|FFFFFF';

$lang->score = new stdclass();
$lang->score->common = '积分';

$lang->community = new stdclass();
$lang->community->common  = '社区';
$lang->getMobileCodeByApi = '获取手机验证码';
$lang->getEmailCodeByApi  = '获取邮箱验证码';
$lang->checkEmail         = '验证邮箱';
$lang->checkMobile        = '验证手机';
$lang->getUserByApi       = '获取绑定信息';

/* Select lang tip */
$lang->selectLangTip = array();
$lang->selectLangTip['zh-cn'] = '切换到简体中文站点';
$lang->selectLangTip['zh-tw'] = '切换到繁体中文站点';
$lang->selectLangTip['en']    = '切换到英文站点';

/* Items for javascript. */
$lang->js = new stdclass();
$lang->js->confirmDelete    = '您确定要执行删除操作吗？';
$lang->js->deleteing        = '删除中';
$lang->js->doing            = '处理中';
$lang->js->loading          = '加载中';
$lang->js->updating         = '更新中...';
$lang->js->timeout          = '网络超时,请重试';
$lang->js->errorThrown      = '<h4>执行出错：</h4>';
$lang->js->continueShopping = '继续购物';
$lang->js->required         = '必填';
$lang->js->back             = '返回';
$lang->js->continue         = '继续';
$lang->js->bindWechatTip    = '发帖功能设置了绑定微信的限制，请先绑定微信会员。';

/* Contact fields*/
$lang->company = new stdclass();
$lang->company->contactUs = '联系我们';
$lang->company->contacts  = '联系人';
$lang->company->address   = '地址';
$lang->company->phone     = '电话';
$lang->company->email     = 'Email';
$lang->company->fax       = '传真';
$lang->company->qq        = 'QQ';
$lang->company->skype     = 'Skype';
$lang->company->weibo     = '微博';
$lang->company->weixin    = '微信';
$lang->company->wangwang  = '旺旺';
$lang->company->site      = '网址';

/* Sitemap settings. */
$lang->sitemap = new stdclass();
$lang->sitemap->common = '站点地图';

/* The primary navbar */
$lang->groups = new stdclass();
$lang->groups->home     = array('title' => '蝉知', 'link' => 'admin|index|',               'icon' => 'home');
$lang->groups->content  = array('title' => '内容', 'link' => 'article|admin|type=article', 'icon' => 'edit');
$lang->groups->shop     = array('title' => '商城', 'link' => 'order|admin|',               'icon' => 'shopping-cart');
$lang->groups->user     = array('title' => '会员', 'link' => 'user|admin|',                'icon' => 'group');
$lang->groups->promote  = array('title' => '推广', 'link' => 'stat|traffic|',              'icon' => 'volume-up');
$lang->groups->design   = array('title' => '设计', 'link' => 'ui|settemplate|',            'icon' => 'paint-brush');
$lang->groups->open     = array('title' => '平台', 'link' => 'package|browse|',            'icon' => 'cloud');
$lang->groups->setting  = array('title' => '设置', 'link' => 'site|setbasic|',             'icon' => 'cog');

/* The main menus. */
$lang->menu = new stdclass();
$lang->menu->admin      = '首页|admin|index|';
$lang->menu->article    = '文章|article|admin|type=article';
$lang->menu->blog       = '博客|article|admin|type=blog';
$lang->menu->book       = '手册|book|admin|';
$lang->menu->page       = '单页|article|admin|type=page';
$lang->menu->attachment = '附件|file|admin|';

$lang->menu->order        = '订单|order|admin|';
$lang->menu->product      = '产品|product|admin|';
$lang->menu->orderSetting = '设置|product|setting|';

$lang->menu->user         = '会员|user|admin|';
$lang->menu->message      = '反馈|message|admin|';
$lang->menu->forum        = '论坛|forum|admin|';
$lang->menu->thread       = '主题|forum|admin|';
$lang->menu->forumreply   = '回帖|reply|admin|';
$lang->menu->submission   = '投稿|article|admin|type=submission&tab=user';
$lang->menu->wechat       = '微信|wechat|message|mode=replied&replied=0';

$lang->menu->stat    = '统计|stat|traffic|';
$lang->menu->tag     = '关键词|tag|admin|';
$lang->menu->links   = '友情链接|links|admin|';

$lang->menu->ui       = '界面|ui|settemplate|';
$lang->menu->logo     = '标志|ui|setlogo|';
$lang->menu->nav      = '导航|nav|admin|';
$lang->menu->block    = '区块|block|admin|';
$lang->menu->slide    = '幻灯片|slide|admin|';
$lang->menu->others   = "设置|ui|others|";
$lang->menu->effect   = "特效|ui|effect|";
$lang->menu->visual   = "可视化|visual|design|";
$lang->menu->edit     = "编辑模板|ui|edittemplate|";

$lang->menu->site          = '站点|site|setbasic|';
$lang->menu->security      = '安全|site|setsecurity|';
$lang->menu->company       = '公司|company|setbasic|';
$lang->menu->score         = '积分|score|setcounts|';
$lang->menu->interface     = '接口|site|setoauth|';
$lang->menu->wechatSetting = '微信设置|wechat|admin|';
$lang->menu->bear          = '熊掌号|bear|setting|';

$lang->menu->package    = '插件|package|browse|';
$lang->menu->themestore = '主题|ui|themestore|';
$lang->menu->community  = '社区|admin|register|';

/* Menu groups setting. */
$lang->menuGroups = new stdclass();
$lang->menuGroups->mail    = 'interface';
$lang->menuGroups->wechat  = 'wechatSetting';
$lang->menuGroups->group   = 'security';
$lang->menuGroups->tree    = 'article';
$lang->menuGroups->search  = 'site';
$lang->menuGroups->company = 'company';
$lang->menuGroups->score   = 'score';
$lang->menuGroups->guarder = 'security';

$lang->designMenus = new stdclass();
$lang->designMenus->theme     = array('link' => '主题|ui|settemplate|', 'alias' => 'themestore');
$lang->designMenus->block     = array('link' => '区块|block|admin|', 'alias' => 'create');
$lang->designMenus->nav       = array('link' => '导航|nav|admin|');
$lang->designMenus->component = array('link' => '组件|ui|component|', 'alias' => 'effect,browsesource');
$lang->designMenus->senior    = array('link' => '高级|ui|editTemplate|');
$lang->designMenus->others    = array('link' => '设置|ui|others|');

/* Menu of article module. */
$lang->article = new stdclass();
$lang->article->menu = new stdclass();
$lang->article->menu->browse = '文章列表|article|admin|';

/* Menu of blog module. */
$lang->blog = new stdclass();
$lang->blog->menu = new stdclass();
$lang->blog->menu->browse = '博客列表|article|admin|type=blog';

$lang->page = new stdclass();

$lang->express = new stdclass();

$lang->orderSetting = new stdclass();
$lang->orderSetting->menu = new stdclass();
$lang->orderSetting->menu->orderSetting = '设置|product|setting|';
$lang->orderSetting->menu->express      = '快递|tree|browse|type=express';

/* Menu of product module. */
$lang->product = new stdclass();
$lang->product->menu = new stdclass();
$lang->product->menu->browse = array('link' => '所有产品|product|admin|', 'alias' => 'create, edit');

/* Menu of UI module. */
$lang->ui = new stdclass();

/* Menu of theme. */
$lang->theme = new stdclass();
$lang->theme->menu = new stdclass();
$lang->theme->menu->theme   = '主题管理|ui|settemplate|';
$lang->theme->menu->layout  = array('link' => '布局管理|block|pages|', 'alias' => 'setregion');
$lang->theme->menu->custom  = '外观管理|ui|customtheme|';
$lang->theme->menu->code    = '代码管理|ui|setcode|';
$lang->theme->menu->source  = '素材管理|file|browsesource|';

/* Menu of user module. */
$lang->user = new stdclass();

/* Menu of message module. */
$lang->message = new stdclass();

/* Menu of forum module. */
$lang->forum = new stdclass();
$lang->forum->menu = new stdclass();
$lang->forum->menu->browse  = '主题列表|forum|admin|';
$lang->forum->menu->reply   = '回帖列表|reply|admin|';
$lang->forum->menu->tree    = '版块管理|tree|browse|type=forum';
$lang->forum->menu->update  = '更新数据|forum|update|';
$lang->forum->menu->setting = '论坛设置|forum|setting|';

/* Menu of site module. */
$lang->site = new stdclass();
$lang->site->menu = new stdclass();
$lang->site->menu->basic     = '站点设置|site|setbasic|';
$lang->site->menu->langs     = '语言设置|site|setlanguage|';
$lang->site->menu->request   = '地址类型|site|seturltype|';
$lang->site->menu->domain    = '域名设置|site|setdomain|';
$lang->site->menu->cdn       = 'CDN设置|site|setcdn|';
$lang->site->menu->cache     = '缓存设置|site|setcache|';
$lang->site->menu->home      = '首页菜单|site|sethomemenu|';
$lang->site->menu->search    = '全文检索|search|buildindex|';
$lang->site->menu->backup    = '备份还原|backup|index|';
$lang->site->menu->agreement = '注册协议|site|setagreement|';
//$lang->site->menu->api    = 'API|site|setapi|';

/* Menu of company module. */
if(!isset($lang->company)) $lang->company = new stdclass();
$lang->company->menu = new stdclass();
$lang->company->menu->company   = '公司信息|company|setbasic|';
$lang->company->menu->contact   = '联系方式|company|setcontact|';

/* Menu of security module. */
$lang->security = new stdclass();
$lang->security->menu = new stdclass();
$lang->security->menu->basic       = '基本设置|site|setsecurity|';
$lang->security->menu->filter      = '过滤设置|site|setfilter|';
$lang->security->menu->blacklist   = '黑名单管理|guarder|setblacklist|';
$lang->security->menu->whitelist   = '白名单管理|guarder|setwhitelist|';
$lang->security->menu->sensitive   = '敏感词设置|site|setsensitive|';
$lang->security->menu->captcha     = '验证码设置|guarder|setcaptcha|';
$lang->security->menu->upload      = '附件上传|site|setupload|';
$lang->security->menu->admin       = array('link' => '管理员|user|admin|admin=1', 'alias' => 'delete,batchdelete');
$lang->security->menu->group       = array('link' => '分组权限|group|browse|', 'alias' => 'managepriv,managemember');
$lang->security->menu->log         = '登录日志|user|adminlog|';

$lang->interface = new stdclass();
$lang->interface->menu = new stdclass();
$lang->interface->menu->oauth = '开放登录|site|setoauth|';
$lang->interface->menu->mail  = array('link' => '发信设置|mail|admin|', 'alias' => 'detect,edit,save,test');

/* Menu of score module. */
$lang->score->menu = new stdclass();
$lang->score->menu->score     = '积分规则|score|setcounts|';
$lang->score->menu->stateinfo = '积分结算|score|showstateinfo|';

$lang->cart    = new stdclass();
$lang->order   = new stdclass();
$lang->address = new stdclass();

/* Menu of tree module. */
$lang->tree = new stdclass();
$lang->tree->menu = $lang->article->menu;

/* Menu of reply module. */
$lang->reply = new stdclass();
$lang->reply->menu = $lang->forum->menu;

/* Menu of search module. */
$lang->search = new stdclass();
$lang->search->menu   = $lang->site->menu;
$lang->search->common = '搜索';

/* Menu of group module. */
$lang->group = new stdclass();
$lang->group->menu = $lang->security->menu;

/* Menu of package module. */
$lang->package = new stdclass();

/* Menu of stat module. */
$lang->stat = new stdclass();
$lang->stat->menu = new stdclass();
$lang->stat->menu->traffic  = '流量概况|stat|traffic|';
$lang->stat->menu->from     = '来源分类|stat|from|';
$lang->stat->menu->domains  = array('link' => '来路域名|stat|domainlist|', 'alias' => 'domaintrend,domainpage');
$lang->stat->menu->search   = '搜索引擎|stat|search|';
$lang->stat->menu->keywords = '关键词|stat|keywords|';
$lang->stat->menu->client   = '用户终端|stat|client|type=browser';
$lang->stat->menu->page     = '点击排行|stat|page|';
$lang->stat->menu->setStat  = '设置|stat|setting|';

/* Menu of bear module. */
$lang->bear = new stdclass();
$lang->bear->menu = new stdclass;
$lang->bear->menu->setting     = '设置|bear|setting|';
$lang->bear->menu->batchSubmit = '批量提交|bear|batchsubmit|';
$lang->bear->menu->log         = '日志|bear|log|';

/* The error messages. */
$lang->error = new stdclass();
$lang->error->length       = array('<strong>%s</strong>长度错误，应当为<strong>%s</strong>', '<strong>%s</strong>长度应当不超过<strong>%s</strong>，且不小于<strong>%s</strong>。');
$lang->error->reg          = '<strong>%s</strong>不符合格式，应当为:<strong>%s</strong>。';
$lang->error->unique       = '<strong>%s</strong>已经有<strong>%s</strong>这条记录了。';
$lang->error->notempty     = '<strong>%s</strong>不能为空。';
$lang->error->equal        = '<strong>%s</strong>必须为<strong>%s</strong>。';
$lang->error->gt           = "<strong>%s</strong>应当大于<strong>%s</strong>。";
$lang->error->ge           = "<strong>%s</strong>应当不小于<strong>%s</strong>。";
$lang->error->lt           = "<strong>%s</strong>应当小于<strong>%s</strong>。";
$lang->error->le           = "<strong>%s</strong>应当不大于<strong>%s</strong>。";
$lang->error->in           = '<strong>%s</strong>必须为<strong>%s</strong>。';
$lang->error->int          = array('<strong>%s</strong>应当是数字。', '<strong>%s</strong>最小值为%s',  '<strong>%s</strong>应当介于<strong>%s-%s</strong>之间。');
$lang->error->float        = '<strong>%s</strong>应当是数字，可以是小数。';
$lang->error->email        = '<strong>%s</strong>应当为合法的EMAIL。';
$lang->error->phone        = '<strong>%s</strong>应当为合法的电话号码。';
$lang->error->mobile       = '<strong>%s</strong>应当为合法的手机号码。';
$lang->error->URL          = '<strong>%s</strong>应当为合法的URL。';
$lang->error->IP           = '<strong>%s</strong>应当为合法的IP。';
$lang->error->date         = '<strong>%s</strong>应当为合法的日期。';
$lang->error->account      = '<strong>%s</strong>应当为字母和数字的组合，至少三位';
$lang->error->passwordsame = '两次密码应当相等。';
$lang->error->passwordrule = '密码应该符合规则，长度至少为六位，并且不能含有中文字符。';
$lang->error->captcha      = '请输入正确的验证码。';
$lang->error->noWritable   = '%s 可能不可写，请修改权限！';
$lang->error->fingerprint  = '身份认证过期，请重试！';
$lang->error->token        = '必须为英文或数字，长度为3-32字符！';
$lang->error->sensitive    = '内容中不能存在敏感词!';
$lang->error->noRepeat     = '主题或内容已存在，禁止重复';
$lang->error->between      = '<strong>%s</strong>必须在<strong>%s</strong>之中。';
$lang->error->idcard       = '<strong>%s</strong>应当为合法的身份证号。';

/* The pager items. */
$lang->pager = new stdclass();
$lang->pager->noRecord     = "暂时没有记录";
$lang->pager->digest       = "共 <strong>%s</strong> 条记录，%s <strong>%s/%s</strong> &nbsp; ";
$lang->pager->recPerPage   = "每页 <strong>%s</strong> 条";
$lang->pager->first        = "<i class='icon-step-backward' title='首页'></i>";
$lang->pager->pre          = "<i class='icon icon-play icon-rotate-180' title='上一页'></i>";
$lang->pager->next         = "<i class='icon-play' title='下一页'></i>";
$lang->pager->last         = "<i class='icon-step-forward' title='末页'></i>";
$lang->pager->locate       = "GO!";
$lang->pager->previousPage = "上一页";
$lang->pager->nextPage     = "下一页";
$lang->pager->summery      = "第 <strong>%s-%s</strong> 项，共 <strong>%s</strong> 项";

/* The date unit*/
$lang->date = new stdclass();
$lang->date->minute       = '分钟';
$lang->date->day          = '天';
$lang->date->oneMinuteAgo = '1分钟前';
$lang->date->minutesAgo   = '分钟前';
$lang->date->oneHourAgo   = '1小时前';
$lang->date->hoursAgo     = '小时前';

/* The datetime settings. */
if(!defined('DT_DATETIME1'))  define('DT_DATETIME1',  'Y-m-d H:i:s');
if(!defined('DT_DATETIME2'))  define('DT_DATETIME2',  'y-m-d H:i');
if(!defined('DT_MONTHTIME1')) define('DT_MONTHTIME1', 'n/d H:i');
if(!defined('DT_MONTHTIME2')) define('DT_MONTHTIME2', 'n月d日 H:i');
if(!defined('DT_DATE1'))      define('DT_DATE1',     'Y年m月d日');
if(!defined('DT_DATE2'))      define('DT_DATE2',     'Ymd');
if(!defined('DT_DATE3'))      define('DT_DATE3',     'Y年m月d日');
if(!defined('DT_DATE4'))      define('DT_DATE4',     'Y-m-d');
if(!defined('DT_TIME1'))      define('DT_TIME1',     'H:i:s');
if(!defined('DT_TIME2'))      define('DT_TIME2',     'H:i');

/* Keywords for chanzhi. */
$lang->k  = '开源 cms — 首选蝉知建站系统;';
$lang->k .= '蝉知建站系统，开源免费的CMS系统;';
$lang->k .= 'cms系统，首选蝉知cms;';
$lang->k .= '企业建站，就用蝉知cms;';
$lang->k .= '蝉知企业建站系统，开源免费的php CMS系统';

/* Labels */
$lang->label = new stdclass();
$lang->label->hot    = '热';
$lang->label->latest = '新';
