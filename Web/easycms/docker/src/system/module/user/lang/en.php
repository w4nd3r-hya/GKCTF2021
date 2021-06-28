<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The user module english file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     user
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->user->common    = 'User';
$lang->user->setting   = 'User Setting';

$lang->user->id        = 'ID';
$lang->user->account   = 'Account';
$lang->user->admin     = 'Admin';
$lang->user->oldPwd    = 'Old Password';
$lang->user->password  = 'Password';
$lang->user->password2 = 'Repeat Password';
$lang->user->realname  = 'Name';
$lang->user->nickname  = 'Nick Name';
$lang->user->avatar    = 'Avatar';
$lang->user->birthyear = 'Birth Year';
$lang->user->birthday  = 'Birthday';
$lang->user->gender    = 'Gender';
$lang->user->email     = 'Email';
$lang->user->msn       = 'MSN';
$lang->user->qq        = 'QQ';
$lang->user->yahoo     = 'Yahoo';
$lang->user->gtalk     = 'Gtalk';
$lang->user->wangwang  = 'Wangwang';
$lang->user->mobile    = 'Mobile';
$lang->user->phone     = 'Phone';
$lang->user->company   = 'Company';
$lang->user->address   = 'Address';
$lang->user->zipcode   = 'Zip Code';
$lang->user->join      = 'Join Date';
$lang->user->visits    = 'Visit';
$lang->user->ip        = 'IP';
$lang->user->last      = 'Last Login';
$lang->user->status    = 'Status';
$lang->user->captcha   = 'Verification Code';
$lang->user->alert     = 'Your account has been disabled.';
$lang->user->privilege = 'Privilege';
$lang->user->certified = 'Verified';

$lang->user->all             = 'All Users';
$lang->user->list            = 'User List';
$lang->user->view            = "User Profile";
$lang->user->create          = "Add User";
$lang->user->edit            = "Edit";
$lang->user->operate         = 'Action';
$lang->user->changePassword  = "Change Password";
$lang->user->changeEmail     = "Email Settings";
$lang->user->recoverPassword = "Forgot Password";
$lang->user->newPassword     = "New Password";
$lang->user->update          = "Edit User";
$lang->user->browse          = "View User";
$lang->user->deny            = "You access is denied.";
$lang->user->confirmDelete   = "Do you want to delete it?";
$lang->user->confirmActivate = "Do you want to activate it?";
$lang->user->relogin         = "Login again";
$lang->user->asGuest         = "Guest Login";
$lang->user->goback          = "Back";
$lang->user->allUsers        = 'All Users';
$lang->user->submit          = "Submit";
$lang->user->forbid          = 'Disable';
$lang->user->activate        = 'Activate';
$lang->user->pullWechatFans  = 'Update Wechat fans data';
$lang->user->adminlog        = 'Admin Log';
$lang->user->checkEmail      = 'Bind Your Email';
$lang->user->getEmailCode    = 'Get verification code';
$lang->user->getCertifyCode  = 'Send Now';
$lang->user->setEmail        = 'Change Email';
$lang->user->setMobile       = 'Configure Mobile';
$lang->user->newEmail        = 'Email';
$lang->user->rank            = 'Rank';
$lang->user->score           = 'Cost';
$lang->user->details         = 'Detail';
$lang->user->buyScore        = 'Buy Point';
$lang->user->addScore        = 'Reward';
$lang->user->reduceScore     = 'Deduct';
$lang->user->bindAccount     = 'Bind Your Account';
$lang->user->batchDelete     = 'Batch Delete';
$lang->user->deleteHistory   = 'Delete the account and its history';
$lang->user->question        = 'Security Questions';
$lang->user->answer          = 'Answer';
$lang->user->checkContact    = 'Contact';
$lang->user->certifyNow      = 'Verify Now';

$lang->user->checkMobile        = 'Verify Your Mobile';
$lang->user->checkMobileSuccess = 'Your mobile is veridied.';

