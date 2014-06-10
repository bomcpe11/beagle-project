<?php echo $this->Html->css("change_pic");?>
<!-- #################################################################################################### -->
<script type="text/JavaScript">
	/* ------------------------------------------------------------------------------------------------- */
	var flagUploadFile = "<?php echo $flagUploadFile;?>";
	/* ------------------------------------------------------------------------------------------------- */
	jQuery(document).ready(function(){
			setDatePicker(".datePicker");
			jQuery('input[type="submit"]').button();
			
			if( flagUploadFile ) {
				jAlert(flagUploadFile
						, function() {
							window.location.replace('<?php echo $this->Html->url('/Changepic/index');?>');
						}// okFnc
						, function() {
						}// openFnc
						, function() {
						}// closeFnc
				);
			}
		}
	);
	/* ------------------------------------------------------------------------------------------------- */
	function validateData() {
		var fileUpload = jQuery("#file_upload").val();
		var extensionFile = fileUpload.split(".").pop();
// 		var eduStep = jQuery("#select_edustep").val();
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

		extensionFile = extensionFile.toLowerCase();
		
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
// 		if ( eduStep == -1 ) {
// 			jAlert("กรุณาเลือก ระดับการศึกษา"
// 					, function() {
// 					}// okFnc
// 					, function() {
// 					}// openFnc
// 					, function() {
// 					}// closeFnc
// 			);// jAlert

// 			return false;
// 		}// if

		// validate imgDtm
// 		if ( !imgDtm ) {
// 			jAlert("กรุณาเลือก วันที่ถ่ายรูปนี้"
// 					, function() {
// 					}// okFnc
// 					, function() {
// 					}// openFnc
// 					, function() {
// 					}// closeFnc
// 			);// jAlert

// 			return false;
// 		}// if

		// validate imgDesc
// 		if ( !imgDesc ) {
// 			jAlert("กรุณากรอก คำอธิบายใต้ภาพ"
// 					, function() {
// 					}// okFnc
// 					, function() {
// 					}// openFnc
// 					, function() {
// 					}// closeFnc
// 			);// jAlert

// 			return false;
// 		}// if
		loading();
		return true;
	}// validateData
	/* ------------------------------------------------------------------------------------------------- */
	function updateImgProfile(imgpath,imgdesc){
		jConfirm('กรุณายืนยัน เพื่อเปลี่ยนรูปโปรไฟล์', 
				function(){ //okFunc
					loading();
					jQuery.post('<?php echo $this->Html->url('/Changepic/updateImgProfile');?>'
						,{'data':{'imgpath':imgpath
									,'imgdesc':imgdesc}}
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
				}, 
				function(){ //cancelFunc
				}, 
				function(){ //openFunc
				}, 
				function(){ //closeFunc
				});
	}
	function deletePic(linkDeletePic){
		jConfirm('กรุณายืนยันเพื่อ ลบรูปโปรไฟล์', 
				function(){ //okFunc
					window.location.replace(linkDeletePic);
				}, 
				function(){ //cancelFunc
				}, 
				function(){ //openFunc
				}, 
				function(){ //closeFunc
				});
	}
</script>
<!-- #################################################################################################### -->
<!-- Picture -->
<div style="margin: 20px 0 0 10px;">	
	<span class="header1">รูปภาพที่มีอยู่</span>
	<div class="div_form_picture">
		<?php 
			$linkDeletePic = '';
			$countPathImage = count($pathImage);
			for( $i=0;$i<$countPathImage;$i++ ){
				$linkDeletePic = $this->Html->url(array('controller' => 'Changepic',
												    	'action' => 'deletePic',
												    	'?' => array('id' => $pathImage[$i]['profile_pics']['id'], 'profileId'=>( empty($_GET['id'])?'':$_GET['id'] ))
														));
					
				echo "<div class=\"div-item-picture\">
						<a class=\"icon-delete\" title=\"ลบ รูปโปรไฟล์\"
							href=\"#\" onclick=\"deletePic('$linkDeletePic')\">
							<img src=\"{$this->Html->url('/img/icon_del.png')}\" />
						</a>
						<img class=\"img-picture\" title=\"ใช้รูปนี้เป็นรูป โปรไฟล์\"
							src=\"$this->webroot{$pathImage[$i]['profile_pics']['imgpath']}\"
							onclick=\"updateImgProfile('{$pathImage[$i]['profile_pics']['imgpath']}'
														,'{$pathImage[$i]['profile_pics']['imgdesc']}')\"/>
						<span class=\"span-picture-desc\">{$pathImage[$i]['profile_pics']['imgdesc']}</span>
						
					</div>";
			}
		?>
	</div>
</div>
<!-- Data -->
<div class="section-layout" style="width:97% ;margin: 20px 0 0 10px;">
	<span class="header1">อัพโหลดรูปภาพเพิ่ม</span>
	<form id="form_data" name="form_data" method="post" action="<?php echo $this->webroot;?>changepic/submitDataFnc<?php if(!empty($_GET['id'])) echo '?id='.$_GET['id']; ?>" 
		enctype="multipart/form-data" onSubmit="return validateData();">
		<table class="table_form_data">
			<tr>
				<td class="td_label">* ไฟล์รูปภาพ</td>
				<td class="td_data"> 
					<input type="file" id="file_upload" name="file_upload">
				</td>
			</tr>
			<!-- 
			<tr>
				<td class="td_label">ปีที่ถ่ายรูปนี้ (พ.ศ.)</td>
				<td class="td_data">
					<input type="text" id="text_imgdtm" name="text_imgdtm" size="4">
				</td>
			</tr>
			<tr>
				<td class="td_label">* คำอธิบายใต้ภาพ</td>
				<td class="td_data" rowspan="2">
					<textarea rows="3" cols="24" id="textarea_imgdesc" name="textarea_imgdesc"></textarea>
				</td>
			</tr>
			-->
			<tr>
				<td class="td_label"></td>
				<td class="td_data">
					<input type="submit" id="button_upload" value="Upload"/>
					<input type="button" value="Back" onclick="window.location.replace('<?php echo $this->Html->url('/Customize'); ?>');"/>
				</td>
			</tr>
		</table>
	</form>
</div>