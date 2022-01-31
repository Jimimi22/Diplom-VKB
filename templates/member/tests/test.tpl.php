<form name="test" id="q" action="?cmd=test&id_chapter=<? echo $_GET['id_chapter'];?>&step=<? echo $_GET['step']+1?>" method="post">
<input type="hidden" name="id_chapter" value="<?php echo $_GET['id_chapter'] ?>">
<input type="hidden" name="id_quest" value="<?php echo $this->item['id'];?>">
<input type="hidden" name="level" value="<?php echo $this->item['level'];?>">

<table border="0" width="100%" class="grid" cellpadding="0" cellspacing="0">
<tr>
	<th colspan="5" align="left">&nbsp;</th>
</tr>
<?php
if ($this->item) { ?>

<tr>
	<td><b>	<?php echo $this->item['question']; ?></b>
	<br /><br />
	<div class="form1">Ответ: <b><?php $this->pop('answer-failed');?></b><br />
		<input type="text" name="answer" value="<?php $this->pop('answer');?>" />
	</div>	
	</td>
</tr>
<tr><td style="border-bottom: 1px solid #1B1A13;"><br/></td></tr>
<tr><td><br/></td></tr>

<tr>
<td>
	<div class="wrapper">		
		<input type="submit" value="Ok">
	</div>
</td>
</tr>

<?php } else { ?>
<tr><td >Вопросы отстутствуют либо вы ответили на все вопросы<br/><br/>
<?php 
if($this->is_tested) {
	echo "Правильных ответов: ".$this->right_answers.'<br />';
	echo "Неправильных ответов: ".$this->unright_answers.'<br />';
	echo "Набрано баллов: ".$this->user_points.'<br />';
	echo "Вердикт: ".$this->test_res.'<br />';
}

?>
</td></tr>
<?php } ?>

</table>
</form>