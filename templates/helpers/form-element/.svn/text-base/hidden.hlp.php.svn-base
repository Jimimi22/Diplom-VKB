<?php
//---------------------- required -------------
require_once '../templates/helpers/form-element.php';

//---------------------- libs -----------------

//---------------------- models ---------------

class HiddenHelper extends FormElementHelper {
    public function __construct($template) {
        parent::__construct($template);
	}
	
	public function run($name, $value) {
        $html = '<input type="hidden" name="'.$name.'" value="'.$value.'" id="'.$this->getId($name).'"
			class="'.$options['class'].'">';
		echo $html;			
	}
}

?>