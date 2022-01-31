<?php
//---------------------- required -------------
require_once '../templates/helpers/form-element.php';

//---------------------- libs -----------------

//---------------------- models ---------------

class TextareaHelper extends FormElementHelper {
    private $_defaults = array(
	    'class' => 'txt fill100',
        'rows'  => '5',
	    'with-failed' => true
    );
    
    public function __construct($template) {
        parent::__construct($template);
	}
	
	public function run($name, $value, $options = array()) {
	    $options = array_merge($this->_defaults, $options);
        $html = '<textarea name="'.$name.'" id="'.$this->getId($name).'"
			rows="'.$options['rows'].'"
			class="'.$options['class'].'">'.$value.'</textarea>';
        if ($options['with-failed']) {
            $html .= $this->withFailedHTMLCode($name);
        }
		echo $html;			
	}
}

?>