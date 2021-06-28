<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The ui module zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     ui
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->ui->common = "UI";

$lang->ui->component       = 'Component';
$lang->ui->clientDesktop   = 'Desktop';
$lang->ui->clientMobile    = 'Mobile';
$lang->ui->logo            = 'Logo';
$lang->ui->favicon         = 'Favicon';
$lang->ui->setLogo         = "Logo";
$lang->ui->setTemplate     = 'Template Settins';
$lang->ui->manageTemplate  = 'Manage Template';
$lang->ui->manageTheme     = 'Manage Theme';
$lang->ui->installTemplate = 'Import Template';
$lang->ui->exportTheme     = 'Export Theme';
$lang->ui->addTheme        = 'Add Theme';
$lang->ui->setTheme        = 'Theme Settings';
$lang->ui->setDevice       = 'Device Settings';
$lang->ui->setFavicon      = "Favicon Settings";
$lang->ui->deleteFavicon   = "Delete Favicon";
$lang->ui->deleteLogo      = "Delete Logo";
$lang->ui->others          = "Settings";
$lang->ui->productView     = "Product Clicks";
$lang->ui->viewMode        = "View Mode";
$lang->ui->QRCode          = "QR Code";
$lang->ui->execInfo        = "Operating Information";
$lang->ui->templateName    = "Template";
$lang->ui->currentTheme    = 'Current Theme';
$lang->ui->internalTheme   = 'Built-in Theme';
$lang->ui->uploadPackage   = 'Upload Theme';
$lang->ui->installTheme    = 'Install Theme';
$lang->ui->importedBlocks  = 'Import Widget';
$lang->ui->matchedBlock    = 'Match Widget';
$lang->ui->createBlock     = 'Add Widget';
$lang->ui->useOldBlock     = 'Use existing Widget';
$lang->ui->themeStore      = 'Theme Store';
$lang->ui->themeList       = 'Theme List';
$lang->ui->help            = "Help";
$lang->ui->deleteLogo      = "Delete Logo";
$lang->ui->setCode         = "Code";
$lang->ui->editTemplate    = "Edit current template";
$lang->ui->installedThemes = "Installed Themes";
$lang->ui->enableTheme     = "Apply";
$lang->ui->industry        = "Industry";
$lang->ui->byIndustry      = "By industry";
$lang->ui->offcial         = "Official";
$lang->ui->score           = "Point";
$lang->ui->reset           = "Reset";
$lang->ui->themePackage    = "Theme Package";
$lang->ui->refreshPage     = "Refresh";
$lang->ui->mobileBottomNav = 'Bottom Navigation on mobile';
$lang->ui->searchTheme     = 'Search Installed Themes';

$lang->ui->uploadLogo             = "Upload Logo";
$lang->ui->uploadFavicon          = "Upload Favicon";
$lang->ui->noStyleTag             = "Please use CSS code. No &lt;style&gt;&lt;/style&gt; tag";
$lang->ui->noJsTag                = "Please use JS code. No &lt;script&gt;&lt;/script&gt; tag";
$lang->ui->setLogoFailed          = "Failed.";
$lang->ui->noSelectedFile         = "Failed. Image size excceeds the limit.";
$lang->ui->notAlloweFileType      = "Please choose %s file.";
$lang->ui->suitableLogoSize       = 'Height %s, Width %s';
$lang->ui->faviconHelp            = "Please upload .ico file.<a href='%s' target='_blank'>HELP</a>";
$lang->ui->exportedSuccess        = 'Exported!';
$lang->ui->deleteThemeSuccess     = 'Deleted!';
$lang->ui->deleteThemeFail        = 'Failed!';
$lang->ui->fileRequired           = 'Please choose a file.';
$lang->ui->importThemeSuccess     = 'Imported!';
$lang->ui->packagePathUnwriteable = 'Upload directory %s is not writable.';
$lang->ui->selectSourceImage      = 'from Library';
$lang->ui->rebuildThumbs          = 'Rebuild Thumbnail';
$lang->ui->packagePathTip         = 'Please upload the zip file to %s, then install';
$lang->ui->gdHelp                 = 'How to install';
$lang->ui->gdTip                  = 'Image watermark features requires PHP-gd extension.';
$lang->ui->effectError            = 'Import effects fails. Check whether your effects are normal. View the address: http://www.chanzhi.org/effect';
$lang->ui->errorGetEffect         = 'Get effect failed. Please check your network and your effect. View the address: http://www.chanzhi.org/effect';
$lang->ui->deleteFaviconFail      = 'Delete %s fail.';
$lang->ui->lengthOverflow         = 'The content length is %s bytes. Keep it be <65535 bytes, or some content cannot be saved.';

