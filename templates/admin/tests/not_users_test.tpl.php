<?php if (($count = count($this->items))) { ?>
<table width="100%">
<th align="left">Пользователь</th>
<?php for ($i = 0; $i < $count; $i++) {?>
<tr>
	<td align="left">
    	<a href="users.php?cmd=edit&uid=<?php echo $this->items[$i]['uid']; ?>"><b><?php echo $this->items[$i]['username']?></b></a>
	</td>

</tr>
<?php } // endfor?>
<?php } else { ?>
<tr><td >Пользователи отсутствуют</td></tr>
<?php } // endif?>
</table>
<?php $this->call('pager', 
        $this->count, 
		$this->onpage, 
		$this->page,
		$this->neighbours, '?cmd='.$this->_CMD);?>
