<?php
/**
 * The router, config and lang class file of ZenTaoPHP framework.
 *
 * The author disclaims copyright to this source code.  In place of
 * a legal notice, here is a blessing:
 *
 *  May you do good and not evil.
 *  May you find forgiveness for yourself and forgive others.
 *  May you share freely, never taking more than you give.
 */

define('FRAME_ROOT', dirname(__FILE__));
include FRAME_ROOT . '/base/router.class.php';

/**
 * The router class.
 *
 * @package framework
 */
class router extends baseRouter
{ 
    /**
     * The construct function.
     * 
     * Prepare all the paths, classes, super objects and so on.
     * Notice: 
     * 1. You should use the createApp() method to get an instance of the router.
     * 2. If the $appRoot is empty, the framework will comput the appRoot according the $appName
     *
     * @param string $appName   the name of the app 
     * @param string $appRoot   the root path of the app
     * @access protected
     * @return void
     */
    public function __construct($appName = 'demo', $appRoot = '')
    {
        parent::__construct($appName, $appRoot);
        $this->fixLangConfig();
    }

    /**
     * 创建一个应用。
     * Create an application.
     * 
     * @param string $appName   应用名称。  The name of the app.
     * @param string $appRoot   应用根路径。The root path of the app.
     * @param string $className 应用类名，如果对router类做了扩展，需要指定类名。When extends router class, you should pass in the child router class name.
     * @static
     * @access public
     * @return object   the app object
     */
    public static function createApp($appName = 'demo', $appRoot = '', $className = '')
    {
        if(empty($className)) $className = __CLASS__;
        return new $className($appName, $appRoot);
    }
    
    /**
     * Get template root.
     * 
     * @access public
     * @return string
     */
    public function getTplRoot()
    {
        return $this->appRoot . 'template' . DS;
    }

    /**
     * Set client theme.
     *
     * @param   string $theme   
     * @access  public
     * @return  void
     */
    public function setClientTheme($theme = '')
    {
        if(isset($this->config->client->theme)) $this->clientTheme = $this->config->client->theme;
        if(isset($_COOKIE['theme']))            $this->clientTheme = $_COOKIE['theme'];
        if(!empty($theme))                      $this->clientTheme = $theme;

        if(!empty($this->clientTheme))
        {
            $this->clientTheme = strtolower($this->clientTheme);
            if(!isset($this->lang->themes[$this->clientTheme])) $this->clientTheme = $this->config->default->theme;
        }    
        else
        {
            $this->clientTheme = $this->config->default->theme;
        }

        setcookie('theme', $this->clientTheme, $this->config->cookieLife, $this->config->cookiePath, '', false, true);
        if(!isset($_COOKIE['theme'])) $_COOKIE['theme'] = $this->clientTheme;

        return true;
    }

    /**
     * Set client device.
     * 
     * @access public
     * @return void
     */
    public function setClientDevice()
    {
        $deviceCookieVar = RUN_MODE . 'Device';
        if(!$this->cookie->{$deviceCookieVar} || (strpos('mobile,desktop', $this->cookie->{$deviceCookieVar}) === false)) 
        {
            $mobile = new mobile();
            $device = ($mobile->isMobile() and !$mobile->isTablet()) ? 'mobile' : 'desktop';
        }
        else
        {
            $device = $this->cookie->{$deviceCookieVar};
        }

        if(RUN_MODE == 'admin' && strpos('mobile,desktop', $this->session->device) !== false) $device = $this->session->device;

        setcookie($deviceCookieVar, $device, $this->config->cookieLife, $this->config->cookiePath, '', false, true);
        $this->cookie->set($deviceCookieVar, $device);

        $pathInfo = $this->getPathInfo();
        $dotPos   = strrpos($pathInfo, '.');
        $viewType = substr($pathInfo, $dotPos + 1);
        if($viewType == 'mhtml')
        {
            $device = 'mobile';
            setcookie($deviceCookieVar, '', time() - 3600, $this->config->cookiePath, '', false, true);
            $this->cookie->set($deviceCookieVar, '');
        }

        if($this->cookie->visualDevice and RUN_MODE == 'front') $device = $this->cookie->visualDevice;
        $this->clientDevice = $device;

        return $this->clientDevice;
    }

