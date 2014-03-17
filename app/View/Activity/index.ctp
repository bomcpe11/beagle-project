<?php include 'popup_join_activity.ctp'; ?>
<script type="text/javascript">
    function addFile(){
		jQuery('#uploadFile').css("display","block");
	}
	function cancel(){
		jQuery('#uploadFile').css("display","none");
	}

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
	
	function uploadFile(){
		jConfirm('ท่านต้องการอัพโหลดไฟล์เพิ่มใช่หรือไม่?', 
			function(){ //okFunc
				loading();
				jQuery.ajax({
					type: "POST",
					dataType: 'json',
					url: '<?php echo $this->Html->url('/Activitylist/uploadFiles');?>',
					data: {id:""},
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
<style type="text/css">
#activity-longdesc, #activity-longdesc p, #activity-longdesc td, #activity-longdesc th, #activity-longdesc span, #activity-longdesc div{
	color: black;
}
#activity-longdesc h1, #activity-longdesc h2, #activity-longdesc h3, #activity-longdesc h4, #activity-longdesc h5{
	color: black;
}
#activity-longdesc{
	border:1px solid black;
	border-radius:5px;
	background-color: #FDFDFE;
	padding:2px;
}
</style>
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
<table class="tableLayout" width="100%" border="0">
	<tr>
		<th align="right" width="170">ชื่อกิจกรรม : 
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
		<td colspan="2"><div style="padding-left:50px;"><?php echo $result[0]["activities"]["shortdesc"] ?></div></td>
	</tr>
	<tr>
		<th align="right">รายละเอียดกิจกรรม : </th><td></td>
	</tr>
	<tr>
		<td colspan="2"><div id="activity-longdesc"><?php echo $result[0]["activities"]["longdesc"] ?></div></td>
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
<table class="tableLayout" width="100%" style="display:block;">
	<tr align="left" >
		<th colspan="2"> ไฟล์แนบ</th>
	</tr>
	<tr>
		<th align="left" width="40%">ชื่อไฟล์</th>
		<th align="right" width="40%">ลบไฟล์</th>
	</tr>
	<?php
			$dir = opendir("files/activities/".$result[0]["activities"]["id"]);
			while (($file = readdir($dir)) !== false)
			{ 
	?>
	<tr>
		<td align="left">
			<?php echo "$file"; ?>
		</td>
		<td align="right">X</td>
	</tr>
	<?php   }
			closedir($dir);
			?> 
	<tr align="left" >
		<th colspan="4"><input type="button" id="AddFile" onclick="addFile();" value="อัพโหลดไฟล์เพิ่ม"/></th>
	</tr>
</table>
<table class="tableLayout" id="uploadFile" width="100%" style="display:none;">
	<tr>
		<td class="td_label">ไฟล์แนบ : </td>
		<td class="td_data"><input type="file"  id="upload" name="file_upload"></td>
	</tr>
	<tr>
		<td><input value="Submit" type="button" onclick="uploadFile();"></td>
		<td><input value="Cancel" type="button" onclick="cancel();"></td>
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