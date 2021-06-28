<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The site module en file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Hao Sun <sunhao@cnezsoft.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->visual->common      = "Visual Editor";
$lang->visual->editLogo    = "Edit Logo";
$lang->visual->editSlogan  = "Edit slogan";
$lang->visual->appendBlock = "Insert Widget";
$lang->visual->removeBlock = "Remove Widget";
$lang->visual->sortBlocks  = "Sort Widgets";

$lang->visual->info            = "Edit Mode";
$lang->visual->preview         = "Preview";
$lang->visual->exit            = "Exit";
$lang->visual->exitVisualEdit  = "Exit Visual Editor";
$lang->visual->customTheme     = "Custom Theme";
$lang->visual->admin           = "Admin";
$lang->visual->reload          = 'Refresh';
$lang->visual->createBlock     = 'Add Widget';
$lang->visual->manageBlock     = 'Manage Widget';
$lang->visual->searchBlock     = 'Search Widget';
$lang->visual->allBlock        = 'All Widgets';
$lang->visual->openInNewWindow = 'Open in a new window';
$lang->visual->editPowerBy     = "<p>You can use Zsite for free, if you have read and agreed to <a href='http://www.zsite.net/book/zsitemanual/zsitelicense-5.html' target='_blank'> Z PUBLIC LICENSE 1.2 </a>, and you have to keep Zsite logos which is of great importance to Zsite. If you would like to remove Zsite logos, please purchase <a href='http://www.zsite.net/license-search.html' target='_blank'> Zsite business license</a>.</p>";
$lang->visual->pageLayout      = 'Page layout is applied.';
$lang->visual->pageLayoutInfo  = 'Only applies to current layout.<span class="page-name"></span> will not affect global layout.';
$lang->visual->globalLayout    = 'Gloabl Layout';
$lang->visual->globalLayoutInfo= 'Layout applies to all <span class="page-name"></span>';

$lang->visual->js = new stdclass();
$lang->visual->js->saved             = $lang->saveSuccess;
$lang->visual->js->deleted           = $lang->deleteSuccess;
$lang->visual->js->preview           = 'Preview';
$lang->visual->js->exitPreview       = 'Exit';
$lang->visual->js->removeBlock       = 'Remove Widget';
$lang->visual->js->invisible         = 'Hidden';
$lang->visual->js->carousel          = 'Slide';
$lang->visual->js->operateFail       = 'Action failed！';
$lang->visual->js->addContent        = 'Add';
$lang->visual->js->addContentTo      = 'Add Widget to 【{0}】';
$lang->visual->js->createBlock       = 'Add Widget';
$lang->visual->js->addSubRegion      = 'Add Child';
$lang->visual->js->addBlock          = 'Add an existing Widget';
$lang->visual->js->subRegion         = 'Child Widget';
$lang->visual->js->randomRegion      = 'Random Widget';
$lang->visual->js->subRegionDesc     = 'Child Details';
$lang->visual->js->randomRegionDesc  = 'Random Details';
$lang->visual->js->alreadyLastSlide  = 'Last Silde';
$lang->visual->js->alreadyFirstSlide = 'First Silde';
$lang->visual->js->slideOrder        = 'Play Order';
$lang->visual->js->gridWidth         = 'Grid Width';
$lang->visual->js->pageLayoutPrefix  = 'Current Only';
$lang->visual->js->deleteConfirm     = 'Confirm to delete the block “{0}”?';
$lang->visual->js->changeLayout      = 'Change Layout';
$lang->visual->js->setColumns        = 'Set Columns';
$lang->visual->js->addRegionAlert    = 'Not allowed to add Region block to “{0}”.';
$lang->visual->js->actions           = array('edit' => 'Edit', 'delete' => 'Delete', 'move' => 'Move', 'add' => 'Add');