$lang->ui->deviceList = new stdclass();
$lang->ui->deviceList->desktop = "<i class='icon icon-desktop'></i> Desktop";
$lang->ui->deviceList->mobile  = "<i class='icon icon-tablet'></i> Mobile";

$lang->ui->productViewList[1] = 'On';
$lang->ui->productViewList[0] = 'Off';

$lang->ui->QRCodeList[1] = 'On';
$lang->ui->QRCodeList[0] = 'Off';

$lang->ui->execInfoOptions['show'] = 'On';
$lang->ui->execInfoOptions['hide'] = 'Off';

$lang->ui->logoList['current'] = 'Current Theme';
$lang->ui->logoList['all']     = 'All Themes';

$lang->ui->deleteThemeList['blue']       = 'Default';
$lang->ui->deleteThemeList['brightdark'] = "Zsite Checks";
$lang->ui->deleteThemeList['flat']       = 'Clear';
$lang->ui->deleteThemeList['tree']       = 'Tree';
$lang->ui->deleteThemeList['colorful']   = 'Colorful';

$lang->ui->template = new stdclass();
$lang->ui->template->name            = 'Title';
$lang->ui->template->code            = 'Code';
$lang->ui->template->version         = 'Version';
$lang->ui->template->author          = 'Author';
$lang->ui->template->charge          = 'Fee';
$lang->ui->template->chanzhiVersion  = 'Compatibility';
$lang->ui->template->desc            = 'Description';
$lang->ui->template->theme           = 'Themes';
$lang->ui->template->license         = 'License';
$lang->ui->template->preview         = 'Preview';
$lang->ui->template->availableThemes = '<strong>%s</strong> themes available.';
$lang->ui->template->currentTheme    = '<strong>%s</strong> is in use.';
$lang->ui->template->changeTheme     = 'Switch';
$lang->ui->template->apply           = 'Apply';
$lang->ui->template->current         = 'Current';
$lang->ui->template->conflicts       = "Warning! Template named <strong> %s </strong> exists.";
$lang->ui->template->override        = "Override";
$lang->ui->template->reupload        = "Upload Again";
$lang->ui->template->installSuccess  = 'Congrats! Your template has been uploaded!';
$lang->ui->template->manageTemplate  = 'Manage Template';
$lang->ui->template->manageBlock     = 'Manage Widget';
$lang->ui->template->enable          = 'Activate';
$lang->ui->template->reload          = 'Refresh';
$lang->ui->template->doInstall       = 'Confirm Installation';
$lang->ui->template->info            = 'Template Info';
$lang->ui->template->demo            = 'Demo';
$lang->ui->template->qq              = 'QQ';
$lang->ui->template->email           = 'Email';
$lang->ui->template->site            = 'Site';

$lang->ui->appearance      = 'Appearance';
$lang->ui->custom          = 'Customize';
$lang->ui->themeSaved      = 'Theme saved!';
$lang->ui->unWritable      = "File cannot be created. Please check the privilege of %s.";
$lang->ui->codeHolder      = "Theme ID, a combination of numbers and letter.";
$lang->ui->unWritableFile  = "Fail to generate the css file, please check the privilege of %s";
$lang->ui->openMobileTemplate = "Do you want to switch on mobile template？";

