<?php

class Db {

    public static function factory($config) {
        $config += array('masterslave' => false, 'adapter' => 'Pdo_Mysql');

        if ($config['masterslave']) {
            return new Db\Masterslave($config);
        }

        $class = 'Db\\' . $config['adapter'];
        return new $class($config);
    }

}
