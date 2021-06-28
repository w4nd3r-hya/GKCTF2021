<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The site module zh-tw file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青島易軟天創網絡科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->site->common        = "站點";

$lang->site->type             = '站點類型';
$lang->site->tidy             = '代碼美化';
$lang->site->requestType      = '訪問類型';
$lang->site->status           = '站點狀態';
$lang->site->pauseTip         = '暫停提示';
$lang->site->name             = '網站名稱';
$lang->site->module           = '功能模組';
$lang->site->lang             = '站點語言';
$lang->site->defaultLang      = '預設語言';
$lang->site->domain           = '主域名';
$lang->site->allowedDomain    = '可訪問域名';
$lang->site->keywords         = '關鍵詞';
$lang->site->indexKeywords    = '首頁關鍵詞';
$lang->site->meta             = 'Meta 標籤';
$lang->site->desc             = '站點描述';
$lang->site->icpSN            = '備案編號';
$lang->site->icpLink          = '備案連結';
$lang->site->policeSN         = '公安部備案編號';
$lang->site->policeTip        = '公安部備案編號';
$lang->site->policeLink       = '備案連結';
$lang->site->slogan           = '站點口號';
$lang->site->mission          = '站點使命';
$lang->site->copyright        = '創建年份';
$lang->site->allowUpload      = '允許上傳附件';
$lang->site->allowedFiles     = '允許附件類型';
$lang->site->setImageSize     = '圖片縮略圖大小';
$lang->site->captcha          = '前台表單';
$lang->site->mailCaptcha      = '郵箱驗證碼';
$lang->site->twContent        = '繁體內容';
$lang->site->cn2tw            = '自動從簡體版複製';
$lang->site->cdn              = 'CDN地址';
$lang->site->sensitive        = '敏感詞';
$lang->site->scheme           = '預設訪問協議';
$lang->site->saveDays         = '日誌保存天數';
$lang->site->openCache        = '開啟緩存';
$lang->site->cachePage        = '緩存整頁';
$lang->site->cacheExpired     = '更新時間';
$lang->site->clearCache       = '清除緩存';
$lang->site->clearingCache    = '清除中';
$lang->site->clearedCache     = '清除完畢';
$lang->site->failClear        = '清除失敗';
$lang->site->clearCacheTip    = '<td>刪除權限不足，請修改<code>%s</code>權限<td>';
$lang->site->hour             = '小時';
$lang->site->homeMenus        = '首頁菜單';
$lang->site->agreement        = '註冊協議';
$lang->site->agreementTitle   = '協議標題';
$lang->site->agreementContent = '協議內容';

$lang->site->importantOption  = '重要操作';
$lang->site->resetPassword    = '前台找回密碼';
$lang->site->checkIP          = '後台登錄IP白名單';
$lang->site->checkLocation    = '後台登錄地區驗證';
$lang->site->checkEmail       = '會員郵箱綁定';
$lang->site->filterFunction   = '過濾功能';
$lang->site->allowedLocation  = '允許登錄地區';
$lang->site->checkSessionIP   = '後台檢查IP';
$lang->site->setsecurity      = '安全設置';
$lang->site->setsensitive     = '敏感詞設置';
$lang->site->filterSensitive  = '敏感詞過濾';
$lang->site->setBlacklist     = '黑名單管理';
$lang->site->mobileTemplate   = '移動模板';
$lang->site->gzipOutput       = 'gzip輸出';
$lang->site->score            = '積分';
$lang->site->setCounts        = '積分規則';
$lang->site->front            = '網站瀏覽';
$lang->site->useCDN           = '啟用CDN';

$lang->site->setBasic      = "基本信息設置";
$lang->site->setLanguage   = "語言設置";
$lang->site->setUrlType    = "地址類型";
$lang->site->setCache      = '緩存設置';
$lang->site->setCDN        = "CDN設置";
$lang->site->setDomain     = "域名設置";
$lang->site->setLang       = "語言設置";
$lang->site->setFilter     = "過濾設置";
$lang->site->ipFilter      = "ip過濾";
$lang->site->accountFilter = "帳號過濾";
$lang->site->setSecurity   = "安全設置";
$lang->site->setUpload     = "附件上傳";
$lang->site->setRobots     = "Robots 設置";
$lang->site->setOauth      = "開放登錄";
$lang->site->setSinaOauth  = "新浪微博接入";
$lang->site->setQQOauth    = "QQ接入";
$lang->site->oauthHelp     = "使用幫助";
$lang->site->setRecPerPage = "列表數量設置";
$lang->site->useLocation   = "使用當前登錄地址: <span>%s</span>";
$lang->site->changeSetting = "更改設置";
$lang->site->setStat       = "流量統計設置";
$lang->site->setHomeMenu   = "首頁菜單";
$lang->site->openModule    = "開啟模組";
$lang->site->setAgreement  = "設置註冊協議";
$lang->site->isVertified   = "已認證";

