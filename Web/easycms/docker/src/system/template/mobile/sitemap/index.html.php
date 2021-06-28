{if(!defined("RUN_MODE"))} {!die()} {/if}
{*php
/**
 * The sitemap view file of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV12 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     sitemap
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
/php*}
{if($onlyBody == 'no')} {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'header')} {/if}
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class='icon-sitemap'></i> {$lang->sitemap->common}</strong>
    <div class='panel-actions pull-right'>
      {!html::a($control->createLink('sitemap', 'index', '', '', 'xml'), '<i class="icon-code"></i> ' . $lang->sitemap->xmlVersion, "class='btn primary'")}
    </div>
  </div>
  <div class='panel-body'>
    <div class='clearfix sitemap-tree'>
      <ul class='tree'>
        <li>{!html::a(helper::createLink('company', 'index'), $lang->aboutUs)}</li>
        {if(!empty($pages))}
          {foreach($pages as $page)}
            <li>{!html::a(helper::createLink('page', 'view', "pageID={{$page->id}}", "name={{$page->alias}}"), $page->title)}</li>
          {/foreach}
        {/if}
      </ul>
    </div>
    
    {if(commonModel::isAvailable('article'))}
      <div class='clearfix sitemap-tree'> 
        <h4>{$lang->sitemap->articleList}</h4>
        <ul class='tree'>
          {foreach($articles as $article)}
            <li class='articleItem'>{!html::a(helper::createLink('article', 'view', "id=$article->id", "category={{$article->category->alias}}&name=$article->alias"), $article->title)}</li>
          {/foreach}
        </ul>
      </div>
    {/if}
    
    {if(strpos($productTree, '<li>') !== false)}
      <div class='clearfix sitemap-tree'> 
        <h4>{$lang->sitemap->productCategory}</h4>
        {$productTree}
      </div>
    {/if}

    {if(strpos($articleTree, '<li>') !== false)}
      <div class='clearfix sitemap-tree'> 
        <h4>{$lang->sitemap->articleCategory}</h4>
        {$articleTree}
      </div>
    {/if}
    {if(commonModel::isAvailable('blog') && strpos($blogTree, '<li>') !== false)}
      <div class='clearfix sitemap-tree'> 
        <h4>{$lang->sitemap->blogCategory}</h4>
        {$blogTree}
      </div>
    {/if}

    {if(commonModel::isAvailable('forum') && $boards)}
      <div class='clearfix sitemap-tree'>
        <h4>{$lang->sitemap->boards}</h4>
        <ul class='tree'>
          {foreach($boards as $parentBoard)}
            <li>
              {$parentBoard->name}
              {if($parentBoard->children)}
                <ul>
                  {foreach($parentBoard->children as $child)}
                    <li>{!html::a(helper::createLink('forum', 'board', "id=$child->id", "category={{$child->alias}}"), $child->name)}</li>
                  {/foreach}
                </ul>
              {/if}
            </li>
          {/foreach}
        </ul>
      </div>
    {/if}
    {if(commonModel::isAvailable('book') && !empty($books))}
      <div class='clearfix sitemap-tree'>
        <h4>{$lang->sitemap->books}</h4>
        <ul class='tree'>
          {foreach($books as $book)}
            <li>{!html::a(helper::createLink('book', 'browse', "nodeID=$book->id", "book={{$book->alias}}"), $book->title)}</li>
          {/foreach}
        </ul>
      </div>
    {/if}
  </div>
</div>
{if($onlyBody == 'no')} {include $control->loadModel('ui')->getEffectViewFile('mobile', 'common', 'footer')} {/if}
