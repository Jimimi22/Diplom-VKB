<?php
require_once '../lib/Database/Adapter/Abstract.php';

//---------------------- libs -----------------

class DisModel {
    private $_adapter;
    
    public function __construct(DatabaseAdapterAbstract $adapter) {
        $this->_adapter = $adapter;
    }
    
    public function getDisCnt($where = null) {
        $sql = 'SELECT COUNT(id) AS cnt 
			FROM `disciplines` '.($where?' WHERE '.$where:'');
	    $statement = $this->_adapter->query($sql);	    
	    $row = $this->_adapter->fetchRow($statement);
	    return $row['cnt'];        
    }
    
    public function getDis($from, $to, $where = null, $order = '`id` DESC') {
        $sql = 'SELECT * FROM `disciplines` 
			'.($where?' WHERE '.$where:'').'
			'.($order?' ORDER BY '.$order:'').'
			LIMIT '.$from.', '.$to;        
	    $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchAll($statement);        
    }
    
    public function getDisById($id) {
        $item = $this->_adapter->load('disciplines', array('field' => 'id', 'value' => $id));
        return $item;
    }
    
    public function rmDis($id) {
        return $this->_adapter->remove('disciplines', 
            array('field' => 'id', 'value' => $id));
    }
    
    public function saveDis(array $values, $id = null) {
        if ($id) {
            $id = array('field' => 'id', 'value' => $id);
        }
        return $this->_adapter->save('disciplines', $values, $id);
    }
    
	public function saveChapter(array $values, $id = null) {
        if ($id) {
            $id = array('field' => 'id', 'value' => $id);
        }
        return $this->_adapter->save('chapters', $values, $id);
    }
    
	public function getChaptersCnt($where = null) {
        $sql = 'SELECT COUNT(id) AS cnt 
			FROM `chapters` '.($where?' WHERE '.$where:'');
	    $statement = $this->_adapter->query($sql);	    
	    $row = $this->_adapter->fetchRow($statement);
	    return $row['cnt'];        
    }
    
    public function getChapters($from, $to, $where = null, $order = '`id` DESC') {
        $sql = 'SELECT * FROM `chapters` 
			'.($where?' WHERE '.$where:'').'
			'.($order?' ORDER BY '.$order:'').'
			LIMIT '.$from.', '.$to;        
	    $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchAll($statement);        
    }
    
	 public function getChapterById($id) {
	 	$item = $this->_adapter->load('chapters', array('field' => 'id', 'value' => $id));
        return $item;
    }
    
	public function rmChapter($id) {
        return $this->_adapter->remove('chapters', 
            array('field' => 'id', 'value' => $id));
    }
    
    public function saveQuestion(array $values, $id) {
    	if ($id) {
    		$id = array('field' => 'id', 'value' => $id);
        }
        return $this->_adapter->save('questions', $values, $id);
    }	
    
    public function saveAnswer($answer, $id_question, $is_wright) {
    	$values['answer'] = $answer;
    	$values['id_question'] = $id_question;
    	$values['is_wright'] = $is_wright;
    	return $this->_adapter->save('answers', $values, '');
    }
    
    public function getAnswersByQuestId($id_quest) {
        $sql = 'SELECT * FROM `answers` WHERE `id_question` = '.$id_quest.' ORDER BY id ASC';        
	    $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchAll($statement);        
    }
    
	public function getQuestionById($id_quest) {
        $sql = 'SELECT * FROM `questions` WHERE `id` = '.$id_quest;        
	    $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchAll($statement);        
    }
    
	public function rmAnswers($id_quest) {
        $sql = 'DELETE FROM `answers` WHERE `id_question` = '.$id_quest;        
	    $statement = $this->_adapter->query($sql);
	    
    }
    
	public function rmQuest($id_quest) {
        $sql = 'DELETE FROM `questions` WHERE `id` = '.$id_quest;        
	    $statement = $this->_adapter->query($sql);
	    
    }
    
	
    /*
    public function saveAnswers(array $values, $id_quest) {
    	$id = '';
    	foreach ($values as $key=>$value) {
       		$this->_adapter->save('answers', $values, $id);
    	}	
		return true;
    }
	
    */
    
}

?>