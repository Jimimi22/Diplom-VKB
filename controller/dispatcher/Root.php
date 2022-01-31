<?php
require_once '../lib/Controller/Interface.php';

//---------------------- libs -----------------
require_once '../lib/Config.php';

require_once '../lib/Database/Adapter/Abstract.php';
require_once '../lib/Database/Adapter/Mysql.php';

require_once '../lib/Template/Adapter/Native.php';
require_once '../lib/Template/Native.php';
//---------------------- models ---------------

abstract class RootController implements ControllerInterface {
    public static $NOTIF = true;
    public static $ERROR = false; 
               
    private $_config;
    private $_command;
    
    private $_database;
    private $_template;
    
    public function __construct(Config $config) {
        //database
        $this->setDatabaseAdapter(new DatabaseAdapterMysql($config->db));
        
		//template
		$this->setTemplateAdapter(new TemplateAdapterNative($config->tpl));
		
		$this->setConfig($config);
    }
    
    public function process($command, array $args = array()) {
        $this->_command = $command;
        $command .= (isset($_SERVER['HTTP_X_REQUESTED_WITH'])
	        && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest'))?'Async':'Cmd';
        try {
            $class   = new ReflectionClass($this);
            $method  = $class->getMethod($command);
            
            $this->getTemplateAdapter()->put('_CMD', $this->_command);
			$this->getTemplateAdapter()->put
			    ('_CONTENT', $method->invokeArgs($this, $args));            
			    
            header('Content-Type: text/html;charset='.$this->getConfig()->charset);                       
    		echo $this->getTemplateAdapter()->render($this->getConfig()->thm);
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
    
    public function setTemplateAdapter(TemplateAdapterInterface $adapter) {
    	$this->_template = $adapter;
    }
    
    public function getTemplateAdapter() {
    	return $this->_template;
    }
    
    public function addMessage($message, $notif = true) {
	    if (!array_key_exists('msg', $_SESSION)) {
	        $_SESSION['msg'] = array('error' => array(), 'notif' => array());
	    } 
	    $_SESSION['msg'][($notif)?'notif':'error'][] = $message;        
    }
    
    public function redirect($url) {
		header('Location: '.$url);
		die();
	}
	
    public abstract function indexCmd();
    
    public function _404($command) {        
        header("HTTP/1.0 404 Not Found"); 
        die();
    }    
}

?>