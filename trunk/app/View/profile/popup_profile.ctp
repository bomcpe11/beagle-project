<script>
	function edit_profile() {
		var strHtml = '<div class="table" style="width: 700px;">\
						<ul>\
							<li class="single">\
								<p><strong>* คำนำหน้าชื่อ :</strong></p>\
								<p>\
									<select id="select-title-name-th">\
										<option value="">---- กรุณาเลือก ----</option>\
										<?php for ( $i = 0; $i < count($namePrefixTh); $i++ ) { ?>\
											<?php if ( $namePrefixTh[$i]["gvars"]["vardesc1"] == $objuser["titleth"]) { ?>\
												<option value=<?php echo $namePrefixTh[$i]["gvars"]["vardesc1"];?> selected><?php echo $namePrefixTh[$i]["gvars"]["vardesc1"];?></option>\
											<?php } else { ?>\
												<option value=<?php echo $namePrefixTh[$i]["gvars"]["vardesc1"];?>><?php echo $namePrefixTh[$i]["gvars"]["vardesc1"];?></option>\
											<?php } ?>\
										<?php } ?>\
									</select>\
								</p>\
							</li>\
							<li>\
								<p><strong>* ชื่อ(ภาษาไทย) :</strong></p>\
								<p>\
									<input id="text-name-th" type="text" value=<?php echo $objuser["nameth"];?>>\
								</p>\
								<p><strong>* นามสกุล(ภาษาอังกฤษ) :</strong></p>\
								<p>\
									<input id="text-lastname-th" type="text" value=<?php echo $objuser["lastnameth"];?>>\
								</p>\
							</li>\
							<li class="single">\
								<p><strong>* คำนำหน้าชื่อ :</strong></p>\
								<p>\
									<select id="select_title-name-eng">\
										<option value="">---- กรุณาเลือก ----</option>\
										<?php for ( $i = 0; $i < count($namePrefixEn); $i++ ) { ?>\
											<?php if ( $namePrefixEn[$i]["gvars"]["vardesc1"] == $objuser["titleen"] ) { ?>\
												<option value=<?php echo $namePrefixEn[$i]["gvars"]["vardesc1"];?> selected><?php echo $namePrefixEn[$i]["gvars"]["vardesc1"];?></option>\
											<?php } else { ?>\
												<option value=<?php echo $namePrefixEn[$i]["gvars"]["vardesc1"];?>><?php echo $namePrefixEn[$i]["gvars"]["vardesc1"];?></option>\
											<?php } ?>\
										<?php } ?>\
									</select>\
								</p>\
							</li>\
							<li>\
								<p><strong>* ชื่อ(ภาษาอังกฤษ) :</strong></p>\
								<p>\
									<input id="text-name-eng" type="text" value=<?php echo $objuser["nameeng"];?>>\
								</p>\
								<p><strong>* นามสกุล(ภาษาอังกฤษ) :</strong></p>\
								<p>\
									<input id="text-last-name-eng" type="text" value=<?php echo $objuser["lastnameeng"];?>>\
								</p>\
							</li>\
							<li>\
								<p><strong>* ชื่อเล่น :</strong></p>\
								<p>\
									<input id="text-nickname" type="text" value=<?php echo $objuser["nickname"];?>>\
								</p>\
								<p><strong>* ชื่อรุ่น :</strong></p>\
								<p>\
									<input id="text-generation" type="text" value=<?php echo $objuser["generation"];?>>\
								</p>\
							</li>\
							<li class="single">\
								<p><strong>* วันเกิด :</strong></p>\
								<p>\
									<input id="text-birthday" class="birthDatePicker" type="text" value="">\
								</p>\
							</li>\
							<li>\
								<p><strong>สัญชาติ :</strong></p>\
								<p>\
									<input id="text-nationality" type="text" value=<?php echo $objuser["nationality"];?>>\
								</p>\
								<p><strong>ศาสนา :</strong></p>\
								<p>\
									<input id="text-religious" type="text" value=<?php echo $objuser["religious"];?>>\
								</p>\
							</li>\
							<li>\
								<p><strong>สถานะภาพ :</strong></p>\
								<p>\
									<input id="text-social-status" type="text" value=<?php echo $objuser["socialstatus"];?>>\
								</p>\
								<p><strong>สถานะภาพทางการศึกษา :</strong></p>\
								<p>\
									<input id="text-study-status" type="text" value=<?php echo $objuser["studystatus"];?>>\
								</p>\
							</li>\
							<li class="single">\
								<p><strong>ที่อยู่ :</strong></p>\
								<p>\
									<textarea id="textarea-address" rows="3"><?php echo trim($objuser["address"]);?></textarea>\
								</p>\
							</li>\
							<li>\
								<p><strong>โทรศัพท์ :</strong></p>\
								<p>\
									<input id="text-tel-phone" type="text" value=<?php echo $objuser["telphone"];?>>\
								</p>\
								<p><strong>โทรศัพท์มือถือ :</strong></p>\
								<p>\
									<input id="text-cel-phone" type="text" value=<?php echo $objuser["celphone"];?>>\
								</p>\
							</li>\
							<li class="single">\
								<p><strong>* อีเมล์ :</strong></p>\
								<p>\
									<input id="text-email" type="text" value=<?php echo $objuser["email"];?>>\
								</p>\
							</li>\
							<li class="single">\
								<p><strong>Sosial Media :</strong></p>\
								<p>\
									<input id="text-blog-address" type="text" value=<?php echo $objuser["blogaddress"];?>>\
									<input id="hidden-profile-id" type="hidden" value=<?php echo $objuser["id"];?>>\
								</p>\
							</li>\
						</ul>\
					</div>';
	
		var buttons = [
			               {
				               text: "บันทึก", click: function() {
				            	   editProfile();
				               }
			               }
			       		];
	
		openPopupHtml("แก้ไขข้อมูลส่วนตัว", strHtml, buttons, 
				function(){ //openFunc
					setBirthDatePicker(".birthDatePicker");
				}, 
				function(){ //closeFunc
				}
		);
	}
	function editProfile() {
		var titleTh 		= jQuery("#select-title-name-th").val();
		var nameTh 			= jQuery("#text-name-th").val();
		var lastnameTh 		= jQuery("#text-lastname-th").val();
		var titleEng 		= jQuery("#select_title-name-eng").val();
		var nameEng 		= jQuery("#text-name-eng").val();
		var lastnameEng 	= jQuery("#text-last-name-eng").val();
		var nickname 		= jQuery("#text-nickname").val();
		var generation 		= jQuery("#text-generation").val();
		var birthday 		= jQuery("#text-birthday").val();
		var nationality 	= jQuery("#text-nationality").val();
		var religious 		= jQuery("#text-religious").val();
		var socialStatus 	= jQuery("#text-social-status").val();
		var studyStatus 	= jQuery("#text-study-status").val();
		var address 		= jQuery("#textarea-address").val();
		var telPhone 		= jQuery("#text-tel-phone").val();
		var celPhone 		= jQuery("#text-cel-phone").val();
		var email 			= jQuery("#text-email").val();
		var blogAddress 	= jQuery("#text-blog-address").val();
		var profileId 		= jQuery("#hidden-profile-id").val();
	
		if ( !titleTh
			|| !nameTh
			|| !lastnameTh
			|| !titleEng
			|| !nameEng
			|| !lastnameEng
			|| !nickname
			|| !generation
			|| !birthday
			|| !email ) {
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
	
		if ( !validateEmail(email )) {
			jAlert("อีเมล์ ไม่ถูกต้อง"
					, function(){ 
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);
	
			return false;
		}
	
		loading();
		jQuery.post("<?php echo $this->Html->url('/profile/updateProfileAjax');?>"
				, {"titleTh":titleTh
					,"nameTh":nameTh
					,"lastnameTh":lastnameTh
					,"titleEng":titleEng
					,"nameEng":nameEng
					,"lastnameEng":lastnameEng
					,"nickname":nickname
					,"generation":generation
					,"birthday":birthday
					,"nationality":nationality
					,"religious":religious
					,"socialStatus":socialStatus
					,"studyStatus":studyStatus
					,"address":address
					,"telPhone":telPhone
					,"celPhone":celPhone
					,"email":email
					,"blogAddress":blogAddress
					,"profileId":profileId}
				, function(data) {
					unloading();
					
					jAlert(data.result
							, function(){ 
								if ( data.result == "การแก้ไขข้อมูลส่วนตัวเสร็จเรียบร้อย" ) {
									jQuery(this).dialog("close"); 
									jQuery(this).remove();
								}
							}//okFunc	
							, function(){ 
							}//openFunc
							, function(){ 		
							}//closeFunc
					);
				}
				, "json");
	}
	function validateEmail(email) { 
	    var pattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/; 
	    
	    return pattern.test(email);
	}// validateEmail
</script>