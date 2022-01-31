<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
<tr>
	<th colspan="5" align="left">&nbsp;</th>
</tr>
<?php
if (($count = count($this->items))) { ?>
<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) {?>
<tr>
	<td><b>	<?php echo $this->items[$i]['question']; ?>: <?php echo $this->items[$i]['wright_answ']; ?></b><br />
	<a href="disciplines.php?cmd=editQuest&id_quest=<?php echo $this->items[$i]['id']; ?>">Ред.</a>
	&nbsp;|&nbsp;
	<a href="disciplines.php?cmd=rmQuest&id_quest=<?php echo $this->items[$i]['id']; ?>">Уд.</a>
	<br /><br />
	</td>
</tr>
<tr><td style="border-bottom: 1px solid #1B1A13;"><br/></td></tr>
<tr><td><br/></td></tr>
<?php } //end for ?>
<?php } else { ?>
<tr><td >Вопросы отстутствуют</td></tr>
<?php } ?>
</table>
<?php $this->call('pager', 
        $this->count, 
		$this->onpage, 
		$this->page,
		$this->neighbours, '?cmd='.$this->_CMD);?>