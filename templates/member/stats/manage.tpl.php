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
	<th align="left">Date</th>	
	<th align="left">Promo hits</th>
	<th align="left">Installs</th>
	<th align="left">Clicks</th>
	<th align="left">Money</th>
	<th align="left">Referrals</th>
	<th align="left">Total money</th>	
</tr>
<?php if (($count = count($this->items))) {?>
<?php for($i = 0; $i < $count; $i++) {?>
<tr>
	<td><?php echo $this->items[$i]['date']; ?></td>
	<td><?php echo $this->items[$i]['hits']; ?></td>
	<td><?php echo $this->items[$i]['installs']; ?></td>	
	<td><?php echo $this->items[$i]['clicks_revshare']; ?></td>
	<td>$<?php echo $this->items[$i]['amount_revshare']; ?></td>	
	<td>$<?php echo $this->items[$i]['referals']; ?></td>		
	<td>$<?php echo $this->items[$i]['amount_revshare']+$this->items[$i]['referals']; ?></td>
</tr>
<?php } // end for ?>
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