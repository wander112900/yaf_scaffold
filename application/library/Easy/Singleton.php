<?php
/**
 * Description
 *
 * @file Singleton.php
 * @date 2014-03-31 14:58:08
 * @author FtMan <gianjason@gmail.com>
 * @copyright (c) 2014 Jason Gian
 */
namespace Easy;

abstract class Singleton {

    protected static $_instance=array();

    /* {{{ public static function getInstance() */
    public static function getInstance() {

        $class = get_called_class();

        if (isset(self::$_instance[$class])) {
            if (self::$_instance[$class] instanceof $class) {
                return self::$_instance[$class];
            }
        }

        $obj = new $class;
        self::$_instance[$class] = $obj;
        return $obj;

    }
    /* }}} */

    /* {{{ protected function __construct() */
    protected function __construct() {
    }
    /* }}} */

}

/* vim: set ts=4 sw=4 sts=4 tw=100 et: */