$lang->ui->blocks2Merge  = "Widgets can be merged";
$lang->ui->blocks2Create = "New";

$lang->ui->theme = new stdclass();
$lang->ui->theme->reset                                = 'Set as Default';
$lang->ui->theme->upgrade                              = 'Upgrade';
$lang->ui->theme->installed                            = 'Installed';
$lang->ui->theme->online                               = 'Online Themes';
$lang->ui->theme->default                              = 'Default';
$lang->ui->theme->all                                  = 'All';
$lang->ui->theme->noTheme                              = 'No themes under this category';
$lang->ui->theme->resetTip                             = 'Parameter has been reset. It will be valid once saved.';
$lang->ui->theme->sizeTip                              = 'Default unit is pixel, e.g. 1px.';
$lang->ui->theme->colorTip                             = ' e.g. red or #FFF';
$lang->ui->theme->positionTip                          = ' e.g. 100px, 50%, left, top, center';
$lang->ui->theme->backImageTip                         = 'Image address, e.g. image.jpg';
$lang->ui->theme->extraStyle                           = 'CSS';
$lang->ui->theme->extraScript                          = 'Javascript';
$lang->ui->theme->customStyleTip                       = 'Less is applicable in style sheet.';
$lang->ui->theme->customScriptTip                      = 'jQuery 1.9.0 is included.';

$lang->ui->theme->borderStyleList['none']              = 'No Border';
$lang->ui->theme->borderStyleList['solid']             = 'Solid';
$lang->ui->theme->borderStyleList['dashed']            = 'Dashed';
$lang->ui->theme->borderStyleList['dotted']            = 'Dotted';
$lang->ui->theme->borderStyleList['double']            = 'Double';

$lang->ui->theme->imageRepeatList['repeat']            = 'Default';
$lang->ui->theme->imageRepeatList['repeat']            = 'Repeated';
$lang->ui->theme->imageRepeatList['repeat-x']          = 'X axis repeated';
$lang->ui->theme->imageRepeatList['repeat-y']          = 'Y axis repeated';
$lang->ui->theme->imageRepeatList['no-repeat']         = 'No Repeat';

$lang->ui->theme->fontWeightList['inherit']            = 'Default';
$lang->ui->theme->fontWeightList['normal']               = 'Normal';
$lang->ui->theme->fontWeightList['bold']               = 'Bold';

$lang->ui->theme->fontList['inherit']                  = 'Default';
$lang->ui->theme->fontList['SimSun']                   = 'SimSun';
$lang->ui->theme->fontList['FangSong']                 = 'FangSong';
$lang->ui->theme->fontList['SimHei']                   = 'SimHei';
$lang->ui->theme->fontList['Microsoft YaHei']          = 'Microsoft YaHei';
$lang->ui->theme->fontList['Arial']                    = 'Arial';
$lang->ui->theme->fontList['Courier']                  = 'Courier';
$lang->ui->theme->fontList['Console']                  = 'Console';
$lang->ui->theme->fontList['Tahoma']                   = 'Tahoma';
$lang->ui->theme->fontList['Verdana']                  = 'Verdana';
$lang->ui->theme->fontList['ZenIcon']                  = 'Icon Font ZenIcon';

$lang->ui->theme->fontSizeList['inherit']              = 'Default';
$lang->ui->theme->fontSizeList['12px']                 = '12px';
$lang->ui->theme->fontSizeList['13px']                 = '13px';
$lang->ui->theme->fontSizeList['14px']                 = '14px';
$lang->ui->theme->fontSizeList['15px']                 = '15px';
$lang->ui->theme->fontSizeList['16px']                 = '16px';
$lang->ui->theme->fontSizeList['18px']                 = '18px';
$lang->ui->theme->fontSizeList['20px']                 = '20px';
$lang->ui->theme->fontSizeList['24px']                 = '24px';

