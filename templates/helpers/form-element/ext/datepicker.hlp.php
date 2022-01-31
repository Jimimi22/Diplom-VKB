<?php
//---------------------- required -------------
require_once '../templates/helpers/form-element/input.hlp.php';

//---------------------- libs -----------------

//---------------------- models ---------------

class DatepickerHelper extends InputHelper {
    public function __construct($template) {
        parent::__construct($template);
	}
	
	public function run($name, $value, $options = array()) {
	    //$options = array_merge($this->_defaults, $options);
	    parent::run($name, $value, $options);
		echo '<script type="text/javascript">
		$(function() {
			$(\'#'.$this->getId($name).'\').datepicker({
				dateFormat: $.datepicker.ATOM
			});
		});
		</script>';				
	}
}
?>