<style type="text/css">
.tableLayout {
	width: 400px;
	margin: 100px auto 200px auto;
	background-color: #FCFCFC;
	border-radius:7px;
	padding: 0 20px 0 20px;
}
</style>
<!-- ###################################################################################################### -->
<script type="text/JavaScript">
	/* --------------------------------------------------------------------------------------------------- */
	jQuery(document).ready(function() {
			jQuery('input:button, input:submit, button').button();
		}// function
	);// jQuery.ready

	var profileid = '<?php echo $_GET['id']; ?>';
	var profilekey = '<?php echo $_GET['key']; ?>';
	
	function validateData(username, password, confirm_password){

		// validate text_password, text_confirm_password
		if ( password != confirm_password ) {
			jAlert("Password ไม่ตรงกัน"
					, function(){ 
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);// jAlert
			
			return false;
		}// if


		return true;
		
	}

	function submitRegister(){

		var username 			= jQuery("#txt_username").val();
		var password 			= jQuery("#txt_password").val();
		var confirm_password 	= jQuery("#txt_repassword").val();

		if(validateData(username, password, confirm_password)){

			loading();
			jQuery.post('<?php echo $this->Html->url('/Register/setUP');?>'
					, { username : username,
						password : password,
						profileid : profileid,
						profilekey : profilekey
						}
					, function(data) {
						unloading();
						if(data.result.status){
							jAlert(data.result.message
									, function(){ 
										
										window.location.replace("<?php echo $this->webroot;?>Login/index");
									}//okFunc	
									, function(){ 
									}//openFunc
									, function(){ 		
									}//closeFunc
							);// jAlert
						}else{
							jAlert(data.result.message
									, function(){ 
									}//okFunc	
									, function(){ 
									}//openFunc
									, function(){ 		
									}//closeFunc
							);// jAlert
						}
					}// function(data)
					, 'json').error(function() {
						unloading();

						jAlert('Ajax Error : submitRegister'
								, function(){ 
								}//okFunc	
								, function(){ 
								}//openFunc
								, function(){ 		
								}//closeFunc
						);// jAlert
					}// function()
			);// jQuery.post
			
		}
		
	}
</script>
<!-- ###################################################################################################### -->
<!-- <form action="<?php echo $this->Html->url('/Register/setUP'); ?>" method="post" > -->
<table class="tableLayout">
	<tr>
		<td colspan="2" style="height:40px;"><h3>ลงทะเบียน Username และ Password</h3></td>
	</tr>
	<tr>
		<td>Username : </td>
		<td><input type="text" id="txt_username" /> *</td>
	</tr>
	<tr>
		<td>Password : </td>
		<td><input type="password" id="txt_password" /> *</td>
	</tr>
	<tr>
		<td>Re-password : </td>
		<td><input type="password" id="txt_repassword" /> *</td>
	</tr>
	<tr>
		<td colspan="2" align="center" style="height:50px;">
			<input type="button" value="ลงทะเบียน" onclick="submitRegister();" />
		</td>
	</tr>
</table>
<!-- </form> -->