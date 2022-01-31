<?php
//---------------------- required -------------
require_once '../templates/helpers/form-element.php';

//---------------------- libs -----------------

//---------------------- models ---------------

class InputHelper extends FormElementHelper {
    private $_defaults = array(
	    'class' => 'txt fill100',
            
	    'with-failed' => true
    );
    
    public function __construct($template) {
        parent::__construct($template);
	}
	
	public function run($name, $value, $options = array()) {
	    $options = array_merge($this->_defaults, $options);
        $html = '<input type="text" name="'.$name.'" value="'.$value.'" id="'.$this->getId($name).'"
			class="'.$options['class'].'">';
        if ($options['with-failed']) {
            $html .= $this->withFailedHTMLCode($name);
        }
		echo $html;			
	}
}

?>