<?php if(!defined("RUN_MODE")) die();?>
<?php
$lang->admin->common        = 'Admin';
$lang->admin->index         = 'Home';
$lang->admin->checked       = 'Checked';

$lang->admin->getEmailCodeByApi  = 'Get email code';
$lang->admin->getMobileCodeByApi = 'Get mobile code';

$lang->admin->shortcuts = new stdclass();
$lang->admin->shortcuts->common             = 'Shortcuts';
$lang->admin->shortcuts->articleCategories  = 'Category';
$lang->admin->shortcuts->article            = 'Article';
$lang->admin->shortcuts->product            = 'Product';
$lang->admin->shortcuts->feedback           = 'Feedback';
$lang->admin->shortcuts->site               = 'Settings';
$lang->admin->shortcuts->logo               = 'Logo';
$lang->admin->shortcuts->company            = 'Company';
$lang->admin->shortcuts->contact            = 'Contact';

$lang->admin->thread       = 'New Thread';
$lang->admin->order        = 'New Order';
$lang->admin->feedback     = 'New Feedback';

$lang->admin->adminEntry     = 'Warning! The admin entry is admin.php. Please rename it for security reasons.';

$lang->admin->connectApiFail = "It cannot be connected to the Zsite community. Please <a href='javascritp:loaction.reload()'>retry</a> after check the internet connection.";
$lang->admin->registerInfo   = "The site has binded to Zsite %s, %s";
$lang->admin->registerPage   = 'Register Page';
$lang->admin->rebind         = "Rebind";
$lang->admin->bindedInfo     = 'ZSite Account';

$lang->js->confirmRebind = "Are you sure to rebind the account of Zsite?";

$lang->admin->community = new stdclass();
$lang->admin->community->common     = 'The page is to register in Zsite.';
$lang->admin->community->caption    = 'Register';
$lang->admin->community->lblAccount = 'letters and numbers only ';
$lang->admin->community->lblPasswd  = 'letters and numbers only ';
$lang->admin->community->submit     = 'Submit';
$lang->admin->community->success    = "Submitted";
$lang->admin->community->update     = "Update information";

$lang->admin->bind = new stdclass();
$lang->admin->bind->caption = 'Zsite Account';
$lang->admin->bind->submit  = 'Bind account';
$lang->admin->bind->success = "Binding account is done.";