$lang->ui->theme->navbarLayoutList['false']            = 'Normal';
$lang->ui->theme->navbarLayoutList['true']             = 'Adaptive Width';

$lang->ui->theme->sideFloatList['right']  = 'Right';
$lang->ui->theme->sideFloatList['left']   = 'Left';
$lang->ui->theme->sideFloatList['hidden'] = 'Hide';

$lang->ui->theme->sideGridList[2]        = "1/6";
$lang->ui->theme->sideGridList[3]        = "1/4";
$lang->ui->theme->sideGridList[4]        = "1/3";
$lang->ui->theme->sideGridList[6]        = "1/2";

$lang->ui->theme->underlineList['none']                = 'None';
$lang->ui->theme->underlineList['underline']           = 'Underline';

$lang->ui->theme->searchLabels = new stdclass();
$lang->ui->theme->searchLabels->sales  = 'Most Purchased';
$lang->ui->theme->searchLabels->latest = 'Latest';
$lang->ui->theme->searchLabels->hot    = 'Hot';
$lang->ui->theme->searchLabels->rand   = 'Recommended';
$lang->ui->theme->searchLabels->free   = 'Free';

$lang->ui->groups = new stdclass();
$lang->ui->groups->basic  = 'Basic';
$lang->ui->groups->navbar = 'Navigation';
$lang->ui->groups->block  = 'Widget';
$lang->ui->groups->button = 'Button';
$lang->ui->groups->header = 'Header';
$lang->ui->groups->footer = 'Footer';

$lang->ui->color          = 'Color';
$lang->ui->colorset       = 'Color';
$lang->ui->pageBackground = 'Background';
$lang->ui->pageText       = 'Text';
$lang->ui->aLink          = 'Links';
$lang->ui->aVisited       = 'Visited Links';
$lang->ui->aHover         = 'Hover Links';
$lang->ui->underline      = 'Underline';
$lang->ui->transparent    = 'Transparent';
$lang->ui->none           = 'None';

$lang->ui->layout        = 'Layout';
$lang->ui->navbar        = 'Navigation';
$lang->ui->panel         = 'Panel';
$lang->ui->menuBorder    = 'Menu Border';
$lang->ui->submenuBorder = 'Submenu Border';
$lang->ui->menuNormal    = 'Normal Menu';
$lang->ui->menuHover     = 'Hover Menu';
$lang->ui->menuActive    = 'Active Menu';
$lang->ui->submenuNormal = 'Normal Submenu';
$lang->ui->submenuHover  = 'Hover Submenu';
$lang->ui->submenuActive = 'Active Submenu';
$lang->ui->heading       = 'Title';
$lang->ui->body          = 'Body';
$lang->ui->background    = 'Background';
$lang->ui->button        = 'Button';
$lang->ui->text          = 'Text';
$lang->ui->column        = 'Column';
$lang->ui->sideFloat     = 'Float';
$lang->ui->sideGrid      = 'Grid';
$lang->ui->height        = 'Height';

$lang->ui->primaryColor    = 'Primary Color';
$lang->ui->backcolor       = 'Background Color';
$lang->ui->forecolor       = 'Foreground Color';
$lang->ui->backgroundImage = 'Image';
$lang->ui->repeat          = 'Repeat Mode';
$lang->ui->position        = 'Position';
$lang->ui->style           = 'Style';
$lang->ui->fontSize        = 'Size';
$lang->ui->fontFamily      = 'Font';
$lang->ui->fontWeight      = 'Weight';
$lang->ui->layout          = 'Layout';
$lang->ui->border          = 'Border';
$lang->ui->borderColor     = 'Border Color';
$lang->ui->borderWidth     = 'Border Width';
$lang->ui->width           = 'Width';
$lang->ui->radius          = 'Radius';
$lang->ui->linkColor       = 'Link Color';
$lang->ui->linkFontSize    = 'Link Font';
$lang->ui->default         = 'Default';
$lang->ui->primary         = 'Primary';
$lang->ui->info            = 'Info';
$lang->ui->danger          = 'Warning';
$lang->ui->warning         = 'Warning';
$lang->ui->success         = 'Success';
$lang->ui->removeDirFaild  = "<pre>%s</pre> <h4>cannot be removed. </h4><div class='text-important'>Please delete it manually, or change permissions and try it again.</div>";
$lang->ui->padding         = 'Padding';
$lang->ui->left            = 'Left';
$lang->ui->right           = 'Right';
$lang->ui->top             = 'Top';
$lang->ui->bottom          = 'Bottom';

