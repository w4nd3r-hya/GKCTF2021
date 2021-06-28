<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The site module zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->site->common        = "站点";

$lang->site->type             = '站点类型';
$lang->site->tidy             = '代码美化';
$lang->site->requestType      = '访问类型';
$lang->site->status           = '站点状态';
$lang->site->pauseTip         = '暂停提示';
$lang->site->name             = '网站名称';
$lang->site->module           = '功能模块';
$lang->site->lang             = '站点语言';
$lang->site->defaultLang      = '默认语言';
$lang->site->domain           = '主域名';
$lang->site->allowedDomain    = '可访问域名';
$lang->site->keywords         = '关键词';
$lang->site->indexKeywords    = '首页关键词';
$lang->site->meta             = 'Meta 标签';
$lang->site->desc             = '站点描述';
$lang->site->icpSN            = '备案编号';
$lang->site->icpLink          = '备案链接';
$lang->site->policeSN         = '公安部备案编号';
$lang->site->policeTip        = '公安部备案编号';
$lang->site->policeLink       = '备案链接';
$lang->site->slogan           = '站点口号';
$lang->site->mission          = '站点使命';
$lang->site->copyright        = '创建年份';
$lang->site->allowUpload      = '允许上传附件';
$lang->site->allowedFiles     = '允许附件类型';
$lang->site->setImageSize     = '图片缩略图大小';
$lang->site->captcha          = '前台表单';
$lang->site->mailCaptcha      = '邮箱验证码';
$lang->site->twContent        = '繁体内容';
$lang->site->cn2tw            = '自动从简体版复制';
$lang->site->cdn              = 'CDN地址';
$lang->site->sensitive        = '敏感词';
$lang->site->scheme           = '默认访问协议';
$lang->site->saveDays         = '日志保存天数';
$lang->site->openCache        = '开启缓存';
$lang->site->cachePage        = '缓存整页';
$lang->site->cacheExpired     = '更新时间';
$lang->site->clearCache       = '清除缓存';
$lang->site->clearingCache    = '清除中';
$lang->site->clearedCache     = '清除完毕';
$lang->site->failClear        = '清除失败';
$lang->site->clearCacheTip    = '<td>删除权限不足，请修改<code>%s</code>权限<td>';
$lang->site->hour             = '小时';
$lang->site->homeMenus        = '首页菜单';
$lang->site->agreement        = '注册协议';
$lang->site->agreementTitle   = '协议标题';
$lang->site->agreementContent = '协议内容';

$lang->site->importantOption  = '重要操作';
$lang->site->resetPassword    = '前台找回密码';
$lang->site->checkIP          = '后台登录IP白名单';
$lang->site->checkLocation    = '后台登录地区验证';
$lang->site->checkEmail       = '会员邮箱绑定';
$lang->site->filterFunction   = '过滤功能';
$lang->site->allowedLocation  = '允许登录地区';
$lang->site->checkSessionIP   = '后台检查IP';
$lang->site->setsecurity      = '安全设置';
$lang->site->setsensitive     = '敏感词设置';
$lang->site->filterSensitive  = '敏感词过滤';
$lang->site->setBlacklist     = '黑名单管理';
$lang->site->mobileTemplate   = '移动模板';
$lang->site->gzipOutput       = 'gzip输出';
$lang->site->score            = '积分';
$lang->site->setCounts        = '积分规则';
$lang->site->front            = '网站浏览';
$lang->site->useCDN           = '启用CDN';

$lang->site->setBasic      = "基本信息设置";
$lang->site->setLanguage   = "语言设置";
$lang->site->setUrlType    = "地址类型";
$lang->site->setCache      = '缓存设置';
$lang->site->setCDN        = "CDN设置";
$lang->site->setDomain     = "域名设置";
$lang->site->setLang       = "语言设置";
$lang->site->setFilter     = "过滤设置";
$lang->site->ipFilter      = "ip过滤";
$lang->site->accountFilter = "帐号过滤";
$lang->site->setSecurity   = "安全设置";
$lang->site->setUpload     = "附件上传";
$lang->site->setRobots     = "Robots 设置";
$lang->site->setOauth      = "开放登录";
$lang->site->setSinaOauth  = "新浪微博接入";
$lang->site->setQQOauth    = "QQ接入";
$lang->site->oauthHelp     = "使用帮助";
$lang->site->setRecPerPage = "列表数量设置";
$lang->site->useLocation   = "使用当前登录地址: <span>%s</span>";
$lang->site->changeSetting = "更改设置";
$lang->site->setStat       = "流量统计设置";
$lang->site->setHomeMenu   = "首页菜单";
$lang->site->openModule    = "开启模块";
$lang->site->setAgreement  = "设置注册协议";
$lang->site->isVertified   = "已认证";

