<?php
/**
 * Helper类从baseHelper类继承而来，您可以在这个文件中对其进行扩展。
 * This helper class extends from the baseHelper class, and you can
 * extend it by change this helper.class.php file.
 *
 * @package framework
 *
 * The author disclaims copyright to this source code. In place of
 * a legal notice, here is a blessing:
 * 
 *  May you do good and not evil.
 *  May you find forgiveness for yourself and forgive others.
 *  May you share freely, never taking more than you give.
 */
include FRAME_ROOT . '/base/helper.class.php';
class helper extends baseHelper
{
    /**
     * Create a link to a module's method.
     * 
     * This method also mapped in control class to call conveniently.
     * <code>
     * <?php
     * helper::createLink('hello', 'index', 'var1=value1&var2=value2');
     * helper::createLink('hello', 'index', array('var1' => 'value1', 'var2' => 'value2');
     * ?>
     * </code>
     * @param string       $moduleName     module name
     * @param string       $methodName     method name
     * @param string|array $vars           the params passed to the method, can be array('key' => 'value') or key1=value1&key2=value2) or key1=value1&key2=value2
     * @param string|array $alias          the alias  params passed to the method, can be array('key' => 'value') or key1=value1&key2=value2) or key1=value1&key2=value2
     * @param string       $viewType       the view type
     * @static
     * @access public
     * @return string the link string.
     */
    static public function createLink($moduleName, $methodName = 'index', $vars = '', $alias = array(), $viewType = '')
    {
        global $app, $config;
        $clientLang = $app->getClientLang();
        $lang       = $config->langCode;

        if(empty($viewType) and $app->getViewType() == 'wxml')
        {
            $viewType = 'wxml';
            $currentRequestType = $config->requestType;
            $config->requestType = 'GET';
        }

        /* Set viewType is mhtml if visit with mobile.*/
        if(!$viewType and RUN_MODE == 'front' and $app->clientDevice == 'mobile' and $methodName != 'oauthCallback') $viewType = 'mhtml';

        /* Set vars and alias. */
        if(!is_array($vars)) parse_str($vars, $vars);
        if(!is_array($alias)) parse_str($alias, $alias);
        foreach($alias as $key => $value) $alias[$key] = urlencode($value);

        /* Seo modules return directly. */
        if($config->requestType != 'GET' and method_exists('uri', 'create' . $moduleName . $methodName))
        {
            if($config->requestType == 'PATH_INFO2') $config->webRoot = $_SERVER['SCRIPT_NAME'] . '/';
            $link = call_user_func_array('uri::create' . $moduleName . $methodName, array('param'=> $vars, 'alias'=>$alias, 'viewType'=>$viewType));

            /* Add client lang. */
            if($lang and $link) $link = $config->webRoot .  $lang . '/' . substr($link, strlen($config->webRoot));

            if($config->requestType == 'PATH_INFO2') $config->webRoot = getWebRoot();
            if($link) return $link;
        }
        
        /* Set the view type. */
        if(empty($viewType)) $viewType = $app->getViewType();
        if($config->requestType == 'PATH_INFO')  $link = $config->webRoot;
        if($config->requestType == 'PATH_INFO2') $link = $_SERVER['SCRIPT_NAME'] . '/';
        if($config->requestType == 'GET') $link = $_SERVER['SCRIPT_NAME'];
        if($config->requestType != 'GET' and $lang) $link .= "$lang/";

        /* Common method. */
        if($config->requestType != 'GET')
        {
            /* If the method equal the default method defined in the config file and the vars is empty, convert the link. */
            if($methodName == $config->default->method and empty($vars))
            {
                /* If the module also equal the default module, change index-index to index.html. */
                if($moduleName == $config->default->module)
                {
                    $link .= 'index.' . $viewType;
                }
                elseif($viewType == $app->getViewType())
                {
                    $link .= $moduleName . '/';
                }
                else
                {
                    $link .= $moduleName . '.' . $viewType;
                }
            }
            else
            {
                $link .= "$moduleName{$config->requestFix}$methodName";
                foreach($vars as $value) $link .= "{$config->requestFix}$value";
                $link .= '.' . $viewType;
            }
        }
        else
        {
            $link .= "?{$config->moduleVar}=$moduleName&{$config->methodVar}=$methodName";
            if($viewType != 'html') $link .= "&{$config->viewVar}=" . $viewType;
            foreach($vars as $key => $value) $link .= "&$key=$value";
            if($lang and RUN_MODE != 'admin') $link .= "&l=$lang";
            if(isset($currentRequestType)) $config->requestType = $currentRequestType;
        }
        return $link;
    }

