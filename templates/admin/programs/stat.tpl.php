<div class="indent1" style="z-index: 0;">
  <div class="box" style="z-index: 0;">
    <div class="left-top-corner" style="z-index: 0;">
      <div class="right-top-corner" style="z-index: 0;">
        <div class="right-bot-corner" style="z-index: 0;">
          <div class="left-bot-corner" style="z-index: 0;">
            <div class="inner" style="z-index: 0;">
				<form action="?cmd=stat" method="post" id="stat">
					<input type="hidden" name="id" value="<?php $this->pop('id'); ?>">
					<div class="form1">From: <b><?php $this->pop('from-failed');?></b><br />
						<input type="text" name="from" id="from" value="<?php $this->pop('from');?>" />
					</div>	
					<div class="form1">To: <b><?php $this->pop('to-failed');?></b><br />
						<input type="text" name="to" id="to" value="<?php $this->pop('to');?>" />					
					</div>
					<br />
					<div class="wrapper">		
						<a href="#" class="link4" onclick="document.getElementById('stat').submit(); return false;"><em><b>View statistic</b></em></a>
						<a href="?cmd=index" class="link4" style="margin-left: 20px;"><em><b>Cancel</b></em></a>
					</div>		
				</form>            
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<br />
<div style="overflow: auto; height: 300px;">
<table width="100%" cellpadding="0" cellspacing="0"> 
<tr>
	<th>Country</th>	
	<?php for ($i = 0, $count = count($this->dates); $i < $count; $i++) {?>
	<th align="left"><?php echo $this->dates[$i]; ?></th>
	<?php } // end for ?>
</tr>
<?php foreach($this->stat as $key => $value ) {?>
<tr>
	<td><?php echo $key; ?></td>
	<?php for ($i = 0, $count = count($this->dates); $i < $count; $i++) {?>
	<td><?php echo @$value[$this->dates[$i]]?@$value[$this->dates[$i]]:0; ?></td>
	<?php } // end for ?>
</tr>
<tr><td colspan="<?php echo count($this->dates)+1; ?>" style="border-bottom: 1px solid #1B1A13;"><br/></td></tr>
<tr><td colspan="<?php echo count($this->dates)+1; ?>"><br/></td></tr>
<?php } // end foreach ?>
</table> 
</div>
<script type="text/javascript">
$(document).ready(function() {
<!--
	$('#from').mask('9999-99-99');		
	$('#to').mask('9999-99-99');			
//-->
});
</script>