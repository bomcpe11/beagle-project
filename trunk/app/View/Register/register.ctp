<?php echo $this->Html->css('registers');?>
<?php echo $this->Html->css('captcha_style');?>
<!-- ###################################################################################################### -->
<script type="text/JavaScript">
	/* --------------------------------------------------------------------------------------------------- */
	jQuery(document).ready(function() {
			// set datepicker
			setBirthDatePicker(".datePicker");
		}// function
	);// jQuery.ready
	/* --------------------------------------------------------------------------------------------------- */
	function change_Captcha(){
		jQuery("#captcha").attr("src", "<?php echo $this->webroot;?>reCaptcha/get_captcha.php?rnd=" + Math.random());
	}// change_Captcha
	/* --------------------------------------------------------------------------------------------------- */
	function submitData() {
		var cardtype = jQuery("#select_cardtype").val();
		var cardid = jQuery("#text_cardid").val();
		var titleth = jQuery("#select_titleth").val();
		var nameth = jQuery("#text_nameth").val();
		var lastnameth = jQuery("#text_lastnameth").val();
		var titleen = jQuery("#select_titleen").val();
		var nameeng = jQuery("#text_nameeng").val();
		var lastnameeng = jQuery("#text_lastnameeng").val();
		var nickname = jQuery("#text_nickname").val();
		var generation = jQuery("#text_generation").val();
		var birthday = jQuery("#text_birthday").val();
		var nationality = jQuery("#text_nationality").val();
		var religious = jQuery("#text_religious").val();
		var socialstatus = jQuery("#text_socialstatus").val();
		var studystatus = jQuery("#text_studystatus").val();
		var address = jQuery("#textarea_address").val();
		var telphone = jQuery("#text_telphone").val();
		var celphone = jQuery("#text_celphone").val();
		var email = jQuery("#text_email").val();
		var position = jQuery("#text_position").val();
		var blogaddress = jQuery("#text_blogaddress").val();
		var username = jQuery("#text_username").val();
		var password = jQuery("#text_password").val();
		var confirm_password = jQuery("#text_confirm_password").val();
		var captcha_code = jQuery("#captcha_code").val();
		
		// validate field *
		if ( cardtype.length == 0
				|| cardid.length == 0
				|| titleth.length == 0
				|| nameth.length == 0
				|| lastnameth.length == 0
				|| titleen.length == 0
				|| nameeng.length == 0
				|| lastnameeng.length == 0
				|| nickname.length == 0
				|| generation.length == 0
				|| birthday.length == 0
				|| email.length == 0
				|| username.length == 0
				|| password.length == 0
				|| confirm_password.length == 0
				|| captcha_code.length == 0 ) {
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

		// validate select_cardtype
		if ( cardtype == "-1") {
			jAlert("กรุณาเลือกประเภทของบัตร" 
					, function(){ 
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);// jAlert
			
			return false;
		}// if
		
		// validate titlename
		if ( titleth == "-1"
				|| titleen == "-1" ) {
			jAlert("กรุณาเลือกคำหน้านำชื่อ" 
					, function(){ 
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);// jAlert
			
			return false;
		}// if

		// validate text_cardid
		if ( !validateCardId(cardid) ) {
			jAlert("เลขบัตรประจำตัวประชาชน ไม่ถูกต้อง"
					, function(){ 
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);// jAlert
			
			return false;
		}// if

		// validate text_email
		if ( !validateEmail(email) ) {
			jAlert("อีเมล์ ไม่ถูกต้อง"
					, function(){ 
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);// jAlert
			
			return false;
		}// if

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

		loading();
		
		jQuery.post("<?php echo $this->Html->url('/register/insertFnc');?>"
				, {"cardtype":cardtype
					, "cardid":cardid
					, "titleth":titleth
					, "nameth":nameth
					, "lastnameth":lastnameth
					, "titleen":titleen
					, "nameeng":nameeng
					, "lastnameeng":lastnameeng
					, "nickname":nickname
					, "generation":generation
					, "birthday":birthday
					, "nationality":nationality
					, "religious":religious
					, "socialstatus":socialstatus
					, "studystatus":studystatus
					, "address":address
					, "telphone":telphone
					, "celphone":celphone
					, "email":email
					, "position":position
					, "blogaddress":blogaddress
					, "username":username
					, "password":password
					, "captcha_code":captcha_code}
				, function(data) {
					if ( data.result ) {
						jAlert(data.result
								, function(){ 
									if ( data.result == "ลงทะเบียนเรียบร้อย" ) {
										window.location.replace("<?php echo $this->webroot;?>login/index");
									}// if
								}//okFunc	
								, function(){ 
								}//openFunc
								, function(){ 		
								}//closeFunc
						);// jAlert
					}//if else

					unloading();
				}// function(data)
				, "json").error(function() {
				}// function()
		);// jQuery.post
	}// submitData
	/* --------------------------------------------------------------------------------------------------- */
	function validateCardId(cardId) {
		var pattern = /^[0-9]{13}$/;

		return pattern.test(cardId);
	}// validateCardId
	/* --------------------------------------------------------------------------------------------------- */
	function validateEmail(email) { 
        var pattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/; 
        
        return pattern.test(email);
	}// validateEmail
	/* --------------------------------------------------------------------------------------------------- */
	function clearScreen() {
		// clear select
		jQuery("select").val("-1");
		// clear text box
		jQuery("input[type='text']").val(null);
		// clear text area
		jQuery("textarea").val(null);
		// clear text password
		jQuery("input[type='password']").val(null);
	}// clearScreen
</script>
<!-- ###################################################################################################### -->
<table align="center" class="tableLayout">
	<tr>
		<td colspan="4" style="height: 50px;">
			<span class="header1">ลงทะเบียนเข้าร่วม</span>
		</td>
	</tr>
	<tr>
		<td colspan="4" style="height: 25px;padding-left: 25px;">
			<span class="header2">โครงการพัฒนาศักยภาพ โครงการพัฒนาอัจฉริยภาพทางวิทยาศาสตร์และเทคโนโลยีสำหรับเด็กและเยาวชน</span>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">* ประเภทของบัตร : </td>
		<td class="tdData">
			<select id="select_cardtype">
				<option value='-1'>---- กรุณาเลือก ----</option>
			<?php for ( $i = 0; $i < count($personalIdType); $i++ ) { ?>
				<option value="<?php echo $personalIdType[$i]['gvars']['varcode'];?>"><?php echo $personalIdType[$i]["gvars"]["vardesc1"];?></option>
			<?php } ?>
			</select>
		</td>
		
		<td class="tdLabel">* เลขบัตรจำตัว : </td>
		<td class="tdData">
			<input type="text" id="text_cardid" class="textbox" value="" size="24" maxlength="20"/>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">* คำนำหน้าชื่อ : </td>
		<td colspan="3" class="tdData">
			<select id="select_titleth">
				<option value='-1'>---- กรุณาเลือก ----</option>
			<?php for ( $i = 0; $i < count($namePrefixTh); $i++ ) { ?>
				<option value="<?php echo $namePrefixTh[$i]['gvars']['vardesc1'];?>"><?php echo $namePrefixTh[$i]["gvars"]["vardesc1"];?></option>
			<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">* ชื่อ (ภาษาไทย) : </td>
		<td class="tdData">
			<input type="text" id="text_nameth" class="textbox" value="" size="24" maxlength="255"/>
		</td>
		
		<td class="tdLabel">* นามสกุล (ภาษาไทย) : </td>
		<td class="tdData">
			<input type="text" id="text_lastnameth" class="textbox" value="" size="24" maxlength="255"/>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">* คำนำหน้าชื่อ : </td>
		<td colspan="3" class="tdData">
			<select id="select_titleen">
				<option value='-1'>---- กรุณาเลือก ----</option>
			<?php for ( $i = 0; $i < count($namePrefixEn); $i++ ) { ?>
				<option value="<?php echo $namePrefixEn[$i]['gvars']['vardesc1'];?>"><?php echo $namePrefixEn[$i]["gvars"]["vardesc1"];?></option>
			<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">* ชื่อ (ภาษาอังกฤษ) : </td>
		<td class="tdData">
			<input type="text" id="text_nameeng" class="textbox" value="" size="24" maxlength="255"/>
		</td>
		
		<td class="tdLabel">* นามสกุล (ภาษาอังกฤษ) : </td>
		<td class="tdData">
			<input type="text" id="text_lastnameeng" class="textbox" value="" size="24" maxlength="255"/>
		</td>
	</tr>
	<tr>
	<td class="tdLabel">* ชื่อเล่น : </td>
		<td class="tdData">
			<input type="text" id="text_nickname" class="textbox" value="" size="24" maxlength="255"/>
		</td>
		
		<td class="tdLabel">* ชื่อรุ่น : </td>
		<td class="tdData">
			<input type="text" id="text_generation" class="textbox" value="" size="24" maxlength="255"/>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">* วันเกิด : </td>
		<td class="tdData">
			<input type="text" id="text_birthday" class="datePicker" value="" size="24" readonly="readonly"/>
		</td>
		
		<td class="tdLabel">สัญชาติ : </td>
		<td class="tdData">
			<input type="text" id="text_nationality" class="textbox" value="" size="24" maxlength="255"/>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">ศาสนา : </td>
		<td class="tdData">
			<input type="text" id="text_religious" class="textbox" value="" size="24" maxlength="255"/>
		</td>
		
		<td class="tdLabel">สถานะภาพ : </td>
		<td class="tdData">
			<input type="text" id="text_socialstatus" class="textbox" value="" size="24" maxlength="255"/>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">สถานะภาพทางการศึกษา : </td>
		<td class="tdData">
			<input type="text" id="text_studystatus" class="textbox" value="" size="24" maxlength="255"/>
		</td>
		
		<td class="tdLabel">ที่อยู่ : </td>
		<td rowspan="2" class="tdData">
			<textarea rows="3" cols="30" id="textarea_address" maxlength="1000"></textarea>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">โทรศัพท์ : </td>
		<td class="tdData">
			<input type="text" id="text_telphone" class="textbox" value="" size="24" maxlength="255"/>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">โทรศัพท์มือถือ : </td>
		<td class="tdData">
			<input type="text" id="text_celphone" class="textbox" value="" size="24" maxlength="255"/>
		</td>
		
		<td class="tdLabel">* อีเมล์ : </td>
		<td class="tdData">
			<input type="text" id="text_email" class="textbox" value="" size="24" maxlength="255"/>
		</td>
	</tr>
	<tr>
		<td class="tdLabel">ตำแหน่งทางวิชาการ(ถ้ามี) : </td>
		<td class="tdData">
			<input type="text" id="text_position" class="textbox" value="" size="24" maxlength="255"/>
		</td>
		
		<td class="tdLabel">Social network url : </td>
		<td class="tdData">
			<input type="text" id="text_blogaddress" class="textbox" value="" size="24" maxlength="255"/>
		</td>
	</tr>
	<tr>
		<td colspan="2">
			<!-- table username, password -->
			<table width="100%">
				<tr>
					<td class="tdLabel">* Username : </td>
					<td class="tdData">
						<input type="text" id="text_username" class="textbox" value="" size="24" maxlength="255"/>
					</td>
				</tr>
				<tr>
					<td class="tdLabel">* Password : </td>
					<td class="tdData">
						<input type="password" id="text_password" class="textbox" value="" size="24" maxlength="40"/>
					</td>
				</tr>
				<tr>
					<td class="tdLabel">* Password confirm : </td>
					<td class="tdData">
						<input type="password" id="text_confirm_password" class="textbox" value="" size="24" maxlength="40"/>
					</td>
				</tr>
			</table>
		</td>
		<td colspan="2">
			<!-- table captcha-->
			<table width="100%">
				<tr align="center">
					<td>
						<div id="captcha-wrap">
							<div class="captcha-box">
								<img src="<?php echo $this->webroot;?>reCaptcha/get_captcha.php" alt="" id="captcha" />
							</div>
							<div class="text-box">
								<label>* กรุณากรอกข้อความที่เห็น : </label>
								<input name="captcha-code" type="text" id="captcha_code"/>
							</div>
							<div class="captcha-action">
								<img style="width: 25px;height: 25px;" src="<?php echo $this->webroot;?>img/refresh-icon.gif" alt="" id="captcha-refresh" onClick="JavaScript:change_Captcha();" />
							</div>
						</div>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr align="center" style="height: 50px;">
		<td colspan="4">
			<input type="button" value="ยืนยันการลงทะเบียน" onClick="JavaScript:submitData();"/>
			<input type="button" value="ล้างข้อมูล" onClick="JavaScript:clearScreen();"/>
		</td>
	</tr>
	
</table>