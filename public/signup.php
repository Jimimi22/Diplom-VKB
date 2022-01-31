<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Public.php';

//---------------------- libs -----------------
require_once '../lib/Mail/class.phpmailer.php';
//---------------------- models ---------------
require_once '../model/Users.php';
require_once '../model/Payments.php';
require_once '../model/Programs.php';
require_once '../model/News.php';

class Controller extends PublicController {
    private $ProgramsModel;
    private $UsersModel;
    private $PaymentsModel;
    private $NewsModel;
    
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->UsersModel = new UsersModel($this->getDatabaseAdapter());
        $this->NewsModel = new NewsModel($this->getDatabaseAdapter());
        $this->ProgramsModel = new ProgramsModel($this->getDatabaseAdapter());
        $this->PaymentsModel = new PaymentsModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }
    
    public function IndexTheme($title, $template, $menu_item) {
        $this->getTemplateAdapter()->put('_MENUITEM', $menu_item);
        return $this->getTemplateAdapter()->render('user/'.$template);
    }
    
    public function indexCmd() {
    	$count = $this->NewsModel->getNewsCnt($where);
    	$items = $this->NewsModel->getNews(0, $count, $where);
    	$this->getTemplateAdapter()->put('news', $items);
    	$ref_uid = Filter::getStrval($_REQUEST, 'ref_uid');
    	$item = $this->UsersModel->loadUserByUid($ref_uid);
    	$payment_systems = $this->PaymentsModel->getPaymentSystems();
    	$this->getTemplateAdapter()->put('payment_systems', $payment_systems);	
    	$this->getTemplateAdapter()->put('ref_id', $item['id']);	
    	$this->getTemplateAdapter()->put('action', 'Новый аккаунт');		   
        return $this->IndexTheme('SignUp', 'edit.tpl.php', 'signup');
    }
    
        
    public function doSaveCmd() {
    	$where = '';
        $values = array(
            'email' => Filter::getEmail($_REQUEST, 'email'),
            'uid' => md5(time()),
            'username' => Filter::getStrval($_REQUEST, 'username'),
            'first_name' => Filter::getStrval($_REQUEST, 'first_name'),
            'last_name' => Filter::getStrval($_REQUEST, 'last_name'),
            'url' => Filter::getStrval($_REQUEST, 'url'),
            'mesenger' => Filter::getIntval($_REQUEST, 'mesenger'),
            'id_mes' => Filter::getStrval($_REQUEST, 'id_mes'),
            'user_info' => Filter::getStrval($_REQUEST, 'user_info'),
            'password' => substr(md5(time()), -6)
        );
        
        // get latest extuid's 
	    $users_data = $this->UsersModel->getUsers('0', '1', $where);
    	
        
        if ($this->ValidateSendForm($values)) {			
        	if ($this->UsersModel->saveUser($values, $id)) {
                      	    
	        	$PHPMailer = new PHPMailer();
	            $PHPMailer->ContentType = 'text/html';
	            $PHPMailer->CharSet = 'utf-8';           
	            $PHPMailer->From = 'no-reply@diplom.com';      
	            $PHPMailer->FromName = 'YOUR TEST';
	            $PHPMailer->Subject = 'YOUR TEST регистрация';            
	            $this->getTemplateAdapter()->pass($values);
	            $url = substr($values['uid'], 0, 5);
	            $PHPMailer->Body = $this->getTemplateAdapter()->render('emails/register.tpl.php'); 
	            $PHPMailer->AddAddress($values['email']);
	            $PHPMailer->Send();
        		$this->addMessage('Регистрация выполнена успешно! Пожалуйста, проверьте e-mail для получения входный данных. Ваш логин: '.$values['username'].', Ваш пароль: '.$values['password'].'', self::$NOTIF);
        	}
        	$this->redirect('?cmd=index');
        }
        $this->getTemplateAdapter()->pass($values);
        return $this->indexCmd();
    }
    
    private function ValidateSendForm(array $values) {
    	
        $valid = true;
        if (empty($values['email'])) {
        	
            $this->getTemplateAdapter()->put('email-failed', 'некорректное значение');
            $valid = false;
        }
        if (empty($values['username'])) {
        	
            $this->getTemplateAdapter()->put('username-failed', 'обязательное поле');            
            $valid = false;
        }
        
        if (empty($values['user_info'])) {
        	
            $this->getTemplateAdapter()->put('pay-info-failed', 'обязательное поле');
            $valid = false;
        }    
        
        
        $where = '`email` = \''.$values['email'].'\'';
        $is_exists = $this->UsersModel->getUsers(0, 1, $where);
        if(count($is_exists) > 0) {
        	$this->getTemplateAdapter()->put('email-failed', 'Пользователь с таким e-mail уже зарегистрирован');
            $valid = false;
        }
    
        return $valid;
    }
    
	 public function getPaySystInfoAsync() {
        $payment_systems = $this->PaymentsModel->getPaymentSystems();
        if(!isset($_GET['id'])) {
        	$id = 1;
        }
        else {
        	$id = $_GET['id'];
        }
        if($payment_systems[$id]['amount'] != 0) {
	       	$str = '';
	        if(!$payment_systems[$id]['percent']) {
	        	$str .= '$';
	        }
	        $str .= $payment_systems[$_GET['id']]['amount'];
		 	if($payment_systems[$id]['percent']) {
	        	$str .= '%';
	        }
        }
        else {
        	$str = 'contact support';    
        }
        echo $str;
        die();
    }
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>