    /**
     * Get exec infomation.
     * 
     * @access public
     * @return string
     */
    public static function getExecInfo()
    {
        global $app, $lang;
        list($second, $millisecond) = explode(' ', STARTED_TIME);
        $started = (float) $second + (float) $millisecond;
        list($second, $millisecond) = explode(' ', microtime());
        $ended = (float) $second + (float) $millisecond;

        $execTime = round($ended - $started, 2);
        $memoryUsage = memory_get_peak_usage(true);
        $memoryUsage = number_format(round($memoryUsage / 1024 / 1024, 2), 2);

        $html = "<span style='cursor:pointer;' id='execIcon'><i class='icon icon-dashboard'> </i></span>";
        if($app->clientDevice == 'desktop')
        {
            $html .= sprintf($lang->execInfo, count(dao::$querys), $memoryUsage . 'MB', $execTime);
            $html .= '<script>';
            $html .= "$().ready(function() { $('#execIcon').tooltip({title:$('#execInfoBar').html(), html:true, placement:'right'}); }); ";
            $html .= '</script>';
        }

        if($app->clientDevice == 'mobile')
        {
            $html .= '<script>';
            $html .= "$().ready(function() { ";
            $html .= "$('#execIcon').click(function(){ $('#execInfoBar').toggle();});";
            $html .= "}); ";
            $html .= '</script>';
            $lang->execInfo = str_replace('<br>', '', $lang->execInfo);
            $html .= sprintf($lang->execInfo, count(dao::$querys), $memoryUsage . 'MB', $execTime);
        }

        return $html;
    }

