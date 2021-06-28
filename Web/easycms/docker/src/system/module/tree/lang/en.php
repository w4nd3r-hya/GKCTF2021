<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The tree category zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     tree
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->tree->add         = "Add";
$lang->tree->edit        = "Edit";
$lang->tree->addChild    = "Add Child";
$lang->tree->delete      = "Delete";
$lang->tree->browse      = "Category";
$lang->tree->manage      = "Manage Category";
$lang->tree->fix         = "Fix Data";
$lang->tree->children    = "Child";
$lang->tree->layout      = 'Layout';

$lang->tree->common           = 'Category';
$lang->tree->noCategories     = 'Please create a category first.';
$lang->tree->timeCountDown    = "<strong id='countDown'>3</strong> seconds later, it will be redirected to category management page.";
$lang->tree->redirect         = 'Redirecting...';
$lang->tree->aliasRepeat      = 'Alias %s is existed. Do not add it again.';
$lang->tree->aliasConflict    = 'Alias %s is conflicted with system module. Do not add it.';
$lang->tree->aliasNumber      = 'Alias should not be numbers.';
$lang->tree->hasChildren      = 'This board has Child Board. Do not delete it.';
$lang->tree->confirmDelete    = "Do you want to delete this category?";
$lang->tree->successFixed     = "Done!";
$lang->tree->browseByCategory = 'View by Category';

$lang->tree->placeholder = new stdclass();
$lang->tree->placeholder->link = 'Enter a link. External one is OK.';

/* Lang items for article, products. */
$lang->category = new stdclass();
$lang->category->common     = 'Category';
$lang->category->name       = 'Name';
$lang->category->abbr       = 'Abbreviation';
$lang->category->alias      = 'Alias';
$lang->category->parent     = 'Parent';
$lang->category->desc       = 'Description';
$lang->category->keywords   = 'Tags';
$lang->category->children   = "Child";
$lang->category->unsaleable = 'Not for Sale';
$lang->category->isLink     = 'Jump';
$lang->category->link       = 'Link';

/* Lang items for forum. */
$lang->board = new stdclass();
$lang->board->common     = 'Board';
$lang->board->name       = 'Name';
$lang->board->abbr       = 'Abbreviation';
$lang->board->alias      = 'Alias';
$lang->board->parent     = 'Parent';
$lang->board->desc       = 'Description';
$lang->board->keywords   = 'Tags';
$lang->board->children   = "Child";
$lang->board->readonly   = 'Access Control';
$lang->board->moderators = 'Board Moderator';
$lang->board->isLink     = 'Jump';
$lang->board->link       = 'Link';
$lang->board->discussion = 'Discussion Mode';

$lang->board->readonlyList[0] = 'Public';
$lang->board->readonlyList[1] = 'Read Only';

$lang->board->placeholder = new stdclass();
$lang->board->placeholder->moderators  = 'Use comma to separate usernames';
$lang->board->placeholder->setChildren = 'You have to set child boards to display a forum.';

/* Lang items for express. */
$lang->express = new stdclass();
$lang->express->common = 'Shipping Carrier';
$lang->express->name   = 'Carrier Name';

/* Lang items for wechat menu. */
$lang->wechatMenu = new stdclass();
$lang->wechatMenu->common      = 'Menu for public account';
$lang->wechatMenu->name        = 'Title';
$lang->wechatMenu->parent      = 'Parent Menu';
$lang->wechatMenu->children    = "Child Menu";
$lang->wechatMenu->delete      = "Detele";
$lang->wechatMenu->commit      = "Sync";
$lang->wechatMenu->setResponse = 'Response Settings';
$lang->wechatMenu->responseTip = 'Tip:Every menu should set the response';

$lang->tree->adminLinks = new stdclass();
$lang->tree->adminLinks->article = 'Manage articles|article|admin|type=article';
$lang->tree->adminLinks->blog    = 'Manage blogs|article|admin|type=blog';
$lang->tree->adminLinks->forum   = 'Manage threads|forum|admin|';
$lang->tree->adminLinks->product = 'Manage products|product|admin|';
