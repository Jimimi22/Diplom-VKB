<?php
require_once '../lib/Controller/Interface.php';

//---------------------- libs -----------------
require_once '../lib/Config.php';

require_once '../lib/Database/Adapter/Abstract.php';
require_once '../lib/Database/Adapter/Mysql.php';
//---------------------- models ---------------

abstract class SchedulerController implements ControllerInterface {
    private $_config;
    private $_command;
    
    private $_database;
    
    public function __construct(Config $config) {
        //database
        $this->setDatabaseAdapter(new DatabaseAdapterMysql($config->db));
        
		$this->setConfig($config);
    }
    
    public function process($command, array $args = array()) {
        $this->_command = $command;
        $command .= (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
	        && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'))?'Async':'Cmd';
        try {
            $class   = new ReflectionClass($this);
            $method  = $class->getMethod($command);
            echo $method->invokeArgs($this, $args);
        } catch (ReflectionException $ex) {
            $this->_404($command);
        }    
    }
    
    public function setConfig(Config $config) {
        $this->_config = $config;
    }
    
    public function getConfig() {
        return $this->_config;
    }
    
    public function getCommand() {
        return $this->_command;
    }
    
    public function setDatabaseAdapter(DatabaseAdapterAbstract $adapter) {
        $this->_database = $adapter;
    }
    
    public function getDatabaseAdapter() {
        return $this->_database;
    }
        
    public abstract function indexCmd();
    
    public function _404($command) {        
        die(__METHOD__.' undefined command '.$command);
    }    
}

?>