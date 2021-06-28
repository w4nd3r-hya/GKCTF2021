<?php
/**
 * ZenTaoPHP的验证和过滤类。
 * The validater and fixer class file of ZenTaoPHP framework.
 *
 * The author disclaims copyright to this source code.  In place of
 * a legal notice, here is a blessing:
 * 
 *  May you do good and not evil.
 *  May you find forgiveness for yourself and forgive others.
 *  May you share freely, never taking more than you give.
 */

helper::import(dirname(dirname(__FILE__)) . '/base/filter/filter.class.php');
/**
 * validater类，检查数据是否符合规则。
 * The validater class, checking data by rules.
 * 
 * @package framework
 */
class validater extends baseValidater
{
    /**
     * Filter config placeholder for POST.
     * 
     * @param  array    $post 
     * @static
     * @access public
     * @return array
     */
    public static function filterConfigPlaceholder($post)
    {
        if(empty($post)) return $post;

        global $config;
        $evils = array($config->execPlaceholder, $config->siteNavHolder, $config->viewsPlaceholder, $config->idListPlaceHolder, $config->searchWordPlaceHolder);

        $replaces = array();
        foreach($evils as $i => $evil) $replaces[$i] = strtr($evil, '_', ' ');

        foreach($post as $key => $item)
        {
            if(is_array($item))
            {
                foreach($item as $subkey => $subItem)
                {
                    if(is_array($subItem)) continue;
                    $post[$key][$subkey] = str_replace($evils, $replaces, $subItem);
                }
            }
            else
            {
                $post[$key] = str_replace($evils, $replaces, $item);
            }
        }
        return $post;
    }

    /**
     * Filter super. 
     * 
     * @param  array $super 
     * @static
     * @access public
     * @return array
     */
    public static function filterSuper($super)
    {
        if(!is_array($super)) return $super;
        if(!defined('RUN_MODE') or RUN_MODE != 'admin') return parent::filterSuper($super);

        return self::filterBadKeys($super);
    }
}

/**
 * fixer类，处理数据。
 * fixer class, to fix data types.
 * 
 * @package framework
 */
class fixer extends baseFixer
{
}
