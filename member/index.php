<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Member.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
//---------------------- models ---------------
require_once '../model/News.php';

class Controller extends MemberController {

    private $NewsModel;

    public function __construct(Config $config) {
        parent::__construct($config);
        $this->NewsModel = new NewsModel($this->getDatabaseAdapter());
      
    }
    
    public function init(Config $config) {
    	
        parent::init($config);
        
    }    
    
    public function IndexTheme($title, $template) {
    	
        $this->getTemplateAdapter()->put('_MENUITEM', 'home');
        return $this->getTemplateAdapter()->render('member/news/'.$template);
    }
    
    public function indexCmd() {
    	$user  = $this->getUser();
    	$where = null;        
        $count = $this->NewsModel->getNewsCnt($where);
	    $Pager = new Pager($count, $this->getConfig()->pager->onpage);
        $page  = $Pager->current(Filter::getIntval($_REQUEST, 'page', 
            Pager::$_FIRST));  	      

        $items = $this->NewsModel->getNews($Pager->index($page), 
	        $this->getConfig()->pager->onpage, $where);
	            
	    $this->getTemplateAdapter()->put('items', $items);    	    
	    $this->getTemplateAdapter()->put('news', $items);    	    
	    $this->getTemplateAdapter()->put('user', $user);    	    
   	    $this->getTemplateAdapter()->put('count', $count);	    
	    $this->getTemplateAdapter()->put('page',  $page);
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());
		
        return $this->IndexTheme('Home', 'index.tpl.php');
    }            
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>