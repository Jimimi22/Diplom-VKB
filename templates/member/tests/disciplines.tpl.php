<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
<tr>
	<th align="left">Дисциплина</th>
	
</tr>
<tr>
	<th align="left">&nbsp;</th>
</tr>
<?php if (($count = count($this->items))) { ?>
<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) {?>
<tr>
	<td><b><a href="?cmd=getChapters&id_dis=<?php echo $this->items[$i]['id']; ?>">
	<?php echo $this->items[$i]['discipline']; ?>
	</a></b>
	</td>
</tr>
<tr><td colspan="4" style="border-bottom: 1px solid #1B1A13;"><br/></td></tr>
<tr><td colspan="4"><br/></td></tr>
<?php } //end for ?>
<?php } else { ?>
<tr><td >Дисциплины отстутствуют</td></tr>
<?php } ?>
</table>
<?php $this->call('pager', 
        $this->count, 
		$this->onpage, 
		$this->page,
		$this->neighbours, '?cmd='.$this->_CMD);?>