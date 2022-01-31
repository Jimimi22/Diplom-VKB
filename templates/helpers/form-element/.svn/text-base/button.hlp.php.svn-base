<?php
//---------------------- required -------------
require_once '../templates/helpers/form-element.php';

//---------------------- libs -----------------

//---------------------- models ---------------

class ButtonHelper extends FormElementHelper {
    private $_defaults = array(
	    'class' => 'button red',            
	    'width' => '100px'
    );
    function __construct($template) {
        parent::__construct($template);
	}
	
	function run($caption, $action, array $options = array()) {
	    $options = array_merge($this->_defaults, $options);	    
		$html = '<div class="'.$options['class'].'" style="width: '.$options['width'].'"
			onclick="javascript:'.$action.';"
		>'.$caption.'</div>';
		echo $html;			
	}
}

?>