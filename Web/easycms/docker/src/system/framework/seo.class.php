<?php
/**
 * The seo class, parse seo mode uri to normal mode uri.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */

/**
 * The seo class.
 *
 * @package framework
 */
class seo
{
    /**
     * Parse SEO URI for setRouteByPathInfo.
     *
     * @param uri
     * return string
     */
    public static function parseURI($uri)
    {
        global $config;

        $categoryAlias = $config->seo->alias->category;
        $pageAlias     = $config->seo->alias->page;
        $forumAlias    = isset($config->seo->alias->forum) ? $config->seo->alias->forum : array();
        $methodAlias   = $config->seo->alias->method;
        $usercaseAlias = zget($config->seo->alias, 'usercase');

        $params = array();

        /* Is there a pageID variable in the url?  */
        $pageID = 0;
        if(preg_match('/\/p\d+$/', $uri, $matches))
        {
            $pageID = str_replace('/p', '', $matches[0]);    // Get pageID thus the flowing logic can use it.
            $uri    = str_replace($matches[0], '', $uri);    // Remove the pageID part from the url.
        }

        /* Split uri to items and try to get module and params from it. */
        $items  = explode('/', $uri);
        $module = $items[0];

        /* Use book instead of help. */
        if($module == 'help') $module = $items[0] = 'book';

        $isFormModule = isset($config->formModules) && is_array($config->formModules) && in_array($module, $config->formModules);
        /* There's no '/' in uri. */
        if(strpos($uri, '/') === false && !$isFormModule)
        {
            /* Use book instead of help. */
            if($uri == 'help') $uri = 'book';

            if($pageID and $module == 'blog' and count($items) == 1) 
            {
                $params['category'] = 0;
                return seo::convertURI($module, 'index', $params, $pageID);
            }

            if($pageID and $module == 'effect' and count($items) == 1) 
            {
                $params['category'] = 0;
                $params['mode'] = 0;
                return seo::convertURI($module, 'index', $params, $pageID);
            }

            /* Not an alias, return directly. */
            if(empty($categoryAlias[$uri])) return $uri;

            /* The module is an alias of a category. */
            $module = $categoryAlias[$uri]->module;
            $params['category'] = $categoryAlias[$uri]->category;
            return seo::convertURI($module, 'browse', $params, $pageID);
        }

        /* Is the module an alias of a category? */
        if(isset($categoryAlias[$module]))
        {
            $category = $categoryAlias[$module]->category;  // Get the category.
            $module   = $categoryAlias[$module]->module;    // Get the module of the alias category.

            /* If the first param is number, like article/123.html, should call view method. */
            if(is_numeric($items[1])) 
            {
                $params['id'] = $items[1];
                return seo::convertURI($module, 'view', $params, $pageID);
            }
            else
            {
                if(!empty($items[1]))
                {
                    $viewparams = explode('-', $items[1]);
                    $id = end($viewparams);
                }
                if(is_numeric($id))
                {
                    $params['id'] = $id;
                    return seo::convertURI($module, 'view', $params, $pageID);
                }
            }

            $params['category'] = $category;
            return seo::convertURI($module, 'browse', $params, $pageID);
        }

        //------------- The module is an system module-------------- */
        /* Is the module an alias of a page. */
        if($module == 'page' && isset($pageAlias[$items[1]]))
        {
            $params['page'] = $items[1];
            return seo::convertURI($module, 'view', $params, $pageID);
        }

        if($module == 'page' && !isset($pageAlias[$items[1]]))
        {
            $params['page'] = $items[1];
            return seo::convertURI($module, 'view', $params, $pageID);
        }

        /* Form modules. */
        if($isFormModule)
        {
            $params['formID'] = isset($items[1]) ? $items[1] : 0;
            $params['userID'] = isset($items[2]) ? $items[2] : 0;
            return seo::convertURI('form', 'view', $params, $pageID);
        }

        if($module == 'book')
        {
            if(count($items) > 2)
            {
                if(preg_match('/^c\d+$/', $items[2])) 
                {
                    $params = array('nodeID' => str_replace('c', '', $items[2]));
                    return seo::convertURI('book', 'browse', $params);
                }

                if(preg_match('/\w+-\d+$/', $items[2])) 
                {
                    $params = explode('-', $items[2]);
                    $params = array('articleID' => end($params));
                    
                    return seo::convertURI('book', 'read', $params);
                }
                elseif(is_numeric($items[2]))
                {
                    $params = array('articleID' => $items[2]);
                    return seo::convertURI('book', 'read', $params);
                }
                else
                {
                    $params = array('nodeID' => $items[2]);
                    return seo::convertURI('book', 'browse', $params);
                }
            }
            if(count($items) == 2 )
            {
                $params = array('nodeID' => $items[1]);
                return seo::convertURI('book', 'browse', $params);
            }
        }

        if($module == 'forum' && isset($forumAlias[$items[1]]))
        {
            $params['category'] = $items[1];
            $method = $methodAlias[$module]['browse'];
            return seo::convertURI($module, $method, $params, $pageID);
        }

        if($module == 'usercase' and $items[1] == 'area' and isset($items[2]))
        {
            $params['type'] = $items[1];
            $params['area'] = $items[2];
            $method = $methodAlias[$module]['browse'];
            return seo::convertURI($module, $method, $params, $pageID);
        }

        if($module == 'usercase' and $items[1] == 'industry' and isset($items[2]) and isset($usercaseAlias[$items[2]]))
        {
            $params['type']     = $items[1];
            $industry = $usercaseAlias[$items[2]];
            $params['category'] = $industry->id;
            $method = $methodAlias[$module]['browse'];
            return seo::convertURI($module, $method, $params, $pageID);
        }

        if($module == 'usercase' and isset( $items[2]) and  preg_match('/^c\d+$/', $items[2]))
        {
            $params['type'] = $items[1];
            $params['category'] = str_replace('c', '', $items[2]);
            $method = $methodAlias[$module]['browse'];
            return seo::convertURI($module, $method, $params, $pageID);
        }

        if($module == 'ask' and isset($items[2]))
        {
            if(is_numeric($items[1]) and is_numeric($items[2]))
            {
                $method = $methodAlias[$module]['view'];
                $params['questionID'] = $items[1];
                $params['answerID']   = $items[2];
            }
            else
            {
                if(preg_match('/^c\d+$/', $items[1])) $params['categoryID'] = str_replace('c', '', $items[1]);
                if(!preg_match('/^c\d+$/', $items[1])) $params['categoryID'] = $items[1];
                $params['type']       = $items[2];
                $method = $methodAlias[$module]['browse'];
            }
            return seo::convertURI($module, $method, $params, $pageID);
        }

        if($module == 'effect' and isset($items[2]))
        {
            if(is_numeric($items[1]) and is_numeric($items[2]))
            {
                $method = $methodAlias[$module]['view'];
                $params['categoryID'] = $items[1];
                $params['type']       = $items[2];
            }
            else
            {
                if(preg_match('/^c\d+$/', $items[1])) $params['categoryID'] = str_replace('c', '', $items[1]);
                if(!preg_match('/^c\d+$/', $items[1])) $params['categoryID'] = $items[1];
                $params['type'] = $items[2];
                $method         = $methodAlias[$module]['browse'];
            }
            return seo::convertURI($module, $method, $params, $pageID);
        }
        elseif($module == 'effect')
        {
            if(preg_match('/^\d+$/', $items[1])) 
            {
               $params['effectID'] = $items[1];
               return seo::convertURI($module, 'view', $params, $pageID);
            }

            if(preg_match('/^\w+-\d+$/', $items[1])) 
            {
               list($category, $params['effectID']) = explode('-', $items[1]);
               return seo::convertURI($module, 'view', $params, $pageID);
            }

            if(preg_match('/^c\d+$/', $items[1])) 
            {
                $params['categoryID'] = str_replace('c', '', $items[1]);
                $params['type'] = 'all';
                return seo::convertURI($module, 'index', $params, $pageID);
            }

            if(preg_match('/^\w+$/', $items[1])) 
            {
               $params['categoryID'] = $items[1];
               $params['mode'] = 'all';
               return seo::convertURI($module, 'index', $params, $pageID);
            }
        }

        if($module == 'faq' and isset($items[1]))
        {
            $params['mode'] = $items[1];
            if(isset($items[2]) and preg_match('/^c\d+$/', $items[2])) $params['objectID'] = str_replace('c', '', $items[2]);
            if(isset($items[3])) $params['orderBy'] = $items['3'];
            $method = $methodAlias[$module]['browse'];
            return seo::convertURI($module, $method, $params, $pageID);
        }

        /*  If the first param is a category id, like news/c123.html. */
        if(preg_match('/^c\d+$/', $items[1]))
        {
            $params['category'] = str_replace('c', '', $items[1]);
            $method = $methodAlias[$module]['browse'];
            return seo::convertURI($module, $method, $params, $pageID);
        }

        /* The first param is an object id. */
        if(is_numeric($items[1]))
        {
            $params['id'] = $items[1];
            $method = $methodAlias[$module]['view'];
            return seo::convertURI($module, $method, $params, $pageID);
        }

        $viewparams = explode('-', $items[1]);
        if(count($viewparams) > 1)
        {
            $id = end($viewparams);
            if(is_numeric($id))
            {
                $params['id'] = $id;
                $method = $methodAlias[$module]['view'];
                return seo::convertURI($module, $method, $params, $pageID);
            }
            else
            {
                $params['id'] = $items[1];
                $method = $methodAlias[$module]['browse'];
                return seo::convertURI($module, $method, $params, $pageID);
            }
        }
        else
        {
            /* The first param is a category alias. */
            $params['category'] = $items[1]; 
        }

        $method = isset($methodAlias[$module]['browse']) ? $methodAlias[$module]['browse'] : 'browse';

        return seo::convertURI($module, $method, $params, $pageID);
    }

