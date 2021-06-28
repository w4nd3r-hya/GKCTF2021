<?php
/**
 * The control class file of ZenTaoPHP framework.
 *
 * The author disclaims copyright to this source code.  In place of
 * a legal notice, here is a blessing:
 *
 *  May you do good and not evil.
 *  May you find forgiveness for yourself and forgive others.
 *  May you share freely, never taking more than you give.
 */

include FRAME_ROOT . '/base/control.class.php';

/**
 * The base class of control.
 *
 * @package framework
 */
class control extends baseControl
{
    /**
     * The construct function.
     *
     * 1. global the global vars, refer them by the class member such as $this->app.
     * 2. set the pathes of current module, and load it's mode class.
     * 3. auto assign the $lang and $config to the view.
     * 
     * @access public
     * @return void
     */
    public function __construct($moduleName = '', $methodName = '')
    {
        parent::__construct($moduleName, $methodName);

        $this->setClientDevice();
        $this->setTplRoot();
        $this->setHttpReferer();

        if(RUN_MODE == 'front') $this->view->layouts = $this->loadModel('block')->getPageBlocks($this->moduleName, $this->methodName);
    }

    /**
     * Set the prefix of view file for mobile or PC.
     * 
     * @access public
     * @return void
     */
    public function setDevicePrefix()
    {
        $this->devicePrefix = '';
        if(RUN_MODE == 'front')
        {
            if($this->app->clientDevice == 'mobile') $this->devicePrefix = 'm.';
        }
    }

    /**
     * Set referer.
     * 
     * @access public
     * @return void
     */
    public function setHttpReferer()
    {
        if($this->session->http_referer) return true;

        if(!empty($_SERVER['HTTP_REFERER']))
        {
            $refererInfo = parse_url($_SERVER['HTTP_REFERER']);
            $referer     = $_SERVER['HTTP_REFERER'];
            if($this->server->http_host == $refererInfo['host']) $referer = '';
            $this->session->set('http_referer', $referer);
        }
        return true;
    }

    /**
     * Set TPL_ROOT used in template files.
     * 
     * @access public
     * @return void
     */
    public function setTplRoot()
    {
        if(!defined('TPL_ROOT')) define('TPL_ROOT', $this->app->getAppRoot() . 'template' . DS . $this->config->template->{$this->app->clientDevice}->name . DS);
    }

    /**
     * Set the view file, thus can use fetch other module's page.
     * 
     * @param  string   $moduleName    module name
     * @param  string   $methodName    method name
     * @access private
     * @return string  the view file
     */
    public function setViewFile($moduleName, $methodName)
    {
        $moduleName = strtolower(trim($moduleName));
        $methodName = strtolower(trim($methodName));

        $modulePath  = $this->app->getModulePath($this->appName, $moduleName);
        $viewExtPath = $this->app->getModuleExtPath($this->appName, $moduleName, 'view');

        $viewType     = $this->viewType == 'mhtml' ? 'html' : $this->viewType;
        $mainViewFile = $modulePath . 'view' . DS . $this->devicePrefix . $methodName . '.' . $viewType . '.php';
        $viewFile     = $mainViewFile;

        if(RUN_MODE == 'front')
        {
            $templatePath = TPL_ROOT . $moduleName;
            $viewFile     = str_replace(($this->app->getModulePath('', $moduleName) . 'view'), $templatePath, $viewFile);
            
            if($this->devicePrefix == 'm.' and !is_file($viewFile))
            {
                $viewFile = $templatePath . DS . "{$methodName}.{$viewType}.php";
            }
            $mainViewFile = $viewFile;

            $tmpViewFolder = $this->config->framework->multiSite ? $this->app->getTmpRoot() . 'template' . DS . $this->app->siteCode : $this->app->getTmpRoot() . 'template';
            $customedFile  = str_replace($this->app->getAppRoot() . 'template', $tmpViewFolder, $mainViewFile);
            if(file_exists($customedFile))
            {
                $viewFile     = $customedFile;  
                $mainViewFile = $viewFile;
            }
        }

        if(!empty($viewExtPath))
        {
            $commonExtViewFile = $viewExtPath['common'] . $this->devicePrefix . $methodName . ".{$viewType}.php";
            if(!file_exists($commonExtViewFile)) $commonExtViewFile = $viewExtPath['common'] . $methodName . ".{$viewType}.php";
            $siteExtViewFile   = empty($viewExtPath['site']) ? '' : $viewExtPath['site'] . $this->devicePrefix . $methodName . ".{$viewType}.php";
            if(!file_exists($siteExtViewFile)) $siteExtViewFile   = empty($viewExtPath['site']) ? '' : $viewExtPath['site'] . $methodName . ".{$viewType}.php";

            $viewFile = file_exists($commonExtViewFile) ? $commonExtViewFile : $mainViewFile;

            $viewFile = (!empty($siteExtViewFile) and file_exists($siteExtViewFile)) ? $siteExtViewFile : $viewFile;
            if(!is_file($viewFile)) $this->app->triggerError("the view file $viewFile not found", __FILE__, __LINE__, $exit = true);

            $hookExtension      = RUN_MODE == 'front' ? 'hook.tpl.php' : 'hook.php';
            $commonExtHookFiles = glob($viewExtPath['common'] . $this->devicePrefix . $methodName . ".*.{$viewType}.{$hookExtension}");
            $siteExtHookFiles   = empty($viewExtPath['site']) ? '' : glob($viewExtPath['site'] . $this->devicePrefix . $methodName . ".*.{$viewType}.{$hookExtension}");
            $extHookFiles       = array_merge((array) $commonExtHookFiles, (array) $siteExtHookFiles);
        }

        if(!empty($extHookFiles)) return array('viewFile' => $viewFile, 'hookFiles' => $extHookFiles);
        return $viewFile;
    }

