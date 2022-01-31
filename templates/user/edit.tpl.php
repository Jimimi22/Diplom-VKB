<script>
(function($) {	
	$.pay_info = function(url) {
		$.ajax({
			url      : url,
			success  : function (data) {
				$('#pay_info').html(data);
			}
	});
}
})(jQuery);
</script>
<div class="art-PostContent">
 <form action="?cmd=doSave" method="post" id="signup" >
 <input type="hidden" name="uid" value="<?php $this->pop('uid');?>">
 <input type="hidden" name="ref_id" value="<?php $this->pop('ref_id');?>">
    <div class="form1">Логин: <font color="red">*</font>&nbsp;<b><?php $this->pop('username-failed');?></b><br />
      <input type="text" style="width: 300px" name="username" value="<?php $this->pop('username');?>">
    </div>
    <?php if($this->update == 'yes') { ?>
    <div class="form1">Пароль: <font color="red">*</font>&nbsp;<b><?php $this->pop('password-failed');?></b><br />
      <input type="text" style="width: 300px" name="password" value="<?php $this->pop('password');?>">
    </div>
    <div class="form1">Повторите пароль: <font color="red">*</font>&nbsp;<b><?php $this->pop('password1-failed');?></b><br />
      <input type="text" style="width: 300px" name="password1" value="<?php $this->pop('password1');?>">
    </div>
    <?php } ?>
    <div class="form1">E-mail адрес: <font color="red">*</font>&nbsp;<b><?php $this->pop('email-failed');?></b><br />
      <input type="text" style="width: 300px" name="email" value="<?php $this->pop('email');?>">
    </div>
    <div class="form1">Имя:<br />
      <input type="text" style="width: 300px" name="first_name" value="<?php $this->pop('first_name');?>">
    </div>
    <div class="form1">Фамилия:<br />
      <input type="text" style="width: 300px" name="last_name" value="<?php $this->pop('last_name');?>">
    </div>
    <div class="form1">URL:<br />
      <input type="text" style="width: 300px" name="url" value="<?php $this->pop('url');?>">
    </div>
    <div class="form1">Tип месенджера: <br />
      <select name="mesenger" >
      	<option value="0" <?php if($this->mesenger == 0) echo 'selected';?> />--NONE--</option>
      	<option value="1" <?php if($this->mesenger == 1) echo 'selected';?> />--ICQ--</option>
      	<option value="2" <?php if($this->mesenger == 2) echo 'selected';?> />--MSN--</option>
      	<option value="3" <?php if($this->mesenger == 3) echo 'selected';?> />--AOL--</option>
      	<option value="4" <?php if($this->mesenger == 4) echo 'selected';?> />--YAHOO!--</option>
      </select>
     
    </div>
    <div class="form1">ID месенджера:<br />
      <input type="text" style="width: 300px" name="id_mes" value="<?php $this->pop('id_mes');?>">
    </div>
    
     <div class="form1">О себе: <font color="red">*</font>&nbsp;<b><?php $this->pop('pay-info-failed');?></b><br />
      <textarea name="user_info" rows="3" cols="35"><?php $this->pop('payment_info');?></textarea>
    </div>
    
    <div class="form1"><br />
      <input type="submit" value="Создать аккаунт">
    </div>
    
  </form>
</div>