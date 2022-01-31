<?php
require_once '../lib/Template/Adapter/Interface.php';
require_once '../lib/Template/Native.php';

require_once '../lib/Config.php';

class TemplateAdapterNative implements TemplateAdapterInterface {
    private $_template;
    
	public function __construct(Config $config) {
	    $this->_template = new Native($config);
	}
	
	public function put($name, $value) {
	    $this->_template->$name = $value;
	}
	
	public function pass(array $values) {
	    $this->_template->pass($values);
	}
	
	public function get($name) {
	    return $this->_template->$name;
	}
	
	public function render($template) {
	    return $this->_template->render($template);
	}	
}
?>