    /**
     * Get the extension file of an view.
     * 
     * @param  string $viewFile 
     * @access public
     * @return string|bool  If extension view file exists, return the path. Else return fasle.
     */
    public function getExtViewFile($viewFile)
    {
        $extPath     = dirname(realpath($viewFile)) . "/ext/_{$this->app->siteCode}/";
        $extViewFile = $extPath . basename($viewFile);

        if(file_exists($extViewFile))
        {
            helper::cd($extPath);
            return $extViewFile;
        }

        $extPath = RUN_MODE == 'front' ? dirname(realpath($viewFile)) . '/ext/' : dirname(dirname(realpath($viewFile))) . '/ext/view/';
        $extViewFile = $extPath . basename($viewFile);

        if(file_exists($extViewFile))
        {
            helper::cd($extPath);
            return $extViewFile;
        }

        return false;
    }

    /**
     * Get css code for a method. 
     * 
     * @param  string    $moduleName 
     * @param  string    $methodName 
     * @access private
     * @return string
     */
    public function getCSS($moduleName, $methodName)
    {
        $moduleName = strtolower(trim($moduleName));
        $methodName = strtolower(trim($methodName));

        $modulePath = $this->app->getModulePath('', $moduleName);
        $cssExtPath = $this->app->getModuleExtPath('', $moduleName, 'css') ;

        $css = '';
        if((RUN_MODE != 'front') or (strpos($modulePath, 'module' . DS . 'ext' . DS) !== false))
        {
            $mainCssFile   = $modulePath . 'css' . DS . $this->devicePrefix . 'common.css';
            $methodCssFile = $modulePath . 'css' . DS . $this->devicePrefix . $methodName . '.css';

            if(file_exists($mainCssFile))   $css .= file_get_contents($mainCssFile);
            if(file_exists($methodCssFile)) $css .= file_get_contents($methodCssFile);
        }
        else
        {
            $defaultMainCssFile   = TPL_ROOT . $moduleName . DS . 'css' . DS . "common.css";
            $defaultMethodCssFile = TPL_ROOT . $moduleName . DS . 'css' . DS . "{$methodName}.css";
            $themeMainCssFile     = TPL_ROOT . $moduleName . DS . 'css' . DS . "common.{$this->config->site->theme}.css";
            $themeMethodCssFile   = TPL_ROOT . $moduleName . DS . 'css' . DS . "{$methodName}.{$this->config->site->theme}.css";

            if(file_exists($defaultMainCssFile))   $css .= file_get_contents($defaultMainCssFile);
            if(file_exists($defaultMethodCssFile)) $css .= file_get_contents($defaultMethodCssFile);
            if(file_exists($themeMainCssFile))     $css .= file_get_contents($themeMainCssFile);
            if(file_exists($themeMethodCssFile))   $css .= file_get_contents($themeMethodCssFile);
        }

        if(!empty($cssExtPath))
        {
            $commonExtCssFiles = glob($cssExtPath['common'] . $methodName . DS . $this->devicePrefix . '*.css');
            if(!empty($commonExtCssFiles)) foreach($commonExtCssFiles as $cssFile) $css .= file_get_contents($cssFile);

            $methodExtCssFiles = glob($cssExtPath['site'] . $methodName . DS . $this->devicePrefix . '*.css');
            if(!empty($methodExtCssFiles)) foreach($methodExtCssFiles as $cssFile) $css .= file_get_contents($cssFile);
        }
        return $css;
    }

