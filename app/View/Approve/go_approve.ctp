<table class="section-layout" style="width:97%">
	<colgroup>
		<col style="width:40%"/>
		<col style="width:60%"/>
	</colgroup>
	<tr>
		<td colspan="2">
			<b>ชื่อ-นามสกุล :</b> 
			<?php echo $dataProfile[0]['profiles']['titleth'].' '.$dataProfile[0]['profiles']['nameth'].' '.$dataProfile[0]['profiles']['lastnameth'];?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<b>Name :</b> 
			<?php echo $dataProfile[0]['profiles']['titleen'].' '.$dataProfile[0]['profiles']['nameeng'].' '.$dataProfile[0]['profiles']['lastnameeng'];?>
		</td>
	</tr>
	<tr>
		<td><b>ชื่อเล่น :</b> <?php echo $dataProfile[0]['profiles']['nickname'];?></td>
		<td><b>รุ่น :</b> <?php echo $dataProfile[0]['profiles']['generation'];?></td>
	</tr>
	<tr>
		<td><b>วันเกิด :</b> <?php echo $birthday;?></td>
		<td><b>อายุ :</b> <?php echo $age;?></td>
	</tr>
	<tr>
		<td><b>สัญชาติ :</b> <?php echo $dataProfile[0]['profiles']['nationality'];?></td>
		<td><b>ศาสนา :</b> <?php echo $dataProfile[0]['profiles']['religious'];?></td>
	</tr>
	<tr>
		<td><b>สถานะภาพ :</b> <?php echo $dataProfile[0]['profiles']['socialstatus'];?></td>
		<td><b>สถานะภาพทางการศึกษา :</b> <?php echo $dataProfile[0]['profiles']['studystatus'];?></td>
	</tr>
	<tr>
		<td colspan="2">
			<b>ที่อยู่ :</b> <?php echo $dataProfile[0]['profiles']['address'];?>
		</td>
	</tr>
	<tr>
		<td><b>โทรศัพท์ :</b> <?php echo $dataProfile[0]['profiles']['telphone'];?></td>
		<td><b>โทรศัพท์มือถือ :</b> <?php echo $dataProfile[0]['profiles']['celphone'];?></td>
	</tr>
	<tr>
		<td><b>อีเมล์ :</b> <?php echo $dataProfile[0]['profiles']['email'];?></td>
	</tr>
	<tr>
		<td><b>Social Media :</b> <?php echo $dataProfile[0]['profiles']['blogaddress'];?></td>
	</tr>
	<tr style="text-align:center">
		<td colspan="2">
			<input type="button" value="Approve" onclick="do_approve(<?php echo $dataProfile[0]['profiles']['id'];?>)"/>
			<input type="button" value="Back" onclick="go_back()"/>
		</td>
	</tr>
</table>
<!-- ################################################################################################## -->
<script>
	jQuery(document).ready(function(){
		jQuery('input[type="button"]').button();
	});
	function do_approve(profile_id){
		jConfirm('กรุณายืนยัน', 
				function(){ //okFunc
					loading();
					jQuery.post('<?php echo $this->Html->url('/Approve/doApprove');?>'
							,{'data':{'profile_id':profile_id}}
							,function(data){
								jAlert(data.msg
										, function(){
											if(data.flg===1){
												go_back();
											}
										}//okFunc	
										, function(){
											unloading();
										}//openFunc
										, function(){ 		
										}//closeFunc
								);
							}
							,'json');
				}, 
				function(){ //cancelFunc
				}, 
				function(){ //openFunc
				}, 
				function(){ //closeFunc
				}
			);
	}
	function go_back(){
		var path = '<?php echo $this->Html->url('/Approve/index');?>';
		
		loading();
		window.location = path;
	}
</script>