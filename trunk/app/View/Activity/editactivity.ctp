<script type="text/javascript">
		function cancelClick(id){
			window.location.replace("<?php echo $this->webroot;?>Activity?id="+id);
		}
		jQuery(document).ready(function(){
			setDatePicker('.datePicker');
			setBirthDatePicker('.birthDatePicker');
		});
</script>
<table class="tableLayout" width="100%">
	<tr align="left">
		<th align="right" width="20%">ชื่อกิจกรรม : </th>
		<td align="left">
			<input type="text" id="activityName" style="width: 300px;" value=" <?php echo $result[0]["activities"]["name"] ?>" />
		</td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">วันที่จัดกิจกรรม เริ่มต้น : </th>
		<td align="left">
			<input type="text" class="datePicker" id="startDate" value=" <?php echo $result[0]["activities"]["startdtm"] ?>"  />
		</td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">วันที่จัดกิจกรรม สิ้นสุด : </th>
		<td align="left">
			<input type="text" class="datePicker" id="endDate" value=" <?php echo $result[0]["activities"]["enddtm"] ?>" />
		</td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">สถานที่จัดกิจกรรม : </th>
		<td align="left">
		<input type="text" id="location" style="width: 300px;" value=" <?php echo $result[0]["activities"]["location"] ?>" />
		</td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">รายละเอียดกิจกรรม อย่างย่อ : </th>
		<td align="left">
		<input type="text" id="shortdesc" style="width: 300px;" value =" <?php echo $result[0]["activities"]["shortdesc"] ?>" />
		</td>
	</tr>
	<tr align="left">
		<th align="right" width="20%">ชื่อรุ่น : </th>
		<td align="left">
		<input type="text" id="genname" value=" <?php echo $result[0]["activities"]["genname"] ?>" />
		</td>
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
		<td align="left"><input type="button" id="cancel" value="ยกเลิก" onclick="cancelClick('<?php echo $result[0]["activities"]["id"] ?>');" /></td>
	</tr>
</table>