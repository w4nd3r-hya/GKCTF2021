{if(!defined("RUN_MODE"))} {!die()} {/if}
{*
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
*}
{if($onlyBody == 'no')} {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'header')} {/if}
<div class='panel'>
  <div class='panel-heading'>
    <strong><i class='icon-sitemap'></i> {!echo $lang->sitemap->common}</strong>
    <div class='panel-actions'>
      {!html::a($control->createLink('sitemap', 'index', '', '', 'xml'), '<i class="icon-code"></i> ' . $lang->sitemap->xmlVersion, "class='btn btn-primary'")}
    </div>
  </div>
  <div class='panel-body'>
    {if(commonModel::isAvailable('article'))}
    <div class='clearfix sitemap-tree'> 
      <h4>{!echo $lang->sitemap->articleList}</h4>
      <ul class='tree'>
        <li class='articleItem'>{!html::a(helper::createLink('company', 'index'), $lang->aboutUs)}</li>
        {if(!empty($pages))}
        {foreach($pages as $page)}
        <li class='articleItem'>{!html::a(helper::createLink('page', 'view', "pageID={{$page->id}}", "name={{$page->alias}}"), $page->title)}</li>
        {/foreach}
        {/if}
      </ul>
      <ul class='tree'>
        {foreach($articles as $article)}
        <li class='articleItem'>{!html::a(helper::createLink('article', 'view', "id=$article->id", "category={{$article->category->alias}}&name=$article->alias"), $article->title)}</li>
        {/foreach}
      </ul>
    </div>
    {/if}

    {if(commonModel::isAvailable('product'))}
    <div class='clearfix sitemap-tree'> 
      <h4>{!echo $lang->sitemap->productList}</h4>
      <ul class='tree'>
        {foreach($products as $product)}
        <li class='productItem'>{!html::a(helper::createLink('product', 'view', "id=$product->id", "category={{$product->category->alias}}&name=$product->alias"), $product->name)}</li>
        {/foreach}
      </ul>
    </div>
    {/if}
    
    {if(strpos($productTree, '<li>') !== false)}
    <div class='clearfix sitemap-tree'> 
      <h4>{!echo $lang->sitemap->productCategory}</h4>
      {!echo $productTree}
    </div>
    {/if}

    {if(strpos($articleTree, '<li>') !== false)}
    <div class='clearfix sitemap-tree'> 
      <h4>{!echo $lang->sitemap->articleCategory}</h4>
      {!echo $articleTree}
    </div>
    {/if}
    {if(commonModel::isAvailable('blog') && strpos($blogTree, '<li>') !== false)}
    <div class='clearfix sitemap-tree'> 
      <h4>{!echo $lang->sitemap->blogCategory}</h4>
      {!echo $blogTree}
    </div>
    {/if}

    {if(commonModel::isAvailable('forum') && $boards)}
    <div class='clearfix sitemap-tree'>
      <h4>{!echo $lang->sitemap->boards}</h4>
      <ul class='tree'>
        {foreach($boards as $parentBoard)}
        <li>
          {!echo $parentBoard->name}
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
    {if(!empty($threads))}
    <div class='clearfix sitemap-tree'>
      <h4>{!echo $lang->sitemap->threadList}</h4>
      <ul class='tree'>
        {foreach($threads as $thread)}
        <li>{!html::a(helper::createLink('thread', 'view', "id=$thread->id"), $thread->title)}</li>
        {/foreach}
      </ul>
    </div>
    {/if}
    {/if}

    {if(commonModel::isAvailable('book'))}
      {if(!empty($books))}
        <div class='clearfix sitemap-tree'>
          <h4>{!echo $lang->sitemap->books}</h4>
          <ul class='tree'>
            {foreach($books as $book)}
            <li>{!html::a(helper::createLink('book', 'browse', "nodeID=$book->id", "book={{$book->alias}}"), $book->title)}</li>
            {/foreach}
          </ul>
        </div>
      {/if}
      {if(!empty($bookArticles))}
        <div class='clearfix sitemap-tree'>
          <h4>{!echo $lang->sitemap->bookArticles}</h4>
          <ul class='tree'>
            {foreach($bookArticles as $bookArticle)}
            <li>{!html::a(helper::createLink('book', 'read', "articleID=$bookArticle->id", "book={{$bookArticle->book->alias}}&article=$bookArticle->alias"), $bookArticle->title)}</li>
            {/foreach}
          </ul>
        </div>
      {/if}
    {/if}

    {foreach($control->config->sitemap->modules as $module)}
      {if(strpos('article,blog,page,product,book,forum,thread', $module) === false and is_callable(array($control->sitemap, "show{{$module}}")))}
        {include TPL_ROOT . "sitemap/show{{$module}}.html.php"}
      {/if}
    {/foreach}
  </div>
</div>
{if($onlyBody == 'no')} {include $control->loadModel('ui')->getEffectViewFile('default', 'common', 'footer')} {/if}
