<?php
require_once '../lib/Database/Adapter/Abstract.php';

//---------------------- libs -----------------
//---------------------- models ---------------

class ShoutboxModel {
    private $_adapter;
    
    public function __construct(DatabaseAdapterAbstract $adapter) {
        $this->_adapter = $adapter;
    }
    
    public function getMessagesCnt($where = null) {
        $sql = 'SELECT COUNT(`shoutbox`.`id`) AS cnt 
			FROM `shoutbox` 
		'.($where?' WHERE '.$where:'');
	    $statement = $this->_adapter->query($sql);	    
	    $row = $this->_adapter->fetchRow($statement);
	    return $row['cnt'];        
    }
    
    public function getMessages($from, $to, $where = null, $order = '`date` ASC') {
        $sql = 'SELECT `shoutbox`.*
			FROM `shoutbox`
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
        return $this->_adapter->save('shoutbox', $values, $id);
    }    
}

?>