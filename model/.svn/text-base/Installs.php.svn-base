<?php
require_once '../lib/Database/Adapter/Abstract.php';

//---------------------- libs -----------------
require_once '../lib/Config.php';
require_once '../lib/Config/Database.php';
//---------------------- models ---------------
require_once '../model/Users.php';

class InstallsModel {
    private $_adapter;
    
    private $_aff;
    private $_amount;
    private $_clicks;
    
    private $_installs = false;
        
    private $_tag;
    
    private $_config;
    private $_user;
    
    private $UsersModel;
    
    public function __construct(DatabaseAdapterAbstract $adapter) {
        $this->_adapter = $adapter;
        $this->_config  = new Config(ConfigDatabase::load($this->_adapter));
        
        $this->UsersModel = new UsersModel($this->_adapter);
    }
    
    function _xmls($parser, $name, $attrs) {
        switch ($name) {
            case 'AFF':
                $this->_aff  = $attrs['VALUE'];                
                $this->_user = $this->UsersModel->getUserByExtuid($this->_aff);
                break;
            case 'INSTALLS':
                $this->_installs = true;
                break;
        }
        $this->_tag = $name;        
    }    

    function _xmle($parser, $name) {
        switch ($name) {
            case 'AFF':
                //save payments
                if ($this->_user) {
                    $values = array(
						'user' => $this->_user['id'],
						'date' => date('Y-m-d'),
						'clicks_real' => $this->_clicks,
						'amount_real' => $this->_amount,
						'clicks_revshare' => $this->_clicks - ($this->_clicks*$this->_config->revshare_clicks),
						'amount_revshare' => $this->_amount - ($this->_amount*$this->_config->revshare_money));
						
                    $sql = 'SELECT `id` FROM `payments-stat`
						WHERE 
						`user` = \''.$this->_user['id'].'\' AND
						`date` = \''.date('Y-m-d').'\'';
                    $statemet = $this->_adapter->query($sql);
                    $id = null;
                    if(($row = $this->_adapter->fetchRow($statemet))) {
                        $id = array('field' => 'id', 'value' => $row['id']);
                    } 
                    $this->_adapter->save('payments-stat', $values, $id);
                }
                $this->_installs = false;                
                $this->_user   = null;                
                $this->_amount = 0;                
                $this->_clicks = 0;
                $this->_aff    = 0;
                
                break;
            case 'INSTALLS':
                $this->_installs = false;                
                break;
        }
    }
    
    function _xmlcd($parser, $data) {
        switch ($this->_tag) {
            case 'CLICKS':
                $this->_clicks = trim($data);
                break;
            case 'AMOUNT':
                $this->_amount = trim($data);
                break;                
        }
        if ($this->_installs && ($this->_tag != 'INSTALLS')) {
            //save installs
            if ($this->_user) {
                $values = array(
                    'user' => $this->_user['id'],
                    'date' => date('Y-m-d'),
                    'country' => $this->_tag,
                    'installs' => $data);
                $sql = 'SELECT `id` FROM `installs-stat`
					WHERE 
						`user` = \''.$this->_user['id'].'\' AND
						`date` = \''.date('Y-m-d').'\' AND
						`country` = \''.$this->_tag.'\'';
                $statemet = $this->_adapter->query($sql);
                $id = null;
                if(($row = $this->_adapter->fetchRow($statemet))) {
                    $id = array('field' => 'id', 'value' => $row['id']);
                }     
                $this->_adapter->save('installs-stat', $values, $id);
            }
        }
    }
    
    public function track() {
        $url = 'http://cashwrestler.com/xml.php?key=08c0fb9c3a101cc2465bfd3ceb77f8d5&date_from='.date('Y-m-d').'&date_to='.date('Y-m-d');
        $ch = curl_init($url);
		    curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
			curl_setopt($ch, CURLOPT_TIMEOUT, 3);            
        $xml = @curl_exec($ch);
        $xml = explode("\n", $xml);
        for ($i = 0, $count = count($xml); $i < $count; $i++) {
            $xml[$i] = trim($xml[$i]);
        }
        $xml = implode('', $xml);
        $xml = preg_replace("/\n/", '', $xml);
        curl_close($ch);        
        $parser = xml_parser_create();
        xml_set_object($parser, &$this);          
        xml_set_element_handler($parser, '_xmls', '_xmle');        
        xml_set_default_handler($parser, "_xmlcd");        

        xml_set_character_data_handler($parser, '_xmlcd');
        xml_parse($parser, $xml);
        xml_parser_free($parser); 
    } 

    public function getTodayInstalls($where = null) {
        $sql = 'SELECT SUM(`installs`) AS sum 
			FROM `installs-stat`	
			WHERE `installs-stat`.`date` = \''.date('Y-m-d').'\'
			'.($where?' AND '.$where:'').'
		';
        $statement = $this->_adapter->query($sql);
        $row = $this->_adapter->fetchRow($statement);
        return $row['sum'];
    }
    
    public function getTodayClicks($where = null) {
        $sql = 'SELECT 
				SUM(`clicks_real`) AS clicks_real,
				SUM(`clicks_revshare`) AS clicks_revshare
			FROM `payments-stat`	
			WHERE `payments-stat`.`date` = \''.date('Y-m-d').'\'
			'.($where?' AND '.$where:'').'
			GROUP BY `date`, `user`
		';
        $statement = $this->_adapter->query($sql);
        $row = $this->_adapter->fetchRow($statement);
        return $row;        
    }
    
    public function getTodayMoney($where = null) {
        $sql = 'SELECT 
				SUM(`amount_real`) AS amiunt_real,
				SUM(`amount_revshare`) AS amount_revshare
			FROM `payments-stat`	
			WHERE `payments-stat`.`date` = \''.date('Y-m-d').'\'
			'.($where?' AND '.$where:'').'
			GROUP BY `date`, `user`
		';
        $statement = $this->_adapter->query($sql);
        $row = $this->_adapter->fetchRow($statement);
        return $row;        
    }
    
    public function getPPInstalls($where = null) {
        $day = date('j');        
        if ($day <= 15) {
            $from = date('Y-m-01');
        } else if ($day > date('t')) {
            $from = date('Y-m-16');            
        } else die('...'); 
        $to = date('Y-m-d'); 
        
        $sql = 'SELECT SUM(`installs`) AS sum 
			FROM `installs-stat`	
			WHERE 
				`date` >= \''.$from.'\' AND
				`date` <= \''.$to.'\'
			'.($where?' AND '.$where:'').'
		';
        $statement = $this->_adapter->query($sql);
        $row = $this->_adapter->fetchRow($statement);
        return $row['sum'];        
    }
    
    public function getPPClicks($where = null) {
        $day = date('j');        
        if ($day <= 15) {
            $from = date('Y-m-01');
        } else if ($day > date('t')) {
            $from = date('Y-m-16');            
        } else die('...'); 
        $to = date('Y-m-d'); 
        
        $sql = 'SELECT 
				SUM(`clicks_real`) AS clicks_real,
				SUM(`clicks_revshare`) AS clicks_revshare
			FROM `payments-stat`	
			WHERE 
				`date` >= \''.$from.'\' AND
				`date` <= \''.$to.'\'
			'.($where?' AND '.$where:'').'
			GROUP BY `date`, `user`
		';
        $statement = $this->_adapter->query($sql);
        $row = $this->_adapter->fetchRow($statement);
        return $row;        
    }
}
?>