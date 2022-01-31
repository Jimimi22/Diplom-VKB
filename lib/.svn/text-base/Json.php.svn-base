<?php
class Json {
    public function __construct() {
    }
    
    public static function encode(array $value) {
        $self = new self();
        return $self->value($value);        
    }    
        
    private function value($value) {
        return is_array($value)?$this->_array($value):$this->datum($value);
    }        
    
    private function string(&$string) {
        $search  = array('\\', "\n", "\t", "\r", "\b", "\f", '"');
        $replace = array('\\\\', '\\n', '\\t', '\\r', '\\b', '\\f', '\"');
        
        $string  = str_replace($search, $replace, $string);        
        $string  = str_replace(array(chr(0x08), chr(0x0C)), array('\b', '\f'), $string);
        return '"' . $string . '"';        
    }    
            
    private function _array(array $array) {
        $tmp = array();
        if (!empty($array) && (array_keys($array) !== range(0, count($array) - 1))) {
            $result = '{';
            foreach ($array as $key => $value) {
                $key = (string)$key;
                $tmp[] = $this->string($key).':'.$this->value($value);
            }
            $result .= implode(',', $tmp);
            $result .= '}';            
        } else {
            $result = '[';
            $length = count($array);
            for ($i = 0; $i < $length; $i++) {
                $tmp[] = $this->value($array[$i]);
            }
            $result .= implode(',', $tmp);
            $result .= ']';            
        }
        return $result;
    }
    
    private function datum($value) {
        $result = 'null';
        if (is_int($value) || is_float($value)) {
            $result = (string)$value;
        } elseif (is_string($value)) {
            $result = $this->string($value);
        } elseif (is_bool($value)) {
            $result = $value ? 'true' : 'false';
        }
        return $result;        
    }        
}
?>