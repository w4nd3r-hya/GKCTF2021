<?php
$config->menus = new stdclass();
$config->menus->home    = 'admin,order,message,comment,reply,thread,forumreply,wechat';
$config->menus->content = 'article,page,blog,book,submission,attachment';
$config->menus->shop    = 'order,product,orderSetting';
$config->menus->user    = 'user,message,comment,reply,forum,wechat,submission';
$config->menus->promote = 'stat,tag,links,bear';
$config->menus->design  = '';
$config->menus->setting = 'site,company,score,interface,security,wechatSetting';
$config->menus->open    = 'package,themestore,effect,community,';

$designMenus = array('ui', 'logo', 'slide', 'nav', 'block', 'visual', 'others', 'edit');
$config->menuGroups = new stdclass();
foreach($designMenus as $menu)
{
    $config->menuGroups->$menu = 'design';
    $config->menus->design .= ",$menu";
}

foreach($config->menus as $group => $modules)
{
    $menus = explode(',', $modules);
    foreach($menus as $menu)
    {
        if($menu) $config->menuGroups->$menu = $group;
    }
}

$config->multiEntrances = array();
$config->multiEntrances[] = 'order_admin';
$config->multiEntrances[] = 'message_admin';
$config->multiEntrances[] = 'forum_admin';
$config->multiEntrances[] = 'reply_admin';
$config->multiEntrances[] = 'article_admin';
$config->multiEntrances[] = 'article_create';
$config->multiEntrances[] = 'article_edit';
$config->multiEntrances[] = 'article_check';
$config->multiEntrances[] = 'product_admin';
$config->multiEntrances[] = 'product_create';
$config->multiEntrances[] = 'product_edit';
$config->multiEntrances[] = 'book_admin';
$config->multiEntrances[] = 'book_create';
$config->multiEntrances[] = 'book_edit';
$config->multiEntrances[] = 'book_catalog';
$config->multiEntrances[] = 'book_setting';
$config->multiEntrances[] = 'user_admin';
$config->multiEntrances[] = 'user_create';
$config->multiEntrances[] = 'user_edit';
$config->multiEntrances[] = 'user_setting';
$config->multiEntrances[] = 'stat_traffic';
$config->multiEntrances[] = 'stat_from';
$config->multiEntrances[] = 'stat_domainlist';
$config->multiEntrances[] = 'stat_search';
$config->multiEntrances[] = 'stat_keywords';
$config->multiEntrances[] = 'stat_browser';
$config->multiEntrances[] = 'stat_page';
$config->multiEntrances[] = 'stat_setting';
$config->multiEntrances[] = 'wechat_message';
$config->multiEntrances[] = 'tag_admin';
$config->multiEntrances[] = 'links_admin'; 
$config->multiEntrances[] = 'site_setbasic'; 
$config->multiEntrances[] = 'site_setsecurity'; 
$config->multiEntrances[] = 'site_setdomain'; 
$config->multiEntrances[] = 'site_setcdn'; 
$config->multiEntrances[] = 'site_setcache'; 
$config->multiEntrances[] = 'site_sethomemenu'; 
$config->multiEntrances[] = 'company_setbasic'; 
$config->multiEntrances[] = 'company_setcontact'; 
$config->multiEntrances[] = 'site_setoauth'; 
$config->multiEntrances[] = 'mail_edit'; 
$config->multiEntrances[] = 'mail_test'; 
$config->multiEntrances[] = 'wechat_admin'; 
$config->multiEntrances[] = 'wechat_create'; 
$config->multiEntrances[] = 'wechat_edit'; 
$config->multiEntrances[] = 'wechat_adminResponse'; 
$config->multiEntrances[] = 'wechat_integrate'; 
$config->multiEntrances[] = 'search_buildindex'; 
$config->multiEntrances[] = 'score_setcounts'; 
$config->multiEntrances[] = 'backup_index'; 
$config->multiEntrances[] = 'site_setfilter'; 
$config->multiEntrances[] = 'guarder_setblacklist'; 
$config->multiEntrances[] = 'guarder_setwhitelist'; 
$config->multiEntrances[] = 'guarder_setsensitive'; 
$config->multiEntrances[] = 'guarder_setcaptcha'; 
$config->multiEntrances[] = 'site_setupload'; 
$config->multiEntrances[] = 'user_admin'; 
$config->multiEntrances[] = 'group_browse'; 
$config->multiEntrances[] = 'group_managepriv'; 
$config->multiEntrances[] = 'group_managemember'; 
$config->multiEntrances[] = 'user_adminlog'; 
$config->multiEntrances[] = 'article_submission'; 
$config->multiEntrances[] = 'file_index'; 

$config->menuDependence = new stdclass();
$config->menuDependence->submission   = 'submission';
$config->menuDependence->page         = 'page';
$config->menuDependence->blog         = 'blog';
$config->menuDependence->orderSetting = 'product';

$config->menuExtra = new stdclass();
$config->menuExtra->visual = "target='_blank'";

$config->moduleMenu = new stdclass();