$lang->ui->importType    = 'Import type';
$lang->js->importTip     = "Old layout data will be replaced";
$lang->js->fullImportTip = "Old article, product, layout data will be replaced and import test data";

$lang->ui->importTypes = new stdclass();
$lang->ui->importTypes->theme = 'Theme data';
$lang->ui->importTypes->full  = 'Full data';

$lang->ui->theme->encryptTip = new stdclass();
$lang->ui->theme->encryptTip->common    = 'Prompt:';
$lang->ui->theme->encryptTip->zend      = 'The theme you imported is encrypted by zend, so you have to install Zend Guard Loader to decrypt it. <a href="http://www.zsite.net/book/zsitemanual/162.html" target="_blank">Zend Guard Loader installation documentation</a>.';
$lang->ui->theme->encryptTip->ioncube   = 'The imported theme is encrypted by ioncube, so you have to install the ioncube, <a href="http://www.zsite.net/book/zsitemanual/160.html" target="_blank">ioncube extension installation documentation</a>.';
$lang->ui->theme->encryptTip->noZend    = 'You did not install the Zend Guard Loader.';
$lang->ui->theme->encryptTip->noIoncube = 'You did not install ioncube.';
$lang->ui->theme->encryptTip->none      = 'You did not have any decryption program installed.';

$lang->ui->themeColors = array();
$lang->ui->themeColors[] = 'FF2A2A';
$lang->ui->themeColors[] = 'F8F100';
$lang->ui->themeColors[] = '7AE441';
$lang->ui->themeColors[] = '0084FF';
$lang->ui->themeColors[] = 'FF63E8';
$lang->ui->themeColors[] = '964B00';
$lang->ui->themeColors[] = '7F7F7F';
$lang->ui->themeColors[] = '000000';

$lang->ui->folderList = new stdclass();
$lang->ui->folderList->common  = 'Common';
$lang->ui->folderList->index   = 'Home';
$lang->ui->folderList->block   = 'Widget';
$lang->ui->folderList->article = 'Article';
$lang->ui->folderList->product = 'Product';
$lang->ui->folderList->search  = 'Search';
$lang->ui->folderList->order   = 'Order';
$lang->ui->folderList->user    = 'User';
$lang->ui->folderList->message = 'Message';
$lang->ui->folderList->forum   = 'Forum';

$lang->ui->folderAlias = new stdclass();
$lang->ui->folderAlias->blog   = 'article';
$lang->ui->folderAlias->page   = 'article';
$lang->ui->folderAlias->thread = 'forum';
$lang->ui->folderAlias->reply  = 'forum';

$lang->ui->settingList['display']   = 'Display';
$lang->ui->settingList['browse']    = 'Browse Page';
$lang->ui->settingList['thumb']     = 'Thumb';
$lang->ui->settingList['watermark'] = 'Watermark';

$lang->ui->files = new stdclass();
$lang->ui->files->default = new stdclass();

