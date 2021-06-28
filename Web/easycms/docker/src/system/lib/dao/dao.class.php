<?php
/**
 * ZenTaoPHP的dao和sql类。
 * The dao and sql class file of ZenTaoPHP framework.
 *
 * The author disclaims copyright to this source code.  In place of
 * a legal notice, here is a blessing:
 * 
 *  May you do good and not evil.
 *  May you find forgiveness for yourself and forgive others.
 *  May you share freely, never taking more than you give.
 */

helper::import(dirname(dirname(__FILE__)) . '/base/dao/dao.class.php');
/**
 * DAO类。
 * DAO, data access object.
 *
 * @package framework
 */
class dao extends baseDAO
{
    /**
     * The tables changed.
     *
     * @var array
     * @access public
     */
    static public $changedTables = array();

    /* Execute the sql. It's different with query(), which return the stmt object. But this not.
     *
     * @param  string $sql
     * @access public
     * @return int the modified or deleted records.
     */
    public function exec($sql = '')
    {
        self::$changedTables[] = $this->table;
        parent::exec($sql);
    }
}

/**
 * SQL类。
 * The SQL class.
 *
 * @package framework
 */
class sql extends baseSQL
{
}