/* Language for config */
$lang->visual->setting = new stdclass();
$lang->visual->setting->logo                               = array('name' => "Logo/name");
$lang->visual->setting->slogan                             = array('name' => "Slogan");
$lang->visual->setting->powerby                            = array('name' => "Zsite logo", 'actions' => array());
$lang->visual->setting->powerby['actions']['edit']         = array('title' => 'Remove Zsite logo', 'text' => 'Remove Zsite logo', 'alert' => $lang->visual->editPowerBy);
$lang->visual->setting->company                            = array('name' => "Company Introduction", 'actions' => array());
$lang->visual->setting->company['actions']['edit']         = array('text' => 'Edit Company Introduction');
$lang->visual->setting->companyName                        = array('name' => "Company Name");
$lang->visual->setting->companyDesc                        = array('name' => "Company Introduction");
$lang->visual->setting->companyContact                     = array('name' => "Contact");
$lang->visual->setting->links                              = array('name' => "Links");
$lang->visual->setting->navbar                             = array('name' => "Menu");
$lang->visual->setting->carousel                           = array();
$lang->visual->setting->carousel['groupActions']           = array();
$lang->visual->setting->carousel['groupActions']['add']    = array('text' => 'Add slide');
$lang->visual->setting->carousel['itemActions']            = array();
$lang->visual->setting->carousel['itemActions']['edit']    = array('text' => 'Edit', 'title' => 'Edit a slide');
$lang->visual->setting->carousel['itemActions']['delete']  = array('text' => 'Delete this one', 'confirm' => 'Do you want to delete this slide?');
$lang->visual->setting->carousel['itemActions']['up']      = array('text' => 'Play forward to {0}');
$lang->visual->setting->carousel['itemActions']['down']    = array('text' => 'Play backward to {0}');
$lang->visual->setting->block                              = array('name' => "Widget", 'actions' => array());
$lang->visual->setting->block['actions']['delete']         = array('confirm' => 'Do you want to remove {title}?', 'success' => '{title} has been removed.'); 
$lang->visual->setting->block['actions']['layout']         = array('text' => 'Change Layout', 'success' => 'Layout has been saved.');
$lang->visual->setting->block['actions']['add']            = array('title' => 'Add Widget to 【{title}】');
$lang->visual->setting->block['actions']['create']         = array('title' => 'Add Widget');
$lang->visual->setting->columns                            = array('name' => "Column Settings", 'actions' => array());
$lang->visual->setting->columns['actions']['edit']         = array('title' => "Sidebar Settings", 'text' => "Sidebar Settings");
$lang->visual->setting->article                            = array('name' => 'Article');
$lang->visual->setting->articles                           = array('name' => 'Article list', 'actions' => array());
$lang->visual->setting->articles['actions']['add']         = array('text' => 'Post Article');
$lang->visual->setting->page                               = array('name' => 'Page');
$lang->visual->setting->pageList                           = array('name' => 'Page list', 'actions' => array());
$lang->visual->setting->pageList['actions']['add']         = array('text' => 'Publish Page');
$lang->visual->setting->blog                               = array('name' => 'Blog');
$lang->visual->setting->blogList                           = array('name' => 'Blog list', 'actions' => array());
$lang->visual->setting->blogList['actions']['add']         = array('text' => 'Post Blog');
$lang->visual->setting->product                            = array('name' => 'Product');
$lang->visual->setting->products                           = array('name' => 'Product list', 'actions' => array());
$lang->visual->setting->products['actions']['add']         = array('text' => 'Publish Product');
$lang->visual->setting->books                              = array('name' => 'Book List', 'actions' => array());
$lang->visual->setting->books['actions']['add']            = array('text' => 'Add Book');
$lang->visual->setting->bookCatalog                        = array('name' => "Book Content");
$lang->visual->setting->book                               = array('name' => "Book");
$lang->visual->setting->boards                             = array('name' => 'Board', 'actions' => array());
$lang->visual->setting->boards['actions']['add']           = array('text' => 'Board Admin');
$lang->visual->setting->thread                             = array('name' => 'Thread', 'actions' => array());
$lang->visual->setting->thread['actions']['edit']          = array('text' => 'Transfer');

$lang->visual->design                 = new stdclass();
$lang->visual->design->pageTemplate   = 'Page Template';
$lang->visual->design->currentTheme   = 'Current Theme:';
$lang->visual->design->layout         = 'Layout';
$lang->visual->design->block          = 'Block';
$lang->visual->design->skin           = 'Skin';
$lang->visual->design->code           = 'Code';
$lang->visual->design->hidePageTmpl   = 'Toggle show/hide Page Template Menu';
$lang->visual->design->dragAndAdd     = 'Drag and Drop to Add Block';
$lang->visual->design->noBlockTip     = 'No block in this category.';
$lang->visual->design->setColumns     = 'Set Columns';

$lang->visual->design->placeholders                = array();
$lang->visual->design->placeholders['main']        = 'Main Content';
$lang->visual->design->placeholders['page_header'] = 'Page Header';
$lang->visual->design->placeholders['page_footer'] = 'Page Footer';
$lang->visual->design->placeholders['breadcrumb']  = 'Breadcrumb Menu';
$lang->visual->design->placeholders['article']     = 'Article Content';
$lang->visual->design->placeholders['category']    = 'Category Content';
