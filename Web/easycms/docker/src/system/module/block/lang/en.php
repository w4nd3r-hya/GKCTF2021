<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The block module zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
$lang->block->common          = 'Widget';
$lang->block->id              = 'ID';
$lang->block->title           = 'Title';
$lang->block->amount          = 'Count';
$lang->block->limit           = 'Total';
$lang->block->recPerRow       = 'Per Row';
$lang->block->type            = 'Type';
$lang->block->htmlcode        = 'html';
$lang->block->phpcode         = 'php';
$lang->block->content         = 'Content';
$lang->block->moreLink        = 'Links';
$lang->block->page            = 'Page';
$lang->block->regionList      = 'Region List';
$lang->block->select          = 'Select';
$lang->block->categories      = 'Category';
$lang->block->showImage       = 'Display Image';
$lang->block->showInfo        = 'Display Presentaion';
$lang->block->infoAmount      = 'Maximum';
$lang->block->character       = 'Character';
$lang->block->maxWidth        = 'Max Width ';
$lang->block->showCategory    = 'Display Category';
$lang->block->showBoard       = 'Display Board';
$lang->block->showTime        = 'Display Time';
$lang->block->showPrice       = 'Display Price';
$lang->block->showViews       = 'Display views';
$lang->block->titleAlign      = 'Title align';
$lang->block->product         = 'Product';
$lang->block->slide           = 'Slide';
$lang->block->titleless       = 'No Title';
$lang->block->borderless      = 'No Border';
$lang->block->icon            = 'Icon';
$lang->block->padding         = 'Padding';
$lang->block->border          = 'Border';
$lang->block->grid            = 'Width';
$lang->block->probability     = 'Probability';
$lang->block->more            = 'More';
$lang->block->color           = 'Color';
$lang->block->backgroundColor = 'Background Color';
$lang->block->textColor       = 'Text Color';
$lang->block->borderColor     = 'Border Color';
$lang->block->linkColor       = 'Link Color';
$lang->block->iconColor       = 'Icon Color';
$lang->block->heading         = 'Title';
$lang->block->content         = 'Content';
$lang->block->background      = 'Background';
$lang->block->custom          = 'Custom';
$lang->block->preview         = 'Preview';
$lang->block->textExample     = 'Example: text style  <a href="###">Link</a>';
$lang->block->customStyleTip  = 'Custom color and backgroud of the block HERE';
$lang->block->style           = 'Style';
$lang->block->sort            = 'Sort';
$lang->block->class           = 'CSS Class';
$lang->block->subRegion       = 'Sub Layout';
$lang->block->currentLayout   = 'Current Layout is %s';
$lang->block->renameLayout    = 'Rename Plan';
$lang->block->planName        = 'Plan Name';
$lang->block->saveLayoutAs    = 'Copy Layout %s';
$lang->block->defaultPlan     = 'Default';
$lang->block->image           = 'Image';
$lang->block->uploadImage     = 'Upload image';
$lang->block->all             = 'All Blocks';

$lang->block->layout            = 'Layout';
$lang->block->logoPosition      = 'Logo';
$lang->block->navPosition       = 'Navigation';
$lang->block->searchbarPosition = 'Search bar';
$lang->block->sloganPosition    = 'Slogan';
$lang->block->childBlock        = 'Blocks';

$lang->block->header = new stdclass();

$lang->block->header->top         = new stdclass();
$lang->block->header->top->common = 'Header';
$lang->block->header->top->left   = 'Left';
$lang->block->header->top->center = 'Center';
$lang->block->header->top->right  = 'Right';

$lang->block->header->middle         = new stdclass();
$lang->block->header->middle->common = 'Center';
$lang->block->header->middle->left   = 'Left';
$lang->block->header->middle->center = 'Center';
$lang->block->header->middle->right  = 'Right';

$lang->block->header->bottom         = new stdclass();
$lang->block->header->bottom->common = 'Bottom';

$lang->block->header->top->leftOptions['']       = 'Hide';
$lang->block->header->top->leftOptions['slogan'] = 'Slogan';
$lang->block->header->top->leftOptions['custom'] = 'Custom';

