<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of common module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     common
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class commonModel extends model
{
    /**
     * Do some init functions.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        if(!defined('FIRST_RUN'))
        {
            if(!defined('SESSION_STARTED')) $this->startSession();
            $this->sendHeader();
            $this->setUser();
            $this->loadConfigFromDB();

            if($this->config->cache->type != 'close')
            {
                /* Code for task #2746. */
                if($this->app->user->admin != 'no' and RUN_MODE == 'front') $this->config->cache->expired = 1;
                $this->config->cache->file->expired = $this->config->cache->expired;
                $this->app->loadCacheClass();
            }
            if(RUN_MODE == 'admin' and helper::isAjaxRequest()) $this->config->debug = 1;

            $this->loadAlias();
            $this->loadModel('site')->setSite();
            define('FIRST_RUN', true);
        }
    }

    /**
     * Set the header info.
     * 
     * @access public
     * @return void
     */
    public function sendHeader()
    {
        $type = 'html';
        if((strpos($_SERVER['REQUEST_URI'], '.xml') !== false) or (isset($_GET['t']) and $_GET['t'] == 'xml')) $type = 'xml'; 

        header("Content-Type: text/{$type}; charset={$this->config->charset}");
        header("Cache-control: private");
    }

    /**
     * Load configs from database and save it to config->system and config->personal.
     *
     * @access public
     * @return void
     */
    public function loadConfigFromDB()
    {
        /* Get configs of system and current user. */
        $account = isset($this->app->user->account) ? $this->app->user->account : '';
        if($this->config->db->name) $config  = $this->loadModel('setting')->getSysAndPersonalConfig($account);
        $this->config->system   = isset($config['system']) ? $config['system'] : array();
        $this->config->personal = isset($config[$account]) ? $config[$account] : array();

        /* Overide the items defined in config/config.php and config/my.php. */
        foreach($this->config->system as $module => $records)
        {
            if($module == 'common')
            {
                foreach($this->config->system->common as $record)
                {
                    if($record->section)
                    {
                        if(!isset($this->config->{$record->section})) $this->config->{$record->section} = new stdclass();
                        if($record->key)
                        {
                            if($record->section == 'guarder') $record->value = json_decode($record->value);
                            $this->config->{$record->section}->{$record->key} = $record->value;
                        }
                    }
                    else
                    {
                        if(!$record->section) $this->config->{$record->key} = $record->value;
                    }
                }
            }
            else
            {
                foreach($this->config->system->$module as $record)
                {
                    if($record->module)
                    {
                        if(!isset($this->config->{$record->module})) $this->config->{$record->module} = new stdclass();
                        if($record->section)
                        {
                            if(!isset($this->config->{$record->module}->{$record->section})) $this->config->{$record->module}->{$record->section} = new stdclass();
                            if($record->key) $this->config->{$record->module}->{$record->section}->{$record->key} = $record->value;
                        }
                        else
                        {
                            if(!$record->section) $this->config->{$record->module}->{$record->key} = $record->value;
                        }
                    }
                }
            }
        }

        $device = $this->app->clientDevice;
        if(isset($this->config->template->desktop) and !is_object($this->config->template->desktop)) $this->config->template->desktop = json_decode($this->config->template->desktop);
        if(isset($this->config->template->mobile) and !is_object($this->config->template->mobile)) $this->config->template->mobile = json_decode($this->config->template->mobile);
        if(!isset($this->config->site->status)) $this->config->site->status = 'normal';
    }

    /**
     * Check the priviledge.
     *
     * @access public
     * @return void
     */
    public function checkPriv()
    {
        if($this->config->site->filterFunction == 'open')
        {
            if($this->server->request_method == 'post') $inBlackList = $this->loadModel('guarder')->logOperation('ip', 'post');
            $inList = $this->loadModel('guarder')->inList();
            if($inList)
            {
                $contact = json_decode($this->config->company->contact);
                $this->app->moduleName == 'user' ? die(sprintf(strip_tags($this->lang->badrequestTips), $contact->phone, $contact->email)) : die(sprintf($this->lang->badrequestTips, $contact->phone, $contact->email));
            }
        }

        if(RUN_MODE == 'admin' and !empty($this->config->group->unUpdatedAccounts) and strpos($this->config->group->unUpdatedAccounts, $this->app->user->account) !== false)
        {
            $user = $this->app->user;
            $user->rights = $this->loadModel('user')->authorize($user);
            $this->session->set('user', $user);
            $this->app->user = $this->session->user;

            $unUpdatedAccounts = str_replace($this->app->user->account, '', $this->config->group->unUpdatedAccounts);
            if(str_replace(',', '', $unUpdatedAccounts) == '') $unUpdatedAccounts = '';
            $this->loadModel('setting')->setItem("system.group.unUpdatedAccounts", $unUpdatedAccounts);
        }

        $module = $this->app->getModuleName();
        $method = $this->app->getMethodName();

        if($this->isOpenMethod($module, $method)) return true;

        /* If no $app->user yet, go to the login page. */
        if(RUN_MODE == 'admin' and $this->app->user->account == 'guest')
        {
            $referer = helper::safe64Encode($this->app->getURI(true));
            die(js::locate(helper::createLink('user', 'login', "referer=$referer")));
        }

        /* if remote ip not equal loginIP, go to login page. */
        if(RUN_MODE == 'admin')
        {
            if(zget($this->config->site, 'checkSessionIP', '0') and (helper::getRemoteIP() != $this->app->user->loginIP))
            {
                session_destroy();
                $referer = helper::safe64Encode($this->app->getURI(true));
                die(js::locate(helper::createLink('user', 'login', "referer=$referer")));
            }
        }

        /* go to login page, if the setting of front page is need login. */
        if(RUN_MODE == 'front')
        {
            $frontConfig = isset($this->config->site->front) ? $this->config->site->front : 'guest';
            if($frontConfig == 'login' and $this->app->user->account == 'guest')
            {
                $referer = helper::safe64Encode($this->app->getURI(true));
                die(js::locate(helper::createLink('user', 'login', "referer=$referer")));
            }
        }

        /* Check the priviledge. */
        if(!commonModel::hasPriv($module, $method)) $this->deny($module, $method);
        if(!isset($this->config->rights->guest[strtolower($module)][strtolower($method)]) and !helper::isAjaxRequest() and RUN_MODE == 'front' and $this->app->user->account != 'guest' and strtolower($method) != 'checkemail')
        {
            if(isset($this->config->site->checkEmail) and $this->config->site->checkEmail == 'open' and !$this->app->user->emailCertified)
            {
                exit(js::locate(helper::createLink('user', 'checkEmail')));
            }
        }
    }

    /**
     * Check current user has priviledge to the module's method or not.
     *
     * @param mixed $module     the module
     * @param mixed $method     the method
     * @static
     * @access public
     * @return bool
     */
    public static function hasPriv($module, $method)
    {
        $module = strtolower($module);
        $method = strtolower($method);
        global $app, $config;
        
        $rights  = $app->user->rights;
        if(RUN_MODE == 'admin')
        {
            if($app->user->admin == 'no') return false;
            if($app->user->admin == 'super') return true;
            if($app->user->admin != 'no' and $module == 'admin' and $method == 'index') return true;
            if($module == 'file' and strtolower($method) == 'uploadfile' and isset($rights['file']['upload'])) return true;
            if(isset($rights[$module][$method])) return true;
            return false;
        }
        if(!commonModel::isAvailable($module)) return false;

        if(isset($rights[$module][$method])) return true;

        /* Check rights one more time to enable new created rights.*/
        if($app->user->account == 'guest')
        {
            if(isset($config->rights->guest[$module][$method])) return true;
        }
        else
        {
            if(isset($config->rights->guest[$module][$method]) or isset($config->rights->member[$module][$method])) return true;
        }

        return false;
    }

    /**
     * Set the user info.
     *
     * @access public
     * @return void
     */
    public function setUser()
    {
        if($this->session->user) return $this->app->user = $this->session->user;
        
        /* Create a guest account. */
        $user           = new stdclass();
        $user->id       = 0;
        $user->account  = 'guest';
        $user->realname = 'guest';
        $user->admin    = RUN_MODE == 'cli' ? 'super' : 'no';
        if(RUN_MODE == 'front') $user->rights = $this->config->rights->guest;

        $this->session->set('user', $user);
        $this->app->user = $this->session->user;
    }

    /**
     * Check whether module is available.
     *
     * @param  string $module
     * @static
     * @access public
     * @return void
     */
    public static function isAvailable($module)
    {
        global $app, $config;
        $enabledModules = zget($config->site, 'modules', '');
        if($module == 'order' and strpos($enabledModules, 'score') === false and strpos($enabledModules, 'shop') === false) return false;

        /* Check whether dependence modules is available. */
        if(!empty($config->dependence->$module))
        {
            foreach($config->dependence->$module as $dependModule)
            {
                if(!isset($config->site->modules) or strpos($config->site->modules, $dependModule) === false) return false;
            }
        }
        
        return true;
    }

    /**
     * Show the deny info.
     *
     * @param mixed $module     the module
     * @param mixed $method     the method
     * @access public
     * @return void
     */
    public function deny($module, $method)
    {
        if(helper::isAjaxRequest())
        {
            $this->app->loadLang($module);
            $this->app->loadLang('user');
            $moduleName = isset($this->lang->$module->common)  ? $this->lang->$module->common:  $module;
            $methodName = isset($this->lang->$module->$method) ? $this->lang->$module->$method: $method;
            $data = sprintf(substr($this->lang->user->errorDeny, 0, strpos($this->lang->user->errorDeny, '<br/>')), $moduleName, $methodName);
            print(json_encode($data)) and die(helper::removeUTF8Bom(ob_get_clean()));
        }

        /* Get authorize again. */
        $user = $this->app->user;
        $user->rights = $this->loadModel('user')->authorize($user);
        $this->session->set('user', $user);
        $this->app->user = $this->session->user;
        if(commonModel::hasPriv($module, $method)) return true;

        $vars = "module=$module&method=$method";
        if(isset($_SERVER['HTTP_REFERER']))
        {
            $referer  = helper::safe64Encode($_SERVER['HTTP_REFERER']);
            $vars .= "&referer=$referer";
        }

        if(RUN_MODE == 'admin')
        {
            if(strpos($_SERVER['HTTP_REFERER'], "m=user&f=login") !== false) die(js::locate(helper::createLink('admin', 'index')));
        }

        $denyLink = helper::createLink('user', 'deny', $vars);
        die(js::locate($denyLink));
    }

    /**
     * Judge a method of one module is open or not?
     *
     * @param  string $module
     * @param  string $method
     * @access public
     * @return bool
     */
    public function isOpenMethod($module, $method)
    {
        $module = strtolower($module);
        $method = strtolower($method);
        if($module == 'user' and strpos(',login|logout|deny|resetpassword|checkresetkey|oauthbind|', $method)) return true;
        if($module == 'admin' and $method == 'switchlang') return true;
        if($module == 'mail' and $method == 'sendmailcode') return true;
        if($module == 'guarder' and $method == 'validate') return true;
        if($module == 'misc' and $method == 'ajaxgetfingerprint') return true;
        if($module == 'wechat' and $method == 'response') return true;
        if($module == 'source' and $method == 'js') return true;
        if($module == 'source' and $method == 'css') return true;
        if($module == 'sitemap' and $method == 'index') return true;
        if($module == 'file' and $method == 'apiforueditor') return true;
        if(RUN_MODE == 'admin' and $this->app->user->admin != 'no' and isset($this->config->rights->admin[$module][$method])) return true;
        if(RUN_MODE == 'admin' and $module == 'farm' and $method == 'register') return true;
        if(RUN_MODE == 'admin' and $module == 'farm' and (strpos($method, 'api') !== false)) return true;
        if(RUN_MODE == 'admin' and $module == 'widget') return true;

        if($this->loadModel('user')->isLogon() and stripos($method, 'ajax') !== false) return true;

        return false;
    }

    /**
     * Check domain and header 301.
     *
     * @access public
     * @return void
     */
    public function checkDomain()
    {
        if(RUN_MODE == 'install' or RUN_MODE == 'upgrade' or RUN_MODE == 'shell' or RUN_MODE == 'admin' or !$this->config->installed) return true;

        $http       = helper::isHttps() ? 'https://' : 'http://';
        $httpHost   = $this->server->http_host;
        if(strpos($this->server->http_host, ':') !== false) $httpHost = substr($httpHost, 0, strpos($httpHost, ':'));
        $currentURI = $http . $httpHost . $this->server->request_uri;
        $scheme     = isset($this->config->site->scheme) ? $this->config->site->scheme : 'http';
        $mainDomain = isset($this->config->site->domain) ? $this->config->site->domain : '';
        $mainDomain = str_replace(array('http://', 'https://'), '', $mainDomain);

        /* Check main domain and scheme. */
        $redirectURI = $currentURI;
        if(strpos($redirectURI, $scheme . '://') !== 0) $redirectURI = $scheme . substr($redirectURI, strpos($redirectURI, '://'));
        if(!empty($mainDomain) and $httpHost != $mainDomain) $redirectURI = str_replace($httpHost, $mainDomain, $redirectURI);
        if($redirectURI != $currentURI) helper::header301($redirectURI);

        /* Check domain is allowed. */
        $allowedDomains = isset($this->config->site->allowedDomain) ? $this->config->site->allowedDomain : '';
        $allowedDomains = str_replace(array('http://', 'https://'), '', $allowedDomains);
        if(!empty($allowedDomains))
        {
            if(strpos($allowedDomains, $httpHost) !== false) return true;
            if(!empty($mainDomain) and helper::parseSiteCode($httpHost) == helper::parseSiteCode($mainDomain)) return true;
            die('domain denied.');
        }
    }

    /**
     * Check API.
     * 
     * @access public
     * @return void
     */
    public function checkAPI()
    {
        $key = '';
        if($this->post->key) $key = $this->post->key;
        if($this->get->key) $key = $this->get->key;

        if(!empty($this->config->site->api->key) or $this->config->site->api->key != $key) die('KEY ERROR!');
        if(!empty($this->config->site->api->ip) && strpos($this->config->site->api->ip, helper::getRemoteIP()) === false) die('IP DENIED');
    }

    /**
     * Create the main menu.
     *
     * @param  string $currentModule
     * @static
     * @access public
     * @return string
     */
    public static function createMainMenu($currentModule)
    {
        $group = self::computeMenuGroup($currentModule);

        global $config, $app, $lang;
        $app->session->set('currentGroup', $group);

        $menus  = explode(',', $config->menus->{$group});
        $string = "<ul class='nav navbar-nav'>\n";

        foreach($menus as $menu)
        {
            $extra = zget($config->menuExtra, $menu, '');

            if(isset($config->menuDependence->$menu) and !commonModel::isAvailable($config->menuDependence->$menu)) continue;
            if($menu == 'wechat' and !commonModel::hasPublic()) continue;
            if(!isset($lang->menu->{$menu})) continue;

            $mainMenu      = $lang->menu->{$menu};
            $currentModule = zget($lang->menuGroups, $currentModule);
            $class         = $menu == $currentModule ? " class='active'" : '';
            list($label, $module, $method, $vars) = explode('|', $mainMenu);

            /* Judge whether article/blog/page menu should shown. */
            if(!commonModel::isAvailable('article') && $vars == 'type=article') continue;
            if(!commonModel::isAvailable('video') && $vars == 'type=video') continue;
            if(!commonModel::isAvailable('blog') && $vars == 'type=blog') continue;
            if(!commonModel::isAvailable('page') && $vars == 'type=page') continue;
            if(!commonModel::isAvailable('submission') && $vars == 'type=submission') continue;
           
            if($module == 'wechat' and $method != 'admin' and !commonModel::isAvailable($module)) continue;
            if($module != 'wechat' and $module != 'user' and $module != 'article' and !commonModel::isAvailable($module)) continue;

            if(commonModel::hasPriv($module, $method) || ($module == 'wechat' && $method == 'admin') )
            {
                $link = helper::createLink($module, $method, $vars);
            }
            else
            {
                $link = self::getLinkFromSubmenu($menu);
            }

            if($link != '') $string .= "<li$class><a href='$link' $extra>$label</a></li>\n";
        }

        if($group == 'home') $string .= "<li>" . html::a(helper::createLink('site', 'sethomemenu'), "<i class='icon icon-plus'> </i>" . $lang->custom) . "</li>";
        
        $string .= "</ul>\n";
        return $string;
    }
     
    /**
     * Compute admin menu group of a module.
     * 
     * @param  string    $module 
     * @access public
     * @return void
     */
    public static function computeMenuGroup($module)
    {
        global $config, $app, $lang;

        self::fixGroups();
        $module = zget($lang->menuGroups, $module);

        /* Use home as default admin menu group. */
        $group = 'home';

        /* Set current module. */
        $currentGroup = $app->cookie->currentGroup;

        /* Methods not in multiEntrances can not change their menu group. */
        if(!in_array($app->getModuleName() . '_' . $app->getMethodName(), $config->multiEntrances)) $currentGroup = false;

        if($currentGroup and isset($config->menus->{$currentGroup}) and strpos($config->menus->$currentGroup, $module) !== false) 
        {
            $group = $currentGroup;
        }
        else
        {
            if(isset($config->menuGroups->$module)) $group = $config->menuGroups->$module;
        }

        return $group;
    }

    /**
     * Get Link From Submenu.
     * 
     * @param  string    $menuGroup 
     * @access public
     * @return string
     */
    public static function getLinkFromSubmenu($menuGroup)
    {
        global $lang, $config;

        if(!isset($lang->$menuGroup->menu)) return '';

        foreach($lang->$menuGroup->menu as $code => $menu)
        {
            $extra = zget($config->menuExtra, $code, '');
            if(is_array($menu)) $menu = $menu['link'];
            list($label, $moduleName, $methodName, $vars) = explode('|', $menu);

            if(commonModel::hasPriv($moduleName, $methodName)) return helper::createLink($moduleName, $methodName, $vars);
        }

        return '';
    }

    /**
     * Check has wechat public.
     * 
     * @static
     * @access public
     * @return bool
     */
    public static function hasPublic()
    {
        global $config, $app;
        if(isset($config->wechatPublic->hasPublic)) return $config->wechatPublic->hasPublic;

        $publicCount = $app->loadClass('dao')->select('count(*) as count')->from(TABLE_WX_PUBLIC)->fetch('count');
        
        $data = new stdclass();
        $data->owner   = 'system';
        $data->module  = 'common';
        $data->section = 'wechatPublic';
        $data->key     = 'hasPublic';

        $data->value = $publicCount ? '1' : '0';
        $app->loadClass('dao')->replace(TABLE_CONFIG)->data($data)->exec();

        return $publicCount;
    }

    /**
     * Create the module menu.
     *
     * @param  string $currentModule
     * @static
     * @access public
     * @return void
     */
    public static function createModuleMenu($currentModule, $navClass = 'nav-left nav-primary nav-stacked', $chevron = true)
    {
        global $lang, $app, $config;

        $currentModuleAlias = zget($lang->menuGroups, $currentModule);
        if(!isset($lang->$currentModuleAlias->menu)) return false;

        $string = "<ul class='nav " . $navClass . "'>\n";

        /* Get menus of current module and current method. */
        $moduleMenus   = $lang->$currentModuleAlias->menu;
        $currentMethod = $app->getMethodName();

        /* Cycling to print every menus of current module. */
        foreach($moduleMenus as $methodName => $methodMenu)
        {
            $extra = zget($config->moduleMenu, "{$currentModule}_{$methodName}", '');
            if(is_array($methodMenu))
            {
                $methodAlias = $methodMenu['alias'];
                $methodLink  = $methodMenu['link'];
            }
            else
            {
                $methodAlias = '';
                $methodLink  = $methodMenu;
            }

            /* Split the methodLink to label, module, method, vars. */
            list($label, $module, $method, $vars) = explode('|', $methodLink);
            if($chevron) $label .= '<i class="icon-chevron-right"></i>';

            if($module != 'user' and $module != 'article' and !commonModel::isAvailable($module)) continue;
            if(commonModel::hasPriv($module, $method))
            {
                $class = '';
                if($module == $currentModule && $method == $currentMethod) $class = " class='active'";
                if($module == $currentModule && strpos(",$methodAlias,", ",$currentMethod,") !== false) $class = " class='active'";
                $string .= "<li{$class}>" . html::a(helper::createLink($module, $method, $vars), $label, $extra) . "</li>\n";
            }
        }

        $string .= "</ul>\n";
        return $string;
    }

    /**
     * Create menu for managers.
     *
     * @access public
     * @return string
     */
    public static function createManagerMenu($class = 'nav navbar-nav navbar-right')
    {
        global $app, $lang , $config;

        $string  = '<ul class="' . $class . '">';
        $string .= sprintf('<li data-toggle="tooltip" title="%s" data-id="profile" class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon icon-user icon-2x"></i><span class="text-username"> %s <b class="caret"></b></span></a>', $app->user->realname, $app->user->realname);
        $string .= '<ul class="dropdown-menu">';
        $string .= '<li class="heading"><i class="icon icon-user icon-large"></i><strong> ' . $app->user->realname . '</strong></li>';
        $string .= '<li class="divider"></li>';
        $string .= '<li>' . html::a(helper::createLink('user', 'setPassword'), $lang->changePassword, "data-toggle='modal'") . '</li>';
        $string .= '<li>' . html::a(helper::createLink('user', 'setEmail'), $lang->setEmail, "data-toggle='modal'") . '</li>';
        $string .= '<li>' . html::a(helper::createLink('user', 'setSecurity'), $lang->setSecurity, "data-toggle='modal'") . '</li>';
        $string .= '<li>' . html::a(helper::createLink('misc', 'about'), $lang->about, "data-toggle='modal'") . '</li>';
        $string .= '<li>' . html::a(helper::createLink('misc','thanks'), $lang->thanks, "data-toggle='modal'") . '</li>';
        $string .= '<li>' . html::a(helper::createLink('user','logout'), $lang->logout) . '</li>';
        $string .= '</ul></li></ul>';

        return $string;
    }

    /**
     * Print the top bar.
     *
     * @param  boolean $asListItem
     * @access public
     * @return void
     */
    public static function printTopBar()
    {
        $topBar = '';
        if(!commonModel::isAvailable('user')) return '';

        global $app, $config, $lang;

        /* Compute cart info. */
        if($app->clientDevice == 'desktop' and commonModel::isAvailable('shop'))
        {
            $cart          = ($app->cookie->cart === false or $app->cookie->cart == '') ? array() : json_decode($app->cookie->cart);
            $goodsInCookie = array();
            foreach($cart as $product)
            {
                $goods = new stdclass();
                $goods->account = 'guest';
                $goods->product = $product->product;
                $goods->count   = $product->count;
                $goods->lang    = 'zh-cn';
                $goodsInCookie[$product->product] = $goods;
            }

            $goodsInCookie = (array) $goodsInCookie;
            $cartCount = 0;
            if($app->user->account != 'guest')
            {
                $cartCount = $app->loadClass('dao')->select('count(*) as count')->from(TABLE_CART)
                    ->where('account')->eq($app->user->account)
                    ->beginIf(!empty($goodsInCookie))->andWhere('product')->notin(array_keys($goodsInCookie))->fi()
                    ->fetch('count');
            }

            $cartCount += count($goodsInCookie);

            if($cartCount)
            {
                $app->loadLang('cart');
                $cartInfo = html::a(helper::createLink('cart', 'browse'), sprintf($lang->cart->topbarInfo, $cartCount));
                $topBar .= "<span class='text-center text-middle' id='cartBox'>{$cartInfo}</span>";
            }
        }

        if($app->user->account != 'guest')
        {
            $messages = '';
            if(commonModel::isAvailable('message'))
            {
                $app->loadLang('user');
                $messages = $app->loadClass('dao')->select('COUNT(*) as count')->from(TABLE_MESSAGE)->where('`to`')->eq($app->user->account)->andWhere('readed')->eq(0)->fetch('count');
                if($messages) $messages = html::a(helper::createLink('user', 'message'), sprintf($lang->user->message->mine, $messages));
            }

            if($app->clientDevice == 'mobile')
            {
                $topBar .= "<li class='menu-user-center text-center'>" . html::a(helper::createLink('user', 'control'), "<div class='user-avatar'><i class='icon icon-user avatar icon-s2 bg-primary circle'></i><strong class='user-name'>{$app->session->user->realname}</strong></div>") . '</li>';
                $topBar .= "<li>" . html::a(helper::createLink('user', 'control'), $app->lang->dashboard) . '</li>';
                $topBar .= '<li>' . html::a(helper::createLink('user', 'logout'),  $app->lang->logout) . '</li>';
            }
            else
            {
                $topBar .= html::a(helper::createLink('user', 'control'), "<i class='icon-user icon-small'> </i>" . $app->session->user->realname);
                if($messages) $topBar .= "<span id='msgBox'>{$messages}</span>";
                $topBar .= html::a(helper::createLink('user', 'logout'),  $app->lang->logout);
            }
        }
        else
        {
            if($app->clientDevice == 'mobile')
            {
                if(self::isAvailable('user'))
                {
                    $topBar .= '<li>' . html::a(helper::createLink('user', 'login'), $app->lang->login) . '</li>';
                    $topBar .= '<li>' . html::a(helper::createLink('user', 'register'), $app->lang->register) . '</li>';
                }
            }
            else
            {
                $topBar .= html::a(helper::createLink('user', 'login'), $app->lang->login);
                $topBar .= html::a(helper::createLink('user', 'register'), $app->lang->register);
            }
        }

        return $topBar;
    }

    /**
     * Print language bar.
     *
     * @static
     * @access public
     * @return string
     */
    public static function printLanguageBar()
    {
        $languagebar = '';
        global $config, $app;
        $langs = explode(',', $config->enabledLangs);
        if(count($langs) == 1) return false;
        if($app->clientDevice == 'mobile')
        {
            if(commonModel::isAvailable('user')) $languagebar .= "<li class='divider'></li>";
            $clientLang = $app->getClientLang();
            foreach($langs as $lang)
            {
                $a = html::a(getHomeRoot($config->langsShortcuts[$lang]), $config->langs[$lang]);
                $liClass = $clientLang === $lang ? " class='active'" : '';
                $a = "<li{$liClass}>{$a}</li>";
                $languagebar .= $a;
            }
        }
        else
        {
            foreach($langs as $lang) $languagebar .= html::a(getHomeRoot($config->langsShortcuts[$lang]), $config->langAbbrLabels[$lang]);
        }

        return $languagebar;
    }

    /**
     * Print the nav bar.
     *
     * @static
     * @access public
     * @return void
     */
    public static function printNavBar()
    {
        global $app;
        echo "<ul class='nav'>";
        echo '<li>' . html::a(getHomeRoot(), $app->lang->homePage) . '</li>';
        foreach($app->site->menuLinks as $menu) echo "<li>$menu</li>";
        echo '</ul>';
    }

    /**
     * Print position bar
     *
     * @param   object $module
     * @param   object $object
     * @param   mixed  $misc    other params.
     * @access  public
     * @return  void
     */
    public function printPositionBar($module = '', $object = '', $misc = '', $root = '')
    {
        echo '<ul class="breadcrumb">';
        if($root == '')
        {
            echo '<li>' . "<span class='breadcrumb-title'>" . $this->lang->currentPos . $this->lang->colon . '</span>' . html::a(getHomeRoot(), $this->lang->home) . '</li>';
        }
        else
        {
            echo $root;
        }

        $moduleName = $this->app->getModuleName();
        $moduleName = $moduleName == 'reply' ? 'thread' : $moduleName;
        $funcName = "print$moduleName";
        if(method_exists('commonModel', $funcName) or method_exists('extcommonModel', $funcName)) echo $this->$funcName($module, $object, $misc);
        echo '</ul>';
    }

    /**
     * Print the link contains orderBy field.
     *
     * This method will auto set the orderby param according the params. For example, if the order by is desc,
     * will be changed to asc.
     *
     * @param  string $fieldName    the field name to sort by
     * @param  string $orderBy      the order by string
     * @param  string $vars         the vars to be passed
     * @param  string $label        the label of the link
     * @param  string $module       the module name
     * @param  string $method       the method name
     * @static
     * @access public
     * @return void
     */
    public static function printOrderLink($fieldName, $orderBy, $vars, $label, $module = '', $method = '')
    {
        global $lang, $app;
        if(empty($module)) $module = $app->getModuleName();
        if(empty($method)) $method = $app->getMethodName();
        $className = 'header';

        if(strpos($orderBy, $fieldName . '_') !== false)
        {
            if(stripos($orderBy, $fieldName . '_desc') !== false)
            {
                $orderBy   = str_ireplace('desc', 'asc', $orderBy);
                $className = 'headerSortUp';
            }
            elseif(stripos($orderBy, $fieldName . '_asc')  !== false)
            {
                $orderBy = str_ireplace('asc', 'desc', $orderBy);
                $className = 'headerSortDown';
            }
        }
        else
        {
            $orderBy   = $fieldName . '_' . 'asc';
            $className = 'header';
        }
        $link = helper::createLink($module, $method, sprintf($vars, $orderBy));
        echo "<div class='$className'>" . html::a($link, $label) . '</div>';
    }

    /**
     * print link;
     *
     * @param  string $module
     * @param  string $method
     * @param  string $vars
     * @param  string $label
     * @param  string $misc
     * @static
     * @access public
     * @return bool
     */
    public static function printLink($module, $method, $vars = '', $label, $misc = '')
    {
        if(!commonModel::hasPriv($module, $method)) return false;
        echo html::a(helper::createLink($module, $method, $vars), $label, $misc);
        return true;
    }

    /**
     * Print the positon bar of product module.
     *
     * @param  object $module
     * @param  object $product
     * @access public
     * @return void
     */
    public function printProduct($module, $product)
    {
        if(empty($module->pathNames))
        {
            echo '<li>' . $module->name . '</li>';
            return '';
        }
        foreach($module->pathNames as $moduleID => $moduleName)
        {
            echo '<li>' . html::a(inlink('browse', "moduleID=$moduleID", "category=" . $this->loadModel('tree')->getAliasByID($moduleID)), $moduleName) . '</li>';
        }
        if($product) echo '<li>' . $product->name . '</li>';
    }

    /**
     * Print the positon bar of score module.
     * 
     * @access public
     * @return void
     */
    public function printScore()
    {
        echo '<li>' . $this->lang->score->common . '</li>';
    }

    /**
     * Print the positon bar of company module.
     *
     * @param  object $module
     * @access public
     * @return void
     */
    public function printcompany($module)
    {
        echo '<li>' . $this->lang->aboutUs . '</li>';
    }

    /**
     * Print the positon bar of links module.
     *
     * @param  object $module
     * @access public
     * @return void
     */
    public function printlinks($module)
    {
        echo '<li>' . $this->lang->link . '</li>';
    }

    /**
     * Print the positon bar of article module.
     *
     * @param  object $module
     * @param  object $article
     * @access public
     * @return void
     */
    public function printArticle($module, $article)
    {
        if(empty($module->pathNames)) return '';

        $divider = $this->lang->divider;
        foreach($module->pathNames as $moduleID => $moduleName)
        {
            echo '<li>' . html::a(inlink('browse', "moduleID=$moduleID", "category=" . $this->loadModel('tree')->getAliasByID($moduleID)), $moduleName) . '</li>';
        }
        if($article) echo '<li>' . $article->title . '</li>';
    }

    /**
     * Print the positon bar of blog module.
     *
     * @param  object $module
     * @param  object $article
     * @access public
     * @return void
     */
    public function printBlog($module, $article)
    {
        if(empty($module->pathNames)) return '';
        $categories = array();
        foreach($this->config->seo->alias->blog as $alias => $category) $categories[$category->id] = $alias;

        $divider = $this->lang->divider;
        foreach($module->pathNames as $moduleID => $moduleName)
        {
            $categoryAlias = zget($categories, $moduleID, '');
            echo '<li>' . html::a(inlink('index', "moduleID=$moduleID", "category=" . $categoryAlias), $moduleName) . '</li>';
        }
        if($article) echo '<li>' . $article->title . '</li>';
    }

    /**
     * Print the position bar of book module.
     *
     * @param   array   $families
     * @access  public
     * @return  void
     */
    public function printBook($origins)
    {
        $link = '<li>' . html::a(helper::createLink('book', 'index'), $this->lang->bookHome) . '</li>';
        $book = current($origins);
        foreach($origins as $node)
        {
            if($node->type == 'book') $link .= '<li>' . html::a(helper::createLink('book', 'browse', "bookID=$node->id", "book=$book->alias"), $node->title) . '</li>';
            if($node->type != 'book') $link .= '<li>' . html::a(helper::createLink('book', 'browse', "nodeID=$node->id", "book=$book->alias&node=$node->alias"), $node->title) . '</li>';
        }
        echo $link;
    }

    /**
     * Print the position bar of forum module.
     *
     * @param   object $board
     * @access  public
     * @return  void
     */
    public function printForum($board = '')
    {
        if($board == 'forum') echo '<li>' . html::a(helper::createLink('forum', 'index'), $this->lang->forumHome) . '</li>';

        if(empty($board->pathNames)) return '';

        $divider = $this->lang->divider;
        echo '<li>' . html::a(helper::createLink('forum', 'index'), $this->lang->forumHome) . '</li>';
        if(!$board) return false;

        $categories = array();
        if(empty($this->config->seo->alias->forum)) $this->config->seo->alias->forum = array();
        foreach($this->config->seo->alias->forum as $alias => $category) $categories[$category->id] = $alias;

        unset($board->pathNames[key($board->pathNames)]);
        foreach($board->pathNames as $boardID => $boardName)
        {
            $categoryAlias = zget($categories, $boardID, '');
            echo '<li>' . html::a(helper::createLink('forum', 'board', "boardID={$boardID}", "category=" . $categoryAlias), $boardName) . '</li>';
        }
    }

    /**
     * Print the position bar of thread module.
     *
     * @param   object $board
     * @param   object $thread
     * @access  public
     * @return  void
     */
    public function printThread($board, $thread = '')
    {
        $this->printForum($board);
        if($thread) echo '<li>' . $thread->title . '</li>';
    }

    /**
     * Print the positon bar of page module.
     *
     * @param  object $page
     * @access public
     * @return void
     */
    public function printPage($page)
    {
        $divider = $this->lang->divider;
        if(!$page) echo '<li>' . $this->lang->page->list . '</li>';
        if($page) echo '<li>' . $page->title . '</li>';
    }

    /**
     * Print the position bar of message module.
     *
     * @access public
     * @return void
     */
    public function printMessage()
    {
        echo '<li>' . $this->lang->message->common . '</li>';
    }

    /**
     * Print the position bar of Search.
     *
     * @param  int    $module
     * @param  int    $object
     * @param  int    $keywords
     * @access public
     * @return void
     */
    public function printSearch($module, $object, $keywords)
    {
        echo "<li> {$this->lang->search->common} </li>" . "<li>{$keywords}</li>";
    }

    /**
     * Create front link for admin MODEL.
     *
     * @param string       $module
     * @param string       $method
     * @param string|array $vars
     * @param string|array $alias
     * return string
     */
    public static function createFrontLink($module, $method, $vars = '', $alias = '', $viewType = '')
    {
        if(RUN_MODE == 'front') return helper::createLink($module, $method, $vars, $alias, $viewType);

        global $config;

        $requestType = $config->requestType;
        $config->requestType = $config->frontRequestType;
        $link = helper::createLink($module, $method, $vars, $alias, $viewType);
        $link = str_replace($_SERVER['SCRIPT_NAME'], $config->webRoot . 'index.php', $link);
        $config->requestType = $requestType;
        if($config->frontRequestType == 'GET') $link .= "&l=" . $config->langCode;

        return $link;
    }

    /**
     * Verify administrator through ok file.
     *
     * @access public
     * @return array
     */
    public function verifyAdmin()
    {
        if(!$this->session->okFileName) $this->session->set('okFileName', helper::createRandomStr(4, $skip = '0-9A-Z') . '.txt');
        $okFile = $this->app->getTmpRoot() . $this->session->okFileName;

        if(file_exists($okFile))
        {
            $fileUpdateTime = filemtime($okFile);
            if(!$this->session->okFileTime) $this->session->set('okFileTime', $fileUpdateTime);

            if(time() - $this->session->okFileTime > 180)
            {
                @unlink($okFile);
                $this->session->set('okFileName', helper::createRandomStr(4, $skip = '0-9A-Z') . '.txt');
                $this->session->set('okFileTime', '');

                $okFile = $this->app->getTmpRoot() . $this->session->okFileName;
            }
            else
            {
                $this->session->set('verify', 'pass');
                return array('result' => 'success');
            }
        }

        if(!file_exists($okFile)) return array('result' => 'fail', 'name' => $okFile);
    }

    /**
     * Create changes of one object.
     * 
     * @param mixed $old    the old object
     * @param mixed $new    the new object
     * @static
     * @access public
     * @return array
     */
    public static function createChanges($old, $new)
    {   
        global $config;
        $changes    = array();
        $magicQuote = get_magic_quotes_gpc();
        foreach($new as $key => $value)
        {   
            if(!isset($old->$key))                   continue;
            if(strtolower($key) == 'last')           continue;
            if(strtolower($key) == 'lastediteddate') continue;
            if(strtolower($key) == 'lasteditedby')   continue;
            if(strtolower($key) == 'assigneddate')   continue;
            if(strtolower($key) == 'editedby')       continue;
            if(strtolower($key) == 'editeddate')     continue;

            if(is_array($value))
            {
                if(is_string(reset($value))) $value = join(',', $value);
                else $value = join(',', array_keys($value)); 
            }
            if(is_array($old->$key)) 
            {
                if(is_string(reset($old->$key))) $old->$key = join(',', $old->$key);
                else $old->$key = join(',', array_keys($old->$key)); 
            }

            if($magicQuote) $value = stripslashes($value);
            if($value != stripslashes($old->$key))
            {
                $diff = '';
                if(substr_count($value, "\n") > 1     or
                   substr_count($old->$key, "\n") > 1 or
                   strpos('name,title,desc,content,summary', strtolower($key)) !== false)
                {
                    $diff = commonModel::diff($old->$key, $value);
                }
                $changes[] = array('field' => $key, 'old' => $old->$key, 'new' => $value, 'diff' => $diff);
            }
        }
        return $changes;
    }

    /**
     * Diff two string. (see phpt)
     *
     * @param string $text1
     * @param string $text2
     * @static
     * @access public
     * @return string
     */
    public static function diff($text1, $text2)
    {
        $text1 = str_replace('&nbsp;', '', trim($text1));
        $text2 = str_replace('&nbsp;', '', trim($text2));
        $w  = explode("\n", $text1);
        $o  = explode("\n", $text2);
        $w1 = array_diff_assoc($w,$o);
        $o1 = array_diff_assoc($o,$w);
        $w2 = array();
        $o2 = array();
        foreach($w1 as $idx => $val) $w2[sprintf("%03d<",$idx)] = sprintf("%03d- ", $idx+1) . "<del>" . trim($val) . "</del>";
        foreach($o1 as $idx => $val) $o2[sprintf("%03d>",$idx)] = sprintf("%03d+ ", $idx+1) . "<ins>" . trim($val) . "</ins>";
        $diff = array_merge($w2, $o2);
        ksort($diff);
        return implode("\n", $diff);
    }

    /**
     * Get the run info.
     *
     * @param mixed $startTime  the start time of this execution
     * @access public
     * @return array    the run info array.
     */
    public function getRunInfo($startTime)
    {
        $info['timeUsed'] = round(getTime() - $startTime, 4) * 1000;
        $info['memory']   = round(memory_get_peak_usage() / 1024, 1);
        $info['querys']   = count(dao::$querys);
        return $info;
    }

    /**
     * Get the full url of the system.
     *
     * @static
     * @access public
     * @return string
     */
    public static function getSysURL()
    {
        global $config;
        $scheme = 'http';
        if(isset($config->site->scheme))
        {
            $scheme = $config->site->scheme;
        }
        else
        {
            $scheme = helper::isHttps() ? 'https' : 'http';
        }
        $httpHost = rtrim($_SERVER['HTTP_HOST'], '/');
        return "$scheme://$httpHost";
    }

    /**
     * Get client IP.
     *
     * @access public
     * @return string
     */
    public function getIP()
    {
        if(getenv("HTTP_CLIENT_IP"))
        {
            $ip = getenv("HTTP_CLIENT_IP");
        }
        elseif(getenv("HTTP_X_FORWARDED_FOR"))
        {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        }
        elseif(getenv("REMOTE_ADDR"))
        {
            $ip = getenv("REMOTE_ADDR");
        }
        else
        {
            $ip = "Unknow";
        }

        return $ip;
    }

    /**
     * Load category and page alias.
     *
     * @access public
     * @return void
     */
    public function loadAlias()
    {
        if(version_compare($this->loadModel('setting')->getVersion(), 1.4) <= 0) return true;
        $categories = $this->dao->select('*, id as category')->from(TABLE_CATEGORY)->where('type')->in('article,video,product,blog,forum,usercase')->fetchGroup('type', 'id');
        $this->config->categories = $categories;
        $this->config->seo->alias->category = array();
        $this->config->seo->alias->blog     = array();
        
        if(!empty($categories['article'] ))
        {
            foreach($categories['article'] as $category) 
            {
                if(empty($category->alias)) continue;
                $categories['article'][$category->alias] = $category;
                $category->alias  = urlencode($category->alias);
                $category->module = 'article';
                $this->config->seo->alias->category[$category->alias] = $category;
            }
        }
        
        if(!empty($categories['video'] ))
        {
            foreach($categories['video'] as $category) 
            {
                if(empty($category->alias)) continue;
                $category->alias  = urlencode($category->alias);
                $category->module = 'video';
                $categories['video'][$category->alias] = $category;
                $this->config->seo->alias->category[$category->alias] = $category;
            }
        }

        if(!empty($categories['usercase'] ))
        {
            foreach($categories['usercase'] as $category) 
            {
                if(empty($category->alias)) continue;
                $category->alias  = urlencode($category->alias);
                $category->module = 'usercase';
                $categories['usercase'][$category->alias] = $category;
                $this->config->seo->alias->usercase[$category->alias] = $category;
            }
        }

        if(!empty($categories['product'] ))
        {
            foreach($categories['product'] as $category) 
            {
                if(empty($category->alias)) continue;
                $category->alias  = urlencode($category->alias);
                $category->module = 'product';
                $categories['product'][$category->alias] = $category;
                $this->config->seo->alias->category[$category->alias] = $category;
            }
        }

        if(!empty($categories['blog']))
        {
            foreach($categories['blog'] as $category) 
            {
                if(empty($category->alias)) continue;
                $category->alias  = urlencode($category->alias);
                $category->module = 'blog';
                $categories['blog'][$category->alias] = $category;
                $this->config->seo->alias->blog[$category->alias] = $category;
            }
        }

        if(!empty($categories['forum'] ))
        {
            foreach($categories['forum'] as $category) 
            {
                if(empty($category->alias)) continue;
                $category->alias  = urlencode($category->alias);
                $category->module = 'forum';
                $categories['forum'][$category->alias] = $category;
                $this->config->seo->alias->forum[$category->alias] = $category;
            }
        }
    
        $this->config->categoryAlias = array();
        foreach($this->config->seo->alias->category as $alias => $category) $this->config->categoryAlias[$category->category] = $alias;
    }

    /**
     * Fix link of menu groups.
     * 
     * @static
     * @access public
     * @return bool
     */
    public static function fixGroups()
    {
        global $app, $config, $lang;

        foreach($lang->groups as $menuGroup => $groupSetting)
        {
            $groupMenus = explode(',', $config->menus->$menuGroup);
      
            $showGroup = $menuGroup == 'design' ? true : false;
            foreach($groupMenus as $groupMenu)
            {
                if($showGroup) continue;
                if(!isset($lang->menu->$groupMenu)) continue;
                list($title, $module, $method, $params) = explode('|', $lang->menu->$groupMenu);
                if(commonModel::isAvailable($groupMenu) and commonModel::hasPriv($module, $method))
                {
                    $showGroup = true;
                    $lang->groups->{$menuGroup}['link'] = substr($lang->menu->$groupMenu, strpos($lang->menu->$groupMenu, '|') + 1);
                }
                if(!commonModel::isAvailable($groupMenu)) unset($lang->menu->$groupMenu);
                continue;
            }
            if(!$showGroup) unset($lang->groups->$menuGroup);
        }
        
        $modules = $config->site->modules;
        if(strpos($modules, 'article') === false)
        {
            if(strpos($modules, 'book')  !== false) $lang->groups->content['link'] = 'book|admin|';
            if(strpos($modules, 'video') !== false) $lang->groups->content['link'] = 'article|admin|type=video';
            if(strpos($modules, 'blog')  !== false) $lang->groups->content['link'] = 'article|admin|type=blog';
            if(strpos($modules, 'page')  !== false) $lang->groups->content['link'] = 'article|admin|type=page';
        }

        if((strpos($modules, 'shop') === false and strpos($modules, 'score') === false) or strpos($modules, 'user') === false)
        {
            if(strpos($modules, 'product') !== false) $lang->groups->shop['link'] = 'product|admin|';
        }
  
        if(strpos($modules, 'stat') === false) $lang->groups->promote['link'] = 'tag|admin|';

        if(strpos($modules, 'form') === false) unset($lang->groups->form);
        return true;
    }

    /**
     * Get current template.
     * 
     * @access public
     * @return string
     */
    public function getCurrentTemplate()
    {
        return $this->config->template->{$this->app->clientDevice}->name;
    }

    /**
     * Get current theme 
     * 
     * @access public
     * @return string
     */
    public function getCurrentTheme()
    {
        return $this->config->template->{$this->app->clientDevice}->theme;
    }

    /**
     * Parse the item id
     *
     * @param  string    $moduleName 
     * @param  string    $methodName 
     * @static
     * @access public
     * @return void
     */
    public static function parseItemID($moduleName, $methodName)
    {
        global $app;
        $isGetRequest = $app->config->requestType == 'GET' ? true : false;
        $params       = $app->getParams();
        
        $uri = $app->URI;
        $id  = '0'; 

        if($moduleName == 'article' and $methodName == 'view')
        {
            if($isGetRequest)
            {
                if(isset($_GET['articleID'])) $id = $_GET['articleID'];
                if(isset($_GET['id']))        $id = $_GET['id'];
                if(empty($id) and $params)    $id = $params['articleID'];
            }
            else
            {
                $id = str_replace('article-view-', '', $uri); 
            }
        }
        
        if($moduleName == 'product' and $methodName == 'view')
        {
            if($isGetRequest)
            {
                if(isset($_GET['productID'])) $id = $_GET['productID'];
                if(isset($_GET['id']))        $id = $_GET['id'];
                if(empty($id) and $params)    $id = $params['productID'];
            }
            else
            {
                $id = str_replace('product-view-', '', $uri); 
            }
        }
        
        if($moduleName == 'blog' and $methodName == 'view')
        {
            if($isGetRequest)
            {
                if(isset($_GET['articleID'])) $id = $_GET['articleID'];
                if(isset($_GET['id']))        $id = $_GET['id'];
                if(empty($id) and $params)    $id = $params['articleID'];
            }
            else
            {
                $id = str_replace('blog-view-', '', $uri); 
            }
        }
        
        if($moduleName == 'book' and $methodName == 'read')
        {
            if($isGetRequest)
            {
                if(isset($_GET['articleID'])) $id = $_GET['articleID'];
                if(empty($id) and $params)    $id = $params['articleID'];
            }
            else
            {
                $id = str_replace('book-read-', '', $uri); 
            }
        }
        
        if($moduleName == 'page' and $methodName == 'view')
        {
            if($isGetRequest)
            {
                if(isset($_GET['pageID'])) $id = $_GET['pageID'];
                if(isset($_GET['id']))     $id = $_GET['id'];
                if(empty($id) and $params) $id = $params['pageID'];
            }
            else
            {
                $id = str_replace('page-view-', '', $uri); 
            }
        }

        $id = str_replace('.', '-', $id);
        return $id;
    }

    /**
     * Process before load cache.
     * 
     * @param  string    $moduleName 
     * @param  string    $methodName 
     * @static
     * @access public
     * @return void
     */
    public static function processPre($moduleName, $methodName)
    {
        global $app;
        $id = self::parseItemID($moduleName, $methodName);

        if($moduleName == 'article' and $methodName == 'view')
        {
            $app->loadClass('dao')->update(TABLE_ARTICLE)->set("views = views + 1")->where('id')->eq($id)->exec();
        }

        if($moduleName == 'product' and $methodName == 'view')
        {
            $app->loadClass('dao')->update(TABLE_PRODUCT)->set("views = views + 1")->where('id')->eq($id)->exec();
        }

        if($moduleName == 'blog' and $methodName == 'view')
        {
            $app->loadClass('dao')->update(TABLE_ARTICLE)->set("views = views + 1")->where('id')->eq($id)->exec();
        }

        if($moduleName == 'book' and $methodName == 'read')
        {
            $app->loadClass('dao')->update(TABLE_BOOK)->set("views = views + 1")->where('id')->eq($id)->exec();
        }

        if($moduleName == 'page' and $methodName == 'view')
        {
            if(is_numeric($id)) $app->loadClass('dao')->update(TABLE_ARTICLE)->set("views = views + 1")->where('id')->eq($id)->exec();
            if(!is_numeric($id)) $app->loadClass('dao')->update(TABLE_ARTICLE)->set("views = views + 1")->where('alias')->eq($id)->exec();
        }
        
        dao::$changedTables = array();
    }

    /*
     * Get the views data according to param from databaes;
     *
     * @access public
     * @param  string $moduleName
     * @param  string $methodName
     * @param  array|string $viewsIDList
     * @static
     * @return string
     */
    public static function getViews($moduleName, $methodName, $viewsIDList)
    {
        global $app;
        
        if(is_array($viewsIDList))
        {
            if(empty($viewsIDList)) return array();

            $viewsList = array();
            if($moduleName == 'article' and $methodName == 'browse')
            {
                $viewsList = $app->loadClass('dao')->select('id, views')->from(TABLE_ARTICLE)->where('id')->in($viewsIDList)->fetchPairs();
            }
            if($moduleName == 'blog' and $methodName == 'index')
            {
                $viewsList = $app->loadClass('dao')->select('id, views')->from(TABLE_ARTICLE)->where('id')->in($viewsIDList)->fetchPairs();
            }
            if($moduleName == 'product' and $methodName == 'browse')
            {
                $viewsList = $app->loadClass('dao')->select('id, views')->from(TABLE_PRODUCT)->where('id')->in($viewsIDList)->fetchPairs();
            }
            return $viewsList;
        }
        else
        {
            $id = $viewsIDList;

            if($moduleName == 'article' and $methodName == 'view')
            {
                $views = $app->loadClass('dao')->select('views')->from(TABLE_ARTICLE)->where('id')->eq($id)->fetch()->views;
            }
            
            if($moduleName == 'blog' and $methodName == 'view')
            {
                $views = $app->loadClass('dao')->select('views')->from(TABLE_ARTICLE)->where('id')->eq($id)->fetch()->views;
            }
            
            if($moduleName == 'book' and $methodName == 'read')
            {
                $views = $app->loadClass('dao')->select('views')->from(TABLE_BOOK)->where('id')->eq($id)->fetch()->views;
            }

            $views = is_numeric($views) ? $views : '0';
            return $views;
        }
    }

    /**
     * Print powerdBy.
     * 
     * @static
     * @access public
     * @return void
     */
    public static function printPowerdBy()
    {
        global $config, $lang, $app;
        $chanzhiVersion = $config->version;
        $isProVersion   = strpos($chanzhiVersion, 'pro') !== false;
        if($isProVersion) $chanzhiVersion = str_replace('pro', '', $chanzhiVersion);

        $icon = 'icon-chanzhi';
        if($isProVersion) $icon = 'icon-chanzhi-pro';
        if($app->clientLang == 'en') $icon = 'icon-zsite';
        if($app->clientLang == 'en' && $isProVersion) $icon = 'icon-zsite-pro';
        printf($lang->poweredBy, $config->version, k(), "<span class='" . $icon . "'></span> <span class='name'>" . $lang->chanzhiEPSx . '</span>' . $chanzhiVersion);
    }

    /**
     * Check cache need cache or not.
     * 
     * @static
     * @access public
     * @return bool
     */
    public static function needClearCache()
    {
        global $app, $config;

        /* The field stickTime of TABLE_ARTICLE was added in version 6.7.1. */
        if(version_compare($config->global->version, '6.7.1', '<')) return false;

        $overdueSticks = $app->loadClass('dao')->select('id')->from(TABLE_ARTICLE)->where('stickTime')->lt(helper::now())->andWhere('stickTime')->ne('0000-00-00 00:00:00')->fetchPairs();

        if(!empty($overdueSticks))
        {
            $app->loadClass('dao')->update(TABLE_ARTICLE)
                ->set('sticky')->eq('0')
                ->set('stickTime')->eq('0000-00-00 00:00:00')
                ->where('id')->in($overdueSticks)
                ->exec();

            return true;
        }
        return false;
    }

    /**
     * check has online payment.
     * 
     * @static
     * @access public
     * @return void
     */
    public static function hasOnlinePayment()
    {
        global $config;
        if(!self::isAvailable('shop')) return false;
        if(strpos($config->shop->payment, 'alipay') !== false) return true;
        if(strpos($config->shop->payment, 'wechatpay') !== false) return true;
        return false;
    }

}
