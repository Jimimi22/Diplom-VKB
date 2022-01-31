<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=index">Входящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=outbox" style="color: #fff;">Исходящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=compose">Отправить сообщение</a></li>		
</ul>
<br /><br />
<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
<tr>
	<th align="left">Кому</th>	
	<th align="left">Тема</th>
	<th align="left">Отправлено</th>
</tr>
<?php if (($count = count($this->items))) { ?>
<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) {?>
<tr>
	<td><?php echo $this->items[$i]['first_name']; ?>&nbsp;<?php echo $this->items[$i]['last_name']; ?></td>	
	<td><a href="?cmd=outbox&id=<?php echo $this->items[$i]['id']; ?>"><?php echo $this->items[$i]['subj']; ?></a></td>
	<td><?php echo $this->items[$i]['posted']; ?></td>
</tr>
<?php } //end for ?>
<?php } else { ?>
<tr><td colspan="3">Сообщения отсутствуют</td></tr>
<?php } ?>
</table>
<br /><br />
<?php $this->call('pager', 
        $this->count, 
		$this->onpage, 
		$this->page,
		$this->neighbours, '?cmd='.$this->_CMD);?>
		