$lang->site->typeList = new stdclass();
$lang->site->typeList->portal = '企业门户';
$lang->site->typeList->blog   = '个人博客';

$lang->site->requestTypeList = array();
$lang->site->requestTypeList['PATH_INFO']  = 'PATH_INFO';
$lang->site->requestTypeList['PATH_INFO2'] = 'PATH_INFO2';
$lang->site->requestTypeList['GET']        = 'GET';

$lang->site->statusList = new stdclass();
$lang->site->statusList->normal = '正常';
$lang->site->statusList->pause  = '暂停';

$lang->site->agreementList = array();
$lang->site->agreementList['open']  = '开启';
$lang->site->agreementList['close'] = '关闭';

$lang->site->resetPasswordList = array();
$lang->site->resetPasswordList['open']  = '开启';
$lang->site->resetPasswordList['close'] = '关闭';

$lang->site->tidyOptions = array();
$lang->site->tidyOptions['open']  = '开启';
$lang->site->tidyOptions['close'] = '关闭';

$lang->site->checkIPList = array();
$lang->site->checkIPList['open']  = '开启';
$lang->site->checkIPList['close'] = '关闭';

$lang->site->filterSensitiveList = array();
$lang->site->filterSensitiveList['open']  = '开启';
$lang->site->filterSensitiveList['close'] = '关闭';

$lang->site->checkLocationList = array();
$lang->site->checkLocationList['open']  = '开启';
$lang->site->checkLocationList['close'] = '关闭';

$lang->site->checkEmailList = array();
$lang->site->checkEmailList['open']  = '开启';
$lang->site->checkEmailList['close'] = '关闭';

$lang->site->sensitiveList = array();
$lang->site->sensitiveList['content'] = '内容敏感词';
$lang->site->sensitiveList['user']    = '用户名敏感词';

$lang->site->sessionIpoptions = array();
$lang->site->sessionIpoptions[1] = '检查';
$lang->site->sessionIpoptions[0] = '不检查';

$lang->site->imageSize['s'] = '小图';
$lang->site->imageSize['m'] = '中图';
$lang->site->imageSize['l'] = '大图';

$lang->site->image['width']  = '宽度';
$lang->site->image['height'] = '高度';

$lang->site->captchaList = array();
$lang->site->captchaList['open']  = '一直启用验证码';
$lang->site->captchaList['auto']  = '有敏感内容时自动启用验证码';
$lang->site->captchaList['close'] = '不用验证码';

$lang->site->validateTypes = new stdclass();
$lang->site->validateTypes->okFile      = '文件验证';
$lang->site->validateTypes->email       = '邮件验证码验证';
$lang->site->validateTypes->setSecurity = '密保问题验证';

$lang->site->schemeList = array();
$lang->site->schemeList['http']  = 'http';
$lang->site->schemeList['https'] = 'https';

$lang->site->frontList = array();
$lang->site->frontList['login'] = '需要登录';
$lang->site->frontList['guest'] = '不需要登录';

$lang->site->mobileTemplateList['open']  = '启用';
$lang->site->mobileTemplateList['close'] = '禁用';

$lang->site->gzipOutputList['open']  = '启用';
$lang->site->gzipOutputList['close'] = '禁用';

$lang->site->scoreList['open']  = '启用';
$lang->site->scoreList['close'] = '禁用';

$lang->site->cdnList['open']  = '启用';
$lang->site->cdnList['close'] = '关闭';

$lang->site->cacheTypes['file']  = '启用';
$lang->site->cacheTypes['close'] = '关闭';

$lang->site->cachePageOptions['open']  = '开启';
$lang->site->cachePageOptions['close'] = '关闭';

$lang->site->filterFunctionList['open']  = '启用';
$lang->site->filterFunctionList['close'] = '关闭';

$lang->site->moduleAvailable = new stdclass();
                           
$lang->site->moduleAvailable->content = array();
$lang->site->moduleAvailable->content['article']    = '文章';
$lang->site->moduleAvailable->content['blog']       = '博客';
$lang->site->moduleAvailable->content['page']       = '单页';
$lang->site->moduleAvailable->content['book']       = '手册';
                           
$lang->site->moduleAvailable->user = array();
$lang->site->moduleAvailable->user['user']       = '会员';
$lang->site->moduleAvailable->user['forum']      = '论坛';
$lang->site->moduleAvailable->user['score']      = '积分';
$lang->site->moduleAvailable->user['message']    = '评论留言';
$lang->site->moduleAvailable->user['submission'] = '投稿';

