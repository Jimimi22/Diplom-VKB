<?php
require_once '../lib/Database/Adapter/Abstract.php';

//---------------------- libs -----------------
require_once '../lib/Config/Database.php';
require_once '../lib/Config.php';
//---------------------- models ---------------

class PaymentsModel {
    private $_adapter;
    
    public function __construct(DatabaseAdapterAbstract $adapter) {
        $this->_adapter = $adapter;
    }
    
    public function getStat($from, $to) {
        $sql = '
			SELECT `payments-stat`.*, 
				`users`.`username`,
				`users`.`uid`
			FROM `payments-stat`, `users`
			WHERE `payments-stat`.`user` = `users`.`id` AND
			(
			`payments-stat`.`date` >= \''.$from.'\' AND
			`payments-stat`.`date` <= \''.$to.'\'
			)
		';
        $statement = $this->_adapter->query($sql);
        $rows = array();
        while (($row = $this->_adapter->fetchRow($statement))) {
            if (!array_key_exists($row['username'], $rows)) {
                $rows[$row['username']] = array('uid' => $row['uid']);
            }
            $rows[$row['username']][$row['date']] = $row;
            
        }
        return $rows;
    }
    
    public function getMemberPPBallance($id) {
        $day = date('j');        
        if ($day <= 15) {
            $from = date('Y-m-01');
        } else if ($day > date('t')) {
            $from = date('Y-m-16');            
        } else die('...'); 
        $to = date('Y-m-d'); 
        
        $sql = '
			SELECT SUM(amount_revshare) AS sum 
			FROM `payments-stat`
			WHERE `user` = \''.$id.'\' AND 
			`date` >= \''.$from.'\' AND
			`date` <= \''.$to.'\'
			GROUP BY `user`
		';
        $statement = $this->_adapter->query($sql);
        $row = $this->_adapter->fetchRow($statement);
        return $row['sum'];
    }
    
