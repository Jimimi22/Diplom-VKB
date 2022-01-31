<div class="art-PostContent">
				<form action="?cmd=pointsLimit" enctype="multipart/form-data" method="post" id="edit">
					<input type="hidden" name="is_points" value="1">
					<div class="form1">К-во баллов: <b><?php $this->pop('points-failed');?></b><br />
						<input type="text" name="points" value="<?php $this->pop('points');?>" />
					</div>	
					<div class="wrapper"><br /><br />		
						<input type="submit" value="Сохранить">
					</div>		
				</form>            
           
</div>