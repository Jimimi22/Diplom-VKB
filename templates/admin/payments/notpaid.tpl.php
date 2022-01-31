<div class="img-box1">
 <div class="box">
  <div class="left-top-corner">
    <div class="right-top-corner">
      <div class="right-bot-corner">
        <div class="left-bot-corner">
          <div class="inner" style="z-index:0;">
			<form action="?cmd=index" method="post" id="filter">
				<input type="hidden" name="id" value="<?php $this->pop('id'); ?>">
				<div class="form1">From: <b><?php $this->pop('date_from-failed');?></b><br />
					<input type="text" name="date_from" id="date_from" value="<?php $this->pop('date_from');?>" />
				</div>	
				<div class="form1">To: <b><?php $this->pop('date_to-failed');?></b><br />
					<input type="text" name="date_to" id="date_to" value="<?php $this->pop('date_to');?>" />					
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
<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=notpaid" style="color: #fff;">Not paid</a></li>		
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=paid">Paid</a></li>				
</ul>
<br /><br />
<?php if (($count = count($this->items))) { ?>
<form name="pay" method="post" action="?cmd=doSave">
<table  border="0" width="100%">
<tr>
	<th align="left">User</th>
	<th align="left">Date pay</th>
	<th align="left">Pay period</th>
	<th align="left">Payment method</th>
	<th align="left">Sum</th>
	<th align="left">Paid</th>
</tr>
<?php for ($i = 0; $i < $count; $i++) {?>
<tr>
	<td align="left">
    	<a href="users.php?cmd=edit&uid=<?php echo $this->items[$i]['uid']?>"><?php echo $this->items[$i]['username']?></span></b><br />
	</td>
	<td align="left">
    	<?php echo $this->items[$i]['pay_date']?></span></b><br />
	</td>
	<td align="left">
		<?php 
		$dates = explode('-', $this->items[$i]['pay_period']);
		echo date("Y-m-d", mktime (0, 0, 0, $dates[1], $dates[2]-14, $dates[0])).' / '.$this->items[$i]['pay_period'];
		?>
	</td>
	<td align="left">
		<?php
		 foreach($this->payment_systems as $key=>$value) 
		 	if($this->items[$i]['pay_method'] == $key) echo $value['name'];
		?>  
		&nbsp;
	</td>
	<td align="left">
		<?php echo '$'.$this->items[$i]['to_pay'].' &nbsp;<span style="color: #000;">($'.$this->items[$i]['pay_sum'].')</span> '; ?>
	</td>
	<td align="left">
		<a href="?cmd=doPay&id=<?php echo $this->items[$i]['id']?>">pay</a>
	</td>
</tr>
<tr><td colspan="6" style="border-bottom: 1px solid #1B1A13;"><br/></td></tr>
<tr><td colspan="6"><br/></td></tr>
<?php } // endfor?>
<?php } else { ?>
<tr><td>There are no payments in this period</td></tr>
<?php } // endif?>
</table>
</form>
<?php $this->call('pager', 
        $this->count, 
		$this->onpage, 
		$this->page,
		$this->neighbours, '?cmd='.$this->_CMD);?>
<script type="text/javascript">
$(document).ready(function() {
<!--
	$('#date_from').mask('9999-99-99');		
	$('#date_to').mask('9999-99-99');			
//-->
});
</script>