    /**
     * Load cache class.
     * 
     * @access public
     * @return void
     */
    public function loadCacheClass()
    {
        $this->loadClass('cache', $static = true);
        $this->config->cache->file->savePath = $this->getTmpRoot() . 'cache';
        if($this->config->framework->multiSite) $this->config->cache->file->savePath = $this->getTmpRoot() . 'cache' . DS . $this->siteCode;

        $cacheConfig = zget($this->config->cache, $this->config->cache->type);
        if(is_object($cacheConfig)) $cacheConfig->lang = $this->getClientLang();

        $this->cache = cache::factory($this->config->cache->type, $cacheConfig);
    }

    /**
     * Clear caches.
     * 
     * @access public
     * @return void
     */
    public function clearCache()
    {
        if(empty(dao::$changedTables)) return true;
        foreach(dao::$changedTables as $table)
        {
            $items = zget($this->config->cache->relation, $table);
            $blocks[] = zget($items, 'blocks');
            $pages[]  = zget($items, 'pages');
        }

        $blocks = join(',', $blocks);
        $pages  = join(',', $pages);
        
        $blocks = array_unique(explode(',', $blocks));
        $pages  = array_unique(explode(',', $pages));
        
        foreach($blocks as $block) 
        {
            if(empty($block)) continue;
            if(isset($this->cache)) $this->cache->clear("block/{$block}*");
        }

        if($this->config->cache->cachePage != 'close')
        {
            foreach($pages as $page) 
            {
                if(empty($page)) continue;
                if($page == '/')
                {
                    $key = 'page' . DS . $this->clientDevice . DS . '*';
                }
                else
                {
                    $page = str_replace('.', '_', $page);
                    $key  = 'page' . DS . $this->clientDevice . DS . $page . DS . '*';
                }
                if(isset($this->cache)) $this->cache->clear($key);
            }
        }
        return true;
    }

    /**
     * Set lang code.
     * 
     * @access public
     * @return void
     */
    public function fixLangConfig()
    {
        $langCode = $this->clientLang == $this->config->default->lang ? '' : $this->config->langsShortcuts[$this->clientLang];
        $this->config->langCode = $langCode;
    }

    /**
     * The entrance of parseing request. According to the requestType, call related methods.
     * 
     * @access public
     * @return void
     */
    public function parseRequest()
    {
        if(isset($_GET['m']) and isset($_GET['f'])) $this->config->requestType = 'GET';
        if($this->config->requestType != 'GET')
        {
            $this->parsePathInfo();

            $langCode = $this->config->langsShortcuts[$this->clientLang];
            if(strpos($this->URI, $langCode) === 0) $this->URI = substr($this->URI, strlen($langCode) + 1);

            $this->URI = seo::parseURI($this->URI);

            $this->setRouteByPathInfo();
        }
        elseif($this->config->requestType == 'GET')
        {
            $this->parseGET();
            $this->setRouteByGET();
        }
        else
        {
            $this->triggerError("The request type {$this->config->requestType} not supported", __FILE__, __LINE__, $exit = true);
        }
        if(defined('REAL_REQUEST_TYPE') and strpos('PATH_INFO2', REAL_REQUEST_TYPE) !== false) $this->config->requestType = REAL_REQUEST_TYPE;
    }

    /**
     * Override set control file logic, use modulePath instead of moduleRoot and moduleName.
     * 
     * @access  public
     * @return  bool
     */
    public function setControlFile($exitIfNone = true)
    {
        $modulePath = $this->getModulePath();
        $this->controlFile = $modulePath . DS . 'control.php';

        if(is_file($this->controlFile)) return true;

        if(RUN_MODE == 'front' && $this->getModuleName() != 'error') 
        {
            if($this->server->request_uri == '/favicon.ico') die();
            $this->setModuleName('errors');
            $this->setMethodName('index');
            return $this->setControlFile();
        }
        
        $this->triggerError("the control file $this->controlFile not found.", __FILE__, __LINE__, $exitIfNone);
    }

