<?php
require_once '../lib/Database/Adapter/Abstract.php';

//---------------------- libs -----------------
//---------------------- models ---------------

class MessagesModel {
    private $_adapter;
    
    public function __construct(DatabaseAdapterAbstract $adapter) {
        $this->_adapter = $adapter;
    }
    
    public function getInboxMessagesCnt($where = null) {
        $sql = 'SELECT COUNT(`messages`.`id`) AS cnt 
			FROM `messages` INNER JOIN `users`
			ON `messages`.`from` = `users`.`id`
		'.($where?' WHERE '.$where:'');
	    $statement = $this->_adapter->query($sql);	    
	    $row = $this->_adapter->fetchRow($statement);
	    return $row['cnt'];        
    }
    
    public function getOutboxMessagesCnt($where = null) {
        $sql = 'SELECT COUNT(`messages`.`id`) AS cnt 
			FROM `messages` INNER JOIN `users`
			ON `messages`.`to` = `users`.`id`
		'.($where?' WHERE '.$where:'');
	    $statement = $this->_adapter->query($sql);	    
	    $row = $this->_adapter->fetchRow($statement);
	    return $row['cnt'];        
    }    
    
    public function getInboxMessages($from, $to, $where = null, $order = '`posted` DESC') {
        $sql = 'SELECT `messages`.*,
			`users`.`username`,
			`users`.`first_name`,
			`users`.`last_name`
			FROM `messages` INNER JOIN `users`
			ON `messages`.`from` = `users`.`id`
			'.($where?' WHERE '.$where:'').'
			'.($order?' ORDER BY '.$order:'').'
			LIMIT '.$from.', '.$to;        
	    $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchAll($statement);        
    }
    
    public function getOutboxMessages($from, $to, $where = null, $order = '`posted` DESC') {
        $sql = 'SELECT `messages`.*,
			`users`.`username`,
			`users`.`first_name`,
			`users`.`last_name` 
			FROM `messages` INNER JOIN `users`
			ON `messages`.`to` = `users`.`id`
			'.($where?' WHERE '.$where:'').'
			'.($order?' ORDER BY '.$order:'').'
			LIMIT '.$from.', '.$to;        
	    $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchAll($statement);        
    }
    
    public function saveMessage(array $values, $id = null) {
        if ($id) {
            $id = array('field' => 'id', 'value' => $id);
        }
        return $this->_adapter->save('messages', $values, $id);
    }
    
    public function getInboxMessageById($id) {
        $sql = 'SELECT `messages`.*,
			`users`.`first_name`,
			`users`.`last_name`
			FROM `messages` INNER JOIN `users` ON `messages`.`from` = `users`.`id`
			WHERE `messages`.`id` = \''.$id.'\'';		
	    $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchRow($statement);        
    }
    
    
    public function getOutboxMessageById($id) {
        $sql = 'SELECT `messages`.*,
			`users`.`first_name`,
			`users`.`last_name`
			FROM `messages` INNER JOIN `users` ON `messages`.`to` = `users`.`id`
			WHERE `messages`.`id` = \''.$id.'\'';		
	    $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchRow($statement);        
    }    
    
    public function rmMessage($id) {
        return $this->_adapter->remove('messages', 
            array('field' => 'id', 'value' => $id));
    }
}

?>