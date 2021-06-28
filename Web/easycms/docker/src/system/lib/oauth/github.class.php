<?php
/**
 * The github client class for OAuth.
 * 
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @author      chunsheng wang <chunsheng@cnezsoft.com> 
 * @package     OAuth
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @version     $Id$
 * @Link        http://www.chanzhi.org
 */
class github extends OAuth
{
    /**
     * The authorize api.
     * 
     * @var string
     * @access public
     */
    public $authorizeAPI = 'https://github.com/login/oauth/authorize?';

    /**
     * The authorize scope.
     * 
     * @var string
     * @access public
     */
    public $authorizeScope = 'user user:email';

    /**
     * The token api.
     * 
     * @var string
     * @access public
     */
    public $tokenAPI ='https://github.com/login/oauth/access_token';

    /**
     * The open id api.
     * 
     * @var string
     * @access public
     */
    public $openIdAPI = 'https://api.github.com/user?';

    /**
     * The user info api.
     * 
     * @var string
     * @access public
     */
    public $userInfoAPI = 'https://api.github.com/user?';

    /**
     * Create the api of authorize.
     * 
     * @access public
     * @return string
     */
    public function createAuthorizeAPI()
    {
        $params['response_type'] = 'code';
        $params['client_id']     = $this->clientID;
        $params['redirect_uri']  = $this->redirectURI;
        $params['state']         = $this->state;
        $params['scope']         = $this->authorizeScope;

        return $this->authorizeAPI . http_build_query($params);
    }

    /**
     * Get token data.
     * 
     * @param  string    $code 
     * @access public
     * @return void
     */
    public function getToken($code)
    {
        $params['client_id']     = $this->clientID;
        $params['client_secret'] = $this->clientSecret;
        $params['code']          = $code;
        
        $data = $this->post($this->tokenAPI, $params);
        parse_str($data, $tokens);
        return $tokens['access_token'];
    }

    /**
     * Get the open id.
     * 
     * @param  string    $token 
     * @access public
     * @return string
     */
    public function getOpenID($token)
    {
        $data = $this->get($this->createOpenIDAPI($token));
        $data = json_decode($data);
        return $data->id;
    }

    /**
     * Create the api of openID.
     * 
     * @param  int    $token 
     * @access public
     * @return string
     */
    public function createOpenIDAPI($token = '')
    {
        return $this->openIdAPI . "access_token=$token";
    }

    /**
     * Get user info.
     * 
     * @param  string    $token 
     * @param  string    $openID 
     * @access public
     * @return object
     */
    public function getUserInfo($token, $openID)
    {
        $data = $this->get($this->createUserInfoAPI($token, $openID));
        return json_decode($data);
    }

    /**
     * Create the api of user info.
     * 
     * @param  string    $token 
     * @param  string    $openID 
     * @access public
     * @return string
     */
    public function createUserInfoAPI($token, $openID)
    {
        return $this->userInfoAPI . "access_token=$token";
    }
}
