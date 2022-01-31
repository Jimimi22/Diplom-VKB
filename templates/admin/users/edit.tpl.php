<div class="art-PostContent">
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
               <div class="form1">Тип мессенджера: <br />
                 <select name="mesenger">
                 	<option value="0" <?php if($this->mesenger == 0) echo 'selected';?> />--NONE--</option>
                 	<option value="1" <?php if($this->mesenger == 1) echo 'selected';?> />--ICQ--</option>
                 	<option value="2" <?php if($this->mesenger == 2) echo 'selected';?> />--MSN--</option>
                 	<option value="3" <?php if($this->mesenger == 3) echo 'selected';?> />--AOL--</option>
                 	<option value="4" <?php if($this->mesenger == 4) echo 'selected';?> />--YAHOO!--</option>
                 </select>
               </div>
               <div class="form1">ID мессенджера:<br />
                 <input type="text" name="id_mes" value="<?php $this->pop('id_mes');?>">
               </div>
               <div >Статус:<br />
                 <table border="0" width="15%">
                 <tr>
                 	<td align="left">
                 		Активный
                 	</td>
                 	<td align="left" >
                 		 <input type="radio" name="is_active" value="1" <?php if($this->is_active == 1) echo 'checked'; ?> />
                 	</td>	
                 	<td align="left" >
                 		Блокированный
                 	</td>
                 	<td align="left" >
                 		 <input type="radio" name="is_active" value="0"  <?php if($this->is_active == 0) echo 'checked'; ?> />
                 	</td>	
                 </table>
               </div>
               <br />
               <div style="align:left"><input type="submit" value="<?php $this->pop('action');?>"></div>
             </form>
            
          	
</div>