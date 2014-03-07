<script type="text/javascript">
		function ckGetData(){
			alert(CKEDITOR.instances.editCK.getData());
		}
		function cancelClick(id){
			window.location.replace("<?php echo $this->webroot;?>Activitylist/index");
		}
		jQuery(document).ready(function(){
			setDatePicker('.datePicker');
			setBirthDatePicker('.birthDatePicker');
			
			var config = {
					filebrowserImageUploadUrl : getURL('/activity/uploadImages'),
					filebrowserUploadUrl : getURL('/activity/uploadImages')
// 					toolbarCanCollapse : false,
// 					colorButton_enableMore : false,
// 					toolbar :
// 					[
// 						{ name: 'document',    items : [ 'Source' ] },
// 						{ name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
// 						{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
// 						{ name: 'paragraph',   items : [ 'Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'] },
// 						{ name: 'colors',      items : [ 'TextColor','BGColor' ] },
// 						{ name: 'insert',      items : [ 'Link', 'Image', 'addFile', 'addImage' ] },
// 						{ name: 'tools',       items : [ 'Maximize', 'About' ] }
// 					]
				};
			
			CKEDITOR.replace( 'editCK', config);
		});
		
		function saveClick(){
			var id = '<?php echo $result[0]["activities"]["id"] ?>';
			var activityName = jQuery('#activityName').val();
			var startDate = jQuery('#startDate').val();
			var endDate = jQuery('#endDate').val();
			var location = jQuery('#location').val();
			var shortdesc = jQuery('#shortdesc').val();
			var genname = jQuery('#genname').val();
			var longdesc = CKEDITOR.instances.editCK.getData();
			jConfirm('ท่านต้องการบันทึกข้อมูลกิจกรรมนี้ใช่หรือไม่?', 
				function(){ //okFunc
					loading();
					jQuery.ajax({
						type: "POST",
						dataType: 'json',
						url: '<?php echo $this->Html->url('/Activity/updateActivity');?>',
						data: {id:id,
							   activityName:activityName,
						       startDate:startDate,
						       endDate:endDate,
						       location:location,
						       shortdesc:shortdesc,
						       genname:genname,
						       longdesc:longdesc},
						success: function(data){
							unloading();
							
							if ( data.status == 1 ) {
								jAlert(data.message, 
									function(){
										window.location.replace("<?php echo $this->webroot;?>Activity?id="+id);
									}
								);
							} else {
								jAlert(data.message);
							}
						}
					});
				}
			);
		}
</script>
<table class="tableLayout" width="100%">
	<tr align="left">
		<th align="right" width="20%">ชื่อกิจกรรม : </th>
		<td align="left">
		<?php if( $objuser['role'] == '1' ){ ?>
			<input type="text" id="activityName" style="width: 300px;" value="<?php echo $result[0]["activities"]["name"] ?>" />
		<?php }else{ 
			 echo $result[0]["activities"]["name"]; 
		} ?>
		</td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">วันที่จัดกิจกรรม เริ่มต้น : </th>
		<td align="left">
		<?php 
			if($result[0]["activities"]["startdtm"] != "" and  $result[0]["activities"]["enddtm"] != ""){
				$arr = explode("-", $result[0]["activities"]["startdtm"]);
				$startDate = $arr[2]."/".$arr[1]."/".($arr[0]+543);
				$arrEndDate = explode("-", $result[0]["activities"]["enddtm"]);
				$enddtm = $arrEndDate[2]."/".$arrEndDate[1]."/".($arrEndDate[0]+543);
			} else{
				$startDate = "";
				$enddtm = "";
			}
		?>
		<?php if( $objuser['role'] == '1' ){ ?>
			<input type="text" class="datePicker" id="startDate" value="<?php echo $startDate  ?>"  />
		<?php }else{
			echo $startDate;
		} ?>
		</td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">วันที่จัดกิจกรรม สิ้นสุด : </th>
		<td align="left">
		<?php if( $objuser['role'] == '1' ){ ?>
			<input type="text" class="datePicker" id="endDate" value="<?php echo $enddtm ?>" />
		<?php }else{
			echo $enddtm;
		} ?>
		</td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">สถานที่จัดกิจกรรม : </th>
		<td align="left">
		<?php if( $objuser['role'] == '1' ){ ?>
			<input type="text" id="location" style="width: 300px;" value="<?php echo $result[0]["activities"]["location"] ?>" />
		<?php }else{
			echo $result[0]["activities"]["location"];
		} ?>
		</td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">ชื่อรุ่น : </th>
		<td align="left">
		<?php if( $objuser['role'] == '1' ){ ?>
			<input type="text" id="genname" value="<?php echo $result[0]["activities"]["genname"] ?>" />
		<?php }else{
			echo $result[0]["activities"]["genname"];
		} ?>
		</td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">รายละเอียดกิจกรรม อย่างย่อ : </th>
		<td align="left">
		<?php if( $objuser['role'] == '1' ){ ?>
			<textarea id="shortdesc" style="width: 700px;" rows="5" ><?php echo $result[0]["activities"]["shortdesc"] ?></textarea>
		<?php }else{
			echo $result[0]["activities"]["shortdesc"];
		} ?>
		</td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">รายละเอียดกิจกรรม : </th>
	</tr>
	<tr align="left">
		<td colspan="2">
			<textarea id="editCK" style="width: 700px;" rows="5" >
				<?php echo $result[0]["activities"]["longdesc"] ?>
			</textarea>
		</td>
	</tr>
	<tr align="left">
		<td align="right" width="20%"><input type="button" id="save" value="บันทึก" onclick="saveClick();" /></td>
		<td align="left"><input type="button" id="cancel" value="ยกเลิก" onclick="cancelClick('<?php echo $result[0]["activities"]["id"] ?>');" /></td>
	</tr>
</table>