    /**
     * Get js code for a method. 
     * 
     * @param  string    $moduleName 
     * @param  string    $methodName 
     * @access private
     * @return string
     */
    public function getJS($moduleName, $methodName)
    {
        $moduleName = strtolower(trim($moduleName));
        $methodName = strtolower(trim($methodName));
        
        $modulePath = $this->app->getModulePath('', $moduleName);
        $jsExtPath  = $this->app->getModuleExtPath('', $moduleName, 'js');

        $js = '';
        if((RUN_MODE !== 'front') or (strpos($modulePath, 'module' . DS . 'ext' . DS) !== false))
        {
            $mainJsFile   = $modulePath . 'js' . DS . $this->devicePrefix . 'common.js';
            $methodJsFile = $modulePath . 'js' . DS . $this->devicePrefix . $methodName . '.js';

            if(file_exists($mainJsFile))   $js .= file_get_contents($mainJsFile);
            if(file_exists($methodJsFile)) $js .= file_get_contents($methodJsFile);
        }
        else
        {
            $defaultMainJsFile   = TPL_ROOT . $moduleName . DS . 'js' . DS . "common.js";
            $defaultMethodJsFile = TPL_ROOT . $moduleName . DS . 'js' . DS . "{$methodName}.js";
            $themeMainJsFile     = TPL_ROOT . $moduleName . DS . 'js' . DS . $this->devicePrefix . "common.{$this->config->site->theme}.js";
            $themeMethodJsFile   = TPL_ROOT . $moduleName . DS . 'js' . DS . $this->devicePrefix . "{$methodName}.{$this->config->site->theme}.js";

            if(file_exists($defaultMainJsFile))   $js .= file_get_contents($defaultMainJsFile);
            if(file_exists($defaultMethodJsFile)) $js .= file_get_contents($defaultMethodJsFile);
            if(file_exists($themeMainJsFile))     $js .= file_get_contents($themeMainJsFile);
            if(file_exists($themeMethodJsFile))   $js .= file_get_contents($themeMethodJsFile);
        }

        if(!empty($jsExtPath))
        {
            $commonExtJsFiles = glob($jsExtPath['common'] . $methodName . DS . $this->devicePrefix . '*.js');
            if(!empty($commonExtJsFiles))
            {
                foreach($commonExtJsFiles as $jsFile) $js .= file_get_contents($jsFile);
            }

            $methodExtJsFiles = glob($jsExtPath['site'] . $methodName . DS  . $this->devicePrefix . '*.js');
            if(!empty($methodExtJsFiles))
            {
                foreach($methodExtJsFiles as $jsFile) $js .= file_get_contents($jsFile);
            }
        }

        return $js;
    }

    /**
     * Parse view file. 
     *
     * @param  string $moduleName    module name, if empty, use current module.
     * @param  string $methodName    method name, if empty, use current method.
     * @access public
     * @return string the parsed result.
     */
    public function parse($moduleName = '', $methodName = '')
    {
        if(empty($moduleName)) $moduleName = $this->moduleName;
        if(empty($methodName)) $methodName = $this->methodName;
    
        if($this->viewType == 'wxml') return $this->parseWXML($moduleName, $methodName);
        if($this->viewType == 'json') return $this->parseJSON($moduleName, $methodName);

        $this->parseCssAndJs($moduleName, $methodName);
        /* If the parser is default or run mode is admin, install, upgrade, call default parser.  */
        if(RUN_MODE != 'front' or $this->config->template->parser == 'default')
        {
            $this->parseDefault($moduleName, $methodName);
            return $this->output;
        }

        /* Call the extened parser. */
        $parserClassName = $this->config->template->parser . 'Parser';
        $parserClassFile = 'parser.' . $this->config->template->parser . '.class.php';
        $parserClassFile = dirname(__FILE__) . DS . $parserClassFile;
        if(!is_file($parserClassFile)) $this->app->triggerError(" The parser file  $parserClassFile not found", __FILE__, __LINE__, $exit = true);

        helper::import($parserClassFile);
        if(!class_exists($parserClassName)) $this->app->triggerError(" Can not find class : $parserClassName not found in $parserClassFile <br/>", __FILE__, __LINE__, $exit = true);

        $parser = new $parserClassName($this);
        $this->output = $parser->parse($moduleName, $methodName);
        return $this->output;
    }

