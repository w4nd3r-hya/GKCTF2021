<?php if(!defined("RUN_MODE")) die();?>
<?php
$config->block->allowedTags = $config->allowedTags->admin . '<script><style><object><param><embed><form><button><textarea>';
$config->block->wxmlTypes   = "header,slide,about,contact,html,htmlcode,latestArticle,hotArticle,latestBlog,pageList,latestProduct,hotProduct,featuredProduct,";

$config->block->editor = new stdclass();
$config->block->editor->create    = array('id' => 'content', 'tools' => 'full');
$config->block->editor->edit      = array('id' => 'content', 'tools' => 'full');
$config->block->editor->blockform = array('id' => "params\[topLeftContent\]", 'tools' => 'simple');

$config->block->require = new stdclass();
$config->block->require->create = 'title, template';
$config->block->require->edit   = 'title';

$config->block->categoryList = new stdclass();
$config->block->categoryList->custom  = ',html,htmlcode,phpcode,baidustat,tabs,';
$config->block->categoryList->article = ',latestArticle,hotArticle,latestBlog,latestThread,pageList,articleTree,blogTree,latestBook,';
$config->block->categoryList->product = ',latestProduct,hotProduct,featuredProduct,productTree,';
$config->block->categoryList->system  = ',contact,message,followUs,about,links,slide,header,bottomNav,subscribe,login,';

$config->block->pageGroupList = new stdclass();
$config->block->pageGroupList->system   = array('all', 'index_index', 'company_index', 'page_view');
$config->block->pageGroupList->content  = array('article_browse', 'article_view', 'blog_index', 'blog_view');
$config->block->pageGroupList->product  = array('product_browse', 'product_view', 'book_browse', 'book_read');
$config->block->pageGroupList->feedback = array('forum_index', 'forum_board', 'thread_view', 'message_index');

$config->block->defaultIcons = array();
$config->block->defaultIcons['about']         = 'icon-group';
$config->block->defaultIcons['html']          = '';
$config->block->defaultIcons['group']         = '';
$config->block->defaultIcons['contact']       = 'icon-phone';
$config->block->defaultIcons['followUs']      = 'icon-weixin';
$config->block->defaultIcons['links']         = 'icon-link';
$config->block->defaultIcons['login']         = 'icon-user';

$config->block->defaultIcons['latestArticle'] = 'icon-list-ul';
$config->block->defaultIcons['hotArticle']    = 'icon-list-ul';

$config->block->defaultIcons['latestBlog']    = 'icon-list-ul';
$config->block->defaultIcons['latestThread']  = 'icon-list-ul';

$config->block->defaultIcons['latestProduct'] = 'icon-th';
$config->block->defaultIcons['hotProduct']    = 'icon-th';

$config->block->defaultIcons['pageList']      = 'icon-list-ul';

$config->block->defaultIcons['articleTree']   = 'icon-folder-close';
$config->block->defaultIcons['productTree']   = 'icon-folder-close';
$config->block->defaultIcons['blogTree']      = 'icon-folder-close';

$config->block->defaultIcons['latestBook']    = 'icon-th';

$config->block->defaultIcons['message']       = 'icon-comment-alt';

$config->block->defaultIcons['bottomNav'] = '';

$config->block->defaultMoreUrl['html']          = '';
$config->block->defaultMoreUrl['latestArticle'] = '';
$config->block->defaultMoreUrl['hotArticle']    = '';
$config->block->defaultMoreUrl['latestProduct'] = '';
$config->block->defaultMoreUrl['hotProduct']    = '';
$config->block->defaultMoreUrl['latestThread']  = '';
$config->block->defaultMoreUrl['about']         = commonModel::createFrontLink('company', 'index');
$config->block->defaultMoreUrl['contact']       = commonModel::createFrontLink('company', 'index');
