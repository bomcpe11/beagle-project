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
		jQuery.post("<?php echo $this->Html->url('/login/loginAjax');?>"
				, {"username":username
					, "password":password
					, "rememberMe":rememberMe}
				, function(data) {
					if ( data.result.length > 0 ) {
						jQuery("#span_error").html("* " + data.result);
					} else {
						window.location.replace("<?php echo $this->webroot;?>profile/index");
					}// if else

					unloading();
				}// function(data)
				, "json").error(function() {
				}// function()
		);// jQuery.post
	}// submitValue
	/* ------------------------------------------------------------------------------------------------- */
	function goRegister() {
		window.location.replace("<?php echo $this->webroot;?>register/index");
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
						<input type="button" id="button_register" value="Register" onClick="JavaScript:goRegister()"/>
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
						ระบบจัดการข้อมูลผ่านทางเว็บไซด์เป็นส่วนหนึ่งของโครงการพัฒนาอัจฉริยภาพทางวิทยาศาสตร์และเทคโนโลยีส าหรับเด็กและ
						เยาวชน ( JSTP) ซึ่งจะรวบรวมและจัดเก็บข้อมูลส่วนบุคคลของนักเรียนที่สมัครเข้าร่วมโครงการ อาทิเช่น ประวัติส่วนบุคคล
						ประสบการณ์การท างานวิจัย ตลอดจนผลงานที่ได้รับรางวัล เป็นต้นโดยมีวัตถุประสงค์เพื่อพัฒนาการจัดเก็บข้อมูลอย่างเป็นระบบ
						สะดวกในการสืบค้นข้อมูล รวมทั้งยังสามารถติดตามความก้าวหน้าของนักเรียนที่ได้รับการคัดเลือกเข้าร่วมโครงการ เพื่อเป็น
						ประโยชน์ในการพัฒนาโครงการต่อไป
						</p>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>