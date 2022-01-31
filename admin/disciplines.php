<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Admin.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
//---------------------- models ---------------
require_once '../model/Disciplines.php';
require_once '../model/News.php';

class Controller extends AdminController {
    private $DisModel;
       
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->DisModel = new DisModel($this->getDatabaseAdapter());
        $this->NewsModel = new NewsModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title, $template) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'dis');
        return $this->getTemplateAdapter()->render('admin/disciplines/'.$template);
    }
    
    public function indexCmd() {
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
        return $this->IndexTheme('Дисциплины', 'manage.tpl.php');
    }  
    
	public function doManageChaptersCmd() {
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
        return $this->IndexTheme('Главы дисциплины', 'manage_chapters.tpl.php');
    }
		
    public function addCmd() {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);    	    
		
        return $this->IndexTheme('Добавить дисциплину', 'edit.tpl.php');        
    }
    
  	public function addChapterCmd() {
  		$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);    	    
  		$id_dis = Filter::getIntval($_REQUEST, 'id_dis');
  		$this->getTemplateAdapter()->put('id_dis', $id_dis);
        return $this->IndexTheme('Добавить главу', 'edit_chapt.tpl.php');        
    }
    
	public function doEditChapterCmd() {
		$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);    	    
		$id = Filter::getIntval($_REQUEST, 'id');
        if ($id && !($item = $this->DisModel->getChapterById($id))) {
            $this->addMessage('Глава не найдена', self::$ERROR);
            $this->redirect('?cmd=index');                
        }
        
        $values = array(
            'body' => $_REQUEST['body'],
            'chapter' => Filter::getStrval($_REQUEST, 'chapter'),
            'id_dis' => Filter::getIntval($_REQUEST, 'id_dis'),
            'is_active' => Filter::getIntval($_REQUEST, 'is_active'),
        );        
        
        if ($this->ValidateEditChaptForm($values)) {
            $this->DisModel->saveChapter($values, $id);
            $this->addMessage('Изменения сохранены', self::$NOTIF);
            $this->redirect($id?'?cmd=editChapter&id='.$id:'?cmd=doManageChapters&id_dis='.$values['id_dis']);
        }
        $this->getTemplateAdapter()->put('id', $id);
        $this->getTemplateAdapter()->pass($values);
        return $this->IndexTheme($id?'Редактировать главу':'Добавить главу', 'edit.tpl.php'); 
    }
    
    public function editCmd() {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);    	    
        $id = Filter::getIntval($_REQUEST, 'id');
        if (!($item = $this->DisModel->getDisById($id))) {
            $this->addMessage('Дисциплина не найдена', self::$ERROR);
            $this->redirect('?cmd=index');                
        }
        $this->getTemplateAdapter()->pass($item);
        return $this->IndexTheme('Редактировать дисциплину', 'edit.tpl.php'); 
    }
    
	public function editChapterCmd() {
		$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);    	    
		//die('here1');
        $id_chapt = Filter::getIntval($_REQUEST, 'id');
        if (!($item = $this->DisModel->getChapterById($id_chapt))) {
            $this->addMessage('Глава не найдена', self::$ERROR);
            $this->redirect('?cmd=index');                
        }
        $this->getTemplateAdapter()->pass($item);
        return $this->IndexTheme('Редактировать главу', 'edit_chapt.tpl.php'); 
    }
  
    public function doEditCmd() {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);    	    
		
        $id = Filter::getIntval($_REQUEST, 'id');
        $id_dis = Filter::getIntval($_REQUEST, 'id_dis');
        if ($id && !($item = $this->DisModel->getDisById($id))) {
            $this->addMessage('Дисциплина не найдена', self::$ERROR);
            $this->redirect('?cmd=index');                
        }
        
        $values = array(
            'discipline' => Filter::getStrval($_REQUEST, 'discipline')
        );        
        
        if ($this->ValidateEditForm($values)) {
            $this->DisModel->saveDis($values, $id);
            $this->addMessage('Изменения сохранены', self::$NOTIF);
            $this->redirect($id?'?cmd=edit&id='.$id:'?cmd=add');
        }
        $this->getTemplateAdapter()->put('id', $id);
        $this->getTemplateAdapter()->put('id_dis', $id_dis);
        $this->getTemplateAdapter()->pass($values);
        return $this->IndexTheme($id?'Редактировать дисциплину':'Добавить дисциплину', 'edit.tpl.php'); 
    }
   
    public function doRemoveCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        $this->DisModel->rmDis($id);
        $this->addMessage('Изменения сохранены', self::$NOTIF);
        $this->redirect('?cmd=index');        
    }
    
	public function doRemoveChapterCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        $this->DisModel->rmChapter($id);
        $this->addMessage('Изменения сохранены', self::$NOTIF);
        $this->redirect('?cmd=index');        
    }
    
    private function ValidateEditForm(array $values) {
        $valid = true;
        if (empty($values['discipline'])) {
            $this->getTemplateAdapter()->put('caption-failed', 'обязательное поле');
            $valid = false;
        }
        
        return $valid;
    }  
    
    private function ValidateEditChaptForm(array $values) {
        $valid = true;
        if (empty($values['chapter'])) {
            $this->getTemplateAdapter()->put('chapter-failed', 'обязательное поле');
            $valid = false;
        }
	    if (empty($values['chapter'])) {
            $this->getTemplateAdapter()->put('body-failed', 'обязательное поле');
            $valid = false;
        }
        
        return $valid;
    }  
    
    public function chapterCmd() {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);    	    
        $where = null;        
        $id_chapt = Filter::getIntval($_REQUEST, 'id');
        if (!($item = $this->DisModel->getChapterById($id_chapt))) {
            $this->addMessage('Глава не найдена', self::$ERROR);
            $this->redirect('?cmd=index');                
        }
        $this->getTemplateAdapter()->pass($item);
        $this->getTemplateAdapter()->put('body-failed', 'обязательное поле');
	    return $this->IndexTheme('Глава', 'chapter.tpl.php');
    }  
    
    public function addQuestCmd() {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);    	    
		
    	$id_chapt = Filter::getIntval($_REQUEST, 'id');
    	$this->getTemplateAdapter()->put('id_chapt', $id_chapt);
    	return $this->IndexTheme('Вопрос', 'add_quest.tpl.php');
    }  
    

    public function editQuestCmd() {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);    	    
		
    	$id_quest = Filter::getIntval($_REQUEST, 'id_quest');
    	$question = $this->DisModel->getQuestionById($id_quest);
        $answers = $this->DisModel->getAnswersByQuestId($id_quest);
        $this->getTemplateAdapter()->put('question', $question[0]['question']);
        $this->getTemplateAdapter()->put('answer', $question[0]['wright_answ']);
        $this->getTemplateAdapter()->put('level', $question[0]['level']);
		$this->getTemplateAdapter()->put('id_quest', $id_quest);
		$this->getTemplateAdapter()->put('id_chapter', $question[0]['id_chapter']);
		$this->getTemplateAdapter()->put('answers', $answers);
    	return $this->IndexTheme('Вопрос', 'edit_quest.tpl.php');
    } 

    
	public function doEditQuestCmd() {
		$id_quest = Filter::getIntval($_REQUEST, 'id_quest');
		$id_chapter = Filter::getIntval($_REQUEST, 'id_chapt');
		if($id_quest)
			$this->DisModel->rmAnswers($id_quest);
	    else
	    	$id_quest = null;
		$values = array(
            'question' => Filter::getStrval($_REQUEST, 'question'),
            'wright_answ' => Filter::getStrval($_REQUEST, 'answer'),
            'level' => Filter::getStrval($_REQUEST, 'level'),
            'picture' => $_FILE['tmp']['picture'],
            'id_chapter' => $id_chapter
        );
        
		$not_wright = array();       
        if ($this->ValidateEditQuestionForm($values)) {
        	if($id_quest)
            	$this->DisModel->saveQuestion($values, $id_quest);
            else	
				$id_quest = $this->DisModel->saveQuestion($values, null);
			/*	
            foreach ($_POST['answers'] as $key=>$value) {
              	$is_wright = 0;
            	if($key+1 == $_POST['is_wright'][0])
            		$is_wright = 1;
            		if(!empty($value['answer']))	
            			$this->DisModel->saveAnswer($value, $id_quest, $is_wright);
            }
			*/
            $this->redirect('tests.php?cmd=manageQuestions&id_chapter='.$id_chapter);
            $this->addMessage('Изменения сохранены', self::$NOTIF);
        }
        
        $this->getTemplateAdapter()->put('id', $id);
        $this->getTemplateAdapter()->pass($values);
        return $this->IndexTheme($id?'Редактировать вопрос':'Добавить вопрос', 'edit_quest.tpl.php'); 
	}
	
	public function rmQuestCmd() {
		$id_quest = Filter::getIntval($_REQUEST, 'id_quest');
		$this->DisModel->rmAnswers($id_quest);
		$this->DisModel->rmQuest($id_quest);
        $this->redirect($_SERVER['HTTP_REFERER']);
	}
    
    private function ValidateEditQuestionForm(array $values) {
        $valid = true;
        if (empty($values['question'])) {
            $this->getTemplateAdapter()->put('question-failed', 'обязательное поле');
            $valid = false;
        }
        return $valid;
    }  

}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>