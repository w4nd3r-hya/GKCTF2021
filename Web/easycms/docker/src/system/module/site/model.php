<?php if(!defined("RUN_MODE")) die();?>
<?php
/**
 * The model file of site module of chanzhiEPS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPLV1.2 (http://zpl.pub/page/zplv12.html)
 * @author      Xiying Guan <guanxiying@xirangit.com>
 * @package     site
 * @version     $Id$
 * @link        http://www.chanzhi.org
 */
?>
<?php
class siteModel extends model
{
    /**
     * Set the site user visiting.
     *
     * @access public
     * @return void
     */
    public function setSite()
    {
        if(!isset($this->config->site->name))  $this->config->site->name = $this->lang->chanzhiEPS;
    }

    /**
     * Clear cache
     *
     * @access public
     * @param  void
     * @return array
     */
    public function clearCache()
    {
        $clearResult = array('result' => 'success', 'message' => '');
        $tmpRoot = $this->app->getTmpRoot();
        $cacheRoot = $tmpRoot . 'cache/'; 
        if(!$this->deleteDir($cacheRoot, false)) $clearResult = array('result' => 'fail', 'message' => $this->lang->site->failClear);
        return $clearResult;
    }

    /**
     * Delete dir. 
     * 
     * @param  string  $dir 
     * @param  bool    $deleteSelf 
     * @access public
     * @return bool
     */
    function deleteDir($dir, $deleteSelf = true) 
    {
        $dh = opendir($dir);
        while($file = readdir($dh)) 
        {
            if($file != "." && $file != "..") 
            {
                $fullpath = $dir . "/" . $file;
                if(!is_dir($fullpath)) 
                {
                    unlink($fullpath);
                } 
                else 
                {
                    $this->deleteDir($fullpath);
                }
            }
        }
        closedir($dh);

        if(!$deleteSelf) return true; 
        if(rmdir($dir))  return true;           
        return false;
    }

    /**
     * Check gzip.
     * 
     * @access public
     * @return bool
     */
    public function checkGzip()
    {
        $file    = $this->app->wwwRoot . 'readme.html';
        $fileUrl = $this->server->request_scheme . '://' . $this->server->http_host . '/readme.html';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $fileUrl);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_exec($curl); 

        if(!curl_errno($curl))
        {
            $info = curl_getinfo($curl);
            $fileSize = $info['size_download'];

            if($fileSize < filesize($file)) return true;
            return false;
        }

        return false;
    }

    /**
     * Set the site language, request type and detectDevice options.
     *
     * @access public
     * @return void
     */
    public function setSystem($config = null)
    {
        $errors ='';
        if(empty($config)) $config = fixer::input('post')->get();

        $myFile = $this->app->getConfigRoot() . 'my.php';
        if($this->config->framework->multiSite)
        {
            $myFile = $this->app->getConfigRoot() . 'sites' . DS . $this->app->siteCode . '.php';
            if(!file_exists(dirname($myFile))) mkdir(dirname($myFile));
            if(!file_exists($myFile)) fopen($myFile, 'w');
        }

        $rawContent = file_get_contents($myFile);
        if(empty($rawContent)) $rawContent = '<?php ';

        if(isset($config->requestType)) $rawContent = preg_replace('/.*config\->requestType.*\n/', '', $rawContent);
        if(isset($config->detectDevice)) $rawContent = preg_replace("/.*config\->framework\->detectDevice\['" . $this->app->clientLang . "'\].*\n/", '', $rawContent);
        if(isset($config->enabledLangs))
        {
            $rawContent = preg_replace('/.*config\->cn2tw.*\n/', '', $rawContent);
            $rawContent = preg_replace('/.*config\->enabledLangs.*\n/', '', $rawContent);
            $rawContent = preg_replace('/.*config\->defaultLang.*\n/', '', $rawContent);
        }

        $rawContent = str_replace("\n\n", "\n", $rawContent);
        $rawContent = str_replace('?>', '', $rawContent);

        if(!$this->config->framework->multiSite && strpos($rawContent, "config->db->name") === false) return array('result' => 'fail');

        if(is_writable($myFile) !== true)
        {
            $error = sprintf($this->lang->site->fileAuthority, 'chmod o=rwx ' . $myFile);
            return array('result' => 'fail', 'error' => $error);
        }        
        else
        {
            $content = '';

            if(isset($config->enabledLangs))
            {
                $enabledLangs = array();
                foreach($config->enabledLangs as $lang)
                {
                    if(isset($this->config->langs[$lang])) $enabledLangs[] = $lang;
                }
                $content .= '$config->enabledLangs = \'' . join(',', $enabledLangs) . "';\n";
            }

            if(isset($config->cn2tw) and in_array('zh-tw', $enabledLangs))
            {
                if(is_array($config->cn2tw)) $config->cn2tw = $config->cn2tw[0];
                $config->cn2tw = (int) $config->cn2tw;
                $content .= '$config->cn2tw = ' . $config->cn2tw . ";\n";
            }

            if(isset($config->defaultLang) and in_array($config->defaultLang, $enabledLangs))
            {
                $content .= '$config->defaultLang = \'' . $config->defaultLang . "';\n";
            }

            if(isset($config->requestType) and strpos('GET,PATH_INFO,PATH_INFO2', $config->requestType) !== false)
            {
                $content .= '$config->requestType = \'' . $config->requestType. "';\n";
            }
            if(isset($config->detectDevice) and is_bool($config->detectDevice))
            {
                $config->detectDevice = $config->detectDevice ? 'true' : 'false';
                $content .= '$config->framework->detectDevice[' . "'{$this->app->clientLang}'" .  '] = ' . $config->detectDevice . ";\n";
            }

            file_put_contents($myFile, $rawContent . "\n" . $content);
            dao::$changedTables[] = TABLE_CONFIG;
            return array('result' => 'success', 'message' => $this->lang->saveSuccess); 
        }
    }
}
