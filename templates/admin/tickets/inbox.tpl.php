<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=index" style="color: #fff;">Входящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=outbox">Исходящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=compose">Отправить новое</a></li>		
</ul>
<br /><br />
<div class="img-box1">
 <div class="box">
  <div class="left-top-corner">
    <div class="right-top-corner">
      <div class="right-bot-corner">
        <div class="left-bot-corner">
          <div class="inner" style="z-index:0;">
<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
<tr>
	<th align="left">Отправлено</th>
	<th align="left">От кого</th>	
	<th align="left">Тема</th>
	<th align="left" style="width: 40%">Сообщения</th>
	<th colspan="2" align="left">Действия</th>	
</tr>
<?php if (($count = count($this->items))) { ?>
<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) {?>
<tr>
	<td valign="top"><?php echo $this->items[$i]['posted']; ?></td>	
	<td valign="top"><?php echo $this->items[$i]['username']; ?></td>	
	<td valign="top"><?php echo $this->items[$i]['subj']; ?></td>
	<td align="justify"><?php echo nl2br($this->items[$i]['message']); ?></td>	
	<td>
		<a href="?cmd=doRemoveInbox&id=<?php echo $this->items[$i]['id']; ?>"
		onclick="javascript: return confirm('Remove selected message?');">удалить</a></td>	
	<td>
		<a href="?cmd=compose&id=<?php echo $this->items[$i]['id']; ?>">ответить</a></td>		
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
		  </div>
        </div>
 	  </div>
 	 </div>
    </div>				
  </div>	
</div>		
		