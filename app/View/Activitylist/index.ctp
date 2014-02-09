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
			<td><a style="cursor: pointer; cursor: hand;" href="<?php echo $this->Html->url('/Activity?id='.$result[$i]["activities"]["id"]);?>" ><?php echo $result[$i]["activities"]["name"] ?></a></td>
			<td>
			<?php 
			if($result[$i]["activities"]["startdtm"] != "" and  $result[$i]["activities"]["enddtm"] != ""){
			$startdtm = $result[$i]["activities"]["startdtm"];
			$enddtm = $result[$i]["activities"]["enddtm"];
			$dateArray=explode('-',$startdtm);
			$enddateArray=explode('-',$enddtm);
			$thai_month_arr=array(  "00"=>"",  
								    "01"=>"ม.ค.",  
								    "02"=>"ก.พ.",  
								    "03"=>"มี.ค.",  
								    "04"=>"เม.ย.",  
								    "05"=>"พ.ค.",  
								    "06"=>"มิ.ย.",   
								    "07"=>"ก.ค.",  
								    "08"=>"ส.ค.",  
								    "09"=>"ก.ย.",  
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
			<td><img style="cursor: pointer; cursor: hand;" onclick="alert('555');" src="<?php echo $this->Html->url('/img/icon_edit.png'); ?>" width="16" height="16" /></td>
			<td>
			<img style="cursor: pointer; cursor: hand;" onclick="deleteData('<?php echo $result[$i]["activities"]["id"] ?>');" src="<?php echo $this->Html->url('/img/icon_del.png'); ?>" width="16" height="16" />
			<input type="hidden" id="idDelete" value="<?php echo $result[$i]["activities"]["id"] ?>"/>
			</td>
		</tr>
		<?php } ?>
	</table>
<script type="text/javascript">
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

