<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of sitemap of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     sitemap
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class sitemap extends control
{
    /**
     * Output the sitemap.
     * 
     * @param string   $nolyBody   Only fetch body. 
     * @access public
     * @return void
     */
    public function index($onlyBody = 'no')
    {
       if($this->app->getviewType() == 'mhtml') echo $this->sitemapHTML($onlyBody);
       if($this->app->getviewType() == 'html')  echo $this->sitemapHTML($onlyBody);
       if($this->app->getviewType() == 'xml')   echo $this->sitemapXML();
    }

    /**
     * Output the sitemap.html.
     * 
     * @param string   $nolyBody   Only fetch body.  
     * @access public
     * @return void
     */
    public function sitemapHTML($onlyBody)
    {
        $this->loadModel('tree');
        $bookAndArticleList = $this->loadModel('book')->getAll();

        $this->view->articleTree  = $this->tree->getTreeMenu('article', 0, array('treeModel', 'createBrowseLink'));
        $this->view->productTree  = $this->tree->getTreeMenu('product', 0, array('treeModel', 'createProductBrowseLink'));
        $this->view->blogTree     = $this->tree->getTreeMenu('blog',    0, array('treeModel', 'createBlogBrowseLink'));
        $this->view->boards       = $this->loadModel('forum')->getBoards();
        $this->view->books        = $bookAndArticleList['book'];
        $this->view->bookArticles = $bookAndArticleList['article'];
        $this->view->pages        = $this->dao->select('id, title, alias')->from(TABLE_ARTICLE)->where('type')->eq('page')->andWhere('status')->eq('normal')->fetchAll('id');
        $this->view->articles     = $this->loadModel('article')->getList('article', $this->tree->getFamily(0, 'article'), 'id_desc');
        $this->view->products     = $this->loadModel('product')->getList(0, 'id_desc');
        $this->view->threads      = $this->loadModel('thread')->getListForSitemap();
        $this->view->onlyBody     = $onlyBody;

        foreach($this->config->sitemap->modules as $module)
        {
            if(strpos('article,blog,page,product,book,forum,thread', $module) === false and is_callable(array($this->sitemap, "show{$module}")))
            {
                $this->view->{$this->config->sitemap->valueList[$module]} = call_user_func_array(array($this->sitemap, "show{$module}"), array());
            }
        }
        $this->display();
    }

    /**
     * Output sitemap.xml.
     * 
     * @access public
     * @return void
     */
    public function sitemapXML()
    {
        $this->loadModel('tree');
        $this->loadModel('article');
        $this->loadModel('product');
        $this->loadModel('forum');
        $this->loadModel('thread');

        $bookAlias = $this->dao->select('id, alias')->from(TABLE_BOOK)->where('type')->eq('book')->fetchPairs('id', 'alias');
        $nodes     = $this->dao->select('id, title, type, path, alias, editedDate, addedDate')->from(TABLE_BOOK)->fetchAll();
        $this->loadModel('book');
        foreach($nodes as $node)
        {
            $bookID     = $this->book->extractBookID($node->path); 
            $node->book = $bookAlias[$bookID];
        }

        $articles = $this->article->getList('article', $this->tree->getFamily(0, 'article'), 'id_desc');
        $pages    = $this->dao->select('id, title, alias, editedDate')->from(TABLE_ARTICLE)->where('type')->eq('page')->andWhere('status')->eq('normal')->fetchAll('id');
        $blogs    = $this->article->getList('blog', $this->tree->getFamily(0, 'blog'), 'id_desc');
        $products = $this->product->getList($this->tree->getFamily(0, 'product'), 'id_desc');
        $board    = $this->tree->getFamily(0, 'forum');
        $threads  = $this->dao->select('id, editedDate')->from(TABLE_THREAD)->beginIf($board)->where('board')->in($board)->orderBy('id desc')->fetchPairs();

        $this->view->systemURL = commonModel::getSysURL();
        $this->view->books     = $nodes;
        $this->view->articles  = $articles;
        $this->view->blogs     = $blogs;
        $this->view->products  = $products;
        $this->view->threads   = $threads;
        $this->view->pages     = $pages;

        echo '<?xml version="1.0" encoding="UTF-8" ?>';
        $this->display();
    }
}
