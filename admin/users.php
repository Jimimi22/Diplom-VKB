<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Admin.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
//---------------------- models ---------------
require_once '../model/Users.php';
require_once '../model/News.php';

class Controller extends AdminController {    
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->UsersModel = new UsersModel($this->getDatabaseAdapter());
        $this->NewsModel = new NewsModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title, $template) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'users');
        return $this->getTemplateAdapter()->render('admin/users/'.$template);
    }
    
    public function indexCmd() {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);  
    	
    	$where = ' `is_admin` = 0';
    	$keyword = Filter::getStrval($_REQUEST, 'keyword');
    	if($keyword)
    		$where .= ' AND (`username` LIKE \'%'.$keyword.'%\' OR `email` LIKE \'%'.$keyword.'%\' OR `first_name` LIKE \'%'.$keyword.'%\' OR `last_name` LIKE \'%'.$keyword.'%\')';	
    	$count = $this->UsersModel->getUsersCnt($where); 
    	$Pager = new Pager($count, $this->getConfig()->pager->onpage);
        $page  = $Pager->current(Filter::getIntval($_REQUEST, 'page', 
            Pager::$_FIRST));  	      
    	$items = $this->UsersModel->getUsers($Pager->index($page), 
	        $this->getConfig()->pager->onpage, $where); 
        $this->getTemplateAdapter()->put('keyword', $keyword);    	    
        $this->getTemplateAdapter()->put('items', $items);    	    
   	    $this->getTemplateAdapter()->put('count', $count);	    
	    $this->getTemplateAdapter()->put('page',  $page);
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());
	    return $this->IndexTheme('Users', 'manage.tpl.php');
    }

    public function editCmd() {
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);  
    	
    	$where = null;        
    	$uid = Filter::getStrval($_REQUEST, 'uid');
        $user_data = $this->UsersModel->loadUserByUid($uid);
        $ref = $this->UsersModel->getUserById($user_data['ref_id']);
        $user_data['ref_id'] = $ref['uid'];
       	$this->getTemplateAdapter()->put('action', 'Обновить аккаунт');		   
	    $this->getTemplateAdapter()->pass($user_data);   	    
	    return $this->IndexTheme('Редактировать аккаунт', 'edit.tpl.php');
    }

    public function doSaveCmd() {
    	/*
    	$items = $this->NewsModel->getNews(0, 
	    100, $where);
	    $this->getTemplateAdapter()->put('news', $items);
		$user  = $this->getUser();
		$this->getTemplateAdapter()->put('user', $user);  
    	*/
    	
		$uid = Filter::getStrval($_REQUEST, 'uid');
		$ref_data = $this->UsersModel->loadUserByUid(Filter::getStrval($_REQUEST, 'ref_id'));
	    $values = array(
            'email' => Filter::getEmail($_REQUEST, 'email'),
            'username' => Filter::getStrval($_REQUEST, 'username'),
            'password' => Filter::getStrval($_REQUEST, 'password'),
            'password1' => Filter::getStrval($_REQUEST, 'password1'),
            'first_name' => Filter::getStrval($_REQUEST, 'first_name'),
            'last_name' => Filter::getStrval($_REQUEST, 'last_name'),
            'url' => Filter::getStrval($_REQUEST, 'url'),
            'mesenger' => Filter::getIntval($_REQUEST, 'mesenger'),
            'id_mes' => Filter::getStrval($_REQUEST, 'id_mes'),
            'ref_id' => $ref_data['id'],
            'is_active' => Filter::getIntval($_REQUEST, 'is_active'),
        );
        if ($this->ValidateForm($values)) {
			unset($values['password1']);
        	if ($this->UsersModel->saveUser($values, $uid)) {
        		$this->addMessage('Аккаунт обновлён', self::$NOTIF);
        		 $this->redirect('?cmd=index');
        	}
           
        }
        $this->getTemplateAdapter()->pass($values);
        return $this->editCmd();
    }
    
	 private function ValidateForm(array $values) {
        $valid = true;
        if (empty($values['email'])) {
            $this->getTemplateAdapter()->put('email-failed', 'неверное значение');
            $valid = false;
        }
        if (empty($values['username'])) {
            $this->getTemplateAdapter()->put('username-failed', 'обязательное поле');            
            $valid = false;
        }
        if (empty($values['password']) || ($values['password'] != $values['password1'])) {
            $this->getTemplateAdapter()->put('password-failed', 'Введите пароль в обоих полях.
');
            $valid = false;
        }        
       
        return $valid;
    }
    
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>