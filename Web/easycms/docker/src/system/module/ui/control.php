<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of ui module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     ui
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class ui extends control
{
    /**
     * Set template.
     *
     * @param  string   $template
     * @param  string   $theme
     * @param  bool     $custom
     * @access public
     * @return void
     */
    public function setTemplate($template = '', $theme = '', $custom = false)
    {
        $templates = $this->ui->getTemplates();

        if($template and isset($templates[$template]))
        {
            $setting = array();
            $setting[$this->app->clientDevice]['name']  = $template;
            $setting[$this->app->clientDevice]['theme'] = $theme;

            $setting[$this->app->clientDevice] = helper::jsonEncode($setting[$this->app->clientDevice]);
            $setting['parser']      = isset($templates[$template]['parser']) ? $templates[$template]['parser'] : 'raintpl';
            $setting['customTheme'] =  $custom ? $theme : '';

            $result = $this->loadModel('setting')->setItems('system.common.template', $setting);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $this->view->title           = $this->lang->ui->template->theme;
        $this->view->template        = current($templates);
        $this->view->installedThemes = $this->ui->getInstalledThemes();
        $this->view->currentTheme    = $this->config->template->{$this->app->clientDevice}->theme;
        $this->view->uiHeader        = true;
        $this->display();
    }

    /**
     * Edit template files.
     *
     * @param  string $module
     * @param  string $file
     * @access public
     * @return void
     */
    public function editTemplate($module = 'common', $file = 'header')
    {
        $template = $this->config->template->{$this->app->clientDevice}->name;
        if($_POST)
        {
            $canManage = array('result' => 'success');
            if(!$this->loadModel('guarder')->verify()) $canManage = $this->loadModel('common')->verifyAdmin();
            if($canManage['result'] != 'success') $this->send(array('result' => 'fail', 'warning' => sprintf($this->lang->guarder->okFileVerify, $canManage['name'])));
            $result = $this->ui->writeViewFile($template, $this->post->module, $this->post->file);
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'locate' => inlink('editTemplate', "moduel=$module&file=$file")));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $this->lang->menuGroups->ui = 'edit';

        $this->view->title         = $this->lang->ui->editTemplate;
        $this->view->uiHeader      = false;
        $this->view->files         = $this->lang->ui->files->$template;
        $this->view->realFile      = $this->ui->getExtFile($template, $module, $file);
        $this->view->content       = file_get_contents($this->ui->getEffectViewFile($template, $module, $file));
        $this->view->rawContent    = file_get_contents($this->app->getAppRoot() . 'template' . DS . $template . DS . $module . DS . $file . '.html.php');

        $this->view->currentModule = zget($this->lang->ui->folderAlias, $module);
        $this->view->currentFile   = $file;
        $this->view->fileModule    = $module;

        $this->display();
    }

    /**
     * Manage component. Such as logo, slide and setting.
     *
     * @access public
     * @return void
     */
    public function component()
    {
        $template    = $this->config->template->{$this->app->clientDevice}->name;
        $theme       = $this->config->template->{$this->app->clientDevice}->theme;
        $logoSetting = isset($this->config->site->logo) ? json_decode($this->config->site->logo) : new stdclass();

        $logo = false;
        if(isset($logoSetting->$template->themes->all))    $logo = $logoSetting->$template->themes->all;
        if(isset($logoSetting->$template->themes->$theme)) $logo = $logoSetting->$template->themes->$theme;

        if($logo) $logo->extension = $this->loadModel('file')->getExtension($logo->pathname);

        unset($this->lang->ui->menu);
        $this->view->logo           = $logo;
        $this->view->favicon        = isset($this->config->site->favicon) ? json_decode($this->config->site->favicon) : false;
        $this->view->defaultFavicon = file_exists($this->app->getWwwRoot() . 'favicon.ico');

        $groups = $this->loadModel('slide')->getCategory();
        foreach($groups as $group)
        {
            $group->slides = $this->slide->getList($group->id);
            $group->slide = $this->slide->getFirstSlide($group->id);
        }
        $this->view->groups = $groups;

        /* Get configs of list number. */
        $this->app->loadModuleConfig('file');
        $this->app->loadLang('file');
        if(strpos($this->config->site->modules, 'blog') !== false)    $this->app->loadModuleConfig('blog');
        if(strpos($this->config->site->modules, 'book') !== false)    $this->app->loadModuleConfig('book');
        if(strpos($this->config->site->modules, 'message') !== false) $this->app->loadModuleConfig('message');

        if(strpos($this->config->site->modules, 'article') !== false)
        {
            $this->app->loadModuleConfig('article');
            $this->app->loadLang('article');
        }
        if(strpos($this->config->site->modules, 'forum') !== false)
        {
            $this->app->loadModuleConfig('forum');
            $this->app->loadModuleConfig('reply');
        }
        if(strpos($this->config->site->modules, 'product') !== false)
        {
            $this->app->loadModuleConfig('product');
            $this->app->loadLang('product');
        }

        $this->view->fontsPath = $this->app->getTmpRoot() . 'fonts';
        $this->view->title     = $this->lang->ui->component;
        $this->display();
    }

    /**
     * Custom theme.
     *
     * @param  string $theme
     * @param  string $template
     * @access public
     * @return void
     */
    public function customTheme($theme = '', $template = '')
    {
        if(empty($theme))    $theme    = $this->config->template->{$this->app->clientDevice}->theme;
        if(empty($template)) $template = $this->config->template->{$this->app->clientDevice}->name;

        $templates = $this->ui->getTemplates();
        if(!isset($templates[$template]['themes'][$theme])) die();

        $cssFile  = $this->ui->getCustomCssFile($template, $theme);
        $savePath = dirname($cssFile);
        if(!file_exists($savePath)) mkdir($savePath, 0777, true);

        if($_POST)
        {
            $params = $_POST;
            $lessResult = $this->ui->createCustomerCss($template, $theme, $params);
            if($lessResult['result'] != 'success') $this->send(array('result' => 'fail', 'message' => $lessResult['message']));
            $setting       = isset($this->config->template->custom) ? json_decode($this->config->template->custom, true): array();
            $postedSetting = fixer::input('post')->remove('template,theme')->get();

            $setting[$template][$theme] = $postedSetting;

            $result = $this->loadModel('setting')->setItems('system.common.template', array('custom' => helper::jsonEncode($setting)));
            $this->loadModel('setting')->setItems('system.common.template', array('customVersion' => time()));
            $this->send(array('result' => 'success', 'message' => $this->lang->ui->themeSaved));
        }

        $setting = isset($this->config->template->custom) ? json_decode($this->config->template->custom, true) : array();

        $this->view->setting = !empty($setting[$template][$theme]) ? $setting[$template][$theme] : array();

        $this->view->title      = $this->lang->ui->appearance;
        $this->view->theme      = $theme;
        $this->view->template   = $template;
        $this->view->uiHeader   = true;
        $this->view->hasPriv    = true;

        if(!is_writable($savePath))
        {
            $this->view->hasPriv = false;
            $this->view->errors  = sprintf($this->lang->ui->unWritable, str_replace(dirname($this->app->getWwwRoot()), '', $savePath));
        }

        $this->display();
     }

    /**
     * set logo.
     *
     * @access public
     * @return void
     */
    public function setLogo()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $setNameResult = false;
            if(!empty($_POST['name'])) $setNameResult = $this->loadModel('setting')->setItem('system.common.site.name', $this->post->name);

            if(isset($_FILES['logo']))    $logoReturn    = $this->ui->setOptionWithFile($section = 'logo', $htmlTagName = 'logo');
            if(isset($_FILES['favicon'])) $faviconReturn = $this->ui->setOptionWithFile($section = 'favicon', $htmlTagName = 'favicon', $allowedFileType = 'ico');

            if($setNameResult || $logoReturn['result'] || $faviconReturn['result']) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess, 'locate'=> inlink('component')));
            if(isset($logoReturn)) $this->send($logoReturn);
            if(isset($faviconReturn)) $this->send($faviconReturn);
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }
    }

    /**
     * Delete favicon
     *
     * @access public
     * @return void
     */
    public function deleteFavicon()
    {
        $favicon = isset($this->config->site->favicon) ? json_decode($this->config->site->favicon) : false;
        $this->loadModel('setting')->deleteItems("owner=system&module=common&section=site&key=favicon");
        if($favicon) $this->loadModel('file')->delete($favicon->fileID);

        $defaultFavicon = $this->app->getWwwRoot() . 'favicon.ico';
        if(file_exists($defaultFavicon) and !unlink($defaultFavicon)) $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->ui->deleteFaviconFail, $defaultFavicon)));

        $this->send(array('result' => 'success', 'locate' => inlink('component')));
    }

    /**
     * Delete logo.
     *
     * @access public
     * @return void
     */
    public function deleteLogo()
    {
        $theme = $this->config->template->{$this->app->clientDevice}->theme;
        $this->loadModel('setting')->deleteItems("owner=system&module=common&section=logo&key=$theme");
        $this->loadModel('setting')->deleteItems("owner=system&module=common&section=site&key=logo");

        $logo = isset($this->config->logo->$theme) ? json_decode($this->config->logo->$theme) : false;
        if($logo) $this->loadModel('file')->delete($logo->fileID);

        $this->send(array('result' => 'success', 'locate' => inlink('component')));
    }

    /**
     * Set others for ui.
     *
     * @access public
     * @return void
     */
    public function others()
    {   
        /* Get configs of list number. */
        $this->app->loadModuleConfig('file');
        $this->app->loadLang('file');
        if(strpos($this->config->site->modules, 'blog') !== false)    $this->app->loadModuleConfig('blog');
        if(strpos($this->config->site->modules, 'book') !== false)    $this->app->loadModuleConfig('book');
        if(strpos($this->config->site->modules, 'message') !== false) $this->app->loadModuleConfig('message');

        if(strpos($this->config->site->modules, 'article') !== false)
        {   
            $this->app->loadModuleConfig('article');
            $this->app->loadLang('article');
        }
        if(strpos($this->config->site->modules, 'forum') !== false)
        {   
            $this->app->loadModuleConfig('forum');
            $this->app->loadModuleConfig('reply');
        }
        if(strpos($this->config->site->modules, 'product') !== false)
        {   
            $this->app->loadModuleConfig('product');
            $this->app->loadLang('product');
        }

        if(!empty($_POST))
        {   
            if($this->post->files['watermark'] == 'open')
            {   
                $fontRoot = $this->app->getTmpRoot() . 'fonts/';
                $fontPath = $fontRoot . 'wqy-zenhei.ttc';
                if(!file_exists($fontPath))
                {   
                    if(!is_writable($fontRoot)) $this->send(array('result' => 'fail', 'message' => $this->lang->file->unWritable));
                    if(!copy($this->config->cdn->host . 'fonts/wqy-zenhei.ttc', $fontPath)) $this->send(array('result' => 'fail', 'message' => $this->lang->file->fontNotDownload));
                }
            }

            $result = $this->loadModel('setting')->setItems('system.blog', $this->post->blog);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            $result = $this->loadModel('setting')->setItems('system.article', $this->post->article);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            if(!$_POST['product']['namePosition']) $_POST['product']['namePosition'] = 'left';
            $result = $this->loadModel('setting')->setItems('system.product', $this->post->product);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            $thumbs = helper::jsonEncode($this->post->thumbs);
            $result = $this->loadModel('setting')->setItem('system.common.file.thumbs', $thumbs);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            $result = $this->loadModel('setting')->setItems('system.common.file', $this->post->files);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            $setting = fixer::input('post')->get('productView,QRCode');
            $result  = $this->loadModel('setting')->setItems('system.common.ui', $setting);
            if(!$result) $this->send(array('result' => 'fail', 'message' => $this->lang->fail));

            $setting = fixer::input('post')->remove('productView,QRCode,blog,article,product,thumbs,files')->get();
            $result  = $this->loadModel('setting')->setItems('system.common.site', $setting, 'all');
            if($result) $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
            $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
        }

        $this->view->fontsPath = $this->app->getTmpRoot() . 'fonts';
        $this->lang->menuGroups->ui = 'others';
        $this->view->title = $this->lang->ui->others;
        $this->display();
    }

    /**
     * Export theme function.
     *
     * @access public
     * @return void
     */
    public function exportTheme()
    {
        if($_POST)
        {
            $initResult = $this->ui->initExportPath($this->post->template, $this->post->theme, $this->post->code);
            if(!$initResult) $this->send(array('result' => 'fail', 'message' => 'failed to init export paths'));

            if(!$this->ui->checkExportParams()) $this->send(array('result' => 'fail', 'message' => dao::getError()));
            $exportedFile = $this->ui->exportTheme($this->post->template, $this->post->theme, $this->post->code);
            $exportedFile = helper::safe64Encode($exportedFile);
            $this->send(array('result' => 'success', 'message' => $this->lang->ui->exportedSuccess, 'locate' => inlink('downloadtheme', "theme={$exportedFile}")));
        }

        $templateList = $this->ui->getTemplates();

        foreach($templateList as $code => $template)
        {
            $templates[$code] = $template['name'];
            $themes[$code]    = $template['themes'];
        }

        $this->view->title           = $this->lang->ui->exportTheme;
        $this->view->templateOptions = $templates;
        $this->view->themes          = $themes;
        $this->display();
    }

    /**
     * Download theme.
     *
     * @param  string    $exportedFile
     * @access public
     * @return void
     */
    public function downloadtheme($exportedFile)
    {
        $exportedFile = helper::safe64Decode($exportedFile);
        $fileData = file_get_contents($exportedFile);
        $pathInfo = pathinfo($exportedFile);
        $this->loadModel('file')->sendDownHeader($pathInfo['basename'], 'zip', $fileData, filesize($exportedFile));
    }

    /**
     * Upload a theme package.
     *
     * @access public
     * @return void
     */
    public function uploadTheme()
    {
        $this->app->loadLang('file');

        set_time_limit(0);
        $canManage = array('result' => 'success');
        if(!$this->loadModel('guarder')->verify()) $canManage = $this->loadModel('common')->verifyAdmin();

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if($canManage['result'] != 'success') $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->guarder->okFileVerify, $canManage['name'])));

            if(empty($_FILES))  $this->send(array('result' => 'fail', 'message' => $this->lang->ui->filesRequired));

            $tmpName  = $_FILES['file']['tmp_name'];
            $fileName = $_FILES['file']['name'];
            $package  = basename($fileName, '.zip');

            $packagePath = $this->app->getTmpRoot() . "package";
            if(!is_dir($packagePath)) mkdir($packagePath, 0777, true);
            if(!is_writeable($packagePath)) $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->ui->packagePathUnwriteable, $packagePath)));
            $packageFile = $this->app->getTmpRoot() . "package/$fileName";
            if(file_exists($packageFile)) @unlink($packageFile);
            $result = move_uploaded_file($tmpName, $packageFile);

            $link = inlink('installtheme', "package=$package&downLink=&md5=&type={$this->post->type}");
            $this->app->loadLang('package');
            $this->send(array('result' => 'success', 'message' => $this->lang->package->successUploadedPackage, 'locate' => $link));
        }

        $this->view->files          = array();
        $this->view->showSetPrimary = false;
        $this->view->objectType     = 'themePackage';
        $this->view->objectID       = 'theme';
        $this->view->canManage      = $canManage;
        $this->view->title          = $this->lang->ui->uploadPackage;
        $this->display();
    }

    /**
     * Install a theme.
     *
     * @param  string   $package
     * @param  string   $downLink
     * @param  string   $md5
     * @param  string   $type
     * @access public
     * @return void
     */
    public function installTheme($package, $downLink = '', $md5 = '', $type)
    {
        set_time_limit(0);

        $this->view->error = '';
        $this->view->title = $this->lang->ui->installTheme;

        if($type == 'full')
        {
            $backup = $this->loadModel('backup')->backupAll();
            if($backup['result'] != 'success')
            {
                $this->view->error = $backup['message'];
                die($this->display());
            }
        }

        /* Ignore merge blocks before blocks imported. */
        $this->view->blocksMerged = true;

        /* Get the package file name. */
        $packageFile = $this->loadModel('package')->getPackageFile($package);

        /* Check the package file exists or not. */
        if(!file_exists($packageFile))
        {
            $this->view->error = sprintf($this->lang->package->errorPackageNotFound, $packageFile);
            die($this->display());
        }

        $this->app->loadClass('pclzip', true);
        $zip = new pclzip($packageFile);
        $licenseFiles = $zip->extract(PCLZIP_OPT_BY_PREG, '/system\/config\/license\/*/');

        $zendEncrypt = false;
        foreach($licenseFiles as $licenseFile)
        {
            if($licenseFile['folder']) continue;
            if(strpos($licenseFile['filename'], '.txt') === false)
            {
                $zendEncrypt = true;
                break;
            }
        }

        if($zendEncrypt and !extension_loaded('Zend Guard Loader'))
        {
            $this->view->error = $this->lang->ui->theme->encryptTip->zend;
            die($this->display());
        }

        if(!$zendEncrypt and !empty($licenseFiles) and !extension_loaded('ionCube Loader'))
        {
            $this->view->error = $this->lang->ui->theme->encryptTip->ioncube;
            die($this->display());
        }

        /* Extract the package. */
        $return = $this->package->extractPackage($package, 'theme');
        if($return->result != 'ok')
        {
            $this->view->error = sprintf($this->lang->package->errorExtracted, $packageFile, $return->error);
            die($this->display());
        }

        /* Checking the package pathes. */
        $return = $this->package->checkPackagePathes($package, 'theme');
        if($this->session->dirs2Created == false) $this->session->set('dirs2Created', $return->dirs2Created);    // Save the dirs to be created.
        if($return->result != 'ok')
        {
            $this->view->error = $return->errors;
            die($this->display());
        }

        if($type == 'full') return $this->importFullSite($package, $downLink, $md5);
        $packageInfo = $this->package->parsePackageCFG($package, 'theme');

        /* Process theme code. */
        $installedThemes = $this->ui->getThemesByTemplate($packageInfo->template);
        $package = $this->package->fixThemeCode($package, $installedThemes);

        $packageInfo = $this->package->parsePackageCFG($package, 'theme');

        /* Save to database. */
        if(!$_POST) $this->package->savePackage($package, 'theme');

        /* Copy files to target directory. */
        $this->view->files = $this->package->copyPackageFiles($package, 'theme');

        /* Execute the install.sql. */
        $this->ui->clearTmpData();
        $return = $this->package->executeDB($package, 'install', 'theme');
        if($return->result != 'ok')
        {
            $this->view->error = sprintf($this->lang->package->errorInstallDB, $return->error);
            die($this->display());
        }

        $this->package->fixSlides($package);

        /* Fetch blocks data and show merge */
        $importedBlocks  = $this->dao->setAutoLang(false)->select('*')->from(TABLE_BLOCK)->where('originID')->gt(0)->andWhere('lang')->eq('lang')->fetchAll('originID');
        $oldBlocks       = $this->dao->select('*')->from(TABLE_BLOCK)->where('template')->eq($packageInfo->template)->fetchAll('id');
        $matchedBlocks   = array();
        $unMatchedBlocks = array();

        foreach($importedBlocks as $newBlock)
        {
            foreach($oldBlocks as $block)
            {
                if($block->content == $newBlock->content and $block->type == $newBlock->type)
                {
                    $matchedBlocks[$newBlock->originID] = $block->id;
                    continue;
                }

                if(stripos(',html,htmlcode,php,', ",{$block->type},") === false)
                {
                    if($block->type == $newBlock->type)
                    {
                        $matchedBlocks[$newBlock->originID] = $block->id;
                        continue;
                    }
                }
            }
            if(!isset($matchedBlocks[$newBlock->originID])) $unMatchedBlocks[$newBlock->originID] = $newBlock;
        }

        $this->app->loadLang('block');
        $this->view->matchedBlocks   = $matchedBlocks;
        $this->view->unMatchedBlocks = $unMatchedBlocks;
        $this->view->importedBlocks  = $importedBlocks;
        $this->view->oldBlocks       = $oldBlocks;
        $this->view->blocksMerged    = true;
        $this->view->package         = $package;
        $this->display();
    }

    /**
     * Import full site.
     *
     * @param  string    $package
     * @param  string    $downLink
     * @param  string    $md5
     * @access public
     * @return void
     */
    public function importFullSite($package, $downLink, $md5)
    {
        $packageInfo = $this->package->parsePackageCFG($package, 'theme');

        /* Process theme code. */
        $installedThemes = $this->ui->getThemesByTemplate($packageInfo->template);
        $package = $this->package->fixThemeCode($package, $installedThemes);

        $packageInfo = $this->package->parsePackageCFG($package, 'theme');
        /* Save to database. */
        if(!$_POST) $this->package->savePackage($package, 'theme');

        /* Clear tables to import. */
        $this->ui->clearDB();

        /* Copy files to target directory. */
        $this->view->files = $this->package->copyPackageFiles($package, 'theme');
        $this->package->copySlides();

        /* Execute the install.sql. */
        $this->ui->clearTmpData();
        $return = $this->package->executeDB($package, 'full', 'theme');
        if($return->result != 'ok')
        {
            $this->view->error = sprintf($this->lang->package->errorInstallDB, $return->error);
            die($this->display());
        }

        $this->package->fixLang();
        $this->ui->cloneLayout($packageInfo->template, $package);

        $setting = array();
        $device = $packageInfo->template == 'default' ? 'desktop' : 'mobile';
        $setting[$device]['name']  = $packageInfo->template;
        $setting[$device]['theme'] = $packageInfo->code;

        $setting[$this->app->clientDevice] = helper::jsonEncode($setting[$this->app->clientDevice]);
        $result = $this->loadModel('setting')->setItems('system.common.template', $setting);
        $this->ui->createCustomerCss($packageInfo->template, $packageInfo->code);
        $this->view->title = $this->lang->ui->importThemeSuccess;
        $this->display('ui', 'importsuccess');
    }

    /**
     * Fix theme datas.
     *
     * @access public
     * @return void
     */
    public function fixTheme()
    {
        $packageInfo = $this->loadModel('package')->parsePackageCFG($this->post->package, 'theme');

        $this->package->mergeBlocks($packageInfo);
        $this->package->mergeCustom($packageInfo);
        $this->package->fixLayout($packageInfo);
        $this->package->fixLang();

        $setting = array();
        $setting[$this->app->clientDevice]['name']  = $packageInfo->template;
        $setting[$this->app->clientDevice]['theme'] = $packageInfo->code;
        $setting[$this->app->clientDevice]  = helper::jsonEncode($setting[$this->app->clientDevice]);
        $setting['parser'] = isset($packageInfo->parser) ? $packageInfo->parser : 'raintpl';

        $result = $this->loadModel('setting')->setItems('system.common.template', $setting);

        unset($this->session->originTheme);
        $this->send(array('result' => 'success', 'message' => $this->lang->ui->importThemeSuccess, "locate" => inlink('customtheme')));
    }

    /**
     * Delete a theme.
     *
     * @param  string    $template
     * @param  string    $theme
     * @access public
     * @return void
     */
    public function deleteTheme($template, $theme)
    {
        $result = $this->ui->deleteTheme($template, $theme);
        if($result) $this->send(array('result' => 'success', 'message' => $this->lang->ui->deleteThemeSuccess, "locate" => inlink('setTemplate')));
        $this->send(array('result' => 'fail', 'message' => $this->lang->ui->deleteThemeFail));
    }

    /**
     * Set device admin.
     *
     * @param  string    $device
     * @access public
     * @return void
     */
    public function setDevice($device, $fromVisual = 0)
    {
        if($device == 'mobile')
        {
            $mobileTemplate = isset($this->config->site->mobileTemplate) ? $this->config->site->mobileTemplate : 'close';
            if($mobileTemplate == 'close')
            {
                $deviceConfig = new stdclass;
                $deviceConfig->detectDevice = true;

                $result = $this->loadModel('site')->setSystem($deviceConfig);
                if(isset($result['result']) and $result['result'] == 'fail') $this->send($result);
                if($setting->mobileTemplate == 'close') $this->session->set('device', 'desktop');
            }
        }

        $this->session->set('device', $device);

        if($fromVisual)
        {
            setcookie('visualDevice', $device, $this->config->cookieLife, $this->config->cookiePath, '', false, true);
        }

        $template = $this->config->template->{$device};
        if(isset($this->config->template->{$device}) and !is_object($this->config->template->{$device})) $template = json_decode($this->config->template->{$device});
        $setting['name']  = $template->name;
        $setting['theme'] = $template->theme;
        $setting = helper::jsonEncode($setting);
        $result = $this->loadModel('setting')->setItems('system.common.template', array($device => $setting));

        $this->locate($this->server->http_referer);
    }

    /**
     * Delete a template.
     *
     * @param  string    $template
     * @access public
     * @return void
     */
    public function uninstallTemplate($template)
    {
        $result = $this->ui->removeTemplateData($template);
        if(!$result) $this->send(array('result' => 'fail', 'message' => dao::getError()));
        $result = $this->ui->removeTemplateFiles($template);
        $this->send(array('result' => 'success', 'message' => $this->lang->setSuccess));
    }

    /**
     * Theme store page.
     *
     * @param  string $industry
     * @param  string $color
     * @param  int    $recTotal
     * @param  int    $recPerPage
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function themeStore($type = 'byindustry', $param = 'all', $recTotal = 0, $recPerPage = 10, $pageID = 1)
    {
        $this->loadModel('package');
        $pager = null;

        $installedThemes = $this->ui->getInstalledThemes();

        $codes = array();
        if($type == 'installed')
        {
            foreach($installedThemes as $template => $themes)
            {
                $codes = $codes + array_keys($themes);
            }

            $param = join(',', $codes);
        }

        /* Get results from the api. */
        $results = $this->loadModel('package')->getThemesByApi($type, $param, $recTotal, $recPerPage, $pageID);
        if($results)
        {
            $this->app->loadClass('pager', $static = true);
            $pager  = new pager($results->dbPager->recTotal, $results->dbPager->recPerPage, $results->dbPager->pageID);
        }

        if($this->session->currentGroup != 'design') $this->lang->menuGroups->ui = 'themestore';
        if($this->session->currentGroup == 'design') $this->view->uiHeader = true;

        $this->view->themes       = zget($results, 'themes');
        $this->view->title        = $this->lang->ui->themeStore;
        $this->view->position[]   = $this->lang->package->obtain;

        $this->view->industryTree = str_replace('/index.php', $this->server->script_name, $this->package->getIndustriesByAPI());
        $this->view->pager        = $pager;
        $this->view->tab          = 'obtain';
        $this->view->type         = $type;
        $this->view->param        = $param;
        $this->display();
    }

    /**
     * Browse theme page.
     *
     * @access public
     * @return void
     */
    public function browseTheme()
    {
        $this->view->themes          = $this->ui->getThemesAvailable();
        $this->view->installedThemes = $this->ui->getInstalledThemes();
        $this->view->packagePath     = $this->app->getTmpRoot() . 'package';
        $this->display();
    }

    /**
     * Get encrypt css and js.
     *
     * @param  int    $type
     * @param  int    $template
     * @param  int    $theme
     * @access public
     * @return void
     */
    public function getEncrypt($type, $template, $theme)
    {
        $this->loadThemeHooks();

        if($type == 'css')
        {
            //header('Content-type: text/css');
            $cssFun = "get{$theme}CSS";
            if(!function_exists($cssFun)) die('/*no css*/');
            $params = $this->ui->getCustomParams($template, $theme);
            $encryptCss = $cssFun();
            $customCss = zget($params, 'css', '');
            $params['css'] = $encryptCss . $customCss;
            $lessResult = $this->ui->createCustomerCss($template, $theme, $params);
            if($lessResult['result'] != 'success') die();
            exit($lessResult['css']);
        }

        if($type == 'js')
        {
            header('Content-type: text/javascript');
            $jsFun = "get{$theme}js";
            if(!function_exists($jsFun)) die('');
            $js = $jsFun();
            exit($js);
        }
        exit;
    }

    /**
     * Set js and css code for pages.
     *
     * @param  string $page
     * @access public
     * @return void
     */
    public function setCode($page = 'all')
    {
        $theme    = $this->config->template->{$this->app->clientDevice}->theme;
        $template = $this->config->template->{$this->app->clientDevice}->name;
        if($_POST)
        {
            $post = fixer::input('post')->stripTags('css,js', $this->config->allowedTags->admin)->get();

            if(isset($post->css))
            {
                $cssSetting["{$template}_{$theme}_{$page}"] = helper::decodeXSS(trim($post->css));
                $cssLength = strlen($cssSetting["{$template}_{$theme}_{$page}"]);
                if($cssLength > 65535) $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->ui->lengthOverflow, $cssLength)));
                $this->loadModel('setting')->setItems('system.common.css', $cssSetting);
            }

            if(isset($post->js))
            {
                $jsSetting["{$template}_{$theme}_{$page}"]  = helper::decodeXSS(trim($post->js));
                $jsLength  = strlen($jsSetting["{$template}_{$theme}_{$page}"]);
                if($jsLength  > 65535) $this->send(array('result' => 'fail', 'message' => sprintf($this->lang->ui->lengthOverflow, $jsLength)));
                $this->loadModel('setting')->setItems('system.common.js', $jsSetting);
            }

            $this->send(array('result' => 'success', 'message' => $this->lang->saveSuccess, 'data' => $post));
        }

        $this->app->loadLang('block');
        $this->view->title    = $this->lang->ui->setCode;
        $this->view->page     = $page;
        $this->view->template = $template;
        $this->view->theme    = $theme;
        $this->view->uiHeader = true;
        $this->view->pageList = $this->lang->block->$template->pages;
        $this->display();
    }

    /**
     * Admin effect page.
     *
     * @param  int    $pageID
     * @access public
     * @return void
     */
    public function effect($pageID = 1)
    {
        $community = $this->loadModel('admin')->getRegisterInfo();
        if(!$community)
        {
            $this->lang->redirecting = $this->lang->effect->redirecting;

            $this->view->reason = $this->lang->effect->bindCommunity;
            $this->view->locate = helper::createLink('admin', 'register');
            $this->display('common', 'redirect');
            die();
        }

        $this->view->title = $this->lang->effect->admin;
        $result = $this->ui->getEffectListByApi($pageID);
        if($result->result == 'success')
        {
            $this->app->loadClass('pager', $static = true);
            $pager  = new pager($result->pager->recTotal, $result->pager->recPerPage, $result->pager->pageID);
            $this->view->pager = $pager;
            $this->view->categories = $result->categories;
            $this->view->effects = $result->effects;
        }
        else
        {
            $this->view->effects = null;
        }

        $this->view->blocks = $this->dao->select('*')->from(TABLE_BLOCK)->where('effectID')->ne('0')->fetchAll('effectID');

        $this->display();
    }

    /**
     * Import one effect.
     *
     * @param  int    $id
     * @access public
     * @return void
     */
    public function importEffect($id)
    {
        if($_POST)
        {
            $result = $this->ui->importEffect($id);
            $this->send($result);
        }

        $template = $this->config->template->{$this->app->clientDevice}->name;
        $blockList = $this->loadModel('block')->getList($template);
        $blocks = array('0' => '');
        foreach($blockList as $block) $blocks[$block->id] = $block->title;

        $this->view->error      = $this->ui->checkEffectPath();
        $this->view->id         = $id;
        $this->view->effect     = $this->ui->getEffectByApi($id);
        $this->view->title      = $this->lang->effect->import;
        $this->view->blocks     = $blocks;
        $this->view->modalWidth = 670;
        $this->display();
    }
}
