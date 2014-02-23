<?php 
	//echo $this->Html->css('profile.css');
?>

<script type="text/javascript">
	jQuery(document).ready(function() {
			
	});
function submitNewTopic(form){
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
</script>

<form action="NewQuestion.php?Action=Save" method="post" name="frmMain" id="frmMain">
  <table width="621" border="1" cellpadding="1" cellspacing="1">
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
</form>