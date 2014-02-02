<table class="table-data">
	<colgroup>
		<col style="width:5%">
		<col style="width:25%">
		<col style="width:10%">
		<col style="width:10%">
		<col style="width:20%">
		<col style="width:30%">
	</colgroup>
	<tr>
		<th>ลำดับ</th>
		<th>ชื่อ - นามสกุล</th>
		<th>ชื่อเล่น</th>
		<th>อายุ</th>
		<th>โทรศัพท์</th>
		<th>อีเมล์</th>
	</tr>
	<?php 
		$countData = count($dataList);
		for( $i=0;$i<$countData;$i++ ){
			echo "<tr title='คลิ๊กเพื่อไปหน้า Approve' onclick='go_approve(".$dataList[$i]['profiles']['id'].")'>
					<td style='text-align:center'>".($i + 1)."</td>
					<td>".$dataList[$i]['profiles']['titleth']." ".$dataList[$i]['profiles']['nameth']." ".$dataList[$i]['profiles']['lastnameth']."</td>
					<td>".$dataList[$i]['profiles']['nickname']."</td>
					<td>".$dataList[$i]['profiles']['age']."</td>
					<td>".$dataList[$i]['profiles']['telphone']."</td>
					<td>".$dataList[$i]['profiles']['email']."</td>
				</tr>";
		}
	
	
	?>
</table>
<!-- ################################################################################################## -->
<script>
	function go_approve(profile_id){
		var path = '<?php echo $this->Html->url('/Approve/goApprove');?>?profile_id='+profile_id;
		
		loading();
		window.location = path;
	}
</script>