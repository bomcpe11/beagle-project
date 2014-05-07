<?php echo $this->Html->css('logins');?>
<div class="tableLayout" style="padding: 10px;">
	<h2>Reset Password</h2>
	<table align="center" style="margin-top: 10px;">
		<tr>
			<td align="right" class="tdLabel">Username :</td>
			<td align="left">
				<input type="hidden" id="id" value="<?php echo $dataProfile[0]['p']['id']; ?>"/>
				<input type="text" id="txt_username" value="<?php echo $dataProfile[0]['p']['login']; ?>" readonly/>
			</td>
		</tr>
		<tr>
			<td align="right" class="tdLabel">Password :</td>
			<td align="left"><input type="password" id="txt_password" maxlength="100"/> *</td>
		</tr>
		<tr>
			<td align="right" class="tdLabel">Re-Password :</td>
			<td align="left"><input type="password" id="txt_re_password" maxlength="100"/> *</td>
		</tr>
		<tr>
			<td></td>
			<td align="left">
				<input type="button" class="button" onclick="submitResetPassword()" value="ตกลง"/>
				<input type="button" class="button" onclick="clearData()" value="ล้างข้อมูล"/>
			</td>
		</tr>
	</table>
</div>
<!-- ##################################################################################################### -->
<script type="text/javascript">
	function submitResetPassword(){
		var id = jQuery('#id').val();
		var username = jQuery('#txt_username').val();
		var password = jQuery('#txt_password').val();
		var rePassword = jQuery('#txt_re_password').val();

		if ( !password || !rePassword ) {
			jAlert("กรุณากรอกข้อมูลช่องที่ * ให้ครบ" 
					, function(){ 
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);
			
			return false;
		}

		if ( password!==rePassword ) {
			jAlert("Password ไม่ตรงกัน" 
					, function(){ 
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);
			
			return false;
		}
		
		var data = {'id':id,
					'username':username,
					'password':password,
					'rePassword':rePassword}
		loading();
		jQuery.post('<?php echo $this->Html->url('/Login/submitResetPassword');?>',
					data,
					function(data){
						unloading();

						jAlert(data.msg
								, function(){ 
								}//okFunc	
								, function(){ 
								}//openFunc
								, function(){
									if( data.flg==='1' ){
										 window.location.assign('<?php echo $this->Html->url('/Login/index');?>');
									}
								}//closeFunc
						);// jAlert
					},
					"json").error(function(p1,p2,p3) {
						console.log(p1);
						console.log(p2);
						console.log(p3);
						jAlert(p1+'/'+p2+'/'+p3);
					}// function()
		);
	}
	function clearData(){
		jQuery('#txt_password').val('');
		jQuery('#txt_re_password').val('');
	}
</script>
