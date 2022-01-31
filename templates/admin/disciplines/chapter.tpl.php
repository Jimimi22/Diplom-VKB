<div class="indent1">
  <div class="box">
    <div class="left-top-corner">
      <div class="right-top-corner">
        <div class="right-bot-corner">
          <div class="left-bot-corner">
            <div class="inner">
				<form action="?cmd=doEditChapter" method="post" id="edit">
					<input type="hidden" name="id" value="<?php $this->pop('id'); ?>">
					<input type="hidden" name="id_dis" value="<?php $this->pop('id_dis'); ?>">
					<div class="form1">
						<b><?php $this->pop('chapter');?></b>
					</div>	
					<br />
					<div><?php $this->pop('body');?>
					</div>	
					
				</form>            
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>