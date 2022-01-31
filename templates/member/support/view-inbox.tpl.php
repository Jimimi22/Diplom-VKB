<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=index" style="color: #fff;">Входящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=outbox">Исходящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=compose&id=<?php echo $this->id; ?>">Ответить</a></li>		
	<li style="float: left; margin-right: 10px;">		
		<a href="?cmd=doRemoveInbox&id=<?php echo $this->id; ?>"
		onclick="javascript: return confirm('Удалить сообщение?');">Удалить</a></td></li>
</ul>
<br /><br />
<b><span style="color:#504e46;">From:</span></b>
<?php echo $this->first_name; ?>&nbsp;<?php echo $this->last_name; ?>
<br /><br />
<b><span style="color:#504e46;">Subject:</span></b>
<?php echo $this->subj; ?>
<br /><br />
<b><span style="color:#504e46;">Posted:</span></b>
<?php echo $this->posted; ?>
<br /><br />
<b><span style="color:#504e46;">Message:</span></b>
<br /><br />
<p>
<?php echo nl2br($this->message); ?>
</p>