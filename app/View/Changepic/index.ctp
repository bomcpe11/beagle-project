<?php echo $this->Html->css("change_pic");?>
<!-- ################################################################################## -->
<script type="text/JavaScript">
	/* ------------------------------------------------------------------------------ */
	var flagUploadFile = "<?php echo $flagUploadFile;?>";
	/* ------------------------------------------------------------------------------ */
	jQuery(document).ready(function() {
			// set datepicker
			setDatePicker(".datePicker");
			
			if ( flagUploadFile ) {
				jAlert(flagUploadFile
						, function() {
						}// okFnc
						, function() {
						}// openFnc
						, function() {
						}// closeFnc
				);// jAlert
			}// if
		}// callback
	);// jQuery.ready
	/* ------------------------------------------------------------------------------ */
	function validateData() {
		var fileUpload = jQuery("#file_upload").val();
		var extensionFile = fileUpload.split(".").pop();
		var eduStep = jQuery("#select_edustep").val();
		var imgDtm = jQuery("#text_imgdtm").val();
		var imgDesc = jQuery("#textarea_imgdesc").val();
		
		// validate fileUpload
		if ( !fileUpload ) {
			jAlert("กรุณาเลือก ไฟล์"
					, function() {
					}// okFnc
					, function() {
					}// openFnc
					, function() {
					}// closeFnc
			);// jAlert

			return false;
		}// if
		
		// validate extenstion file
		if ( extensionFile != "jpg"
			&& extensionFile != "jpeg"
			&& extensionFile != "jpe"
			&& extensionFile != "gif"
			&& extensionFile != "png" ) {
			jAlert("ไฟล์ต้องเป็นชนิด jpg, jpeg, jpe, gif, png เท่านั้น "
					, function() {
					}// okFnc
					, function() {
					}// openFnc
					, function() {
					}// closeFnc
			);// jAlert
			
			return false;
		}// if
		
		// validate eduStep
		if ( eduStep == -1 ) {
			jAlert("กรุณาเลือก ระดับการศึกษา"
					, function() {
					}// okFnc
					, function() {
					}// openFnc
					, function() {
					}// closeFnc
			);// jAlert

			return false;
		}// if

		// validate imgDtm
		if ( !imgDtm ) {
			jAlert("กรุณาเลือก วันที่ถ่ายรูปนี้"
					, function() {
					}// okFnc
					, function() {
					}// openFnc
					, function() {
					}// closeFnc
			);// jAlert

			return false;
		}// if

		// validate imgDesc
		if ( !imgDesc ) {
			jAlert("กรุณากรอก คำอธิบายใต้ภาพ"
					, function() {
					}// okFnc
					, function() {
					}// openFnc
					, function() {
					}// closeFnc
			);// jAlert

			return false;
		}// if

		return true;
	}// validateData
</script>
<!-- ################################################################################## -->
<!-- Picture -->
<div>	
	<span class="header1">รูปภาพที่มีอยู่</span>
	<div class="div_form_picture">
		<?php for ( $i = 0; $i < count($pathImage); $i++ ) {?>
			<div class="div_item_picture">
				<img class="img_picture" src="<?php echo $this->webroot.$pathImage[$i]['profile_pics']['imgpath'];?>"/>
				<span class="span_picture_desc"><?php echo $pathImage[$i]["profile_pics"]["imgdesc"];?></span>
			</div>
		<?php }?>
	</div>
</div>
<!-- Data -->
<div style="margin-top: 20px">
	<span class="header1">อัพโหลดรูปภาพเพิ่ม</span>
	<form id="form_data" name="form_data" method="post" action="<?php echo $this->webroot;?>changepic/submitDataFnc" 
		enctype="multipart/form-data" onSubmit="return validateData();">
		<table class="table_form_data">
			<tr>
				<td class="td_label">* ไฟล์รูปภาพ</td>
				<td class="td_data"> 
					<input type="file" id="file_upload" name="file_upload">
				</td>
			</tr>
			<tr>
				<td class="td_label">* ระดับการศึกษา</td>
				<td class="td_data">
					<select id="select_edustep" name="select_edustep">
						<option value="-1">---- กรุณาเลือก ----</option>
						<?php for ( $i = 0; $i < count($eduStep); $i++ ) { ?>
							<option value="<?php echo $eduStep[$i]['gvars']['varcode'];?>"><?php echo$eduStep[$i]['gvars']['vardesc1'];?></option>
						<?php }?>
					</select>
				</td>
			</tr>
			<tr>
				<td class="td_label">* วันที่ถ่ายรูปนี้</td>
				<td class="td_data">
					<input type="text" id="text_imgdtm" name="text_imgdtm" class="datePicker" readonly size="18">
				</td>
			</tr>
			<tr>
				<td class="td_label">* คำอธิบายใต้ภาพ</td>
				<td class="td_data" rowspan="2">
					<textarea rows="3" cols="24" id="textarea_imgdesc" name="textarea_imgdesc"></textarea>
				</td>
			</tr>
			<tr>
				<td class="td_label"></td>
				<td class="td_data"></td>
			</tr>
			<tr>
				<td class="td_label"></td>
				<td class="td_data">
					<input type="submit" id="button_upload" value="อัพโหลด"/>
				</td>
			</tr>
		</table>
	</form>
</div>