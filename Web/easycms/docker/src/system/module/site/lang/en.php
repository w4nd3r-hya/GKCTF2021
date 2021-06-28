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
$lang->site->common        = "Site";

$lang->site->type            = 'Site Type';
$lang->site->tidy            = 'Tiny Html';
$lang->site->requestType     = 'Request Type';
$lang->site->status          = 'Site Status';
$lang->site->pauseTip        = 'Message';
$lang->site->name            = 'Site Name';
$lang->site->module          = 'Module';
$lang->site->lang            = 'Site Language';
$lang->site->defaultLang     = 'Default Language';
$lang->site->domain          = 'Domain';
$lang->site->allowedDomain   = 'Allowed Domain';
$lang->site->keywords        = 'Tags';
$lang->site->indexKeywords   = 'Homepage Tags';
$lang->site->meta            = 'Meta Tags';
$lang->site->desc            = 'Description';
$lang->site->icpSN           = 'ICP SN';
$lang->site->icpLink         = 'icp Link';
$lang->site->policeSN        = 'Police Record Number';
$lang->site->policeTip       = 'Police Record Number';
$lang->site->policeLink      = 'Police Link';
$lang->site->slogan          = 'Slogan';
$lang->site->mission         = 'Site Mission';
$lang->site->copyright       = 'Copyright';
$lang->site->allowUpload     = 'File Upload';
$lang->site->allowedFiles    = 'File Format';
$lang->site->setImageSize    = 'Thumbnail Size';
$lang->site->captcha         = 'Web Form Verification';
$lang->site->mailCaptcha     = 'Email Verification Code';
$lang->site->twContent       = 'Traditional Chinese';
$lang->site->cn2tw           = 'Auto translate to simplified Chinese';
$lang->site->cdn             = 'CDN Address';
$lang->site->sensitive       = 'Sensitive Words';
$lang->site->scheme          = 'Default Protocol';
$lang->site->saveDays        = 'Hold Time';
$lang->site->openCache       = 'Cache';
$lang->site->cachePage       = 'Cache Page';
$lang->site->cacheExpired    = 'Cache Expiration';
$lang->site->clearCache      = 'Clear Cache';
$lang->site->clearingCache   = 'Clearing';
$lang->site->clearedCache    = 'Finished';
$lang->site->failClear       = 'Failed';
$lang->site->clearCacheTip   = '<td>You do NOT have the privilege to clear cache. Please update your privilege of <code>%s</code>.<td>';
$lang->site->hour            = 'Hour';
$lang->site->homeMenus       = 'Homepage Menu';
$lang->site->agreement        = 'Agreement';
$lang->site->agreementTitle   = 'Title';
$lang->site->agreementContent = 'Content';

$lang->site->importantOption  = 'Key Action Verification';
$lang->site->resetPassword    = 'Reset Password';
$lang->site->checkIP          = 'IP Whitelist';
$lang->site->checkLocation    = 'Admin Login Verification';
$lang->site->checkEmail       = 'Email Binding';
$lang->site->filterFunction   = 'Filter';
$lang->site->allowedLocation  = 'Check Login';
$lang->site->checkSessionIP   = 'IP Check';
$lang->site->setsecurity      = 'Security Settings';
$lang->site->setsensitive     = 'Sensitive Word Settings';
$lang->site->filterSensitive  = 'Sensitive Word Filter';
$lang->site->setBlacklist     = 'Blacklist';
$lang->site->mobileTemplate   = 'Mobile Site';
$lang->site->gzipOutput       = 'gzip output';
$lang->site->score            = 'Points';
$lang->site->setCounts        = 'Point Rules';
$lang->site->front            = 'Website Access';
$lang->site->useCDN           = 'CDN';

$lang->site->setBasic      = "Basic Settings";
$lang->site->setLanguage   = "Language";
$lang->site->setUrlType    = "URL Type";
$lang->site->setCache      = 'Cache Settings';
$lang->site->setCDN        = "CDN Settings";
$lang->site->setDomain     = "Domain Settings";
$lang->site->setLang       = "Language";
$lang->site->setFilter     = "Filter";
$lang->site->ipFilter      = "IP Filter";
$lang->site->accountFilter = "Account Filter";
$lang->site->setSecurity   = "Basic Settings";
$lang->site->setUpload     = "File Upload";
$lang->site->setRobots     = "Robot Settings";
$lang->site->setOauth      = "Open Login";
$lang->site->setSinaOauth  = "Weibo Login Setting";
$lang->site->setQQOauth    = "QQ Login Setting";
$lang->site->oauthHelp     = "Help";
$lang->site->setRecPerPage = "List Settings";
$lang->site->useLocation   = "Use <span>%s</span>";
$lang->site->changeSetting = "Change Settings";
$lang->site->setStat       = "Traffic Report";
$lang->site->setHomeMenu   = "Homepage Menu";
$lang->site->openModule    = "Open module";
$lang->site->setAgreement  = "Set Agreement";
$lang->site->isVertified   = "Vertified";

