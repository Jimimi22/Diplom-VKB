<!-- 
<form action="?cmd=doFilter" method="post" id="filter" >
<div class="img-box1">
 <div class="box">
  <div class="left-top-corner">
    <div class="right-top-corner">
      <div class="right-bot-corner">
        <div class="left-bot-corner">
          <div class="inner" style="z-index:0;">          	
			<form action="?cmd=index" method="post" id="filter">
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
<div>
<br />
 -->
<?php if (($count = count($this->items))) { ?>
<table width="100%">
<th align="left">Date pay</span></th>
<th align="left">Pay period</span></th>
<th align="left">Payment method</span></th>
<th align="left">Sum</span></b></th>
<?php for ($i = 0; $i < $count; $i++) {?>
<tr>
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
		<?php echo '$'.$this->items[$i]['to_pay']; ?>
	</td>
</tr>
<?php } // endfor?>
<?php } else { ?>
<tr><td colspan="4">There are no payments</td></tr>
<?php } // endif?>
</table>
</div>
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