$lang->site->moduleAvailable->mall = array();
$lang->site->moduleAvailable->mall['shop']    = '商城';
$lang->site->moduleAvailable->mall['product'] = '产品';
                           
$lang->site->moduleAvailable->score = array();
$lang->site->moduleAvailable->score['search'] = '搜索';
$lang->site->moduleAvailable->score['stat']   = '统计';

$lang->site->metaHolder       = '可放置<meta><script><style>和<link>标签。';
$lang->site->fileAllowedRole  = '多个后缀名之间请用 "," 隔开';
$lang->site->domainTip        = '所有网站访问跳转到该域名，请确保主域名解析正确，该值为空时不进行跳转。';
$lang->site->allowedDomainTip = "只允许填写的域名访问网站，多个域名用 , 隔开，该值为空时允许所有域名访问。";
$lang->site->allowedIPTip     = '多个IP用 , 隔开，如202.194.133.1,202.194.132.0/28。允许所有IP访问请留空。';
$lang->site->wrongAllowedIP   = 'IP 格式错误';
$lang->site->changeLocation   = '您当前的登录地区与允许登录地区不一致。';
$lang->site->sessionIpTip     = '开启后，如IP变化将自动退出登录。';
$lang->site->schemeTip        = '所有访问会跳转至默认访问协议。';
$lang->site->saveDaysTip      = '访问日志保存天数必须为为 >0 的数字。';
$lang->site->closeScoreTip    = '禁用积分功能后不再记录积分，会员保持原有积分不变。';
$lang->site->cdnFileLost      = '以下资源无法访问：';
$lang->site->useDefaultCdn    = '使用默认地址';
$lang->site->defaultTip       = '站点维护中……';
$lang->site->icpTip           = '仅支持中国大陆网站';
$lang->site->requestTypeTip   = '经检测，您可使用PATH_INFO模式，SEO效果更佳。';
$lang->site->sensitiveTip     = '多个敏感词之间请用英文逗号分隔';

$lang->site->robots            = 'Robots';
$lang->site->robotsUnwriteable = 'Robots文件%s 不可写，请修改权限后设置。';
$lang->site->reloadForRobots   = '刷新页面';

$lang->site->customizableList = new stdclass();
$lang->site->customizableList->article = '文章列表数量';
$lang->site->customizableList->product = '产品列表数量';
$lang->site->customizableList->blog    = '博客列表数量';
$lang->site->customizableList->book    = '手册列表数量';
$lang->site->customizableList->forum   = '论坛列表数量';
$lang->site->customizableList->reply   = '回帖列表数量';
$lang->site->customizableList->message = '留言列表数量';
$lang->site->customizableList->comment = '评论列表数量';

$lang->site->api = new stdclass();
$lang->site->api->common = '集成';
$lang->site->api->key    = '密钥';
$lang->site->api->ip     = 'IP列表';
$lang->site->api->allip  = '无限制';
$lang->site->api->ipTip  = '允许调用者使用这些IP访问，多个IP使用,隔开。支持IP段，如192.168.1.*';

$lang->site->menus = array();
$lang->site->menus['order']      = '订单';
$lang->site->menus['message']    = '留言';
$lang->site->menus['thread']     = '主题';
$lang->site->menus['forumreply'] = '回帖';
$lang->site->menus['article']    = '文章';
$lang->site->menus['page']       = '单页';
$lang->site->menus['blog']       = '博客';
$lang->site->menus['book']       = '手册';
$lang->site->menus['submission'] = '投稿';
$lang->site->menus['product']    = '产品';
$lang->site->menus['user']       = '会员';
$lang->site->menus['wechat']     = '微信';
$lang->site->menus['stat']       = '统计';
$lang->site->menus['tag']        = '关键词';
$lang->site->menus['links']      = '友情链接';
$lang->site->menus['site']       = '站点';
$lang->site->menus['security']   = '安全';

$lang->site->fileAuthority = '需要修改写入文件的权限，Linux下的运行命令为<code>%s</code>';
$lang->site->fileRequired  = '需要创建文件，Linux下的运行命令为<code>%s</code>';

$lang->site->wechatLoginTip = '使用微信登录需要开启PHP的openssl扩展';
$lang->site->noZlib         = '启用gz输出需要开启PHP的zlib扩展';
$lang->site->gzipOn         = 'apache已经安装gzip扩展，无需再启用gzip输出';