    public function getMemberStat($from, $to, $id) {
        $config = new Config(ConfigDatabase::load($this->_adapter));
        $sql = '
			SELECT * 
			FROM `payments-stat`
			WHERE
				`date` >= \''.$from.'\' AND
				`date` <= \''.$to.'\' AND
				`user` = \''.$id.'\'
			ORDER BY `date` ASC
		';
        $statement = $this->_adapter->query($sql);
        $rows = array();
        while (($row = $this->_adapter->fetchRow($statement))) {
            //hits
            $sql = 'SELECT SUM(`value`) AS sum
				FROM `promo-stat`
				WHERE
					`date` = \''.$row['date'].'\' AND
					`uid` = \''.$row['user'].'\'
				GROUP BY `date`
			';
            $statement1 = $this->_adapter->query($sql);                
            $row1 = $this->_adapter->fetchRow($statement1);
            
            $row['hits'] = $row1['sum'];
            //installs
            $sql = 'SELECT SUM(`installs`) AS sum
				FROM `installs-stat`
				WHERE
					`date` = \''.$row['date'].'\' AND
					`user` = \''.$row['user'].'\'
				GROUP BY `date`
			';            
            $statement1 = $this->_adapter->query($sql);                
            $row1 = $this->_adapter->fetchRow($statement1);

            $row['installs'] = $row1['sum'];
            //referals
            $sql = '
				SELECT SUM(`amount_revshare`)*'.$config->referal_commission.' AS sum
				FROM `payments-stat`
				WHERE
					`date` = \''.$row['date'].'\' AND
					`user` IN (SELECT `id` FROM `users` WHERE ref_id = \''.$row['user'].'\')
			';
            $statement1 = $this->_adapter->query($sql);                
            $row1 = $this->_adapter->fetchRow($statement1);

            $row['referals'] = $row1['sum'];
            
            $rows[] = $row;
            
        }
        return $rows;
    }
    
    public function getPaymentsCnt($where = null) {
        $sql = 'SELECT COUNT(id) AS cnt 
			FROM `payments` 
			'.($where?' WHERE '.$where:'').'
		';        
	    $statement = $this->_adapter->query($sql);
	    $row = $this->_adapter->fetchRow($statement);
	    return $row['cnt'];          
    }
    
    public function getPayments($from, $to, $where = null, $order = 'id DESC') {
        $sql = 'SELECT * FROM `payments` 
			'.($where?' WHERE '.$where:'').'
			'.($order?' ORDER BY '.$order:'').'
			LIMIT '.$from.', '.$to.'
		';
        $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchAll($statement);            
    } 
    
    public function savePayment(array $values, $id = null) {
        if ($id) {
            $id = array('field' => 'id', 'value' => $id);
        }
        return $this->_adapter->save('payments', $values, $id);
    }
    
    public function getUsersPayments($from, $to, $where = null, $order = 'id DESC') {
        $sql = 'SELECT `payments`.*, `users`.`username` FROM `payments`, `users`  
			'.($where?' WHERE '.$where:'').'
			GROUP BY `payments`.`id`
			'.($order?' ORDER BY '.$order:'').'
			LIMIT '.$from.', '.$to.'
		';
        $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchAll($statement);            
    } 
    
	public function getUsersPaymentsCnt($where = null) {
        $sql = 'SELECT COUNT(`payments`.`id`) AS cnt 
			FROM `payments`, `users` 
			'.($where?' WHERE '.$where:'').'
			GROUP BY `payments`.`id`
		';        
	    $statement = $this->_adapter->query($sql);
	    $row = $this->_adapter->fetchRow($statement);
	    return $row['cnt'];          
    }
    
    public function getPaymentById($id) {
        $sql = 'SELECT 
				`payments`.*, 
				`users`.`username`, 
				`users`.`email`
			FROM `payments`, `users`  
			WHERE 
				`payments`.`uid` = `users`.`uid` AND
				`payments`.`id`  = \''.$id.'\'';
        $statement = $this->_adapter->query($sql);
	    return $this->_adapter->fetchRow($statement);        
    }
       
    public function calculate() {
        $day = date('j');
               
        if ($day == 15) {
            $from = date('Y-m-01');
        } else if ($day == date('t')) {
            $from = date('Y-m-16');            
        } else die('...'); 
        $to = date('Y-m-').$day;   

        $config = new Config(ConfigDatabase::load($this->_adapter));
        
        //self payments            
        $sql = 'SELECT 
				SUM(`payments-stat`.`amount_revshare`) as sum,
				`users`.`uid`,
				`users`.`payment_method`,
				`users`.`id`
			FROM `payments-stat` INNER JOIN `users` 
			ON `payments-stat`.`user` = `users`.`id`
			WHERE 
				`payments-stat`.`date` >= \''.$from.'\' AND 
				`payments-stat`.`date` <= \''.$to.'\'
			GROUP BY `payments-stat`.`user`
		';
        $statement = $this->_adapter->query($sql);
        $payments  = array();
        while (($row = $this->_adapter->fetchRow($statement))) {
            $values = array(
                'uid' => $row['uid'],
                'pay_date' => date('Y-m-d'),
                'pay_method' => $row['payment_method'],
                'pay_sum' => $row['sum'],
                'is_payed' => 0,
                'pay_period' => $to);
            $payments[] = array(
                'user' => $row['id'], 
                'pay_sum' => $row['sum'],
	            'payment' => $this->savePayment($values));
        }
        
        /** referal payments */
        for ($i = 0, $count = count($payments); $i < $count; $i++) {
            $sql = 'SELECT 
					SUM(`payments`.`pay_sum`) as sum,
					`users`.`ref_id`
				FROM `payments` INNER JOIN `users`
				ON `payments`.`uid` = `users`.`id`
				WHERE `users`.`ref_id` = \''.$payments[$i]['user'].'\'
				GROUP BY `users`.`ref_id`
			';
            $statement = $this->_adapter->query($sql);
            $row = $this->_adapter->fetchRow($statement);
            if ($row) { // exist case
                $values = array(
                    'pay_sum' => $payments[$i]['pay_sum']+($row['sum']*$config->referal_commission)
                );
                $this->savePayment($values, $payments[$i]['payment']);            
            }
        }
    }
    
    public function getPaymentSystems ($values) {
    	$payment_systems = array(
			'1' => array('name' => 'Wire Transfer', 'amount' => '50', 'percent' => false),
			'2' => array('name' => 'WesternUnion', 'amount' => '0', 'percent' => false),
			'3' => array('name' => 'PayPal', 'amount' => '7', 'percent' => true),
			'4' => array('name' => 'WebMoney','amount' => '0.8', 'percent' => true),
			'5' => array('name' => 'Epassporte', 'amount'=> '7', 'percent' => true),
			'6' => array('name' => 'WesternUnion', 'amount'=> '0', 'percent' => false),
			'7' => array('name' => 'Moneygram', 'amount'=> '0', 'percent' => false)
		);
		return $payment_systems;
    }
}

?>