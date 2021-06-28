<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The control file of admin module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     admin
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
class admin extends control
{
    /**
     * The index page of admin panel, print the sites.
     * 
     * @access public
     * @return void
     */
    public function index()
    {
        $widgets = $this->loadModel('widget')->getWidgetList();

        /* Init widget when vist index first. */
        if(empty($widgets) and empty($this->config->widgetInited))
        {
            if($this->widget->initWidget()) die(js::reload());
        }

        foreach($widgets as $key => $widget)
        {
            $widget->params = json_decode($widget->params);
            if(empty($widget->params)) $widget->params = new stdclass();

            $widget->moreLink = zget($this->config->widget->moreLinkList, $widget->type, '');
        }

        $this->view->ignoreUpgrade = isset($this->config->global->ignoreUpgrade) and $this->config->global->ignoreUpgrade;
        $this->view->checkLocation = $this->loadModel('user')->checkAllowedLocation();
        $this->view->widgets        = $widgets;
        $this->display();
    }

    /**
     * Ignore the upgrade notice.
     *
     * @access public
     * return void
     **/
    public function ignoreUpgrade()
    {
        $result = $this->loadModel('setting')->setItems('system.common.global', array('ignoreUpgrade' => true), 'all');
        if($result) $this->send(array('result' => 'success', 'locate' => inlink('index')));
        $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
    }

    /**
     * Ignore the admin entry warning.
     *
     * @access public
     * return void
     **/
    public function ignore()
    {
        $result = $this->loadModel('setting')->setItems('system.common.global', array('ignoreAdminEntry' => true));
        if($result) $this->send(array('result' => 'success', 'locate' => inlink('index')));
        $this->send(array('result' => 'fail', 'message' => $this->lang->fail));
    }

    /**
     * Switch lang.
     * 
     * @param  string    $lang 
     * @access public
     * @return void
     */
    public function switchLang($lang)
    {
        $this->admin->switchLang($lang);
        $this->locate($this->server->http_referer);
    }

    /**
     * Register chanzhi.
     * 
	 * @access public
	 * @return void
	 */
	public function register()
	{
		$registerInfo = $this->admin->getRegisterInfo();
        $apiConfig    = $this->admin->getApiConfig();
		if($_POST)
		{
			$response = $this->admin->registerByAPI($apiConfig);
            if(isset($response->certifiedEmail)) $this->session->set('certifiedEmail', $response->certifiedEmail);
            if(isset($response->certifiedMobile)) $this->session->set('certifiedMobile', $response->certifiedMobile);
            if($response->result == 'success') 
            {
                $this->admin->setCommunity($response->data->account, $response->data->private, $response->certifiedEmail, $response->certifiedMobile);
                $response->message = $this->lang->admin->community->success;
                $response->locate  = inlink('register');
            }
            $this->send($response);
		}

        $this->lang->menuGroups->admin = 'community';
        $this->view->title             = $this->lang->admin->community->common;
	    $this->view->apiConnected      = !empty($apiConfig);
        $this->view->register          = $registerInfo;

        if(!empty($registerInfo)) $this->view->bindedUser = $this->admin->getUserByApi();

		$this->display();
	}

	/**
	 * Bind chanzhi.
	 * 
	 * @access public
	 * @return void
	 */
	public function bind()
	{
        if($_POST)
        {
            $response = $this->admin->bindByAPI();
            if($response->result == 'success')
            {
                $this->admin->setCommunity($response->data->account, $response->data->private);
                $this->send(array('result' => 'success', 'message' => $this->lang->admin->bind->success, 'locate' => inlink('register')));
            }

            $this->send(array('result' => 'fail', 'message' => $response->message));
        }
        exit;
    }

    /**
     * Api get mobileCode 
     * 
     * @param  int    $mobile 
     * @access public
     * @return void
     */
    public function getMobileCodeByApi($mobile)
    {
        $result = $this->admin->getMobileCodeByApi($mobile);
        $this->send($result);
    }

    /**
     * Aet email code by api.
     * 
     * @param  string    $email 
     * @access public
     * @return void
     */
    public function getEmailCodeByApi($email)
    {
        $result = $this->admin->getEmailCodeByApi($email);
        $this->send($result);
    }
    
    /**
     * Unbind chanzhi account.
     * 
     * @access public
     * @return void
     */
    public function unbind()
    {
        $this->admin->setCommunity('', '');
        $this->locate(inlink('register'));
    }

    /**
     * Get user by api.
     * 
     * @access public
     * @return void
     */
    public function getUserByApi()
    {
        $result = $this->admin->getUserByApi(true);
        $this->locate(inlink('register'));
    }

    /**
     * check mobile 
     * 
     * @param  string $referer 
     * @access public
     * @return void
     */
    public function checkMobile()
    {
        if($_POST)
        {
            $result  =$this->admin->checkMobileByApi();

            if($result->result == 'success')
            {
                $result->message = $lang->user->checkMobileSuccess;
                $result->locate  = inlink('register');
                $this->admin->getUserByApi(true);
            }

            $this->send($result);
        }

        $this->view->title      = $this->lang->user->checkMobile;
        $this->view->user       = $this->admin->getUserByApi();
        $this->view->referer    = $this->referer;
        $this->view->mobileURL  = helper::createLink('user', 'checkEmail', "referer=$referer", '', 'mhtml');
        $this->view->desktopURL = helper::createLink('user', 'checkEmail', "referer=$referer", '', 'html');
        $this->display();
    }

    /**
     * check mobile 
     * 
     * @param  string $referer 
     * @access public
     * @return void
     */
    public function checkEmail()
    {
        if($_POST)
        {
            $result = $this->admin->checkEmailByApi();

            if($result->result == 'success')
            {
                $result->message = $lang->user->checkEmailSuccess;
                $result->locate  = inlink('register');
                $this->admin->getUserByApi(true);
            }

            $this->send($result);
        }

        $this->view->title = $this->lang->user->checkEmail;
        $this->view->user  = $this->admin->getUserByApi();
        $this->display();
    }
}
