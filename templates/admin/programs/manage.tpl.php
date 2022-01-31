<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=add">Upload new program</a></li>		
</ul>
<br /><br />
<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
<tr>
	<th align="left">Url</th>	
	<th align="left">Group</th>
	<th align="left">Total upload count</th>	
	<th align="left">Day upload count</th>
	<th align="left">Position</th>	
	<th align="left" colspan="3">Actions</th>	
</tr>
<?php if (($count = count($this->items))) { ?>
<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) {?>
<tr>
	<td><?php echo $this->items[$i]['download_link']; ?></td>	
	<td><?php echo $this->items[$i]['group_name']; ?></td>
	<td><?php echo $this->items[$i]['total_uploads']; ?> (<?php echo $this->items[$i]['today_total_uploads']; ?>)</td>	
	<td><?php echo $this->items[$i]['day_uploads']; ?> (<?php echo $this->items[$i]['today_uploads']; ?>)</td>
	<td><?php echo $this->items[$i]['position']; ?></td>	
	<td align="center">
		<a href="?cmd=edit&id=<?php echo $this->items[$i]['id']; ?>">edit</a></td>
	<td align="center">
		<a href="?cmd=doRemove&id=<?php echo $this->items[$i]['id']; ?>"
		onclick="javascript: return confirm('Remove program?');">remove</a></td>
	<td align="center"><a href="?cmd=stat&id=<?php echo $this->items[$i]['id']; ?>">stat</a></td>	
</tr>
<?php } //end for ?>
<?php } else { ?>
<tr><td colspan="6">There are no programs</td></tr>
<?php } ?>
</table>
<?php $this->call('pager', 
        $this->count, 
		$this->onpage, 
		$this->page,
		$this->neighbours, '?cmd='.$this->_CMD);?>