    /**
     * Parse default html format.
     *
     * @param string $moduleName    module name
     * @param string $methodName    method name
     * @access private
     * @return void
     */
    public function parseDefault($moduleName, $methodName)
    {
        /* Set the view file. */
        $results  = $this->setViewFile($moduleName, $methodName);
        $viewFile = $results;
        if(is_array($results)) extract($results);

        $this->parseCssAndJs($moduleName, $methodName);

        /* Change the dir to the view file to keep the relative pathes work. */
        $currentPWD = getcwd();
        chdir(dirname($viewFile));

        extract((array)$this->view);

        ob_start();
        include $viewFile;
        if(isset($hookFiles)) foreach($hookFiles as $hookFile) if(file_exists($hookFile)) include $hookFile;
        $this->output .= ob_get_contents();
        ob_end_clean();

        /* At the end, chang the dir to the previous. */
        chdir($currentPWD);
    }

    /**
     * Parse wxml. 
     * 
     * @param  string   $moduleName 
     * @param  string   $methodName 
     * @access public
     * @return string   JSON
     */
    public function parseWXML($moduleName, $methodName)
    {
        $this->app->setClientDevice('mobile');
        $this->loadModel('common')->checkWMP();

        unset($this->view->app);
        unset($this->view->config);
        unset($this->view->lang);
        unset($this->view->header);
        unset($this->view->position);
        unset($this->view->moduleTree);
        unset($this->view->common);
        unset($this->view->layouts);
        unset($this->view->pager->app);
        unset($this->view->pager->lang);

        $output['status']  = is_object($this->view) ? 'success' : 'fail';
        $output['data']    = $this->view;
        $output['company'] = $this->config->company;
        $output['site']    = $this->config->site;
        $output['layouts'] = $this->loadModel('block')->getWmpLayouts($moduleName, $methodName);

        die(json_encode($output));
    }

    /**
     * parseCssAndJs 
     * 
     * @param  int    $moduleName 
     * @param  int    $methodName 
     * @access public
     * @return void
     */
    public function parseCssAndJs($moduleName, $methodName)
    {
        /* Get css and js. */
        $css = $this->getCSS($moduleName, $methodName);
        $js  = $this->getJS($moduleName, $methodName);

        if(RUN_MODE == 'front')
        {
            $template    = $this->config->template->{$this->app->clientDevice}->name;
            $theme       = $this->config->template->{$this->app->clientDevice}->theme;
            $customParam = $this->loadModel('ui')->getCustomParams($template, $theme);
            $themeHooks  = $this->loadThemeHooks();

            $importedCSS = array();
            $importedJS  = array();

            if(!empty($themeHooks))
            {
                $jsFun  = "get{$theme}JS";
                $cssFun = "get{$theme}CSS";
                if(function_exists($jsFun))  $importedJS = $jsFun();
                if(function_exists($cssFun)) $importedCSS = $cssFun();

                if(!empty($importedJS))  $importedJS  = $this->processImportedCodes($template, $theme, $importedJS);
                if(!empty($importedCSS)) $importedCSS = $this->processImportedCodes($template, $theme, $importedCSS);

                $jsFun  = "getJS";
                $cssFun = "getCSS";

                if(function_exists($jsFun))  $importedJS = $jsFun($theme);
                if(function_exists($cssFun)) $importedCSS = $cssFun($theme);
            }

            $js .= zget($importedJS, 'all', '');
            $js .= zget($this->config->js, "{$template}_{$theme}_all", '');
            $js .= zget($importedJS, "{$moduleName}_{$methodName}", '');
            $js .= zget($this->config->js,"{$template}_{$theme}_{$moduleName}_{$methodName}", '');

            $allPageCSS  = zget($importedCSS, 'all', '');
            $allPageCSS .= zget($this->config->css, "{$template}_{$theme}_all", '');

            $currentPageCSS  = zget($importedCSS, "{$moduleName}_{$methodName}", '');
            $currentPageCSS .= zget($this->config->css, "{$template}_{$theme}_{$moduleName}_{$methodName}", '');
            $css .= $this->ui->compileCSS($customParam, $allPageCSS . $currentPageCSS);
        }

        if($css) $this->view->pageCSS = $css;
        if($js)  $this->view->pageJS  = $js;
    
    }

