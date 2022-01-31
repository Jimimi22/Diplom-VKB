<?php
class Pager {
    public static $_FIRST = 1;
    private $_total;
    private $_onpage;
  	
    public function __construct($total, $onpage) {
        $this->_total   = $total;
        $this->_onpage  = $onpage;
    }
    
    public function getTotal() {
        return $this->_total;
    }
    
    public function getOnpage() {
        return $this->_onpage;
    }
  	  
    public function pages() {
        $pages = ceil($this->_total/$this->_onpage);
        return $pages?$pages:$this->firstPage();
    }
  	  
    public function current($current) {
        if ($current < $this->firstPage()) {
            return $this->firstPage();
        } else if ($current > $this->lastPage()) {
            return $this->lastPage();
        } return $current;
    }
  	  
    public function firstPage() {
        return self::$_FIRST;
    }

    public function lastPage() {
        return $this->pages();
    }
  	  
    public function nextPage($current) {
        $current = $this->current($current);  	  	
        if ($current < $this->lastPage()) {
            return $current+1;
        } else return null;
    }
  	  
    public function prevPage($current) {
        $current = $this->current($current);  	  	
        if ($current > $this->firstPage()) {
            return $current-1;
        } else return null;
    }
  	  
    public function prevNeighbours($current, $limit) {
        $current = $this->current($current);  	  	
        $result = array();
        while(($current = $this->prevPage($current)) && $limit) {
            $result[] = $current;
            $limit--;
        }
        return array_reverse($result);
    }
  	  
    public function nextNeighbours($current, $limit) {
        $current = $this->current($current);  	  	
        $result = array();
        while(($current = $this->nextPage($current)) && $limit) {
            $result[] = $current;
            $limit--;
        }
        return $result;
    }
  	  
    public function index($current, $repaire = 1) {
        $current = $this->current($current);  	  	
        $result = ($current-$repaire)*$this->_onpage;
        return $result;
    }
}
?>