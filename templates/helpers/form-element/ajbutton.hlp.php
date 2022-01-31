<?php
//---------------------- required -------------
require_once '../templates/helpers/form-element/button.hlp.php';

//---------------------- libs -----------------
require_once '../lib/json.php';

//---------------------- models ---------------

class AjbuttonHelper extends ButtonHelper {    
    private $_defaults = array(
        'validate' => 'null',
        'success'  => 'null',
        'block'    => 'null'
    );
    function __construct($template) {
        parent::__construct($template);
	}
	
	function run($caption, $id, $options = array()) {
	    $options = array_merge($this->_defaults, $options);
        parent::run($caption, '$.ajsubmit($(\'#'.$id.'\'), {
			block : '.@$options['block'].',

			validate : '.@$options['validate'].',
			success  : '.@$options['success'].'
		})', $options);
        echo '<script type="text/javascript">
			$(function() {
				$(\'#'.$id.'\').ajsubmit();
			});</script>';
	}
}

?>