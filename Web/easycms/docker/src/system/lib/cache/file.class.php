<?php
/**
 * fileCache class.
 * 
 * @copyright Copyright 2009-2010 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @author    xiying Guan <guanxiying@xirangit.com>
 * @package   cache
 * @license   ZPL
 * @version   $Id$
 * @Link      http://www.chanzhi.org
 */
class fileCache extends cache
{
    /**
     *  Header content.
     */
    const PREFIX_CODE = "<?php if(!defined('RUN_MODE')) die();?>";

    /**
     * Set config params.
     * 
     * @param  object    $config 
     * @access public
     * @return void
     */
    public function setConfig($config)
    {
        parent::setConfig($config);

        if(!isset($this->config->savePath))
        {
            global $app, $config;
            $this->config->savePath = $config->framework->multiSite ? $app->getTmpRoot() . 'cache' . DS . $app->siteCode : $app->getTmpRoot() . 'cache';
        }

        if(zget($this->config, 'savePath', '') == '') die('The cache save path must defined in $config');
        if(!is_dir($this->config->savePath)) mkdir($this->config->savePath, 0777, true);
        if(!is_writeable(zget($this->config, 'savePath', ''))) die('The cache save path ' . $this->config->savePath . ' is not writeable.');
        $this->config->savePath = rtrim($this->config->savePath, DS) . DS;
        if(!isset($config->lang) or empty($config->lang)) $config->lang = 'zh-cn';
        $this->config->savePath .= $config->lang . DS;
    }
    
    /**
     * Set a cache item.
     * 
     * @param  string    $key 
     * @param  mix       $value 
     * @access public
     * @return void
     */
    public function set($key, $value)
    {
        if(strpos($key, '..') !== false) return false;
        $value = self::PREFIX_CODE . $value;
        $cacheFile = $this->config->savePath . strtolower($key) . '.' .  zget($this->config, 'cacheExtension', 'php');
        if(!is_dir(dirname($cacheFile))) mkdir(dirname($cacheFile), 0777, true);
        file_put_contents($cacheFile, $value);
    }

    /**
     * Get one item from cache
     * 
     * @param  string    $key 
     * @access public
     * @return string
     */
    public function get($key)
    {
        if(strpos($key, '..') !== false) return false;
        $cacheFile = $this->config->savePath . $key . '.' .  zget($this->config, 'cacheExtension', 'php');
        if(!file_exists($cacheFile)) return false;
        if($this->expired and  (time() - filemtime($cacheFile) > $this->expired)) return false;
        $content = file_get_contents($cacheFile);
        return str_replace(self::PREFIX_CODE, '', $content);
    }
    
    /**
     * Clear cache by key.
     * 
     * @param  string    $key 
     * @access public
     * @return bool
     */
    public function clear($key)
    {
        if(strpos($key, '..') !== false) return false;
        $cacheItems = glob($this->config->savePath . strtolower($key));
        foreach($cacheItems as $cacheItem) 
        {
            if(is_file($cacheItem)) unlink($cacheItem);
            if(is_dir($cacheItem))
            {
                $cacheItemFiles = glob($cacheItem . DS . '*');
                foreach($cacheItemFiles as $cacheItemFile) unlink($cacheItemFile);
            }
        }
    }
}
