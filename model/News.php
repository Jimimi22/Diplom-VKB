<?php
require_once '../lib/Database/Adapter/Abstract.php';

//---------------------- libs -----------------

class NewsModel {
    private $_adapter;
    
    public function __construct(DatabaseAdapterAbstract $adapter) {
        $this->_adapter = $adapter;
    }
    
    public function getNewsCnt($where = null) {
        $sql = 'SELECT COUNT(id) AS cnt 
			FROM `news` '.($where?' WHERE '.$where:'');
	    $statement = $this->_adapter->query($sql);	    
	    $row = $this->_adapter->fetchRow($statement);
	    return $row['cnt'];        
    }
    
    public function getNews($from, $to, $where = null, $order = '`posted` DESC') {
        $sql = 'SELECT * FROM `news` 
			'.($where?' WHERE '.$where:'').'
			'.($order?' ORDER BY '.$order:'').'
			LIMIT '.$from.', '.$to;        
	    $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchAll($statement);        
    }
    
    public function getNewsById($id) {
        $item = $this->_adapter->load('news', array('field' => 'id', 'value' => $id));
        return $item;
    }
    
    public function rmNews($id) {
        return $this->_adapter->remove('news', 
            array('field' => 'id', 'value' => $id));
    }
    
    public function saveNews(array $values, $id = null) {
        if ($id) {
            $id = array('field' => 'id', 'value' => $id);
        }
        return $this->_adapter->save('news', $values, $id);
    }
}

?>