$lang->site->typeList = new stdclass();
$lang->site->typeList->portal = 'Enterprise Portal';
$lang->site->typeList->blog   = 'Individual Blog';

$lang->site->requestTypeList = array();
$lang->site->requestTypeList['PATH_INFO']  = 'PATH_INFO';
$lang->site->requestTypeList['PATH_INFO2'] = 'PATH_INFO2';
$lang->site->requestTypeList['GET']        = 'GET';

$lang->site->statusList = new stdclass();
$lang->site->statusList->normal = 'Normal';
$lang->site->statusList->pause  = 'Down';

$lang->site->agreementList = array();
$lang->site->agreementList['open']  = 'Open';
$lang->site->agreementList['close'] = 'Close';

$lang->site->resetPasswordList = array();
$lang->site->resetPasswordList['open']  = 'On';
$lang->site->resetPasswordList['close'] = 'Off';

$lang->site->tidyOptions = array();
$lang->site->tidyOptions['open']  = 'Open';
$lang->site->tidyOptions['close'] = 'Close';

$lang->site->checkIPList = array();
$lang->site->checkIPList['open']  = 'On';
$lang->site->checkIPList['close'] = 'Off';

$lang->site->filterSensitiveList = array();
$lang->site->filterSensitiveList['open']  = 'On';
$lang->site->filterSensitiveList['close'] = 'Off';

$lang->site->checkLocationList = array();
$lang->site->checkLocationList['open']  = 'On';
$lang->site->checkLocationList['close'] = 'Off';

$lang->site->checkEmailList = array();
$lang->site->checkEmailList['open']  = 'On';
$lang->site->checkEmailList['close'] = 'Off';

$lang->site->sensitiveList = array();
$lang->site->sensitiveList['content'] = 'Content';
$lang->site->sensitiveList['user']    = 'User Name';

$lang->site->sessionIpoptions = array();
$lang->site->sessionIpoptions[1] = 'On';
$lang->site->sessionIpoptions[0] = 'Off';

$lang->site->imageSize['s'] = 'small';
$lang->site->imageSize['m'] = 'medium';
$lang->site->imageSize['l'] = 'large';

$lang->site->image['width']  = 'Width';
$lang->site->image['height'] = 'Height';

$lang->site->captchaList = array();
$lang->site->captchaList['open']  = 'Always';
$lang->site->captchaList['auto']  = 'Auto';
$lang->site->captchaList['close'] = 'Never';

$lang->site->validateTypes = new stdclass();
$lang->site->validateTypes->okFile      = 'File verification';
$lang->site->validateTypes->email       = 'Email verification';
$lang->site->validateTypes->setSecurity = 'Security questions';

$lang->site->schemeList = array();
$lang->site->schemeList['http']  = 'http';
$lang->site->schemeList['https'] = 'https';

$lang->site->frontList = array();
$lang->site->frontList['login'] = 'Login';
$lang->site->frontList['guest'] = 'Guest';

$lang->site->mobileTemplateList['open']  = 'On';
$lang->site->mobileTemplateList['close'] = 'Off';

$lang->site->gzipOutputList['open']  = 'On';
$lang->site->gzipOutputList['close'] = 'Off';

$lang->site->scoreList['open']  = 'On';
$lang->site->scoreList['close'] = 'Off';

$lang->site->cdnList['open']  = 'On';
$lang->site->cdnList['close'] = 'Off';

$lang->site->cacheTypes['file']  = 'On';
$lang->site->cacheTypes['close'] = 'Off';

$lang->site->cachePageOptions['open']  = 'On';
$lang->site->cachePageOptions['close'] = 'Off';

$lang->site->filterFunctionList['open']  = 'On';
$lang->site->filterFunctionList['close'] = 'Off';

$lang->site->moduleAvailable = new stdclass();

$lang->site->moduleAvailable->content = array();
$lang->site->moduleAvailable->content['article']    = 'Article';
$lang->site->moduleAvailable->content['blog']       = 'Blog';
$lang->site->moduleAvailable->content['page']       = 'Page';
$lang->site->moduleAvailable->content['book']       = 'Book';

