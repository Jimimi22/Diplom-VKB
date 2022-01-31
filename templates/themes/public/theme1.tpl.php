<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>YOUR TEST: адаптированная система тестирования </title>
<link href="../resources/styles/style.css" rel="stylesheet" type="text/css" />
<link href="../resources/styles/layout.css" rel="stylesheet" type="text/css" />

<script src="../resources/scripts/jquery.js" type="text/javascript"></script>
<script src="../resources/scripts/jquery.pngfix.js" type="text/javascript"></script>
<script src="../resources/scripts/rollover.js" type="text/javascript"></script>

<script type="text/javascript">
<!--
$(document).ready(function() {
	$(document).pngFix(); 	
});
//-->
</script>
<!-- Woopra Code Start -->
<script type="text/javascript">
var _wh = ((document.location.protocol=='https:') ? "https://sec1.woopra.com" : "http://static.woopra.com");
document.write(unescape("%3Cscript src='" + _wh + "/js/woopra.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<!-- Woopra Code End -->
<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
	var pageTracker = _gat._getTracker("UA-1058933-10");
	pageTracker._trackPageview();
} catch(err) {}
</script>

</head>
<body id="page1" onload="MM_preloadImages('/resources/images/m1a.png','/resources/images/m2a.png','/resources/images/m3a.png','/resources/images/m4a.png')">

<div id="main">
  <!-- header -->
  <div id="header">
    <div style="position: absolute; "><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                    codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,24"
           width="980" height="430">
      <param name="movie" value="../resources/header.swf" />
      <param name="quality" value="high" />
      <param name="menu" value="false" />
      <param name="wmode" value="transparent" />
      <!--[if !IE]> <-->
      <object data="../resources/header.swf"
           width="980" height="430" type="application/x-shockwave-flash">
        <param name="quality" value="high" />
        <param name="menu" value="false" />
        <param name="pluginurl" value="http://www.macromedia.com/go/getflashplayer" />
        <param name="wmode" value="transparent" />
        FAIL (the browser should render some flash content, not this).
      </object>
      <!--> <![endif]-->
    </object></div>
    
    <div style="position: absolute; padding-top:12px; padding-left:20px; z-index: 1000;">
	<ul class="list">
          <li><?php 
          	echo date('l, d. F Y, H:i \U\T\C O', time()); ?></li>
        </ul>
    </div>
    <div style="position: absolute; padding-top:45px; padding-left:30px;">
    	<img src="../resources/images/company-logo.png">
    </div>
    <div style="position: absolute; padding-top:212px; padding-left:30px;" class="row-3">
       <ul class="site-nav">
            <li><a href="/" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('m1','','/resources/images/m1a.png',1)">
            	<img src="/resources/images/m1<?php if ($this->_MENUITEM == 'home') {echo 'a'; }?>.png" alt="" id="m1" /></a></li>
            <!-- 
            <li><a href="signup.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('m2','','/resources/images/m2a.png',1)">
            	<img src="../resources/images/m2<?php if ($this->_MENUITEM == 'signup' || $this->_MENUITEM == 'signup_done') {echo 'a'; }?>.png" alt="" id="m2" /></a></li>
             -->		
            <li><a href="faq.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('m3','','/resources/images/m3a.png',1)">
            	<img src="../resources/images/m3<?php if ($this->_MENUITEM == 'faq') {echo 'a'; }?>.png" alt="" id="m3" /></a></li>
            <li style="padding-left: 10px;"><a href="contacts.php" onmouseout="MM_swapImgRestore()" onmouseover="MM_swapImage('m4','','/resources/images/m4a.png',1)">
            	<img src="../resources/images/m4<?php if ($this->_MENUITEM == 'contacts') {echo 'a'; }?>.png" alt="" id="m4" /></a></li>
        </ul>
     </div>
   
  </div>
  <!-- content -->
  <div id="content">
    <div class="container">
      <div class="col-1">
        <div class="indent">
          <div class="title">
          <img src="../resources/images/<?
              switch ($this->_MENUITEM) {
                case 'home':
                    echo 'about.png';
                    break;
                case 'faq':
					echo 'faq.png';
					break;
                case 'contacts':
					echo 'contacts.png';
					break;                      
				case 'signup':
					echo 'signup.png';
					break;                      	
				case 'signup_done':
					echo 'done.png';
					break;                      		
              }
          ?>" />
          </div>
          <div class="img-box1">
    		<?php 
    		    $this->call('messages', true);
    		    $this->call('messages', false);    		    
    		    echo $this->_CONTENT; ?>
          </div>
          <?php if ($this->_MENUITEM == 'home') {
              $this->inc('public/what-we-can.tpl.php'); 
          } ?>
        </div>
      </div>
      <div class="col-2">
        <div class="indent1">
          <div class="box">
            <div class="left-top-corner">
              <div class="right-top-corner">
                <div class="right-bot-corner">
                  <div class="left-bot-corner">
                    <div class="inner">
                      <div class="title"><img src="../resources/images/log-in.png">	</div>
					  
                      <form action="?cmd=doSignin" method="post" id="signin">
                        <div class="form1">Логин: <b><?php $this->pop('login-failed');?></b><br />
                          <input type="text" name="login" value="<?php $this->pop('login'); ?>" />
                        </div>
                        <div class="form1">Пароль: <b><?php $this->pop('password-failed');?></b><br />
                          <input type="password" name="password" value="<?php $this->pop('password'); ?>" />
                        </div>
                        <div class="wrapper"><a href="#" class="link3" onclick="document.getElementById('signin').submit()"><em><b>Войти</b></em></a></div>
                      </form>
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php $this->inc('public/feedback.tpl.php'); ?>
        </div>
      </div>
      <div class="clear"></div>
    </div>
  </div>
  <!-- footer -->
  <div id="footer">
    <p><?php echo strtoupper($_SERVER['HTTP_HOST']); ?> &copy; <?php echo date('Y');?></p>
  </div>
</div>
</body>
</html>