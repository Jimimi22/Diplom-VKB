<html>
<head></head>
<body>
Это сообщение отправлено от: <?php echo $_SERVER['HTTP_HOST'];?><br />
<p>
From: <?php echo $this->fname; ?> <?php echo $this->lname; ?>
</p>
<p>
<?php echo nl2br($this->message); ?>
</p>
</body>
</html>