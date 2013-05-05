<?php

class BaseModel {

    /**
     * Db instance
     *
     * @var object
     */
    protected static $_dbInstance = NULL;

    /**
     * Table name, with prefix and main name
     *
     * @var string
     */
    protected $_table;

    /**
     * Primary key
     *
     * @var string
     */
    protected $_pk = 'id';

    /**
     * Error
     *
     * @var mixed string | array
     */
    protected $_error;

    /**
     * Validate rules
     *
     * @var array
     */
    protected $_validate = array();

    const UNKNOWN_ERROR = -9;
    const SYSTEM_ERROR = -8;
    const VALIDATE_ERROR = -7;

    /**
     * Load data
     *
     * @param int $id
     * @return array
     */
    public function load($id, $col = null) {
        is_null($col) && $col = $this->_pk;
        $sql = "select * from {$this->_table} where {$col} = " . (is_int($id) ? $id : "'$id'");

        try {
            $result = $this->db->row($sql);
            return $result;
        } catch (Exception $e) {
            $this->error(array('code' => self::SYSTEM_ERROR, 'msg' => $e->getMessage()));
            return false;
        }
    }

    //todo Cache

    /**
     * Find result
     *
     * @param array $conditions
     * @return array
     */
    public function find($conditions = array()) {
        if (is_string($conditions))
            $conditions = array('where' => $conditions);

        $conditions += array('table' => $this->_table);

        try {
            $result = $this->db->find($conditions);
            return $result;
        } catch (Exception $e) {
            $this->error(array('code' => self::SYSTEM_ERROR, 'msg' => $e->getMessage()));
            return false;
        }
    }

    /**
     * Count result
     *
     * @param string $where
     * @param string $table
     * @return int
     */
    public function count($where, $table = null) {
        if (null == $table)
            $table = $this->_table;

        try {
            $result = $this->db->count($where, $table);
            return $result;
        } catch (Exception $e) {
            $this->error(array('code' => self::SYSTEM_ERROR, 'msg' => $e->getMessage()));
            return false;
        }
    }

    /**
     * Query SQL
     *
     * @param string $sql
     * @return mixed
     */
    public function query($sql) {
        try {
            $result = $this->db->query($sql);
            return $result;
        } catch (Exception $e) {
            $this->error(array('code' => self::SYSTEM_ERROR, 'msg' => $e->getMessage()));
            return false;
        }
    }

    /**
     * Get SQL result
     *
     * @param string $sql
     * @return array
     */
    public function sql($sql) {
        try {
            $result = $this->db->sql($sql);
            return $result;
        } catch (Exception $e) {
            $this->error(array('code' => self::SYSTEM_ERROR, 'msg' => $e->getMessage()));
            return false;
        }
    }

    /**
     * Insert
     *
     * @param array $data
     * @param string $table
     * @return boolean
     */
    public function insert($data, $table = null) {
        if (null == $table)
            $table = $this->_table;

        try {
            $result = $this->db->insert($data, $table);
            return $result;
        } catch (Exception $e) {
            $this->error(array('code' => self::SYSTEM_ERROR, 'msg' => $e->getMessage()));
            return false;
        }
    }

    /**
     * Update
     *
     * @param int $id
     * @param array $data
     * @return boolean
     */
    public function update($id, $data) {
        $where = $this->_pk . '=' . (is_int($id) ? $id : "'$id'");

        try {
            $result = $this->db->update($data, $where, $this->_table);
            return true;
        } catch (Exception $e) {
            $this->error(array('code' => self::SYSTEM_ERROR, 'msg' => $e->getMessage()));
            return false;
        }
    }

    /**
     * Delete
     *
     * @param string $where
     * @param string $table
     * @return boolean
     */
    public function delete($id, $col = null) {
        is_null($col) && $col = $this->_pk;

        $where = $col . '=' . (is_int($id) ? $id : "'$id'");

        try {
            $result = $this->db->delete($where, $this->_table);
            return $result;
        } catch (Exception $e) {
            $this->error(array('code' => self::SYSTEM_ERROR, 'msg' => $e->getMessage()));
            return false;
        }
    }

    /**
     * Escape string
     *
     * @param string $str
     * @return string
     */
    public function escape($str) {
        return $this->db->escape($str);
    }

    /**
     * Connect db from config
     *
     * @return Db
     */
    public function db() {

        if (self::$_dbInstance === NULL) {
            $strInstance = Yaf\Application::app()->getConfig()->get('db.instance');
            self::$_dbInstance = Yaf\Registry::get($strInstance);
        }

        return self::$_dbInstance;
    }

    /**
     * Set table Name
     *
     * @param string $table
     */
    public function table($table = null) {
        if (!is_null($table)) {
            $this->_table = $table;
            return $this;
        }

        return $this->_table;
    }

    /**
     * Get or set error
     *
     * @param mixed $error string|array
     * @return mixed $error string|array
     */
    public function error($error = null) {
        if (!is_null($error)) {
            $this->_error = $error;
        }

        return $this->_error;
    }

    /**
     * Validate
     *
     * @param array $data
     * @param boolean $ignoreNotExists
     * @param array $rules
     * @return boolean
     */
    public function validate($data, $ignoreNotExists = false, $rules = null) {

        if (is_null($rules))
            $rules = $this->_validate;
        $result = $this->validate->check($data, $rules, $ignoreNotExists);

        if (!$result) {
            $this->_error = array('code' => self::VALIDATE_ERROR, 'msg' => $this->validate->error());
        }

        return $result;
    }

    /**
     * Dynamic set vars
     *
     * @param string $key
     * @param mixed $value
     */
    public function __set($key, $value = null) {
        $this->$key = $value;
    }

    /**
     * Dynamic get vars
     *
     * @param string $key
     */
    public function __get($key) {
        switch ($key) {
            case 'db' :
                return $this->db = $this->db();
            case 'validate':
                return $this->validate = new Validate();
            default:
                throw new Exception('Undefined property: ' . get_class($this) . '::' . $key);
        }
    }

}
