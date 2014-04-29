<?php echo $this->Html->css('logins');?>
<!-- ###################################################################################################### -->
<script type="text/JavaScript">
	/* ------------------------------------------------------------------------------------------------- */
	jQuery(document).keyup(function(e) {
			// check e.keyCode
			if ( e.keyCode == 13 ) {	// press enter
				var username = jQuery("#text_username").val();
				var password = jQuery("#text_password").val();
		
				// check data in username, password
				if ( username.length > 0 && password.length > 0 ) {
					loginFnc();
				}// if 
			}// if 
		}// function(e)
	);// jQuery.keyup
	/* ------------------------------------------------------------------------------------------------- */
	jQuery(document).ready(function() {
		jQuery('#button_login, #button_register').button();
		}// function()
	);// jQuery.ready
	/* ------------------------------------------------------------------------------------------------- */
	function loginFnc() {
		var username = jQuery("#text_username").val();
		var password = jQuery("#text_password").val();
		var rememberMe = jQuery("#checkbox_remem").is(":checked");

		if( !username ){
			jQuery('#span_error').html('* กรุณากรอก Username');
			
			return;
		}
		if( !password ){
			jQuery('#span_error').html('* กรุณากรอก Password');

			return;
		}
		
		loading();
		jQuery.post('<?php echo $this->Html->url('/login/loginAjax');?>'
				, {'username':username
					, 'password':password
					, 'rememberMe':rememberMe}
				, function(data) {
					if ( data.profile_id===-1 ) {
						jQuery('#span_error').html('* ' + data.msg);
					} else {
						jQuery('#span_error').html(data.msg);
						//window.location.replace('<?php echo $this->webroot;?>profile/index?id='+data.profile_id);
						window.location.replace('<?php echo $this->webroot;?>Mainmenu');
					}// if else

					unloading();
				}// function(data)
				, 'json').error(function() {
				}// function()
		);// jQuery.post
	}// submitValue
	/* ------------------------------------------------------------------------------------------------- */
	function goRegister() {
		var buttons = [
				{text: "Next", 
					click: function(){
						submit_newmember();
					}
				}
			];
		jQuery('#frm-newmember').css('width', '500px');
		openPopupHtml('ลงทะเบียนสมาชิกใหม่', '#frm-newmember', buttons, 
			function(){ //openFunc
// 				jQuery('.popup1').append(' TEST AFTER');
// 				alert('opened');
			}, 
			function(){ //closeFunc
// 				alert('closed');
			}
		);
	}// goRegister
