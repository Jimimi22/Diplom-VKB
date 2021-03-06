/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

$(document).ready(function(){
	//global vars
	var inputUser = $("#user");
	var inputMessage = $("#message");
	//var loading = $("#loading");
	var messageList = $(".content > ul");
	
	//functions
	function updateShoutbox(){
		//just for the fade effect
		/*messageList.hide();
		loading.fadeIn();
		*/
		//send the post to shoutbox.php
		$.ajax({
			type: "POST", url: "shoutbox.php", data: "cmd=update",
			complete: function(data){
				/*loading.fadeOut();*/
				messageList.html(data.responseText);
				/*				messageList.fadeIn(2000);*/
			}
		});
	}
	
	//check if all fields are filled
	function checkForm(){
		if(inputUser.attr("value") && inputMessage.attr("value"))
			return true;
		else
			return false;
	}
	
	//Load for the first time the shoutbox data
	//	updateShoutbox();
	//updateShoutbox();
	
	function send() {
		if(checkForm()){
			var nick = inputUser.attr("value");
			var message = inputMessage.attr("value");
			//we deactivate submit button while sending
			$("#shoutbox").html('<em><b>Sending...</b></em>');
			//send the post to shoutbox.php
			$.ajax({
				type: "POST", url: "shoutbox.php", data: "cmd=index&user=" + nick + "&message=" + message,
				complete: function(data){
					updateShoutbox();
					//reactivate the send button
					$("#shoutbox").html('<em><b>Отправить</b></em>');					
				}
			 });
		}
		else alert("Please fill all fields!");
		//we prevent the refresh of the page after submitting the form
		return false;	
	}
	
	//on submit event
	$("#shoutbox").click(send);
	
	$("#message").bind('keydown', 'return', send);
		
	updateShoutbox();
	$(document).everyTime(10000, function() {
		updateShoutbox();
	});
});