$lang->ui->files->default->common = array();
$lang->ui->files->default->common['header.lite']  = 'header';
$lang->ui->files->default->common['header']       = 'Header';
$lang->ui->files->default->common['qrcode']       = 'QR Code';
$lang->ui->files->default->common['footer']       = 'Footer';
$lang->ui->files->default->common['header.modal'] = 'Popout Header';
$lang->ui->files->default->common['footer.modal'] = 'Popout Bottom';

$lang->ui->files->default->index = array();
$lang->ui->files->default->index['index'] = 'Home';

$lang->ui->files->default->block = array();
$lang->ui->files->default->block['about']           = 'About Us';
$lang->ui->files->default->block['articletree']     = 'Article Category';
$lang->ui->files->default->block['blogtree']        = 'Blog Category';
$lang->ui->files->default->block['contact']         = 'Contact Us';
$lang->ui->files->default->block['featuredproduct'] = 'Feature Product';
$lang->ui->files->default->block['followus']        = 'Follow Us';
$lang->ui->files->default->block['header']          = 'Header';
$lang->ui->files->default->block['header.default']  = 'Compatibilty Mode';
$lang->ui->files->default->block['header.layout']   = 'Custom Mode';
$lang->ui->files->default->block['hotarticle']      = 'Hot Article';
$lang->ui->files->default->block['hotproduct']      = 'Hot Product';
$lang->ui->files->default->block['htmlcode']        = 'HTML Code';
$lang->ui->files->default->block['html']            = 'Custom';
$lang->ui->files->default->block['latestarticle']   = 'Latest Article';
$lang->ui->files->default->block['latestblog']      = 'Latest Blog';
$lang->ui->files->default->block['latestproduct']   = 'Latest Product';
$lang->ui->files->default->block['latestthread']    = 'Latest Thread';
$lang->ui->files->default->block['links']           = 'Links';
$lang->ui->files->default->block['logo']            = 'Logos';
$lang->ui->files->default->block['nav']             = 'Navigation';
$lang->ui->files->default->block['pagelist']        = 'Pages';
$lang->ui->files->default->block['phpcode']         = 'PHP Code';
$lang->ui->files->default->block['producttree']     = 'Product Categories';
$lang->ui->files->default->block['searchbar']       = 'Search Bar';
$lang->ui->files->default->block['slide']           = 'Slides';
$lang->ui->files->default->block['slogan']          = 'Slogan';
$lang->ui->files->default->block['usermenu']        = 'Login Info';

$lang->ui->files->default->article = array();
$lang->ui->files->default->article['browse'] = 'Article';
$lang->ui->files->default->article['view']   = 'Article Details';

$lang->ui->files->default->article['blog/header'] = 'Blog Header';
$lang->ui->files->default->article['blog/index']  = 'Blog List';
$lang->ui->files->default->article['blog/view']   = 'Blog Details';
$lang->ui->files->default->article['blog/footer'] = 'Blog Bottom';

$lang->ui->files->default->article['page/view'] = 'Pages';

$lang->ui->files->default->blog = array();
$lang->ui->files->default->blog['header'] = 'Blog Header';
$lang->ui->files->default->blog['index']  = 'Blog List';
$lang->ui->files->default->blog['view']   = 'Blog Details';
$lang->ui->files->default->blog['footer'] = 'Blog Bottom';

$lang->ui->files->default->page = array();
$lang->ui->files->default->page['view'] = 'Pages';

$lang->ui->files->default->product = array();
$lang->ui->files->default->product['browse']      = 'Products';
$lang->ui->files->default->product['browse.card'] = 'View Card';
$lang->ui->files->default->product['browse.list'] = 'View List';
$lang->ui->files->default->product['view']        = 'Product Details';

$lang->ui->files->default->forum = array();
$lang->ui->files->default->forum['index'] = 'Forum Home';
$lang->ui->files->default->forum['board'] = 'Board';

$lang->ui->files->default->forum['thread/view']   = 'View Thread';
$lang->ui->files->default->forum['thread/thread'] = 'Show Thread ';
$lang->ui->files->default->forum['thread/reply']  = 'Show Reply';
$lang->ui->files->default->forum['thread/post']   = 'Post Thread';
$lang->ui->files->default->forum['reply/reply']   = 'Reply List';

