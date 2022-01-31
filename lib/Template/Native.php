<?php
require_once '../lib/Template/Native/Helper/Abstract.php';

class Native {
	private $_config;
	
	private $_vars    = array();	
	private $_helpers = array();
	
	private $_controller;
	
	public function __construct(Config $config) {
	    $this->setConfig($config);
	}
	
	public function setConfig(Config $config) {
	    return $this->_config = $config;
	}
		
	public function getConfig() {
	    return $this->_config;
	}	
	
	public function __set($name, $value) {
       	$this->_vars[$name] = $value;
	}
	
	public function __get($name) {
	    return array_key_exists($name, $this->_vars)?$this->_vars[$name]:null;
	}	
	
	public function pass(array $values) {
	    foreach ($values as $name => $value) {
	        $this->__set($name, $value);
	    }
	}
	
	public function pop($name) {
		echo $this->__get($name);
	}	
		
	public function inc($template) {
        $filepath = rtrim($this->_config->templates, '/').'/'.trim($template, '/');	    
		if (file_exists($filepath)) {
			require($filepath);
		} else
            die(__METHOD__.' template '.$template.' was not found in path '.$filepath);
	}
				
	public function run($helper, $args) {
        if ($helper) {
			if (!array_key_exists($helper, $this->_helpers)) {
				$filepath = rtrim($this->_config->helpers, '/').'/'.ucfirst($helper).'.hlp.php';
				if (file_exists($filepath)) {
					require_once($filepath);
										
					if (($name = trim(strrchr($helper, '/'), '/'))) {
						$helper = $name;
					}
					$class = new ReflectionClass(ucfirst($helper).'Helper');

                    if (!$class->isSubclassOf('NativeHelperAbstract')) {
                        die(__METHOD__.' invalid helper');
                    }	
					$this->_helpers[$helper] = $class->newInstanceArgs(array($this));//new $class($this);					
				}
				else
				    die(__METHOD__.' helper '.$helper.' was not found in path '.$filepath);
			}		

   			$method = new ReflectionMethod($this->_helpers[$helper], 'run');
    
    		return $method->invokeArgs($this->_helpers[$helper], $args);
    		
		}
		die(__METHOD__.' empty helper called');
	}
			
	public function render($template) {
		ob_start();
            $this->inc($template);
		return ob_get_clean();
	}
	
	public function put($name, $value) {
	    $this->__set($name, $value);	   
	}
	
	public function call() {
		$helper = func_get_arg(0);
		$args   = func_get_args();
        		array_shift($args);
        return $this->run($helper, $args);        		
	}
}

?>