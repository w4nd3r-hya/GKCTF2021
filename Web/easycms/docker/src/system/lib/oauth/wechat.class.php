<?php
/**
 * The wechat client class for OAuth.
 * 
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @author      chunsheng wang <chunsheng@cnezsoft.com> 
 * @package     OAuth
 * @license     商业软件非免费软件
 * @version     $Id$
 * @Link        http://www.chanzhi.org
 */
class wechat extends OAuth
{
    /**
     * The authorize api.
     * 
     * @var string
     * @access public
     */
    public $authorizeAPI = 'https://open.weixin.qq.com/connect/qrconnect?';

    /**
     * The authorize scope.
     * 
     * @var string
     * @access public
     */
    public $authorizeScope = 'snsapi_login';

    /**
     * The token api.
     * 
     * @var string
     * @access public
     */
    public $tokenAPI ='https://api.weixin.qq.com/sns/oauth2/access_token?';

    /**
     * The user info api.
     * 
     * @var string
     * @access public
     */
    public $userInfoAPI = 'https://api.weixin.qq.com/sns/userinfo?';

    /**
     * The Open ID.
     * 
     * @var string
     * @access public
     */
    private $openID = '';

    /**
     * Create the api of authorize.
     * 
     * @access public
     * @return string
     */
    public function createAuthorizeAPI()
    {
        $params['appid']         = $this->clientID;
        $params['redirect_uri']  = $this->redirectURI;
        $params['scope']         = $this->authorizeScope;
        $params['response_type'] = 'code';
        $params['state']         = $this->state . '#wechat_redirect';

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
        $data = $this->get($this->createTokenAPI($code));
        $tokens = json_decode($data);
        $this->openID = $tokens->openid;
        return $tokens->access_token;
    }

    /**
     * Create the api of token.
     * 
     * @param  string   $code 
     * @access public
     * @return string
     */
    public function createTokenAPI($code)
    {
        $params['grant_type']    = 'authorization_code';
        $params['appid']         = $this->clientID;
        $params['secret']        = $this->clientSecret;
        $params['redirect_uri']  = $this->redirectURI;
        $params['code']          = $code;

        return $this->tokenAPI . http_build_query($params);
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
        return $this->openID;
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
        $params['oauth_consumer_key'] = $this->clientID;
        $params['access_token']       = $token;
        $params['openid']             = $openID;
        $params['format']             = 'json';

        return $this->userInfoAPI . http_build_query($params);
    }
}
