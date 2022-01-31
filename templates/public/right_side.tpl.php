<div class="art-Block">
                  <div class="art-Block-body">
                      <div class="art-BlockHeader">
                          <div class="l"></div>
                          <div class="r"></div>
                          <div class="art-header-tag-icon">
                          <?php if(!isset($_SESSION['uid'])) { ?>
                              <div class="t">Вход</div>
                          <?php } else { ?>    
                          	  <div class="t">Добро пожаловать</div>
                          <?php } ?>    
                          </div>
                      </div><div class="art-BlockContent">
                          <div class="art-BlockContent-tl"></div>
                          <div class="art-BlockContent-tr"></div>
                          <div class="art-BlockContent-bl"></div>
                          <div class="art-BlockContent-br"></div>
                          <div class="art-BlockContent-tc"></div>
                          <div class="art-BlockContent-bc"></div>
                          <div class="art-BlockContent-cl"></div>
                          <div class="art-BlockContent-cr"></div>
                          <div class="art-BlockContent-cc"></div>
                          <div class="art-BlockContent-body">
                          <?php if(!isset($_SESSION['uid'])) { ?>
                              <div><form action="?cmd=doSignin" method="post" id="signin">
                              Логин:<br />
                              <input type="text" value="<?php $this->pop('login'); ?>" name="login" id="s" style="width: 95%;" />
							  Пароль:<br />
                              <input type="password" value="<?php $this->pop('password'); ?>" name="password" id="s" style="width: 95%;" />
                              <span class="art-button-wrapper">
                              	<span class="l"> </span>
                              	<span class="r"> </span>
                              	<input class="art-button" type="submit" name="search" value="Войти"/>
                              </span>
                              </form></div>
                          <?php } else { ?>
                          <div>Ваш никнейм: <?php echo $this->user['username'];  ?></div>
                          <?php } ?>    
                          </div>
                      </div>
                  </div>
</div>
<div class="art-Block">
	<div class="art-Block-body">
	    <div class="art-BlockHeader">
	        <div class="l"></div>
	        <div class="r"></div>
	        <div class="art-header-tag-icon">
	            <div class="t">Новости</div>
	        </div>
	    </div><div class="art-BlockContent">
	        <div class="art-BlockContent-tl"></div>
	        <div class="art-BlockContent-tr"></div>
	        <div class="art-BlockContent-bl"></div>
	        <div class="art-BlockContent-br"></div>
	        <div class="art-BlockContent-tc"></div>
	        <div class="art-BlockContent-bc"></div>
	        <div class="art-BlockContent-cl"></div>
	        <div class="art-BlockContent-cr"></div>
	        <div class="art-BlockContent-cc"></div>
	        <div class="art-BlockContent-body">
	            <div>
	            <?php if (($count = count($this->news))) {?>
				<?php for ($i = 0; $i < $count; $i++) {?>
				 <p><b><?php echo $this->news[$i]['posted']; ?></b><br/>
				 <?php echo $this->news[$i]['body']; ?>
				<?php }?>
				<?php }?>
	            </div>
	        </div>
	    </div>
	</div>
</div>


<div class="art-Block">
	<div class="art-Block-body">
	    <div class="art-BlockHeader">
	        <div class="l"></div>
	        <div class="r"></div>
	        <div class="art-header-tag-icon">
	            <div class="t">Наши контакты</div>
	        </div>
	    </div><div class="art-BlockContent">
	        <div class="art-BlockContent-tl"></div>
	        <div class="art-BlockContent-tr"></div>
	        <div class="art-BlockContent-bl"></div>
	        <div class="art-BlockContent-br"></div>
	        <div class="art-BlockContent-tc"></div>
	        <div class="art-BlockContent-bc"></div>
	        <div class="art-BlockContent-cl"></div>
	        <div class="art-BlockContent-cr"></div>
	        <div class="art-BlockContent-cc"></div>
	        <div class="art-BlockContent-body">
	            <div>
	                  <img src="/resources/images/contact.jpg" alt="an image" style="margin: 0 auto;display:block;width:95%" />
	            <br />
	            
	            </div>
	        </div>
	    </div>
	</div>
</div>