$lang->block->header->top->rightOptions['']               = 'Hide';
$lang->block->header->top->rightOptions['login']          = 'Login/Register + Switch Language';
$lang->block->header->top->rightOptions['search']         = 'Search bar';
$lang->block->header->top->rightOptions['loginAndSearch'] = 'Login/Register Language + Search Box';
$lang->block->header->top->rightOptions['searchAndLogin'] = 'Search Box + Login/Register Language';
$lang->block->header->top->rightOptions['custom']         = 'Custom';

$lang->block->header->middle->leftOptions['']     = 'Hide';
$lang->block->header->middle->leftOptions['logo'] = 'Logo';

$lang->block->header->middle->centerOptions['']       = 'Hide';
$lang->block->header->middle->centerOptions['slogan'] = 'Slogan';
$lang->block->header->middle->centerOptions['nav']    = 'Navigation';

$lang->block->header->middle->rightOptions['']       = 'Hide';
$lang->block->header->middle->rightOptions['search'] = 'Search bar';

$lang->block->header->bottomOptions['']             = 'Hide';
$lang->block->header->bottomOptions['nav']          = 'Navigation';
$lang->block->header->bottomOptions['navAndSearch'] = 'Naviagtion + Search Box';

$lang->block->admin        = "Widget";
$lang->block->pages        = "Layout";
$lang->block->add          = "Add";
$lang->block->insertLink   = 'Insert';
$lang->block->addChild     = "Child";
$lang->block->addRandom    = "Random";
$lang->block->template     = "Template";
$lang->block->create       = 'Add';
$lang->block->browseBlocks = 'Widget';
$lang->block->browseRegion = 'Layout Settings';
$lang->block->edit         = 'Edit';
$lang->block->view         = 'View';
$lang->block->setPage      = 'Page Layout';
$lang->block->setregion    = 'Layout';
$lang->block->resetRegion  = 'Reset';
$lang->block->switchPlan   = 'Switch';
$lang->block->cloneLayout  = 'Save';
$lang->block->switchLayout = 'Switch';
$lang->block->removeLayout = 'Remove';
$lang->block->planIsUseing = 'You cannot remove a Layout in use.';
$lang->block->noInsertTip  = 'Need delete the original before insert the new one';

$lang->block->paddingTop    = 'Top';
$lang->block->paddingBottom = 'Bottom';
$lang->block->paddingLeft   = 'Left';
$lang->block->paddingRight  = 'Right';

$lang->block->placeholder                         = new stdclass();
$lang->block->placeholder->moreText               = 'Text shown at the upper right of the widget.';
$lang->block->placeholder->moreUrl                = 'Link shown at the upper right of the widget.';
$lang->block->placeholder->padding                = '0';
$lang->block->placeholder->customStyleTip         = 'Less is supported in style chart. You can use #blockID as ID selector.';
$lang->block->placeholder->desktopCustomScriptTip = 'jQuery 1.9.0 is included. You can use #blockID as ID selector.';
$lang->block->placeholder->mobileCustomScriptTip  = 'jQuery id supported. You can use #blockID as ID selector.';
$lang->block->placeholder->class                  = 'Use space as class delimitor.';
$lang->block->placeholder->reset                  = "Do you want to restore this page to unified layout settings?";

$lang->block->gridOptions[0]  = 'Auto';
$lang->block->gridOptions[6]  = '1/2';
$lang->block->gridOptions[4]  = '1/3';
$lang->block->gridOptions[8]  = '2/3';
$lang->block->gridOptions[3]  = '1/4';
$lang->block->gridOptions[9]  = '3/4';
$lang->block->gridOptions[2]  = '1/6';
$lang->block->gridOptions[10] = '5/6';
$lang->block->gridOptions[12] = '100%';

$lang->block->probabilityOptions[1] = '10%';
$lang->block->probabilityOptions[2] = '20%';
$lang->block->probabilityOptions[3] = '30%';
$lang->block->probabilityOptions[4] = '40%';
$lang->block->probabilityOptions[5] = '50%';
$lang->block->probabilityOptions[6] = '60%';
$lang->block->probabilityOptions[7] = '70%';
$lang->block->probabilityOptions[8] = '80%';
$lang->block->probabilityOptions[9] = '90%';

