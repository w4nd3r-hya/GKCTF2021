<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of admin module of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     admin
 * @version     $Id: model.php 5148 2013-07-16 01:31:08Z chencongzhi520@gmail.com $
 * @link        http://www.zentao.net
 */
?>
<?php
class adminModel extends model
{
    /**
     * The api agent(use snoopy).
     * 
     * @var object   
     * @access public
     */
    public $agent;

    /**
     * The construct function.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->setAgent();
    }

    /**
     * Set the api agent.
     * 
     * @access public
     * @return void
     */
    public function setAgent()
    {
        $this->agent = $this->app->loadClass('snoopy');
    }

    /**
     * Get api config.
     * 
     * @access public
     * @return void
     */
    public function getApiConfig()
    {
        if(!$this->session->apiConfig)
        {
            $config = file_get_contents($this->config->admin->apiRoot . "?mode=getconfig");    
            $config = json_decode($config);
            if(empty($config) or empty($config->sessionID)) return null;
            $this->session->set('apiConfig', $config);
        }
        return $this->session->apiConfig;
    }

    /**
     * Post data form  API 
     * 
     * @param  string $url 
     * @param  string $formvars 
     * @access public
     * @return void
     */
    public function postAPI($url, $formvars = "")
    {
        $url = $this->config->admin->apiRoot . $url;
		$this->agent->cookies['lang'] = $this->cookie->lang;
    	$this->agent->submit($url, $formvars);
		return $this->agent->results;
    }

    /**
     * Get mobile code by api.
     * 
     * @param  int    $mobile 
     * @access public
     * @return void
     */
    public function getMobileCodeByApi($mobile)
    {
        if(empty($mobile) or !$this->session->apiConfig) return array('result' => 'fail', 'message' => 'fail');
        $community = $this->getRegisterInfo();
		$api = "sms-apiSendCode.json?{$this->session->apiConfig->sessionVar}={$this->session->apiConfig->sessionID}&t=json";
        $response = $this->postApi($api, array('mobile' => $mobile, 'account' => zget($community, 'account')));
        $result   = json_decode($response);
        if(!empty($result)) return $result;
        return array('result' => 'fail', 'message' => $response);
    }

    /**
     * Get email code by api.
     * 
     * @param  string    $email 
     * @access public
     * @return void
     */
    public function getEmailCodeByApi($email)
    {
        if(empty($email) or !$this->session->apiConfig) return array('result' => 'fail', 'message' => 'fail');
		$api = "mail-apiSendCode.json?{$this->session->apiConfig->sessionVar}={$this->session->apiConfig->sessionID}&t=json";
        $community = $this->getRegisterInfo();
        $response = $this->postApi($api, array('email' => $email, 'account' => $community->account));
        $result   = json_decode($response);
        if(!empty($result)) return $result;
        return array('result' => 'fail', 'message' => $response);
    }

	/**
	 * Register zentao by API. 
	 * 
	 * @access public
	 * @return void
	 */
	public function registerByAPI($apiConfig)
	{
        $_POST['bindSite'] = $this->server->http_host;
		$api = "user-apiregister.json?{$apiConfig->sessionVar}={$apiConfig->sessionID}";
        $response = $this->postApi($api, $_POST);
        $result   = json_decode($response);
        if(!empty($result)) return $result;
        return array('result' => 'fail', 'message' => $response);
	}

	/**
	 * Login zentao by API.
	 * 
	 * @access public
	 * @return void
	 */
	public function bindByAPI()
	{
		$api = 'user-bindchanzhi.json';

        $user = array();
        $user['account']  = $this->post->account;
        $user['password'] = $this->post->password ? $this->post->password : $this->post->password1;
        $user['site']     = $this->server->http_host;
	
		$response = $this->postAPI($api, $user);
        $result   = json_decode($response);
        if(empty($result))
        {
            $result = new stdclass();
            $result->result  = 'fail';
            $result->message = $response;
        }
        return $result;
	}

    /**
     * Set community info.
     * 
     * @param  string    $account 
     * @param  string    $private 
     * @access public
     * @return bool
     */
    public function setCommunity($account, $private, $email = '', $mobile = '')
    {
        $this->loadModel('setting')->setItem('system.common.community.account', $account);
        $this->loadModel('setting')->setItem('system.common.community.private', $private);
        $this->loadModel('setting')->setItem('system.common.community.email',   $email);
        $this->loadModel('setting')->setItem('system.common.community.mobile',  $mobile);
        return true;
    }

