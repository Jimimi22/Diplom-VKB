<table border="0" width="75%" class="grid" cellpadding="0" cellspacing="0">
<tr>
	<th align="left">Глава</th>
</tr>
<tr>
	<th colspan="1" align="left"></th>
</tr>
<?php if (($count = count($this->items))) { ?>
<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) {?>
<tr>
	<td><b><a href="?cmd=manageQuestions&id_chapter=<?php echo $this->items[$i]['id']; ?>">
	<?php echo $this->items[$i]['chapter']; ?>
	</a></b>
	</td>
	
</tr>
<tr><td colspan="1" style="border-bottom: 1px solid #1B1A13;"><br/></td></tr>
<tr><td colspan="1"><br/></td></tr>
<?php } //end for ?>
<?php } else { ?>
<tr><td >Главы отстутствуют</td></tr>
<?php } ?>
</table>
<?php $this->call('pager', 
        $this->count, 
		$this->onpage, 
		$this->page,
		$this->neighbours, '?cmd='.$this->_CMD);?>