    /**
     * Print the content of the view. 
     * 
     * @param   string  $moduleName    module name
     * @param   string  $methodName    method name
     * @access  public
     * @return  void
     */
    public function display($moduleName = '', $methodName = '')
    {
        if(empty($this->output)) $this->parse($moduleName, $methodName);
        if(isset($this->config->cn2tw) and $this->config->cn2tw and $this->app->getClientLang() == 'zh-tw')
        {
            $this->app->loadClass('cn2tw', true);
            $this->output = cn2tw::translate($this->output);
        }

        $moduleName = $this->moduleName;
        $methodName = $this->methodName;
        if(RUN_MODE == 'front')
        {
            if($this->config->cache->type != 'close' and $this->config->cache->cachePage == 'open')
            {
                if(strpos($this->config->cache->cachedPages, "$moduleName.$methodName") !== false)
                {
                    if(!isset($this->app->clientDevice) or empty($this->app->clientDevice)) $this->app->clientDevice = 'desktop';
                    $key = 'page' . DS . $this->app->clientDevice . DS . $moduleName . '_' . $methodName . DS . md5($_SERVER['REQUEST_URI']);
                    $this->app->cache->set($key, $this->output);
                }
            }

            if(in_array($moduleName . '_' . $methodName, $this->config->replaceViewsPages))
            {
                $viewsID      = commonModel::parseItemID($moduleName, $methodName);
                $views        = commonModel::getViews($moduleName, $methodName, $viewsID);
                $this->output = str_replace($this->config->viewsPlaceholder, $views, $this->output);
            }
            
            if(in_array($moduleName . '_' . $methodName, $this->config->replaceViewsListPages))
            {
                $beginPos    = strpos($this->output, $this->config->idListPlaceHolder) + strlen($this->config->idListPlaceHolder);
                $length      = strrpos($this->output, $this->config->idListPlaceHolder) - $beginPos; 
                $viewsIDList = explode(',', trim(substr($this->output, $beginPos, $length), ',')); 
                $viewsList   = commonModel::getViews($moduleName, $methodName, $viewsIDList);
                foreach($viewsList as $viewID => $views)
                {
                    $this->output = str_replace($this->config->viewsPlaceholder . $viewID . $this->config->viewsPlaceholder, $views, $this->output);
                }
            }

            $keywords     = ($this->app->getModuleName() == 'search') ? $this->session->searchIngWord : '';
            $searchHtml   = html::input('words', $keywords, "class='form-control' placeholder=''");
            $this->output = str_replace($this->config->searchWordPlaceHolder, $searchHtml, $this->output);

            $siteNav = commonModel::printTopBar() . commonModel::printLanguageBar();

            $this->output = str_replace($this->config->siteNavHolder, $siteNav, $this->output);

            /* Hide execinfo if output has no powerby btn. */
            if($this->config->site->execInfo == 'show') $this->output = str_replace($this->config->execPlaceholder, helper::getExecInfo(), $this->output);

            if($this->moduleName != 'source' and in_array($this->viewType, array('html', 'mhtml'))) 
            {
                $unmergedPages[] = 'chat.registercomponent';
                $unmergedPages[] = 'theme.viewsnap';
                $page = strtolower($this->moduleName . '.' .  $this->methodName);
                if(!in_array($page, $unmergedPages))
                {
                    $this->mergeCSS();
                    $this->mergeJS();
                }
            }
        }

        if(RUN_MODE == 'front')
        {
			if(!in_array($this->moduleName, array('chat', 'registercomponent')))
            {
                $this->output = $this->app->loadClass('cleanoutput')->clean($this->output);
            }
            $this->output = preg_replace('/[\r\n]{2,}/', "\n", $this->output);
        }

        if(!headers_sent()
            && isset($this->config->site->gzipOutput) && $this->config->site->gzipOutput == 'open'
            && extension_loaded('zlib')
            && strstr($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")
            && !zget($this->config, 'inFetch', ''))
        {
            $this->output = gzencode($this->output, 9);
            header('Content-Encoding: gzip');
            header('Content-Length: ' . strlen($this->output));
        }

        if(is_callable(array('extcommonModel', 'processOutput'))) $this->output = extcommonModel::processOutput($this->output);
		echo $this->output;
    }

    /**
     * Send data directly, for ajax requests.
     * 
     * @param  misc    $data 
     * @param  string  $type 
     * @access public
     * @return void
     */
    public function send($data, $type = 'json')
    {
        $data = (array) $data;
        if($type == 'json')
        {
            if(!helper::isAjaxRequest() and $this->viewType != 'json')
            {
                if(isset($data['result']) and $data['result'] == 'success')
                {
                    if(!empty($data['message'])) echo js::alert($data['message']);
                    $locate = isset($data['locate']) ? $data['locate'] : (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');
                    if(!empty($locate)) die(js::locate($locate));
                    die(isset($data['message']) ? $data['message'] : 'success');
                }

                if(isset($data['result']) and $data['result'] == 'fail')
                {
                    if(!empty($data['message']))
                    {
                        $message = json_decode(json_encode((array)$data['message']), true);
                        $result  = array(); 
                        foreach((array)$message as $item => $errors)
                        {
                            $result[$item] = implode(',', (array)$errors);
                        }
                        echo js::alert(strip_tags(implode(" ", (array) $result)));
                        die(js::locate('back'));
                    }
                }
            }

            header("Content-type: text/html; charset=utf-8");
            header("Content-type: application/json");
            $data = json_encode($data);
            echo ($data === false) ? 'Json encode faild.' : $data;
        }
        die(helper::removeUTF8Bom(ob_get_clean()));
    }

    /**
     * Create a link to one method of one module.
     * 
     * @param   string         $moduleName    module name
     * @param   string         $methodName    method name
     * @param   string|array   $vars          the params passed, can be array(key=>value) or key1=value1&key2=value2
     * @param   string         $viewType      the view type
     * @access  public
     * @return  string the link string.
     */
    public function createLink($moduleName, $methodName = 'index', $vars = array(), $alias = array(), $viewType = '')
    {
        if(empty($moduleName)) $moduleName = $this->moduleName;
        return helper::createLink($moduleName, $methodName, $vars, $alias, $viewType);
    }

    /**
     * Create a link to the inner method of current module.
     * 
     * @param   string         $methodName    method name
     * @param   string|array   $vars          the params passed, can be array(key=>value) or key1=value1&key2=value2
     * @param   string         $viewType      the view type
     * @access  public
     * @return  string  the link string.
     */
    public function inlink($methodName = 'index', $vars = array(), $alias = array(), $viewType = '')
    {
        return helper::createLink($this->moduleName, $methodName, $vars, $alias, $viewType);
    }

    /**
     * Load theme hooks.
     * 
     * @access public
     * @return array
     */
    public function loadThemeHooks()
    {
        if(isset($this->config->inFetch) and $this->config->inFetch) return true;
        $theme     = $this->config->template->{$this->app->clientDevice}->theme;
        $hookPath  = $this->app->getWwwRoot() . 'theme' . DS . $this->config->template->{$this->app->clientDevice}->name . DS . $theme . DS;
        $hookFiles = glob("{$hookPath}*.php");

        if(empty($hookFiles)) return array();
        foreach($hookFiles as $file) include $file;
        return $hookFiles;
    }

    /**
     * Merge all css codes of one page. 
     * 
     * @access public
     * @return void
     */
    public function mergeCSS()
    {
        $pageCSS = '';
        preg_match_all('/<style>([\s\S]*?)<\/style>/', $this->output, $styles);
        if(!empty($styles[1])) $pageCSS = join('', $styles[1]);

        if(!empty($pageCSS))
        {
            $this->output = str_replace("</style>\n", '</style>', $this->output);
            $this->output = preg_replace('/<style>([\s\S]*?)<\/style>/', '', $this->output);
        }
		
		$params = $this->app->getParams();
		$params['module'] = $this->moduleName;
		$params['method'] = $this->methodName;
        $params['device'] = $this->clientDevice;
        $params['lang']   = $this->app->getClientLang();
        $page = md5(http_build_query($params));
        $key  = strtolower("/css/{$page}");

        if($this->config->cache->type == 'close')
        {
            $cachePath = $this->app->getTmpRoot() . 'cache' . DS . $this->app->getClientLang() . DS . 'css';
            if(!is_dir($cachePath)) mkdir($cachePath, 0777, true);
            file_put_contents($cachePath . DS . $page . ".css", $pageCSS);
        }
        else
        {
            $this->app->cache->set($key, $pageCSS);
        }

        if($this->config->debug) $this->config->site->updatedTime = time();
        $sourceURL  = helper::createLink('source', 'css', "page=$page&version={$this->config->site->updatedTime}", '', 'html');
        $importHtml = "<link rel='stylesheet' href='$sourceURL' type='text/css' media='screen' />\n";

        if(strpos($this->output, $importHtml) === false)
        {
            if(strpos($this->output, '</head>') != false) $this->output = str_replace('</head>', "{$importHtml}</head>", $this->output);
            if(strpos($this->output, '</head>') == false) $this->output = $importHtml . $this->output;
        }
    }

    /**
     * Merge all js codes of one page, 
     * 
     * @access public
     * @return void
     */
    public function mergeJS()
    {
        $pageJS = '';
        preg_match_all('/<script>([\s\S]*?)<\/script>/', $this->output, $scripts);

        $hasHeader = strpos($this->output, "var config=") !== false;
        if($hasHeader)
        {
            if(empty($scripts[1][1])) return true;
            $configCode = $scripts[1][0] . $scripts[1][1];

            unset($scripts[1][1]);
            unset($scripts[1][0]);

            if(!empty($scripts[1])) $pageJS = join(';', $scripts[1]);
        }
        else
        {
            if(empty($scripts[1])) return true;
            $pageJS = join(';', $scripts[1]);
        }

   		$params = $this->app->getParams();
		$params['module'] = $this->moduleName;
		$params['method'] = $this->methodName;
        $params['device'] = $this->clientDevice;
        $params['lang']   = $this->app->getClientLang();
        $page = md5(http_build_query($params));
        $key  = strtolower("/js/{$page}");

        if($this->config->cache->type == 'close')
        {
            $cachePath = $this->app->getTmpRoot() . 'cache' . DS . $this->app->getClientLang() . DS . 'js';
            if(!is_dir($cachePath)) mkdir($cachePath, 0777, true);
            file_put_contents($cachePath . DS . $page . ".js", $pageJS);
        }
        else
        {
            $this->app->cache->set($key, $pageJS);
        }

        if(strpos($pageJS, 'initUeditor') !== false) $this->config->site->updatedTime = uniqid('v');
        $sourceURL  = helper::createLink('source', 'js', "page=$page&version={$this->config->site->updatedTime}", '', 'html');
        $importHtml =  "<script src='{$sourceURL}' type='text/javascript'></script>\n";

        if(!empty($pageJS))
        {
            $this->output = str_replace("</script>\n", '</script>', $this->output);
            $this->output = preg_replace('/<script>([\s\S]*?)<\/script>/', '', $this->output);
            if(strpos($this->output, $importHtml) === false)
            {
                if(strpos($this->output, '</body>') != false) $this->output = str_replace('</body>', "{$importHtml}</body>", $this->output);
                if(strpos($this->output, '</body>') == false) $this->output .= $importHtml;
            }
        }

        if($hasHeader)
        {
            $pos = strpos($this->output, '<script src=');
            $this->output = substr_replace($this->output, '<script>' . $configCode . '</script>', $pos) . substr($this->output, $pos);
        }
        return true;
    }

    /**
     * Process imported codes encrypted.
     * 
     * @param  string    $template 
     * @param  string    $theme 
     * @param  array     $codes 
     * @access public
     * @return void
     */
    public function processImportedCodes($template, $theme, $codes)
    {
        $sources[] = "{$template}_default_";
        $sources[] = "{$template}_clean_";
        $sources[] = "{$template}_wide_";
        $sources[] = "{$template}_tartan_";
        $sources[] = "{$template}_colorful_";
        $sources[] = "{$template}_blank_";

        foreach($sources as $source) $replace[] = '';

        foreach($codes as $page => $code)
        {
            $page = str_replace($sources, $replace, $page);
            $codes->$page = $code;
        }
        return $codes;
    }
}
