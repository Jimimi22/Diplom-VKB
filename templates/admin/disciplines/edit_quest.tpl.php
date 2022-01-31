<div class="art-PostContent">
				<form action="?cmd=doEditQuest" enctype="multipart/form-data" method="post" id="edit">
					<input type="hidden" name="id_quest" value="<?php $this->pop('id_quest'); ?>">
					<input type="hidden" name="id_chapt" value="<?php $this->pop('id_chapter'); ?>">
					<div class="form1">Вопрос: <b><?php $this->pop('question-failed');?></b><br />
						<input type="text" name="question" value="<?php $this->pop('question');?>" />
					</div>	
					<!-- 
					<br />
					<div class="form1">Изображение: <br />
						<input type="file" name="picture"  />
					</div>	
					 -->
					<br />
					<div class="form1">Ответ: <b><?php $this->pop('answer-failed');?></b><br />
						<input type="text" name="answer" value="<?php $this->pop('answer');?>" />
					</div>	
					<br />
					
					<div class="form1">Сложность: <b><?php $this->pop('level-failed');?></b><br />
						1 <input type="radio" name="level" <?php if($this->level == 1) echo 'checked'; ?> value="1" /><br />
						2 <input type="radio" name="level" <?php if($this->level == 2) echo 'checked'; ?> value="2" /><br />
						3 <input type="radio" name="level" <?php if($this->level == 3) echo 'checked'; ?> value="3" /><br />
					</div>	
					<!-- 
					<?php foreach ($this->answers as $key=>$value) {?>
						<input type='text' name = "answers[]" value="<?php echo $value['answer']; ?>">&nbsp;
						<input type='radio' name = "is_wright[]" value='<?php echo $key+1; ?>' <?php if ($value['is_wright'] == 1) echo 'checked'; ?>>&nbsp;
						<br /><br />
						
					<?php $i=$key+1; } ?>
					<script>
						var i=<?php echo $i+1; ?>;
						function addItem() {
							div=document.getElementById("answer");
							button=document.getElementById("new_answer");
							newitem="";
							newitem+="<input type='text' name= answers[]>&nbsp;&nbsp;<input type='radio' value='"+i+"' name='is_wright[]'><br /><br />";
							newnode=document.createElement("span");
							newnode.innerHTML=newitem;
							div.insertBefore(newnode,button);
							i++;
						}
					</script>
					<div id = "answer">
						Вариант: <b><?php $this->pop('chapter-failed');?></b><br />
				    	<a href="javascript: addItem(<?php echo $i; ?>);" class="link4" ID="new_answer"><em><b>Ещё</b></em></a>
    				</div>
    				-->
					<div class="wrapper"><br /><br />		
						<input type="submit" value="Сохранить">
					</div>		
				</form>            
            
</div>