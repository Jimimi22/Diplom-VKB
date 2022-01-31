<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=index">Входящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=outbox">Исходящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=compose" style="color: #fff;">Отправить сообщение</a></li>		
</ul>
<br /><br />
<div class="indent1">
  <div class="box">
    <div class="left-top-corner">
      <div class="right-top-corner">
        <div class="right-bot-corner">
          <div class="left-bot-corner">
            <div class="inner">
				<form action="?cmd=doCompose" method="post" id="compose">
					<input type="hidden" name="to" value="<?php $this->pop('to'); ?>">
					<div class="form1">Тема: <b><?php $this->pop('subj-failed');?></b><br />
						<input type="text" name="subj" value="<?php $this->pop('subj');?>" />
					</div>	
					<div class="form2">Сообщение: <b><?php $this->pop('message-failed');?></b><br />
						<textarea style="height: 200px; width: 400px;" name="message"><?php $this->pop('message'); ?></textarea>
					</div>
					<div class="wrapper">		
						<a href="#" onclick="document.getElementById('compose').submit(); return false;">
							<img src="../resources/images/send-button.png"></a>
					</div>		
				</form>            
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>