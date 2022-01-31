<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Member.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
//---------------------- models ---------------
require_once '../model/Disciplines.php';
require_once '../model/Users.php';
require_once '../model/News.php';

class Controller extends MemberController {
    private $DisModel;
       
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->DisModel = new DisModel($this->getDatabaseAdapter());
        $this->UsersModel = new UsersModel($this->getDatabaseAdapter());
        $this->NewsModel = new NewsModel($this->getDatabaseAdapter());
        
    }
    
    public function init(Config $config) {
        parent::init($config);
        
        $this->getTemplateAdapter()->put('news', $news); 
        
    }    
    
    public function IndexTheme($title, $template) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'material');
        return $this->getTemplateAdapter()->render('member/material/'.$template);
    }
    
    public function indexCmd() {
        $where = null;        
	    $user  = $this->getUser();
        $this->getTemplateAdapter()->put('user', $user);
        $news = $this->NewsModel->getNews(0, 
	        100, $where);
	    $this->getTemplateAdapter()->put('news', $news);    	    
	        
        $count = $this->DisModel->getDisCnt($where);
	    $Pager = new Pager($count, $this->getConfig()->pager->onpage);
        $page  = $Pager->current(Filter::getIntval($_REQUEST, 'page', 
            Pager::$_FIRST));  	      

        $items = $this->DisModel->getDis($Pager->index($page), 
	        $this->getConfig()->pager->onpage, $where);
	            
	    $this->getTemplateAdapter()->put('items', $items);    	    
   	    $this->getTemplateAdapter()->put('count', $count);	    
	    $this->getTemplateAdapter()->put('page',  $page);
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());        
        return $this->IndexTheme('Дисциплины', 'manage.tpl.php');
    } 
    
    public function getChaptersCmd() {
   	    $user  = $this->getUser();
        $this->getTemplateAdapter()->put('user', $user);
        $news = $this->NewsModel->getNews(0, 
	        100, $where);
   	    $this->getTemplateAdapter()->put('news', $news);    
		$id_dis = Filter::getIntval($_REQUEST, 'id_dis');
		$dis = $this->DisModel->getDisById($id_dis);
		$where = '`id_dis` = '.$id_dis.' AND `is_active` = 1';        
        $count = $this->DisModel->getChaptersCnt($where);
	    $Pager = new Pager($count, $this->getConfig()->pager->onpage);
        $page  = $Pager->current(Filter::getIntval($_REQUEST, 'page', 
            Pager::$_FIRST));  	      

        $items = $this->DisModel->getChapters($Pager->index($page), 
	        $this->getConfig()->pager->onpage, $where);

	    $this->getTemplateAdapter()->put('id_dis', $id_dis);    	        
	    $this->getTemplateAdapter()->put('dis', $dis['discipline']);    	        
	    $this->getTemplateAdapter()->put('items', $items);    	    
   	    $this->getTemplateAdapter()->put('count', $count);	    
	    $this->getTemplateAdapter()->put('page',  $page);
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());        
        return $this->IndexTheme('Главы дисциплины', 'chapters.tpl.php');
    }
    
     public function getChapterCmd() {
   	    $user  = $this->getUser();
        $this->getTemplateAdapter()->put('user', $user);
        $news = $this->NewsModel->getNews(0, 
	        100, $where);
  	    $this->getTemplateAdapter()->put('news', $news);    
     	$where = null;        
        $id_chapt = Filter::getIntval($_REQUEST, 'id_chapter');
        if (!($item = $this->DisModel->getChapterById($id_chapt))) {
            $this->addMessage('Глава не найдена', self::$ERROR);
            $this->redirect('?cmd=index');                
        }
        $dis = $this->DisModel->getDisById($item['id_dis']);
        $this->getTemplateAdapter()->put('dis', $dis['discipline']);    	        
        $this->getTemplateAdapter()->pass($item);
         return $this->IndexTheme('Глава', 'chapter.tpl.php');
     }
		
}
//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>