    /**
     * Get user by api.
     * 
     * @access public
     * @return object
     */
    public function getUserByApi($sync = false)
    {
        if(!$this->getRegisterInfo()) return null;
        if(!$sync and isset($this->config->community->user)) 
        {
            $user = json_decode($this->config->community->user);
            if(!empty($user)) return $user;
        }

        $apiConfig = $this->getApiConfig();
        $api = 'user-apigetuser.json';
        $response = $this->getByApi($api);
        $result   = json_decode($response);
        if(empty($result)) return null;

        if($result->result == 'success')
        {
            $user = $result->user;
            $this->loadModel('setting')->setItem('system.common.community.user', helper::jsonEncode($user));
            return $user;
        }

        return null;
    }

	/**
	 * Get register information. 
	 * 
	 * @access public
	 * @return object
	 */
	public function getRegisterInfo()
    {
        if(!isset($this->config->community->account) or !isset($this->config->community->private)) return false;
        if($this->config->community->account and $this->config->community->private) return $this->config->community;
        return false;
	}

    /**
     * Get by api.
     * 
     * @param  int    $api 
     * @access public
     * @return void
     */
    public function getByApi($api)
    {
        $api = $this->processApi($api);
        if(!$api) return false;

        return file_get_contents($this->config->admin->apiRoot . $api);
    }

    /**
     * Process api url. 
     * 
     * @param  string    $api 
     * @access public
     * @return void
     */
    public function processApi($api)
    {
        $config = $this->getRegisterInfo();
        if(empty($config)) return false;

        $pathInfo = parse_url($api);

        if(!isset($pathInfo['query']))
        {
           $params = array();
        }
        else
        {
            parse_str($pathInfo['query'], $params);
        }
        
        if(!isset($params['site'])) $params['site'] = $this->server->http_host;
        if(!isset($params['time'])) $params['time'] = time();

        if(isset($params['u'])) unset($params['u']);
        $key = md5(http_build_query($params) . md5($config->private));
        $params['u'] = $config->account;
        $params['k'] = $key;
        $pathInfo['query'] = http_build_query($params);
        $api = http_build_url($pathInfo);
        return $api;
    }

    /**
     * Check mobile by api.
     * 
     * @access public
     * @return array
     */
    public function checkMobileByApi()
    {
        $registerInfo = $this->getRegisterInfo();
        $apiConfig    = $this->getApiConfig();
        if(!$registerInfo or empty($apiConfig)) return array('result' => 'fail');

		$api      = "sms-apiCertify.json?{$this->session->apiConfig->sessionVar}={$this->session->apiConfig->sessionID}&t=json";
        $api      = $this->processApi($api);
		$response = $this->postAPI($api, array('mobile' => $this->post->mobile, 'account' => $registerInfo->account, 'captcha' => $this->post->captcha));
        $result   = json_decode($response);

        if(empty($result))
        {
            $result = new stdclass();
            $result->result  = 'fail';
            $result->message = $response;
        }
        return $result;
    }

    /**
     * Check mobile by api.
     * 
     * @access public
     * @return array
     */
    public function checkEmailByApi()
    {
        $registerInfo = $this->getRegisterInfo();
        $apiConfig    = $this->getApiConfig();
        if(!$registerInfo or empty($apiConfig)) return array('result' => 'fail');

		$api      = "mail-apiCertify.json?{$this->session->apiConfig->sessionVar}={$this->session->apiConfig->sessionID}&t=json";
        $api      = $this->processApi($api);
		$response = $this->postAPI($api, array('email' => $this->post->email, 'account' => $registerInfo->account, 'captcha' => $this->post->captcha));
        $result   = json_decode($response);

        if(empty($result))
        {
            $result = new stdclass();
            $result->result  = 'fail';
            $result->message = $response;
        }
        return $result;
    }

    /**
     * Switch lang of admin.
     * 
     * @param  int    $lang 
     * @access public
     * @return void
     */
    public function switchLang($lang)
    {
        $langCookieVar = RUN_MODE . 'Lang';
        setcookie($langCookieVar, $lang, $this->config->cookieLife, $this->config->cookiePath, '', false, true);

        $user = $this->app->user;
        $user->rights = $this->loadModel('user')->authorize($user);
        $this->session->set('user', $user);
        $this->app->user = $this->session->user;
        return true;
    }
}
