<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=index" style="color: #fff;">Входящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=outbox">Исходящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=compose">Отправить сообщение</a></li>		
</ul>
<br /><br />
<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
<tr>
	<th align="left">От кого</th>	
	<th align="left">Тема</th>
	<th align="left">Отправлено</th>
	<th colspan="2" align="left">Действия</th>	
</tr>
<?php if (($count = count($this->items))) { ?>
<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) {?>
<tr>
	<td><?php echo $this->items[$i]['first_name']; ?>&nbsp;<?php echo $this->items[$i]['last_name']; ?></td>	
	<td><a href="?cmd=index&id=<?php echo $this->items[$i]['id']; ?>"><?php echo $this->items[$i]['subj']; ?></a></td>
	<td><?php echo $this->items[$i]['posted']; ?></td>
	<td>
		<a href="?cmd=doRemoveInbox&id=<?php echo $this->items[$i]['id']; ?>"
		onclick="javascript: return confirm('Удалить выбранное сообщение?');">удалить</a></td>	
	<td><a href="?cmd=compose&id=<?php echo $this->items[$i]['id']; ?>">ответить</a></td>		
</tr>
<?php } //end for ?>
<?php } else { ?>
<tr><td colspan="6">Сообщения отсутствуют</td></tr>
<?php } ?>
</table>
<br /><br />
<?php $this->call('pager', 
        $this->count, 
		$this->onpage, 
		$this->page,
		$this->neighbours, '?cmd='.$this->_CMD);?>
		