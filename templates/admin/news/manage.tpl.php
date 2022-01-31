<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
<tr>
	<th align="left">Добавлено</th>	
	<th align="left">Описание</th>
	<th align="left" colspan="2">Действия</th>	
</tr>
<tr>
	<th colspan="3" align="left">&nbsp;</th>
</tr>
<?php if (($count = count($this->items))) { ?>
<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) {?>
<tr>
	<td><?php echo $this->items[$i]['posted']; ?></td>	
	<td><?php echo $this->items[$i]['caption']; ?></td>
	<td>
		<a href="?cmd=edit&id=<?php echo $this->items[$i]['id']; ?>">ред.</a></td>
	<td>
		<a href="?cmd=doRemove&id=<?php echo $this->items[$i]['id']; ?>"
		onclick="javascript: return confirm('Удалить выбранную новость?');">уд.</a></td>
</tr>
<tr><td colspan="4" style="border-bottom: 1px solid #1B1A13;"><br/></td></tr>
<tr><td colspan="4"><br/></td></tr>
<?php } //end for ?>
<?php } else { ?>
<tr><td colspan="4">Новости отстутствуют</td></tr>
<?php } ?>
</table>
<?php $this->call('pager', 
        $this->count, 
		$this->onpage, 
		$this->page,
		$this->neighbours, '?cmd='.$this->_CMD);?>