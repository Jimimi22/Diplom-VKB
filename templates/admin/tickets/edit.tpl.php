<script>
function filterlist(selectobj) {

  // VARIABLES

  // HTML SELECT object
  this.selectobj = selectobj;

  // Flags for regexp matching.
  // "i" = ignore case; "" = do not ignore case
  this.flags = "i";

  // Make a copy of the options array
  this.optionscopy = new Array();
  for (var i=0; i < selectobj.options.length; i++) {
    this.optionscopy[i] = new Option();
    this.optionscopy[i].text = selectobj.options[i].text;
    this.optionscopy[i].value = selectobj.options[i].value;
  }

  //==================================================
  // METHODS
  //==================================================

  //--------------------------------------------------
  this.reset = function() {
  // This method resets the select list to the original state.
  // It also unselects all of the options.

    this.set("");
  }

  //--------------------------------------------------
  this.set = function(pattern) {
  // This method removes all of the options from the select list,
  // then adds only the options that match the pattern regexp.
  // It also unselects all of the options.
  // In case of a regexp error, returns false

    var loop=0, index=0, regexp, e;

    // Clear the select list so nothing is displayed
    this.selectobj.options.length = 0;

    // Set up the regular expression
    try {
      regexp = new RegExp(pattern, this.flags);
    } catch(e) {
      return;
    }

    // Loop through the entire select list
    for (loop=0; loop < this.optionscopy.length; loop++) {

      // Check if we have a match
      if (regexp.test(this.optionscopy[loop].text)) {

        // We have a match, so add this option to the select list
        this.selectobj.options.length = index + 1;
        this.selectobj.options[index].text = this.optionscopy[loop].text;
        this.selectobj.options[index].value = this.optionscopy[loop].value;
        this.selectobj.options[index].selected = false;

        // Increment the index
        index++;
      }
    }
  }

  //--------------------------------------------------
  this.set_ignore_case = function(value) {
  // This method sets the regexp flags.
  // If value is true, sets the flags to "i".
  // If value is false, sets the flags to "".

    if (value) {
      this.flags = "i";
    } else {
      this.flags = "";
    }
  }

}

</script>
<ul>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=index">Входящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=outbox">Исходящие</a></li>
	<li style="float: left; margin-right: 10px;">
		<a href="?cmd=compose" style="color: #fff;">Отправить новое</a></li>		
</ul>
<br /><br />
<div class="indent1">
  <div class="box">
    <div class="left-top-corner">
      <div class="right-top-corner">
        <div class="right-bot-corner">
          <div class="left-bot-corner">
            <div class="inner">
				<form action="?cmd=doCompose" method="post" id="compose" name="compose">
					<div class="form1">Тема: <b><?php $this->pop('subj-failed');?></b><br />
						<input type="text" name="subj" value="<?php $this->pop('subj');?>" />
					</div>	
					<div class="form2">Сообщение: <b><?php $this->pop('message-failed');?></b><br />
						<textarea style="height: 200px; width: 400px;" name="message"><?php $this->pop('message'); ?></textarea>
					</div>
					
					<div class="form1">Поиск: <br />
					<INPUT type="text" onkeyup=myfilter.set(this.value) name=regexp>
					</div>
					<div class="form2">Пользователи: <b><?php $this->pop('to-failed');?></b><br />
						<select name="to[]" id="to" multiple="multiple" size="15" style="width: 300px;">
						<?php foreach ($this->users as $key => $value) {?>
						<option value="<?php echo $key?>" 
						<?php if (@in_array($key, $this->to)) {
						    echo 'selected';
						} ?>
						>
							<?php echo $value; ?></option>
						<?php } // end foreach ?>
						</select>
					<SCRIPT type=text/javascript>
					<!--
					var myfilter = new filterlist(document.getElementById('to'));
					//-->
					</SCRIPT>	
					</div>
					<br />
					
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