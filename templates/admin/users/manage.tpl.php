<form action="?cmd=index" method="get" id="filter" >
<div class="img-box1">
 <div class="box">
  <div class="left-top-corner">
    <div class="right-top-corner">
      <div class="right-bot-corner">
        <div class="left-bot-corner">
          <div class="inner">
			<div class="form1">Поиск юзера:<br />
			  <input type="text" name="keyword" value="<?php $this->pop('keyword');?>"><br />
			 </div>
			 <div class="wrapper" style="align:left"><a href="#" class="link4" onclick="document.getElementById('filter').submit()"><em><b>Ok</b></em></a></div>
			</div>
        	</div>
 		  </div>
 	   </div>
    </div>				
  </div>	
</div>
</form>
<?php if (($count = count($this->items))) { ?>
<table width="100%">
<th align="left">Пользователь</th>
<th align="left">Статус</th>
<th align="left">IM</th>
<th align="left">Последний заход</th>
<?php for ($i = 0; $i < $count; $i++) {?>
<tr>
	<td align="left">
    	<a href="users.php?cmd=edit&uid=<?php echo $this->items[$i]['uid']; ?>"><b><?php echo $this->items[$i]['username']?></b></a>
	</td>
	<td align="left">
    	<?php if($this->items[$i]['is_active'] == 1) echo 'активен'; else echo 'блокирован'; ?>
	</td>
	<td align="left">
		<?php echo $this->items[$i]['id_mes']?>
		<?php 
			if($this->items[$i]['mesenger'] == 1) echo ' (ICQ)';
			if($this->items[$i]['mesenger'] == 2) echo ' (MSN)';
			if($this->items[$i]['mesenger'] == 3) echo ' (AOL)';
			if($this->items[$i]['mesenger'] == 4) echo ' (YAHOO!)';
		?>
	</td>
	<td align="left">
    	<?php echo $this->items[$i]['last_access']?>
	</td>
</tr>
<tr><td colspan="5" style="border-bottom: 1px solid #1B1A13;"><br/></td></tr>
<tr><td colspan="5"><br/></td></tr>
<?php } // endfor?>
<?php } else { ?>
<tr><td colspan="5">There are no users</td></tr>
<?php } // endif?>
</table>
<?php $this->call('pager', 
        $this->count, 
		$this->onpage, 
		$this->page,
		$this->neighbours, '?cmd='.$this->_CMD);?>
