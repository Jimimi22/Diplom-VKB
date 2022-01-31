<?php
require_once '../controller/Root.php';

//---------------------- libs -----------------
//---------------------- models ---------------
require_once '../model/Users.php';
require_once '../model/Installs.php';
require_once '../model/Messages.php';
require_once '../model/Payments.php';

abstract class MemberController extends RootController {	
    private $UsersModel;
    
    private $_user;
    
	public function __construct(Config $config) {
	    $config->thm = 'themes/member/theme.tpl.php';	    	    
        parent::__construct($config);	
        
        $this->UsersModel = new UsersModel($this->getDatabaseAdapter());        
	}	
	
    public function process($command, array $args = array()) {
    	$uid = Filter::getStrval($_SESSION, 'uid');
    	if (!$uid) {    		
    		$uid = Filter::getStrval($_COOKIE, 'uid');
    	} 
    	
    	if ($uid 
    	    && ($user = $this->UsersModel->loadUserByUid($uid))) {
    	    $_SESSION['uid'] = $user['uid'];    	        
    	    $this->_user = $user;
    	    
    	    $this->getTemplateAdapter()->put('_USER', $this->_user);
    	    
    	    
      	    $MessageModel = new MessagesModel($this->getDatabaseAdapter());
      	    $where = '`to` = \''.$user['id'].'\'';
      	    $messages = $MessageModel->getInboxMessagesCnt($where);
      	    $this->getTemplateAdapter()->put('_INBOX_MESSAGES', $messages);
      	    
      	    
            parent::process($command, $args);        	        
    	} else 
    	    $this->redirect('/public/index.php?cmd=index');
    }
    
    public function getUser() {
        return $this->_user;
    }

    public function doLogoutCmd() {
        session_unset();
        session_destroy();
        setcookie('uid', null, 0, '/');
        $this->redirect('?cmd=index');        
    }
}

?>