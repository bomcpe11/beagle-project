<?php

?>

<h2>Welcome to JSTP HUB</h2>

<!-- ####################  DATE PICKER EXAMPLE  ########################################## -->
<script type="text/javascript">
jQuery(document).ready(function(){
	setDatePicker('.datePicker');
	setBirthDatePicker('.birthDatePicker');
});
</script>
<h3>- DATE PICKER EXAMPLE</h3>
<p>
Date : <input type="text" class="datePicker" /><br />
Birth Date :<input type="text" class="birthDatePicker" />
</p>


<!-- ####################  JQUERY DIALOG EXAMPLE  ########################################## -->
<h3>- JQUERY DIALOG EXAMPLE</h3>
<p>
<input type="button" id="jdialog1" value="open Popup" />
</p>
<script type="text/javascript">
	/*Syntax : void openPopupHtml(String title, String html, ObjectArray buttons, function openFunc, function closeFunc, boolean isPutCloseBtn=true)*/
	jQuery('#jdialog1').click(function(){
			var html = '<div style="width:500px;">\
										<h4>Welcome to jQuery Dialog</h4>\
										<div class="popup1">ABCDEFG</div>\
									</div>';
			var buttons = [
			   			{text: "Button1", click: function(){alert('Button1');}},
			   			{text: "Button2", click: function(){alert('Button2');}},
			   			{text: "Button3", click: function(){alert('Button3');}}
			];
			openPopupHtml('Test Popup1', html, buttons, 
					function(){ //openFunc
						jQuery('.popup1').append(' TEST AFTER');
						alert('opened');
					}, 
					function(){ //closeFunc
						alert('closed');
					}
			);
		});
</script>


<!-- ####################  ALERT EXAMPLE  ########################################## -->
<h3>- ALERT EXAMPLE</h3>
<p>
<input type="button" id="jalert1" value="open Alert" />
</p>
<script type="text/javascript">
	/*Syntax : void fAlert(String msg, function okFunc, function openFunc, function closeFunc)*/
	jQuery('#jalert1').click(function(){
		jAlert('TEST ALERT', 
				function(){ //okFunc
					alert('OK'); 
				}, 
				function(){ //openFunc
					alert('Open'); 
				}, 
				function(){ //closeFunc
					alert('Close'); 
				}
		);
	});
</script>


<!-- ####################  CONFIRM EXAMPLE  ########################################## -->
<h3>- CONFIRM EXAMPLE</h3>
<p>
<input type="button" id="jconfirm1" value="open Confirm" />
</p>
<script type="text/javascript">
	/*Syntax : void fAlert(String msg, function okFunc, function openFunc, function closeFunc)*/
	jQuery('#jconfirm1').click(function(){
		jConfirm('TEST CONFIRM?', 
				function(){ //okFunc
					alert('OK'); 
				}, 
				function(){ //cancelFunc
					alert('Cancel'); 
				}, 
				function(){ //openFunc
					alert('Open'); 
				}, 
				function(){ //closeFunc
					alert('Close'); 
				}
		);
	});
</script>

