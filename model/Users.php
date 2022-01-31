<?php
require_once '../lib/Database/Adapter/Abstract.php';

//---------------------- libs -----------------

class UsersModel {
    private $_adapter;
    
    public function __construct(DatabaseAdapterAbstract $adapter) {
        $this->_adapter = $adapter;
    }
    
    public function getUsersCnt($where = null) {
        $sql = 'SELECT COUNT(id) AS cnt 
			FROM `users` 
			'.($where?' WHERE '.$where:'').'
		';        
	    $statement = $this->_adapter->query($sql);
	    $row = $this->_adapter->fetchRow($statement);
	    return $row['cnt'];          
    }
    
    public function getUsers($from, $to, $where = null, $order = 'id DESC') {
        $sql = 'SELECT * FROM `users` 
			'.($where?' WHERE '.$where:'').'
			'.($order?' ORDER BY '.$order:'').'
			LIMIT '.$from.', '.$to.'
		';
        $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchAll($statement);            
    }    
    
    public function saveUser(array $values, $id = null) {
        if ($id) {
            $id = array('field' => 'uid', 'value' => $id);
        }
        return $this->_adapter->save('users', $values, $id);
    }
    
	public function loadUserByLoginData($login, $password) {
        $sql = 'SELECT * FROM `users`
			WHERE 
				`username` = \''.$login.'\' AND
				`password` = \''.$password.'\' AND			
				`is_active` = 1
		';
        $statement = $this->_adapter->query($sql);
        return $this->_adapter->fetchRow($statement);
    }
    
    public function loadUserByUid($uid) {
		$row = $this->_adapter->load('users', array('field' => 'uid', 'value' => $uid));
        return $row;
    }    

    public function getUserById($id) {
    	
        $row = $this->_adapter->load('users', array('field' => 'id', 'value' => $id));
        return $row;
    }  

    public function getUserByExtuid($id) {
        $sql = 'SELECT * FROM `users` 
			WHERE `extuid1` = \''.$id.'\' OR `extuid2` = \''.$id.'\'';
        $statement = $this->_adapter->query($sql);        
        
        return $this->_adapter->fetchRow($statement);
    }
    
    public function setLastAccess($uid) {
        $sql = 'UPDATE `users` SET `last_access` = NOW() WHERE `uid` = \''.$uid.'\'';
        $statement = $this->_adapter->query($sql);
        return true;
    }    

    public function getTested($id_chapter) {
    	$sql = 'SELECT `users_answers`.*, 
					   `users`.`id`,
					   `users`.`username`
				FROM `users_answers`, `users`
				WHERE `users_answers`.`id_chapter` = '.$id_chapter.' 
				AND `users_answers`.`uid` = `users`.`uid`';
    	$statement = $this->_adapter->query($sql);        
        return $this->_adapter->fetchAll($statement);
    	
    }
    
	public function getNotTested($id_chapter) {
		$sql = 'SELECT `users`.*
				FROM `users`
				WHERE `users`.`uid` NOT IN (SELECT `uid` FROM `users_answers` WHERE `id_chapter` = '.$id_chapter.')';
    	$statement = $this->_adapter->query($sql);        
        return $this->_adapter->fetchAll($statement);

    }
    
   
}

?>