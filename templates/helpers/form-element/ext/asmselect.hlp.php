<?php
//---------------------- required -------------
require_once '../templates/helpers/form-element/select.hlp.php';

//---------------------- libs -----------------

//---------------------- models ---------------

class AsmselectHelper extends SelectHelper {
    private $_defaults = array(
    );
    
    public function __construct($template) {
        parent::__construct($template);
	}
	
	public function run($name, $value, array $values, $options = array()) {
	    $options = array_merge($this->_defaults, $options);
	    $options['multiply'] = true;
	    
	    parent::run($name, $value, $values, $options);
        echo '<script type="text/javascript">
			$(function() {
			    $(\'#'.$this->getId($name).'\').asmSelect({
					animate: true,
					highlight: true
				});
			});
		</script>';	
	}
}

?>