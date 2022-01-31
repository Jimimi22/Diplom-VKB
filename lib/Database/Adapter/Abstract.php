<?php
require_once '../lib/Config.php';

abstract class DatabaseAdapterAbstract {
    private $_config;
    
    public function __construct(Config $config) {
        $this->setConfig($config);
    }
    
    public function setConfig(Config $config) {
        $this->_config = $config;
    }
    
    public function getCongif() {
        return $this->_config;
    }    
    
    public abstract function getConnection();
    
    public abstract function query($sql);
        
    public abstract function save($table, array $values, $id = null);
    
    public abstract function load($table, $id);
    public abstract function insert($table, array $values);
    public abstract function replace($table, array $values);
    public abstract function update($table, array $values, $id);
    public abstract function remove($table, $id);
    
    public abstract function fetchAll($statement);
    public abstract function fetchRow($statement);    
}

?>