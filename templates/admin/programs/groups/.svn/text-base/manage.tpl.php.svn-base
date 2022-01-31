<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="programs.php?cmd=cgroups" style="color: #fff;">Countries groups for programs</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="settings.php?cmd=index">Custom settings</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="account.php?cmd=index">Account settings</a></li>			
</ul>
<br /><br />
<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=addCgroup">New countries goup for programs</a></li>		
</ul>
<br /><br />
<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
<tr>
	<th align="left">Name</th>	
	<th align="left">Countries</th>
	<th align="left" colspan="2">Actions</th>	
</tr>
<?php if (($count = count($this->items))) { ?>
<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) {?>
<tr>
	<td valign="top"><b><?php echo $this->items[$i]['name']; ?></b></td>
	<td align="justify"><?php echo implode('<br/>', str_split($this->items[$i]['countries'], 90)); ?></td>	
	<td align="center">
		<a href="?cmd=doRemoveCgroup&id=<?php echo $this->items[$i]['id']; ?>"
		onclick="javascript: return confirm('Remove selected group? All related programs will be deleted!');">remove</a></td>	
	<td align="center"><a href="?cmd=editCgroup&id=<?php echo $this->items[$i]['id']; ?>">edit</a></td>		
</tr>
<tr><td colspan="4"><br /></td></tr>
<?php } //end for ?>
<?php } else { ?>
<tr><td colspan="4">There are no groups</td></tr>
<?php } ?>
</table>