$lang->block->categoryList['custom']  = 'Custom Widget';
$lang->block->categoryList['article'] = 'Content';
$lang->block->categoryList['product'] = 'Product';
$lang->block->categoryList['system']  = "System";

$lang->block->pageGroupList['system']   = "System";
$lang->block->pageGroupList['content']  = 'Content';
$lang->block->pageGroupList['product']  = 'Product';
$lang->block->pageGroupList['feedback'] = 'Feedback';

$lang->block->imageSizeList['large']  = 'Large';
$lang->block->imageSizeList['middle'] = 'Medium';
$lang->block->imageSizeList['small']  = 'Small';

$lang->block->imagePositionList['left']  = 'Left';
$lang->block->imagePositionList['right'] = 'Right';

$lang->block->category                = new stdclass();
$lang->block->category->showChildren  = 'Display Subcategory';
$lang->block->category->fromCurrent   = 'Start from current category';
$lang->block->category->initialExpand = 'Expand subcategory by default';

$lang->block->category->showChildrenList[1] = 'Yes';
$lang->block->category->showChildrenList[0] = 'No';

$lang->block->category->fromCurrentList[1] = 'Yes';
$lang->block->category->fromCurrentList[0] = 'No';

$lang->block->category->initialExpandList[1] = 'Yes';
$lang->block->category->initialExpandList[0] = 'No';

$lang->block->category->showCategoryList['abbr'] = 'Abbreviation';
$lang->block->category->showCategoryList['name'] = 'Full Name';

$lang->block->slideStyle                 = 'Display Style';
$lang->block->slideStyleList['carousel'] = 'Horizontal';
$lang->block->slideStyleList['tile']     = 'Vertical';

$lang->block->navTypeList                = new stdclass();
$lang->block->navTypeList->desktop_top   = 'Desktop';
$lang->block->navTypeList->desktop_blog  = 'Blog';
$lang->block->navTypeList->mobile_top    = 'Mobile Top';
$lang->block->navTypeList->mobile_bottom = 'Mobile Bottom';
$lang->block->navTypeList->mobile_blog   = 'Mobile Blog';

$lang->block->book           = new stdclass();
$lang->block->book->showType = 'Show';

$lang->block->book->sortList['order'] = 'Order';
$lang->block->book->sortList['time']  = 'Time';

$lang->block->book->showTypeList['block'] = 'Block';
$lang->block->book->showTypeList['list']  = 'List';

$lang->block->sideGrid  = 'Sidebar Width';
$lang->block->sideFloat = 'Sidebar Position ';

$lang->block->alignList           = array();
$lang->block->alignList['left']   = 'Left';
$lang->block->alignList['middle'] = 'Middle';

$lang->block->imageTypeList           = array();
$lang->block->imageTypeList['wechat'] = 'Wechat qrcode';
$lang->block->imageTypeList['custom'] = 'Custom Image';

$lang->block->subscribe                  = new stdclass();
$lang->block->subscribe->fixInNav        = 'Fix in nav';
$lang->block->subscribe->fixInNavList    = array();
$lang->block->subscribe->fixInNavList[1] = 'Yes';
$lang->block->subscribe->fixInNavList[0] = 'No';

$lang->block->sideFloatOptions          = array();
$lang->block->sideFloatOptions['left']  = 'Left';
$lang->block->sideFloatOptions['right'] = 'Right';

$lang->block->sideGridOptions     = array();
$lang->block->sideGridOptions[6]  = '1/2';
$lang->block->sideGridOptions[4]  = '1/3';
$lang->block->sideGridOptions[8]  = '2/3';
$lang->block->sideGridOptions[3]  = '1/4';
$lang->block->sideGridOptions[9]  = '3/4';
$lang->block->sideGridOptions[2]  = '1/6';
$lang->block->sideGridOptions[10] = '5/6';
$lang->block->sideGridOptions[0]  = 'Hidden';
