<?php
/**
 * The block module zh-cn file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     block
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
if(!isset($lang->block->default)) $lang->block->default = new stdclass();
$lang->block->default->typeList['html']      = 'Html widget';
$lang->block->default->typeList['htmlcode']  = 'Html code';
$lang->block->default->typeList['phpcode']   = 'php code';
$lang->block->default->typeList['baidustat'] = 'Baidu stat';
$lang->block->default->typeList['tabs']      = 'Block tabs';

$lang->block->default->typeList['latestArticle'] = 'Latest Articles';
$lang->block->default->typeList['hotArticle']    = 'Hot Articles';

$lang->block->default->typeList['latestBlog']      = 'Latest Blogs';
$lang->block->default->typeList['latestThread']    = 'Latest Threads';

$lang->block->default->typeList['latestProduct']   = 'Latest Products';
$lang->block->default->typeList['featuredProduct'] = 'Featured Products';
$lang->block->default->typeList['hotProduct']      = 'Hot Products';

$lang->block->default->typeList['pageList']        = 'Pages';

$lang->block->default->typeList['articleTree'] = 'Article Categories';
$lang->block->default->typeList['productTree'] = 'Product Categories';
$lang->block->default->typeList['blogTree']    = 'Blog Categories';

$lang->block->default->typeList['contact']   = 'Contact';
$lang->block->default->typeList['message']   = 'Message';
$lang->block->default->typeList['followUs']  = 'Follow Us';
$lang->block->default->typeList['about']     = 'About';
$lang->block->default->typeList['links']     = 'Links';
$lang->block->default->typeList['slide']     = 'Slide';
$lang->block->default->typeList['header']    = 'Header';
$lang->block->default->typeList['bottomNav'] = 'Footer Nav';
$lang->block->default->typeList['subscribe'] = 'Subscribe';
$lang->block->default->typeList['login']     = 'Login';

$lang->block->default->typeGroups = array();
$lang->block->default->typeGroups['html']     = 'input';
$lang->block->default->typeGroups['htmlcode'] = 'input';
$lang->block->default->typeGroups['phpcode']  = 'input';

$lang->block->default->typeGroups['latestArticle'] = 'article';
$lang->block->default->typeGroups['hotArticle']    = 'article';

$lang->block->default->typeGroups['latestBlog']    = 'blog';
$lang->block->default->typeGroups['latestThread']  = 'thread';

$lang->block->default->typeGroups['latestProduct']   = 'product';
$lang->block->default->typeGroups['featuredProduct'] = 'product';
$lang->block->default->typeGroups['hotProduct']      = 'product';

$lang->block->default->typeGroups['pageList']        = 'page';

$lang->block->default->typeGroups['articleTree'] = 'category';
$lang->block->default->typeGroups['productTree'] = 'category';
$lang->block->default->typeGroups['blogTree']    = 'category';

$lang->block->default->typeGroups['contact']   = 'system';
$lang->block->default->typeGroups['followUs']  = 'system';
$lang->block->default->typeGroups['about']     = 'system';
$lang->block->default->typeGroups['links']     = 'system';
$lang->block->default->typeGroups['slide']     = 'system';
$lang->block->default->typeGroups['header']    = 'system';
$lang->block->default->typeGroups['bottomNav'] = 'system';
$lang->block->default->typeGroups['subscribe'] = 'system';

$lang->block->default->pages['all']            = 'All Pages';
$lang->block->default->pages['index_index']    = 'Homepage';
$lang->block->default->pages['company_index']  = 'About Us';

$lang->block->default->pages['article_browse'] = 'Article List Pages';
$lang->block->default->pages['article_view']   = 'Article Detail Pages';

$lang->block->default->pages['product_browse'] = 'Product List Pages';
$lang->block->default->pages['product_view']   = 'Product Detail Pages';

$lang->block->default->pages['blog_index']     = 'Blog List Pages';
$lang->block->default->pages['blog_view']      = 'Blog Detail Pages';

$lang->block->default->pages['forum_index']    = 'Forum Home';
$lang->block->default->pages['forum_board']    = 'Thread List Pages';
$lang->block->default->pages['thread_view']    = 'Thread Detail Pages';
$lang->block->default->pages['search_index']   = 'Search';

$lang->block->default->pages['book_index']     = 'Book';
$lang->block->default->pages['book_browse']    = 'Book Home';
$lang->block->default->pages['book_read']      = 'Book Contents';

$lang->block->default->pages['message_index']  = 'Messages';

$lang->block->default->pages['page_view']      = 'Pages';

/* page layou>default-> list. */
if(!isset($lang->block->default->regions)) $lang->block->default->regions = new stdclass();
$lang->block->default->regions->all['header'] = 'Header';
$lang->block->default->regions->all['top']    = 'Top';
$lang->block->default->regions->all['banner'] = 'Banner';
$lang->block->default->regions->all['bottom'] = 'Bottom';
$lang->block->default->regions->all['footer'] = 'Footer';

