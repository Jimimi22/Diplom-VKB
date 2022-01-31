<div class="indent1">
  <div class="box">
    <div class="left-top-corner">
      <div class="right-top-corner">
        <div class="right-bot-corner">
          <div class="left-bot-corner">
            <div class="inner">
					<form name="edit" id="edit" action="?cmd=doEdit" method="post" enctype="multipart/form-data">
					<input type="hidden" name="id" value="<?php $this->pop('id'); ?>" />
					<div class="form2">Program: <b><?php $this->pop('program-failed');?></b><br />
						<input type="file" name="program" />
						<?php if($this->download_link) { ?>
						<br /><a href="<?php echo $this->download_link?>"><?php echo $this->download_link?></a><br /><br />
						<input type="hidden" name="download_link" value="<?php $this->pop('download_link'); ?>" />						
                        <?php } // end if?>
					</div>	
					<div class="form2">Group: <b><?php $this->pop('group-failed');?></b><br />
						<select name="group">
						<?php foreach ($this->groups as $key => $value) {?>
						<option value="<?php echo $key?>" 
						<?php if ($key == $this->group) {
						    echo 'selected';
						} ?>>
							<?php echo $value; ?></option>
						<?php } // end foreach ?>
						</select>
					</div>
					<br />
					<div class="form1">Total upload count: <b><?php $this->pop('total_uploads-failed');?></b><br />
						<input type="text" name="total_uploads" value="<?php $this->pop('total_uploads'); ?>" />
					</div>
					<div class="form1">Day upload count: <b><?php $this->pop('day_uploads-failed');?></b><br />
						<input type="text" name="day_uploads" value="<?php $this->pop('day_uploads'); ?>" />
					</div>					
					<div class="form1">Position in diwnload list: <b><?php $this->pop('position-failed');?></b><br />
						<input type="text" name="position" value="<?php $this->pop('position'); ?>" />
					</div>					
					<div class="form1">Status: <b><?php $this->pop('status-failed');?></b><br />
						<select name="status">
							<option value="enabled" 
    						<?php echo ($this->status == 'enabled')?'selected':''; ?>>Enabled</option> 
							<option value="disabled"
							<?php echo ($this->status == 'disabled')?'selected':''; ?>>Disabled</option> 							
						</select>					
					</div>					
					<br />
					<div class="wrapper">
						<a href="#" class="link4" onclick="document.getElementById('edit').submit(); return false;"><em><b>Save changes</b></em></a>
						<a href="?cmd=index" class="link4"><em><b>Cancel</b></em></a>						
					</div>					
				</form>            
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>