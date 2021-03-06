<?php
require_once '../lib/Database/Adapter/Abstract.php';

class DatabaseAdapterMysql extends DatabaseAdapterAbstract {
	private $_connection;
	
	public function __construct(Config $config) {		
	    parent::__construct($config);
		$this->getConnection();			
	}
	
	public function getConnection() {
	    $config = $this->getCongif();
		if (empty($this->_connection)) {

			$connection = @mysql_connect($config->host, $config->user, 
			    $config->pass) or die(mysql_error());
			@mysql_select_db($config->db, $connection) or die(mysql_error($connection));
			$this->_connection = $connection;
			$this->query("set character_set_client='" . $config->character_set_client. "'", $this->_connection);
			$this->query("set character_set_results='". $config->character_set_results."'", $this->_connection);		
			$this->query("set collation_connection='" . $config->collation_connection. "'", $this->_connection);		
		}	
		return $this->_connection;		
	}
	
	public function query($sql) {
		$connection = $this->getConnection();	
      	$statement = @mysql_query($sql, $connection) or die($sql." - ".mysql_error());     	
      	return $statement;
	}	
		
	public function fetchAll($statement) {
		$rows = array();
		while ($row = $this->fetchRow($statement)) {
			$rows[] = $row;
		}
		return $rows;		
	}
	
	public function fetchRow($statement) {
		$row = mysql_fetch_array($statement, MYSQL_ASSOC);
		if (is_array($row)) {
			foreach ($row as $key => $value) {
				$row[$key] = str_replace('\\', '', $row[$key]);				
			}		
		}
		return $row;
	}
	
	public function save($table, array $values, $id = null) {
	    return !$id?$this->insert($table, $values):$this->update($table, $values, $id);
	}
	
	public function load($table, $id) {
	    $sql = 'SELECT * FROM `'.$table.'` WHERE '.$id['field'].' = \''.$id['value'].'\'';
	    $statement = $this->query($sql);
	    return $this->fetchRow($statement);	    
	}
	
	public function insert($table, array $values) {
        $sql = 'INSERT INTO `'.$table.'` SET ';
        foreach ($values as $key => $value) {
            $sql .= '`'.$key.'` = \''.addslashes($value).'\', ';   	  	      	
        }
        
        $sql = substr($sql, 0, strlen($sql)-2);      
        $this->query($sql);
        //echo $sql;
        return mysql_insert_id($this->getConnection());
	}
	
	public function update($table, array $values, $id) {
        $sql = 'UPDATE `'.$table.'` SET ';
        foreach ($values as $key => $value) {
             $sql .= '`'.$key.'` = \''.$value.'\', ';   	  	      	
		}
        $sql = substr($sql, 0, strlen($sql)-2);
        $sql .= ' WHERE '.$id['field'].' = \''.$id['value'].'\'';
        return $this->query($sql);
	}
	
	public function replace($table, array $values) {
		$sql = 'REPLACE INTO `'.$table.'` SET ';
        foreach ($values as $key => $value) {
             $sql .= '`'.$key.'` = \''.$value.'\', ';   	  	      	
		}
        $sql = substr($sql, 0, strlen($sql)-2);		
        return $this->query($sql);
	}
	
	public function remove($table, $id) {
        $sql = 'DELETE FROM `'.$table.'` WHERE `'.$id['field'].'` = \''.$id['value'].'\'';
        return $this->query($sql);        
	}	
}

?>