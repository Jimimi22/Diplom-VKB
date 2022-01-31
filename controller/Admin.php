<?php
require_once '../controller/Root.php';

//---------------------- libs -----------------
//---------------------- models ---------------
require_once '../model/Users.php';

abstract class AdminController extends RootController {	
    private $UsersModel;
    
    private $_user;
    
	public function __construct(Config $config) {
	    $config->thm = 'themes/admin/theme.tpl.php';	    	    
        parent::__construct($config);	
        
        $this->UsersModel = new UsersModel($this->getDatabaseAdapter());        
	}	
	
    public function process($command, array $args = array()) {
    	$uid = Filter::getStrval($_SESSION, 'uid');
    	if (!$uid) {    		
    		$uid = Filter::getStrval($_COOKIE, 'uid');
    	} 
    	
    	if ($uid 
    	    && ($user = $this->UsersModel->loadUserByUid($uid))
    	    && ($user['is_admin'])) {
    	    $_SESSION['uid'] = $user['uid'];    	        
    	    $this->_user = $user;
    	    
    	    $this->getTemplateAdapter()->put('_USER', $this->_user);
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