$lang->site->moduleAvailable->user = array();
$lang->site->moduleAvailable->user['user']       = 'User';
$lang->site->moduleAvailable->user['forum']      = 'Forum';
$lang->site->moduleAvailable->user['score']      = 'Points';
$lang->site->moduleAvailable->user['message']    = 'Message';
$lang->site->moduleAvailable->user['submission'] = 'Submission';

$lang->site->moduleAvailable->mall = array();
$lang->site->moduleAvailable->mall['shop']    = 'Mall';
$lang->site->moduleAvailable->mall['product'] = 'Product';

$lang->site->moduleAvailable->score = array();
$lang->site->moduleAvailable->score['search'] = 'Search';
$lang->site->moduleAvailable->score['stat']   = 'Statistics';

$lang->site->metaHolder       = 'Tag <meta><script><style> and <link> applicable';
$lang->site->fileAllowedRole  = 'Use "," to separate file types.';
$lang->site->domainTip        = 'All visits will jump to this domain. Please ensure domain analysis is correct. Leave it blank if no jump is wanted.';
$lang->site->allowedDomainTip = "Only visits from certain domain is allowed. Use comma to separate more domains. Leave it blank if no restriction on IP.";
$lang->site->allowedIPTip     = 'Use comma to separate IP, such as 202.194.133.1, 202.194.132.0/28. Leave it blank if no restriction on IP.';
$lang->site->wrongAllowedIP   = 'IP Error';
$lang->site->changeLocation   = 'Your login location is not allowed.';
$lang->site->sessionIpTip     = 'Once it is switched on，the user will log out automatically if IP changed.';
$lang->site->schemeTip        = 'All visits will jump to default access protocol.';
$lang->site->saveDaysTip      = 'Number of days that login log will be kept should be >0.';
$lang->site->closeScoreTip    = 'Once points deactivated, no more points will be recorded and users can keep their points.';
$lang->site->cdnFileLost      = 'The followings can not be accessed';
$lang->site->useDefaultCdn    = 'Use default address';
$lang->site->defaultTip       = 'Sorry, the site is currently down for maintenance……';
$lang->site->icpTip           = 'Mainland China Only';
$lang->site->requestTypeTip   = 'Select PATH_INFO for SEO.';
$lang->site->sensitiveTip     = 'Use "," to separate sensitive.';

$lang->site->robots            = 'Robots';
$lang->site->robotsUnwriteable = 'Robots %s is not writable. Please update your permissions.';
$lang->site->reloadForRobots   = 'Refresh';

$lang->site->customizableList = new stdclass();
$lang->site->customizableList->article = 'Article List';
$lang->site->customizableList->product = 'Product List';
$lang->site->customizableList->blog    = 'Blog List';
$lang->site->customizableList->book    = 'Book List';
$lang->site->customizableList->forum   = 'Forum List';
$lang->site->customizableList->reply   = 'Reply List';
$lang->site->customizableList->message = 'Message List';
$lang->site->customizableList->comment = 'Comment List';

$lang->site->api = new stdclass();
$lang->site->api->common = 'Integration';
$lang->site->api->key    = 'Key';
$lang->site->api->ip     = 'IP List';
$lang->site->api->allip  = 'No Restrictions';
$lang->site->api->ipTip  = 'Use comma to separate IPs allowed to visit. IP segment is OK, such as 192.168.1.*';

$lang->site->menus = array();
$lang->site->menus['order']      = 'Order';
$lang->site->menus['message']    = 'Message';
$lang->site->menus['thread']     = 'Thread';
$lang->site->menus['forumreply'] = 'Reply';
$lang->site->menus['article']    = 'Article';
$lang->site->menus['page']       = 'Page';
$lang->site->menus['blog']       = 'Blog';
$lang->site->menus['book']       = 'Book';
$lang->site->menus['submission'] = 'Submission';
$lang->site->menus['product']    = 'Product';
$lang->site->menus['user']       = 'User';
$lang->site->menus['wechat']     = 'Wechat';
$lang->site->menus['stat']       = 'Stats';
$lang->site->menus['tag']        = 'Tags';
$lang->site->menus['links']      = 'Links';
$lang->site->menus['site']       = 'Site';
$lang->site->menus['security']   = 'Security';

$lang->site->fileAuthority = 'You have to edit the privilege to write the file. In Linux, run the command <code>%s</code>.';
$lang->site->fileRequired  = 'You have to to create the file. In Linux, run the command<code>%s</code>.';

$lang->site->wechatLoginTip = 'It requires the extension openssl of php to use wechat login';
$lang->site->noZlib         = 'It requires the extension zlib of php to use gzip output.';
$lang->site->gzipOn         = 'Apache has been installed gzip extension, no need to enable gzip output.';