$lang->block->default->regions->index_index['top']     = 'Top';
$lang->block->default->regions->index_index['middle']  = 'Middle';
$lang->block->default->regions->index_index['bottom']  = 'Bottom';

$lang->block->default->regions->company_index['topBanner']    = 'TopBanner';
$lang->block->default->regions->company_index['top']          = 'Top';
$lang->block->default->regions->company_index['bottom']       = 'Bottom';
$lang->block->default->regions->company_index['side']         = 'Side';
$lang->block->default->regions->company_index['bottomBanner'] = 'BottomBanner';

$lang->block->default->regions->article_browse['topBanner']    = 'TopBanner';
$lang->block->default->regions->article_browse['top']          = 'Top';
$lang->block->default->regions->article_browse['bottom']       = 'Bottom';
$lang->block->default->regions->article_browse['side']         = 'Side';
$lang->block->default->regions->article_browse['bottomBanner'] = 'BottomBanner';

$lang->block->default->regions->article_view['topBanner']    = 'TopBanner';
$lang->block->default->regions->article_view['top']          = 'Top';
$lang->block->default->regions->article_view['bottom']       = 'Bottom';
$lang->block->default->regions->article_view['side']         = 'Side';
$lang->block->default->regions->article_view['bottomBanner'] = 'BottomBanner';

$lang->block->default->regions->product_browse['topBanner']    = 'TopBanner';
$lang->block->default->regions->product_browse['top']          = 'Top';
$lang->block->default->regions->product_browse['bottom']       = 'Bottom';
$lang->block->default->regions->product_browse['side']         = 'Side';
$lang->block->default->regions->product_browse['bottomBanner'] = 'BottomBanner';

$lang->block->default->regions->product_view['topBanner']    = 'TopBanner';
$lang->block->default->regions->product_view['top']          = 'Top';
$lang->block->default->regions->product_view['bottom']       = 'Bottom';
$lang->block->default->regions->product_view['side']         = 'Side';
$lang->block->default->regions->product_view['bottomBanner'] = 'BottomBanner';

$lang->block->default->regions->blog_index['topBanner']    = 'TopBanner';
$lang->block->default->regions->blog_index['top']          = 'Top';
$lang->block->default->regions->blog_index['bottom']       = 'Bottom';
$lang->block->default->regions->blog_index['side']         = 'Side';
$lang->block->default->regions->blog_index['bottomBanner'] = 'BottomBanner';

$lang->block->default->regions->blog_view['topBanner']    = 'TopBanner';
$lang->block->default->regions->blog_view['top']          = 'Top';
$lang->block->default->regions->blog_view['bottom']       = 'Bottom';
$lang->block->default->regions->blog_view['side']         = 'Side';
$lang->block->default->regions->blog_view['bottomBanner'] = 'BottomBanner';

$lang->block->default->regions->forum_index['top']     = 'Top';
$lang->block->default->regions->forum_index['bottom']  = 'Bottom';
$lang->block->default->regions->forum_board['top']     = 'Top';
$lang->block->default->regions->forum_board['bottom']  = 'Bottom';
$lang->block->default->regions->thread_view['top']     = 'Top';
$lang->block->default->regions->thread_view['bottom']  = 'Bottom';

$lang->block->default->regions->book_browse['topBanner']    = 'TopBanner';
$lang->block->default->regions->book_browse['top']          = 'Top';
$lang->block->default->regions->book_browse['bottom']       = 'Bottom';
$lang->block->default->regions->book_browse['side']         = 'Side';
$lang->block->default->regions->book_browse['bottomBanner'] = 'BottomBanner';

$lang->block->default->regions->book_read['top']       = 'Top';
$lang->block->default->regions->book_read['bottom']    = 'Bottom';