    /**
     * Extends get module path logic. 
     * If the module path doesn't exist and extensionLevel == 2, return the ext directory of site below module root.
     * 
     * @param  string $appName    the app name
     * @param  string $moduleName    the module name
     * @access public
     * @return string the module path
     */
    public function getModulePath($appName = '', $moduleName = '')
    {
        if($moduleName == '') $moduleName = $this->moduleName;
        $modulePath = parent::getModulePath($appName, $moduleName);
        if(!file_exists($modulePath) && $this->config->framework->extensionLevel == 2) 
        {
            $modulePath = $this->getModuleRoot() . 'ext' . DS . '_' . $this->siteCode . DS . $moduleName . DS;
        }
        return $modulePath;
    }

    /**
     * Extends get module ext path logic. 
     * If the extensionLevel == 2, use the ext directory of site below module root as site extension directory.
     *
     * @param   string $appName        the app name
     * @param   string $moduleName     the module name
     * @param   string $ext            the extension type, can be control|model|view|lang|config
     * @access  public
     * @return  string the extension path.
     */
    public function getModuleExtPath($appName, $moduleName, $ext)
    {
        $paths = parent::getModuleExtPath($appName, $moduleName, $ext);

        $modulePath = parent::getModulePath($appName, $moduleName);
        if(!file_exists($modulePath) && $this->config->framework->extensionLevel == 2)
        {
            $modulePath = $this->getModuleRoot() . 'ext' . DS . '_' . $this->siteCode . DS . $moduleName . DS;
            $paths['site'] = $modulePath . $ext . DS;
        }
        return $paths;
    }

    /**
     * Extend page cache logics.
     * 
     * @access public
     * @return void
     */
    public function loadModule()
    {
        $moduleName = $this->moduleName;
        $methodName = $this->methodName;
        if(RUN_MODE == 'front') commonModel::processPre($moduleName, $methodName);

        if(RUN_MODE == 'front' and $this->server->request_method != 'POST' and $this->config->cache->type != 'close' and $this->config->cache->cachePage == 'open')
        {
            if(commonModel::needClearCache())
            {
                dao::$changedTables[] = TABLE_CONFIG;
                $this->clearCache();
            }

            if(strpos($this->config->cache->cachedPages, "$moduleName.$methodName") !== false)
            {
                if(!isset($this->clientDevice) or empty($this->clientDevice)) $this->clientDevice = 'desktop';
                $key   = 'page' . DS . $this->clientDevice . DS . $moduleName . '_' . $methodName . DS . md5($_SERVER['REQUEST_URI']);
                $cache = $this->cache->get($key);
                if($cache)
                {
                    $siteNav = commonModel::printTopBar() . commonModel::printLanguageBar();
                    $cache   = str_replace($this->config->siteNavHolder, $siteNav, $cache);

                    if($this->config->site->execInfo == 'show') $cache = str_replace($this->config->execPlaceholder, helper::getExecInfo(), $cache);
                    
                    if(in_array($moduleName . '_' . $methodName, $this->config->replaceViewsPages))
                    {
                        $viewsID = commonModel::parseItemID($moduleName, $methodName);
                        $views   = commonModel::getViews($moduleName, $methodName, $viewsID);
                        $cache   = str_replace($this->config->viewsPlaceholder, $views, $cache);
                    }
                    
                    if(in_array($moduleName . '_' . $methodName, $this->config->replaceViewsListPages))
                    {
                        $beginPos    = strpos($cache, $this->config->idListPlaceHolder) + strlen($this->config->idListPlaceHolder);
                        $length      = strrpos($cache, $this->config->idListPlaceHolder) - $beginPos; 
                        $viewsIDList = explode(',', trim(substr($cache, $beginPos, $length), ',')); 
                        $viewsList   = commonModel::getViews($moduleName, $methodName, $viewsIDList);
                        foreach($viewsList as $viewID => $views)
                        {
                            $cache = str_replace($this->config->viewsPlaceholder . $viewID . $this->config->viewsPlaceholder, $views, $cache);
                        }
                    }
                    
                    $keywords   = ($this->getModuleName() == 'search') ? $this->session->searchIngWord : '';
                    $searchHtml = html::input('words', $keywords, "class='form-control' placeholder=''");
                    $cache      = str_replace($this->config->searchWordPlaceHolder, $searchHtml, $cache);

                    if(is_callable(array('extcommonModel', 'processCache'))) $cache = extcommonModel::processCache($cache);
                    die($cache);
                }
            }
        }

        parent::loadModule();
    }

