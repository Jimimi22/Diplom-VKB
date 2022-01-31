<?php
require_once '../lib/Database/Adapter/Abstract.php';

//---------------------- libs -----------------

class TestsModel {
    private $_adapter;
    
    public function __construct(DatabaseAdapterAbstract $adapter) {
        $this->_adapter = $adapter;
    }
    
    public function getRandomQuestion ($where = null) {
    	$sql = 'SELECT * FROM `questions` 
			'.($where?' WHERE '.$where:'').'
			ORDER BY RAND() LIMIT 0,1
		';
    	//echo $sql;
    	$statement = $this->_adapter->query($sql);
        $question = $this->_adapter->fetchRow($statement);        
        return $question;        
    }
    
 	public function getRandomQuestionCnt ($where = null) {
    	$sql = 'SELECT COUNT(`id`) AS `cnt` FROM `questions` 
			'.($where?' WHERE '.$where:'').'
		';
    	
    	$statement = $this->_adapter->query($sql);
        $question = $this->_adapter->fetchRow($statement);        
        return $question['cnt'];        
    }
    
   
    public function getQuestions($where = null, $order = '`id` DESC') {
        $questins = array();
    	$sql = 'SELECT * FROM `questions` 
			'.($where?' WHERE '.$where:'').'
			'.($order?' ORDER BY '.$order:'');    
    	
        $statement = $this->_adapter->query($sql);
        $questions = $this->_adapter->fetchAll($statement);        
        foreach ($questions as $key=>$value) {
        	$sql = 'SELECT * FROM `answers` WHERE `id_question` = '.$value['id'].' ORDER BY `id` ASC';
			$statement = $this->_adapter->query($sql);	
			$questions[$key]['answers'] = $this->_adapter->fetchAll($statement);        
	    }
	    return $questions;        
    }
    
	public function saveAnswers(array $values, $id = null) {
        if ($id) {
            $id = array('field' => 'uid', 'value' => $id);
        }
         
        return $this->_adapter->save('users_answers', $values, $id);
    }
    
	public function rmUserAnswers($uid, $id_chapter) {
        $sql = 'DELETE FROM `users_answers` WHERE `uid` = "'.$uid.'" AND `id_chapter` = '.$id_chapter;
        $this->_adapter->query($sql);
    }
    
	public function addUserAnswers($uid, $id_chapter) {
        //$sql = 'INSERT `users_answers` SET `uid` = "'.$uid.'", `id_chapter` = '.$id_chapter;
        return $this->_adapter->insert('users_answers', array('uid'=>$uid, 'id_chapter'=>$id_chapter));
        
    }
    
	public function updateUserAnswers($uid, $id_chapter, $user_points) {
        $sql = 'UPDATE `users_answers` SET `user_points` = `user_points` + '.$user_points.' WHERE `uid` = "'.$uid.'" AND `id_chapter` = '.$id_chapter;
        $this->_adapter->query($sql);
    }
    
	public function getUserAnswers($uid, $id_chapter) {
        $sql = 'SELECT * FROM `users_answers` WHERE `uid` = "'.$uid.'" AND `id_chapter` = '.$id_chapter;
        $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchAll($statement); 
    }
    
    public function isRightAnswer ($answer, $id_quest) {
    	$sql = 'SELECT COUNT(`id`) AS `cnt`  FROM `questions` WHERE `wright_answ` LIKE "'.$answer.'" AND `id` = '.$id_quest;
    	$statement = $this->_adapter->query($sql);
    	$row = $this->_adapter->fetchRow($statement);
    	return $row['cnt'];
    }	
    
	public function getPoints() {
        $sql = 'SELECT * FROM `points_limit` WHERE `id` = 1';
        $statement = $this->_adapter->query($sql);
	    $row = $this->_adapter->fetchRow($statement); 
	    return $row['points'];
    }
    
    public function getTestsResults() {
    	$sql = 'SELECT `users_answers`.*, 
					   `users`.`username`,
            		   `users`.`first_name`,
					   `users`.`last_name`,
					   `chapters`.`chapter`,
					   `disciplines`.`discipline`
				FROM `users_answers`, `users`, `chapters`, `disciplines`
				WHERE `users_answers`.`uid` = `users`.`id` AND
   					  `users_answers`.`id_chapter` = `chapters`.`id` AND
					  `chapters`.`id_dis` = `disciplines`.`id`
				GROUP BY `users_answers`.`id`
				ORDER BY `users_answers`.`id` DESC
		';
    	$statement = $this->_adapter->query($sql);
        $question = $this->_adapter->fetchAll($statement);        
        return $question;        
    }
    
	public function getUserTestsResults($uid, $answer_id) {
    	$sql = 'SELECT `users_answers`.*, 
					   `users`.`username`,
            		   `users`.`first_name`,
					   `users`.`last_name`,
					   `chapters`.`chapter`,
					   `disciplines`.`discipline`
				FROM `users_answers`, `users`, `chapters`, `disciplines`
				WHERE `users_answers`.`uid` = '.$uid.' AND
          			  `users_answers`.`id` = '.$answer_id.' AND
					  `users_answers`.`uid` = `users`.`id` AND
   					  `users_answers`.`id_chapter` = `chapters`.`id` AND
					  `chapters`.`id_dis` = `disciplines`.`id`
				GROUP BY `users_answers`.`id`
				ORDER BY `users_answers`.`id` DESC
		';
    	$statement = $this->_adapter->query($sql);
        $question = $this->_adapter->fetchRow($statement);        
        return $question;        
    }
    
	public function updatePoints($points) {
        $sql = 'UPDATE `points_limit` SET `points`='.$points.' WHERE `id` = 1';
        $statement = $this->_adapter->query($sql);
	    return true;
    }
    
}

?>