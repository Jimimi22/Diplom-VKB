<?php
include_once '../lib/Template/Native/Helper/Abstract.php';

class MessagesHelper extends NativeHelperAbstract {
	function __construct($template) {
	    parent::__construct($template);
	}
	
	function run($notif = true) {
	    $type = $notif?'notif':'error';	    
        if (isset($_SESSION['msg']) && isset($_SESSION['msg'][$type]) && (count($_SESSION['msg'][$type]))) {
            $html = '';
            for ($i = 0, $count = count($_SESSION['msg'][$type]); $i < $count; $i++) {
                $html .= '<li>'.$_SESSION['msg'][$type][$i].'</li>';
            }
            $html = '<div id="'.$type.'"><ul>'.$html.'</ul></div>';            
            
            $_SESSION['msg'][$type] = array();            
	    } else 
	        $html = '<div id="'.$type.'" style="display: none;"><ul></ul></div>';
	    echo $html;
	}
}

?>