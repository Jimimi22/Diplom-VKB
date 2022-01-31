<?php  
class Config implements Iterator {
    protected $_config = array();
  	  
    public function __construct(array $array) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $this->__set($key, new self($value));  
            } else {
                $this->__set($key, $value);
            }
        }
    }
  	  
    public function __set($key, $value) {
        $this->_config[$key] = $value;
    }
  	  
    public function __get($key) {
        return @$this->_config[$key];        
    }
  	  
    public function rewind() {
        reset($this->_config);
    }
  	  
    public function key() {
        return key($this->_config);
    }
  	  
    public function current() {
        return current($this->_config);
    }
  	  
    public function next() {
        return next($this->_config); 
    }
  	  
    public function valid() {
        return (current($this->_config) !== false);
    }
  	  
    public function toArray() {
        return $this->_config;
    }
}
?>