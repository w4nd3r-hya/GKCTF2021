<?php
class wechatPay
{
    const TRADETYPE_JSAPI  = 'JSAPI', TRADETYPE_NATIVE = 'NATIVE', TRADETYPE_APP = 'APP', TRADETYPE_WAP = 'MWEB';
    const URL_UNIFIEDORDER = "https://api.mch.weixin.qq.com/pay/unifiedorder";
    const URL_ORDERQUERY   = "https://api.mch.weixin.qq.com/pay/orderquery";
    const URL_CLOSEORDER   = 'https://api.mch.weixin.qq.com/pay/closeorder';
    const URL_REFUND       = 'https://api.mch.weixin.qq.com/secapi/pay/refund';
    const URL_REFUNDQUERY  = 'https://api.mch.weixin.qq.com/pay/refundquery';
    const URL_DOWNLOADBILL = 'https://api.mch.weixin.qq.com/pay/downloadbill';
    const URL_REPORT       = 'https://api.mch.weixin.qq.com/payitil/report';
    const URL_SHORTURL     = 'https://api.mch.weixin.qq.com/tools/shorturl';
    const URL_MICROPAY     = 'https://api.mch.weixin.qq.com/pay/micropay';

    /**
     * Error info.
     * 
     * @var string
     * @access public
     */
    public $error = null;

    /**
     * Error xml.
     * 
     * @var xml   
     * @access public
     */
    public $errorXML = null;

    /**
     * Main config of wechat pay.
     * appid        appid
     * mch_id       merchant ID
     * apikey       api key
     * appsecret    app secret
     * sslcertPath  apiclient_cert.pem path
     * sslkeyPath   apiclient_key.pem path
     */
    private $_config;

    /**
     * The construct function.
     * 
     * @param  object  $config 
     * @access public
     * @return void
     */
    public function __construct($config)
    {
        $this->_config = $config;
    }

    /**
     * Get authURL.
     * 
     * @param  string  $redirectURL 
     * @access public
     * @return string
     */
    public function getAuthURL($redirectURL)
    {
        $appid = $this->_config['appid'];
        $redirectURL = urlencode($redirectURL);

        /* scope = snsapi_base. User need pay attention to public, so must use snsapi_userinfo */
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirectURL&response_type=code&scope=snsapi_userinfo&state=123#wechat_redirect";
    }

    /**
     * Get user info from wechat api.
     * 
     * @param  int    $code 
     * @access public
     * @return void
     */
    public function getUserInfo($code)
    {
        $appid     = $this->_config['appid'];
        $appsecret = $this->_config['appsecret'];
        $url       = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$appsecret&code=$code&grant_type=authorization_code";
        $data      = file_get_contents($url);
        $data      = json_decode($data);
        $openID    = $data->openid;
        $token     = $data->access_token;
        $data      = file_get_contents("https://api.weixin.qq.com/sns/userinfo?access_token=$token&openid=$openID");
                                        
        return json_decode($data);
    }

    /**
     * Get wap pay url.
     * 
     * @param  int    $body 
     * @param  int    $out_trade_no 
     * @param  int    $total_fee 
     * @param  int    $product_id 
     * @access public
     * @return void|string
     */
    public function getWAPPayUrl($body, $out_trade_no, $total_fee, $product_id)
    {
        $data = array();
        $data['nonce_str']        = $this->get_nonce_string();
        $data['body']             = $body;
        $data['out_trade_no']     = $out_trade_no;
        $data['total_fee']        = $total_fee;
        $data['notify_url']       = $this->_config["notify_url"];
        $data['trade_type']       = self::TRADETYPE_WAP;
        $data['product_id']       = $product_id;
        $data['spbill_create_ip'] = $_SERVER["SERVER_ADDR"];

        $result = $this->unifiedOrder($data);

        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS')
        {
            $params = array();
            $params['appid']     = $this->_config['appid'];
            $params['timeStamp'] = time();
            $params['nonceStr']  = $this->get_nonce_string();
            $params['package']   = 'prepay_id=' . $result['prepay_id'];
            $params['sign']      = $this->sign($params);

            return 'weixin://wap/pay?' . urlencode(http_build_query($params));
        }
        else 
        {
            $this->error = $result['return_code'] == 'SUCCESS' ? $result['err_code_des'] : $result['return_msg'];
            return null;
        }
    }

