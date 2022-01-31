<html>
<head></head>
<body>
<p>
Hi there,<br /><br />
Another pay period ended. Your income: <?php echo $this->pay_sum; ?>. Money was
sent using: 
<?php
	if($this->pay_method == 1)
		echo 'Wire Transfer'; 
	if($this->pay_method == 2)
		echo 'Wire Transfer'; 
	if($this->pay_method == 3)
		echo 'Wire Transfer'; 
	if($this->pay_method == 4)
		echo 'Wire Transfer'; 			
?>.<br /><br />

Hope you at least double your revenue in next pay period :)<br /><br />

DO NOT REPLY ON THIS MESSAGE, USE TICKETS SYSTEM!<br />
HAVE A NICE DAY!<br />
YA!BUCKS Team,<br />
<a href="mailto:<?php echo $this->_CFG->email; ?>"><?php echo $this->_CFG->email; ?></a><br />
<a href="http://www.<?php echo $_SERVER['HTTP_HOST']; ?>">http://www.<?php echo $_SERVER['HTTP_HOST']; ?></a>   
</p>
</body>
</html>

   