<?php
//---------------------- required -------------
require_once '../templates/helpers/form-element.php';

//---------------------- libs -----------------

//---------------------- models ---------------

class FileHelper extends FormElementHelper {
    private $_defaults = array(
	    'with-failed' => true
    );
    
    public function __construct($template) {
        parent::__construct($template);
	}
	
	public function run($name, $value, $options = array()) {
	    $options = array_merge($this->_defaults, $options);
        $html = '<input type="file" name="'.$name.'" id="'.$this->getId($name).'">';
        if ($options['with-failed']) {
            $html .= $this->withFailedHTMLCode($name);
        }
		echo $html;			
	}
}

?>