<?php 
	//echo $this->Html->css('profile.css');
?>

<script type="text/javascript">
	jQuery(document).ready(function() {
			
	});
function submitNewTopic(form){
	if(!validate(form)) return;
	loading();
	jQuery.post('<?=$this->Html->url('/Webboard/ajaxSubmitNewTopic');?>'
		,{'data':{'txtQuestion':form.txtQuestion.value
					,'txtDetails':form.txtDetails.value,
					'txtName': form.txtName.value}}
		,function(data){
			unloading();

			jAlert(data.msg
					, function(){ 
						if( data.flg===1 ){
							window.location.replace("<?=$this->Html->url('/Webboard/index')?>");
						}
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);
		}
		,'json');
}
function validate(form){
	if(jQuery.trim(form.txtQuestion.value)!="" && jQuery.trim(form.txtDetails.value)!=""){
		return true;
	}else{
		jAlert('คุณกรอกข้อมูล ไม่ครบ', 
				function(){ //okFunc
				}, 
				function(){ //openFunc
				}, 
				function(){ //closeFunc
				}
				);
		return false
	}
}
</script>
<div style="padding:5px;">
<h2 style="margin-bottom: 10px;">Webboard - New Topic</h2>
<hr />
<form action="NewQuestion.php?Action=Save" method="post" name="frmMain" id="frmMain">
  <table width="621" border="1" cellpadding="1" cellspacing="1" bordercolor="#eeeeee">
    <tr>
      <td>Question</td>
      <td><input name="txtQuestion" type="text" id="txtQuestion" value="" size="70"></td>
    </tr>
    <tr>
      <td width="78">Details</td>
      <td><textarea name="txtDetails" cols="50" rows="5" id="txtDetails"></textarea></td>
    </tr>
    <tr>
      <td width="78">Name</td>
      <td width="647"><input name="txtName" type="text" id="txtName" value="<?php echo $objuser['nameth'].' '.$objuser['lastnameth']; ?>" readonly="readonly" size="50"></td>
    </tr>
  </table>
  <input name="btnSave" type="button" id="btnSave" value="Submit" onclick="submitNewTopic(this.form);" />
  <input type="button" value="Back" onclick="javascript:history.back();" />
</form>
</div>