<?php
$config->cachePages = '';

$config->cache = new stdclass();
$config->cache->expired   = 86400;
$config->cache->cachePage = 'open';

$config->cache->type = 'file';
$config->cache->cachedPages = 'index.index,article.browse,article.view,product.browse,product.view,page.view,blog.index,blog.view,book.browse,book.index,book.read,user.login,';

$config->cache->file = new stdclass();
$config->cache->file->expired = $config->cache->expired;

$config->cache->relation = array();

$config->cache->relation[TABLE_BLOCK]['blocks'] = '/';
$config->cache->relation[TABLE_BLOCK]['pages']  = '/';

$config->cache->relation[TABLE_LAYOUT]['blocks'] = '/';
$config->cache->relation[TABLE_LAYOUT]['pages']  = '/';

$config->cache->relation[TABLE_SLIDE]['blocks'] = 'slide,';
$config->cache->relation[TABLE_SLIDE]['pages']  = '/';

$config->cache->relation[TABLE_CONFIG]['blocks'] = '/';
$config->cache->relation[TABLE_CONFIG]['pages']  = '/';

$config->cache->relation[TABLE_ARTICLE]['blocks'] = 'latestarticle,hotarticle,latestblog,pagelist,';
$config->cache->relation[TABLE_ARTICLE]['pages']  = 'article.browse,article.view,page.view,blog.index,blog.view,';

$config->cache->relation[TABLE_CATEGORY]['blocks'] = 'latestarticle,hotarticle,latestblog,pagelist,articletree,producttree,blogtree,slide,';
$config->cache->relation[TABLE_CATEGORY]['pages']  = 'article.browse,article.view,page.view,blog.index,blog.view,product.browse,index.index,';

$config->cache->relation[TABLE_PRODUCT]['blocks'] = 'latestproduct,hotproduct,featuredproduct,';
$config->cache->relation[TABLE_PRODUCT]['pages']  = 'product.browse,product.view,';

$config->cache->relation[TABLE_FILE]['blocks'] = 'latestarticle,hotarticle,latestblog,pagelist,articletree,producttree,blogtree,slide,featuredproduct,';
$config->cache->relation[TABLE_FILE]['pages']  = 'article.browse,article.view,page.view,blog.index,blog.view,product.browse,product.view,index.index,';

$config->cache->relation[TABLE_BOOK]['pages']  = 'book.browse,book.index,book.read,';

$config->cache->relation[TABLE_THREAD]['blocks'] = 'latestproduct,hotproduct,';

$config->cache->relation[TABLE_RELATION]['blocks'] = 'latestarticle,hotarticle,latestblog,pagelist,';
$config->cache->relation[TABLE_RELATION]['pages']  = '/';
