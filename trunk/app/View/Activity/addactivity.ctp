<script type="text/javascript">
		function cancelClick(){
			window.location.replace("<?php echo $this->webroot;?>Activity/index");
		}
		jQuery(document).ready(function(){
			setDatePicker('.datePicker');
			setBirthDatePicker('.birthDatePicker');
		});
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
		<td align="left"><input type="text" id="activityName" style="width: 300px;" /></td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">รายละเอียดกิจกรรม อย่างย่อ : </th>
		<td align="left"><input type="text" id="activityName" style="width: 300px;" /></td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">ชื่อรุ่น : </th>
		<td align="left"><input type="text" id="activityName" /></td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">รายละเอียดกิจกรรม : </th>
	</tr>
	<tr align="left">
		<th align="right" width="20%"></th>
		<td><textarea id="" style="width: 700px;" rows="5" ></textarea></td>
	</tr>
	<tr align="left">
		<td align="right" width="20%"><input type="button" id="save" value="บันทึก" /></td>
		<td align="left"><input type="button" id="cancel" value="ยกเลิก" onclick="cancelClick();" /></td>
	</tr>
</table>