    /**
     * Get prepay id by JSAPI.
     * 
     * @param  int    $body 
     * @param  int    $out_trade_no 
     * @param  int    $total_fee 
     * @param  int    $openid 
     * @access public
     * @return void
     */
    public function getPrepayId($body, $out_trade_no, $total_fee, $openid)
    {
        $data = array();
        $data['nonce_str']        = $this->get_nonce_string();
        $data['body']             = $body;
        $data['out_trade_no']     = $out_trade_no;
        $data['total_fee']        = $total_fee;
        $data['notify_url']       = $this->_config['notify_url'];
        $data['trade_type']       = self::TRADETYPE_JSAPI;
        $data['openid']           = $openid;
        $data['spbill_create_ip'] = $_SERVER['REMOTE_ADDR'];

        $result = $this->unifiedOrder($data);
        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS')
        {
            return $result['prepay_id'];
        }
        else
        {
            $this->error    = $result['return_code'] == 'SUCCESS' ? $result['err_code_des'] : $result['return_msg'];
            $this->errorXML = $this->array2xml($result);
            return null;
        }
    }

    /**
     * Get nonce string.
     * 
     * @access private
     * @return string
     */
    private function get_nonce_string()
    {
        return substr(str_shuffle('abcdefghijklmnopqrstuvwxyz0123456789'), 0, 32);
    }

    /**
     * Unified order.
     * 
     * @param  array    $params 
     * @access public
     * @return void
     */
    public function unifiedOrder($params)
    {
        $data = array();
        $data['appid']            = $this->_config['appid'];
        $data['mch_id']           = $this->_config['mch_id'];
        $data['device_info']      = (isset($params['device_info']) && trim($params['device_info']) != '') ? $params['device_info'] : null;
        $data['nonce_str']        = $this->get_nonce_string();
        $data['body']             = $params['body'];
        $data['detail']           = isset($params['detail']) ? $params['detail'] : null;
        $data['attach']           = isset($params['attach']) ? $params['attach'] : null;
        $data['out_trade_no']     = isset($params['out_trade_no']) ? $params['out_trade_no'] : null;
        $data['fee_type']         = isset($params['fee_type']) ? $params['fee_type'] : 'CNY';
        $data['total_fee']        = $params['total_fee'];
        $data['spbill_create_ip'] = $params['spbill_create_ip'];
        $data['time_start']       = isset($params['time_start']) ? $params['time_start'] : null;
        $data['time_expire']      = isset($params['time_expire']) ? $params['time_expire'] : null;
        $data['goods_tag']        = isset($params['goods_tag']) ? $params['goods_tag'] : null;
        $data['notify_url']       = $params['notify_url'];
        $data['trade_type']       = $params['trade_type'];
        $data['product_id']       = isset($params['product_id']) ? $params['product_id'] : null;
        $data['openid']           = isset($params['openid']) ? $params['openid'] : null;

        return $this->post(self::URL_UNIFIEDORDER, $data);
    }

