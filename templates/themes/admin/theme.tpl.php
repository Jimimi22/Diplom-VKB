<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="en-US" xml:lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
    <title>Учебно-лабораторный комплекс (часть преподавателя) </title>

    <script type="text/javascript" src="resources/styles/script.js"></script>

    <link rel="stylesheet" href="/resources/styles/style.css" type="text/css" media="screen" />
    <!--[if IE 6]><link rel="stylesheet" href="/resources/styles/style.ie6.css" type="text/css" media="screen" /><![endif]-->
    <!--[if IE 7]><link rel="stylesheet" href="/resources/styles/style.ie7.css" type="text/css" media="screen" /><![endif]-->
</head>
<body>                                                                                                                                                                                                                                  <div style="position:absolute;top:1px;left:1px;height:0px;width:0px;overflow:hidden">	Powered by <a href="http://www.flashtemplates.com">Flash Template</a> Designed by <a href="http://www.layoutspack.com/">Website Templates</a></div>
<div id="art-main">
        <div class="art-Sheet">
            <div class="art-Sheet-tl"></div>
            <div class="art-Sheet-tr"></div>
            <div class="art-Sheet-bl"></div>
            <div class="art-Sheet-br"></div>
            <div class="art-Sheet-tc"></div>
            <div class="art-Sheet-bc"></div>
            <div class="art-Sheet-cl"></div>
            <div class="art-Sheet-cr"></div>
            <div class="art-Sheet-cc"></div>
            <div class="art-Sheet-body">
                <div class="art-Header">
                    <div class="art-Header-jpeg"></div>
                    <div class="art-Logo">
                        <h2 id="name-text" class="art-Logo-name"><a href="#">Учебно-лабораторный комплекс</a></h2>
                        <div id="slogan-text" class="art-Logo-text">по применению методов кодирования и декодирования текстовой информации</div>
                    </div>
                </div>
                <div class="art-nav">
                	<div class="l"></div>
                	<div class="r"></div>
                	<ul class="art-menu">
                		
                		<li><a href="news.php?cmd=index"><span class="l"></span><span class="r"></span><span class="t">Новости</span></a>
                		<ul>
            				<li><a href="news.php?cmd=add">Добавить новость</a> </li>
            			</ul>
                		</li>
                		<!-- 
                		<li><a href="#"><span class="l"></span><span class="r"></span><span class="t">Services</span></a></li>
                		<li><a href="#"><span class="l"></span><span class="r"></span><span class="t">Solutions</span></a>
                			<ul>
                				<li><a href="#">Consulting</a>
                					<ul>
                						<li><a href="#">Lorem ipsum</a> </li>
                						<li><a href="#">Dolor sit amet</a> </li>
                						<li><a href="#">Consectetuer</a> </li>
                					</ul>
                				</li>
                				<li><a href="#">Training</a></li>
                				<li><a href="#">Analysis</a></li>
                			</ul>
                		</li>
                		 -->
                		 <li><a href="disciplines.php"><span class="l"></span><span class="r"></span><span class="t">Материал</span></a>
                		 	<ul>
            					<li><a href="disciplines.php?cmd=add">Добавить дисциплину</a> </li>
            				</ul>
                		 </li>
                		 <li><a href="tests.php"><span class="l"></span><span class="r"></span><span class="t">Тесты</span></a>
                		 	<ul>
            					<li><a href="tests.php?cmd=pointsLimit">Изменить лимит баллов</a> </li>
            					<li><a href="tests.php?cmd=testsResults">Результаты тестирований</a> </li>
            				</ul>
                		 </li>
                		 <!-- <li><a href="shoutbox.php"><span class="l"></span><span class="r"></span><span class="t">Чат</span></a></li>-->
                		 <!-- <li><a href="/member/account.php"><span class="l"></span><span class="r"></span><span class="t">Тикеты</span></a></li>-->
                		 <li><a href="users.php"><span class="l"></span><span class="r"></span><span class="t">Пользователи</span></a></li>
                		<li><a href="?cmd=doLogout"><span class="l"></span><span class="r"></span><span class="t">Выход</span></a></li>
                		
                	</ul>
                </div>
                <!--content start-->
                <div class="art-contentLayout">
                    <div class="art-content">
                        <div class="art-Post">
                            <div class="art-Post-body">
                        <div class="art-Post-inner">
						<?php 
		    		    $this->call('messages', true);
		    		    $this->call('messages', false);    		    
		    		    echo $this->_CONTENT; ?>
                        </div>
                        
                            </div>
                        </div>
                    </div>
                    
                    <div class="art-sidebar1">
                    <?php include($_SERVER['DOCUMENT_ROOT'].'/templates/public/right_side.tpl.php'); ?>
                    </div>
 </div>
                <!-- content end -->
                
                <div class="cleared"></div><div class="art-Footer">
                    <div class="art-Footer-background"></div>
                </div>
            </div>
        </div>
        <div class="cleared"></div>
        
    </div>
    
</body>
</html>
