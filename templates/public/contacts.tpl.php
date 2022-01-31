<div class="art-PostContent">
<p>
				<form action="?cmd=doSend" method="post" id="contacts">
					<div class="form1">Email: <b><?php $this->pop('email-failed');?></b><br />
						<input style="width: 300px" type="text" name="email" value="<?php $this->pop('email');?>" />
					</div>
					<div class="form1">Имя: <b><?php $this->pop('fname-failed');?></b><br />
						<input style="width: 300px" type="text" name="fname" value="<?php $this->pop('fname');?>" />
					</div>
					<div class="form1">Фамилия: <b><?php $this->pop('lname-failed');?></b><br />
						<input style="width: 300px" type="text" name="lname" value="<?php $this->pop('lname');?>" />
					</div>
					<div class="form1">Тема: <b><?php $this->pop('subj-failed');?></b><br />
						<input style="width: 300px" type="text" name="subj" value="<?php $this->pop('subj');?>" />
					</div>	
					<div class="form2">Сообщение: <b><?php $this->pop('message-failed');?></b><br />
						<textarea cols="35" rows="5" name="message"><?php $this->pop('message'); ?></textarea>
					</div>
					 <input type="submit" value="Отправить">
				</form>            
</p>
</div>           
