<div class="img-box1">
 <div class="box">
  <div class="left-top-corner">
    <div class="right-top-corner">
      <div class="right-bot-corner">
        <div class="left-bot-corner">
          <div class="inner">
            <form action="?cmd=doSave" method="post" id="signup" >
            <input type="hidden" name="uid" value="<?php $this->pop('uid');?>">
            <input type="hidden" name="ref_id" value="<?php $this->pop('ref_id');?>">
               <div class="form1">Логин: <font color="red">*</font>&nbsp;<b><?php $this->pop('username-failed');?></b><br />
                 <input type="text" name="username" value="<?php $this->pop('username');?>">
               </div>
               <div class="form1">Пароль: <font color="red">*</font>&nbsp;<b><?php $this->pop('password-failed');?></b><br />
                 <input type="text" name="password" value="<?php $this->pop('password');?>">
               </div>
               <div class="form1">Повторить пароль: <font color="red">*</font><br />
                 <input type="text" name="password1" value="<?php $this->pop('password1');?>">
               </div>
               <div class="form1">E-mail: <font color="red">*</font>&nbsp;<b><?php $this->pop('email-failed');?></b><br />
                 <input type="text" name="email" value="<?php $this->pop('email');?>">
               </div>
               <div class="form1">Имя:<br />
                 <input type="text" name="first_name" value="<?php $this->pop('first_name');?>">
               </div>
               <div class="form1">Фамилия:<br />
                 <input type="text" name="last_name" value="<?php $this->pop('last_name');?>">
               </div>
               <div class="wrapper" style="align:left"><a href="#" class="link4" onclick="document.getElementById('signup').submit()"><em><b><?php $this->pop('action');?></b></em></a></div>
             </form>
            
          	</div>
        	</div>
 		  </div>
 	   </div>
    </div>				
  </div>	
</div>