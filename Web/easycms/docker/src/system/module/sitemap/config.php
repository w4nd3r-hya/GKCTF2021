<?php if(!defined("RUN_MODE")) die();?>
<?php
$config->sitemap = new stdclass();
$config->sitemap->modules = array();
$config->sitemap->modules[] = 'article';
$config->sitemap->modules[] = 'blog';
$config->sitemap->modules[] = 'page';
$config->sitemap->modules[] = 'product';
$config->sitemap->modules[] = 'book';
$config->sitemap->modules[] = 'forum';
$config->sitemap->modules[] = 'thread';

$config->sitemap->valueList = array();
