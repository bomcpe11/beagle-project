<!-- -----------------------------------[Start Page Export]------------------------------------------------------------ -->
<?php echo $this->Html->css("export");?>

<script type="text/javascript">
//-------------------------------------------------------------------------------------------------
jQuery(document).ready(function(){
	jQuery("#exportFileBtn").click(function() {doExportFile();});
	jQuery("input[type=radio]").click(function() {doSelectMode();});
	jQuery("#select_cardtype").change(function() {changeSelectDataName();});
	
});
//-------------------------------------------------------------------------------------------------
function doExportFile(){
  var exportType = jQuery("#exportType").val();
  var mode = jQuery("input:checked").val();
  var stmt = jQuery("#stmt").val();  
  var selectDataName = jQuery("#selectDataName").val();  
  var selectDataNameId = jQuery("#select_cardtype").val();  
  
  if(exportType == ""){
	  jAlert('กรุณาเลือกรูปแบบไฟล์!', function(){},function(){},function(){});
	  return false;
  }

  if(mode == 2 && selectDataName == ""){
	  jAlert('กรุณาระบุชื่อในช่องเลือกข้อมูล!', function(){},function(){},function(){});
	  return false;
  }else if(mode == 1 && selectDataNameId == ""){
	  jAlert('กรุณาเลือกข้อมูล!', function(){},function(){},function(){});
	  return false;
  }

  jQuery.post("<?php echo $this->Html->url('/Export/export');?>", {"exportType":exportType,
			   													   "mode":mode,
			   													   "stmt":stmt,
			   													   "selectDataName":selectDataName,
			   													   "selectDataNameId":selectDataNameId}
			, function(data) {
				if(data.status.id==1) {	
					jAlert('ดำเนินการเรียบร้อย!', function(){
						                        jQuery(window.location).attr('href',G_WEB_ROOT+"data.csv");
						                        window.location.reload();
						                  }
	                                   ,function(){}
	                                   ,function(){});
				}else{
					jAlert('เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ!', function(){},function(){},function(){});
			    }
			    
			},"json").error(function() {
			}
	);
	
}
//-------------------------------------------------------------------------------------------------
function doSelectMode(){
	var mode = jQuery("input:checked").val();

	if(mode == 1){
		jQuery('#mode2').css("display", "none");
		jQuery('#mode1').css("display", "inline");
	}else{
		jQuery('#mode1').css("display", "none");
		jQuery('#mode2').css("display", "inline");
	}
}
//-------------------------------------------------------------------------------------------------
function changeSelectDataName(){
	var id = jQuery("#select_cardtype").val();  
	jQuery("#stmt").val(jQuery("#select_cardtype option:selected").attr('strStmt'));
	
}
//-------------------------------------------------------------------------------------------------
</script>
<table width="100%">
	<tr>
	   <td width="20%" class="text">
	      	รูปแบบไฟล์  :
	   </td>
	   <td>
	     	<select id="exportType">
				<option value="">---- กรุณาเลือก ----</option>
				<?php for ( $i = 0; $i < count($exportTypeList); $i++ ) { ?>
				<option value="<?php echo $exportTypeList[$i]['gvars']['varcode'];?>"><?php echo $exportTypeList[$i]["gvars"]["vardesc1"];?></option>
			    <?php } ?>
			</select>
	   </td>
	</tr>
	
	<tr>
	  <td class="text">
	       Mode :
	  </td>
	  <td>
	       <input type="radio" name="mode" value="1" checked="checked"> <a class="data">เคยส่งออกแล้ว</a>
	       <input type="radio" name="mode" value="2"> <a class="data">เพิ่มใหม่</a>
	  </td>
	</tr>
	
    <tr>
	  <td class="text">
	                       เลือกข้อมูล :
	  </td>
	  <td>
	     <div id="mode1">
	       <select id="select_cardtype">
	            <option value="">---- กรุณาเลือก ----</option>
				<?php for ( $i = 0; $i < count($selectDataNameList); $i++ ) { ?>
				<option strStmt="<?php echo $selectDataNameList[$i]['queryexports']['strquery'];?>" value="<?php echo $selectDataNameList[$i]['queryexports']['id'];?>"><?php echo $selectDataNameList[$i]["queryexports"]["name"];?></option>
			    <?php } ?>
		   </select>
		 </div>
		 
		 <div id="mode2" style="display:none;">
		    <input type="text" maxlength="1000" id="selectDataName">
		 </div>
	  </td>
	</tr>
	
	<tr>
	  <td class="text" valign="top">
	       String Query :
	  </td>
	  <td>
	      <textarea cols="80" rows="10" id="stmt"></textarea>
	  </td>
	</tr>
	
    <tr>
	  <td>
	  </td>
	  <td>
	     <input type="button" value="ดำเนินการ" id="exportFileBtn">
	  </td>
	</tr>
	

</table>
<!-- -----------------------------------[Start End Export]------------------------------------------------------------ -->