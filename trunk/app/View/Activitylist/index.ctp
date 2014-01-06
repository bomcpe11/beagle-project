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
			<td><?php echo $result[$i]["activities"]["startdtm"].'-'.$result[$i]["activities"]["enddtm"]?></td>
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
		}
</script>

