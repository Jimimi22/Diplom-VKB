<?php
require_once('../lib/json.php');

class FCKToolbarFactory {	
	
		
	public function forName($name) {
		if (array_key_exists($name, self::$_TOOLBARS)) {
			return self::forSource(self::$_TOOLBARS[$name]);
		} die (__METHOD__.' undefined toolbar');								
	}
	
	public static function forSource(array $source) {
		return Json::encode($source);
	}
}

?>