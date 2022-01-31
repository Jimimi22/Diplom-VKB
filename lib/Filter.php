<?php
class Filter {
    public static $_PLAIN = true;

    public static $_URL      = "^http://";        
    public static $_DATE     = "[0-9]{4}\-[0-9]{2}\-[0-9]{2}";    
    public static $_EMAIL    = "^[a-zA-Z0-9\._-]+@[a-zA-Z0-9\._-]+\.[a-zA-Z]{2,4}\$";            
    public static $_PASSWORD = "^[a-zA-Z0-9]{4,10}\$";    
    
    public static function isExist($stream, $key, $default = false) {
	    return array_key_exists($key, $stream)?true:$default;
	}
	
    public static function getIntval($stream, $key, $default = null) {
		return self::isExist($stream, $key)?intval($stream[$key]):$default;
	}
	
	public static function getFloatval($stream, $key, $default = null) {
		return self::isExist($stream, $key)?floatval($stream[$key]):$default;	    
	}
	
	public static function getStrval($stream, $key, $plain = true, $default = null) {
	    if (self::isExist($stream, $key)) {
	        $str = trim(strval($stream[$key]));
	        if ($plain) {
	            $str = strip_tags($str);
	        }
	        return $str;
	    }
	    return $default;
	}	
	
    public static function getArrval($stream, $key, $default = array()) {
		return self::isExist($stream, $key)?(array)$stream[$key]:$default;
	}

    public static function getMatch($stream, $key, $pattern, $default = false) {
	    return (self::isExist($stream, $key) && ereg($pattern, $stream[$key]))?$stream[$key]:$default;
	}	
	
	public static function getDate($stream, $key, $default = null) {
	    return self::getMatch($stream, $key, self::$_DATE, $default);
	}	

	public static function getEmail($stream, $key, $default = null) {
	    return self::getMatch($stream, $key, self::$_EMAIL, $default);
	}
	
	public static function getUrl($stream, $key, $default = null) {
	    return self::getMatch($stream, $key, self::$_URL, $default);	    
	}
	
	public static function getPassword($stream, $key, $default = null) {
	    return self::getMatch($stream, $key, self::$_PASSWORD, $default);	    
	}	
}
?>