$lang->site->typeList = new stdclass();
$lang->site->typeList->portal = '企業門戶';
$lang->site->typeList->blog   = '個人博客';

$lang->site->requestTypeList = array();
$lang->site->requestTypeList['PATH_INFO']  = 'PATH_INFO';
$lang->site->requestTypeList['PATH_INFO2'] = 'PATH_INFO2';
$lang->site->requestTypeList['GET']        = 'GET';

$lang->site->statusList = new stdclass();
$lang->site->statusList->normal = '正常';
$lang->site->statusList->pause  = '暫停';

$lang->site->agreementList = array();
$lang->site->agreementList['open']  = '開啟';
$lang->site->agreementList['close'] = '關閉';

$lang->site->resetPasswordList = array();
$lang->site->resetPasswordList['open']  = '開啟';
$lang->site->resetPasswordList['close'] = '關閉';

$lang->site->tidyOptions = array();
$lang->site->tidyOptions['open']  = '開啟';
$lang->site->tidyOptions['close'] = '關閉';

$lang->site->checkIPList = array();
$lang->site->checkIPList['open']  = '開啟';
$lang->site->checkIPList['close'] = '關閉';

$lang->site->filterSensitiveList = array();
$lang->site->filterSensitiveList['open']  = '開啟';
$lang->site->filterSensitiveList['close'] = '關閉';

$lang->site->checkLocationList = array();
$lang->site->checkLocationList['open']  = '開啟';
$lang->site->checkLocationList['close'] = '關閉';

$lang->site->checkEmailList = array();
$lang->site->checkEmailList['open']  = '開啟';
$lang->site->checkEmailList['close'] = '關閉';

$lang->site->sensitiveList = array();
$lang->site->sensitiveList['content'] = '內容敏感詞';
$lang->site->sensitiveList['user']    = '用戶名敏感詞';

$lang->site->sessionIpoptions = array();
$lang->site->sessionIpoptions[1] = '檢查';
$lang->site->sessionIpoptions[0] = '不檢查';

$lang->site->imageSize['s'] = '小圖';
$lang->site->imageSize['m'] = '中圖';
$lang->site->imageSize['l'] = '大圖';

$lang->site->image['width']  = '寬度';
$lang->site->image['height'] = '高度';

$lang->site->captchaList = array();
$lang->site->captchaList['open']  = '一直啟用驗證碼';
$lang->site->captchaList['auto']  = '有敏感內容時自動啟用驗證碼';
$lang->site->captchaList['close'] = '不用驗證碼';

$lang->site->validateTypes = new stdclass();
$lang->site->validateTypes->okFile      = '檔案驗證';
$lang->site->validateTypes->email       = '郵件驗證碼驗證';
$lang->site->validateTypes->setSecurity = '密保問題驗證';

$lang->site->schemeList = array();
$lang->site->schemeList['http']  = 'http';
$lang->site->schemeList['https'] = 'https';

$lang->site->frontList = array();
$lang->site->frontList['login'] = '需要登錄';
$lang->site->frontList['guest'] = '不需要登錄';

$lang->site->mobileTemplateList['open']  = '啟用';
$lang->site->mobileTemplateList['close'] = '禁用';

$lang->site->gzipOutputList['open']  = '啟用';
$lang->site->gzipOutputList['close'] = '禁用';

$lang->site->scoreList['open']  = '啟用';
$lang->site->scoreList['close'] = '禁用';

$lang->site->cdnList['open']  = '啟用';
$lang->site->cdnList['close'] = '關閉';

$lang->site->cacheTypes['file']  = '啟用';
$lang->site->cacheTypes['close'] = '關閉';

$lang->site->cachePageOptions['open']  = '開啟';
$lang->site->cachePageOptions['close'] = '關閉';

$lang->site->filterFunctionList['open']  = '啟用';
$lang->site->filterFunctionList['close'] = '關閉';

$lang->site->moduleAvailable = new stdclass();
                           
$lang->site->moduleAvailable->content = array();
$lang->site->moduleAvailable->content['article']    = '文章';
$lang->site->moduleAvailable->content['blog']       = '博客';
$lang->site->moduleAvailable->content['page']       = '單頁';
$lang->site->moduleAvailable->content['book']       = '手冊';
                           
$lang->site->moduleAvailable->user = array();
$lang->site->moduleAvailable->user['user']       = '會員';
$lang->site->moduleAvailable->user['forum']      = '論壇';
$lang->site->moduleAvailable->user['score']      = '積分';
$lang->site->moduleAvailable->user['message']    = '評論留言';
$lang->site->moduleAvailable->user['submission'] = '投稿';

