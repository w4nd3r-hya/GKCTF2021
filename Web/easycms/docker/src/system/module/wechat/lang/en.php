<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The wechat module zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     wechat
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->wechat->common = 'Wechat';

$lang->wechat->id        = 'ID';
$lang->wechat->type      = 'Type';
$lang->wechat->name      = 'Name';
$lang->wechat->account   = 'Account ID';
$lang->wechat->appID     = 'AppID';
$lang->wechat->appSecret = 'AppSecret';
$lang->wechat->token     = 'Token';
$lang->wechat->url       = 'URL';
$lang->wechat->certified = 'Verified';
$lang->wechat->users     = 'WeChat User';
$lang->wechat->content   = 'Content';
$lang->wechat->qrcode    = 'QR Code';

$lang->wechat->create         = 'Create';
$lang->wechat->edit           = 'Edit';
$lang->wechat->admin          = 'Admin';
$lang->wechat->list           = 'List';
$lang->wechat->set            = 'Setting';
$lang->wechat->setMenu        = 'Menu';
$lang->wechat->integrate      = 'Integrate';
$lang->wechat->adminResponse  = 'Response';
$lang->wechat->setResponse    = 'Set Response';
$lang->wechat->deleteResponse = 'Remove Response';
$lang->wechat->reply          = 'Reply';
$lang->wechat->commitMenu     = 'Menu';
$lang->wechat->deleteMenu     = 'Delete Menu';
$lang->wechat->messageList    = 'Messages';
$lang->wechat->remind         = 'Remind';
$lang->wechat->unsupported    = 'Can not display %s message';

$lang->wechat->typeList['subscribe'] = 'Subscribe';
$lang->wechat->typeList['service']   = 'Service';

$lang->wechat->certifiedList[1] = 'Yes';
$lang->wechat->certifiedList[0] = 'No';

$lang->wechat->response = new stdclass();

$lang->wechat->response->keywords  = 'Tag';
$lang->wechat->response->set       = 'Settings';
$lang->wechat->response->create    = 'Add Tag';
$lang->wechat->response->default   = 'Default';
$lang->wechat->response->subscribe = 'Subscribe';

$lang->wechat->response->type     = 'Type';
$lang->wechat->response->source   = 'Source';
$lang->wechat->response->module   = 'Module';
$lang->wechat->response->block    = 'Content';
$lang->wechat->response->link     = 'Link';
$lang->wechat->response->category = 'Category';
$lang->wechat->response->limit    = 'Count';

$lang->wechat->response->list   = 'List';

$lang->wechat->response->typeList['link'] = 'Link';
$lang->wechat->response->typeList['text'] = 'Text';
$lang->wechat->response->typeList['news'] = 'Image';

$lang->wechat->response->sourceList['system'] = "System";
$lang->wechat->response->sourceList['manual'] = 'Manual';

$lang->wechat->response->moduleList['index']   = 'Home';
$lang->wechat->response->moduleList['company'] = 'About Us';
$lang->wechat->response->moduleList['blog']    = 'Blog';
$lang->wechat->response->moduleList['forum']   = 'Forum';
$lang->wechat->response->moduleList['book']    = 'Book';
$lang->wechat->response->moduleList['manual']  = 'Custom';

$lang->wechat->response->textBlockList['company'] = 'Company Intro';
$lang->wechat->response->textBlockList['contact'] = 'Contact Us';
$lang->wechat->response->textBlockList['manual']  = 'Custom';

$lang->wechat->response->newsBlockList['articleTree']   = 'Article Category';
$lang->wechat->response->newsBlockList['latestArticle'] = 'Latest article';
$lang->wechat->response->newsBlockList['hotArticle']    = 'Hot article';
$lang->wechat->response->newsBlockList['productTree']   = 'Product Category';
$lang->wechat->response->newsBlockList['latestProduct'] = 'Latest product';
$lang->wechat->response->newsBlockList['hotProduct']    = 'Hot product';

$lang->wechat->message = new stdclass();
$lang->wechat->message->from     = 'From';
$lang->wechat->message->type     = 'Type';
$lang->wechat->message->status   = 'Status';
$lang->wechat->message->content  = 'Content';
$lang->wechat->message->response = 'Response';
$lang->wechat->message->menu     = 'Menu';
$lang->wechat->message->time     = 'Date';
$lang->wechat->message->reply    = 'Reply';
$lang->wechat->message->record   = 'Record';
$lang->wechat->message->list     = 'List';

$lang->wechat->message->typeList['text']        = 'Text';
$lang->wechat->message->typeList['image']       = 'Image';
$lang->wechat->message->typeList['voice']       = 'Audio';
$lang->wechat->message->typeList['location']    = 'Location';
$lang->wechat->message->typeList['link']        = 'Link';
$lang->wechat->message->typeList['subscribe']   = 'Subscribe';
$lang->wechat->message->typeList['unsubscribe'] = 'Unsubscribe';
$lang->wechat->message->typeList['scan']        = 'Scan';
$lang->wechat->message->typeList['click']       = 'Hit';
$lang->wechat->message->typeList['view']        = 'Link';

$lang->wechat->message->tabList[] = 'mode=replied&replied=0|Unreplied';
$lang->wechat->message->tabList[] = 'mode=type&type=text|Message';
$lang->wechat->message->tabList[] = 'mode=type&type=subscribe|Subscribed';
$lang->wechat->message->tabList[] = 'mode=type&type=unsubscribe|Unsubscribed';
$lang->wechat->message->tabList[] = 'mode=replied&replied=1|Replied';

$lang->wechat->noSelectedFile  = "No image is selected!";
$lang->wechat->noAppID         = "No AppID";
$lang->wechat->qrcodeType      = "Please upload QR code in .jpg";

$lang->wechat->placeholder = new stdclass();
$lang->wechat->placeholder->limit    = '<=10';
$lang->wechat->placeholder->category = 'Max 10 categories';
$lang->wechat->placeholder->name     = 'Name of public';
$lang->wechat->placeholder->account  = 'gh_xxx format';
$lang->wechat->placeholder->token    = 'English letter or number, length of 3-32 characters.';

$lang->wechat->mailSubject     = "From %s wechat";
$lang->wechat->remindUsers     = "Mail to selected";
$lang->wechat->remindNotice    = "Note: Email notification has to be configured, or they cannot receive notifications.";
$lang->wechat->remindNoMail    = "Email notification is not enabled. Configure in the Set->API-> Email.";
$lang->wechat->curlSSLRequired = "This feature requires curl module with ssl encryption transmission.";
$lang->wechat->opensslRequired = "This feature requires openssl module. Please open the PHP module";
$lang->wechat->needCertified   = "This feature requires the account to be verified.";
$lang->wechat->integrateInfo   = "Please integrate in the wechat control panel.";
$lang->wechat->integrateDone   = "I have integrated with wechat server";
$lang->wechat->openUserModule  = "You should switch on User module first. Switch it on now?";