</script>
<!-- ###################################################################################################### -->
<table align="center" class="tableLayout">
	<tr>
		<td class="upperBar">
			<table class="tableForm">
				<tr>
					<td colspan="2"><h2>JSTP Login</h2></td>
				</tr>
				<tr>
					<td align="right" class="tdLabel">Username :</td>
					<td align="left"><input type="text" id="text_username" class="textbox" maxlength="100"/></td>
				</tr>
				<tr>
					<td align="right" class="tdLabel">Password :</td>
					<td align="left"><input type="password" id="text_password" maxlength="100"/></td>
				</tr>
				<tr>
					<td></td>
					<td align="left">
						<input type="checkbox" id="checkbox_remem" value="remem"/> Remember me
					</td>
					
				</tr>
				<tr>
					<td></td>
					<td align="left">
						<span id="span_error"></span>
					</td>
				</tr>
				<tr>
					<td></td>
					<td align="left">
						<input type="submit" id="button_login" value="Login" onClick="JavaScript:loginFnc();"/>
						<input type="button" id="button_register" value="Sign in" onClick="JavaScript:goRegister()"/>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table style="padding: 20px;">
				<tr>
					<td>
						<img width="150px" height="150px" src="<?php echo $this->webroot;?>img/JSTPLogo2.gif"/>
					</td>
					<td style="padding-left: 20px;">
						<p style="text-indent: 25px;word-wrap: break-word;">
						ระบบจัดการข้อมูลผ่านทางเว็บไซด์เป็นส่วนหนึ่งของโครงการพัฒนาอัจฉริยภาพทางวิทยาศาสตร์และเทคโนโลยีสำหรับเด็กและ
						เยาวชน ( JSTP) ซึ่งจะรวบรวมและจัดเก็บข้อมูลส่วนบุคคลของนักเรียนที่สมัครเข้าร่วมโครงการ อาทิเช่น ประวัติส่วนบุคคล
						ประสบการณ์การทำงานวิจัย ตลอดจนผลงานที่ได้รับรางวัล เป็นต้นโดยมีวัตถุประสงค์เพื่อพัฒนาการจัดเก็บข้อมูลอย่างเป็นระบบ
						สะดวกในการสืบค้นข้อมูล รวมทั้งยังสามารถติดตามความก้าวหน้าของนักเรียนที่ได้รับการคัดเลือกเข้าร่วมโครงการ เพื่อเป็น
						ประโยชน์ในการพัฒนาโครงการต่อไป
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
<div style="display:none;">
	<div id="frm-newmember">
		<table>
		<tr>
			<td colspan="2">กรณีมีการเปลี่ยนชื่อ หรือ นามสกุล กรุณาพิมพ์ชื่อเดิม และ นามสกุลเดิมที่เคยแจ้งชื่อไว้กับโครงการฯ ในรุ่นของท่าน เพื่อใช้สำหรับตรวจสอบข้อมูลเบื้องต้น<br /><br /></td>
		</tr>
		<tr>
			<td>ประเภทของบัตร : </td>
			<td>
				<select id="select_cardtype">
					<option value="">---- กรุณาเลือก ----</option>

			<?php for ( $i = 0; $i < count($personalIdType); $i++ ) { ?>
				<option value="<?php echo $personalIdType[$i]['gvars']['varcode'];?>"><?php echo $personalIdType[$i]['gvars']['vardesc1'];?></option>
			<?php } ?>
				
			</select> *
				</td>
			</tr>
			<tr>
				<td>เลขบัตรประจำตัว : </td>
				<td><input type="text" id="txt_cardid" /> *</td>
			</tr>
			<tr>
				<td>ชื่อ (ภาษาไทย) : </td>
				<td><input type="text" id="txt_name" /> *</td>
			</tr>
			<tr>
				<td>นามสกุล (ภาษาไทย) : </td>
				<td><input type="text" id="txt_surname" /> *</td>
			</tr>
			<tr>
				<td>วันเดือนปี เกิด : </td>
				<td><input type="text" id="txt_birthdate" class="birthDatePicker" /> *</td>
			</tr>
			<tr>
				<td>อีเมล์ : </td>
				<td><input type="text" id="txt_email" /> *</td>
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
		</table>
	</div>
</div>

<script type="text/javascript">
	setBirthDatePicker(".birthDatePicker");

	function submit_newmember(){
		var input_container = jQuery('#frm-newmember');

		var select_cardtype = input_container.find('#select_cardtype').val();
		var txt_cardid = jQuery.trim(input_container.find('#txt_cardid').val());
		var txt_name = jQuery.trim(input_container.find('#txt_name').val());
		var txt_surname = jQuery.trim(input_container.find('#txt_surname').val());
		var txt_birthdate = input_container.find('#txt_birthdate').val();
		var txt_email = jQuery.trim(input_container.find('#txt_email').val());
		var txt_username = jQuery.trim(input_container.find('#txt_username').val());
		var txt_password = input_container.find('#txt_password').val();
		var txt_repassword = input_container.find('#txt_repassword').val();

		// validate field *
		if ( !select_cardtype
			|| !txt_cardid
			|| !txt_name 
			|| !txt_surname
			|| !txt_birthdate
			|| !txt_email
			|| !txt_username
			|| !txt_password
			|| !txt_repassword ) {
			jAlert("กรุณากรอกข้อมูลช่องที่ * ให้ครบ" 
					, function(){ 
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);// jAlert
			
			return false;
		}// if

		if(txt_password!=txt_repassword){
			jAlert("Re-password ไม่ถูกต้อง" 
					, function(){ 
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);// jAlert
		}
		
		var data = {select_cardtype: select_cardtype,
					txt_cardid: txt_cardid,
					txt_name: txt_name,
					txt_surname: txt_surname,
					txt_birthdate: txt_birthdate,
					txt_email: txt_email,
					txt_username: txt_username,
					txt_password: txt_password
				};
// 		console.log(data);
		loading();
		jQuery.post("<?php echo $this->Html->url('/Login/signinmember_submit');?>", 
				data,
				function(data) {
					if ( data.result.status ) {
						jAlert(data.result.message
								, function(){ 
									window.location.replace('<?php echo $this->webroot;?>Mainmenu');
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
						);
					}
		
					unloading();
				}// function(data)
				, "json").error(function() {
					jAlert('Ajax Error : sign-in new member');
					unloading();
				}// function()
		);// jQuery.post
	}
</script>