$lang->block->default->regions->message_index['topBanner']    = 'TopBanner';
$lang->block->default->regions->message_index['top']          = 'Top';
$lang->block->default->regions->message_index['bottom']       = 'Bottom';
$lang->block->default->regions->message_index['side']         = 'Side';
$lang->block->default->regions->message_index['bottomBanner'] = 'BottomBanner';

$lang->block->default->regions->page_view['topBanner']    = 'TopBanner';
$lang->block->default->regions->page_view['top']          = 'Top';
$lang->block->default->regions->page_view['bottom']       = 'Bottom';
$lang->block->default->regions->page_view['side']         = 'Side';
$lang->block->default->regions->page_view['bottomBanner'] = 'BottomBanner';

if(!isset($lang->block->headerLayout)) $lang->block->headerLayout = new stdclass();
$lang->block->headerLayout->compatibleEnable  = 'Compatible old header';

$lang->block->headerLayout->nav = array();
$lang->block->headerLayout->nav['besideLogo'] = 'Right of logo';
$lang->block->headerLayout->nav['row']        = 'A whole row';

$lang->block->headerLayout->slogan = array();
$lang->block->headerLayout->slogan['besideLogo'] = 'Right of Logo';
$lang->block->headerLayout->slogan['topLeft']    = 'Top left';

$lang->block->headerLayout->searchbar = array();
$lang->block->headerLayout->searchbar['besideSlogan'] = 'Right of slogan';
$lang->block->headerLayout->searchbar['topRight']     = 'Top right';
$lang->block->headerLayout->searchbar['insideNav']    = 'Right of navigation';

if(!isset($lang->block->default->layout)) $lang->block->default->layout = new stdclass();

$lang->block->default->layout->all = array();
$lang->block->default->layout->all[] = array('type' => 'invisible', 'name' => 'header', 'title' => 'Head (Invisible)');
$lang->block->default->layout->all[] = array('type' => 'container', 'name' => 'top');
$lang->block->default->layout->all[] = array('type' => 'grid', 'name' => 'banner');
$lang->block->default->layout->all[] = array('type' => 'placeholder', 'name' => 'main');
$lang->block->default->layout->all[] = array('type' => 'grid', 'name' => 'bottom');
$lang->block->default->layout->all[] = array('type' => 'invisible', 'name' => 'footer', 'title' => 'Footer (Invisible)');

$lang->block->default->layout->index_index = array();
$lang->block->default->layout->index_index[] = array('type' => 'placeholder', 'name' => 'page_header');
$lang->block->default->layout->index_index[] = array('type' => 'grid', 'name' => 'top');
$lang->block->default->layout->index_index[] = array('type' => 'grid', 'name' => 'middle');
$lang->block->default->layout->index_index[] = array('type' => 'grid', 'name' => 'bottom');
$lang->block->default->layout->index_index[] = array('type' => 'placeholder', 'name' => 'page_footer');

$lang->block->default->layout->company_index = array();
$lang->block->default->layout->company_index[] = array('type' => 'placeholder', 'name' => 'page_header');
$lang->block->default->layout->company_index[] = array('type' => 'placeholder', 'name' => 'breadcrumb');
$lang->block->default->layout->company_index[] = array('type' => 'grid', 'name' => 'topBanner');
$company_index_mainColumns = array();
$company_index_mainColumn = array('type' => 'col', 'name' => 'main', 'colWidth' => '75%', 'children' => array());
$company_index_mainColumn['children'][] = array('type' => 'grid', 'name' => 'top');
$company_index_mainColumn['children'][] = array('type' => 'placeholder', 'name' => 'article');
$company_index_mainColumn['children'][] = array('type' => 'grid', 'name' => 'bottom');
$company_index_sideColumn = array('type' => 'col', 'name' => 'side', 'colWidth' => '25%', 'children' => array());
$company_index_sideColumn['children'][] = array('type' => 'container', 'name' => 'side');
$company_index_mainColumns[] = $company_index_mainColumn;
$company_index_mainColumns[] = $company_index_sideColumn;
$lang->block->default->layout->company_index[] = array('type' => 'row', 'name' => 'main', 'children' => $company_index_mainColumns);
$lang->block->default->layout->company_index[] = array('type' => 'grid', 'name' => 'bottomBanner');
$lang->block->default->layout->company_index[] = array('type' => 'placeholder', 'name' => 'page_footer');