    /**
     * Post 
     * 
     * @param  string  $url 
     * @param  array   $data 
     * @param  bool    $cert 
     * @access private
     * @return void
     */
    private function post($url, $data, $cert = false)
    {
        $data['sign'] = $this->sign($data);
        $xml = $this->array2xml($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);

        if($cert == true)
        {
            /* Set cert pem and key pem */
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, $this->_config['sslcertPath']);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, $this->_config['sslkeyPath']);
        }

        return $this->xml2array(curl_exec($ch));
    }

    /**
     * Get sign.
     * 
     * @param  array    $data 
     * @access private
     * @return string
     */
    private function sign($data)
    {
        ksort($data);
        $string1 = '';
        foreach($data as $k => $v)
        {
            if($v && trim($v) != '') $string1 .= "$k=$v&";
        }

        $stringSignTemp = $string1 . 'key=' . $this->_config['apikey'];
        return strtoupper(md5($stringSignTemp));
    }

    /**
     * Parse array to xml.
     * 
     * @param  array    $array 
     * @access private
     * @return string
     */
    private function array2xml($array)
    {
        $xml = '<xml>' . PHP_EOL;
        foreach ($array as $k => $v)
        {
            if($v && trim($v)!='') $xml .= "<$k><![CDATA[$v]]></$k>" . PHP_EOL;
        }
        $xml .= '</xml>';
        return $xml;
    }

    /**
     * Parse xml to array.
     * 
     * @param  string    $xml 
     * @access private
     * @return array
     */
    private function xml2array($xml)
    {
        $array = array();
        $tmp   = null;
        try
        {
            $tmp = (array) simplexml_load_string($xml);
        }
        catch(Exception $e)
        {
        }

        if($tmp && is_array($tmp))
        {
            foreach($tmp as $k => $v)
            {
                $array[$k] = (string) $v;
            }
        }
        return $array;
    }

    /**
     * Get pay qrcode for mode 2.
     * 
     * @param  int    $body 
     * @param  int    $out_trade_no 
     * @param  int    $total_fee 
     * @param  int    $product_id 
     * @access public
     * @return string|null
     */
    public function getCodeUrl($body, $out_trade_no, $total_fee, $product_id)
    {
        $data = array();
        $data['nonce_str']        = $this->get_nonce_string();
        $data['body']             = $body;
        $data['out_trade_no']     = $out_trade_no;
        $data['total_fee']        = $total_fee;
        $data['notify_url']       = $this->_config['notify_url'];
        $data['trade_type']       = self::TRADETYPE_NATIVE;
        $data['product_id']       = $product_id;
        $data['spbill_create_ip'] = $_SERVER['SERVER_ADDR'];

        $result = $this->unifiedOrder($data);

        if ($result['return_code'] == 'SUCCESS' && $result['result_code'] == 'SUCCESS')
        {
            return $result['code_url'];
        }
        else
        {
            $this->error = $result['return_code'] == 'SUCCESS' ? $result['err_code_des'] : $result['return_msg'];
            return null;
        }
    }

    /**
     * Query an order.
     * 
     * @param  int    $transactionID 
     * @param  int    $tradeID 
     * @access public
     * @return void
     */
    public function orderQuery($transactionID, $tradeID)
    {
        $data = array();
        $data['appid']  = $this->_config['appid'];
        $data['mch_id'] = $this->_config['mch_id'];

        if($transactionID)
        {
            $data['transaction_id'] = $transactionID;
        }
        else
        {
            $data['out_trade_no'] = $tradeID;
        }

        $data['nonce_str'] = $this->get_nonce_string();
        return $this->post(self::URL_ORDERQUERY, $data);
    }

    /**
     * Close an order.
     * 
     * @param  int    $tradeID 
     * @access public
     * @return void
     */
    public function closeOrder($tradeID)
    {
        $data = array();
        $data['appid']        = $this->_config['appid'];
        $data['mch_id']       = $this->_config['mch_id'];
        $data['out_trade_no'] = $tradeID;
        $data['nonce_str']    = $this->get_nonce_string();
        return $this->post(self::URL_CLOSEORDER, $data);
    }

    /**
     * Post refund request by merchant trade id.
     * 
     * @param  int    $out_trade_no 
     * @param  int    $out_refund_no 
     * @param  int    $total_fee 
     * @param  int    $refund_fee 
     * @param  int    $op_user_id 
     * @access public
     * @return void
     */
    public function refund($out_trade_no, $out_refund_no, $total_fee, $refund_fee, $op_user_id)
    {
        $data = array();
        $data['appid']         = $this->_config['appid'];
        $data['mch_id']        = $this->_config['mch_id'];
        $data['nonce_str']     = $this->get_nonce_string();
        $data['out_trade_no']  = $out_trade_no;
        $data['out_refund_no'] = $out_refund_no;
        $data['total_fee']     = $total_fee;
        $data['refund_fee']    = $refund_fee;
        $data['op_user_id']    = $op_user_id;

        return $this->post(self::URL_REFUND, $data, true);
    }

    /**
     * Refund by wechat transaction id.
     * 
     * @param  int    $transaction_id 
     * @param  int    $out_refund_no 
     * @param  int    $total_fee 
     * @param  int    $refund_fee 
     * @param  int    $op_user_id 
     * @access public
     * @return void
     */
    public function refundByTransId($transaction_id, $out_refund_no, $total_fee, $refund_fee, $op_user_id)
    {
        $data = array();
        $data['appid']          = $this->_config['appid'];
        $data['mch_id']         = $this->_config['mch_id'];
        $data['nonce_str']      = $this->get_nonce_string();
        $data['transaction_id'] = $transaction_id;
        $data['out_refund_no']  = $out_refund_no;
        $data['total_fee']      = $total_fee;
        $data['refund_fee']     = $refund_fee;
        $data['op_user_id']     = $op_user_id;
        return $this->post(self::URL_REFUND, $data, true);
    }

    /**
     * Download bill.
     * 
     * @param  date    $bill_date 
     * @param  string  $bill_type 
     * @access public
     * @return void
     */
    public function downloadBill($bill_date, $bill_type = 'ALL')
    {
        $data = array();
        $data['appid']     = $this->_config['appid'];
        $data['mch_id']    = $this->_config['mch_id'];
        $data['bill_date'] = $bill_date;
        $data['bill_type'] = $bill_type;
        $data['nonce_str'] = $this->get_nonce_string();
        return $this->post(self::URL_DOWNLOADBILL, $data);
    }

    /**
     * Get the second param for js pay. 
     * 
     * @param  int    $prepay_id 
     * @access public
     * @return void
     */
    public function get_package($prepay_id)
    {
        $data = array();
        $data['appId']     = $this->_config['appid'];
        $data['timeStamp'] = time();
        $data['nonceStr']  = $this->get_nonce_string();
        $data['package']   = "prepay_id=$prepay_id";
        $data['signType']  = 'MD5';
        $data['paySign']   = $this->sign($data);
        return $data;
    }

    /**
     * Get back data.
     * 
     * @access public
     * @return array|void
     */
    public function get_back_data()
    {
        $xml  = file_get_contents('php://input');
        $data = $this->xml2array($xml);

        if($this->validate($data)) return $data;
        return null;
    }

    /**
     * Validate data signature.
     * 
     * @param  array   $data 
     * @access public
     * @return string
     */
    public function validate($data)
    {
        if(!isset($data['sign'])) return false;
        $sign = $data['sign'];
        unset($data['sign']);
        return $this->sign($data) == $sign;
    }

    /**
     * Response in back when wechat pay.
     * 
     * @param  string  $return_code 
     * @param  string  $return_msg 
     * @access public
     * @return xml
     */
    public function response_back($return_code = 'SUCCESS', $return_msg = null)
    {
        $data = array();
        $data['return_code'] = $return_code;
        if($return_msg) $data['return_msg'] = $return_msg;
        $xml = $this->array2xml($data);
        print $xml;
    }

    /**
     * Get js API config.
     * 
     * @param  int    $body 
     * @param  int    $out_trade_no 
     * @param  int    $total_fee 
     * @param  int    $openid 
     * @access public
     * @return void
     */
    public function getJSAPIConfig($body, $out_trade_no, $total_fee, $openid)
    {
        $prepayId  = $this->getPrepayId($body, $out_trade_no, $total_fee, $openid);

        $payConfig = array();
        $payConfig['appId']     = $this->_config['appid'];
        $payConfig['timeStamp'] = (string) time();
        $payConfig['nonceStr']  = $this->get_nonce_string();
        $payConfig['package']   = 'prepay_id=' . $prepayId;
        $payConfig['signType']  = 'MD5';
        $payConfig['paySign']   = $this->sign($payConfig);
        return $payConfig;
    }
}
