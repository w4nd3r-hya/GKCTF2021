<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class site extends control
{
    /**
     * set site basic info.
     *
     * @access public
     * @return void
     */
    public function setBasic()
    {
        $allowedTags = $this->app->user->admin == 'super' ? $this->config->allowedTags->admin : $this->config->allowedTags->front;

        if(!empty($_POST))
        {
            $setting = fixer::input('post')
                ->stripTags('meta', $allowedTags)
                ->join('modules', ',')
                ->remove('allowedFiles')
                ->setDefault('modules', '')
                ->stripTags('pauseTip', $allowedTags)
                ->remove('uid,lang,cn2tw,defaultLang,requestType')
                ->get();

            if(strpos($setting->modules, 'shop') !== false  && strpos($setting->modules, 'user') === false) $setting->modules = 'user,' . $setting->modules;
            if($setting->modules == 'initial') unset($setting->modules);

            if(isset($setting->gzipOutput) && $setting->gzipOutput == 'open')
            {
                if(!extension_loaded('zlib')) $this->send(array('result' => 'fail', 'message' => $this->lang->site->noZlib));
                if($this->site->checkGzip()) $this->send(array('result' => 'fail', 'message' => $this->lang->site->gzipOn));
            }

            /* Edit config->framework->detectDevice if mobile template closed. */
            $detectDevice = $setting->mobileTemplate == 'open' ? true : false;
            if($detectDevice != $this->config->framework->detectDevice[$this->app->clientLang])
            {
                $deviceConfig = new stdclass;
                $deviceConfig->detectDevice = $detectDevice;

                $result = $this->site->setSystem($deviceConfig);
                if(isset($result['result']) and $result['result'] == 'fail') $this->send($result);
                if($setting->mobileTemplate == 'close') $this->session->set('device', 'desktop');
            }

            $result = $this->loadModel('setting')->setItems('system.common.site', $setting);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate' => inlink('setbasic')));
        }

        $this->view->title = $this->lang->site->common;
        $this->display();
    }

    /**
     * Set domain.
     * 
     * @access public
     * @return void
     */
    public function setDomain()
    {
        if(!empty($_POST))
        {
            $setting = fixer::input('post')->get();
            $result = $this->loadModel('setting')->setItems('system.common.site', $setting);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
            $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate' => inlink('setbasic')));
        }

        $this->view->title = $this->lang->site->setDomain;
        $this->display();
    }

    /**
     * Set sensitive.
     *
     * @param  string $type
     * @access public
     * @return void
     */
    public function setSensitive($type = 'content')
    {
        $this->lang->menuGroups->site = 'security';

        if(!empty($_POST))
        {
            $setting = fixer::input('post')
                ->setDefault('filterSensitive', 'close')
                ->setForce('sensitive', seo::unify($this->post->sensitive, ','))
                ->get();

            if($type == 'content') $result = $this->loadModel('setting')->setItems('system.common.site', $setting);
            if($type == 'user')    $result = $this->loadModel('setting')->setItems('system.user', $setting);

            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate' => inlink('setsensitive', "type={$type}")));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $this->view->title = $this->lang->site->setsensitive;
        $this->view->type  = $type;
        $this->display();
    }

    /**
     * Set robots.
     *
     * @access public
     * @return void
     */
    public function setRobots()
    {
        $robotsFile = $this->app->getWwwRoot() . 'robots.txt';
        $writeable  = ((file_exists($robotsFile) and is_writeable($robotsFile)) or is_writeable(dirname($robotsFile)));

        if(!empty($_POST))
        {
            if(!$writeable) $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->site->robotsUnwriteable, $robotsFile)) );
            if(!$this->post->robots) $this->send(array('result' => 'fail', 'message' => array('robots' => sprintf($this->lang->error->notempty, $this->lang->site->robots) )) );

            $result = file_put_contents($robotsFile, $this->post->robots);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
            $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate' => inlink('setrobots')));
        }

        $this->view->robots = '';
        if(file_exists($robotsFile)) $this->view->robots = file_get_contents($robotsFile);

        $this->view->robotsFile = $robotsFile;
        $this->view->writeable  = $writeable;
        $this->view->title      = $this->lang->site->setBasic;
        $this->display();
    }

    /**
     * set site security info.
     *
     * @access public
     * @return void
     */
    public function setSecurity()
    {
        $this->lang->menuGroups->site = 'security';

        $captcha        = (isset($this->config->site->captcha) and ($this->config->site->captcha == 'open' and ($this->post->captcha == 'close' or $this->post->captcha == 'auto')) or ((!isset($this->config->site->captcha) or $this->config->site->captcha == 'auto') and $this->post->captcha == 'close'));
        $checkEmail     = (isset($this->config->site->checkEmail) and $this->config->site->checkEmail == 'open' and $this->post->checkEmail == 'close');
        $front          = (isset($this->config->site->front) and $this->config->site->front == 'login' and $this->post->front == 'guest');
        $checkLocation  = (isset($this->config->site->checkLocation) and $this->config->site->checkLocation == 'open' and $this->post->checkLocation == 'close');
        $checkSessionIP = (isset($this->config->site->checkSessionIP) and $this->config->site->checkSessionIP == 1 and $this->post->checkSessionIP == 0);
        $allowedIP      = (isset($this->config->site->allowedIP) and ($this->config->site->allowedIP != $this->post->allowedIP));

        $newImportantValidate = $this->post->importantValidate ? $this->post->importantValidate : array();
        $oldImportantValidate = explode(',', $this->config->site->importantValidate);

        $importantChange = false;
        foreach($oldImportantValidate as $validate)
        {
            if(!in_array($validate, $newImportantValidate))
            {
                $importantChange = true;
                break;
            }
        }

        if($captcha or $checkEmail or $front or $checkLocation or $checkSessionIP or $allowedIP or $importantChange)
        {
            $okFile = $this->loadModel('common')->verifyAdmin();
            $pass   = $this->loadModel('guarder')->verify('okFile');
            $this->view->pass   = $pass;
            $this->view->okFile = $okFile;
            if(!empty($_POST) && !$pass) $this->send(array('result' => 'fail', 'reason' => 'captcha'));
        }

        if(!empty($_POST))
        {
            $setting = fixer::input('post')
                ->setDefault('captcha', 'auto')
                ->setDefault('checkIP', 'close')
                ->setDefault('checkSessionIP', '0')
                ->setDefault('checkLocation', 'close')
                ->setDefault('checkEmail', 'close')
                ->setDefault('allowedIP', '')
                ->setDefault('importantValidate', '')
                ->join('importantValidate', ',')
                ->get();

            /* check IP. */
            $ips = !$this->post->allowedIP ? array() : explode(',', $this->post->allowedIP);
            foreach($ips as $ip)
            {
                if(!empty($ip) and !validater::checkIP($ip))
                {
                    dao::$errors['allowedIP'][] = $this->lang->site->wrongAllowedIP;
                    break;
                }
            }

            $result = $this->loadModel('setting')->setItems('system.common.site', $setting, 'all');

            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate' => inlink('setsecurity')));
            $this->send(array('result' => 'fail', 'message' => dao::getError()));
        }

        $location = $this->app->loadClass('IP')->find(helper::getRemoteIp());
        if(is_array($location))
        {
            $locations = $location;
            $location  = join(' ', $locations);
            if(count($locations) > 3) $location = $locations[0] . ' ' . $locations[1] . ' ' . $locations[2];
        }

        $this->view->title    = $this->lang->site->setSecurity;
        $this->view->location = $location;
        $this->display();
    }

    /**
     * Set upload configures.
     *
     * @access public
     * @return void
     */
    public function setUpload()
    {
        $this->lang->menuGroups->site = 'security';

        $this->loadModel('file');

        if(!empty($_POST))
        {
            $setting = fixer::input('post')->remove('allowedFiles,thumbs')->setDefault('allowUpload', '0')->get();

            $dangers = explode(',', $this->config->file->dangers);
            $allowedFiles = trim(strtolower($this->post->allowedFiles), ',');
            $allowedFiles = str_replace($dangers, '', $allowedFiles);
            $allowedFiles = seo::unify($allowedFiles, ',');
            if(!preg_match('/^[a-z0-9,]+$/', $allowedFiles)) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            $allowedFiles = explode(',', $allowedFiles);

            foreach ($allowedFiles as $extension)
            {
                if(strlen($extension) > 5) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
            }

            $allowedFiles = implode(',', $allowedFiles);

            foreach ($dangers as $danger)
            {
                if(strpos($allowedFiles, $danger) !== false) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
            }

            $allowedFiles = ',' . $allowedFiles . ',';
            $result = $this->loadModel('setting')->setItem('system.common.file.allowed', $allowedFiles);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            $result  = $this->loadModel('setting')->setItems('system.common.site', $setting);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate' => inlink('setupload')));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $this->view->title = $this->lang->site->setUpload;
        $this->display();
    }

    /**
     * set oauth login configure.
     *
     * @access public
     * return void
     */
    public function setOauth()
    {
        $this->lang->menuGroups->site = 'interface';
        if(!empty($_POST))
        {
            $provider = $this->post->provider;
            foreach($_POST as $key => $value)
            {
                $_POST[$key] = trim($value);
                if($key == 'isVertified') $_POST['verification'] = '';
            }
            $oauth    = array($provider => helper::jsonEncode($_POST));

            $result   = $this->loadModel('setting')->setItems('system.common.oauth', $oauth);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }
        $this->view->setting = array();

        $this->view->title = $this->lang->site->setOauth;
        $this->display();
    }

    /**
     * Set filter rule.
     * 
     * @access public
     * @return void
     */
    public function setFilter($type = 'ip')
    {
        $this->loadModel('guarder');
        if(!empty($_POST))
        {
            $setting = new stdclass;
            $setting->owner   = 'system';
            $setting->module  = 'common';
            $setting->section = 'guarder';
            $setting->key     = 'limits';
            $setting->lang    = 'all';

            $limits = $this->config->guarder->limits;
            $limits->$type  = $this->post->limits;
            $setting->value = helper::jsonEncode($limits);

            $this->dao->replace(TABLE_CONFIG)->data($setting)->exec();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            $setting = new stdclass;
            $setting->owner   = 'system';
            $setting->module  = 'common';
            $setting->section = 'guarder';
            $setting->key     = 'punishment';
            $setting->lang    = 'all';

            $punishment = $this->config->guarder->punishment;
            $punishment->$type  = $this->post->punishment;
            $setting->value = helper::jsonEncode($punishment);

            $this->dao->replace(TABLE_CONFIG)->data($setting)->exec();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            $interval = $this->post->interval;
            foreach($interval as $action => $value) $interval[$action] = (int)$value;
            $setting = new stdclass;
            $setting->owner   = 'system';
            $setting->module  = 'common';
            $setting->section = 'guarder';
            $setting->key     = 'interval';
            $setting->lang    = 'all';

            $config = $this->config->guarder->interval;
            $config->$type  = $interval;
            $setting->value = helper::jsonEncode($config);

            $this->dao->replace(TABLE_CONFIG)->data($setting)->exec();
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
        }

        $this->lang->menuGroups->site = 'security';

        $this->view->title = $this->lang->site->setFilter;
        $this->view->type  = $type;
        $this->display();
    }
   
    /**
     * set cdb configure.
     * 
     * @access public
     * return void
     */
    public function setCDN()
    {
        if(!empty($_POST))
        {
            if($this->post->site and $this->post->site != 'http://cdn.chanzhi.org/' . $this->config->version . '/')
            {
                $cdnSite = rtrim($this->post->site, '/');
                if(strpos($cdnSite, '//') === 0)
                {
                    $httpType = isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == 'on' ? 'https' : 'http';
                    $cdnSite  = $httpType . ':' . $cdnSite;
                }

                foreach($this->config->cdn->fileList as $file)
                {
                    $ch = curl_init($cdnSite . $file);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
                    curl_setopt($ch, CURLOPT_NOBODY, true);
                    curl_exec($ch);
                    $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    curl_close($ch);

                    if($retcode != 200) $lostFiles[] = $this->post->site . $file;
                }
                if(!empty($lostFiles)) $this->send(array('result' => 'fail', 'message' => $lostFiles));
            }
            $setting = fixer::input('post')->get();
            $result  = $this->loadModel('setting')->setItems('system.common.cdn', $setting);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }
        $this->view->title = $this->lang->site->setCDN;
        $this->display();
    }
  
    /**
     * Set api config.
     * 
     * @access public
     * @return void
     */
    public function setApi()
    {   
        if($_POST)
        {   
            $setting = array();
            $setting['key'] = $this->post->key;
            $setting['ip']  = $this->post->allip ? '' : $this->post->ip;

            $this->loadModel('setting')->setItems('system.site.api', $setting, $lang = 'all');
            $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
        }   

        $this->view->title = $this->lang->site->api->common;
        $this->display();
    }   

    /**
     * Set cache function.
     * 
     * @access public
     * @return void
     */
    public function setCache()
    {
        if(!empty($_POST))
        {
            $post    = fixer::input('post')->get();

            $setting = new stdclass();
            $setting->type      = $post->status;
            $setting->cachePage = $post->cachePage;
            $setting->expired   = $post->cacheExpired * 3600;

            $result = $this->loadModel('setting')->setItems('system.common.cache', $setting);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
            $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate' => inlink('setcache')));
        }
        $this->view->cacheRoot = $this->app->getTmpRoot() . 'cache/'; 
        $this->view->title     = $this->lang->site->setCache;
        $this->display();
    }

    /**
     * Set home menu.
     * 
     * @access public
     * @return void
     */
    public function setHomeMenu()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $this->loadModel('setting')->setItem('system.common.menus.home', 'admin,' . implode(',', $this->post->homeMenus));
            if(dao::isError()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate' => inlink('sethomemenu')));
        }
        if($this->cookie->currentGroup == 'home') 
        {
            unset($this->lang->site->menu);
            $this->config->menuGroups->site = 'home';
        }

        $this->view->title = $this->lang->site->setHomeMenu;
        $this->display();
    }

    /**
     * Set RequestType.
     * 
     * @access public
     * @return void
     */
    public function setUrlType()
    {
        if($_POST)
        {
            $okFile = $this->loadModel('common')->verifyAdmin();
            $pass   = $this->loadModel('guarder')->verify('okFile');
            $this->view->pass   = $pass;
            $this->view->okFile = $okFile;
            if(!$pass) $this->send(array('result' => 'fail', 'reason' => 'captcha'));

            $result = $this->site->setSystem();
            $this->send($result);
        }

        $http = $this->app->loadClass('http');

        $this->view->title       = $this->lang->site->setUrlType;
        $this->view->requestType = $http->get($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/pathinfo.php?requestType=pathinfo');
        $this->display();
    }

    /**
     * Set languages.
     * 
     * @access public
     * @return void
     */
    public function setLanguage()
    {
        if($_POST)
        {
            $okFile = $this->loadModel('common')->verifyAdmin();
            $pass   = $this->loadModel('guarder')->verify('okFile');
            $this->view->pass   = $pass;
            $this->view->okFile = $okFile;
            if(!$pass) $this->send(array('result' => 'fail', 'reason' => 'captcha'));

            if(!$this->post->enabledLangs)
            {
                $this->send(array('result' => 'fail', 'message' => sprintf(strip_tags($this->lang->error->notempty), $this->lang->site->lang)));
            }

            if(!in_array($this->post->defaultLang, $this->post->enabledLangs)) 
            {
                $enabledLangsName = '';
                if(count($this->post->enabledLangs) > 1)
                {
                    foreach($this->post->enabledLangs as $enabledLang) $enabledLangsName .= zget($this->config->langs, $enabledLang) . ',';
                    $this->send(array('result' => 'fail', 'message' => sprintf(strip_tags($this->lang->error->between), $this->lang->site->defaultLang, trim($enabledLangsName, ','))));
                }
                else
                {
                    $enabledLangsName = zget($this->config->langs, $this->post->enabledLangs[0]);
                    $this->send(array('result' => 'fail', 'message' => sprintf(strip_tags($this->lang->error->in), $this->lang->site->defaultLang, trim($enabledLangsName, ','))));
                }
            }

            $result = $this->site->setSystem();
            if($result['result'] == 'success')
            {
                if(!in_array($this->app->clientLang, $this->post->enabledLangs)) $this->loadModel('admin')->switchLang($this->post->defaultLang);
            }

            $this->send($result);
        }

        $this->view->title = $this->lang->site->setLanguage;
        $this->display();
    }

    /**
     * Clear cache
     *
     * @access public
     * @param  void
     * @return void
     */
    public function clearCache()
    {
        if(helper::isAjaxRequest())
        {
             $clearResult = $this->site->clearCache();
             $clearResult = json_encode($clearResult);
             echo $clearResult;
        }
    }

    /**
     * Open one module of chanzhi.
     * 
     * @param  string $module 
     * @access public
     * @return void
     */
    public function openModule($module = '')
    {
        $enabledModules = trim(zget($this->config->site, 'modules', ''), ',');
        $enabledModules .= ',' . $module;
        $result = $this->loadModel('setting')->setItem('system.common.site.modules', $enabledModules);
        if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess));
    }

    /**
     * Set registe agreement.
     * 
     * @access public
     * @return void
     */
    public function setAgreement()
    {
        if(!empty($_POST))
        {
            $setting = fixer::input('post')->get();
            $result  = $this->loadModel('setting')->setItems('system.common.site', $setting);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate' => inlink('setagreement')));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $this->view->title = $this->lang->site->setAgreement;
        $this->display();

    }
}
