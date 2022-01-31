<div class="art-PostContent">
				<form action="?cmd=doEdit" method="post" id="edit">
					<input type="hidden" name="id" value="<?php $this->pop('id'); ?>">
					<div class="form1">Описание: <b><?php $this->pop('caption-failed');?></b><br />
						<input type="text" name="caption" value="<?php $this->pop('caption');?>" />
					</div>	
					<div class="form2">Тело новости: <b><?php $this->pop('body-failed');?></b><br />
						<textarea style="height: 400px; width: 100%;" name="body"><?php $this->pop('body'); ?></textarea>
					</div>
					<br />
					<div >		
						<input type="submit" value="Сохранить">
						
					</div>		
				</form>            
            
</div>