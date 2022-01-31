<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
<tr>
	<th align="left">Ник</th>
	<th align="left">Имя</th>
	<th align="left">Фамилия</th>
	<th align="left">Дисциплина</th>
	<th align="left">Глава</th>
	<th align="left">Баллы</th>
	<th align="left">Статус</th>
</tr>
<tr>
	<th colspan="2" align="left">&nbsp;</th>
</tr>
<?php if (($count = count($this->items))) { ?>
<?php for ($i = 0, $count = count($this->items); $i < $count; $i++) {?>
<tr>
	<td><?php echo $this->items[$i]['username'];?></td>
	<td><?php echo $this->items[$i]['first_name'];?></td>
	<td><?php echo $this->items[$i]['last_name'];?></td>
	<td><?php echo $this->items[$i]['discipline'];?></td>
	<td><?php echo $this->items[$i]['chapter'];?></td>
	<td><?php echo $this->items[$i]['user_points'];?></td>	
	<td> <?php if($this->items[$i]['user_points']<$this->points) echo 'Тест не сдан'; else echo 'Тест сдан'; ?></td>	
</tr>
<tr><td colspan="7" style="border-bottom: 1px solid #1B1A13;"><br/></td></tr>
<tr><td colspan="7"><br/></td></tr>
<?php } //end for ?>
<?php } else { ?>
<tr><td colspan="7">Результаты тестирований отстутствуют</td></tr>
<?php } ?>
</table>