    /**
     * Create random string. 
     * 
     * @param  int    $length 
     * @param  string $skip A-Z|a-z|0-9
     * @static
     * @access public
     * @return void
     */
    public static function createRandomStr($length, $skip = '')
    {
        $str  = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $skip = str_replace('A-Z', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', $skip);
        $skip = str_replace('a-z', 'abcdefghijklmnopqrstuvwxyz', $skip);
        $skip = str_replace('0-9', '0123456789', $skip);
        for($i = 0; $i < strlen($skip); $i++)
        {
            $str = str_replace($skip[$i], '', $str);
        }

        $strlen = strlen($str);
        while($length > strlen($str)) $str .= $str;

        $str = str_shuffle($str); 
        return substr($str,0,$length); 
    }

    /**
     * Decode xss codes.
     * 
     * @param  string    $content
     * @access public
     * @return void
     */
    public static function decodeXSS($content)
    {
        $evils    = array('appendchild(', 'createElement(', 'xss.re', 'onfocus', 'onclick', 'innerHTML', 'replaceChild(', 'html(', 'append(', 'appendTo(', 'prepend(', 'prependTo(', 'after(', 'insertBefore', 'before(', 'Before(', 'replaceWith(');
        $replaces = array('a p p e n d c h i l d (', 'c r e a t e E l e  m e n t (', 'x s s . r e', 'o n f o c u s', 'o n c l i c k', 'i n n e r H T M L', 'r e p l a c e C h i l d (', 'h t m l (', 'a p p e n d (', 'a p p e n d T o (', 'p r e p e n d (', 'p r e p e n d T o (', 'a f t e r (', 'i n s e r t B e f o r e(', 'b e f o r e (', 'B e f o r e (', 'r e p l a c e W i t h (');
        return str_ireplace($replaces, $evils, $content);
    }

    /**
     * Process traffic.
     * 
     * @param  float    $traffic 
     * @access public
     * @return float
     */
    public static function formatKB($traffic)
    {
        return round($traffic / (1024 * 1024), 2) > 1 ? round($traffic / (1024 * 1024), 2) . 'G' : (round($traffic / 1024, 2) > 1 ? round($traffic / 1024, 2) . 'M' : round($traffic, 2) . 'KB');
    }

    /**
     * Hex color to RGB color 
     * 
     * @param  string    $hexColor 
     * @static
     * @access public
     * @return void
     */
    public static function hex2Rgb($hexColor)
    {
        $color = str_replace('#','',$hexColor);
        if (strlen($color) > 3)
        {
            $rgb = array(
                'r'=>hexdec(substr($color,0,2)),
                'g'=>hexdec(substr($color,2,2)),
                'b'=>hexdec(substr($color,4,2))
            );
        }
        else
        {
            $color = str_replace('#','',$hexColor);
            $r = substr($color,0,1). substr($color,0,1);
            $g = substr($color,1,1). substr($color,1,1);
            $b = substr($color,2,1). substr($color,2,1);
            $rgb = array( 
                'r' => hexdec($r),
                'g' => hexdec($g),
                'b' => hexdec($b)
            );
        }
        return $rgb;
    }

    /**
     * Tidy function.
     * 
     * @param  string    $html 
     * @static
     * @access public
     * @return string
     */
    public static function tidy($html)
    {
        $config = array (
            'show-errors' => 0,
            'wrap' => 300,
            'tab-size' => 4,
            'write-back' => false,
            'show-info' => true,
            'quiet' => false,
            'indent' => 2,
            'indent-spaces' => 2,
            'output-html' => true,
            'clean' => false,
            'drop-empty-elements' => false,
            'drop-empty-paras' => false,
            'fix-bad-comments' => false,
            'split' => false,
            'merge-divs' => false,
            'merge-spans' => false
        );

        $html = tidy_parse_string($html, $config, "utf8");
        $html->cleanRepair();
        return $html->value;
    }
}

/**
 * Get home root.
 * 
 * @param  string $langCode 
 * @access public
 * @return string
 */
function getHomeRoot($langCode = '')
{
	global $config, $app;
	$requestType = $config->requestType;
	if(RUN_MODE == 'admin') $config->requestType = zget($config, 'frontRequestType', $config->requestType);

	$langCode = $langCode == '' ? $config->langCode : $langCode;
	$defaultLang = isset($config->defaultLang) ?  $config->defaultLang : $config->default->lang;
	if($langCode == $config->langsShortcuts[$defaultLang])
	{
		$config->requestType = $requestType;
		return $config->webRoot;
	}
	$homeRoot = $config->webRoot;

	if($langCode and $config->requestType == 'PATH_INFO') $homeRoot = $config->webRoot . $langCode; 
	if($langCode and $config->requestType == 'PATH_INFO2') $homeRoot = $config->webRoot . 'index.php/' . "$langCode";
	if($langCode and $config->requestType == 'GET') $homeRoot = $config->webRoot . 'index.php?l=' . "$langCode";
	if($config->requestType != 'GET') $homeRoot = rtrim($homeRoot, '/') . '/';

	$config->requestType = $requestType;
	return $homeRoot;
}

/**
 * Check admin entry. 
 * 
 * @access public
 * @return string
 */
function checkAdminEntry()
{
	if(strpos($_SERVER['PHP_SELF'], '/admin.php') === false) return true; 

	$path  = dirname($_SERVER['SCRIPT_FILENAME']);
	$files = scandir($path);
	$defaultFiles = array('admin.php', 'index.php', 'install.php', 'loader.php', 'upgrade.php');
	foreach($files as $file)
	{
		if(strpos($file, '.php') !== false and !in_array($file, $defaultFiles))
		{
			$contents = file_get_contents($path . '/' . $file);
			if(strpos($contents, "'RUN_MODE', 'admin'") && strpos($_SERVER['PHP_SELF'], '/admin.php') !== false) die(header("location: " . getWebRoot()));
		}
	}
}

/**
 * Format time.
 * 
 * @param  int    $time 
 * @param  string $format 
 * @access public
 * @return void
 */
function formatTime($time, $format = '')
{
    global $lang;
	$time = str_replace('0000-00-00', '', $time);
	$time = str_replace('00:00:00', '', $time);
	if($format == 'publish')
    {
        $pubTime = strtotime($time);
        $pubTimeLen = time() - $pubTime;
        if($pubTimeLen > 86400)
        {
            return substr($time, 0, 10);
        }
        else
        {
            $minute = floor($pubTimeLen / 60);
            $hour = floor($pubTimeLen / 3600);
            if($hour == 0)
            {
                return $minute == 1 ? $lang->date->oneMinuteAgo : $minute . $lang->date->minutesAgo;
            }
            else
            {
                return $hour == 1 ? $lang->date->oneHourAgo : $hour . $lang->date->hoursAgo;
            }
        }
    }
    elseif($format)
    {
        return date($format, strtotime($time));
    }
	return trim($time);
}

/**
 * Get file mime type.
 * 
 * @param  int    $file 
 * @access public
 * @return void
 */
function getFileMimeType($file)
{
	if(function_exists('mime_content_type')) return mime_content_type($file);
	if(function_exists('finfo_open'))
	{
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		return finfo_file($finfo, $file); 
	}
	return false;
}

/**
 * Key for chanzhi.
 * 
 * @access public
 * @return string
 */
function k()
{
	global $app, $lang;

	$codeLen  = strlen($app->siteCode);
	$keywords = explode(';', $lang->k);
	$count    = count($keywords);

	$sum = 0;
	for($i = 0; $i < $codeLen; $i++) $sum += ord($app->siteCode{$i});

	$key = $sum % $count;
	return $keywords[$key];
}

/**
 * Save debug info to file
 *
 * @access public
 * @param  mixed
 * @return bool
 */
function saveInfoToFile($file, $info)
{    
	if(!file_exists($file)) return false;
	if(!is_writable($file)) return false;

	$time = helper::now(); 
	$info = print_r($info);
	file_put_contents($file, $time . "\n");
	file_put_contents($file, $info . "\n", FILE_APPEND);
}

function http_build_url($data)
{
	$url  = isset( $data['scheme'])  ? "{$data['scheme']}://" : '';
	$url .= !empty($data['host'])    ? $data['host'] : '';
	$url .= !empty($data['port'])    ? ":{$data['port']}" : '';
	$url .= $data['path'];
	$url .= empty($data['query'])    ? '' : "?{$data['query']}";
	$url .= empty($data['fragment']) ? '' : "#{$data['fragment']}";
	return $url;
}

/**
 * Set string to entity.
 * 
 * @param  string    $string 
 * @access public
 * @return string
 */
function str2Entity($string)
{
    $str2Entities = array();
    $str2Entities['0'] = '&#x30;';
    $str2Entities['1'] = '&#x31;';
    $str2Entities['2'] = '&#x32;';
    $str2Entities['3'] = '&#x33;';
    $str2Entities['4'] = '&#x34;';
    $str2Entities['5'] = '&#x35;';
    $str2Entities['6'] = '&#x36;';
    $str2Entities['7'] = '&#x37;';
    $str2Entities['8'] = '&#x38;';
    $str2Entities['9'] = '&#x39;';
    $str2Entities['@'] = '&#x40;';

    $entity = '';
    for($i = 0; $i < strlen($string); $i++)
    {
        if(isset($str2Entities[$string{$i}]))
        {
            $entity .= $str2Entities[$string{$i}];
        }
        else
        {
            $entity .= htmlentities($string{$i});
        }
    }

    return $entity;
}
