<?php echo $this->Html->css('change_pwd');?>
<!-- ################################################################################### -->
<script type="text/JavaScript">
	/* ------------------------------------------------------------------------------- */
	jQuery(document).keyup(function(e) {
			if ( e.keyCode == 13 ) {
				updatePassword();
			}// if
		}// callback
	);// jQuery.keyup
	/* ------------------------------------------------------------------------------- */
	function updatePassword() {
		var oldPassword = jQuery("#text_old_password").val();
		var newPassword = jQuery("#text_new_password").val();
		var confirmNewPassword = jQuery("#text_confirm_new_password").val();

		// validate null data
		if ( !oldPassword || !newPassword || !confirmNewPassword ) {
			jAlert("คุณกรอกข้อมูลไม่ครบ" 
					, function(){ 
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);// jAlert

			return false;
		}// if
	
		// validate newPassword, confirmNewPassword
		if ( newPassword != confirmNewPassword ) {
			jAlert("รหัสผ่านใหม่ ไม่ตรงกัน" 
					, function(){ 
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);// jAlert
			
			return false;
		}// if

		//*** update password
		loading();
		jQuery.post("<?php echo $this->Html->url('/changepwd/updatePasswordFnc');?>"
				, {"oldPassword":oldPassword
					, "newPassword":newPassword}
				, function(data) {
						jAlert(data.result 
								, function(){ 
									if ( data.result == "แก้ไขรหัสผ่าน เรียบร้อย" ) {
										//*** logout
										loading();
										jQuery.post("<?php echo $this->Html->url('/logout/logoutAjax');?>"
												, {}
												, function(data) {
													if ( data.status ) {	// logout success
														//*** re login
														var username = "<?php echo $objuser['login'];?>";
														jQuery.post("<?php echo $this->Html->url('/login/loginAjax');?>"
																, {"username":username
																	, "password":newPassword
																	, "rememberMe":false}
																, function(data) {
																	if ( data.result ) {	// re login fail
																		jAlert(data.result
																				, function(){ 
																				}//okFunc	
																				, function(){ 
																					unloading();
																				}//openFunc
																				, function(){ 		
																				}//closeFunc
																		);// jAlert
																	} else {	// re login seccess
																		window.location.replace("<?php echo $this->webroot;?>profile/index");

																		unloading();
																	}// if else
																}// callback
																, "json").error(function() {
																}// error
														);// jQuery.post
													} else {	// logout fail
														jAlert("ระบบขัดข้อง กรุณาติดต่อผู้ดูแลระบบ" 
																, function(){ 
																}//okFunc	
																, function(){ 
																	unloading();
																}//openFunc
																, function(){ 		
																}//closeFunc
														);// jAlert
													}// if else
												}// callback
												, "json").error(function() {
												}// error
										);// jQuery.post
									}// if
								}//okFunc	
								, function(){ 
									unloading();
								}//openFunc
								, function(){ 		
								}//closeFunc
						);// jAlert
				}// callback
				, "json").error(function() {
				}// error
		);// jQuery.post
	}// updatePassword
	/* ------------------------------------------------------------------------------- */
</script>
<!-- ################################################################################### -->
<div class="page_layout">
	<table class="table_form">
		<tr>
			<td class="td_label">รหัสผ่านเดิม : </td>
			<td class="td_data">
				<input type="password" id="text_old_password" size="24"/>
				<span id="span_old_password"></span>
			</td>
		</tr>
		<tr>
			<td class="td_label">รหัสผ่านใหม่ : </td>
			<td class="td_data">
				<input type="password" id="text_new_password" size="24"/>
				<span id="span_new_password"></span>
			</td>
		</tr>
		<tr>
			<td class="td_label">ยืนยันรหัสผ่านใหม่ : </td>
			<td class="td_data">
				<input type="password" id="text_confirm_new_password" size="24"/>
				<span id="span_confirm_new_password"></span>
			</td>
		</tr>
		<tr>
			<td></td>
			<td>
				<input type="button" id="button_submit" value="ยืนยันการแก้ไขรหัสผ่าน" onClick="JavaScript:updatePassword();"/>
			</td>
		</tr>
	</table>
</div>
