<?php
require_once '../lib/Template/Native.php';

abstract class NativeHelperAbstract {
    private $_template;
    
    public function __construct(Native $template) {
        $this->setTemplate($template);
    }
    
    public function setTemplate(Native $template) {
        $this->_template = $template;
    }
    
    public function getTemplate() {
        return $this->_template;
    }  
}

?>