    /**
     * 设置请求的参数(PATH_INFO 方式)。
     * Set the params by PATH_INFO.
     * 
     * @param   array $defaultParams the default settings of the params.
     * @access  public
     * @return  void
     */
    public function setParamsByPathInfo($defaultParams = array(), $type = '')
    {
        $params = array();
        if($type != 'fetch')
        {
            /* 分割URI。 Spit the URI. */
            $items     = explode($this->config->requestFix, $this->URI);
            $itemCount = count($items);

            /** 
             * 前两项为模块名和方法名，参数从下标2开始。
             * The first two item is moduleName and methodName. So the params should begin at 2.
             **/
            for($i = 2; $i < $itemCount; $i ++)
            {
                $key = key($defaultParams);     // Get key from the $defaultParams.
                if(empty($key)) continue;

                $params[$key] = str_replace('.', '-', $items[$i]);
                next($defaultParams);
            }
        }

        $this->params = $this->mergeParams($defaultParams, $params);
    }

    /**
     * 加载语言文件，返回全局$lang对象。
     * Load lang and return it as the global lang object.
     * 
     * @param   string $moduleName     the module name
     * @param   string $appName     the app name
     * @access  public
     * @return  bool|object the lang object or false.
     */
    public function loadLang($moduleName, $appName = '')
    {
        /* 初始化变量。Init vars. */
        $modulePath      = $this->getModulePath($appName, $moduleName);
        $extLangFiles    = array();
        $langFilesToLoad = array();

        /* 判断主语言文件是否存在。Whether the main lang file exists or not. */
        $mainLangFile = $modulePath . 'lang' . DS . $this->clientLang . '.php';
        if(file_exists($mainLangFile)) $langFilesToLoad[] = $mainLangFile;

        /* 获取前台语言文件。Get template lang files. */
        $templateLangPath = $this->getTplRoot() . $this->config->template->{$this->clientDevice}->name . DS . '_lang' . DS . $moduleName . DS; 
        $templateLangFile = $templateLangPath . $this->clientLang . '.php';
        if(file_exists($templateLangFile)) $langFilesToLoad[] = $templateLangFile;

        /* 获取扩展语言文件。If extensionLevel > 0, get extension lang files. */
        if($this->config->framework->extensionLevel > 0)
        {
            $commonExtLangFiles = array();
            $siteExtLangFiles   = array();

            $extLangPath = $this->getModuleExtPath($appName, $moduleName, 'lang');
            if($this->config->framework->extensionLevel >= 1 and !empty($extLangPath['common'])) $commonExtLangFiles = helper::ls($extLangPath['common'] . $this->clientLang, '.php');
            if($this->config->framework->extensionLevel == 2 and !empty($extLangPath['site']))   $siteExtLangFiles   = helper::ls($extLangPath['site'] . $this->clientLang, '.php');
            $extLangFiles  = array_merge($commonExtLangFiles, $siteExtLangFiles);
        }

        /* 计算最终要加载的语言文件。 Get the lang files to be loaded. */
        $langFilesToLoad = array_merge($langFilesToLoad, $extLangFiles);
        if(empty($langFilesToLoad)) return false;


        /* 加载语言文件。Load lang files. */
        global $lang;
        if(!is_object($lang)) $lang = new language();
        if(!isset($lang->$moduleName)) $lang->$moduleName = new stdclass();

        static $loadedLangs = array();
        foreach($langFilesToLoad as $langFile)
        {
            if(in_array($langFile, $loadedLangs)) continue;
            include $langFile;
            $loadedLangs[] = $langFile;
        }

        $this->lang = $lang;
        return $lang;
    }