$lang->user->type           = 'Type';
$lang->user->profile        = 'Profile';
$lang->user->editProfile    = 'Edit';
$lang->user->thread         = 'Thread';
$lang->user->messages       = 'Message';
$lang->user->reply          = 'Reply';
$lang->user->submission     = 'Submission';
$lang->user->unlogin        = "Not Login";
$lang->user->clickLogin     = "Click to login";
$lang->user->myScore        = "My Point";
$lang->user->totalScore     = "Total Point";
$lang->user->levelScore     = "Level Point";
$lang->user->scoreRecharge  = "Buy Point";

$lang->user->userHistory       = "User History";
$lang->user->threadHistory     = "Post";
$lang->user->replyHistory      = "Reply";
$lang->user->commentHistory    = "Comment";
$lang->user->messageHistory    = "Message";
$lang->user->orderHistory      = "Order";
$lang->user->addressHistory    = "Address";
$lang->user->submissionHistory = "Submission";

$lang->user->message = new stdclass();
$lang->user->message->mine   = "Message <span class='label label-badge text-latin'>%s</span>";
$lang->user->message->from   = 'from';
$lang->user->message->unread = '%s unread';

$lang->user->inputUserName       = 'Enter user name';
$lang->user->inputAccountOrEmail = 'Enter your account or Email';
$lang->user->inputPassword       = 'Enter Password';
$lang->user->searchUser          = 'Search';

$lang->user->errorDeny         = "Sorry, you have no access to『<b>%s</b>』->『<b>%s</b>』. Please contact your Admin. <br/> You will be directed to Homepage in 5 seconds...";
$lang->user->noModuleDeny      = "Sorry, the site you are visiting has not been enabled 『<b>%s</b>』module. Please contact your Admin. <br/> You will be directed to Homepage in 5 seconds...";
$lang->user->loginFailed       = "Login failed. Please check your username and password.";
$lang->user->identifyFailed    = "Verification failed. Please check your password.";
$lang->user->locked            = "Account has been locked. Please try to login in %s.";
$lang->user->lockedForEver     = "Account has been permanently deactivated.";
$lang->user->lblRegistered     = 'Congrats! You have registered in Zsite!';
$lang->user->forbidSuccess     = 'Deactivated!';
$lang->user->forbidFail        = 'Deactivation failed.';
$lang->user->activateSuccess   = 'Activated!';
$lang->user->activateFail      = 'Activation failed.';
$lang->user->pullSuccess       = 'Wetchat user data is done';
$lang->user->wrongPwd          = 'Wrong Password';
$lang->user->checkEmailSuccess = 'Done!';
$lang->user->sendRecoverEmail  = 'Send reset Email.';
$lang->user->resetSuccess      = 'Password has been reset. Please login with your new password.';

$lang->user->forbidUser = 'Deactivate';
$lang->user->forbidDate = array();
$lang->user->forbidDate['1']    = '1 Day';
$lang->user->forbidDate['2']    = '2 Days';
$lang->user->forbidDate['3']    = '3 Days';
$lang->user->forbidDate['7']    = '1 Week';
$lang->user->forbidDate['30']   = '1 Month';
$lang->user->forbidDate['3000'] = 'Permanent';

$lang->user->adminList['super']  = 'Super Admin';
$lang->user->adminList['common'] = 'Admin';
$lang->user->adminList['no']     = 'User';

$lang->user->accountTypeList['no']      = 'Front Account';
$lang->user->accountTypeList['common']  = 'Backend Account';

$lang->user->genderList = new stdclass();
$lang->user->genderList->m = 'Male';
$lang->user->genderList->f = 'Female';
$lang->user->genderList->u = 'unknown';
$lang->user->register  = new stdclass();
$lang->user->register->common      = 'Register';
$lang->user->register->instant     = 'Register Now';
$lang->user->register->welcome     = 'Welcome to register in Ziste!';
$lang->user->register->why         = 'Register to enjoy more!';
$lang->user->register->lblUserInfo = 'User Profile';
$lang->user->register->lblAccount  = 'must be letters and numbers, 3 charaters at least.';
$lang->user->register->lblPassword = 'must be letters and numbers, 6 charaters at least.';
$lang->user->register->login       = 'Login';
$lang->user->register->loginTip    = 'Already registered?';
$lang->user->register->agreement   = 'Agreement';
$lang->user->register->agree       = 'I have read and accept';

