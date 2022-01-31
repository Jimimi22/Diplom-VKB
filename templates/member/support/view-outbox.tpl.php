<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=index">Inbox</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=outbox" style="color: #fff;">Sent</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=compose">Compose new</a></li>		
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