<div class="indent1">
  <div class="box">
    <div class="left-top-corner">
      <div class="right-top-corner">
        <div class="right-bot-corner">
          <div class="left-bot-corner">
            <div class="inner">
				<form action="?cmd=doEdit" method="post" id="edit">
					<input type="hidden" name="id" value="<?php $this->pop('id'); ?>">
					<div class="form1">Название главы: <b><?php $this->pop('chdpter-failed');?></b><br />
						<input type="text" name="chapter" value="<?php $this->pop('chapter');?>" />
					</div>	
					<br />
					<div class="form1">Содержание главы: <b><?php $this->pop('body-failed');?></b><br />
						<?php $this->call('form-element/ext/fckeditor', 'body', $this->body, 'engine'); ?>
					</div>
					<br />
					<div class="wrapper">		
						<a href="#" class="link4" onclick="document.getElementById('edit').submit(); return false;"><em><b>Сохранить</b></em></a>
						<a href="?cmd=index" class="link4" style="margin-left: 20px;"><em><b>Отмена</b></em></a>
					</div>		
				</form>            
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>