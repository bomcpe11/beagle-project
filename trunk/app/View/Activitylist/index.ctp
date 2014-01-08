<?php

?>
	<table class="tableLayout" border="1" bordercolor="#eeeeee" width="100%">
		<tr align="center" style="">
			<th width="15%" >ชื่อกิจกรรม</th>
			<th width="15%">วันที่จัดกิจกรรม</th>
			<th width="20%">สถานที่จัดกิจกรรม</th>
			<th width="15%">ชื่อเรื่อง</th>
			<th width="20%">รายละเอียดอย่างย่อ</th>
			<th width="5%">แก้ไข</th>
			<th width="10%">ลบกิจกรรม</th>
		</tr>
		<?php for($i=0; $i<count($result); $i++){ ?>
		<tr align="center">
			<td><?php echo $result[$i]["activities"]["name"] ?></td>
			<td>
			<?php 
			if($result[$i]["activities"]["startdtm"] != "" and  $result[$i]["activities"]["enddtm"] != ""){
			$startdtm = $result[$i]["activities"]["startdtm"];
			$enddtm = $result[$i]["activities"]["enddtm"];
			$dateArray=explode('-',$startdtm);
			$enddateArray=explode('-',$enddtm);
			$thai_month_arr=array(  "0"=>"",  
								    "1"=>"ม.ค.",  
								    "2"=>"ก.พ.",  
								    "3"=>"มี.ค.",  
								    "4"=>"เม.ย.",  
								    "5"=>"พ.ค.",  
								    "6"=>"มิ.ย.",   
								    "7"=>"ก.ค.",  
								    "8"=>"ส.ค.",  
								    "9"=>"ก.ย.",  
								    "10"=>"ต.ค.",  
								    "11"=>"พ.ย.",  
								    "12"=>"ธ.ค."                    
								);  
		    echo $dateArray[2].'/'.$thai_month_arr[$dateArray[1]].'/'.substr(($dateArray[0]+543),-2).'-'.$enddateArray[2].'/'.$thai_month_arr[$enddateArray[1]].'/'.substr(($enddateArray[0]+543),-2)
		    
			?><?php } ?>
			</td>
			<td><?php echo $result[$i]["activities"]["location"] ?></td>
			<td><?php echo $result[$i]["activities"]["genname"] ?></td>
			<td><?php echo $result[$i]["activities"]["shortdesc"] ?></td>
			<td>/</td>
			<td><a style="cursor: pointer; cursor: hand;" onclick="deleteData('<?php echo $result[$i]["activities"]["id"] ?>');">X</a>
			<input type="hidden" id="idDelete" value="<?php echo $result[$i]["activities"]["id"] ?>"/>
			</td>
		</tr>
		<?php } ?>
	</table>
<script type="text/javascript">
		function deleteData(id){
			jConfirm('TEST CONFIRM?', 
				function(){ //okFunc
					jQuery.post("<?php echo $this->Html->url('/Activitylist/deleteActivity');?>"
						, {"id":id}
						, function(data) {
							if ( data.status.id == 1 ) {
								alert("เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ");
							} else {
								alert("ดำเนินการสำเร็จ");
								window.location.replace("<?php echo $this->webroot;?>Activitylist/index");
							}
						}
						, "json").error(function() {}
					);
				}, 
				function(){ //cancelFunc
					//alert('Cancel'); 
				}, 
				function(){ //openFunc
					//alert('Open'); 
				}, 
				function(){ //closeFunc
					//alert('Close'); 
				}
			);
		}
</script>

