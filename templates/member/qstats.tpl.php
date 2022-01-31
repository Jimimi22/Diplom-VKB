<div class="title"><img src="../resources/images/qstats.png"></div>
<b>Today installs:</b> <?php echo $this->_TODAY_INSTALLS; ?><br />
<br />
<b>Today clicks:</b> <?php echo $this->_TODAY_CLICKS['clicks_revshare']?$this->_TODAY_CLICKS['clicks_revshare']:0; ?><br />
<br />
<b>Today earned:</b> <?php echo $this->_TODAY_MONEY['amount_revshare']?$this->_TODAY_CLICKS['amount_revshare']:0; ?><br />
<br />
<b>This PP installs</b>: <?php echo $this->_PPINSTALLS; ?><br />
<br />
<b>This PP clicks</b>: <?php echo $this->_PP_CLICKS['clicks_revshare']?$this->_PP_CLICKS['clicks_revshare']:0; ?> <br />
<br />						
<b>Ballance:</b> $<?php echo $this->_PPBALLANCE?$this->_PPBALLANCE:0; ?><br />
<br />
<b>Messages</b> (<a href="support.php?cmd=index"><?php echo $this->_INBOX_MESSAGES?$this->_INBOX_MESSAGES:0; ?></a>) <br />						
