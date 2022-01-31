<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=addChapter&id_dis=<?php echo $this->id_dis; ?>">Добавить главу или лабораторную</a></li>		
</ul>
<br /><br />
<table border="0" width="60%" class="grid" cellpadding="0" cellspacing="0">
<tr>
	<th align="left">Глава</th>
	<th align="left">Активно</th>
	<th align="left" colspan="4">Действия</th>	
</tr>
<tr>
	<th colspan="5" align="left">&nbsp;</th>
</tr>
<?php if (($count = count($this->items))) { ?>
<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) {?>
<tr>
	<td><b><a href="?cmd=chapter&id=<?php echo $this->items[$i]['id']; ?>">
	<?php echo $this->items[$i]['chapter']; ?>
	</a></b>
	</td>
	<td><b>
	<?php if($this->items[$i]['is_active'] == 1) echo 'Да'; else echo 'Нет'; ?>
	</b>
	</td>
	<td>
		<a href="?cmd=editChapter&id=<?php echo $this->items[$i]['id']; ?>">ред.</a></td>
	<td>
		<a href="?cmd=doRemoveChapter&id=<?php echo $this->items[$i]['id']; ?>"
		onclick="javascript: return confirm('Удалить выбранную главу?');">уд.</a></td>
	<td>
		<a href="?cmd=addQuest&id=<?php echo $this->items[$i]['id']; ?>">доб. вопр.</a></td>
	
</tr>
<tr><td colspan="5" style="border-bottom: 1px solid #1B1A13;"><br/></td></tr>
<tr><td colspan="5"><br/></td></tr>
<?php } //end for ?>
<?php } else { ?>
<tr><td colspan="4">Главы отсутствуют</td></tr>
<?php } ?>
</table>
<?php $this->call('pager', 
        $this->count, 
		$this->onpage, 
		$this->page,
		$this->neighbours, '?cmd='.$this->_CMD);?>