<div class="art-PostContent">
				<form action="?cmd=doEdit" method="post" id="edit">
					<input type="hidden" name="id" value="<?php $this->pop('id'); ?>">
					<div class="form1">Дисциплина: <b><?php $this->pop('caption-failed');?></b><br />
						<input type="text" name="discipline" value="<?php $this->pop('discipline');?>" />
					</div>	
					<br />
					<div class="wrapper">		
						<input type="submit" value="Сохранить">
					</div>		
				</form>            
           
</div>