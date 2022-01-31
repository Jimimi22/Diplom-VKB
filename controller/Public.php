<?php
require_once '../controller/Root.php';
require_once '../model/Users.php';

abstract class PublicController extends RootController {
    private $UsersModel;
        	
	public function __construct(Config $config) {
        parent::__construct($config);	
        $this->UsersModel = new UsersModel($this->getDatabaseAdapter());
	}
	
	public function doSigninCmd() {
	    $values = array(
	        'login' => Filter::getStrval($_REQUEST, 'login'),
	        'password' => Filter::getStrval($_REQUEST, 'password')
	    );
	    if ($this->ValidateSigninForm($values)) {
	    	if($user = $this->UsersModel->loadUserByLoginData($values['login'], $values['password'])) {
				
	    		$_SESSION['uid']   = $user['uid'];
	    		$this->UsersModel->setLastAccess($user['uid']);
	    		if ($user['is_admin']) { // admin case
    	    		$this->redirect('/admin/news.php?cmd=index');	    		    
	    		} else // member case
    	    		$this->redirect('/member/index.php?cmd=index');	    		    	    		
	    	}
	    	else {
	    		$this->addMessage('Пользователь не найден', self::$ERROR);	
	    		$this->redirect('?cmd=index');
	    	}
	        
	    }
	    
	}
	
	public function ValidateSigninForm (array $values) {
	    $valid = true;
	    if (empty($values['login']) 
	        || empty($values['password'])) {
	        $this->addMessage('Неверные данные логина', self::$ERROR);
	        $this->redirect('index.php');	    		    	    		
	        $valid = false;
	    }
	    
	    return $valid;	    
	}
}

?>