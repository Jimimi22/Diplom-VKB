<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Member.php';

//---------------------- libs -----------------
require_once '../lib/Ui/Pager.php';
require_once '../lib/Mail/class.phpmailer.php';
//---------------------- models ---------------
require_once '../model/Messages.php';
require_once '../model/Users.php';

class Controller extends MemberController {
    private $MessagesModel;
    private $UsersModel;
    
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->MessagesModel = new MessagesModel($this->getDatabaseAdapter());
        $this->UsersModel = new UsersModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title, $template) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'support');
        return $this->getTemplateAdapter()->render('member/support/'.$template);
    }
    
    public function indexCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        $user  = $this->getUser();
                
        /** view */
        if ($id 
            && ($item = $this->MessagesModel->getInboxMessageById($id)) 
            && ($item['to'] == $user['id'])) {
            $this->getTemplateAdapter()->pass($item);
            return $this->IndexTheme('Support', 'view-inbox.tpl.php');             
        } elseif ($id) {
            $this->addMessage('Сообщения не найдены', self::$ERROR);
            $this->redirect('?cmd=index');
        }
        /** end */
        
        $where = '`messages`.`to` = \''.$user['id'].'\'';        
        $count = $this->MessagesModel->getInboxMessagesCnt($where);
	    $Pager = new Pager($count, $this->getConfig()->pager->onpage);
        $page  = $Pager->current(Filter::getIntval($_REQUEST, 'page', 
            Pager::$_FIRST));  	      

        $items = $this->MessagesModel->getInboxMessages($Pager->index($page), 
	        $this->getConfig()->pager->onpage, $where);
	        
	    $this->getTemplateAdapter()->put('items', $items);    	    
   	    $this->getTemplateAdapter()->put('count', $count);	    
	    $this->getTemplateAdapter()->put('page',  $page);
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());        
        return $this->IndexTheme('Support', 'inbox.tpl.php');        
    }
    
    public function outboxCmd() {        
        $id = Filter::getIntval($_REQUEST, 'id');
        $user  = $this->getUser();
                
        /** view */
        if ($id 
            && ($item = $this->MessagesModel->getOutboxMessageById($id)) 
            && ($item['from'] == $user['id'])) {
            $this->getTemplateAdapter()->pass($item);
            return $this->IndexTheme('Support', 'view-outbox.tpl.php');             
        } elseif ($id) {
            $this->addMessage('Сообщение не найдено', self::$ERROR);
            $this->redirect('?cmd=index');
        }
        /** end */
        
        $where = '`messages`.`from` = \''.$user['id'].'\'';        
        $count = $this->MessagesModel->getOutboxMessagesCnt($where);
	    $Pager = new Pager($count, $this->getConfig()->pager->onpage);
        $page  = $Pager->current(Filter::getIntval($_REQUEST, 'page', 
            Pager::$_FIRST));  	      

        $items = $this->MessagesModel->getOutboxMessages($Pager->index($page), 
	        $this->getConfig()->pager->onpage, $where);
	        
	    $this->getTemplateAdapter()->put('items', $items);    	    
   	    $this->getTemplateAdapter()->put('count', $count);	    
	    $this->getTemplateAdapter()->put('page',  $page);
	    $this->getTemplateAdapter()->pass($this->getConfig()->pager->toArray());        
        return $this->IndexTheme('Support', 'outbox.tpl.php');        
    }
    
    public function composeCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        $user  = $this->getUser();        
        if ($id 
            && ($item = $this->MessagesModel->getInboxMessageById($id)) 
            && ($item['to'] == $user['id'])) { // replu case
            $item['subj'] = 'Re: '.$item['subj'];
            $array = explode("\n", $item['message']);
            for ($i = 0, $count = count($array); $i < $count; $i++) {
                $array[$i] = '> '.$array[$i];
            } $item['message'] = implode("\n", $array);
            
            $item['to'] = $item['from'];
            $this->getTemplateAdapter()->pass($item);
        } elseif ($id) {
            $this->addMessage('Сообщение не найдено', self::$ERROR);
            $this->redirect('?cmd=index');
        }
        
        return $this->IndexTheme('Support', 'edit.tpl.php');        
    }
        
    public function doComposeCmd() {
        $user = $this->getUser();
        $values = array(
            'subj' => Filter::getStrval($_REQUEST, 'subj'),
            'message' => FIlter::getStrval($_REQUEST, 'message'),
            'from' => $user['id'],
            'posted' => date('Y-m-d'),
            'to' => Filter::getIntval($_REQUEST, 'to'));
                        
        if ($this->ValidateComposeForm($values)) {
            $where = '`is_admin` = 1';
            $PHPMailer = new PHPMailer();
            $PHPMailer->ContentType = 'text/html';
            $PHPMailer->CharSet = 'utf-8';           
            $PHPMailer->From = $user['email'];      
            $PHPMailer->FromName = $user['first_name'].' '.$user['last_name'];
            
            $PHPMailer->Subject = $values['subj'];            
            $this->getTemplateAdapter()->pass($values);
            $PHPMailer->Body = $this->getTemplateAdapter()->render('emails/inbox.tpl.php'); 

            $users = $this->UsersModel->getUsers(0, $this->UsersModel->getUsersCnt($where), $where);            
            if (($to = $this->UsersModel->getUserById($values['to']))
                && ($to['is_admin'] == 1)) { // reply case
                $this->MessagesModel->saveMessage($values);
                $PHPMailer->AddAddress($to['email']);                                
            } else { // compose case
                for ($i = 0, $count = count($users); $i < $count; $i++) {
                    $values['to'] = $users[$i]['id'];
                    $this->MessagesModel->saveMessage($values);
                    $PHPMailer->AddAddress($users[$i]['email']);                
                }            
            }
            
            $PHPMailer->Send();                        
            $this->addMessage('Сообщение отправлено', self::$NOTIF);
            $this->redirect('?cmd=outbox');
        }
        $this->getTemplateAdapter()->pass($values);
        return $this->IndexTheme('Support', 'edit.tpl.php');  
    }
    
    public function doRemoveInboxCmd() {
        $id = Filter::getIntval($_REQUEST, 'id');
        $user = $this->getUser();
        if (($item = $this->MessagesModel->getInboxMessageById($id)) 
            && ($item['to'] == $user['id'])) {
            $this->MessagesModel->rmMessage($id);
            $this->addMessage('Изменения сохранены', self::$NOTIF);                        
        } else $this->addMessage('Message not found', self::$ERROR);
        $this->redirect('?cmd=index');        
    }
    
    private function ValidateComposeForm(array $values) {
        $valid = true;
        if (empty($values['subj'])) {
            $this->getTemplateAdapter()->put('subj-failed', 'required field');            
            $valid = false;
        }
        if (empty($values['message'])) {
            $this->getTemplateAdapter()->put('message-failed', 'required field');
            $valid = false;
        }     
        return $valid;
    }
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>