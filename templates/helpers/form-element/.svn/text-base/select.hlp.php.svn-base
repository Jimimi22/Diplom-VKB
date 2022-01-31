<?php
//---------------------- required -------------
require_once '../templates/helpers/form-element.php';

//---------------------- libs -----------------

//---------------------- models ---------------

class SelectHelper extends FormElementHelper {
    private $_defaults = array(
	    'class'    => 'fill50',
        'multiply' => false,
	    'with-failed' => true
    );
    
    function __construct($template) {
        parent::__construct($template);
	}
	
    public function run($name, $value, array $values, $options = array()) {
	    $options = array_merge($this->_defaults, $options);
	    $html  = '<select name="'.$name.'" id="'.$this->getId($name).'" 
		'.($options['multiply']?'multiple="multiple"':'').' class="'.$options['class'].'" '.($options['multiply']?'multiple="multiple"':'').'>';
	    foreach($values as $key => $option) {
            $selected = $options['multiply']?@in_array($key, $value):($key == $value);
	        $html .= '<option value="'.$key.'"'.($selected?'selected':'').'>'.$option.'</option>';
	    }
	    $html .= '</select>';
        if ($options['with-failed']) {
            $html .= $this->withFailedHTMLCode($name);
        }
		echo $html;			
	}
}

?>