<?php
require_once '../lib/template/template.php';

abstract class AbstractTemplateHelper {
    private $_template;
    
    public function __construct(Template $template) {
        $this->setTemplate($template);
    }
    
    public function setTemplate(Template $template) {
        $this->_template = $template;
    }
    
    /**
     * @return Template
	*/
    public function getTemplate() {
        return $this->_template;
    }  
}

?>