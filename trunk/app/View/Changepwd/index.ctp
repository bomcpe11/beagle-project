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

		loading();
		jQuery.post("<?php echo $this->Html->url('/changepwd/updatePasswordFnc');?>"
				, {"oldPassword":oldPassword
					, "newPassword":newPassword}
				, function(data) {
					jAlert(data.result 
							, function(){ 
								if ( data.result == "แก้ไขรหัสผ่าน เรียบร้อย" ) {
									window.location.replace("<?php echo $this->webroot;?>login/index");
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
