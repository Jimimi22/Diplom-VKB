<style type="text/css">
.shoutbox {
	height: 250px;
	background: #ded6b6; 
	border:1px solid #dfe4e4; 
	padding:3px 0 3px 3px;
	overflow: auto;
}
.shoutbox img {float: none; margin: 0px;}

.shoutbox ul {
	color: #000;
}
.shoutbox ul li {
	padding-top: 5px;
	padding-bottom: 5px;
	border-bottom: 1px dashed #2A241D;
}
</style>
<div class="indent1">
  <div class="box">
    <div class="left-top-corner">
      <div class="right-top-corner">
        <div class="right-bot-corner">
          <div class="left-bot-corner">
            <div class="inner">
				<div id="container" class="shoutbox">
					<div class="content">
						<ul></ul>
					</div>
				</div>
				<br />
				<input type="hidden" id="user" value="<?php echo $this->_USER['username']; ?>"  />
				<div class="form1">Сообщение:<br />
					<input type="text" id="message"  />	
				</div>
				<SCRIPT LANGUAGE="JavaScript">
				function InsertSmile(smile){
				           var txt = document.getElementById('message');
				           txt.value+=''+smile+'';
				 }
				</script>  
				<div class="form1" style="background-color: #ded6b6;">
				<a href="javascript: InsertSmile(':-)')"><img src='/resources/images/smiles/ab.gif'></a>
				<a href="javascript: InsertSmile(':-(')"><img src='/resources/images/smiles/ac.gif'></a>
				<a href="javascript: InsertSmile(':-D')"><img src='/resources/images/smiles/ag.gif'></a>
				<a href="javascript: InsertSmile(';-)')"><img src='/resources/images/smiles/ad.gif'></a>
				<a href="javascript: InsertSmile('*ROFL*')"><img src='/resources/images/smiles/bj.gif'></a>
				<a href="javascript: InsertSmile('>:o')"><img src='/resources/images/smiles/am.gif'></a>
				<a href="javascript: InsertSmile('*BRAVO*')"><img src='/resources/images/smiles/bi.gif'></a>
				<a href="javascript: InsertSmile('*OK*')"><img src='/resources/images/smiles/bf.gif'></a>
				<a href="javascript: InsertSmile('=-O')"><img src='/resources/images/smiles/ai.gif'></a>
				<!--<a href="javascript: InsertSmile(']->')"><img src='/resources/images/smiles/aq.gif'></a>-->
				</div>
				<div class="wrapper" style="padding-top:  10px;">
					<div style="float: left; fomt-size: 10px; margin-right: 10px;">Нажмите "Enter" или кнопку<br />для отправки</div>
				    <a href="#" id="shoutbox" class="link4"><em><b>Отправить</b></em></a>
				</div>            
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
