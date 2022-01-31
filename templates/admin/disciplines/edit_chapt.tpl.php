<div class="art-PostContent">
				<form action="?cmd=doEditChapter" method="post" id="edit">
					<input type="hidden" name="id" value="<?php $this->pop('id'); ?>">
					<input type="hidden" name="id_dis" value="<?php $this->pop('id_dis'); ?>">
					<div class="form1">Название главы: <b><?php $this->pop('chapter-failed');?></b><br />
						<input type="text" name="chapter" value="<?php $this->pop('chapter');?>" />
					</div>	
					<br />
					<div>Содержание главы: <b><?php $this->pop('body-failed');?></b><br />
						<?php $this->call('form-element/ext/fckeditor', 'body', $this->body, 'engine'); ?>
					</div>	
					<br />
					Активно <input type="radio" name="is_active" value="1" <?php if($this->is_active == 1) echo 'checked';?>>
					&nbsp;
					Неактивно <input type="radio" name="is_active" value="0" <?php if($this->is_active == 0) echo 'checked';?>>		
					<br /><br />
					<div>		
						<input type="submit" value="Сохранить">
					</div>		
				</form>            
           
</div>