<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of bear module of ChanzhiEPS.
 *
 * @copyright   Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv11.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     bear
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class bearModel extends model
{
    const API_REALTIME = 'reatime';
    const API_BATECH   = 'bactch';

    /**
     * Save setting function.
     * 
     * @access public
     * @return array
     */
    public function saveSetting()
    {
        $bear = fixer::input('post')
            ->setDefault('autoSync', '')
            ->join('autoSync', ',')
            ->get();

        $errors = array();
        foreach($bear as $key => $value) $bear->$key = trim($value);
        if(empty($bear->type))  $errors['type'][] = sprintf($this->lang->error->notempty, $this->lang->bear->type);
        if(empty($bear->name))  $errors['name'][] = sprintf($this->lang->error->notempty, $this->lang->bear->name);
        if(empty($bear->appID)) $errors['appID'][] = sprintf($this->lang->error->notempty, $this->lang->bear->appID);
        if(empty($bear->token)) $errors['token'][] = sprintf($this->lang->error->notempty, $this->lang->bear->token);

        if(!empty($errors)) return array('result' => 'fail', 'message' => $errors);

        $result = $this->loadModel('setting')->setItems('system.common.bear', $bear);
        if($result) return array('result' => 'success', 'message' => $this->lang->saveSuccess);
    }

    /**
     * Submit url to bear.
     * 
     * @param  array    $urlList 
     * @param  string   $type 
     * @param  string   $auto 
     * @access public
     * @return object
     */
    public function submit($objectType, $objectID, $type = 'batch', $auto = 'no')
    {

        switch($objectType)
        {
            case 'article':
                $url = $this->loadModel('article')->createPreviewLink($objectID, 'html', $objectType); 
                break;
            case 'blog':
                $url = $this->loadModel('article')->createPreviewLink($objectID, 'html', $objectType);
                break;
            case 'page':
                $url = $this->loadModel('article')->createPreviewLink($objectID, 'html', $objectType);
                break;
            case 'product':
                $url = $this->loadModel('product')->createPreviewLink($objectID); 
                break;
            case 'book':
                $url = $this->loadModel('book')->createPreviewLink($objectID); 
                break;
            case 'thread':
                $url = commonModel::createFrontLink('thread', 'view', "threadID=$thread->id");
                break;
        }

        $scheme  = zget($this->config->site, 'scheme', 'http');
        $domain  = zget($this->config->site, 'domain', '') ?  zget($this->config->site, 'domain', '') : $this->server->http_host;
        $urlInfo = parse_url($url);
        $query   = !empty($urlInfo['query']) ? "?{$urlInfo['query']}" : '';
        $url     = $scheme . "://" . $domain . $urlInfo['path'] . $query;
        if($this->hasSubmited($url)) 
        {
            $result = new stdclass;
            $result->success = 1;
            return $result;
        }

		$curl = curl_init();
		$options =  array();
		$options[CURLOPT_URL]		     = sprintf($this->config->bear->apiList->posturl, $this->config->bear->appID, $this->config->bear->token, $type);
		$options[CURLOPT_POST]           = true;
		$options[CURLOPT_RETURNTRANSFER] = true;
		$options[CURLOPT_POSTFIELDS]     = $url;
		$options[CURLOPT_HTTPHEADER]     = array('Content-Type: text/plain');

		curl_setopt_array($curl, $options);

		$result = curl_exec($curl);
		curl_close($curl);
        $result = json_decode($result);

        if(!is_object($result)) return false;

        $result->type = $type;
        $result->remain  = zget($result, "remain_{$type}", 0);
        $result->success = zget($result, "success_{$type}", 0);
        $result->status  = $result->success == 1 ? 'success' : 'fail';

        $this->log($type, $objectType, $objectID, $url, $result, $auto);
        return $result;
	}

    /**
     * save submit log function.
     * 
     * @param  int    $objectType 
     * @param  int    $objectID 
     * @param  int    $url 
     * @param  int    $result 
     * @access public
     * @return void
     */
    public function log($type, $objectType, $objectID, $url, $result, $auto)
    {
        $data = new stdclass();
        $data->type       = $type;
        $data->account    = $this->app->user->account;
        $data->objectType = $objectType;
        $data->objectID   = $objectID;
        $data->url        = $url;
        $data->status     = $result->status;
        $data->auto       = $auto;
        $data->response   = json_encode($result);
        $data->time       = helper::now();
        $this->dao->insert(TABLE_BEARLOG)->data($data)->exec();
        return dao::isError();
    }

    /**
     * Batch submit function.
     * 
     * @param  string    $type 
     * @param  int       $last 
     * @access public
     * @return array
     */
    public function batchSubmit($type, $lastID = 0)
    {
        if(!commonModel::isAvailable($type))
        {
            if(isset($this->config->bear->submitOrder[$type])) $type = $this->config->bear->submitOrder[$type];
            if(!isset($this->config->bear->submitOrder[$type])) return array('finished' => true);
        }

        $limit = 100;
        if($type == 'article')
        {
            $articles = $this->dao->select('id,type')->from(TABLE_ARTICLE)
                ->where('type')->in('article,blog,page')
                ->andWhere('status')->eq('normal')
                ->andWhere('addedDate')->le(helper::now())
                ->andWhere('id')->gt($lastID)
                ->orderBy('id')
                ->limit($limit)
                ->fetchAll('id');

            if(empty($articles))
            {
                $type   = $this->config->bear->submitOrder[$type];
                $lastID = 0;
            }
            else
            {
                foreach($articles as $article) $this->submit($article->type, $article->id);
                $lastID = max(array_keys($articles));
                return array('type' => $type, 'count' => count($articles), 'lastID' => $lastID);
            }
        }

        if($type == 'product')
        {
            $products = $this->dao->select('id')->from(TABLE_PRODUCT)
                ->where('status')->eq('normal')
                ->andWhere('id')->gt($lastID)
                ->orderBy('id')
                ->limit($limit)
                ->fetchAll('id');

            if(empty($products))
            {
                $type   = $this->config->bear->submitOrder[$type];
                $lastID = 0;
            }
            else
            {
                foreach($products as $product) $this->submit('product', $product->id);
                $lastID = max(array_keys($products));
                return array('type' => $type, 'count' => count($products), 'lastID' => $lastID);
            }
        }

        if($type == 'thread')
        {
            $threads = $this->dao->select('id')->from(TABLE_THREAD)
                ->where('id')->gt($lastID)
                ->beginIf(RUN_MODE == 'front' and $this->config->forum->postReview == 'open')->andWhere('status')->eq('approved')->fi()
                ->orderBy('id')
                ->limit($limit)
                ->fetchAll('id');

            if(empty($threads))
            {
                $type   = $this->config->bear->submitOrder[$type];
                $lastID = 0;
            }
            else
            {
                foreach($threads as $thread) $this->submit('thread', $thread->id);
                $lastID = max(array_keys($threads));
                return array('type' => $type, 'count' => count($threads), 'lastID' => $lastID);
            }
        }

        if($type == 'book')
        {
            $books = $this->dao->select('id,type')->from(TABLE_BOOK)
                ->where('type')->eq('article')
                ->andWhere('id')->gt($lastID)
                ->orderBy('id')
                ->limit($limit)
                ->fetchAll('id');

            if(empty($books))
            {
                $type   = $this->config->bear->submitOrder[$type];
                $lastID = 0;
            }
            else
            {
                foreach($books as $book) $this->submit('book', $book->id);
                $lastID = max(array_keys($books));
                return array('type' => $type, 'count' => count($books), 'lastID' => $lastID);
            }
        }
        return array('finished' => true);
    }

    /**
     * Check resouce has submited.
     * 
     * @param  string    $url 
     * @access public
     * @return bool
     */
    public function hasSubmited($url)
    {
        $record = $this->dao->select('*')->from(TABLE_BEARLOG)->where('url')->eq($url)->andWhere('status')->eq('success')->fetch();   
        return !empty($record);
    }

    /**
     * Get logs list.
     * 
     * @param  string    $begin 
     * @param  string    $end 
     * @param  string    $orderBy 
     * @param  object    $pager 
     * @access public
     * @return array
     */
    public function getLogs($begin, $end, $orderBy, $pager)
    {
        $end .= " 23:59:59";
        return $this->dao->select('*')->from(TABLE_BEARLOG)
            ->where('time')->ge($begin)
            ->andWhere('time')->le($end)
            ->orderBy($orderBy)
            ->page($pager)
            ->fetchAll();
    }
}
