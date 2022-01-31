<script>
	var i=1;
	function addItem() {
		div=document.getElementById("answer");
		button=document.getElementById("new_answer");
		newitem="";
		newitem+="<div class='form1'><input type='text' name= answers[]>&nbsp;<input type='radio' value='"+i+"' name='is_wright[]'></div>";
		newnode=document.createElement("span");
		newnode.innerHTML=newitem;
		div.insertBefore(newnode,button);
		i++;
	}
</script>

<div class="art-PostContent">
				<form action="?cmd=doEditQuest" enctype="multipart/form-data" method="post" id="edit">
					<input type="hidden" name="id" value="<?php $this->pop('id'); ?>">
					<input type="hidden" name="id_chapt" value="<?php $this->pop('id_chapt'); ?>">
					<div class="form1">Вопрос: <b><?php $this->pop('question-failed');?></b><br />
						<input type="text" name="question" value="<?php $this->pop('question');?>" />
					</div>	
					<br />
					<div class="form1">Ответ: <b><?php $this->pop('answer-failed');?></b><br />
						<input type="text" name="answer" value="<?php $this->pop('answer');?>" />
					</div>	
					<div class="form1">Сложность: <b><?php $this->pop('level-failed');?></b><br />
						1 <input type="radio" name="level" value="1" /><br />
						2 <input type="radio" name="level" value="2" /><br />
						3 <input type="radio" name="level" value="3" /><br />
					</div>	
					<!-- 
					<div class="form1">Изображение: <br />
						<input type="file" name="picture"  />
					</div>	
					<br />
					<div id = "answer">
						Вариант: <b><?php $this->pop('chapter-failed');?></b><br />
				    	<a href="javascript: addItem();" class="link4" ID="new_answer"><em><b>Ещё</b></em></a>
    				</div>
    				-->
					<div class="wrapper"><br /><br />		
						<input type="submit" value="Сохранить">
					</div>		
				</form>            
           
</div>