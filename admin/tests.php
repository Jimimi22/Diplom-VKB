<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Admin.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
//---------------------- models ---------------
require_once '../model/Disciplines.php';
require_once '../model/Tests.php';
require_once '../model/Users.php';
require_once '../model/News.php';

class Controller extends AdminController {
    private $DisModel;
    private $TestsModel;       
    private $NewsModel;
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->DisModel = new DisModel($this->getDatabaseAdapter());
        $this->TestsModel = new TestsModel($this->getDatabaseAdapter());
        $this->UsersModel = new UsersModel($this->getDatabaseAdapter());
        $this->NewsModel = new NewsModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title, $template) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'tests');
        return $this->getTemplateAdapter()->render('admin/tests/'.$template);
    }
    
    public function indexCmd() {
    	header('Content-Type: text/html; charset=utf-8');
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);  
		
    	$where = null;        
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
        return $this->IndexTheme('Дисциплины', 'disciplines.tpl.php');
    } 
    
	public function getChaptersCmd() {
		$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);  
		
		$id_dis = Filter::getIntval($_REQUEST, 'id_dis');
		$where = '`id_dis` = '.$id_dis;        
        $count = $this->DisModel->getChaptersCnt($where);
	    $Pager = new Pager($count, $this->getConfig()->pager->onpage);
        $page  = $Pager->current(Filter::getIntval($_REQUEST, 'page', 
            Pager::$_FIRST));  	      

        $items = $this->DisModel->getChapters($Pager->index($page), 
	        $this->getConfig()->pager->onpage, $where);

	    $this->getTemplateAdapter()->put('id_dis', $id_dis);    	        
	    $this->getTemplateAdapter()->put('items', $items);    	    
   	    $this->getTemplateAdapter()->put('count', $count);	    
	    $this->getTemplateAdapter()->put('page',  $page);
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());        
        return $this->IndexTheme('Главы дисциплины', 'chapters.tpl.php');
    }
	
    
    public function manageQuestionsCmd () {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);  
		
    	$id_chapter = Filter::getIntval($_REQUEST, 'id_chapter');
		$where = '`id_chapter` = '.$id_chapter;        
        $items = $this->TestsModel->getQuestions($where, 'id ASC');
        $this->getTemplateAdapter()->put('items', $items);    	    
        return $this->IndexTheme('Вопросы', 'questions.tpl.php');
    }
	
    public function getTestedCmd () {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);  
		
		$id_chapter = Filter::getIntval($_REQUEST, 'id_chapter');    
		$users = $this->UsersModel->getTested($id_chapter);	
		foreach ($users as $key=>$value) {
		$wrong_answers = unserialize($users[$key]['wrong_answers']);
		if(count($wrong_answers) == 0)
			$users[$key]['is_tested'] = 'Сдал';
		else	
			$users[$key]['is_tested'] = 'Не сдал';
		}	
		$this->getTemplateAdapter()->put('items', $users);    	    
		return $this->IndexTheme('Вопросы', 'test_users.tpl.php');
	}
	
	public function getNotTestedCmd () {
	   	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);  
		
		$id_chapter = Filter::getIntval($_REQUEST, 'id_chapter');    
		$users = $this->UsersModel->getNotTested($id_chapter);	
		$this->getTemplateAdapter()->put('items', $users);    	    
		return $this->IndexTheme('Вопросы', 'not_users_test.tpl.php');
	}
	
	public function pointsLimitCmd () {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);  
		
		$is_points = Filter::getIntval($_REQUEST, 'is_points');    
		if($is_points) {
			$points = Filter::getIntval($_REQUEST, 'points');    
			$this->TestsModel->updatePoints($points);
		}
		$points = $this->TestsModel->getPoints();
		$this->getTemplateAdapter()->put('points', $points);    	    
		return $this->IndexTheme('Лимит баллов', 'points_limit.tpl.php');
	}
	
	public function testsResultsCmd() {
	   	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);  
		
		$results = $this->TestsModel->getTestsResults();
		$points = $this->TestsModel->getPoints();
		$this->getTemplateAdapter()->put('items', $results);    	    
		$this->getTemplateAdapter()->put('points', $points);    	    
        return $this->IndexTheme('Результаты тестов', 'test_results.tpl.php');
    } 
	
	
	

}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>