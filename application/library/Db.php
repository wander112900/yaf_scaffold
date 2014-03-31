<?php
/**
 * Description
 *
 * @file Db.php
 * @date 2014-03-31 15:50:12
 * @author FtMan <gianjason@gmail.com>
 * @copyright (c) 2014 Jason Gian
 */
use \Db;

class Db {

    public static function factory($config) {
        $config += array('masterslave' => false, 'adapter' => 'Pdo_Mysql');

        if ($config['masterslave']) {
            return new \Db\Masterslave($config);
        }

        $class = '\Db\\' . $config['adapter'];
        return new $class($config['params']);
    }

}
/* vim: set ts=4 sw=4 sts=4 tw=100 et: */
