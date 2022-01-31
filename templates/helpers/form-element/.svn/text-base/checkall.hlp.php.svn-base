<?php
//---------------------- required -------------
require_once '../templates/helpers/form-element.php';

//---------------------- libs -----------------

//---------------------- models ---------------

class CheckallHelper extends FormElementHelper {
    private $_defaults = array(
    );
    function __construct($template) {
        parent::__construct($template);
	}
	
	function run($name, $id, $expr, $checked = false) {
	    //$options = array_merge($this->_defaults, $options);	
	    $expr = ':not(#'.$this->getId($name).')';    
	    $html = '<input type="checkbox" name="'.$name.'" id="'.$this->getId($name).'"
			'.($checked?'checked':'').'
			onclick="javascript: this.checked?$(\'#'.$id.'\').checkCheckboxes(\''.$expr.'\'):$(\'#'.$id.'\').unCheckCheckboxes(\''.$expr.'\');">
			<script type="text/javascript">
			$(function() {	
				'.($checked?'$(\'#'.$id.'\').checkCheckboxes(\''.$expr.'\');':'').'					
			});
			</script>';        	    
		echo $html;			
	}
}

?>