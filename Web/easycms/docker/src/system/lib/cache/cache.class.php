<?php
/**
 * Cache class.
 * 
 * @copyright Copyright 2009-2016 QingDao Nature Easy Soft Network Technology Co,LTD (www.cnezsoft.com)
 * @author    Xiying Guan <guanxiying@xirangit.com>
 * @package   
 * @license   ZPL
 * @version   $Id$
 * @Link      http://www.chanzhi.org
 */
class cache
{
    /**
     * array instance.
     */
    public static $instance;

    /**
     * config object.
     */
    public $config;

    /**
     * expired time.
     */ 
    public $expired = 86400;

    /**
     * Factory function.
     * 
     * @param  string    $cacher 
     * @param  object    $config 
     * @static
     * @access public
     * @return object
     */
    public static function factory($cacher, $config)
    {
        if(empty(self::$instance)) self::$instance = array(); 
        if(isset(self::$instance[$cacher])) return self::$instance[$cacher];

        $className = $cacher . 'Cache';
        $classFile = dirname(__FILE__) . DS . $cacher . '.class.php';
        if(!is_file($classFile)) return trigger_error("thie class file {$classFile} not found");

        include $classFile;

        self::$instance[$cacher] = new $className($cacher, $config);

        return self::$instance[$cacher];
    }

    /**
     * __construct function
     * 
     * @param  string    $cacher 
     * @param  object    $config 
     * @access public
     * @return void
     */
    public function __construct($cacher, $config)
    {
        $this->cacher = $cacher;
        $this->setConfig($config);
    }

    /**
     * Set config function.
     * 
     * @param  object    $config 
     * @access public
     * @return void
     */
    public function setConfig($config)
    {
        $this->config = $config;
        if(isset($config->expired)) $this->expired = $config->expired;
    }

    /**
     * Set function.
     * 
     * @param  string    $key 
     * @param  mix       $value 
     * @access public
     * @return void
     */
    public function set($key, $value)
    {
    }

    /**
     * The get function.
     * 
     * @param  string    $key 
     * @access public
     * @return void
     */
    public function get($key)
    {
    }

    /**
     * Get cached keys.
     * 
     * @param string $patten 
     * @access public
     * @return array
     */
    public function getKeys($patten)
    {
    }

    /**
     * clear items by key.
     * 
     * @param  string    $key 
     * @access public
     * @return void
     */
    public function clear($key)
    {
    }
}