$lang->user->notice = new stdclass();
$lang->user->notice->password = '>=6 letters and numbers';

$lang->user->login  = new stdclass();
$lang->user->login->common  = "Login";
$lang->user->login->welcome = 'Account';
$lang->user->login->why     = 'Welcome to login!';

$lang->user->resetPassword = new stdclass();
$lang->user->resetPassword->common  = "Reset Password";
$lang->user->resetPassword->success = "Reset password link has been sent to your Email.";
$lang->user->resetPassword->failed  = "Wrong security Email address. Please enter again.";

$lang->user->resetMail = new stdclass();
$lang->user->resetMail->subject  = 'Reset Password';
$lang->user->resetMail->account  = 'Hello,'; 
$lang->user->resetMail->resetUrl = 'You have requested to reset your password at %s（%s）. Pleae click the link below and reset your password.'; 
$lang->user->resetMail->notice   = 'This is automatically sent by Zsite. Do not reply.(Ignore this Email, if you do not want to do anthing.)';

$lang->user->oauth = new stdclass();
$lang->user->oauth->common       = 'Open Login';
$lang->user->oauth->provider     = 'Service Provider';
$lang->user->oauth->verification = 'Verification';
$lang->user->oauth->widget       = 'Widget';
$lang->user->oauth->callbackURL  = 'Call Back URL';

$lang->user->oauth->sina = new stdclass();
$lang->user->oauth->sina->clientID     = 'App Key';
$lang->user->oauth->sina->clientSecret = 'App Secret';

$lang->user->oauth->qq = new stdclass();
$lang->user->oauth->qq->clientID     = 'APP ID';
$lang->user->oauth->qq->clientSecret = 'APP KEY';

$lang->user->oauth->github = new stdclass();
$lang->user->oauth->github->clientID     = 'Client ID';
$lang->user->oauth->github->clientSecret = 'Client Secret';

$lang->user->oauth->twitter= new stdclass();
$lang->user->oauth->twitter->clientID     = 'API ID';
$lang->user->oauth->twitter->clientSecret = 'API Secret';

$lang->user->oauth->facebook= new stdclass();
$lang->user->oauth->facebook->clientID     = 'API ID';
$lang->user->oauth->facebook->clientSecret = 'API Secret';

$lang->user->oauth->google= new stdclass();
$lang->user->oauth->google->clientID     = 'API ID';
$lang->user->oauth->google->clientSecret = 'API Secret';

$lang->user->oauth->wechat = new stdclass();
$lang->user->oauth->wechat->clientID     = 'AppID';
$lang->user->oauth->wechat->clientSecret = 'AppSecret';
$lang->user->oauth->wechat->autoLogin    = 'Automatic Login';

$lang->user->oauth->wechat->autoLoginList = array();
$lang->user->oauth->wechat->autoLoginList['on']  = 'On';
$lang->user->oauth->wechat->autoLoginList['off'] = 'Off';

$lang->user->oauth->providers['sina'] = 'Weibo';
$lang->user->oauth->providers['qq']   = 'QQ';
$lang->user->oauth->providers['github'] = 'Github';
#$lang->user->oauth->providers['twitter'] = 'Twitter';
$lang->user->oauth->providers['facebook'] = 'Facebook';
#$lang->user->oauth->providers['google'] = 'Google';
$lang->user->oauth->providers['wechat']   = 'Wechat';

$lang->user->oauth->typeList['sina']   = 'Weibo User';
$lang->user->oauth->typeList['qq']     = 'QQ User';
$lang->user->oauth->typeList['wechat'] = 'Wechat User';
$lang->user->oauth->typeList['github'] = 'Github';
$lang->user->oauth->typeList['facebook'] = 'Facebook';
#$lang->user->oauth->typeList['google'] = 'Google';

