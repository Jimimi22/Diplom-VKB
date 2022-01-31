<?php
//---------------------- required -------------
require_once '../lib/template/helper/abstract.php';

//---------------------- libs -----------------

//---------------------- models ---------------

class FormElementHelper extends AbstractTemplateHelper {
    public function __construct($template) {
        parent::__construct($template);
	}
	
	public function getId($name) {
	    return 'id-'.ereg_replace('\[.*\]', '', $name);
	}
	
	public function withFailedHTMLCode($name) {
	    $name  = ereg_replace('\[.*\]', '', $name);
        return '<div class="failed" id="'.$name.'-error">'.
            ($this->getTemplate()->__get($name.'-error')).'</div>';	    
	}
}
?>