<?php 
	//echo $this->Html->css('profile.css');
?>

<script type="text/javascript">
	jQuery(document).ready(function() {
			
	});
function submitReply(form){
	if(!validateReply(form)) return;
	loading();
	jQuery.post('<?=$this->Html->url('/Webboard/ajaxSubmitReply');?>'
		,{'data':{'hidQuestionID':form.hidQuestionID.value
					,'txtDetails':form.txtDetails.value,
					'txtName': form.txtName.value}}
		,function(data){
			unloading();

			jAlert(data.msg
					, function(){ 
						if( data.flg===1 ){
							window.location.reload();
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
function validateReply(form){
	if(jQuery.trim(form.txtDetails.value)!=""){
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
<div style="padding:20px; 5px; 0 5px;">
<?php 
if(count($webboard)>0){
?>

<table width="98%" border="1" cellpadding="1" cellspacing="1" bordercolor="#eeeeee">
  <tr>
    <td colspan="2"><center><h2><?=$webboard[0]["webboards"]["Question"];?></h2></center><hr /></td>
  </tr>
  <tr>
    <td height="53" colspan="2"><?=nl2br($webboard[0]["webboards"]["Details"]);?></td>
  </tr>
  <tr>
    <td width="397">Name : <?=$webboard[0]["webboards"]["Name"];?> Create Date : <?=$webboard[0]["webboards"]["CreateDate"];?></td>
    <td width="253">View : <?=$webboard[0]["webboards"]["View"];?> Reply : <?=$webboard[0]["webboards"]["Reply"];?></td>
  </tr>
</table>
<hr />
<?
for($i=0; $i<count($replies); $i++){
?> No : <?=($i+1);?>
<table width="98%" border="1" cellpadding="1" cellspacing="1" bordercolor="#eeeeee">
  <tr>
    <td height="" colspan="2"><?=nl2br($replies[$i]["webboard_replies"]["Details"]);?></td>
  </tr>
  <tr>
    <td width="">Name :
        <?=$replies[$i]["webboard_replies"]["Name"];?>      </td>
    <td width="">Create Date :
    <?=$replies[$i]["webboard_replies"]["CreateDate"];?></td>
  </tr>
</table><hr />
<?
}
?>
<form action="" method="post" name="frmMain" id="frmMain">
  <input type="hidden" name="hidQuestionID" value="<?=$webboard[0]["webboards"]["QuestionID"]?>" />
  <table width="738" border="1" cellpadding="1" cellspacing="1" bordercolor="#eeeeee">
    <tr>
      <td width="78">Details</td>
      <td><textarea name="txtDetails" cols="50" rows="5" id="txtDetails"></textarea></td>
    </tr>
    <tr>
      <td width="78">Name</td>
      <td width="647"><input name="txtName" type="text" id="txtName" value="<?php echo $objuser['nameth'].' '.$objuser['lastnameth']; ?>" readonly="readonly" size="50"></td>
    </tr>
  </table>
  
  <input name="btnSave" type="button" id="btnSave" value="Submit" onclick="submitReply(this.form);" />
  <input type="button" value="Back" onclick="window.location.replace('<?=$this->Html->url('/Webboard/index')?>');" />
</form>
<?php 
}else{ echo "Error can't find QuestionID"; }
?>