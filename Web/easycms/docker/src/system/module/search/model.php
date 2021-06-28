<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of search module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     search
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class searchModel extends model
{
    /**
     * get search results of keywords.
     * 
     * @param  string    $keywords 
     * @param  object    $pager 
     * @access public
     * @return array
     */
    public function getList($keywords, $pager)
    {
        $spliter = $this->app->loadClass('spliter');
        $words   = explode(' ', seo::unify($keywords, ' '));

        $against = '';
        $againstCond   = '';
        $likeCondition = '';
        foreach($words as $word)
        {
            $splitedWords = $spliter->utf8Split($word);

            $trimedWord   = trim($splitedWords['words']);
            $against     .= '"'  . $trimedWord  . '" '; 
            $againstCond .= '+"' . $trimedWord . '" '; 
            if(is_numeric($word) and strlen($word) == 5) $againstCond .= "-\" $word \" ";

            $likeWord = is_numeric($word) ? $word : $trimedWord;
            if(is_numeric($word) and strlen($word) < 5) $likeWord = " $likeWord ";
            
            $condition = "OR title like '%{$likeWord}%' OR content like '%{$likeWord}%'";
            if(is_numeric($word) and strlen($word) == 5) $condition = "OR title REGEXP '[^ ]{$likeWord}[^ ]' OR content REGEXP '[^ ]{$likeWord}[^ ]'";
            $likeCondition .= $condition;
        }
        
        $words = str_replace('"', '', $against);
        $words = str_pad($words, 5, '_');
    
        $scoreColumn = "((1 * (MATCH(title) AGAINST('{$against}' IN BOOLEAN MODE))) + (0.6 * (MATCH(content) AGAINST('{$against}' IN BOOLEAN MODE))) )";
        $results = $this->dao->select("*, {$scoreColumn} as score")
            ->from(TABLE_SEARCH_INDEX)
            ->where("(MATCH(title,content) AGAINST('{$againstCond}' IN BOOLEAN MODE) >= 1 $likeCondition)")
            ->andWhere('status')->eq('normal')
            ->andWhere('addedDate')->le(helper::now())
            ->orderBy('score_desc, editedDate_desc')
            ->page($pager)
            ->fetchAll('id');
        
        $objectIdList = array();
        foreach($results as $result) $objectIdList[] = $result->objectID;

        $this->loadModel('file');
        $images = $this->dao->setAutoLang(false)->select('*')->from(TABLE_FILE)
            ->where('extension')->in($this->config->file->imageExtensions)
            ->andWhere('objectType')->in('article,product')
            ->andWhere('objectID')->in($objectIdList)
            ->orderBy('`order`, editor_desc') 
            ->fetchGroup('objectID');

        foreach($images as $objectImages) $this->file->batchProcessFile($objectImages);

        foreach($results as $record)
        {
            $record->title   = explode(' ', $record->title);
            $record->content = explode(' ', $record->content);
            foreach($record->title as $titleKey => $titleWord)
            {
                if(is_numeric($titleWord) && strlen($titleWord) != 5) unset($record->title[$titleKey]);
            }
            foreach($record->content as $contentKey => $contentWord)
            {
                if(is_numeric($contentWord) && strlen($contentWord) != 5) unset($record->content[$contentKey]);
            }
            $record->title   = implode(' ', $record->title);
            $record->content = implode(' ', $record->content);

            $record->title   = str_replace('</span> ', '</span>', $this->decode($this->markKeywords($record->title, $words)));
            $record->title   = str_replace('_', '', $record->title);
            $record->summary = $this->getSummary($record->content, $words);
            $record->summary = str_replace('_', '', $record->summary);

            if(empty($images[$record->objectID])) continue;
            $record->image = new stdclass();

            /* For match right objectType. */
            if(isset($images[$record->objectID]))
            {
                foreach($images[$record->objectID] as $image)
                {
                    if($image->objectType == $record->objectType) $record->image->list[] = $image;
                }
            }

            if(!empty($record->image->list)) $record->image->primary = $record->image->list[0];
        }

        return $this->processLinks($results);
    }

    /**
     * Save an index item.
     * 
     * @param  string    $objectType article|blog|page|product|thread|reply|
     * @param  int       $objectID 
     * @access public
     * @return void
     */
    public function save($objectType, $object)
    {
        $fields = $this->config->search->fields->{$objectType};

        $status = !empty($object->{$fields->status}) ? $object->{$fields->status} : 'normal' ;
        if($objectType == 'thread' and $status == 'approved' and !$object->hidden) $status = 'normal';

        $index = new stdclass();
        $index->objectID   = $object->{$fields->id};
        $index->objectType = $objectType;
        $index->title      = $object->{$fields->title};
        $index->status     = $status;
        $index->addedDate  = isset($object->{$fields->addedDate}) ? $object->{$fields->addedDate} : '0000-00-00 00:00:00';
        $index->editedDate = isset($object->{$fields->editedDate}) ? $object->{$fields->editedDate} : '0000-00-00 00:00:00';

        $paramFields = explode(',', $fields->params);
        foreach($paramFields as $field)
        {
            $params[$field] = isset($object->$field) ? $object->$field : ''; 
        }

        $index->params = json_encode($params);

        $index->content = '';
        $contentFields  = explode(',', $fields->content);
        foreach($contentFields as $field) $index->content .= $object->$field;

        $spliter = $this->app->loadClass('spliter');

        $titleSplited   = $spliter->utf8Split($index->title);
        $index->title   = $titleSplited['words'];
        $contentSplited = $spliter->utf8Split(strip_tags($index->content));
        $index->content = $contentSplited['words'];

        $this->saveDict($titleSplited['dict'] + $contentSplited['dict']);
        $this->dao->replace(TABLE_SEARCH_INDEX)->data($index)->exec();
        return true;
    }

    /**
     * Save dict info. 
     * 
     * @param  array    $words 
     * @access public
     * @return void
     */
    public function saveDict($dict)
    {
        foreach($dict as $key => $value)
        {
            if(!is_numeric($key) or empty($value) or strlen($key) != 5) continue;
            $this->dao->replace(TABLE_SEARCH_DICT)->data(array('key' => $key, 'value' => $value))->exec();
        }
    }

    /**
     * Transfer unicode to words.
     * 
     * @param  string    $string 
     * @access public
     * @return void
     */
    public function decode($string)
    {
        if(strpos($string, ' ') === false and !is_numeric($string)) return $string;
        if(preg_match('/^[a-zA-z]+[0-9]*[a-zA-z]$/', trim($string))) return $string;
        static $dict;
        if(empty($dict))
        {
            $dict = $this->dao->select("concat(`key`, ' ') as `key`, value")->from(TABLE_SEARCH_DICT)->fetchPairs();
            $dict['|'] = '';
        }
        return str_replace(array_keys($dict), array_values($dict), $string . ' ');
    }

    /**
     * Get summary of results.
     * 
     * @param  string    $content 
     * @param  string    $words 
     * @access public
     * @return string
     */
    public function getSummary($content, $words)
    {
        $length = $this->config->search->summaryLength;
        if(strlen($content) <= $length) return $this->decode($this->markKeywords($content, $words));

        $content = $this->markKeywords($content, $words);
        preg_match_all("/\<span class='text-danger'\>.*?\<\/span\>/", $content, $matches);

        if(empty($matches[0])) return $this->decode($this->markKeywords(substr($content, 0, $length), $words));

        $matches = $matches[0];
        $score   = 0;
        $needle  = '';
        foreach($matches as $matched) 
        {
            /* Use length of matched words as score. */
            if(strlen($matched) > $score) 
            {
                $content = str_replace($needle, strip_tags($needle), $content);
                $needle  = $matched;
                $score   = strlen($matched);
            }
        }

        $content = str_replace('<span class', '<spanclass', $content);
        $content = str_replace('/span>', '/span> ', $content);
        $content = explode(' ', $content);

        foreach($content as $key => $item) $content[$key] = str_replace("<spanclass", "<span class", $item);
        $pos     = array_search($needle, $content);

        $start   = max(0, $pos - ($length / 2));
        $summary = join(' ', array_slice($content, $start, $length));
        $summary = str_replace('<spanclass', '<span class', $summary);
 
        $summary = $this->decode($summary);
        $summary = str_replace('</span> ', '</span>', $summary);
        return $summary;
    }

    /**
     * Process links of search results.
     * 
     * @param  array    $results 
     * @access public
     * @return array
     */
    public function processLinks($results)
    {
        foreach($results as $record)
        {
            $record->params = json_decode($record->params);
            if($record->objectType == 'article') $record->url = helper::createLink('article', 'view',  "id={$record->objectID}", "category={$record->params->category}&name={$record->params->alias}");
            if($record->objectType == 'product') $record->url = helper::createLink('product', 'view',  "id={$record->objectID}", "category={$record->params->category}&name={$record->params->alias}");
            if($record->objectType == 'thread')  $record->url = helper::createLink('thread', 'view', "id={$record->objectID}");;
            if($record->objectType == 'blog')    $record->url = helper::createLink('blog', 'view',  "id={$record->objectID}", "category={$record->params->category}&name={$record->params->alias}");
            if($record->objectType == 'page')    $record->url = helper::createLink('page', 'view',  "id={$record->objectID}", "name={$record->params->alias}");
            if($record->objectType == 'book')    $record->url = helper::createLink('book', 'read', "id={$record->objectID}", "book={$record->params->book}&node={$record->params->alias}");

            if(is_callable(array($this->loadModel('search'), "process{$record->objectType}Link")))
            {
                call_user_func(array($this->loadModel('search'), "process{$record->objectType}Link"), $record);
            }
        }

        return $results;
    }

    /**
     * Mark keywords in content.
     * 
     * @param  string    $content 
     * @param  string    $keywords 
     * @access public
     * @return void
     */
    public function markKeywords($content, $keywords)
    {
        $words = explode(' ', trim($keywords, ' '));
        $markedWords = array();

        foreach($words as $key => $word)
        {
            if(preg_match('/^\|[0-9]+\|$/', $word))
            {
                $words[$key] = trim($word, '|');
            }
            elseif(is_numeric($word))
            {
                $words[$key] = $word . ' ';
            }
            else
            {
                $words[$key] = strlen($word) == 5 ? str_replace('_', '', $word) : $word;
                $words[$key] .= ' ';
            }
            $markedWords[] = "[" . $this->decode($words[$key]) . "] ";
        }

        $content = str_replace($words, $markedWords, $content . ' ');
        $content = str_replace(" ] [", '', $content);
        $content = str_replace("[", "<span class='text-danger'>", $content);
        $content = str_replace(" ] ", '</span>', $content);

        return $content;
    }

    /**
     * Build all search index.
     * 
     * @access public
     * @return bool
     */
    public function buildAllIndex($type, $lastID)
    {
        if(!commonModel::isAvailable($type))
        {
            if(isset($this->config->search->buildOrder[$type])) $type = $this->config->search->buildOrder[$type];
            if(!isset($this->config->search->buildOrder[$type])) return array('finished' => true);
        }

        $limit = 100;
        $categories = $this->dao->select('id,alias')->from(TABLE_CATEGORY)->fetchPairs();

        if(is_callable(array($this->loadModel('search'), "build{$type}Index")))
        {
            return call_user_func(array($this->loadModel('search'), "build{$type}Index"), $lastID);
        }

        if($type == 'article')
        {
            if(!commonModel::isAvailable($type))
            {
                if(isset($this->config->search->buildOrder[$type])) $type = $this->config->search->buildOrder[$type];
                if(!isset($this->config->search->buildOrder[$type])) return array('finished' => true);
            }
            else
            {
                $articles = $this->dao->select('t1.*, t2.category as category')
                    ->from(TABLE_ARTICLE)->alias('t1')
                    ->leftJoin(TABLE_RELATION)->alias('t2')->on("t1.id=t2.id")
                    ->where('t2.type')->in('article,video')
                    ->beginIF($lastID)->andWhere('t1.id')->gt($lastID)->fi()
                    ->orderBy('id')
                    ->limit($limit)
                    ->fetchAll('id');

                if(empty($articles))
                {
                    $type   = $this->config->search->buildOrder['article'];
                    $lastID = 0;
                }
                else
                {
                    foreach($articles as $article) 
                    {
                        $article->category = $categories[$article->category];
                        $this->save($article->type, $article);
                    }

                    return array('type' => $type, 'count' => count($articles), 'lastID' => max(array_keys($articles)));
                }
            }
        }

        if($type == 'blog')
        {
            if(!commonModel::isAvailable($type))
            {
                if(isset($this->config->search->buildOrder[$type])) $type = $this->config->search->buildOrder[$type];
                if(!isset($this->config->search->buildOrder[$type])) return array('finished' => true);
            }
            else
            {
                $articles = $this->dao->select('t1.*, t2.category as category')
                    ->from(TABLE_ARTICLE)->alias('t1')
                    ->leftJoin(TABLE_RELATION)->alias('t2')->on("t1.id=t2.id")
                    ->where('t2.type')->eq('blog')
                    ->beginIF($lastID)->andWhere('t1.id')->gt($lastID)->fi()
                    ->orderBy('t1.id')
                    ->limit($limit)
                    ->fetchAll('id');

                if(empty($articles))
                {
                    $type   = $this->config->search->buildOrder['blog'];
                    $lastID = 0;
                }
                else
                {
                    foreach($articles as $article) 
                    {
                        $article->category = $categories[$article->category];
                        $this->save($article->type, $article);
                    }

                    return array('type' => $type, 'count' => count($articles), 'lastID' => max(array_keys($articles)));
                }
            }
        }

        if($type == 'product')
        {
            if(!commonModel::isAvailable($type))
            {
                if(isset($this->config->search->buildOrder[$type])) $type = $this->config->search->buildOrder[$type];
                if(!isset($this->config->search->buildOrder[$type])) return array('finished' => true);
            }
            else
            {
                $products = $this->dao->select('t1.*, t2.category as category')
                    ->from(TABLE_PRODUCT)->alias('t1')
                    ->leftJoin(TABLE_RELATION)->alias('t2')->on("t1.id=t2.id")
                    ->where('t2.type')->eq('product')
                    ->beginIF($lastID)->andWhere('t1.id')->gt($lastID)->fi()
                    ->limit($limit)
                    ->fetchAll('id');

                $attributes = $this->dao->select('*')->from(TABLE_PRODUCT_CUSTOM)->where('product')->in(array_keys($products))->fetchGroup('product');

                foreach($products as $product)
                {
                    $product->attributes = '';
                    $productAttributes = isset($attributes[$product->id]) ? $attributes[$product->id] : array();
                    foreach($productAttributes as $attribute) $product->attributes .= $attribute->value;
                }

                if(empty($products))
                {
                    $type   = $this->config->search->buildOrder['product'];
                    $lastID = 0;
                }
                else
                {
                    foreach($products as $product)
                    {
                        $product->category = $categories[$product->category];
                        $this->save('product', $product);
                    }
                    return array('type' => $type, 'count' => count($products), 'lastID' => max(array_keys($products)));
                }
            }
        }
        
        if($type == 'page')
        {
            if(!commonModel::isAvailable($type))
            {
                if(isset($this->config->search->buildOrder[$type])) $type = $this->config->search->buildOrder[$type];
                if(!isset($this->config->search->buildOrder[$type])) return array('finished' => true);
            }
            else
            {
                $pages = $this->dao->select("*")
                    ->from(TABLE_ARTICLE)
                    ->where('type')->eq('page')
                    ->beginIF($lastID)->andWhere('id')->gt($lastID)->fi()
                    ->limit($limit)
                    ->fetchAll('id');

                if(empty($pages))
                {
                    $type   = $this->config->search->buildOrder['page'];
                    $lastID = 0;
                }
                else
                {
                    foreach($pages as $page) $this->save('page', $page);
                    return array('type' => $type, 'count' => count($pages), 'lastID' => max(array_keys($pages)));
                }
            }
        }

        if($type == 'thread')
        {
            if(!commonModel::isAvailable($type))
            {
                if(isset($this->config->search->buildOrder[$type])) $type = $this->config->search->buildOrder[$type];
                if(!isset($this->config->search->buildOrder[$type])) return array('finished' => true);
            }
            else
            {
                $threads = $this->dao->select("*, 'normal' as status")
                    ->from(TABLE_THREAD)
                    ->where('status')->eq('approved')
                    ->andWhere('hidden')->eq(0)
                    ->beginIF($lastID)->andWhere('id')->gt($lastID)->fi()
                    ->limit($limit)
                    ->fetchAll('id');

                if(empty($threads))
                {
                    $type   = $this->config->search->buildOrder['thread'];
                    $lastID = 0;
                }
                else
                {
                    foreach($threads as $thread) $this->save('thread', $thread);
                    return array('type' => $type, 'count' => count($threads), 'lastID' => max(array_keys($threads)));
                }
            }
        }

        if($type == 'book')
        {
            if(!commonModel::isAvailable($type))
            {
                if(isset($this->config->search->buildOrder['book']) and is_callable(array($this, "build{$this->config->search->buildOrder['book']}Index")))
                {
                    return call_user_func(array($this, "build{$this->config->search->buildOrder['book']}Index"), $lastID);
                }
                else
                {
                    return array('finished' => true);
                }
            }
            else
            {
                $books    = $this->dao->select('id,alias')->from(TABLE_BOOK)->where('type')->eq('book')->fetchPairs();
                $articles = $this->dao->select('*')->from(TABLE_BOOK)
                    ->where('type')->eq('article')
                    ->beginIF($lastID)->andWhere('id')->gt($lastID)->fi()
                    ->limit($limit)
                    ->fetchAll('id');

                if(isset($this->config->search->buildOrder['book']) and is_callable(array($this, "build{$this->config->search->buildOrder['book']}Index")))
                {
                    if(empty($articles))
                    {
                        $type   = $this->config->search->buildOrder['book'];
                        $lastID = 0;
                    }
                    else
                    {
                        foreach($articles as $article)
                        {
                            $pathes = explode(',', trim($article->path, ','));
                            $bookID = $pathes[0];

                            $article->book = $books[$bookID];
                            $this->save('book', $article);
                        }
                        return array('type' => $type, 'count' => count($articles), 'lastID' => max(array_keys($articles)));
                    }

                    if($type == $this->config->search->buildOrder['book'])
                    {
                        return call_user_func(array($this, "build{$this->config->search->buildOrder['book']}Index"), $lastID);
                    }
                }
                else
                {
                    foreach($articles as $article)
                    {
                        $pathes = explode(',', trim($article->path, ','));
                        $bookID = $pathes[0];

                        $article->book = $books[$bookID];
                        $this->save('book', $article);
                    }

                    return array('finished' => true);
                }
            }
        }
        return array('finished' => true);
    }

    /**
     * Delete index of an object.
     * 
     * @param  string    $objectType 
     * @param  int       $objectID 
     * @access public
     * @return void
     */
    public function deleteIndex($objectType, $objectID)
    {
        $this->dao->delete()->from(TABLE_SEARCH_INDEX)->where('objectType')->eq($objectType)->andWhere('objectID')->eq($objectID)->exec();
        return !dao::isError();
    }
}
