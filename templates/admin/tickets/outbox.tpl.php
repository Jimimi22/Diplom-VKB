<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=index">Входящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=outbox" style="color: #fff;">Исходящие</a></li>
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
	<th align="left">Кому</th>	
	<th align="left">Тема</th>
	<th align="left" style="width: 40%">Сообщение</th>
</tr>
<?php if (($count = count($this->items))) { ?>
<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) {?>
<tr>
	<td valign="top"><?php echo $this->items[$i]['posted']; ?></td>	
	<td valign="top"><?php echo $this->items[$i]['username']; ?></td>	
	<td valign="top"><?php echo $this->items[$i]['subj']; ?></td>
	<td align="justify"><?php echo nl2br($this->items[$i]['message']); ?></td>
</tr>
<?php } //end for ?>
<?php } else { ?>
<tr><td colspan="4">Сообщения отсутствуют</td></tr>
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