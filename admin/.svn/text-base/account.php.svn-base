<?php
//---------------------- required -------------
require_once '../controller/boot.php';
require_once '../controller/Admin.php';

//---------------------- libs -----------------
//---------------------- models ---------------
require_once '../model/Users.php';

class Controller extends AdminController {
    private $UsersModel;
    
    public function __construct(Config $config) {
        parent::__construct($config);
        $this->UsersModel = new UsersModel($this->getDatabaseAdapter());
    }
    
    public function init(Config $config) {
        parent::init($config);
    }    
    
    public function IndexTheme($title) {
        $this->getTemplateAdapter()->put('_MENUITEM', 'settings');
        return $this->getTemplateAdapter()->render('admin/users/edit_admin.tpl.php');
    }
    
    public function indexCmd() {
    	$where = null;        
        $user_data = $this->UsersModel->loadUserByUid($_SESSION['uid']);
        $this->getTemplateAdapter()->put('action', 'Update account');		   
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
            'last_name' => Filter::getStrval($_REQUEST, 'last_name')
        );
        if ($this->ValidateForm($values)) {
			unset($values['password1']);
        	if ($this->UsersModel->saveUser($values, $id)) {
        		$this->addMessage('Your account has been updated', self::$NOTIF);
        	}
            $this->redirect('?cmd=index');
        }
        $this->getTemplateAdapter()->pass($values);
        return $this->indexCmd();
    }
    
    private function ValidateForm(array $values) {
        $valid = true;
        if (empty($values['email'])) {
            $this->getTemplateAdapter()->put('email-failed', 'invalid value');
            $valid = false;
        }
        if (empty($values['username'])) {
            $this->getTemplateAdapter()->put('username-failed', 'required field');            
            $valid = false;
        }
        
        if (empty($values['password']) || ($values['password'] != $values['password1'])) {
            $this->getTemplateAdapter()->put('password-failed', 'enter the new password in both fields.');
            $valid = false;
        }  
       
        return $valid;
    }
}

//---------------------- required -------------
require_once '../controller/dispatcher/default.php';
?>