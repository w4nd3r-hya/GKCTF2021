<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of blog module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     blog
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class blog extends control
{
    /** 
     * Browse blog in front.
     * 
     * @param int    $categoryID   the category id
     * @param int    $pageID       current page id
     * @access public
     * @return void
     */
    public function index($categoryID = 0, $pageID = 1)
    {   
        $category = $this->loadModel('tree')->getByID($categoryID, 'blog');

        if($this->app->clientDevice == 'desktop')
        {
            $recPerPage = !empty($this->config->site->blogRec) ? $this->config->site->blogRec : $this->config->blog->recPerPage;
        }
        else
        {
            $recPerPage = !empty($this->config->site->blogMobileRec) ? $this->config->site->blogMobileRec : $this->config->blog->recPerPage;
        }
        $this->app->loadClass('pager', $static = true);
        $pager = new pager(0, $recPerPage, $pageID);

        $categoryID = is_numeric($categoryID) ? $categoryID : $category->id;
        $families   = $categoryID ? $this->tree->getFamily($categoryID, 'blog') : '';
        $articles   = $this->loadModel('article')->getList('blog', $families, 'addedDate_desc', $pager);
        $articles   = $this->loadModel('file')->processImages($articles, 'blog');
        if(commonModel::isAvailable('message')) $articles = $this->article->computeComments($articles, 'blog');

        $sticks = $this->article->getSticks($families, 'blog');
        $sticks = $this->file->processImages($sticks, 'blog');

        $articleIdList = '';
        $articleCategoryList = array();

        foreach($articles as $article) 
        {
            $articleIdList .= $article->id . ',';
            $articleCategoryList[] = $article->category->id;
        }

        foreach($sticks as $stick)
        {
            $articleIdList .= $stick->id . ',';
            $articleCategoryList[] = $article->category->id;
        }

        $articleCategoryList = array_unique($articleCategoryList);
        if(isset($this->config->blog->categoryLevel) and $this->config->blog->categoryLevel == 'first') 
        {
            $topCategoryList = $this->loadModel('tree')->getTopCategroyList($articleCategoryList, 'blog');
            $this->view->topCategoryList = $topCategoryList;
        }

        $this->view->title         = $this->lang->blog->common;
        $this->view->articleIdList = $articleIdList;
        $this->view->categoryID    = $categoryID;
        $this->view->articles      = $articles;
        $this->view->sticks        = $sticks;
        $this->view->pager         = $pager;
        $this->view->mobileURL     = helper::createLink('blog', 'index', "categoryID=$categoryID&pageID=$pageID", $category ? "category=$category->alias" : '', 'mhtml');
        $this->view->desktopURL    = helper::createLink('blog', 'index', "categoryID=$categoryID&pageID=$pageID", $category ? "category=$category->alias" : '', 'html');
 
        if($category)
        {
            if($category->link) helper::header301($category->link);

            $this->view->category = $category;
            $this->view->title    = $category->name;
            $this->view->keywords = trim($category->keywords);
            $this->view->desc     = strip_tags($category->desc);
            $this->session->set('articleCategory', $category->id);
            $this->view->layouts    = $this->loadModel('block')->getPageBlocks('blog', 'index', $category->id);
        }
        else
        {
            $this->session->set('articleCategory', 0);
        }

        $this->view->sideGrid   = $this->loadModel('ui')->getThemeSetting('sideGrid', 3);
        $this->view->sideFloat  = $this->ui->getThemeSetting('sideFloat', 'right');

        $this->display();
    }
    
    /**
     * View an article.
     * 
     * @param int $articleID 
     * @param int $currentCategory 
     * @access public
     * @return void
     */
    public function view($articleID, $currentCategory = 0)
    {
        $article = $this->loadModel('article')->getByID($articleID);
        if(!$article) die($this->fetch('errors', 'index'));

        if($article->link) 
        {
            $this->view->updateViewsLink = helper::createLink('article', 'updateArticleViews', "articleID=$articleID");
            helper::header301($article->link);
        }
        /* fetch category for display. */
        $category = array_slice($article->categories, 0, 1);
        $category = $category[0]->id;

        $currentCategory = $this->session->articleCategory;
        if($currentCategory > 0 && isset($article->categories[$currentCategory])) $category = $currentCategory;  
        $category = $this->loadModel('tree')->getByID($category);

        
        $this->view->title       = $article->title . ' - ' . $category->name;
        $this->view->keywords    = trim(trim($article->keywords . ' - ' . $category->keywords), '-');
        $this->view->desc        = strip_tags($article->summary);
        $this->view->article     = $article;
        $this->view->prevAndNext = $this->loadModel('article')->getPrevAndNext($article, $category->id);
        $this->view->category    = $category;
        $this->view->contact     = $this->loadModel('company')->getContact();
        $this->view->mobileURL   = helper::createLink('blog', 'view', "articleID=$articleID&currentCategory=$currentCategory", "category=$category->alias&name=$article->alias", 'mhtml');
        $this->view->desktopURL  = helper::createLink('blog', 'view', "articleID=$articleID&currentCategory=$currentCategory", "category=$category->alias&name=$article->alias", 'html');
        $this->view->layouts     = $this->loadModel('block')->getPageBlocks('blog', 'view', $article->id);
        $this->view->sideGrid    = $this->loadModel('ui')->getThemeSetting('sideGrid', 3);
        $this->view->sideFloat   = $this->ui->getThemeSetting('sideFloat', 'right');

        if($article->source == 'article')
        {
            $copyArticle = $this->article->getByID($article->copyURL);
            $copyArticleCategory = current(array_slice($copyArticle->categories, 0, 1));
            if($this->app->clientDevice == 'desktop') 
            {    
                $this->view->sourceURL = helper::createLink('article', 'view', "articleID=$copyArticle->id&categoryID=$copyArticleCategory->id", "category=$copyArticleCategory->alias&name=$copyArticle->alias", 'html');
            }
            else
            {
                $this->view->sourceURL = helper::createLink('article', 'view', "articleID=$copyArticle->id&categoryID=$copyArticleCategory->id", "category=$copyArticleCategory->alias&name=$copyArticle->alias", 'mhtml');
            } 
        }
        else
        {
            if($this->app->clientDevice == 'desktop') 
            {
                $this->view->canonicalURL = helper::createLink('article', 'view', "articleID=$$article->id&categoryID=$currentCategory", "category=$category->alias&name=$article->alias", 'html');
            }
            else
            {
                $this->view->canonicalURL = helper::createLink('article', 'view', "articleID=$$article->id&categoryID=$currentCategory", "category=$category->alias&name=$article->alias", 'mhtml');
            }
        }

        $this->view->updateViewsLink = helper::createLink('article', 'updateArticleViews', "articleID=$articleID");
        $this->display();
    }
}
