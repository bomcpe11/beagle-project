<script type="text/javascript">
		function ckGetData(){
			alert(CKEDITOR.instances.ckeditor1.getData());
		}
	
		function cancelClick(){
			window.location.replace("<?php echo $this->webroot;?>Activitylist/index");
		}
		jQuery(document).ready(function(){
			setDatePicker('.datePicker');
			setBirthDatePicker('.birthDatePicker');
			CKEDITOR.replace( 'addCK', {filebrowserImageUploadUrl : getURL('/activity/uploadImages')});
		});
		
		function saveClick(){
			var activityName = jQuery('#activityName').val();
			var startDate = jQuery('#startDate').val();
			var endDate = jQuery('#endDate').val();
			var location = jQuery('#location').val();
			var shortdesc = jQuery('#shortdesc').val();
			var genname = jQuery('#genname').val();
			var longdesc = CKEDITOR.instances.longdesc.getData();
			
			jConfirm('ท่านต้องการบันทึกข้อมูลกิจกรรมนี้ใช่หรือไม่?', 
				function(){ //okFunc
					loading();
					jQuery.ajax({
						type: "POST",
						dataType: 'json',
						url: '<?php echo $this->Html->url('/Activity/insertActivity');?>',
						data: {activityName:activityName,
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
										window.location.replace("<?php echo $this->webroot;?>Activitylist");
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
		<td align="left"><input type="text" id="activityName" style="width: 300px;" /></td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">วันที่จัดกิจกรรม เริ่มต้น : </th>
		<td align="left"><input type="text" class="datePicker" id="startDate" /></td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">วันที่จัดกิจกรรม สิ้นสุด : </th>
		<td align="left"><input type="text" class="datePicker" id="endDate" /></td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">สถานที่จัดกิจกรรม : </th>
		<td align="left"><input type="text" id="location" style="width: 300px;" /></td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">รายละเอียดกิจกรรม อย่างย่อ : </th>
		<td align="left"><td><textarea id="shortdesc" rows="10" cols="80"></textarea></td></td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">ชื่อรุ่น : </th>
		<td align="left"><input type="text" id="genname" /></td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">รายละเอียดกิจกรรม : </th>
	</tr>
	<tr align="left">
		<th align="right" width="20%"></th>
		<td><textarea id="longdesc" rows="10" cols="80"></textarea></td>
	</tr>
	<tr align="left">
		<td align="right" width="20%"><input type="button" id="save" value="บันทึก" onclick="saveClick();" /></td>
		<td align="left"><input type="button" id="cancel" value="ยกเลิก" onclick="cancelClick();" /></td>
	</tr>
</table>