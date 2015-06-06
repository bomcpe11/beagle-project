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
			var html = '<div id="jdialog1-container" style="width:500px;">\
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
			// Example to close with script ==> closePopup('#jdialog1-container');
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

<!-- ####################  IMAGE BUTTON  ########################################## -->
<h3>- IMAGE BUTTON</h3>
<table border="1" id="imgbutton1">
	<tr>
		<th>Head1</th>
		<th>Head2</th>
		<th>Head3</th>
		<th>Edit</th>
		<th>Delete</th>
	</tr>
	<tr>
		<td>abc</td>
		<td>abc</td>
		<td>abc</td>
		<td style="text-align: center;cursor:pointer;"><img src="<?php echo $this->Html->url('/img/icon_edit.png'); ?>" width="16" height="16" /></td>
		<td style="text-align: center;cursor:pointer;"><img src="<?php echo $this->Html->url('/img/icon_del.png'); ?>" width="16" height="16" /></td>
	</tr>
	<tr>
		<td>abc2</td>
		<td>abc2</td>
		<td>abc2</td>
		<td style="text-align: center;cursor:pointer;"><img src="<?php echo $this->Html->url('/img/icon_edit.png'); ?>" width="16" height="16" /></td>
		<td style="text-align: center;cursor:pointer;"><img src="<?php echo $this->Html->url('/img/icon_del.png'); ?>" width="16" height="16" /></td>
	</tr>
	<tr>
		<td>abc3</td>
		<td>abc3</td>
		<td>abc3</td>
		<td style="text-align: center;cursor:pointer;"><img src="<?php echo $this->Html->url('/img/icon_edit.png'); ?>" width="16" height="16" /></td>
		<td style="text-align: center;cursor:pointer;"><img src="<?php echo $this->Html->url('/img/icon_del.png'); ?>" width="16" height="16" /></td>
	</tr>
	<tr>
		<td colspan="5" style="text-align: center;"><input type="button" id="btnAddRow" value="Add another rows" /></td>
	</tr>
</table><br />
<div style="border: 1px solid black;">
<b>EXAMPLE</b><br />
<b>Via PHP Syntax</b><br />
&lt;img src=&quot;&lt;?php echo $this-&gt;Html-&gt;url('/img/icon_edit.png'); ?&gt;&quot; width=&quot;16&quot; height=&quot;16&quot; /&gt;<br/>&lt;img src=&quot;&lt;?php echo $this-&gt;Html-&gt;url('/img/icon_del.png'); ?&gt;&quot; width=&quot;16&quot; height=&quot;16&quot; /&gt;
<br /><br />
<b>Via Javascript Syntax</b><br />
'&lt;img src=&quot;'+getURL('/img/icon_edit.png')+'&quot; width=&quot;16&quot; height=&quot;16&quot; /&gt;';
</div>
<script type="text/javascript">
	jQuery('table#imgbutton1 input#btnAddRow').click(function(){
		var tr = jQuery(this).parent().parent();
		var html = '';
		html += '<tr>' 
			+ '<td>abc</td>'
			+ '<td>abc</td>'
			+ '<td>abc</td>'
			+ '<td style="text-align: center;cursor:pointer;"><img src="'+getURL('/img/icon_edit.png')+'" width="16" height="16" /></td>'
			+ '<td style="text-align: center;cursor:pointer;"><img src="'+getURL('/img/icon_del.png')+'" width="16" height="16" /></td>'
			+ '</tr>';
		tr.before(html);
	});
</script>

<!-- ####################  CKEDITOR & CKFINDER  ########################################## -->
<h3>- CKEDITOR</h3>
<textarea id="ckeditor1">
	This is my textarea to be replaced with CKEditor.
</textarea><br />
<input type="button" onclick="ckGetData()" value="getData()" /><br /><br />
<div style="border: 1px solid black;">
<b>Javascript Syntax Example</b><br />
1. Insert textarea :<br />
&lt;textarea id="ckeditor1" rows="10" cols="80"&gt;&lt;/textarea&gt;<br /><br />

2. Use ckeditor :<br />
CKEDITOR.replace( 'ckeditor1', {filebrowserImageUploadUrl : getURL('/activity/uploadImages')});<br /><br />

3. Get html data for insert :<br />
CKEDITOR.instances.ckeditor1.getData();
</div>
<script type="text/javascript">
	CKEDITOR.replace( 'ckeditor1', {filebrowserImageUploadUrl : getURL('/activity/uploadImages')});
	//CKEDITOR.instances.ckeditor1.insertHtml('<img src="xxx.jpg">');
	//CKEDITOR.instances.ckeditor1.getData();
	function ckGetData(){
		alert(CKEDITOR.instances.ckeditor1.getData());
	}
</script>













