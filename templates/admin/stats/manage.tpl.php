<div class="img-box1">
 <div class="box">
  <div class="left-top-corner">
    <div class="right-top-corner">
      <div class="right-bot-corner">
        <div class="left-bot-corner">
          <div class="inner" style="z-index:0;">
			<form action="?cmd=index" method="post" id="filter">
				<input type="hidden" name="id" value="<?php $this->pop('id'); ?>">
				<div class="form1">From: <b><?php $this->pop('from-failed');?></b><br />
					<input type="text" name="from" id="from" value="<?php $this->pop('from');?>" />
				</div>	
				<div class="form1">To: <b><?php $this->pop('to-failed');?></b><br />
					<input type="text" name="to" id="to" value="<?php $this->pop('to');?>" />					
				</div>
				<br />
				<div class="wrapper">		
					<a href="#" class="link4" onclick="document.getElementById('filter').submit(); return false;"><em><b>View statistic</b></em></a>
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
	<th align="left">User</th>	
	<?php for ($i = 0, $count = count($this->dates); $i < $count; $i++) {?>
	<th align="left"><?php echo $this->dates[$i]; ?></th>
	<?php } // end for ?>
</tr>
<?php if (($count = count($this->items))) {?>
<?php foreach($this->items as $key => $value ) {?>
<tr>
	<td><a href="users.php?cmd=edit&uid=<?php echo $value['uid'];?>"><?php echo $key; ?></a></td>
	<?php for ($i = 0, $count = count($this->dates); $i < $count; $i++) {?>
	<td><?php if (array_key_exists($this->dates[$i], $value)) {
	    echo $value[$this->dates[$i]]['clicks_revshare'].'&nbsp;<span style="color: #000;">('.$value[$this->dates[$i]]['clicks_real'].')</span><br />'.
	    $value[$this->dates[$i]]['amount_revshare'].'&nbsp;<span style="color: #000;">($'.$value[$this->dates[$i]]['amount_real'].')</span>';
	} else echo '0'; ?></td>
	<?php } // end for ?>
</tr>
<tr><td colspan="<?php echo count($this->dates)+1; ?>" style="border-bottom: 1px solid #1B1A13;"><br/></td></tr>
<tr><td colspan="<?php echo count($this->dates)+1; ?>"><br/></td></tr>
<?php } // end foreach ?>
<?php } else { ?>
<tr><td colspan="<?php echo count($this->dates)+1; ?>">There are no stats</td></tr>
<?php } // end if?>
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