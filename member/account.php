<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Member.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
//---------------------- models ---------------
require_once '../model/Users.php';
require_once '../model/News.php';

class Controller extends MemberController {
    private $NewsModel;
    private $PaymentsModel;
    
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->UsersModel = new UsersModel($this->getDatabaseAdapter());
        $this->PaymentsModel = new PaymentsModel($this->getDatabaseAdapter());
        $this->NewsModel = new NewsModel($this->getDatabaseAdapter());
        
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'account');
        return $this->getTemplateAdapter()->render('user/edit.tpl.php');
    }
    
    public function indexCmd() {
    	$user  = $this->getUser();
        $this->getTemplateAdapter()->put('user', $user);
        $news = $this->NewsModel->getNews(0, 
	        100, $where);
	    $this->getTemplateAdapter()->put('news', $news); 
    	$where = null;        
        $user_data = $this->UsersModel->loadUserByUid($_SESSION['uid']);
        $this->getTemplateAdapter()->put('action', 'Обновить аккаунт');		   
        $this->getTemplateAdapter()->put('update', 'yes');		   
	    $this->getTemplateAdapter()->pass($user_data);  
	    return $this->IndexTheme('Edit account');
    }   

	public function doSaveCmd() {
		$id = Filter::getStrval($_REQUEST, 'uid');
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
            'user_info' => Filter::getStrval($_REQUEST, 'user_info'),
            'uid' => $id
            
        );
        if ($this->ValidateSendForm($values)) {
			unset($values['password1']);
			if ($this->UsersModel->saveUser($values, $id)) {
        		$this->addMessage('Ваш аккаунт сохранён', self::$NOTIF);
        	}
            $this->redirect('?cmd=index');
        }
        $this->getTemplateAdapter()->pass($values);
        return $this->indexCmd();
    }
    
    private function ValidateSendForm(array $values) {
    	$valid = true;
        if (empty($values['email'])) {
            $this->getTemplateAdapter()->put('email-failed', 'неверное значение');
            $valid = false;
        }
        if (empty($values['username'])) {
            $this->getTemplateAdapter()->put('username-failed', 'обязательное поле');            
            $valid = false;
        }
            
        $where = '`email` = \''.$values['email'].'\' AND `uid` != \''.$values['uid'].'\'';
	    $is_exists = $this->UsersModel->getUsers(0, 1, $where);
        if(count($is_exists) > 0) {
        	$this->addMessage('Пользователь с таким e-mail уже зарегистрирован', self::$NOTIF);
            $valid = false;
        }
		
        if (empty($values['password']) || ($values['password'] != $values['password1'])) {
            $this->getTemplateAdapter()->put('password-failed', 'Введите пароль в оба поля.
');
            $valid = false;
        }  
       
        return $valid;
    }
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>