$lang->user->oauth->bindUser         = 'Bind User';
$lang->user->oauth->lblWelcome       = 'Open Login';
$lang->user->oauth->lblOtherLogin    = 'Other Login';
$lang->user->oauth->lblProfile       = "Register User";
$lang->user->oauth->lblBind          = "User Binding";
$lang->user->oauth->directBind       = "Direct Bind";
$lang->user->oauth->lblBindCurrent   = "The current login user is %s，Wechat username is %s";
$lang->user->oauth->lblUnbind        = "Remove Binding";
$lang->user->oauth->lblUnbindSuccess = "Binding removed!";
$lang->user->oauth->lblUnbindFailed  = "Remove bnding failed!";
$lang->user->oauth->lblBindFailed    = "User binding failed!";
$lang->user->oauth->ignore           = "Ignore";

$lang->user->statusList = new stdclass();
$lang->user->statusList->locked    = "<label class='label label-danger'>Locked</label>";
$lang->user->statusList->forbidden = "<label class='label label-danger'>Deactivated</label>";
$lang->user->statusList->normal    = "<label class='label label-success'>Normal</label>";

$lang->user->control = new stdclass();
$lang->user->control->common      = 'User Center';
$lang->user->control->welcome     = 'Hello, <strong>%s</strong>';
$lang->user->control->lblPassword = "Leave it blank, if you don't want to change your password.";

$lang->user->navGroups = new stdclass();
$lang->user->navGroups->user    = 'My Profile';
$lang->user->navGroups->order   = 'My Order';
$lang->user->navGroups->message = 'My Post';

$lang->user->control->menus['profile']    = '<i class="icon-user"></i> Profile <i class="icon-chevron-right"></i>|user|profile';
$lang->user->control->menus['message']    = '<i class="icon-comments-alt"></i> Message <i class="icon-chevron-right"></i>|user|message';
$lang->user->control->menus['score']      = '<i class="icon-sun"></i> Points <i class="icon-chevron-right"></i>|user|score';
$lang->user->control->menus['recharge']   = '<i class="icon-bolt"></i> Refill Points <i class="icon-chevron-right"></i>|score|buyscore';
$lang->user->control->menus['order']      = '<i class="icon-shopping-cart"></i> Order <i class="icon-chevron-right"></i>|order|browse';
$lang->user->control->menus['address']    = '<i class="icon-map-marker"> </i> Address <i class="icon-chevron-right"></i>|address|browse';
$lang->user->control->menus['thread']     = '<i class="icon-comment"></i> Thread <i class="icon-chevron-right"></i>|user|thread';
$lang->user->control->menus['reply']      = '<i class="icon-reply"></i> Reply <i class="icon-chevron-right"></i>|user|reply';
$lang->user->control->menus['submission'] = '<i class="icon-envelope"></i> Submission <i class="icon-chevron-right"></i>|article|submission';
$lang->user->control->menus['cart']       = '<i class="icon-shopping-cart text-danger"></i> Cart <i class="icon-chevron-right"></i>|cart|browse';

$lang->user->log = new stdclass();
$lang->user->log->common = 'Log';
$lang->user->log->list   = 'Login Log';

$lang->user->log->id          = 'ID';
$lang->user->log->account     = 'Account';
$lang->user->log->browser     = 'Browser';
$lang->user->log->ip          = 'IP Address';
$lang->user->log->location    = 'Location';
$lang->user->log->date        = 'Login Time';
$lang->user->log->desc        = 'Login Result';

$lang->user->ipDenied             = 'Login IP is restricted.Please follow instructions.';
$lang->user->locationDenied       = 'Login location is restricted. Please follow instructions.';
$lang->user->loginLocationChanged = 'Login address is changed. Please follow instructions.';
$lang->user->verifyFail           = 'Please enter the correct verification code.';
$lang->user->confirmUnbind        = 'Do you want to remove binding?';

$lang->user->placeholder = new stdclass();
$lang->user->placeholder->password   = 'Please enter your password.';
$lang->user->placeholder->verifyCode = 'Please enter verification code received by Email.';

$lang->user->isSensitive = 'Username can not be sensitive words. Please change it';
