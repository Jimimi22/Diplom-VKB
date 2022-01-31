<?php
//---------------------- required -------------
require_once '../templates/helpers/form-element/file.hlp.php';

//---------------------- libs -----------------
require_once '../lib/json.php';

//---------------------- models ---------------

class MultifileHelper extends FileHelper {    
    private $_defaults = array(
        'max'    => '-1',
        'accept' => '',
        'string' => array('remove' => 'remove')
    );
    
    function __construct($template) {
        parent::__construct($template);
	}
	
	function run($name, $options = array()) {
	    $options = array_merge($this->_defaults, $options);
	    parent::run($name, '', $options);
	    echo '<script type="text/javascript">
			$(function() {
				$(\'#'.$this->getId($name).'\').MultiFile({
					accept : \''.$options['accept'].'\',
					max    : \''.$options['max'].'\',
					
					STRING : {
						remove : \''.$options['string']['remove'].'\'
					}
				});
        	});
		</script>';
	}
}

?>