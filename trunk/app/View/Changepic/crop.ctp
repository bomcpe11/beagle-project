<?php 
	echo $this->Html->css('/js/jquery.imgareaselect/css/imgareaselect-default');

	/* JavaScript */
	echo $this->Html->script('jquery.imgareaselect/scripts/jquery.imgareaselect.pack');

?>

<script type="text/javascript">
	var g_imgCropper = null;
	jQuery(document).ready(function () {
		g_imgCropper = jQuery('img#photo').imgAreaSelect({
	    	aspectRatio: '1:1',
	        handles: true,
	        instance: true,
	        x1: 232, y1: 18, x2: 768, y2: 554,
	        persistent: true
	    });
	});

	function submitImageCrop(){
// 		console.log(g_imgCropper.getSelection());
		//getSelection
	}

	function submit_crop(){
		var raw_imgPath = '<?php echo $raw_imgPath; ?>';
		var pictureId = '<?php echo $pictureId; ?>';
		var cropInfo = g_imgCropper.getSelection();
		var imgDtm = jQuery("#text_imgdtm").val();
		var imgDesc = jQuery("#textarea_imgdesc").val();

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

		loading();
		jQuery.post('<?php echo $this->Html->url('/Changepic/ajax_crop');?>'
			,{imgpath: raw_imgPath
					,imgdtm: imgDtm
					,imgdesc: imgDesc
					,cropInfo: cropInfo
					,pictureId: pictureId
				}
			,function(data){
// 				console.log(data);
				unloading();
				jAlert(data.message
						, function(){ 
							if( data.status ){
								window.location.replace('<?php echo $this->Html->url('/Changepic');?>');
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
<div style="text-align: center;">
	<img id="photo" src="<?php echo $this->Html->url('/'.$imgPath); ?>" />

</div>

<div class="input" style="color: white;">
	<fieldset style="width: 300px;margin: 5px auto;">
	<legend>เพิ่มภาพส่วนตัว</legend>
		<table>
			<tr>
				<td class="td_label">ปีที่ถ่ายรูปนี้ (พ.ศ.)</td>
				<td class="td_data">
					<input type="text" id="text_imgdtm" name="text_imgdtm" size="4">
				</td>
			</tr>
			<tr>
				<td class="td_label" valign="top">* คำอธิบายใต้ภาพ</td>
				<td class="td_data">
					<textarea rows="3" cols="24" id="textarea_imgdesc" name="textarea_imgdesc"></textarea>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="left"><input type="button" value="บันทึก" onclick="submit_crop();" /></td>
			</tr>
		</table>
	</fieldset>
</div>