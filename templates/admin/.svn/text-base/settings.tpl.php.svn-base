<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="programs.php?cmd=cgroups">Countries groups for programs</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="settings.php?cmd=index" style="color: #fff;">Custom settings</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="account.php?cmd=index">Account settings</a></li>		
</ul>
<br /><br />
<div class="indent1">
  <div class="box">
    <div class="left-top-corner">
      <div class="right-top-corner">
        <div class="right-bot-corner">
          <div class="left-bot-corner">
            <div class="inner">
				<form name="settings" id="settings" action="?cmd=doSave" method="post">
					<b><span style="color:#504e46;">Ftp for programs:</span></b>
					<br /><br />
					<div class="form1">Ftp domain: <b><?php $this->pop('ftp_domain-failed');?></b><br />
						<input type="text" name="ftp_domain" value="<?php $this->pop('ftp_domain');?>" />
					</div>
					<div class="form1">Ftp port: <b><?php $this->pop('ftp_port-failed');?></b><br />
						<input type="text" name="ftp_port" value="<?php $this->pop('ftp_port');?>" />
					</div>					
					<div class="form1">Ftp user: <b><?php $this->pop('ftp_user-failed');?></b><br />
						<input type="text" name="ftp_user" value="<?php $this->pop('ftp_user');?>" />
					</div>																
					<div class="form1">Ftp password: <b><?php $this->pop('ftp_password-failed');?></b><br />
						<input type="text" name="ftp_password" value="<?php $this->pop('ftp_password');?>" />
					</div>
					<div class="form1">Ftp directory: <b><?php $this->pop('ftp_directory-failed');?></b><br />
						<input type="text" name="ftp_directory" value="<?php $this->pop('ftp_directory');?>" />
					</div>										
					<br />
					<br /><br />					
					<div class="form1">Referal commission: <b><?php $this->pop('referal_commission-failed');?></b><br />
						<input type="text" name="referal_commission" value="<?php $this->pop('referal_commission');?>" />
					</div>					
					<div class="form1">Minimal payment: <b><?php $this->pop('min_payment-failed');?></b><br />
						<input type="text" name="min_payment" value="<?php $this->pop('min_payment');?>" />
					</div>										
					<br />
					<br /><br />					
					<b><span style="color:#504e46;">Reshare settings:</span></b>
					<br /><br />
					<div class="form1">Revshare clicks: <b><?php $this->pop('revshare_clicks-failed');?></b><br />
						<input type="text" name="revshare_clicks" value="<?php $this->pop('revshare_clicks');?>" />
					</div>					
					<div class="form1">Revshare money: <b><?php $this->pop('revshare_money-failed');?></b><br />
						<input type="text" name="revshare_money" value="<?php $this->pop('revshare_money');?>" />
					</div>	
					<br /><br />				
					<b><span style="color:#504e46;">Renew settings:</span></b>
					<br /><br />
					<div class="form1">Renew url: <b><?php $this->pop('renew_url-failed');?></b><br />
						<input type="text" name="renew_url" value="<?php $this->pop('renew_url');?>" />
					</div>
					<div class="form1">Autorenew: <b><?php $this->pop('autorenew-failed');?></b><br />
						<select name="autorenew">
							<option value="enabled"
							<?php echo ($this->autorenew == 'enabled')?'selected':''?>>Auto renew enabled</option>
							<option value="disabled"
							<?php echo ($this->autorenew == 'disabled')?'selected':''?>>Auto renew disabled</option>
						</select>
					</div>
					<br />					
					<div class="wrapper">
						<a href="#" class="link4" onclick="document.getElementById('settings').submit(); return false;"><em><b>Save changes</b></em></a>
					</div>
				</form>            
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>