$lang->ui->files->default->user['control']     = 'Dashboard';
$lang->ui->files->default->user['side']        = 'Menu';
$lang->ui->files->default->user['deny']        = 'Access denied';
$lang->ui->files->default->user['edit']        = 'Edit';
$lang->ui->files->default->user['login.front'] = 'Login';
$lang->ui->files->default->user['message']     = 'Messages';
$lang->ui->files->default->user['profile']     = 'Profile';
$lang->ui->files->default->user['register']    = 'Register';
$lang->ui->files->default->user['score']       = 'Points';
$lang->ui->files->default->user['thread']      = 'Threads';

$lang->ui->files->default->order['browse']        = 'My Order';
$lang->ui->files->default->order['check']         = 'Chechout';
$lang->ui->files->default->order['confirm']       = 'Order Confirmation';
$lang->ui->files->default->order['processorder']  = 'Payment';
$lang->ui->files->default->order['track']         = 'Tracking';

$lang->ui->files->default->message['index']       = 'Message Home';
$lang->ui->files->default->message['comment']     = 'Comments';

$lang->ui->files->default->search['index']        = 'Search Results';

$lang->ui->files->mobile = $lang->ui->files->default;

unset($this->lang->ui->files->mobile->common['qrcode']);
unset($this->lang->ui->files->mobile->common['header.modal']);
unset($this->lang->ui->files->mobile->common['footer.modal']);
unset($this->lang->ui->files->mobile->block['header']);
unset($this->lang->ui->files->mobile->block['header.default']);
unset($this->lang->ui->files->mobile->block['logo']);
unset($this->lang->ui->files->mobile->block['nav']);
unset($this->lang->ui->files->mobile->block['searchbar']);
unset($this->lang->ui->files->mobile->block['slogan']);
unset($this->lang->ui->files->mobile->block['usermenu']);
unset($this->lang->ui->files->mobile->product['browse.card']);
unset($this->lang->ui->files->mobile->product['browse.list']);
unset($this->lang->ui->files->mobile->forum['reply/reply']);

if(!isset($lang->effect)) $lang->effect = new stdclass();

$lang->effect->common      = 'Effect';
$lang->effect->category    = 'Category';
$lang->effect->name        = 'Name';
$lang->effect->account     = 'Designer';
$lang->effect->desc        = 'Description';
$lang->effect->score       = 'Points';
$lang->effect->content     = 'Code';
$lang->effect->image       = 'Image';
$lang->effect->package     = 'Package';
$lang->effect->status      = 'Status';
$lang->effect->views       = 'Views';
$lang->effect->downloads   = 'Download';
$lang->effect->createdTime = 'Created On';

$lang->effect->admin         = 'Manage effect';
$lang->effect->import        = 'Import';
$lang->effect->blockName     = 'Name';
$lang->effect->newBlock      = 'Import Widget';
$lang->effect->obtan         = 'Get effect';
$lang->effect->imported      = 'Imported';
$lang->effect->importSuccess = 'Imported';
$lang->effect->noEffect      = '<code>%s</code> cannot be written! Please check the directory permissions, or it cannot be imported';
$lang->effect->noWritable    = '<code>%s</code> cannot be written! Please check the directory permissions, or it cannot be imported';
$lang->effect->bindCommunity = 'Please bind the account of Zsite before get effect';
$lang->effect->noRsults      = "You have no effect. Login Zsite <a href='http://www.zsite.net/effect.html' target='_blank'>get effect</a>。";
$lang->effect->redirecting   = "<span class='text-muted'><span id='countDown'>3</span> seconds. Redirecting to the community page...</span> <a class='btn-redirec' href='%s'><i class='icon icon-hand-right'></i>Link</a>";