$lang->site->moduleAvailable->mall = array();
$lang->site->moduleAvailable->mall['shop']    = '商城';
$lang->site->moduleAvailable->mall['product'] = '產品';
                           
$lang->site->moduleAvailable->score = array();
$lang->site->moduleAvailable->score['search'] = '搜索';
$lang->site->moduleAvailable->score['stat']   = '統計';

$lang->site->metaHolder       = '可放置<meta><script><style>和<link>標籤。';
$lang->site->fileAllowedRole  = '多個尾碼名之間請用 "," 隔開';
$lang->site->domainTip        = '所有網站訪問跳轉到該域名，請確保主域名解析正確，該值為空時不進行跳轉。';
$lang->site->allowedDomainTip = "只允許填寫的域名訪問網站，多個域名用 , 隔開，該值為空時允許所有域名訪問。";
$lang->site->allowedIPTip     = '多個IP用 , 隔開，如202.194.133.1,202.194.132.0/28。允許所有IP訪問請留空。';
$lang->site->wrongAllowedIP   = 'IP 格式錯誤';
$lang->site->changeLocation   = '您當前的登錄地區與允許登錄地區不一致。';
$lang->site->sessionIpTip     = '開啟後，如IP變化將自動退出登錄。';
$lang->site->schemeTip        = '所有訪問會跳轉至預設訪問協議。';
$lang->site->saveDaysTip      = '訪問日誌保存天數必須為為 >0 的數字。';
$lang->site->closeScoreTip    = '禁用積分功能後不再記錄積分，會員保持原有積分不變。';
$lang->site->cdnFileLost      = '以下資源無法訪問：';
$lang->site->useDefaultCdn    = '使用預設地址';
$lang->site->defaultTip       = '站點維護中……';
$lang->site->icpTip           = '僅支持中國大陸網站';
$lang->site->requestTypeTip   = '經檢測，您可使用PATH_INFO模式，SEO效果更佳。';
$lang->site->sensitiveTip     = '多個敏感詞之間請用英文逗號分隔';

$lang->site->robots            = 'Robots';
$lang->site->robotsUnwriteable = 'Robots檔案%s 不可寫，請修改權限後設置。';
$lang->site->reloadForRobots   = '刷新頁面';

$lang->site->customizableList = new stdclass();
$lang->site->customizableList->article = '文章列表數量';
$lang->site->customizableList->product = '產品列表數量';
$lang->site->customizableList->blog    = '博客列表數量';
$lang->site->customizableList->book    = '手冊列表數量';
$lang->site->customizableList->forum   = '論壇列表數量';
$lang->site->customizableList->reply   = '回帖列表數量';
$lang->site->customizableList->message = '留言列表數量';
$lang->site->customizableList->comment = '評論列表數量';

$lang->site->api = new stdclass();
$lang->site->api->common = '整合';
$lang->site->api->key    = '密鑰';
$lang->site->api->ip     = 'IP列表';
$lang->site->api->allip  = '無限制';
$lang->site->api->ipTip  = '允許調用者使用這些IP訪問，多個IP使用,隔開。支持IP段，如192.168.1.*';

$lang->site->menus = array();
$lang->site->menus['order']      = '訂單';
$lang->site->menus['message']    = '留言';
$lang->site->menus['thread']     = '主題';
$lang->site->menus['forumreply'] = '回帖';
$lang->site->menus['article']    = '文章';
$lang->site->menus['page']       = '單頁';
$lang->site->menus['blog']       = '博客';
$lang->site->menus['book']       = '手冊';
$lang->site->menus['submission'] = '投稿';
$lang->site->menus['product']    = '產品';
$lang->site->menus['user']       = '會員';
$lang->site->menus['wechat']     = '微信';
$lang->site->menus['stat']       = '統計';
$lang->site->menus['tag']        = '關鍵詞';
$lang->site->menus['links']      = '友情連結';
$lang->site->menus['site']       = '站點';
$lang->site->menus['security']   = '安全';

$lang->site->fileAuthority = '需要修改寫入檔案的權限，Linux下的運行命令為<code>%s</code>';
$lang->site->fileRequired  = '需要創建檔案，Linux下的運行命令為<code>%s</code>';

$lang->site->wechatLoginTip = '使用微信登錄需要開啟PHP的openssl擴展';
$lang->site->noZlib         = '啟用gz輸出需要開啟PHP的zlib擴展';
$lang->site->gzipOn         = 'apache已經安裝gzip擴展，無需再啟用gzip輸出';
