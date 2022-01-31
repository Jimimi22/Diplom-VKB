<html>
<head></head>
<body>
Это сообщение отправлено от <?php echo $_SERVER['HTTP_HOST'];?><br />
<p>
Пользователь <?php echo $this->_USER['first_name']; ?> <?php echo $this->_USER['last_name']; ?> 
отправил вам новое сообщение.
</p>
<p>
<?php echo nl2br($this->message); ?>
</p>
</body>
</html>