<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="programs.php?cmd=cgroups" style="color: #fff;">Countries groups for programs</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="settings.php?cmd=index">Custom settings</a></li>
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
					<form name="edit" id="edit" action="?cmd=doSaveCgroup" method="post">
					<input type="hidden" name="id" value="<?php $this->pop('id'); ?>">
					<div class="form1">Name: <b><?php $this->pop('name-failed');?></b><br />
						<input type="text" name="name" value="<?php $this->pop('name');?>" />
					</div>	
					<div class="form2">Countires: <b><?php $this->pop('countries-failed');?></b><br />
						<select name="countries[]" multiple="multiple" size="15" style="width: 250px;">
						<?php foreach ($this->items as $key => $value) {?>
						<option value="<?php echo $key?>" 
						<?php if (@in_array($key, $this->countries)) {
						    echo 'selected';
						} ?>
						>
							<?php echo $value; ?></option>
						<?php } // end foreach ?>
						</select>
					</div>
					<br />
					<div class="wrapper">
						<a href="#" class="link4" onclick="document.getElementById('edit').submit(); return false;"><em><b>Save changes</b></em></a>
						<a href="?cmd=cgroups" class="link4"><em><b>Cancel</b></em></a>						
					</div>					
				</form>            
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>