<?php  
//---------------------- required -------------
include_once '../lib/Template/Native/Helper/Abstract.php';

//---------------------- libs -----------------

//---------------------- models ---------------

class PagerHelper extends NativeHelperAbstract {
    private $_pager;    
    
	public function __construct($template) {
        parent::__construct($template);
	}
  	  
    public function pagerFirst($page, $href) {
        if ($page != $this->_pager->firstPage()) {
            return '<span class="act"><a href="'.$href.$this->_pager->firstPage().'">&laquo;</a></span>';  	  	        	  	      
        } return '<span class="dis">&laquo;</span>';    
    }

    public function pagerLast($page, $href) {
        if ($page != $this->_pager->lastPage()) {
            return '<span class="act"><a href="'.$href.$this->_pager->lastPage().'">&raquo;</a></span>';  	  	      
        } else return '<span class="dis">&raquo;</span>';
    }

    public function pagerNext($page, $href) {
        if (($page = $this->_pager->nextPage($page))) {
            return '<span class="act"><a href="'.$href.$page.'">Next</a></span>';
        } else return '<span class="dis">Next</span>';
    }

    public function pagerPrev($page, $href) {
        if (($page = $this->_pager->prevPage($page))) {
            return '<span class="act"><a href="'.$href.$page.'">Prev</a></span>';  	  	       	  	      
        } else return '<span class="dis">Prev</span>';
    }

    public function pagerPrevNeighbours($page, $neighbours, $href) {
        $html = '';
            $neightbours = $this->_pager->prevNeighbours($page, $neighbours);
            foreach ($neightbours as $value) {
                $html .= '<span class="act">[<a href="'.$href.$value.'">'.$value.'</a>]</span>';
        }
        return $html;
    }

    public function pagerNextNeighbours($page, $neighbours, $href) {
        $html = '';
        $neightbours = $this->_pager->nextNeighbours($page, $neighbours);
        foreach ($neightbours as $value) {
            $html .= '<span class="act">[<a href="'.$href.$value.'">'.$value.'</a>]</span>';
        }
        return $html;
    }
      	    	    	    	  
    public function run($total, $onpage, $page, $neighbours, $href) {
        $this->_pager = new Pager($total, $onpage);
        $url   = parse_url($href);
        $href .= isset($url['query'])?'&page=':'?page=';
        
        if (!$this->_pager->getTotal() ||
            ($this->_pager->pages() == 1)) {
            return ;
        }
        echo '<div class="pager">'.
            $this->pagerFirst($page, $href).
            $this->pagerPrev($page, $href).        
            $this->pagerPrevNeighbours($page, $neighbours, $href)
            .'<span id="current">['.$page.']</span>'.
            $this->pagerNextNeighbours($page, $neighbours, $href).                         
            $this->pagerNext($page, $href).        
            $this->pagerLast($page, $href).
	    '</div>';        	          	  	  
    }  	  
  	  
}
?>