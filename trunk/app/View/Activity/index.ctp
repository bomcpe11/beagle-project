<script type="text/javascript">

	function activityAdd(){
		window.location.replace("<?php echo $this->webroot;?>Activity/addactivity");
	}
	
	function activityEdit(id){
		window.location.replace("<?php echo $this->webroot;?>Activity/editactivity?id="+id);
	}
		
</script>
<table class="tableLayout" width="100%">
	<tr align="left" >
		<th>ชื่อกิจกรรม : <?php echo $result[0]["activities"]["name"] ?>
		<input type="hidden" id="AcId" value="<?php echo $result[0]["activities"]["id"] ?>"/>
		</th>
	</tr>
	<tr align="left" >
		<th>วันที่จัดกิจกรรมเริ่มต้น : <?php echo $result[0]["activities"]["startdtm"] ?></th>
	</tr>
	<tr align="left" >
		<th>วันที่จัดกิจกรรมสิ้นสุด : <?php echo $result[0]["activities"]["enddtm"] ?></th>
	</tr>
	<tr align="left">
		<th>สถานที่จัดกิจกรรม : <?php echo $result[0]["activities"]["location"] ?></th>
	</tr>
	<tr align="left" style="">
		<th>ชื่อรุ่น : <?php echo $result[0]["activities"]["genname"] ?></th>
	</tr>
	<tr align="left" >
		<th>รายละเอียดกิจกรรมอย่างย่อ : <?php echo $result[0]["activities"]["shortdesc"] ?></th>
	</tr>
	<tr align="left" style="">
		<th>รายละเอียดกิจกรรม : <?php echo $result[0]["activities"]["shortdesc"] ?></th>
	</tr>
</table>
<br/>
<table class="tableLayout" width="100%">
	<tr align="left" >
		<th colspan="4"> ไฟล์แนบ</th>
	</tr>
	<tr align="left" >
		<th>ชื่อไฟล์ไฟล์</th>
		<th>คำอธิบาย</th>
		<th>วันที่อัพโหลด</th>
		<th>ลบไฟล์</th>
	</tr>
</table>

<table class="tableLayout" width="100%">
	<tr align="center" >
		<td colspan="2"><input type="button" id="Add" onclick="javascript:activityAdd();" value="อัพโหลดไฟล์เพิ่ม"/>
		</td>
	</tr>
	<tr>
		<td align="right"><input type="button" id="Edit" onclick="activityEdit('<?php echo $result[0]["activities"]["id"] ?>');" value="แก้ไขกิจกรรมนี้"/></td>
		<td align="left"><input type="button" id="Delete" value="ลบกิจกรรมนี้"/></td>
	</tr>
</table>