    /**
     * Convert seo mode URI to normal mode.
     * 
     * @param string $module
     * @param string $method
     * @param string $params
     * @param int $pageID
     * return string
     */
    public static function convertURI($module, $method, $param = array(), $pageID = 0)
    {
        $uri = "$module-$method";
        foreach($param as $value) $uri .= '-' . str_replace('-', '.', $value);
        if($pageID > 0) $uri .= "-$pageID";
        return $uri;
    }

    /**
     * Unify string to standard chars.
     * 
     * @param  string    $string 
     * @param  string    $to 
     * @static
     * @access public
     * @return string
     */
    public static function unify($string, $to = ',', $trim = false)
    {
        if($trim) $string = str_replace(' ', '', $string);
        $labels = array('_', '、', '-', '\n', '?', '@', '&', '%', '~', '`', '+', '*', '/', '\\', '，', '。');
        $string = str_replace($labels, $to, $string);
        return preg_replace("/[{$to}]+/", $to, trim($string, $to));
    }
}

/**
 * The uri class.
 *
 * @package seo
 */
class uri
{
    /**
     * Create article browse
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */
    public static function createArticleBrowse($params, $alias, $viewType = '')
    {
        global $config;

        $link = 'article/c' . array_shift($params);
        if(!empty($alias['category'])) $link = $alias['category'];

        $viewType = $viewType ? $viewType : $config->default->view;

        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create article view
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */
    public static function createArticleView($params, $alias, $viewType = '')
    {
        global $config;

        $link = 'article/';
        if(!empty($alias['category'])) $link = $alias['category'] . '/';
        if(!empty($alias['name'])) $link .= $alias['name'] . '-';
        $link .= array_shift($params);

        $viewType = $viewType ? $viewType : $config->default->view;

        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create video browse
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */
    public static function createVideoBrowse($params, $alias, $viewType = '')
    {
        global $config;

        $link = 'video/c' . array_shift($params);
        if(!empty($alias['category'])) $link = $alias['category'];

        $viewType = $viewType ? $viewType : $config->default->view;

        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create video view
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * @return string
     */
    public static function createVideoView($params, $alias, $viewType = '')
    {
        global $config;

        $link = 'video/';
        if(!empty($alias['category'])) $link = $alias['category'] . '/';
        if(!empty($alias['name'])) $link .= $alias['name'] . '-';
        $link .= array_shift($params);

        $viewType = $viewType ? $viewType : $config->default->view;

        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create form view.
     *
     * @param  array  $params
     * @param  array  $alias
     * @param  string $viewType
     * @static
     * @access public
     * @return string
     */
    public static function createFormView($params, $alias, $viewType = '')
    {
        global $config;

        $link = 'form/';
        if(!empty($alias['type'])) $link = $alias['type'] . '/';
        $link .= array_shift($params);
        if($params) $link .= '/' . array_shift($params);

        $viewType = $viewType ? $viewType : $config->default->view;

        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create article view
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */

    public static function createProductBrowse($params, $alias, $viewType = '')
    {
        global $config;
        
        $link = 'product/c' . array_shift($params);
        if(!empty($alias['category'])) $link = $alias['category'];

        $viewType = $viewType ? $viewType : $config->default->view;

        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create product view
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */
    public static function createProductView($params, $alias, $viewType = '')
    {
        global $config;

        $link = 'product/';
        if(!empty($alias['category'])) $link = $alias['category'] . '/';
        if(!empty($alias['name'])) $link .= $alias['name'] . '-';
        $link .= array_shift($params);

        $viewType = $viewType ? $viewType : $config->default->view;
        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create forum board.
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */
    public static function createForumBoard($params, $alias, $viewType = '')
    {
        global $config;

        $link = 'forum/';
        $link .= !empty($alias['category']) ? $alias['category'] : 'c' . array_shift($params);

        $viewType = $viewType ? $viewType : $config->default->view;
        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create thread view.
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */
    public static function createThreadView($params, $alias, $viewType = '')
    {
        global $config;
        $viewType = $viewType ? $viewType : $config->default->view;

        $link = 'thread/' . array_shift($params);

        if(isset($alias['pageID']))  $link .= '/p' . $alias['pageID'];
        $link .= '.' . $viewType;
        if(isset($alias['replyID'])) $link .= '#'  . $alias['replyID'];

        return  $config->webRoot . $link;
    }

    /**
     * Create blog index.
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */
    public static function createBlogIndex($params, $alias, $viewType = '')
    {
        global $config;
        $viewType = $viewType ? $viewType : $config->default->view;

        $link = $config->webRoot . 'blog';
        if(isset($alias['category']) and trim($alias['category']) != '') return $link . '/' . $alias['category'] . '.' . $viewType;
        if(!empty($params)) return $link . '/c' . array_shift($params) . '.' . $viewType;
        return $link . '.' . $viewType;
    }

    /**
     * Create blog view.
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */
    public static function createBlogView($params, $alias, $viewType = '')
    {
        global $config;

        $link = 'blog/';
        if($alias['name']) $link .= $alias['name'] . '-';
        $link .= array_shift($params);
        $viewType = $viewType ? $viewType : $config->default->view;
        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create book book.
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */
    public static function createBookBrowse($params, $alias, $viewType = '')
    {
        global $config;
        $viewType = $viewType ? $viewType : $config->default->view;

        $link = 'book/' . $alias['book'];
        if(!isset($alias['node'])) return $config->webRoot . $link . '.' . $viewType;
        if($alias['node'])  return $config->webRoot . $link . '/' . $alias['node'] . '.' . $viewType;
        if(!$alias['node']) return $config->webRoot . $link . '/c' . array_shift($params). '.' . $viewType;
    }

    /**
     * Create book read.
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */
    public static function createBookRead($params, $alias, $viewType = '')
    {
        global $config;
        $viewType = $viewType ? $viewType : $config->default->view;

        $link = 'book/';
        if(!empty($alias['book'])) $link .= $alias['book'] . '/';
        if(!empty($alias['node'])) $link .= $alias['node'] . '-';
        $link .= array_shift($params);

        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create page view
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */
    public static function createPageView($params, $alias, $viewType = '')
    {
        global $config;
        $viewType = $viewType ? $viewType : $config->default->view;

        $link = 'page/' . array_shift($params);
        if($alias['name']) $link = 'page/' . $alias['name'];

        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create ask browse.
     *
     * @params array    $params
     * @params string   $viewType  
     * return string
     */
    public static function createAskIndex($params, $alias, $viewType = '')
    {
        global $config;

        $viewType = $viewType ? $viewType : $config->default->view;
        if(empty($params)) return $config->webRoot . 'ask.' . $viewType;

        $categoryID = array_shift($params);
        $type       = array_shift($params);
        if(!empty($alias['name']))
        {
            $link = $config->webRoot . 'ask' . '/' . $alias['name'];
            if($type) $link .= '/' . $type;
            return $link . '.' . $viewType;
        }
 
        $link = 'ask/c';
        $link .= is_numeric($categoryID) ? $categoryID : 0;
        if($type) $link .= '/' . $type;
        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create ask view.
     *
     * @params array    $params
     * @params string   $viewType  
     * return string
     */
    public static function createAskView($params, $viewType = '')
    {
        global $config;

        $questionID = array_shift($params);
        $answerID   = array_shift($params);

        $link = 'ask/' . $questionID;
        if($answerID and is_numeric($answerID)) $link .= '/' . $answerID;

        $viewType = $viewType ? $viewType : $config->default->view;
        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create faq index.
     * 
     * @param  array   $params 
     * @param  array   $alias 
     * @param  string  $viewType 
     * @static
     * @access public
     * @return string
     */
    public static function createFaqIndex($params, $alias, $viewType = '')
    {
        global $config;

        $viewType = $viewType ? $viewType : $config->default->view;
        if(empty($params)) return $config->webRoot . 'faq.' . $viewType;

        $mode     = array_shift($params);
        $objectID = array_shift($params);
        $orderBy  = array_shift($params);

        $link = 'faq/';
        if($mode) $link .= $mode;
        $link .= '/c' . (is_numeric($objectID) ? $objectID : 0);
        if($orderBy) $link .= '/' . $orderBy;
        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create effect index.
     * 
     * @param  array   $params 
     * @param  array   $alias 
     * @param  string  $viewType 
     * @static
     * @access public
     * @return string
     */
    public static function createEffectIndex($params, $alias, $viewType = '')
    {
        global $config;

        $viewType = $viewType ? $viewType : $config->default->view;
        if(empty($params)) return $config->webRoot . 'effect.' . $viewType;

        $categoryID = array_shift($params);
        $mode       = array_shift($params);
        if(!empty($alias['name']))
        {
            $link = $config->webRoot . 'effect' . '/' . $alias['name'];
            if($mode) $link .= '/' . $mode;
            return $link . '.' . $viewType;
        }
 
        $link = 'effect/c';
        $link .= is_numeric($categoryID) ? $categoryID : 0;
        if($mode) $link .= '/' . $mode;
        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create effect view
     *
     * @params array    $params
     * @params array    $alias  
     * @params string   $viewType  
     * return string
     */
    public static function createEffectView($params, $alias, $viewType = '')
    {
        global $config;

        $link = 'effect/';
        if(!empty($alias['category'])) $link .= $alias['category'] . '-';
        $link .= array_shift($params);

        $viewType = $viewType ? $viewType : $config->default->view;

        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create usercase browse.
     *
     * @params array    $params
     * @params string   $viewType  
     * return string
     */
    public static function createUsercaseBrowse($params, $viewType = '')
    {
        global $config;
        $type = array_shift($params);
        $id   = array_shift($params);
        $link = 'usercase/' . $type;
        if(is_numeric($id)) $id = 'c' . $id;
        $link .= '/' . $id;

        $viewType = $viewType ? $viewType : $config->default->view;
        return $config->webRoot . $link . '.' . $viewType;
    }

    /**
     * Create usercase view.
     *
     * @params array    $params
     * @params string   $viewType  
     * return string
     */
    public static function createUsercaseView($params, $viewType = '')
    {
        global $config;

        $link = 'usercase/' . array_shift($params);

        $viewType = $viewType ? $viewType : $config->default->view;
        return $config->webRoot . $link . '.' . $viewType;
    }
}
