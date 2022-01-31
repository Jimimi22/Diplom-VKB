<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Public.php';

//---------------------- libs -----------------
require_once '../lib/Mail/class.phpmailer.php';
//---------------------- models ---------------
require_once '../model/News.php';

class Controller extends PublicController {
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->NewsModel = new NewsModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }
    
    public function IndexTheme($title) {
    	$where = '';
    	$count = $this->NewsModel->getNewsCnt($where);
    	$items = $this->NewsModel->getNews(0, $count, $where);
    	$this->getTemplateAdapter()->put('news', $items);
        $this->getTemplateAdapter()->put('_MENUITEM', 'contacts');
        return $this->getTemplateAdapter()->render('public/contacts.tpl.php');
    }
    
    public function indexCmd() {
        return $this->IndexTheme('Contacts');
    }
    
    public function doSendCmd() {
        $values = array(
            'email' => Filter::getEmail($_REQUEST, 'email'),
            'fname' => Filter::getStrval($_REQUEST, 'fname'),
            'lname' => Filter::getStrval($_REQUEST, 'lname'),                        
            'subj'  => Filter::getStrval($_REQUEST, 'subj'),
            'message' => Filter::getStrval($_REQUEST, 'message')
        );
       
        if ($this->ValidateSendForm($values)) {
            $PHPMailer = new PHPMailer();
            $PHPMailer->ContentType = 'text/html';
            $PHPMailer->CharSet = 'utf-8';           
            $PHPMailer->From = $values['email'];      
            $PHPMailer->FromName = $values['fname'].' '.$values['lname'];
            
            $PHPMailer->Subject = $values['subj'];            
            $this->getTemplateAdapter()->pass($values);
            $PHPMailer->Body = $this->getTemplateAdapter()->render('emails/contacts.tpl.php'); 
            $PHPMailer->AddAddress($this->getConfig()->email);
            $PHPMailer->Send();
            
            $this->addMessage('Ваше сообщение отправлено', self::$NOTIF);
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
        if (empty($values['subj'])) {
            $this->getTemplateAdapter()->put('subj-failed', 'обязательное поле');            
            $valid = false;
        }
        if (empty($values['fname'])) {
            $this->getTemplateAdapter()->put('fname-failed', 'обязательное поле');                        
            $valid = false;
        }        
        if (empty($values['lname'])) {
            $this->getTemplateAdapter()->put('lname-failed', 'обязательное поле');
            $valid = false;
        }        
        if (empty($values['message'])) {
            $this->getTemplateAdapter()->put('message-failed', 'обязательное поле');
            $valid = false;
        }        
        return $valid;
    }
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>