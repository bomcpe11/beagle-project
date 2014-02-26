<?php include 'popup_join_activity.ctp'; ?>
<script type="text/javascript">

	function activityAdd(){
		window.location.replace("<?php echo $this->webroot;?>Activity/addactivity");
	}
	
	function activityEdit(id){
		window.location.replace("<?php echo $this->webroot;?>Activity/editactivity?id="+id);
	}
	function deleteData(id){
		jConfirm('ท่านต้องการลบข้อมูลกิจกรรมนี้ใช่หรือไม่?', 
			function(){ //okFunc
				loading();
				jQuery.ajax({
					type: "POST",
					dataType: 'json',
					url: '<?php echo $this->Html->url('/Activitylist/deleteActivity');?>',
					data: {id:id},
					success: function(data){
						unloading();
						if ( data.status ) {
							jAlert(data.message, 
								function(){
									window.location.replace("<?php echo $this->webroot;?>Activitylist/index");
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
	<tr>
		<th align="right" width="20%">ชื่อกิจกรรม : 
		<input type="hidden" id="AcId" value="<?php echo $result[0]["activities"]["id"] ?>"/>
		</th>
		<td><?php echo $result[0]["activities"]["name"] ?></td>
	</tr>
	<tr>
		<th align="right">วันที่จัดกิจกรรมเริ่มต้น : </th>
		<td><?php echo $startdtm; ?></td>
	</tr>
	<tr>
		<th align="right">วันที่จัดกิจกรรมสิ้นสุด : </th>
		<td><?php echo $enddtm; ?></td>
	</tr>
	<tr>
		<th align="right">สถานที่จัดกิจกรรม : </th>
		<td><?php echo $result[0]["activities"]["location"] ?></td>
	</tr>
	<tr>
		<th align="right">ชื่อรุ่น : </th>
		<td><?php echo $result[0]["activities"]["genname"] ?></td>
	</tr>
	<tr>
		<th align="right">รายละเอียดกิจกรรมอย่างย่อ : </th><td></td>
	</tr>
	<tr>
		<th align="right"></th>
		<td><?php echo $result[0]["activities"]["shortdesc"] ?></td>
	</tr>
	<tr>
		<th align="right">รายละเอียดกิจกรรม : </th><td></td>
	</tr>
	<tr>
		<td colspan="2"><?php echo $result[0]["activities"]["longdesc"] ?></td>
	</tr>
	<tr>
		<td colspan="2" align="right">
		<?php if( $objuser['role'] != '1' ){ ?>
			<input type="button" id="Edit" onclick="activityEdit('<?php echo $result[0]["activities"]["id"] ?>');" value="แก้ไขรายละเอียดของกิจกรรมนี้"/>
		<?php } ?>
		</td>
	</tr>
</table>
<br/>
<table class="tableLayout" width="100%" style="display:none;">
	<tr align="left" >
		<th colspan="4"> ไฟล์แนบ</th>
	</tr>
	<tr align="left" >
		<th>ชื่อไฟล์ไฟล์</th>
		<th>คำอธิบาย</th>
		<th>วันที่อัพโหลด</th>
		<th>ลบไฟล์</th>
	</tr>
	<tr align="left" >
		<th colspan="4"><input type="button" id="Add" onclick="javascript:activityAdd();" value="อัพโหลดไฟล์เพิ่ม"/></th>
	</tr>
</table>

<table class="tableLayout" width="100%">
	<tr style="text-align:center">
		<td>
		<?php if( $objuser['role']==='1' ){ ?>
			<input type="button" id="Edit" onclick="activityEdit('<?php echo $result[0]["activities"]["id"] ?>');" value="แก้ไขกิจกรรมนี้"/>
		<?php } ?>
			<input type="button" id="JoinActivity" onclick="openPopupActivity('<?php echo $result[0]["activities"]["id"] ?>');" 
					value="เข้าร่วมกิจกรรมนี้" <?php echo ($flagJoinActivity===1)?'disabled':''; ?>/>
		<?php if( $objuser['role']==='1' ){ ?>
			<input type="button" id="Delete" onclick="deleteData('<?php echo $result[0]["activities"]["id"] ?>');" value="ลบกิจกรรมนี้"/>
		<?php } ?>
		</td>
	</tr>
</table>