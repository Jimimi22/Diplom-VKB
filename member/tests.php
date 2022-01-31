<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Member.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
require_once '../lib/Mail/class.phpmailer.php';
//---------------------- models ---------------
require_once '../model/Disciplines.php';
require_once '../model/Tests.php';
require_once '../model/Users.php';
require_once '../model/News.php';

class Controller extends MemberController {
    private $DisModel;
    private $TestsModel;       
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
        return $this->getTemplateAdapter()->render('member/tests/'.$template);
    }
    
    public function indexCmd() {
    	$user  = $this->getUser();
        $this->getTemplateAdapter()->put('user', $user);
        $news = $this->NewsModel->getNews(0, 
	        100, $where);
	    $this->getTemplateAdapter()->put('news', $news);    	    
	    
    	$user_data = $this->UsersModel->loadUserByUid($_SESSION['uid']);
    	unset($_SESSION['u'.$user_data['id']]);
    	unset($_SESSION[$user_data['id']]);
    	unset($_SESSION['user_points']);
    	unset($_SESSION['id_answer']);
    	$_SESSION['right_answers'] = 0;
    	$_SESSION['unright_answers'] = 0;
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
	    $this->getTemplateAdapter()->put('items', $items);    	    
   	    $this->getTemplateAdapter()->put('count', $count);	    
	    $this->getTemplateAdapter()->put('page',  $page);
	    $this->getTemplateAdapter()->put('dis', $dis['discipline']);    	        
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());        
        return $this->IndexTheme('Главы дисциплины', 'chapters.tpl.php');
    }
    
    public function testCmd() {
    	$user  = $this->getUser();
        $this->getTemplateAdapter()->put('user', $user);
        $news = $this->NewsModel->getNews(0, 
	        100, $where);
	    $this->getTemplateAdapter()->put('news', $news);    	    
	    
    	$user_data = $this->UsersModel->loadUserByUid($_SESSION['uid']);
    	$id_chapter = Filter::getIntval($_REQUEST, 'id_chapter');
    	$id_quest = Filter::getIntval($_REQUEST, 'id_quest');
    	$answer = Filter::getStrval($_REQUEST, 'answer');
    	$level = Filter::getIntval($_REQUEST, 'level');
    	$step = Filter::getIntval($_REQUEST, 'step');
    	if(!$step) {
	    	$this->TestsModel->rmUserAnswers($user_data['id'], $id_chapter);
	    	$_SESSION['id_answer'] = $this->TestsModel->addUserAnswers($user_data['id'], $id_chapter);
	    }
    
    	if($_SESSION['u'.$user_data['id']] != '')
    		$_SESSION['u'.$user_data['id']] .= ','.$id_quest;
    	else {	
    		$_SESSION['u'.$user_data['id']] = $id_quest;
    	}
		$where = '`id_chapter` = '.$id_chapter;

		if($answer) {
    		$answered = explode(',', $_SESSION['u'.$user_data['id']]);
	    	$str = '';
	    	foreach ($answered as $key=>$value) {
	    		if($key !=0 ) 
	    			$str .= ','.$value;
	    		else	
	    			$str .= $value;
	    	}
	    	
	    	if(count($answered) > 0) {
	    		$where .= ' AND `id` NOT IN ('.$str.')';  
	    	}
	    	$right = $this->TestsModel->isRightAnswer($answer, $id_quest);
	    	if($right == 1) {
	    		$_SESSION['right_answers']++;
	    		$this->TestsModel->updateUserAnswers($user_data['id'], $id_chapter, $level);
	    		$level = $level+1;
	    		$where_quest =  $where.' AND `level` = '.$level;
	    		$quest_cnt = $this->TestsModel->getRandomQuestionCnt($where_quest);  
	    		
	    		if($quest_cnt > 0) {
	    			$where .= ' AND `level` = '.$level;
	    		} else {
	    			$where_quest =  $where.' AND `level` = '.$level;
	    			$quest_cnt = $this->TestsModel->getRandomQuestionCnt($where_quest);  
	    			if($quest_cnt > 0) {
	    				$where .= ' AND `level` = '.$level;
	    			} else {
	    				$level = $level-1;
	    				$where_quest =  $where.' AND `level` = '.$level;
		    			$quest_cnt = $this->TestsModel->getRandomQuestionCnt($where_quest);
		    			if($quest_cnt > 0) {
		    				$where .= ' AND `level` = '.$level;
		    			}  
	    			}
	    		}
	    	} else {
	    		$_SESSION['unright_answers']++;
	    		if($quest_cnt > 0) {
	    			$level = $level-1;
	    			$where .= ' AND `level` = '.$levels;
	    		} else {
	    			$where_quest =  $where.' AND `level` = '.$level;
	    			$quest_cnt = $this->TestsModel->getRandomQuestionCnt($where_quest);  
	    			if($quest_cnt > 0) {
	    				$where .= ' AND `level` = '.$level;
	    			} else {
	    				$level = $level+1;
	    				$where_quest =  $where.' AND `level` = '.$level;
		    			$quest_cnt = $this->TestsModel->getRandomQuestionCnt($where_quest);
		    			if($quest_cnt > 0) {
		    				$where .= ' AND `level` = '.$level;
		    			}  
	    			}
	    		}
	    		
	    	}
    	}
    	
		$item = $this->TestsModel->getRandomQuestion($where);  
		if($step > 0 && !$item) {
			$total_answers = $_SESSION['right_answers'] + $_SESSION['unright_answers'];
			$total_answers = $right_answers + $unright_answers;
			$test_res = $this->TestsModel->getUserTestsResults($user_data['id'], $_SESSION['id_answer']);
			$points = $this->TestsModel->getPoints();
			
			if($points > $test_res['user_points']) {
				$this->getTemplateAdapter()->put('test_res', 'Тест не сдан');  
			} else {
				$this->getTemplateAdapter()->put('test_res', 'Тест сдан');  
			}
			
			$this->getTemplateAdapter()->put('right_answers', $_SESSION['right_answers']);  
			$this->getTemplateAdapter()->put('unright_answers', $_SESSION['unright_answers']);  
			$this->getTemplateAdapter()->put('total_answers', $total_answers);  
			$this->getTemplateAdapter()->put('user_points', $test_res['user_points']);  
			$this->getTemplateAdapter()->put('is_tested', '1');  
		}
		$this->getTemplateAdapter()->put('item', $item);  
    	return $this->IndexTheme('Тест', 'test.tpl.php');	
    }
    
	public function doTestCmd() {
		$user  = $this->getUser();
        $this->getTemplateAdapter()->put('user', $user);
        $news = $this->NewsModel->getNews(0, 
	        100, $where);
	    $this->getTemplateAdapter()->put('news', $news);    	    
	    
		$id_chapter = Filter::getIntval($_REQUEST, 'id_chapter');
		$where = '`id_chapter` = '.$id_chapter;   
		$chapter = $this->DisModel->getChapterById($id_chapter);    
		//print_r($chapter);
		$item = $this->TestsModel->getUserAnswers($_SESSION['uid'], $id_chapter); 
		if(count($item) > 0) {
			$arr = unserialize($item['0']['wrong_answers']);
			if(count($arr) > 0) {
				$where .= ' AND ( ';	
				foreach ($arr as $key=>$value) {
					if ($key == 0)
						$where .= '`id` = '.$value;	
					else	
						$where .= ' OR `id` = '.$value;	
				}
				$where .= ')';
			}
		}
		$items = $this->TestsModel->getQuestions($where, 'id ASC');
		$wrong_answers = array();

		foreach ($items as $key=>$value) {
			if($_POST['answer_'.$value['id']] == 0)	
				array_push($wrong_answers, $value['id']);
		}
		
		$PHPMailer = new PHPMailer();
        $PHPMailer->ContentType = 'text/html';
        $PHPMailer->CharSet = 'utf-8';           
        $PHPMailer->From = 'no-reply@diplom.com';      
        $PHPMailer->FromName = 'YOUR TEST';
	    $PHPMailer->Subject = $chapter['chapter'];            
        if(count($wrong_answers) == 0) {
        	$PHPMailer->Body = "Поздравляем! Тест успешно пройден!"; 	
        }
        else {
        	$PHPMailer->Body = "К сожалению тест не пройден. У вас ".count($wrong_answers)." неправильных ответов."; 
        }
	    
	    $PHPMailer->AddAddress($values['email']);
	    $PHPMailer->Send();
		
		$values = array(
            'uid' =>$_SESSION['uid'],
            'id_chapter' => $id_chapter,
            'wrong_answers' => serialize($wrong_answers)
        );        
        $this->TestsModel->rmUserAnswers($_SESSION['uid'], $id_chapter);
        $this->TestsModel->saveAnswers($values, '');
       	$this->addMessage('Результаты тестирования высланы на ваш почтовый ящик', self::$NOTIF);
        $this->redirect('tests.php');
        return $this->IndexTheme('Тест', 'test.tpl.php');	
    }
	
    /*
    public function manageQuestionsCmd () {
		$id_chapter = Filter::getIntval($_REQUEST, 'id_chapter');
		$where = '`id_chapter` = '.$id_chapter;        
        $items = $this->TestsModel->getQuestions($where, 'id ASC');
        $this->getTemplateAdapter()->put('items', $items);    	    
        return $this->IndexTheme('Вопросы', 'questions.tpl.php');
    }
	*/
	
    


}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>