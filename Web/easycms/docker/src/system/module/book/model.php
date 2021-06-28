<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of book module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Tingting Dai <daitingting@xirangit.com>
 * @package     book
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class bookModel extends model
{
    /**
     * Get a book by id or alias.
     *
     * @param  string|int $id   the id can be the number id or the alias.
     * @access public
     * @return object
     */
    public function getBookByID($id)
    {
        if(!is_numeric($id))
        {
            return $this->dao->select('*')->from(TABLE_BOOK)->where('alias')->eq($id)->andWhere('type')->eq('book')->fetch();
        }
        else
        {
            return $this->dao->select('*')->from(TABLE_BOOK)->where('id')->eq($id)->fetch();
        }
    }

    /**
     * Get a node's book.
     * 
     * @param  object    $node 
     * @access public
     * @return object
     */
    public function getBookByNode($node)
    {
       return $this->getBookByID($this->extractBookID($node->path));
    }

    /**
     * Extract the book id from a node path.
     * 
     * @param  string    $path 
     * @access public
     * @return int
     */
    public function extractBookID($path)
    {
        $path = explode(',', trim($path, ','));
        return $path[0];
    }

    /**
     * Get the first book.
     * 
     * @access public
     * @return object|bool
     */
    public function getFirstBook()
    {
        return $this->dao->select('*')->from(TABLE_BOOK)->where('type')->eq('book')->orderBy('`order`, id')->limit(1)->fetch();
    }

    /**
     * Get book list.
     *
     * @access public
     * @return array
     */
    public function getBookList($pager = null)
    {
        $books = $this->dao->select('*')->from(TABLE_BOOK)->where('type')->eq('book')->orderBy('`order`, id')->page($pager)->fetchAll('id');
        foreach($books as $k => $book)
        {
            $book->articleAmount = $this->getArticleAmount($book->id);
            $books[$k] = $book;
        }
        return $books;
    }

    /**
     * Get article amount of book.
     *
     * @param $bookID
     * @access public
     * @return int
     */
    public function getArticleAmount($bookID)
    {
        return $this->dao->select('count(*) as amount')->from(TABLE_BOOK)
            ->where('type')->eq('article')
            ->andWhere('status')->eq('normal')
            ->andWhere('path')->like("%,{$bookID},%")
            ->fetch('amount');
    }

    /**
     * Get latest book list.
     * 
     * @param  int    $limit 
     * @param  string    $orderBy 
     * @access public
     * @return array
     */
    public function getLatestBookList($limit, $orderBy)
    {
        return $this->dao->select('*')->from(TABLE_BOOK)
            ->where('type')->eq('book')
            ->orderBy($orderBy)
            ->limit($limit)
            ->fetchAll('id');
    }

    /**
     * Get book pairs.
     *
     * @access public
     * @return array
     */
    public function getBookPairs()
    {
        return $this->dao->select('id, title')->from(TABLE_BOOK)->where('type')->eq('book')->orderBy('`order`, id')->fetchPairs();
    }

    /**
     * Get origins tree of node.
     * 
     * @param  object    $node 
     * @access public
     * @return void
     */
    public function getOriginsTree($node)
    {
        if($node->type === 'book' || empty($node->origins)) return null;

        $tree = array();

        foreach($node->origins as $originNode)
        {
            if($node->id == $originNode->id) continue;

            $subTree = array();
            $children = $this->getChildren($originNode->id);
            $subNode = new stdclass();
            foreach($children as $child)
            {
                $childNode = new stdclass();
                $childNode->id      = $child->id;
                $childNode->alias   = $child->alias;
                $childNode->title   = $child->title;
                $childNode->type    = $child->type;
                $childNode->status  = $child->status;
                $childNode->current = stripos($node->path, ',' . $child->id . ',') !== false;
                if($childNode->current) $subNode->current = $childNode;
                $subTree[] = $childNode;
            }
            
            $subNode->nodes = $subTree;
            $tree[] = $subNode;
        }
        return $tree;
    }

    /**
     * Get book catalog for front.
     * 
     * @param  int    $nodeID 
     * @access public
     * @return string
     */
    public function getFrontCatalog($nodeID, $serials)
    {
        $node = $this->getNodeByID($nodeID);
        if(!$node) return '';

        $nodeList = $this->dao->select('id,alias,type,path,`order`,parent,grade,title,link')->from(TABLE_BOOK)
            ->where('path')->like("{$node->path}%")
            ->andWhere('addedDate')->le(helper::now())
            ->andWhere('status')->eq('normal')
            ->orderBy('grade_desc,`order`, id')
            ->fetchGroup('parent');

        $book = $node->type == 'book' ? zget(end($nodeList), '0', '') : $this->getBookByNode($node);
        foreach($nodeList as $parent => $nodes)
        {
            if($parent === 'catalog') continue;

            $catalog = '<dl>';
            foreach($nodes as $node)
            {
                $serial = $node->type != 'book' ? $serials[$node->id] : '';
                if($node->type == 'chapter')
                {
                    if($this->config->book->chapter == 'left' or $this->config->book->fullScreen or $this->get->fullScreen)
                    {
                        $catalog .= "<dd class='catalogue chapter text-nowrap text-ellipsis' title='{$node->title}'><span><span class='order'>$serial</span>&nbsp;" . $node->title . '</span></dd>';
                    }
                    else
                    {
                        $link = helper::createLink('book', 'browse', "nodeID=$node->id", "book=$book->alias&node=$node->alias") . ($this->get->fullScreen ? "?fullScreen={$this->get->fullScreen}" : '');
                        $target = '';
                        if($node->link != '')
                        { 
                            $target = "target='_blank'";
                            $link =  $node->link;
                        }
                        $catalog .= "<dd class='catalogue chapter text-nowrap text-ellipsis' title='{$node->title}'><span><span class='order'>$serial</span>&nbsp;" . html::a($link, $node->title, $target) . '</span></dd>';
                    }
                }
                elseif($node->type == 'article')
                {
                    $link = helper::createLink('book', 'read', "articleID=$node->id", "book=$book->alias&node=$node->alias") . ($this->get->fullScreen ? "?fullScreen={$this->get->fullScreen}" : '');
                    $target = '';
                    if($node->link != '')
                    { 
                        $target = "target='_blank'";
                        $link =  $node->link;
                    }
                    $catalog .= "<dd id='article{$node->id}' class='catalogue article text-nowrap text-ellipsis' title='{$node->title}'><strong><span class='order'>$serial</span></strong>&nbsp;" . html::a($link, $node->title, $target) . '</dd>';
                }
                if(isset($nodeList[$node->id]) and isset($nodeList[$node->id]['catalog'])) $catalog .= $nodeList[$node->id]['catalog'];
            }
            $catalog .= '</dl>';
            $nodeList[$parent]['catalog'] = $catalog;
        }

        return zget(end($nodeList), 'catalog', '');
    }

    /**
     * Get book catalog for mobile front.
     *
     * @param  int    $nodeID
     * @param  array  $serials  the serial number list for all nodes.
     * @access public
     * @return void
     */
    public function getFrontCatalogForMobile($nodeID, $serials)
    {
        $node = $this->getNodeByID($nodeID);
        if(!$node) return '';

        $nodeList = $this->dao->select('id,alias,type,path,`order`,parent,grade,title,link')->from(TABLE_BOOK)
            ->where('path')->like("{$node->path}%")
            ->andWhere('addedDate')->le(helper::now())
            ->andWhere('status')->eq('normal')
            ->orderBy('grade_desc,`order`, id')
            ->fetchGroup('parent');

        $book = $node->type == 'book' ? zget(end($nodeList), '0', '') : $this->getBookByNode($node);
        foreach($nodeList as $parent => $nodes)
        {
            if($parent === 'catalog') continue;

            $catalog = '';
            foreach($nodes as $node)
            {
                $serial = $node->type != 'book' ? $serials[$node->id] : '';
                if($node->type == 'chapter')
                {
                    $catalog .= '<li>';
                    $catalog .= '  <details>';
                    $catalog .= '    <summary>';
                    $catalog .= '    <section class="chapter">';
                    $catalog .= '      <span class="chapter-left">';
                    $catalog .= '        <span class="tag-chapter">' . $this->lang->book->typeList['chapter'] . '</span>';
                    $catalog .= '        <span class="title">' . $serial . ' ' . $node->title . '</span>';
                    $catalog .= '      </span>';
                    $catalog .= '      <span class="down-triangle"></span>';
                    $catalog .= '    </section>';
                    $catalog .= '    </summary>';
                    $catalog .= '    <ul class="chapter-content">';
                }
                elseif($node->type == 'article')
                {
                    $link   = helper::createLink('book', 'read', "articleID={$node->id}", "book={$book->alias}&node={$node->alias}");
                    $target = '';
                    if($node->link != '')
                    {
                        $target = "target='_blank'";
                        $link   = $node->link;
                    }
                    $catalog .= "<li></li>";
                    $catalog .= "<a href='$link' title='{$node->title}' {$target}>";
                    $catalog .= '  <li class="article">';
                    $catalog .= '    <span class="article-left">';
                    $catalog .= '      <span class="tag-article">' . $this->lang->book->typeList['article'] . '</span>';
                    $catalog .= '      <span class="title">' . $serial . ' ' . $node->title . '</span>';
                    $catalog .= '    </span>';
                    $catalog .= $node->grade == 2 ? '</li></a><li></li><div class="divider"></div>' : '</li></a><li></li>';
                }

                if($node->type == 'chapter' && !isset($nodeList[$node->id]['catalog']))
                {
                    $catalog .= $node->grade == 2 ? '</details></li><div class="divider"></div>' : '</details></li>';
                }
                elseif(isset($nodeList[$node->id]) && isset($nodeList[$node->id]['catalog']))
                {
                    $closeTag = $node->grade == 2 ? '</details></li><div class="divider"></div>' : '</details></li>';
                    $catalog .= $nodeList[$node->id]['catalog'] . $closeTag;
                }
            }
            $catalog .= '</ul>';
            $nodeList[$parent]['catalog'] = $catalog;
        }

        return zget(end($nodeList), 'catalog', '');
    }

    /**
     * Get book catalog for admin.
     * 
     * @param  int    $nodeID 
     * @param  array  $serials  the serial number list for all nodes. 
     * @access public
     * @return void
     */
    public function getAdminCatalog($nodeID, $serials)
    {
        $catalog = '';
        
        $node = $this->getNodeByID($nodeID);
        if(!$node) return $catalog;

        $children = $this->getChildren($nodeID);
        if($node->type != 'book') $serial = $serials[$nodeID];

        $anchor      = "name='node{$node->id}' id='node{$node->id}'";
        $titleLink   = $node->type == 'book' ? $node->title : html::a(helper::createLink('book', 'admin', "bookID=$node->id"), $node->title) . ($node->status == 'draft' ? "<span class='label label-warning'>{$this->lang->book->statusList['draft']}</span>" : '');
        $editLink    = commonModel::hasPriv('book', 'edit') ? html::a(helper::createLink('book', 'edit', "nodeID=$node->id"), $this->lang->edit, $anchor) : '';
        $delLink     = commonModel::hasPriv('book', 'edit') ? html::a(helper::createLink('book', 'delete', "bookID=$node->id"), $this->lang->delete, "class='deleter'") : '';
        $filesLink   = commonModel::hasPriv('file', 'browse') ? html::a(helper::createLink('file', 'browse', "objectType=book&objectID=$node->id&isImage=0"), $this->lang->book->files, "data-toggle='modal' data-width='1000'") : '';
        $catalogLink = commonModel::hasPriv('book', 'catalog') ? html::a(helper::createLink('book', 'catalog', "nodeID=$node->id"), $this->lang->book->catalog) : '';
        $moveLink    = commonModel::hasPriv('book', 'sort') ? html::a('javascript:;', "<i class='icon-move'></i>", "class='sort sort-handle'") : '';

        if($node->type == 'article') $previewLink = commonModel::hasPriv('book', 'read') ? html::a($this->createPreviewLink($node->id), $this->lang->preview, "target='_blank'") : '';

        $childrenHtml = '';
        if($children) 
        {
            $childrenHtml .= '<dl>';
            foreach($children as $child) $childrenHtml .=  $this->getAdminCatalog($child->id, $serials);
            $childrenHtml .= '</dl>';
        }

        if($node->type == 'book')    $catalog .= "<dt class='book' data-id='" . $node->id . "'><strong>" . $titleLink . '</strong><span class="actions">' . $editLink . $catalogLink . $delLink . '</span></dt>' . $childrenHtml;

        if($node->type == 'chapter') $catalog .= "<dd class='catalog chapter' data-id='" . $node->id . "'><strong><span class='order'>" . $serial . '</span>&nbsp;' . $titleLink . '</strong><span class="actions">' . $editLink . $catalogLink . $delLink . $moveLink . '</span>' . $childrenHtml . '</dd>';

        $draft = $node->status == 'draft' ? "<span class='label label-warning'>{$this->lang->book->statusList['draft']}</span>" : '';
        if($node->type == 'article') $catalog .= "<dd class='catalog article' data-id='" . $node->id . "'><strong><span class='order'>" . $serial . '</span>&nbsp;' . $node->title . '</strong> ' . $draft . '<span class="actions">' . $editLink . $previewLink . $filesLink . $delLink . $moveLink . '</span>' . $childrenHtml . '</dd>';

        return $catalog;
    }

    /**
     * Get article id list of string.
     * 
     * @param  int    $nodeID 
     * @access public
     * @return string
     */
    public function getArticleIdList($nodeID, $families, $allNodes)
    {
        $node = zget($allNodes, $nodeID, '');
        if(!$node) return '';

        if($node->type == 'article') return $node->id;

        $ids      = '';
        $children = zget($families, $node->id, '');
        if(!$children) return '';

        foreach($children as $child)
        {
            $result = $this->getArticleIdList($child->id, $families, $allNodes);
            if(strlen($result) == 0) continue;
            $ids .= $result . ',';
        }
        return trim($ids, ',');
    }

    /**
     * Get all (books and articles) for sitemap.
     * 
     * @access public
     * @return array
     */
    public function getAll()
    {
        $books    = $this->getBookList();
        $articles = $this->dao->select('*')->from(TABLE_BOOK)
            ->where('type')->eq('article')
            ->andWhere('addedDate')->le(helper::now())
            ->andWhere('status')->eq('normal')
            ->fetchAll();

        foreach($articles as $article)
        {
            $bookID = $this->extractBookID($article->path);
            $article->book = $books[$bookID];
        }

        return array('book' => $books, 'article' => $articles);
    }

    /**
     * Compute the serial number for all nodes of a book.
     * 
     * @param  string    $path 
     * @access public
     * @return void
     */
    public function computeSN($bookID)
    {
        /* Get all children of the startNode. */
        $nodes = $this->dao->select('id, parent, `order`, path')->from(TABLE_BOOK)
            ->where('path')->like(",$bookID,%")
            ->andWhere('type')->ne('book')
            ->beginIF(defined('RUN_MODE') and RUN_MODE == 'front')
            ->andWhere('addedDate')->le(helper::now())
            ->andWhere('status')->eq('normal')
            ->fi()
            ->orderBy('grade, `order`, id')
            ->fetchAll('id');

        /* Group them by their parent. */
        $groupedNodes = array();
        foreach($nodes as $node) $groupedNodes[$node->parent][$node->id] = $node;

        $serials = array();
        foreach($nodes as $node)
        {
            $path      = explode(',', $node->path);
            $bookID    = $path[1];
            $startNode = $path[2];

            $serial = '';
            foreach($path as $nodeID)
            {
                /* If the node id is empty or is the bookID, skip. */
                if(!$nodeID) continue;
                if($nodeID == $bookID) continue;

                /* Compute the serial. */
                if(isset($nodes[$nodeID]))
                {
                    $parentID = $nodes[$nodeID]->parent;
                    $brothers = $groupedNodes[$parentID];
                    $serial  .= array_search($nodeID, array_keys($brothers)) + 1 . '.';
                }
            }

            $serials[$node->id] = rtrim($serial, '.');
        }
        return $serials;
    }

    /**
     * Get a node of a book.
     *
     * @param  int      $nodeID
     * @param  bool     $replaceTag
     * @access public
     * @return object
     */
    public function getNodeByID($nodeID, $replaceTag = true)
    {
        $node = $this->dao->select('*')->from(TABLE_BOOK)->where('id')->eq($nodeID)->fetch();
        if(!$node) $node = $this->dao->select('*')->from(TABLE_BOOK)->where('alias')->eq($nodeID)->fetch();
        if(!$node) return false;
                
        $node->origins = $this->dao->select('id, type, alias, title, `keywords`, summary, content')->from(TABLE_BOOK)->where('id')->in($node->path)->orderBy('grade')->fetchAll('id');
        $node->book    = current($node->origins);
        $node->files   = $this->loadModel('file')->getByObject('book', $nodeID);
        $node->content = $replaceTag ? $this->loadModel('tag')->addLink($node->content) : $node->content;
        
        return $node;
    }

    /**
     * Get children nodes of a node.
     * 
     * @param  int    $nodeID 
     * @access public
     * @return array
     */
    public function getChildren($nodeID)
    {
        return $this->dao->select('*')->from(TABLE_BOOK)->where('parent')->eq($nodeID)->orderBy('`order`, id')->fetchAll('id');
    }

    /**
     * Get the prev and next ariticle.
     * 
     * @param  int    $current  the current article id.
     * @param  int    $parent   the parent id.
     * @access public
     * @return array
     */
    public function getPrevAndNext($current)
    {
        $families = $this->dao->select('*')->from(TABLE_BOOK)
            ->where('path')->like("%,{$current->book->id},%")
            ->andWhere('status')->eq('normal')
            ->andWhere('addedDate')->le(helper::now())
            ->orderBy('`order`, id')
            ->fetchGroup('parent', 'id');

        $allNodes = $this->dao->select('*')->from(TABLE_BOOK)
            ->where('path')->like("%,{$current->book->id},%")
            ->andWhere('status')->eq('normal')
            ->andWhere('addedDate')->le(helper::now())
            ->fetchAll('id');
        $idList = explode(',', $this->getArticleIdList($current->book->id, $families, $allNodes));
        $idListFlip = array_flip($idList);

        $currentOrder = isset($idListFlip[$current->id]) ? $idListFlip[$current->id] : -1;
        $prev = isset($idList[$currentOrder - 1]) ? $idList[$currentOrder - 1] : 0;
        $next = isset($idList[$currentOrder + 1]) ? $idList[$currentOrder + 1] : 0;

        $prev = $this->dao->select('id, title, alias')->from(TABLE_BOOK)->where('id')->eq($prev)->fetch();
        $next = $this->dao->select('id, title, alias')->from(TABLE_BOOK)->where('id')->eq($next)->fetch();

        return array('prev' => $prev, 'next' => $next);
    }

    /**
     * Get families of a node.
     * 
     * @param  object    $node 
     * @access public
     * @return array
     */
    public function getFamilies($node)
    {
        return $this->dao->select('*')->from(TABLE_BOOK)->where('path')->like($node->path . '%')->fetchAll('id');
    }

    /**
     * Create a tree menu in <select> tag.
     * 
     * @param  int    $startParent 
     * @param  bool   $removeRoot 
     * @access public
     * @return string
     */
    public function getOptionMenu($startParent = 0, $removeRoot = false)
    {
        /* First, get all catalogues. */
        $treeMenu   = array();
        $stmt       = $this->dbh->query($this->buildQuery($startParent));
        $catalogues = array();
        while($catalogue = $stmt->fetch()) $catalogues[$catalogue->id] = $catalogue;

        /* Cycle them, build the select control.  */
        foreach($catalogues as $catalogue)
        {
            $origins = explode(',', $catalogue->path);
            $catalogueTitle = '/';
            foreach($origins as $origin)
            {
                if(empty($origin)) continue;
                $catalogueTitle .= $catalogues[$origin]->title . '/';
            }
            $catalogueTitle = rtrim($catalogueTitle, '/');
            $catalogueTitle .= "|$catalogue->id\n";

            if(isset($treeMenu[$catalogue->id]) and !empty($treeMenu[$catalogue->id]))
            {
                if(isset($treeMenu[$catalogue->parent]))
                {
                    $treeMenu[$catalogue->parent] .= $catalogueTitle;
                }
                else
                {
                    $treeMenu[$catalogue->parent] = $catalogueTitle;;
                }

                $treeMenu[$catalogue->parent] .= $treeMenu[$catalogue->id];
            }
            else
            {
                if(isset($treeMenu[$catalogue->parent]) and !empty($treeMenu[$catalogue->parent]))
                {
                    $treeMenu[$catalogue->parent] .= $catalogueTitle;
                }
                else
                {
                    $treeMenu[$catalogue->parent] = $catalogueTitle;
                }    
            }
        }

        $topMenu = @array_pop($treeMenu);
        $topMenu = explode("\n", trim($topMenu));
        if(!$removeRoot) $lastMenu[] = '/';

        foreach($topMenu as $menu)
        {
            if(!strpos($menu, '|')) continue;

            $menu        = explode('|', $menu);
            $label       = array_shift($menu);
            $catalogueID = array_pop($menu);
           
            $lastMenu[$catalogueID] = $label;
        }

        return $lastMenu;
    }

    /**
     * Build the sql to execute.
     * 
     * @param  int    $startParent   the start parent id
     * @access public
     * @return string
     */
    public function buildQuery($startParent = 0)
    {
        /* Get the start parent path according the $startParent. */
        $startPath = '';
        if($startParent > 0)
        {
            $startParent = $this->getNodeByID($startParent);
            if($startParent) $startPath = $startParent->path . '%';
        }

        return $this->dao->select('*')->from(TABLE_BOOK)
            ->where('type')->ne('article')
            ->beginIF($startPath)->andWhere('path')->like($startPath)->fi()
            ->orderBy('grade desc, `order`, id')
            ->get();
    }

    /**
     * Create a book.
     *
     * @access public
     * @return bool
     */
    public function createBook()
    {
        $now = helper::now();
        $book = fixer::input('post')
            ->add('parent', 0)
            ->add('grade', 1)
            ->add('type', 'book')
            ->add('addedDate', $now)
            ->add('editedDate', $now)
            ->setForce('alias',    seo::unify($this->post->alias, '-', true))
            ->setForce('keywords', seo::unify($this->post->keywords, ','))
            ->get();

        $this->dao->insert(TABLE_BOOK)
            ->data($book, $skip = 'uid')
            ->autoCheck()
            ->batchCheck($this->config->book->require->book, 'notempty')
            ->check('alias', 'unique', "`type`='book' AND `lang`='{$this->app->getClientLang()}'")
            ->exec();

        if(dao::isError()) return false;

        /* Update the path and order field. */
        $bookID   = $this->dao->lastInsertID();
        $bookPath = ",$bookID,";
        $this->dao->update(TABLE_BOOK)
            ->set('path')->eq($bookPath)
            ->set('`order`')->eq($bookID)
            ->where('id')->eq($bookID)
            ->exec();

        if(dao::isError()) return false;

        /* Save keywrods. */
        $this->loadModel('tag')->save($book->keywords);

        /* Return the book id. */
        return $bookID;
    }

    /**
     * Manage a node's catalog.
     *
     * @param  int    $parentNode 
     * @access public
     * @return bool
     */
    public function manageCatalog($parentNode)
    {
        $parentNode = $this->getNodeByID($parentNode);

        /* Init the catalogue object. */
        $now = helper::now();
        $node = new stdclass();
        $node->parent = $parentNode ? $parentNode->id : 0;
        $node->grade  = $parentNode ? $parentNode->grade + 1 : 1;

        foreach($this->post->title as $key => $nodeTitle)
        {
            if(empty($nodeTitle)) continue;
            $mode = $this->post->mode[$key];

            /* First, save the child without path field. */
            $node->title     = $nodeTitle;
            $node->type      = $this->post->type[$key];
            $node->author    = $this->post->author[$key];
            $node->alias     = $this->post->alias[$key];
            $node->keywords  = $this->post->keywords[$key];
            $node->addedDate = $this->post->addedDate[$key];
            $node->status    = $this->post->status[$key];
            $node->order     = $this->post->order[$key];
            $node->alias     = seo::unify($node->alias, '-', true);
            $node->keywords  = seo::unify($node->keywords, ',');

            if($mode == 'new')
            {
                $node->editedDate = $now;
                $this->dao->insert(TABLE_BOOK)->data($node)->exec();

                /* After saving, update it's path. */
                $nodeID   = $this->dao->lastInsertID();
                $nodePath = $parentNode->path . "$nodeID,";
                $this->dao->update(TABLE_BOOK)->set('path')->eq($nodePath)->where('id')->eq($nodeID)->exec();
            }
            else
            {
                $nodeID = $key;
                $node->editedDate = $now;
                $node->editor     = $this->app->user->account;
                $this->dao->update(TABLE_BOOK)->data($node)->autoCheck()->where('id')->eq($nodeID)->exec();
            }

            /* Save keywords. */
            $this->loadModel('tag')->save($node->keywords);

            if($node->type == 'article')
            {
                $article = $this->dao->select('*')->from(TABLE_BOOK)->where('id')->eq($nodeID)->fetch();
                $book    = $this->getBookByNode($article);
                $article->book = $book->alias;
                $this->loadModel('search')->save('book', $article);
            }
        }

        return !dao::isError();
    }

    /**
     * Check if alias available.
     *
     * @access public
     * @return void
     */
    public function checkAlias()
    {
        /* Define the return var. */
        $return = array();
        $return['result'] = true;

        /* Count the chapter alias's counts. */
        $chapterAlias = array();
        foreach($this->post->type as $key => $type)
        {
            if($type == 'chapter') $chapterAlias[] = seo::unify($this->post->alias[$key], '-', true); 
        }
        $chapterAlias = array_count_values($chapterAlias);

        foreach($this->post->title as $key => $title)
        {
            $type  = $this->post->type[$key];
            $alias = seo::unify($this->post->alias[$key], '-', true);
            $mode  = $this->post->mode[$key];

            if($type == 'article' or $alias == '' or $title == '') continue;

            /* Check the alias exists in database or not. */
            $dbExists = $this->dao->select('count(*) AS count')
                ->from(TABLE_BOOK)
                ->where('type')->eq('chapter')
                ->andWhere('alias')->eq($alias)
                ->beginIF($mode == 'update')->andWhere('id')->ne($key)->fi()
                ->fetch('count');

            if($dbExists or $chapterAlias[$alias] > 1)
            {
                $return['result']      = false;
                $return['alias'][$key] = $alias;
            }
        }

        return $return;
    }

    /**
     * Update a node.
     *
     * @param int $nodeID
     * @access public
     * @return bool
     */
    public function update($nodeID)
    {
        $oldNode = $this->getNodeByID($nodeID);
        $node = fixer::input('post')
            ->add('id',            $nodeID)
            ->add('editor',        $this->app->user->account)
            ->add('editedDate',    helper::now())
            ->setForce('keywords', seo::unify($this->post->keywords, ','))
            ->setForce('alias',    seo::unify($this->post->alias, '-', true))
            ->setForce('type',     $oldNode->type)
            ->stripTags('content', $this->config->allowedTags->admin)
            ->get();

        if(isset($node->isLink) && $node->isLink == 'on')
        {
            $node->status  = 'normal';
            $node->content = html::a($node->link, "Link: " . $node->link);
        }
        else
        {
            $node->link   = '';
            $node->isLink = 'off';
        }

        $parentNode = $this->getNodeByID($node->parent);

        if($node->type != "book" && strpos($oldNode->path, ",$node->book,") === false)
        {
            $nodePaths = $this->dao->select("id,path")->from(TABLE_BOOK)->where('path')->like("$oldNode->path%")->fetchPairs('id');
            list($id,$path) = each($nodePaths);
            $position = strpos($path,$oldNode->parent);

            foreach($nodePaths as $id => $path)
            {
                $updatePath['path'] = $parentNode->path . substr($path,$position);

                $this->dao->update(TABLE_BOOK)->data($updatePath)
                ->where('id')->eq($id)
                ->exec();
            }
        }

        $this->dao->update(TABLE_BOOK)
            ->data($node, $skip = 'uid,referer,book,isLink')
            ->autoCheck()
            ->batchCheckIF($node->type == 'book', $this->config->book->require->book, 'notempty')
            ->batchCheckIF($node->type != 'book', $this->config->book->require->node, 'notempty')
            ->batchCheckIF($node->type != 'book' and $node->isLink == 'on', $this->config->book->require->link, 'notempty')
            ->checkIF($node->type == 'book', 'alias', 'unique', "`type` = 'book' AND id != '$nodeID' AND `lang` = '{$this->app->getClientLang()}'")
            ->where('id')->eq($nodeID)
            ->exec();

        if(dao::isError()) return false;

        $this->fixPath($node->book);
        if(dao::isError()) return false;

        $this->loadModel('tag')->save($node->keywords);
        if(dao::isError()) return false;

        if($node->type == 'article')
        {
            $this->loadModel('file')->updateObjectID($this->post->uid, $nodeID, 'book');
            $this->file->copyFromContent($this->post->content, $nodeID, 'book');
            if(dao::isError()) return false;
        }
        $book = $this->getNodeByID($nodeID);
        $book->book = $book->book->alias;
        return $this->loadModel('search')->save('book', $book);
    }

    /**
     * Fix the path, grade fields according to the id and parent fields.
     *
     * @param  string    $type 
     * @access public
     * @return void
     */
    public function fixPath($bookID)
    {
        /* Get all nodes grouped by parent. */
        $groupNodes = $this->dao->select('id, parent')->from(TABLE_BOOK)
            ->where('path')->like(",$bookID,%")
            ->fetchGroup('parent', 'id');
        $nodes = array();

        /* Cycle the groupNodes until it has no item any more. */
        while(count($groupNodes) > 0)
        { 
            /* Record the counts before processing. */
            $oldCounts = count($groupNodes);

            foreach($groupNodes as $parentNodeID => $childNodes)
            {
                /** 
                 * If the parentNode doesn't exsit in the nodes, skip it. 
                 * If exists, compute it's child nodes. 
                 */
                if(!isset($nodes[$parentNodeID]) and $parentNodeID != 0) continue;

                if($parentNodeID == 0)
                {
                    $parentNode = new stdclass();
                    $parentNode->grade = 0;
                    $parentNode->path  = ',';
                }
                else
                {
                    $parentNode = $nodes[$parentNodeID];
                }

                /* Compute it's child nodes. */
                foreach($childNodes as $childNodeID => $childNode)
                {
                    $childNode->grade = $parentNode->grade + 1;
                    $childNode->path  = $parentNode->path . $childNode->id . ',';

                    /**
                     * Save child node to nodes, 
                     * thus the child of child can compute it's grade and path.
                     */
                    $nodes[$childNodeID] = $childNode;
                }

                /* Remove it from the groupNodes.*/
                unset($groupNodes[$parentNodeID]);
            }

            /* If after processing, no node processed, break the cycle. */
            if(count($groupNodes) == $oldCounts) break;
        }

        /* Save nodes to database. */
        foreach($nodes as $node)
        {
            $this->dao->update(TABLE_BOOK)->data($node)
                ->where('id')->eq($node->id)
                ->exec();
        }
    }
    /**
     * Delete a book.
     *
     * @param int $id
     * @return bool
     */
    public function delete($id, $null = null)
    {
        $book = $this->getNodeByID($id);
        if(!$book) return false;
        $families = $this->getFamilies($book);

        foreach($families as $node)
        {
            $this->dao->delete()->from(TABLE_BOOK)->where('id')->eq($node->id)->exec();
            $this->loadModel('search')->deleteIndex('book', $node->id);
        }
        return !dao::isError(); 
    }

    /**
     * Create content navigation according the content. 
     * 
     * @param  int    $content 
     * @access public
     * @return string;
     */
    public function addMenu($content)
    {
        $nav = "<ul class='nav nav-content'>";
        $content = str_replace('<h3', '<h4', $content);
        $content = str_replace('h3>', 'h4>', $content);
        preg_match_all('|<h4.*>(.*)</h4>|isU', $content, $result);
        if(count($result[0]) >= 2)
        {
            foreach($result[0] as $id => $item)
            {
                $nav .= "<li><a href='#$id'>" . strip_tags($item) . "</a></li>";
                $replace = str_replace('<h4', "<h4 id=$id", $item);
                $content = str_replace($item, $replace, $content);
            }
            $nav .= "</ul>";
            $content = $nav . "<div class='content'>" . $content . '</div>';
        }

        return $content;
    }

    /**
     * sort books
     * 
     * @access public
     * @return void
     */
    public function sort()
    {
        $nodes = fixer::input('post')->get();
        foreach($nodes->sort as $id => $order)
        {
            $order = explode('.', $order);
            $num   = end($order);
            $this->dao->update(TABLE_BOOK)->set('`order`')->eq($num)->where('id')->eq($id)->exec();
        }
        return !dao::isError();
    }
    /**
     * Explode path.
     *
     * @access public
     * @return string
     */
    public function explodePath($str)
    {
        $path = '';
        $chapters = explode(',', $str, -2);
        foreach($chapters as $chapterID)
        {
            $chapter = $this->dao->select('title')->from(TABLE_BOOK)->where('id')->eq($chapterID)->fetch('title'); 
            $path .= $chapter.'/';
        }
        return $path;
    }
    
    /**
     * Create preview link. 
     * 
     * @param  int    $articleID 
     * @param  string $viewType 
     * @access public
     * @return string
     */
    public function createPreviewLink($articleID, $viewType = '')
    {
        $bookNode = $this->getNodeByID($articleID);
        $link = commonModel::createFrontLink('book', 'read', "articleID=$bookNode->id", "book={$bookNode->book->alias}&node={$bookNode->alias}", $viewType);
        return $link;
    }

    
}
