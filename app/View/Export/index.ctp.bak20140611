<!-- -----------------------------------[Start Page Export]------------------------------------------------------------ -->
<?php echo $this->Html->css("export");?>

<script type="text/javascript">
//-------------------------------------------------------------------------------------------------
jQuery(document).ready(function(){
// 	jQuery("#exportFileBtn").click(function() {doExportFile();});
// 	jQuery("input[type=radio]").click(function() {doSelectMode();});
// 	jQuery("#select_cardtype").change(function() {changeSelectDataName();});
	
});
//-------------------------------------------------------------------------------------------------
// function doExportFile(){
//   var exportType = jQuery("#exportType").val();
//   var mode = jQuery("input:checked").val();
//   var stmt = jQuery("#stmt").val();  
//   var selectDataName = jQuery("#selectDataName").val();  
//   var selectDataNameId = jQuery("#select_cardtype").val();  
  
//   if(exportType == ""){
// 	  jAlert('กรุณาเลือกรูปแบบไฟล์!', function(){},function(){},function(){});
// 	  return false;
//   }

//   if(mode == 2 && selectDataName == ""){
// 	  jAlert('กรุณาระบุชื่อในช่องเลือกข้อมูล!', function(){},function(){},function(){});
// 	  return false;
//   }else if(mode == 1 && selectDataNameId == ""){
// 	  jAlert('กรุณาเลือกข้อมูล!', function(){},function(){},function(){});
// 	  return false;
//   }

  jQuery.post("<?php echo $this->Html->url('/Export/export');?>", {"exportType":exportType,
// 			   													   "mode":mode,
// 			   													   "stmt":stmt,
// 			   													   "selectDataName":selectDataName,
// 			   													   "selectDataNameId":selectDataNameId}
// 			, function(data) {
// 				if(data.status.id==1) {	
// 					jAlert('ดำเนินการเรียบร้อย!', function(){
// 						                        jQuery(window.location).attr('href',G_WEB_ROOT+"data.csv");
// 						                  }
// 	                                   ,function(){}
// 	                                   ,function(){});
// 				}else{
// 					jAlert('เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ!', function(){},function(){},function(){});
// 			    }
			    
// 			},"json").error(function() {
// 			}
// 	);
	
// }
// //-------------------------------------------------------------------------------------------------
// function doSelectMode(){
// 	var mode = jQuery("input:checked").val();

// 	if(mode == 1){
// 		jQuery('#mode2').css("display", "none");
// 		jQuery('#mode1').css("display", "inline");
// 	}else{
// 		jQuery('#mode1').css("display", "none");
// 		jQuery('#mode2').css("display", "inline");
// 	}
// }
// //-------------------------------------------------------------------------------------------------
// function changeSelectDataName(){
// 	var id = jQuery("#select_cardtype").val();  
// 	jQuery("#stmt").val(jQuery("#select_cardtype option:selected").attr('strStmt'));
	
// }
//-------------------------------------------------------------------------------------------------
</script>
<form action="<?=$this->Html->url('/Export/export')?>" method="post">
<table width="100%">
	<tr>
		<td><input type="submit" value="Export" /></td>
	</tr>
		<tr>
		<td>
			<h4>Profiles</h4>
			<div style="padding-left:30px;">
				<input type="checkbox" name="datas[profiles][]" id="profiles-id" value="id" /><label for="profiles-id">id</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-cardid" value="cardid" /><label for="profiles-cardid">cardid</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-cardtype" value="cardtype" /><label for="profiles-cardtype">cardtype</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-nameth" value="nameth" /><label for="profiles-nameth">nameth</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-lastnameth" value="lastnameth" /><label for="profiles-lastnameth">lastnameth</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-nameeng" value="nameeng" /><label for="profiles-nameeng">nameeng</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-lastnameeng" value="lastnameeng" /><label for="profiles-lastnameeng">lastnameeng</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-nickname" value="nickname" /><label for="profiles-nickname">nickname</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-generation" value="generation" /><label for="profiles-generation">generation</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-birthday" value="birthday" /><label for="profiles-birthday">birthday</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-nationality" value="nationality" /><label for="profiles-nationality">nationality</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-religious" value="religious" /><label for="profiles-religious">religious</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-socialstatus" value="socialstatus" /><label for="profiles-socialstatus">socialstatus</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-studystatus" value="studystatus" /><label for="profiles-studystatus">studystatus</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-address" value="address" /><label for="profiles-address">address</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-telphone" value="telphone" /><label for="profiles-telphone">telphone</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-celphone" value="celphone" /><label for="profiles-celphone">celphone</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-email" value="email" /><label for="profiles-email">email</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-blogaddress" value="blogaddress" /><label for="profiles-blogaddress">blogaddress</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-image_file" value="image_file" /><label for="profiles-image_file">image_file</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-image_desc" value="image_desc" /><label for="profiles-image_desc">image_desc</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-created_at" value="created_at" /><label for="profiles-created_at">created_at</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-updated_at" value="updated_at" /><label for="profiles-updated_at">updated_at</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-titleth" value="titleth" /><label for="profiles-titleth">titleth</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-titleen" value="titleen" /><label for="profiles-titleen">titleen</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-position" value="position" /><label for="profiles-position">position</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-login" value="login" /><label for="profiles-login">login</label><br />
<!-- 				<input type="checkbox" name="datas[profiles][]" id="profiles-encrypt_password" value="encrypt_password" /><label for="profiles-encrypt_password">encrypt_password</label><br /> -->
				<input type="checkbox" name="datas[profiles][]" id="profiles-role" value="role" /><label for="profiles-role">role</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-login_count" value="login_count" /><label for="profiles-login_count">login_count</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-failed_login_count" value="failed_login_count" /><label for="profiles-failed_login_count">failed_login_count</label><br />
				<input type="checkbox" name="datas[profiles][]" id="profiles-last_login_at" value="last_login_at" /><label for="profiles-last_login_at">last_login_at</label><br />
<!-- 				<input type="checkbox" name="datas[profiles][]" id="profiles-is_approve" value="is_approve" /><label for="profiles-is_approve">is_approve</label><br /> -->
			</div>
		</td>
	</tr>
</table>
</form>
<!-- -----------------------------------[Start End Export]------------------------------------------------------------ -->