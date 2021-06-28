<?php
/**
 * The smarty parser class file.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     framework
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class raintplParser
{
    /**
     * The control object passed by the control.class.php.
     * 
     * @var object   
     * @access public
     */
    public $control;

    /**
     * Construct function load smarty lib and init smarty configures.
     * 
     * @param  object    $control 
     * @access public
     * @return void
     */
    public function __construct($control)
    {
        $this->control = $control;
	}

    /**
     * Parse template.
     *
     * @param string $moduleName    module name
     * @param string $methodName    method name
     * @access public
     * @return string
     */
    public function parse($moduleName, $methodName)
    {
        global $app, $config, $lang;
        $this->app    = $app;
        $this->lang   = $lang;
        $this->config = $config;

        /* Load smarty class and create smarty object. */
        $app->loadClass('raintpl', true);

        $this->tpl = new RainTPL();
        $tplConfig = array();
        $tplConfig["baseUrl"]        = null;
        $tplConfig["tplDir"]         = TPL_ROOT;
        $tplConfig["tplExt"]         = 'php';
        $tplConfig["cacheDir"]       = $app->getTmpRoot() . 'cache' . DS . 'raintpl' . DS . $app->getClientDevice() . DS;
        $tplConfig["debug"]          = $config->debug;
        $tplConfig["removeComments"] = true;
        
        $this->tpl->configure($tplConfig);

        $this->assignCommon();

        $raintpl = $this->tpl;

        /* Get view files from control. */
        $results  = $this->control->setViewFile($moduleName, $methodName);
        $viewFile = $results;
        if(is_array($results)) extract($results);

        $this->tpl->configure('tplDir', dirname($viewFile) . DS);

        /* Assign hook files. */        
        if(!isset($hookFiles)) $hookFiles = array();
        $this->tpl->assign('hookFiles', $hookFiles);

        foreach($this->control->view as $key => $value) $this->tpl->assign($key, $value);

        $html = $this->tpl->draw($viewFile, true);

        foreach($hookFiles as $hook)
        {
            if(file_exists($hook)) $html .= $this->tpl->draw($hook, true);
        }

        return $html;
    }

    /**
     * Assign common variables.
     * 
     * @access private
     * @return void
     */
    private function assignCommon()
    {
        $this->tpl->assign('control', $this->control);

        $this->tpl->assign('app', $this->app);
        $this->tpl->assign('lang', $this->lang);
        $this->tpl->assign('config', $this->config);
        $this->tpl->assign('session', $this->control->session);

        $device =  $this->app->getclientDevice();
        $this->tpl->assign('device', $device);

        if(!defined('CHANZHI_TEMPLATE'))
        {
            $template = $this->config->template->{$device}->name;
            define('CHANZHI_TEMPLATE', $template);
        }

        if(!defined('CHANZHI_THEME'))
        {
            $theme = $this->config->template->{$device}->theme;
            define('CHANZHI_THEME', $theme);
        }

        $this->tpl->assign('webRoot', $this->config->webRoot);
        $this->tpl->assign('jsRoot',  $this->config->webRoot . 'js/');
        $this->tpl->assign('themeRoot',  $this->config->webRoot . 'theme/' . CHANZHI_TEMPLATE . '/');
        $this->tpl->assign('customCssFile', $this->control->loadModel('ui')->getCustomCssFile(CHANZHI_TEMPLATE, CHANZHI_THEME));
        $this->tpl->assign('customCssURI', $this->control->loadModel('ui')->getThemeCssUrl(CHANZHI_TEMPLATE, CHANZHI_THEME));
        $cdnRoot = ($this->config->cdn->open == 'open') ? (!empty($this->config->cdn->site) ? rtrim($this->config->cdn->site, '/') : $this->config->cdn->host . $this->config->version) : '';
        $this->tpl->assign('cdnRoot', $cdnRoot);
        $this->tpl->assign('sysURL', commonModel::getSysURL());

        $this->tpl->assign('thisModuleName', $this->app->getModuleName());
        $this->tpl->assign('thisMethodName', $this->app->getMethodName());
        
        if(isset($this->config->site->favicon))
        {
            $favicon = json_decode($this->config->site->favicon);
            if(is_object($favicon))
            {
                $favicon->extension = 'ico';
                $favicon = $this->control->loadModel('file')->printFileURL($favicon);
            }
        }
        else
        {
            $favicon =  file_exists($this->app->getWwwRoot() . 'favicon.ico') ? $this->config->webRoot . 'favicon.ico' : '';
        }
        $this->tpl->assign('favicon', $favicon);
    }
}
