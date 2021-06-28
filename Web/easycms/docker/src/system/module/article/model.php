<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of article module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     article
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class articleModel extends model
{
    /* Define submission status const.*/
    const SUBMISSION_STATUS_WAIT     = 1;
    const SUBMISSION_STATUS_APPROVED = 2;
    const SUBMISSION_STATUS_REJECTED = 3;

    /** 
     * Get an article by id.
     * 
     * @param  int      $articleID 
     * @param  bool     $replaceTag 
     * @access public
     * @return bool|object
     */
    public function getByID($articleID, $replaceTag = true)
    {   
        /* Get article self. */
        if(!is_numeric($articleID))
        {
            $article = $this->dao->select('*')->from(TABLE_ARTICLE)->where('alias')->eq($articleID)->fetch();
        }
        else
        {
            $article = $this->dao->select('*')->from(TABLE_ARTICLE)->where('id')->eq($articleID)->fetch();
        }

        if(!$article) return false;
        /* Add link to content if necessary. */
        if($replaceTag) $article->content = $this->loadModel('tag')->addLink($article->content);

        /* Get it's categories. */
        $article->categories = $this->dao->select('t2.name,t2.id,t2.alias,t2.path')
            ->from(TABLE_RELATION)->alias('t1')
            ->leftJoin(TABLE_CATEGORY)->alias('t2')->on('t1.category = t2.id')
            ->where('t1.type')->eq($article->type)
            ->andWhere('t1.id')->eq($article->id)
            ->fetchAll('id');

        /* Get article path to highlight main nav. */
        $path = '';
        foreach($article->categories as $category) $path .= $category->path;
        $article->path = explode(',', trim($path, ','));

        /* Get it's files. */
        $article->files = $this->loadModel('file')->getByObject($article->type, $articleID);
        return $article;
    }   

    /**
     * Get page by ID.
     * 
     * @param  int    $pageID 
     * @access public
     * @return void
     */
    public function getPageByID($pageID)
    {
        /* Get article self. */
        if(!is_numeric($pageID)) $page = $this->dao->select('*')->from(TABLE_ARTICLE)->where('alias')->eq($pageID)->andWhere('type')->eq('page')->fetch();
        if(is_numeric($pageID))  $page = $this->dao->select('*')->from(TABLE_ARTICLE)->where('id')->eq($pageID)->andWhere('type')->eq('page')->fetch();

        if(!$page) return false;
        
        /* Add link to content if necessary. */
        $page->content = $this->loadModel('tag')->addLink($page->content);
        
        /* Get it's files. */
        $page->files = $this->loadModel('file')->getByObject('page', $page->id);
        return $page;
    }

    /** 
     * Get article list.
     *
     * @param  string  $type 
     * @param  array   $categories 
     * @param  string  $orderBy 
     * @param  object  $pager 
     * @param  int     $limit 
     * @access public
     * @return array
     */
    public function getList($type, $categories, $orderBy, $pager = null, $limit = 0)
    {
        $searchWord = $this->get->searchWord;
        $categoryID = $this->get->categoryID;
        if($type == 'page')
        {
            $articles = $this->dao->select('*')->from(TABLE_ARTICLE)
                ->where('type')->eq('page')
                ->beginIf(defined('RUN_MODE') and RUN_MODE == 'front')
                ->andWhere('addedDate')->le(helper::now())
                ->andWhere('status')->eq('normal')
                ->fi()
                ->beginIf($searchWord)
                ->andWhere('title')->like("%{$searchWord}%")
                ->orWhere('keywords')->like("%{$searchWord}%")->andWhere('type')->eq($type)
                ->orWhere('summary')->like("%{$searchWord}%")->andWhere('type')->eq($type)
                ->orWhere('content')->like("%{$searchWord}%")->andWhere('type')->eq($type)
                ->fi()
                ->orderBy($orderBy)
                ->beginIf($limit)->limit($limit)->fi()
                ->page($pager)
                ->fetchAll('id');
        }
        elseif($type == 'submission')
        {
            $articles = $this->dao->select('*')->from(TABLE_ARTICLE)
                ->where('submission')->ne(0)
                ->beginIf(RUN_MODE == 'front')
                ->andWhere('addedBy')->eq($this->app->user->account)
                ->fi()
                ->orderBy($orderBy)
                ->beginIf($limit)->limit($limit)->fi()
                ->page($pager)
                ->fetchAll('id');
        }
        else
        {
            $articleIdList = array();
            if(!empty($categories))
            {
                /*Get articles containing the search word (use groupBy to distinct articles).  */
                $articleIdList = $this->dao->select('id')->from(TABLE_RELATION)
                    ->where('type')->eq($type)
                    ->andWhere('category')->in($categories)
                    ->fetchAll('id');
            }

            $articles = $this->dao->select('*')->from(TABLE_ARTICLE)
                ->where('type')->eq($type)
                ->beginIf(defined('RUN_MODE') and RUN_MODE == 'front')
                ->andWhere('status')->eq('normal')
                ->andWhere('addedDate')->le(helper::now())
                ->fi()
                ->beginIf(!empty($categories))->andWhere('id')->in(array_keys($articleIdList))->fi()

                ->beginIf($searchWord)
                ->andWhere('title', true)->like("%{$searchWord}%")
                ->orWhere('keywords')->like("%{$searchWord}%")
                ->orWhere('summary')->like("%{$searchWord}%")
                ->orWhere('content')->like("%{$searchWord}%")
                ->markRight(1)
                ->fi()

                ->orderBy($orderBy)
                ->page($pager)
                ->beginIf($limit)->limit($limit)->fi()
                ->fetchAll('id');
        }
        if(!$articles) return array();

        return $this->processArticleList($articles, $type);
    }

    /**
     * Get page pairs.
     * 
     * @access public
     * @return array
     */
    public function getPagePairs()
    {
        return $this->dao->select('id, title')->from(TABLE_ARTICLE)
            ->where('type')->eq('page')
            ->andWhere('addedDate')->le(helper::now())
            ->andWhere('status')->eq('normal')
            ->orderBy('id_desc')
            ->fetchPairs();
    }

    /**
     * get hot articles. 
     *
     * @param string|array    $categories
     * @param int             $count
     * @param string          $type
     * @access public
     * @return array
     */
    public function getHot($categories, $count, $type = 'article')
    {
        $family = array();
        $this->loadModel('tree');

        if(!is_array($categories)) $categories = explode(',', $categories);
        foreach($categories as $category) $family = array_merge($family, $this->tree->getFamily($category));

        return $this->getList($type, $family, 'sticky_desc, views_desc', null, $count);
    }

    /**
     * get latest articles. 
     *
     * @param string|array     $categories
     * @param int              $count
     * @param string           $type
     * @access public
     * @return array
     */
    public function getLatest($categories, $count, $type = 'article')
    {
        $family = array();
        $this->loadModel('tree');

        if(!is_array($categories)) $categories = explode(',', $categories);
        foreach($categories as $category) $family = array_merge($family, $this->tree->getFamily($category));

        $this->app->loadClass('pager', true);
        return $this->getList($type, $family, 'sticky_desc, addedDate_desc', null, $count);
    }

    /**
     * Get page list. 
     *
     * @param int              $count
     * @param string           $type
     * @access public
     * @return array
     */
    public function getPageList($count)
    {
        $this->app->loadClass('pager', true);
        return $this->getList('page', '', '`order` desc', null, $count);
    }

    /**
     * Get stick articles.
     * 
     * @param  mix    $categories 
     * @access public
     * @return array
     */
    public function getSticks($categories, $type)
    { 
        $sticks = $this->dao->select('t1.*, t2.category')->from(TABLE_ARTICLE)->alias('t1')
                ->leftJoin(TABLE_RELATION)->alias('t2')->on('t1.id = t2.id')
                ->where('t2.type')->eq($type)
                ->andWhere('t1.stickTime', true)->ge(helper::now())
                ->orWhere('t1.stickTime')->eq('0000-00-00 00:00:00')
                ->markRight(1)

                ->beginIf(defined('RUN_MODE') and RUN_MODE == 'front')
                ->andWhere('t1.addedDate')->le(helper::now())
                ->andWhere('t1.status')->eq('normal')
                ->fi()

                ->andWhere('t1.sticky', true)->eq(2)
                ->orWhere('t1.sticky', true)->eq(1)
                ->beginIf($categories)->andWhere('t2.category')->in($categories)->fi()
                ->markRight(2)

                ->orderBy('sticky_desc, addedDate_desc')
                ->fetchAll('id');

        if(!$sticks) return array();

        return $this->processArticleList($sticks, $type);
    }

    /**
     * Process article list.
     * 
     * @param  array    $articles 
     * @param  string   $type 
     * @access public
     * @return array
     */
    public function processArticleList($articles, $type)
    {
        $articleIdList = array_keys($articles);
        $categories    = $this->dao->select('t2.id, t2.name, t2.abbr, t2.alias, t1.id AS article')
            ->from(TABLE_RELATION)->alias('t1')
            ->leftJoin(TABLE_CATEGORY)->alias('t2')->on('t1.category = t2.id')
            ->where('t2.type')->eq($type)
            ->andWhere('t1.id')->in($articleIdList)
            ->fetchGroup('article', 'id');

        /* Get images for these articles. */
        $images = $this->loadModel('file')->getByObject($type, $articleIdList, $isImage = true);

         /* Assign summary, category to it's article. */
        foreach($articles as $article)
        {
            $article->summary    = empty($article->summary) ? helper::substr(strip_tags($article->content), 200, '...') : $article->summary;
            $article->categories = isset($categories[$article->id]) ? $categories[$article->id] : array();
            $article->category   = current($article->categories);
        }

        $articles = $this->loadModel('file')->processImages($articles, $type);

        return $articles;
    }

    /**
     * Compute comments of an article list.
     * 
     * @param  array    $articles 
     * @param  string   $type
     * @access public
     * @return array
     */
    public function computeComments($articles, $type = 'article')
    {
        if(empty($articles)) return $articles;
        if(!commonModel::isAvailable('message')) return $articles;
        $articleIdList = array_keys($articles);

        $comments = $this->dao->select("objectID, count(id) as count")->from(TABLE_MESSAGE)
            ->where('type')->eq('comment')
            ->andWhere('objectType')->eq($type)
            ->andWhere('objectID')->in($articleIdList)
            ->andWhere('status')->eq(1)
            ->groupBy('objectID')
            ->fetchPairs('objectID', 'count');

        foreach($articles as $article)
        {
            $article->comments = isset($comments[$article->id]) ? $comments[$article->id] : 0;
        }

        return $articles;
    }

    /**
     * Get the prev and next article.
     * 
     * @param  int    $current  the current article id.
     * @param  int    $category the category id.
     * @access public
     * @return array
     */
    public function getPrevAndNext($current, $category)
    {
        $prev = $this->dao->select('t1.id, title, alias')->from(TABLE_ARTICLE)->alias('t1')
           ->leftJoin(TABLE_RELATION)->alias('t2')->on('t1.id = t2.id')
           ->where('t2.category')->eq($category)
           ->andWhere('t1.status')->eq('normal')
           ->andWhere('t1.addedDate')->lt($current->addedDate)
           ->orWhere('t1.addedDate', true)->eq($current->addedDate)
           ->andWhere('t1.id')->lt($current->id)
           ->markRight(1)
           ->orderBy('addedDate_desc, id_desc')
           ->limit(1)
           ->fetch();

       $next = $this->dao->select('t1.id, title, alias')->from(TABLE_ARTICLE)->alias('t1')
           ->leftJoin(TABLE_RELATION)->alias('t2')->on('t1.id = t2.id')
           ->where('t2.category')->eq($category)
           ->andWhere('t1.addedDate')->le(helper::now())
           ->andWhere('t1.status')->eq('normal')
           ->andWhere('t1.addedDate')->gt($current->addedDate)
           ->orWhere('t1.addedDate', true)->eq($current->addedDate)
           ->andWhere('t1.id')->gt($current->id)
           ->markRight(1)
           ->orderBy('addedDate, id')
           ->limit(1)
           ->fetch();

        return array('prev' => $prev, 'next' => $next);
    }

    /**
     * Create an article.
     * 
     * @param  string $type 
     * @access public
     * @return int|bool
     */
    public function create($type)
    {
        $now = helper::now();

        $article = fixer::input('post')
            ->join('categories', ',')
            ->setDefault('addedDate', $now)
            ->setDefault('submission', 0)
            ->add('editedDate', $now)
            ->add('type', $type)
            ->add('addedBy', $this->app->user->account)
            ->setIF(!$this->post->isLink, 'link', '')
            ->setIF(RUN_MODE == 'front', 'submission', self::SUBMISSION_STATUS_WAIT)
            ->setIF($type == 'page' and !$this->post->onlyBody, 'onlyBody', 0)
            ->stripTags('content,link,videoLink', $this->config->allowedTags->admin)
            ->removeIF($type == 'video', 'videoLink, width, height, autoplay')
            ->get();
        if(!isset($article->categories)) $article->categories = '';

        if($type == 'submission')
        {
            $article->author = $this->app->user->account;
            if(!empty($this->app->user->nickname)) $article->author = $this->app->user->nickname;
            if(!empty($this->app->user->realname)) $article->author = $this->app->user->realname;
        }

        /* Set video */
        if($type == 'video')
        {
            if(!$this->post->videoLink)
            {
                dao::$errors['videoLink'] = sprintf($this->lang->error->notempty, $this->lang->video->link);
                return false;
            }
    
            $video = new stdclass();
            $video->link     = $this->post->videoLink;
            $video->width    = $this->post->width;
            $video->height   = $this->post->height;
            $video->autoplay = $this->post->autoplay ? true : false;
            $article->video = helper::jsonEncode($video);
        }

        $article->keywords = seo::unify($article->keywords, ',');
        if(!empty($article->alias)) $article->alias = seo::unify($article->alias, '-', true);
        $article->content = $this->rtrimContent($article->content);
    
        $this->dao->insert(TABLE_ARTICLE)
            ->data($article, $skip = 'categories,uid,isLink')
            ->autoCheck()
            ->batchCheckIF($type != 'page' and $type != 'submission' and !$this->post->isLink, $this->config->article->require->create, 'notempty')
            ->batchCheckIF($type == 'submission', $this->config->article->require->post, 'notempty')
            ->batchCheckIF($type == 'page' and !$this->post->isLink, $this->config->article->require->page, 'notempty')
            ->batchCheckIF($type != 'page' and $this->post->isLink, $this->config->article->require->link, 'notempty')
            ->batchCheckIF($type == 'page' and $this->post->isLink, $this->config->article->require->pageLink, 'notempty')
            ->batchCheckIF($type == 'video', $this->config->article->require->video, 'notempty')
            ->checkIF(($type == 'page') and $this->post->alias, 'alias', 'unique', "type='page'")
            ->exec();
        $articleID = $this->dao->lastInsertID();
        $this->loadModel('file')->updateObjectID($this->post->uid, $articleID, $type); 
        $this->file->copyFromContent($this->post->content, $articleID, $type);

        if(dao::isError()) return false;

        /* Save article keywords. */
        $this->loadModel('tag')->save($article->keywords);
        if($type != 'page' and $type != 'submission') $this->processCategories($articleID, $type, $this->post->categories);

        if($article->submission == 0)
        {
            $article = $this->getByID($articleID);
            $this->loadModel('search')->save($type, $article);
        }

        /* If article has redirect setting return without submission to baidu. */
        if(!empty($article->link)) return $articleID;

        $this->loadModel('bear');
        if(isset($this->config->bear->autoSync) and strpos($this->config->bear->autoSync, 'article') !== false)
        {
            $this->bear->submit($type, $articleID, 'realtime', 'yes');
        }

        return $articleID;
    }

    /**
     * forward an article to blog. 
     * 
     * @param  int    $articleID 
     * @access public
     * @return bool 
     */
    public function forward2Blog($articleID)
    {
        if(!commonModel::isAvailable('blog')) return false;
        $blog = $this->dao->select('*')->from(TABLE_ARTICLE)->where('alias')->eq($articleID)->fetch();
        if(!$blog) $blog = $this->dao->select('*')->from(TABLE_ARTICLE)->where('id')->eq($articleID)->fetch();

        if(!$blog) return false;
        
        $blog->source     = 'article';
        $blog->type       = 'blog';
        $blog->categories = $this->post->categories;
        $blog->copyURL    = $articleID; 
        $blog->author     = $this->app->user->account;
        $blog->addedDate  = $this->post->addedDate ? $this->post->addedDate : helper::now();
        $blog->editedDate = $blog->addedDate;
        $blog->views      = 0;
        $blog->sticky     = 0;

        $this->dao->insert(TABLE_ARTICLE)->data($blog, $skip='id,categories')->autoCheck()->batchCheck($this->config->article->require->forward2Blog, 'notempty')->exec();
        $blogID = $this->dao->lastInsertID();
        
        $files = $this->dao->select('*')->from(TABLE_FILE)->where('objectID')->eq($articleID)->andWhere('objectType')->eq('article')->fetchAll();
        foreach($files as $file)
        {
            $file->objectType = 'blog';
            $file->objectID   = $blogID;
            $file->downloads  = 0;
            $this->dao->insert(TABLE_FILE)->data($file, $skip='id')->autoCheck()->exec();
        }

        if(dao::isError()) return false;

        /* Save blog keywords. */
        $this->loadModel('tag')->save($blog->keywords);
        $this->processCategories($blogID, 'blog', $this->post->categories);

        $blog = $this->getByID($blogID);
        return $this->loadModel('search')->save('blog', $blog);
    }
    
    /**
     * Forward an article to forum. 
     * 
     * @param  int    $articleID 
     * @access public
     * @return bool 
     */
    public function forward2Forum($articleID)
    {
        if(!commonModel::isAvailable('forum')) return false;
        $article  = $this->getByID($articleID);
        $category = current($article->categories);
        $address  = $this->loadModel('common')->getSysURL() . $this->createPreviewLink($articleID);

        $thread = $this->dao->select('*')->from(TABLE_ARTICLE)->where('alias')->eq($articleID)->fetch();
        if(!$thread) $thread = $this->dao->select('title, content')->from(TABLE_ARTICLE)->where('id')->eq($articleID)->fetch();

        if(!$thread) return false;
        
        $thread->board       = $this->post->board;
        $thread->author      = $this->app->user->realname;
        $thread->content    .= "<br><br><div style='text-align: right'>" . $this->lang->article->forwardFrom . ' ' . html::a($address, $address) . '</div>';
        $thread->addedDate   = $this->post->addedDate ? $this->post->addedDate : helper::now();
        $thread->editedDate  = $thread->addedDate;
        $thread->repliedDate = $thread->addedDate;

        $this->dao->insert(TABLE_THREAD)->data($thread)->autoCheck()->batchCheck($this->config->article->require->forward2Forum, 'notempty')->exec();
            
        $threadID = $this->dao->lastInsertID();
        $thread   = $this->loadModel('thread')->getByID($threadID);
        if(dao::isError()) return false;

        $files = $this->dao->select('*')->from(TABLE_FILE)->where('objectID')->eq($articleID)->andWhere('objectType')->eq('article')->fetchAll();
        foreach($files as $file)
        {
            $file->objectType = 'thread';
            $file->objectID   = $threadID;
            $this->dao->insert(TABLE_FILE)->data($file, $skip='id')->autoCheck()->exec();
        }
        if(dao::isError()) return false;

        $this->loadModel('search')->save('thread', $thread);

        return !dao::isError(); 
    }
    /**
     * Update an article.
     * 
     * @param string   $articleID 
     * @access public
     * @return void
     */
    public function update($articleID, $type = 'article')
    {
        $article  = $this->getByID($articleID);
        $category = array_keys($article->categories);

        $article = fixer::input('post')
            ->stripTags('content,link', $this->config->allowedTags->admin)
            ->join('categories', ',')
            ->add('editor', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->setIF(!$this->post->isLink, 'link', '')
            ->setIF($type == 'page' and !$this->post->onlyBody, 'onlyBody', 0)
            ->get();

        $article->keywords = seo::unify($article->keywords, ',');
        if(!empty($article->alias)) $article->alias = seo::unify($article->alias, '-', true);
        $article->content  = $this->rtrimContent($article->content);
        if(!isset($article->categories)) $article->categories = '';

        $this->dao->update(TABLE_ARTICLE)
            ->data($article, $skip = 'categories,uid,isLink')
            ->autoCheck()
            ->batchCheckIF($type == 'submission', $this->config->article->require->post, 'notempty')
            ->batchCheckIF($type != 'page' and $type != 'submission' and !$this->post->isLink, $this->config->article->require->edit, 'notempty')
            ->batchCheckIF($type == 'page' and !$this->post->isLink, $this->config->article->require->page, 'notempty')
            ->batchCheckIF($type != 'page' and $this->post->isLink, $this->config->article->require->link, 'notempty')
            ->batchCheckIF($type == 'page' and $this->post->isLink, $this->config->article->require->pageLink, 'notempty')
            ->checkIF(($type == 'page') and $this->post->alias, 'alias', 'unique', "type='page' and id<>{$articleID}")
            ->where('id')->eq($articleID)
            ->exec();

        $this->loadModel('file')->updateObjectID($this->post->uid, $articleID, $type);
        $this->file->copyFromContent($this->post->content, $articleID, $type);

        if(dao::isError()) return false;

        $this->loadModel('tag')->save($article->keywords);
        if($type != 'page' and $type != 'submission') $this->processCategories($articleID, $type, $this->post->categories);

        if(dao::isError()) return false;

        $article = $this->getByID($articleID);
        if(empty($article)) return false;
        if($type == 'submission') return true;

        return $this->loadModel('search')->save($type, $article);
    }
        
    /**
     * Delete an article.
     * 
     * @param  int      $articleID 
     * @access public
     * @return void
     */
    public function delete($articleID, $null = null)
    {
        $article = $this->getByID($articleID);
        if(!$article) return false;
        if(RUN_MODE == 'front' and $article->addedBy != $this->app->user->account) die();
        /* If this article is a submission and has been adopt, front cannot delete it.*/
        if(RUN_MODE == 'front' and $article->submission == self::SUBMISSION_STATUS_APPROVED) die();

        $this->dao->delete()->from(TABLE_RELATION)->where('id')->eq($articleID)->andWhere('type')->eq($article->type)->exec();
        $this->dao->delete()->from(TABLE_ARTICLE)->where('id')->eq($articleID)->exec();
        return $this->loadModel('search')->deleteIndex($article->type, $articleID);
    }

    /**
     * Process categories for an article.
     * 
     * @param  int    $articleID 
     * @param  string $tree
     * @param  array  $categories 
     * @access public
     * @return void
     */
    public function processCategories($articleID, $type = 'article', $categories = array())
    {
       if(!$articleID) return false;

       /* First delete all the records of current article from the releation table.  */
       $this->dao->delete()->from(TABLE_RELATION)
           ->where('type')->eq($type)
           ->andWhere('id')->eq($articleID)
           ->autoCheck()
           ->exec();

       /* Then insert the new data. */
       foreach($categories as $category)
       {
           if(!$category) continue;

           $data = new stdclass();
           $data->type     = $type; 
           $data->id       = $articleID;
           $data->category = $category;
           $this->dao->insert(TABLE_RELATION)->data($data)->exec();
       }
    }

    /**
     * Create preview link. 
     * 
     * @param  int    $articleID 
     * @param  string $viewType 
     * @param  string $articleType 
     * @access public
     * @return void
     */
    public function createPreviewLink($articleID, $viewType = '', $articleType = '')
    {
        $article = $this->getByID($articleID);
        if(empty($article)) return null;
        $module  = $article->type;
        $param   = "articleID=$articleID";
        if($article->type != 'page')
        {
            $categories    = $article->categories;
            $categoryAlias = !empty($categories) ? current($categories)->alias : '';
            $alias         = "category=$categoryAlias&name=$article->alias";
        }
        else
        {
            $alias = "name=$article->alias";
        }

        $link = commonModel::createFrontLink($module, 'view', $param, $alias, $viewType);
        if(!empty($article->link)) $link = $article->link;

        return $link;
    }

    /**
     * Delete '<p><br /></p>' if it at string's last. 
     * 
     * @param  string    $content 
     * @access public
     * @return string
     */
    public function rtrimContent($content)
    {
        /* Delete empty line such as '<p><br /></p>' if article content has it at last */
        $res   = '';
        $match = '/(\s+?<p><br \/>\s+?<\/p>)+$/';
        preg_match($match, $content, $res);
        if(isset($res[0]))
        {
            $content = substr($content, 0, strlen($content) - strlen($res[0]));
        }
        return $content;
    }

    /**
     * Set css.
     * 
     * @param  int      $articleID 
     * @access public
     * @return int
     */
    public function setCss($articleID)
    {
        $data = fixer::input('post')
            ->add('editor', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->stripTags('css', $this->config->allowedTags->admin)
            ->get();

        $this->dao->update(TABLE_ARTICLE)->data($data, $skip = 'uid')->autoCheck()->where('id')->eq($articleID)->exec();
        
        return !dao::isError();
    }

    /**
     * Set js.
     * 
     * @param  int      $articleID 
     * @access public
     * @return int
     */
    public function setJs($articleID)
    {
        $data = fixer::input('post')
            ->stripTags('js', $this->config->allowedTags->admin)
            ->add('editor', $this->app->user->account)
            ->add('editedDate', helper::now())
            ->get();

        $this->dao->update(TABLE_ARTICLE)->data($data, $skip = 'uid')->autoCheck()->where('id')->eq($articleID)->exec();
        
        return !dao::isError();
    }

    /**
     * Saving setting in config table. 
     * 
     * @access public
     * @return bool 
     */
    public function saveSetting()
    {
        $setting = new stdclass();
        $setting->submission = $this->post->submission; 
        $this->loadModel('setting')->setItems('system.common.article', $setting);
        return !dao::isError();
    }

    /**
     * Approve an submission. 
     * 
     * @param  int    $articleID 
     * @access public
     * @return void
     */
    public function approve($articleID, $type, $categories)
    {
        $article = $this->getByID($articleID);
        if($type == "book")
        {
            $this->loadModel('book');
            $parentNode = $this->book->getNodeByID($categories[0]);

            $node = new stdclass();
            $node->parent = $parentNode ? $parentNode->id : 0;
            $node->grade  = $parentNode ? $parentNode->grade + 1 : 1;

            /* First, save the child without path field. */
            $node->articleID = $articleID;
            $node->title     = $article->title;
            $node->type      = "article";
            $node->author    = $article->author;
            $node->alias     = $article->alias;
            $node->keywords  = $article->keywords;
            $node->summary   = $article->summary;
            $node->content   = $article->content;
            $node->addedDate = $article->addedDate;
            $node->order     = 0;
            $node->keywords  = seo::unify($node->keywords, ',');

            $this->dao->insert(TABLE_BOOK)->data($node)->exec();

            /* After saving, update it's path. */
            $nodeID   = $this->dao->lastInsertID();
            $nodePath = $parentNode->path . "$nodeID,";
            $this->dao->update(TABLE_BOOK)->set('path')->eq($nodePath)->set('order')->eq($nodeID)->where('id')->eq($nodeID)->exec();

            $bookArticle = $this->dao->select('*')->from(TABLE_BOOK)->where('id')->eq($nodeID)->fetch();
            $this->loadModel('search')->save("article", $bookArticle);

            $this->dao->update(TABLE_FILE)->set('objectType')->eq('book')->set('objectID')->eq($nodeID)->where('objectID')->eq($articleID)->andWhere('objectType')->eq('article')->exec();
        }
        else
        {
            $this->loadModel('search')->save($type, $article);
            $this->loadModel('file')->updateObjectType($articleID, 'submission', $type);
            $this->processCategories($articleID, $type, $categories);
        }

        $this->dao->update(TABLE_ARTICLE)->set('type')->eq($type)->set('submission')->eq(self::SUBMISSION_STATUS_APPROVED)->where('id')->eq($articleID)->exec();

        if(commonModel::isAvailable('score')) $this->loadModel('score')->earn('approveSubmission', 'article', $articleID, '', $article->addedBy);
        $this->loadModel('message')->send($this->app->user->account, $article->addedBy, sprintf($this->lang->article->approveMessage, $article->title, $this->config->score->counts->approveSubmission));

        return !dao::isError();
    }

    /**
     * Reject article.
     * 
     * @param  int    $articleID 
     * @access public
     * @return void
     */
    public function reject($articleID)
    {
        $this->dao->update(TABLE_ARTICLE)->set('submission')->eq(self::SUBMISSION_STATUS_REJECTED)->where('id')->eq($articleID)->exec();
        $article = $this->getByID($articleID);
        $this->loadModel('message')->send($this->app->user->account, $article->addedBy, sprintf($this->lang->article->rejectMessage, $article->title));

        return !dao::isError();
    }

    /**
     * Get new submission list.
     * 
     * @access public
     * @return array
     */
    public function getSubmissions($limit)
    {
        return $this->dao->select('*')->from(TABLE_ARTICLE)
            ->where('type')->eq('submission')
            ->andWhere('submission')->ne(self::SUBMISSION_STATUS_REJECTED)
            ->andWhere('editedDate')->like(date("Y-m-d") . '%')
            ->fetchAll('id');
    }
}
