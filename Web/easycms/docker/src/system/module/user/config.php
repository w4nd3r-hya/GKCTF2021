<?php if(!defined("RUN_MODE")) die();?>
<?php
$config->user = new stdclass();
$config->user->resetExpired = 3*86400;

$config->user->skipedFields = new stdclass();
$config->user->skipedFields->create = 'ip,fingerprint,private,emailCertified,mobileCertified,registerAgreement,token';
$config->user->skipedFields->update = 'ip,admin,email,groups,account,join,visits,fingerprint,locked,token,private,emailCertified,mobileCertified,bindSite,token';

$config->user->skipedFields->adminUpdate = 'groups,fingerprint,token';

$config->user->require = new stdclass();
$config->user->require->create      = 'account,realname,email,password1';
$config->user->require->register    = 'account,realname,email,password1';
$config->user->require->edit        = 'realname';
$config->user->require->setSecurity = 'question, answer, security';

$config->user->default = new stdclass();
$config->user->default->module = RUN_MODE == 'front' ? 'user'    : 'admin';
$config->user->default->method = RUN_MODE == 'front' ? 'control' : 'index';

$config->user->recPerPage = new stdclass();
$config->user->recPerPage->thread = 10;
$config->user->recPerPage->reply  = 10;

$config->user->level[1] = 0;
$config->user->level[2] = 500;
$config->user->level[3] = 2000;
$config->user->level[4] = 10000;
$config->user->level[5] = 30000;
$config->user->level[6] = 50000;
$config->user->level[7] = 200000;

$config->user->navGroups = new stdclass();
$config->user->navGroups->desktop = new stdclass();
$config->user->navGroups->desktop->user    = 'profile,message,score,recharge';
$config->user->navGroups->desktop->order   = 'order,address';
$config->user->navGroups->desktop->message = 'thread,reply,submission';

$config->user->navGroups->mobile = new stdclass();
$config->user->navGroups->mobile->user    = 'order,address,cart';
$config->user->navGroups->mobile->message = 'message,thread,reply,submission';

$config->user->infoGroups = new stdclass();
$config->user->infoGroups->mobile = new stdclass();
$config->user->infoGroups->mobile->name    = 'realname';
$config->user->infoGroups->mobile->address = 'email,company,address';
$config->user->infoGroups->mobile->contact = 'zipcode,mobile,phone,qq,gtalk';

$config->user->relatedTables = array();
$config->user->relatedTables[TABLE_MESSAGE][]  = 'account';
$config->user->relatedTables[TABLE_MESSAGE][]  = '`to`';
$config->user->relatedTables[TABLE_THREAD][]   = 'author';
$config->user->relatedTables[TABLE_THREAD][]   = 'repliedBy';
$config->user->relatedTables[TABLE_REPLY][]    = 'author';
$config->user->relatedTables[TABLE_CATEGORY][] = 'postedBy';
$config->user->relatedTables[TABLE_ADDRESS][]  = 'account';
$config->user->relatedTables[TABLE_CART][]     = 'account';
$config->user->relatedTables[TABLE_ORDER][]    = 'account';
$config->user->relatedTables[TABLE_ARTICLE][]  = 'addedBy';
