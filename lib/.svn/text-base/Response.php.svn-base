<?php
require_once '../lib/Json.php';

class Response {
    public static function json(array $json, $charset = 'uf-8') {
        header('Content-Type: application/json; charset='.$charset);
        echo Json::encode($json);
    }
    
    public static function file($filename, $content) {
    	header('Content-Type: application/force-download');
	    header("Content-Length: ".strlen($content)); 
    	header('Content-Disposition: attachment; filename="'.$filename.'"');
        echo $content;
    }    
}
?>