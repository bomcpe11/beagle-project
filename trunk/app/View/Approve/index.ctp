<div class="section-layout" style="width:97%">
	<table>
		<tr>
			<td>ชื่อ - นามสกุล</td>
			<td>
				<select onchange="go_approve(this.value)">
					<option value="-1">---- กรุณาเลือก ----</option>
					<?php 
						$countData = count($dataList);
						for( $i=0;$i<$countData;$i++ ){
							echo '<option value="'.$dataList[$i]['profiles']['id'].'">'.$dataList[$i]['profiles']['nameth'].' '.$dataList[$i]['profiles']['lastnameth'].'</option>';
						}
					?>
				</select>
			</td>
		</tr>
	</table>
</div>
<!-- ################################################################################################## -->
<script>
	function go_approve(profile_id){
		var path = '<?php echo $this->Html->url('/Approve/goApprove');?>?profile_id='+profile_id;
		
		loading();
		window.location = path;
	}
</script>