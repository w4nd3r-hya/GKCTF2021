<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of article module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class article extends control
{
    /** 
     * The index page, locate to the first category or home page if no category.
     * 
     * @access public
     * @return void
     */
    public function index()
    {   
        $category = $this->loadModel('tree')->getFirst('article');
        if($category) $this->locate(inlink('browse', "category=$category->id", array('category' => $category->alias)));
        $this->locate($this->createLink('index'));
    }   

    /** 
     * Browse article in front.
     * 
     * @param int    $categoryID   the category id
     * @param int    $pageID       current page id
     * @access public
     * @return void
     */
    public function browse($categoryID = 0, $pageID = 1)
    {   
        $category = $this->loadModel('tree')->getByID($categoryID, 'article');
        if(!$category) die($this->fetch('errors', 'index'));

        $categoryID = is_numeric($categoryID) ? $categoryID : zget($category, 'id', 0);
        $this->session->set('articleCategory', $categoryID);

        if($category && $category->link) helper::header301($category->link);

        $orderBy = isset($_COOKIE['articleOrderBy'][$categoryID]) ? $_COOKIE['articleOrderBy'][$categoryID] : 'addedDate_desc';
        if($this->app->clientDevice == 'desktop')
        {
            $recPerPage = !empty($this->config->site->articleRec) ? $this->config->site->articleRec : $this->config->article->recPerPage;
        }
        else
        {
            $recPerPage = !empty($this->config->site->articleMobileRec) ? $this->config->site->articleMobileRec : $this->config->article->recPerPage;
        }
        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal = 0, $recPerPage, $pageID);

        $families = $categoryID ? $this->tree->getFamily($categoryID, 'article') : '';
        $sticks   = $pageID > 1 ? array() : $this->article->getSticks($families, 'article');
        $articles = $this->article->getList('article', $families, $orderBy, $pager);
        $articles = $sticks + $articles;

        if(commonModel::isAvailable('message')) $articles = $this->article->computeComments($articles, 'article');

        $articleList = '';
        foreach($articles as $article) $articleList .= $article->id . ',';
        $this->view->articleList = $articleList;
        
        $this->view->title      = $category->name;
        $this->view->keywords   = trim($category->keywords);
        $this->view->desc       = strip_tags($category->desc);
        $this->view->category   = $category;
        $this->view->articles   = $articles;
        $this->view->sticks     = $sticks;
        $this->view->pager      = $pager;
        $this->view->pageID     = $pageID;
        $this->view->orderBy    = $orderBy;
        $this->view->contact    = $this->loadModel('company')->getContact();
        $this->view->mobileURL  = helper::createLink('article', 'browse', "categoryID={$category->id}", "category={$category->alias}", 'mhtml');
        $this->view->desktopURL = helper::createLink('article', 'browse', "categoryID={$category->id}", "category={$category->alias}", 'html');
        $this->view->layouts    = $this->loadModel('block')->getPageBlocks('article', 'browse', $category->id);
        $this->view->sideGrid   = $this->loadModel('ui')->getThemeSetting('sideGrid', 3);
        $this->view->sideFloat  = $this->ui->getThemeSetting('sideFloat', 'right');
    
        $this->display();
    }
    
    /**
     * Browse article in admin.
     * 
     * @param  string $type        the article type
     * @param  int    $categoryID  the category id
     * @param  int    $recTotal 
     * @param  int    $recPerPage 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function admin($type = 'article', $categoryID = '', $orderBy = 'id_desc', $recTotal = 0, $recPerPage = 15, $pageID = 1)
    {
        if($this->get->tab == 'user') 
        {
            $type = 'submission';
            $this->lang->menuGroups->article = $type;
            $this->view->title = $this->lang->submission->common;
        }
        else
        {
            $this->lang->menuGroups->article = $type;
            $this->view->title = $this->lang->$type->common;
        }

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $families = $categoryID ? $this->loadModel('tree')->getFamily($categoryID, $type) : '';
        $sticks   = $this->get->tab != 'feedback' ? $this->article->getSticks($families, $type) : array();
        $articles = $this->article->getList($type, $families, $orderBy, $pager);
        $articles = $sticks + $articles;

        if($type != 'page' and $type != 'submission') 
        {
            $this->view->treeModuleMenu = $this->loadModel('tree')->getTreeMenu($type, 0, array('treeModel', 'createAdminLink'));
            $this->view->treeManageLink = html::a(helper::createLink('tree', 'browse', "type={$type}"), $this->lang->tree->manage);
        }

        $this->loadModel('block');

        $this->view->type       = $type;
        $this->view->categoryID = $categoryID;
        $this->view->articles   = $articles;
        $this->view->sticks     = $sticks;
        $this->view->pager      = $pager;
        $this->view->orderBy    = $orderBy;
        $this->view->template   = $this->config->template->{$this->app->clientDevice}->name;

        $this->display();
    }   

    /**
     * Create an article.
     * 
     * @param  string $type 
     * @param  int    $categoryID
     * @access public
     * @return void
     */
    public function create($type = 'article', $categoryID = '')
    {
        $this->lang->menuGroups->article = $type;

        $categories = $this->loadModel('tree')->getOptionMenu($type, 0, $removeRoot = true);
        if(empty($categories) && $type != 'page')
        {
            $this->view->reason = isset($this->lang->article->noCategories[$type]) ? $this->lang->article->noCategories[$type] : $this->lang->article->noCategoriesTip;
            $this->view->locate = helper::createLink('tree', 'browse', "type=$type");
            $this->display('common', 'redirect');
            die();
        }

        if($_POST)
        {
            $this->article->create($type);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            if(RUN_MODE == 'front') $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate'=>inlink('submission')));

            $currentCategoryID = current($this->post->categories);
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin', "type=$type&categoryID=$currentCategoryID")));
        }

        if($type != 'page') 
        {
            $this->view->treeModuleMenu = $this->loadModel('tree')->getTreeMenu($type, 0, array('treeModel', 'createAdminLink'));
            $this->view->treeManageLink = html::a(helper::createLink('tree', 'browse', "type={$type}"), $this->lang->tree->manage);
        }
        $maxID = $this->dao->select('max(id) as maxID')->from(TABLE_ARTICLE)->fetch('maxID');

        $this->view->title           = $this->lang->{$type}->create;
        $this->view->currentCategory = $categoryID;
        $this->view->categories      = $categories ;
        $this->view->order           = $maxID + 1;
        $this->view->type            = $type;

        $this->display();
    }

    /**
     * Create an submission.
     * 
     * @param  string $type 
     * @param  int    $categoryID
     * @access public
     * @return void
     */
    public function post()
    {
        if(!commonModel::isAvailable('submission')) die();
        if($_POST)
        {
            $this->article->create('submission');
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            if(RUN_MODE == 'front') $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate'=>inlink('submission')));
        }

        $this->view->title = $this->lang->article->create;
        $this->display();
    }

    /**
     * edit an submission.
     * 
     * @param  string $type 
     * @param  int    $categoryID
     * @access public
     * @return void
     */
    public function modify($articleID)
    {
        if(!commonModel::isAvailable('submission')) die();
        $article = $this->article->getByID($articleID);

        if(RUN_MODE == 'front' and $article->addedBy != $this->app->user->account) return false;

        if($_POST)
        {
            $this->article->update($articleID, 'submission');
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('submission')));
        }

        $this->view->title   = $this->lang->article->edit;
        $this->view->article = $article;
        $this->display();
    }

    /**
     * check submission.
     * 
     * @param  int    $id 
     * @access public
     * @return void
     */
    public function check($id)
    {
        if($_POST)
        {
            $type = $this->post->type;
            $categories = '';
            if($type == 'article') $categories = $this->post->articleCategories;
            if($type == 'blog')    $categories = $this->post->blogCategories;
            if($type == 'book')    $categories = array($this->post->bookCatalogs);

            if(empty($categories))$this->send(array('result' => 'fail', 'message' => $this->lang->article->categoryEmpty));
            $result = $this->article->approve($id, $type, $categories);
            if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin', "type=submission&tab=feedback")));
        }

        unset($this->lang->article->menu);
        $this->lang->menuGroups->article = 'submission';

        $this->loadModel('book');
        $bookList = $this->book->getBookPairs();
        $bookCatalog = $this->book->getOptionMenu(key($bookList), $removeRoot = true);

        $this->view->title             = $this->lang->submission->check;
        $this->view->article           = $this->article->getByID($id);
        $this->view->articleCategories = $this->loadModel('tree')->getOptionMenu('article', 0, $removeRoot = true);
        $this->view->blogCategories    = $this->loadModel('tree')->getOptionMenu('blog', 0, $removeRoot = true);
        $this->view->bookList          = $bookList;
        $this->view->bookCatalog       = $bookCatalog;

        $this->display();
    }

    /**
     * Edit an article.
     * 
     * @param  int    $articleID 
     * @param  string $type 
     * @access public
     * @return void
     */
    public function edit($articleID, $type)
    {
        if($type == 'book')
        {
            $node = $this->dao->select('*')->from(TABLE_BOOK)->where('articleID')->eq($articleID)->fetch();
            if($node) $this->locate($this->createLink('book', 'edit', "nodeID=$node->id"));
        }

        $this->lang->menuGroups->article = $type;

        $article  = $this->article->getByID($articleID, $replaceTag = false);

        $categories = $this->loadModel('tree')->getOptionMenu($type, 0, $removeRoot = true);
        if(empty($categories) && $type != 'page')
        {
            die(js::alert($this->lang->tree->noCategories) . js::locate($this->createLink('tree', 'browse', "type=$type")));
        }

        if($_POST)
        {
            $this->article->update($articleID, $type);
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin', "type=$type")));
        }

        if($type != 'page') 
        {
            $this->view->treeModuleMenu = $this->loadModel('tree')->getTreeMenu($type, 0, array('treeModel', 'createAdminLink'));
            $this->view->treeManageLink = html::a(helper::createLink('tree', 'browse', "type={$type}"), $this->lang->tree->manage);
        }

        $this->view->title      = $this->lang->$type->edit;
        $this->view->article    = $article;
        $this->view->categories = $categories;
        $this->view->type       = $type;
        $this->display();
    }

    /**
     * View an article.
     * 
     * @param int $articleID 
     * @access public
     * @return void
     */
    public function view($articleID)
    {
        $article = $this->article->getByID($articleID);

        if(!$article) die($this->fetch('errors', 'index'));
        if($article->link) helper::header301($article->link);

        /* fetch category for display. */
        $category = array_slice($article->categories, 0, 1);
        $category = $category[0]->id;

        $currentCategory = $this->session->articleCategory;
        if($currentCategory > 0)
        {
            if(isset($article->categories[$currentCategory]))
            {
                $category = $currentCategory;  
            }
            else
            {
                foreach($article->categories as $articleCategory)
                {
                    if(strpos($articleCategory->path, $currentCategory)) $category = $articleCategory->id;
                }
            }
        }

        $category = $this->loadModel('tree')->getByID($category);
        $this->session->set('articleCategory', $category->id);

        
        $this->view->title       = $article->title . ' - ' . $category->name;
        $this->view->keywords    = trim(trim($article->keywords . ' - ' . $category->keywords), '-');
        $this->view->desc        = strip_tags($article->summary);
        $this->view->article     = $article;
        $this->view->prevAndNext = $this->article->getPrevAndNext($article, $category->id);
        $this->view->category    = $category;
        $this->view->mobileURL   = helper::createLink('article', 'view', "articleID={$article->id}", "category={$category->alias}&name={$article->alias}", 'mhtml');
        $this->view->desktopURL  = helper::createLink('article', 'view', "articleID={$article->id}", "category={$category->alias}&name={$article->alias}", 'html');

        $this->view->layouts     = $this->loadModel('block')->getPageBlocks('article', 'view', $article->id);
        $this->view->sideGrid    = $this->loadModel('ui')->getThemeSetting('sideGrid', 3);
        $this->view->sideFloat   = $this->ui->getThemeSetting('sideFloat', 'right');
        $authorInfo              = $this->loadModel('user')->getBasicInfo($article->addedBy);
        $this->view->author      = zget($authorInfo, $article->addedBy, '');

        if($this->app->clientDevice == 'desktop') 
        {
            $this->view->canonicalURL = helper::createLink('article', 'view', "articleID={$article->id}", "category={$category->alias}&name={$article->alias}", 'html'); 
        }
        else
        {
            $this->view->canonicalURL = helper::createLink('article', 'view', "articleID={$article->id}", "category={$category->alias}&name={$article->alias}", 'mhtml'); 
        }
            
        $this->display();
    }

    /**
     * Delete an article.
     * 
     * @param  int      $articleID 
     * @access public
     * @return void
     */
    public function delete($articleID)
    {
        if($this->article->delete($articleID)) $this->send(array('result' => 'success'));
        $this->send(array('result' => 'fail', 'message' => dao::getError()));
    }

    /**
     * Set css.
     * 
     * @param  int      $articleID 
     * @access public
     * @return void
     */
    public function setCss($articleID)
    {
        $article = $this->article->getByID($articleID);
        if($_POST)
        {
            if($this->article->setCss($articleID)) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title   = $this->lang->article->css;
        $this->view->article = $article;
        $this->view->modalWidth = 1000;
        $this->display();
    }


    /**
     * Set js.
     * 
     * @param  int      $articleID 
     * @access public
     * @return void
     */
    public function setJs($articleID)
    {
        $article = $this->article->getByID($articleID);
        if($_POST)
        {
            if($this->article->setJs($articleID)) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $this->view->title   = $this->lang->article->js;
        $this->view->article = $article;
        $this->display();
    }

    /**
     * Stick an article.
     * 
     * @param  int    $articleID 
     * @access public
     * @return void
     */
    public function stick($articleID)
    {
        $article = $this->article->getByID($articleID);

        if($_POST)
        {
            $data = new stdclass();
            $data->sticky    = $this->post->sticky;
            $data->stickBold = $this->post->stickBold ? $this->post->stickBold : 0;
            $data->stickTime = $this->post->stickTime;

            $this->dao->update(TABLE_ARTICLE)->data($data)->where('id')->eq($articleID)->exec();
            if(dao::isError()) $this->send(array('result' =>'fail', 'message' => dao::getError()));

            $message = $data->sticky == 0 ? $this->lang->article->successUnstick : $this->lang->article->successStick;
            $this->send(array('result' => 'success', 'message' => $message, 'locate' => inlink('admin', "type={$article->type}")));
        }

        $this->view->title   = $this->lang->article->stick;
        $this->view->article = $article;
        $this->display();
    }

    /**
     * Forward an article to blog. 
     * 
     * @param  int    $articleID 
     * @access public
     * @return void
     */
    public function forward2Blog($articleID)
    {
        if($_POST)
        {
            $result = $this->article->forward2Blog($articleID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $article = $this->article->getByID($articleID);

        $this->view->title           = $this->lang->article->forward2Blog;
        $this->view->categories      = $this->loadModel('tree')->getOptionMenu('blog', 0, $removeRoot = true);
        $this->view->articleID       = $articleID;
        $this->view->defaultPostDate = (formatTime($article->addedDate, 'Y-m-d') == date('Y-m-d')) ? date('Y-m-d H:i', strtotime('+2 day')) : helper::now();
        $this->display();
    }
    
    /**
     * Forward an article to forum. 
     * 
     * @param  int    $articleID 
     * @access public
     * @return void
     */
    public function forward2Forum($articleID)
    {
        if($_POST)
        {
            $result = $this->article->forward2Forum($articleID);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin')));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $article = $this->article->getByID($articleID);
        $parents = $this->dao->select('*')->from(TABLE_CATEGORY)->where('parent')->eq(0)->andWhere('type')->eq('forum')->fetchAll('id');

        $this->view->title           = $this->lang->article->forward2Forum;
        $this->view->parents         = array_keys($parents);
        $this->view->categories      = $this->loadModel('tree')->getOptionMenu('forum', 0, $removeRoot = true);
        $this->view->articleID       = $articleID;
        $this->view->defaultPostDate = (formatTime($article->addedDate, 'Y-m-d') == date('Y-m-d')) ? date('Y-m-d H:i', strtotime('+2 day')) : helper::now();
        $this->display();
    }

    /**
     * Manage article submission.
     * 
     * @access public
     * @return void
     */
    public function submission($orderBy = 'id_desc', $recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        if(!commonModel::isAvailable('submission')) die();
        $this->app->loadLang('user');

        $this->app->loadClass('pager', $static = true);
        $pager = new pager($recTotal, $recPerPage, $pageID);

        $articles = $this->dao->select('t1.*,t2.id as bookID')->from(TABLE_ARTICLE)->alias('t1')
            ->leftJoin(TABLE_BOOK)->alias('t2')->on('t1.id = t2.articleID')
            ->where('t1.submission')->ne(0)
            ->andWhere('t1.addedBy')->eq($this->app->user->account)
            ->orderBy('id_desc')
            ->page($pager)
            ->fetchAll('id'); 

        $this->view->title        = $this->lang->user->submission;
        $this->view->mobileTitle  = $this->lang->user->submission;
        $this->view->articles     = $articles;
        $this->view->pager        = $pager;
        $this->view->orderBy      = $orderBy;

        $this->view->mobileURL  = helper::createLink('article', 'submission', '', '', 'mhtml');
        $this->view->desktopURL = helper::createLink('article', 'submission', '', '', 'html');
        $this->display();
    }

    /**
     * Reject an article.
     * 
     * @param  int    $articleID 
     * @access public
     * @return void
     */
    public function reject($articleID)
    {
        $result = $this->article->reject($articleID);
        if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('admin', "type=submission&tab=feedback")));
    }
}
