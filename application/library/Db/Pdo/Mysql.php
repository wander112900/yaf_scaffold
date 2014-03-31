<?php

namespace Db\Pdo;

class Mysql extends AbstractPdo {

    protected function _dsn() {
        return "mysql:host=" . $this->_config['host'] . ";port=" . $this->_config['port'] . ";dbname=" . $this->_config['database'];
    }

}
