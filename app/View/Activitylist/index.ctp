<?php

?>
	<table class="tableLayout" border="1" bordercolor="#eeeeee" width="100%">
		<tr align="center" style="font-weight: bold;">
			<td width="15%" >ชื่อกิจกรรม</td>
			<td width="15%">วันที่จัดกิจกรรม</td>
			<td width="20%">สถานที่จัดกิจกรรม</td>
			<td width="15%">ชื่อเรื่อง</td>
			<td width="20%">รายละเอียดอย่างย่อ</td>
			<td width="5%">แก้ไข</td>
			<td width="10%">ลบกิจกรรม</td>
		</tr>
		<?php for($i=0; $i<count($result); $i++){ ?>
		<tr align="center">
			<td width="15%"><?php echo $result[$i]["activities"]["name"] ?></td>
			<td width="15%"><?php echo $result[$i]["activities"]["startdtm"].'-'.$result[$i]["activities"]["enddtm"]?></td>
			<td width="20%"><?php echo $result[$i]["activities"]["location"] ?></td>
			<td width="15%"><?php echo $result[$i]["activities"]["genname"] ?></td>
			<td width="20%"><?php echo $result[$i]["activities"]["shortdesc"] ?></td>
			<td width="5%">/</td>
			<td width="10%"><a style="cursor: pointer; cursor: hand;" onclick="deleteData('<?php echo $result[$i]["activities"]["id"] ?>');">X</a>
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