$lang->block->default->layout->article_browse = $lang->block->default->layout->company_index;
$lang->block->default->layout->article_view = $lang->block->default->layout->company_index;
$lang->block->default->layout->product_browse = $lang->block->default->layout->company_index;
$lang->block->default->layout->product_view = $lang->block->default->layout->company_index;
$lang->block->default->layout->blog_index = $lang->block->default->layout->company_index;
$lang->block->default->layout->blog_view = $lang->block->default->layout->company_index;

$lang->block->default->layout->book_browse = array();
$lang->block->default->layout->book_browse[] = array('type' => 'placeholder', 'name' => 'page_header');
$lang->block->default->layout->book_browse[] = array('type' => 'grid', 'name' => 'topBanner');
$lang->block->default->layout->book_browse[] = array('type' => 'placeholder', 'name' => 'main', 'title' => 'Book List');
$lang->block->default->layout->book_browse[] = array('type' => 'grid', 'name' => 'bottomBanner');
$lang->block->default->layout->book_browse[] = array('type' => 'placeholder', 'name' => 'page_footer');

$lang->block->default->layout->book_read = array();
$lang->block->default->layout->book_read[] = array('type' => 'placeholder', 'name' => 'page_header');
$lang->block->default->layout->book_read[] = array('type' => 'grid', 'name' => 'top');
$lang->block->default->layout->book_read[] = array('type' => 'placeholder', 'name' => 'breadcrumb');
$book_read_mainColumns = array();
$book_read_mainColumn = array('type' => 'col', 'name' => 'main', 'colWidth' => '75%', 'children' => array());
$book_read_mainColumn['children'][] = array('type' => 'placeholder', 'name' => 'article');
$book_read_mainColumn['children'][] = array('type' => 'grid', 'name' => 'bottom');
$book_read_sideColumn = array('type' => 'col', 'name' => 'side', 'colWidth' => '25%', 'children' => array());
$book_read_sideColumn['children'][] = array('type' => 'placeholder', 'name' => 'category');
$book_read_mainColumns[] = $book_read_sideColumn;
$book_read_mainColumns[] = $book_read_mainColumn;
$lang->block->default->layout->book_read[] = array('type' => 'row', 'name' => 'main', 'children' => $book_read_mainColumns);
$lang->block->default->layout->book_read[] = array('type' => 'placeholder', 'name' => 'page_footer');

$lang->block->default->layout->forum_index = array();
$lang->block->default->layout->forum_index[] = array('type' => 'placeholder', 'name' => 'page_header');
$lang->block->default->layout->forum_index[] = array('type' => 'grid', 'name' => 'top');
$lang->block->default->layout->forum_index[] = array('type' => 'placeholder', 'name' => 'main', 'title' => 'Forum Boards');
$lang->block->default->layout->forum_index[] = array('type' => 'grid', 'name' => 'bottom');
$lang->block->default->layout->forum_index[] = array('type' => 'placeholder', 'name' => 'page_footer');

$lang->block->default->layout->forum_board = array();
$lang->block->default->layout->forum_board[] = array('type' => 'placeholder', 'name' => 'page_header');
$lang->block->default->layout->forum_board[] = array('type' => 'grid', 'name' => 'top');
$lang->block->default->layout->forum_board[] = array('type' => 'placeholder', 'name' => 'main', 'title' => 'Board Thread List');
$lang->block->default->layout->forum_board[] = array('type' => 'grid', 'name' => 'bottom');
$lang->block->default->layout->forum_board[] = array('type' => 'placeholder', 'name' => 'page_footer');

$lang->block->default->layout->thread_view = array();
$lang->block->default->layout->thread_view[] = array('type' => 'placeholder', 'name' => 'page_header');
$lang->block->default->layout->thread_view[] = array('type' => 'grid', 'name' => 'top');
$lang->block->default->layout->thread_view[] = array('type' => 'placeholder', 'name' => 'article', 'title' => 'Thread Detail');
$lang->block->default->layout->thread_view[] = array('type' => 'placeholder', 'name' => 'form', 'title' => 'Replies');
$lang->block->default->layout->thread_view[] = array('type' => 'grid', 'name' => 'bottom');
$lang->block->default->layout->thread_view[] = array('type' => 'placeholder', 'name' => 'page_footer');

$lang->block->default->layout->message_index = $lang->block->default->layout->company_index;
$lang->block->default->layout->page_view = $lang->block->default->layout->company_index;