    /**
     * Set the language used by the client user.
     * 
     * @param   string $lang  zh-cn|zh-tw|en
     * @access  public
     * @return  void
     */
    public function setClientLang($lang = '')
    {
        $langCookieVar = RUN_MODE . 'Lang';
        if((RUN_MODE == 'front' or RUN_MODE == 'admin') and $this->config->installed)
        {
            $enabledLangs = $this->config->enabledLangs;
            $defaultLang  = $this->config->defaultLang;
                
            if(!empty($enabledLangs)) $enabledLangs = explode(',', $enabledLangs);
            if(isset($defaultLang) && isset($this->config->langs[$defaultLang])) $this->config->default->lang = $defaultLang;
        }

        if(!isset($this->config->langs[$this->config->default->lang])) $this->config->default->lang = current(array_keys($this->config->langs));

        if(empty($lang) and RUN_MODE == 'front')
        {
            if(strpos($this->server->http_referer, 'm=visual') !== false and !empty($_COOKIE['adminLang'])) 
            {
                $lang = $_COOKIE['adminLang'];
            }
            else
            {
                $flipedLangs = array_flip($this->config->langsShortcuts);
                if($this->config->requestType == 'GET' and !empty($_GET[$this->config->langVar])) $lang = $flipedLangs[$_GET[$this->config->langVar]];
                if($this->config->requestType == 'GET' and empty($_GET[$this->config->langVar])) $lang = $this->config->default->lang;
                if($this->config->requestType != 'GET')
                {
                    $pathInfo = $this->getPathInfo();
                    $langFromPathInfo = '';
                    foreach($this->config->langsShortcuts as $language => $code)
                    {
                        if(strpos(trim($pathInfo, '/'), $code) === 0) $langFromPathInfo = $language;
                    }
                    if(empty($langFromPathInfo)) $langFromPathInfo = $this->config->default->lang;
                    $lang = $langFromPathInfo;
                }
            }
        }

        if(empty($lang) and isset($_COOKIE[$langCookieVar])) 
        {
            $lang = $_COOKIE[$langCookieVar];
        }

        if(empty($lang) and RUN_MODE == 'admin' and isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
        {
            $lang = strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], ',') === false ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, strpos($_SERVER['HTTP_ACCEPT_LANGUAGE'], ','));
        }

        if(!empty($lang) and isset($this->config->langs[$lang])) 
        {
            $this->clientLang = $lang;
        }
        else
        {
            $this->clientLang = $this->config->default->lang;
        }
        
        if(strpos($this->config->enabledLangs, $this->clientLang) === false) $this->clientLang = $this->config->defaultLang; 
        if(RUN_MODE == 'admin' and isset($this->config->cn2tw) and $this->config->cn2tw and $this->clientLang == 'zh-tw') $this->clientLang = 'zh-cn';

        setcookie($langCookieVar, $this->clientLang, $this->config->cookieLife, $this->config->cookiePath, '', false, true);
        if(!isset($_COOKIE[$langCookieVar])) $_COOKIE[$langCookieVar] = $this->clientLang;
        
        return $this->clientLang;
    }
   
    /**
     * The shutdown handler.
     * 
     * @access public
     * @return void
     */
    public function shutdown()
    {
        /* If cache on, clear caches. */
        if($this->config->cache->type != 'close') $this->clearCache();
        if(RUN_MODE == 'admin') $this->setUpdatedTime();
        parent::shutdown();
    }
    
    /**
     * Set super vars.
     * 
     * @access public
     * @return void
     */
    public function setSuperVars()
    {
        parent::setSuperVars();
        $_POST = validater::filterConfigPlaceholder($_POST);
    }

	/**
	 * Set updatedTime to refresh source.
	 * 
	 * @access public
	 * @return bool
	 */
	public function setUpdatedTime()
	{
		if(empty(dao::$changedTables)) return true;

		$setting = new stdclass;
		$setting->owner   = 'system';
		$setting->module  = 'common';
		$setting->section = 'site';
		$setting->key     = 'updatedTime';
		$setting->value   = time();
		$setting->lang    = 'all';

        $dao = new dao();
		$dao->replace(TABLE_CONFIG)->data($setting)->exec();
        return !dao::isError();
    }
}
