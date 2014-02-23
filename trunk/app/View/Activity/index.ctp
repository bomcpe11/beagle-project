<?php include 'popup_join_activity.ctp'; ?>
<script type="text/javascript">

	function activityAdd(){
		window.location.replace("<?php echo $this->webroot;?>Activity/addactivity");
	}
	
	function activityEdit(id){
		window.location.replace("<?php echo $this->webroot;?>Activity/editactivity?id="+id);
	}
		
</script>
<?php 
	if($result[0]["activities"]["startdtm"] != "" and  $result[0]["activities"]["enddtm"] != ""){
		$startdtm = $result[0]["activities"]["startdtm"];
		$enddtm = $result[0]["activities"]["enddtm"];
		$dateArray=explode('-',$startdtm);
		$enddateArray=explode('-',$enddtm);
		$thai_month_arr=array(  "00"=>"",  
							    "01"=>"มกราคม",  
							    "02"=>"กุมภาพันธ์",  
							    "03"=>"มีนาคม.",  
							    "04"=>"เมษายน.",  
							    "05"=>"พฤษภาคม",  
							    "06"=>"มิถุนายน",   
							    "07"=>"กรกฎาคม",  
							    "08"=>"สิงหาคม",  
							    "09"=>"กันยายน",  
							    "10"=>"ตุลาคม",  
							    "11"=>"พฤศจิกายน",  
							    "12"=>"ธันวาคม");   
		$startdtm = $dateArray[2].' '.$thai_month_arr[$dateArray[1]].' '.($dateArray[0]+543);
		$enddtm = $enddateArray[2].' '.$thai_month_arr[$enddateArray[1]].' '.($enddateArray[0]+543);
	}else{
		$startdtm = "";
		$enddtm = "";
	}
?>
<table class="tableLayout" width="100%">
	<tr align="left" >
		<th>ชื่อกิจกรรม : <?php echo $result[0]["activities"]["name"] ?>
		<input type="hidden" id="AcId" value="<?php echo $result[0]["activities"]["id"] ?>"/>
		</th>
	</tr>
	<tr align="left" >
		<th>วันที่จัดกิจกรรมเริ่มต้น : <?php echo $startdtm; ?></th>
	</tr>
	<tr align="left" >
		<th>วันที่จัดกิจกรรมสิ้นสุด : <?php echo $enddtm; ?></th>
	</tr>
	<tr align="left">
		<th>สถานที่จัดกิจกรรม : <?php echo $result[0]["activities"]["location"] ?></th>
	</tr>
	<tr align="left" style="">
		<th>ชื่อรุ่น : <?php echo $result[0]["activities"]["genname"] ?></th>
	</tr>
	<tr align="left" >
		<th>รายละเอียดกิจกรรมอย่างย่อ : </th>
	</tr>
	<tr align="left" >
		<th><?php echo $result[0]["activities"]["shortdesc"] ?></th>
	</tr>
	<tr align="left" style="">
		<th>รายละเอียดกิจกรรม : <?php echo $result[0]["activities"]["longdesc"] ?></th>
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
	<tr align="center">
		<td><input type="button" id="Add" onclick="javascript:activityAdd();" value="อัพโหลดไฟล์เพิ่ม"/>
		</td>
	</tr>
	<tr style="text-align:center">
		<td>
			<input type="button" id="Edit" onclick="activityEdit('<?php echo $result[0]["activities"]["id"] ?>');" value="แก้ไขกิจกรรมนี้"/>
			<input type="button" id="JoinActivity" onclick="openPopupActivity('<?php echo $result[0]["activities"]["id"] ?>');" 
					value="เข้าร่วมกิจกรรมนี้" <?php echo ($flagJoinActivity===1)?'disabled':''; ?>/>
			<input type="button" id="Delete" value="ลบกิจกรรมนี้"/>
		</td>
	</tr>
</table>