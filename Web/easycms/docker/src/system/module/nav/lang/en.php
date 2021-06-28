<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The common simplified chinese file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      DaiTingting 
 * @package     chanzhiEPS
 * @version     $Id$
 * @link        http://www.zentao.net
 */
$lang->nav->common   = 'Naviagtion';
$lang->nav->setNav   = 'Settings';
$lang->nav->add      = 'Add Navigation';
$lang->nav->addChild = 'Add Child';
$lang->nav->delete   = 'Delete';

$lang->nav->inputUrl        = 'Enter a Link';
$lang->nav->inputTitle      = 'Enter a Title';
$lang->nav->cannotRemoveAll = 'Cannot remove all';

/* nav show all some type. */
$lang->nav->all['blog']    = 'All blog';
$lang->nav->all['article'] = 'All article';
$lang->nav->all['product'] = 'All product';
$lang->nav->all['custom']  = 'Custom';

/* nav type   */
$lang->nav->types['system']  = 'System Module';
$lang->nav->types['article'] = 'Article Category';
$lang->nav->types['blog']    = 'Blog Category';
$lang->nav->types['product'] = 'Product Category';
$lang->nav->types['page']    = 'Page';
$lang->nav->types['custom']  = 'Custom';

/* common navs.*/
$lang->nav->system = new stdclass();
$lang->nav->system->home    = 'Home';
$lang->nav->system->company = 'About Us';
$lang->nav->system->contact = 'Contact Us';
$lang->nav->system->forum   = 'Forum';
$lang->nav->system->blog    = 'Blog';
$lang->nav->system->book    = 'Book';
$lang->nav->system->message = 'Message';

$lang->nav->desktop        = 'Desktop Top';
$lang->nav->desktop_blog   = 'Blog';
$lang->nav->mobile_top     = 'Mobile Top';
$lang->nav->mobile_bottom  = 'Mobile Bottom';
$lang->nav->mobile_blog    = 'Mobile Blog';

/* Targets setting. */
$lang->nav->targetList = array();
$lang->nav->targetList['_self']  = 'Active Window';
$lang->nav->targetList['_blank'] = 'New Window';
$lang->nav->targetList['modal']  = 'Popout Window';

$lang->nav->dropdown = array();
$lang->nav->dropdown['dropdown']        = 'dropdown';
$lang->nav->dropdown['dropdown-hover']  = 'dropdownHover';
