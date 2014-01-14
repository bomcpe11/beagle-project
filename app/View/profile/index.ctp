<?php echo $this->Html->css('profile.css');?>
<?php include 'popup_family.ctp'?>
<?php include 'popup_education.ctp'?>
<!-- ################################################################################### -->
<script type="text/javascript">
	jQuery(document).ready(function() {
		}
	);
	/* --------------------------------------------------------------------------------------------------- */
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
	/* --------------------------------------------------------------------------------------------------- */
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
	/* --------------------------------------------------------------------------------------------------- */
	function validateEmail(email) { 
        var pattern = /^[a-zA-Z0-9._%-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}/; 
        
        return pattern.test(email);
	}// validateEmail
</script>
<!-- ################################################################################### -->
<div class="container">
	<div class="section_profile">
		<div class="section_picture">
			<div class="picture">
				<img></img>
				<p>Profile Picture Description</p>
			</div>
		</div>
		<div class="section_content">
			<table id="table-profile" class="table_form">
				<tr>
					<td colspan="2">
						<strong>ชื่อ-นามสกุล : </strong>
						<span><?php echo $fullNameTh;?></span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>Name : </strong>
						<span><?php echo $objuser['titleen']." ".$objuser['nameeng']." ".$objuser['lastnameeng'];?></span>
					</td>
				</tr>
				<tr>
					<td>
						<strong>ชื่อเล่น : </strong>
						<span><?php echo $objuser['nickname'];?></span>
					</td>
					<td>
						<strong>รุ่น : </strong>
						<span><?php echo $objuser['generation'];?></span>
					</td>
				</tr>
				<tr>
					<td>
						<strong>วันเกิด : </strong>
						<span><?php echo $birthday;?></span>
					</td>
					<td>
						<strong>อายุ : </strong>
						<span><?php echo $age;?></span>
					</td>
				</tr>
				<tr>
					<td>
						<strong>สัญชาติ : </strong>
						<span><?php echo $objuser['nationality'];?></span>
					</td>
					<td>
						<strong>ศาสนา : </strong>
						<span><?php echo $objuser['religious'];?></span>
					</td>
				</tr>
				<tr>
					<td>
						<strong>สถานะภาพ : </strong>
						<span><?php echo $objuser['socialstatus'];?></span>
					</td>
					<td>
						<strong>สถานะภาพทางการศึกษา : </strong>
						<span><?php echo $objuser['studystatus'];?></span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>ที่อยู่ : </strong>
						<span><?php echo $objuser['address'];?></span>
					</td>
				</tr>
				<tr>
					<td>
						<strong>โทรศัพท์ : </strong>
						<span><?php echo $objuser['telphone'];?></span>
					</td>
					<td>
						<strong>โทรศัพท์มือถือ : </strong>
						<span><?php echo $objuser['celphone'];?></span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>อีเมล์ : </strong>
						<span><?php echo $objuser['email'];?></span>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<strong>Sosial Media : </strong>
						<span><?php echo $objuser['blogaddress'];?></span>
					</td>
				</tr>
			</table>
			
			<button onclick="javascript:edit_profile();">แก้ไขข้อมูลส่วนตัว</button>
		</div>
	</div>
</div>
<div class="container">
	<h1>ประวัติครอบครัว</h1>
	<div class="section_content">
		<table class="table_data">
			<thead>
				<tr>
					<th style="text-align:center;">ความเกี่ยวข้อง</th>
					<th style="text-align:center;">ชื่อ</th>
					<th style="text-align:center;">นามสกุล</th>
					<th style="text-align:center;">วุฒิการศึกษา</th>
					<th style="text-align:center;">อาชีพ</th>
					<th style="text-align:center;">ตำแหนง</th>
					<th style="text-align:center;">Edit</th>
					<th style="text-align:center;">Delete</th>
				</tr>
			</thead>
			<tbody>
			<?php $countListFamily = count($listFamily);
				if( $countListFamily==0 ){?>
					<tr>
						<td colspan="8" style="text-align:center;">ไม่พบข้อมูล</td>
					</tr>
			<?php } else {
					for($i=0; $i<$countListFamily; $i++){?>
					<tr>
						<td>
							<input id="family_id" type="hidden" value="<?php echo $listFamily[$i]['families']['id'];?>"/>
							<?php echo $listFamily[$i]['families']['relation'];?>
						</td>
						<td><?php echo $listFamily[$i]['families']['name'];?></td>
						<td><?php echo $listFamily[$i]['families']['lastname'];?></td>
						<td><?php echo $listFamily[$i]['families']['education'];?></td>
						<td><?php echo $listFamily[$i]['families']['occupation'];?></td>
						<td><?php echo $listFamily[$i]['families']['position'];?></td>
						<td style="text-align:center">
							<img src="<?php echo $this->Html->url('/img/icon_edit.png');?>" width="16" height="16"
								onclick="openPopupFamily('<?php echo $listFamily[$i]['families']['id'];?>'
													,'<?php echo $listFamily[$i]['families']['relation'];?>'
													,'<?php echo $listFamily[$i]['families']['name'];?>'
													,'<?php echo $listFamily[$i]['families']['lastname'];?>'
													,'<?php echo $listFamily[$i]['families']['education'];?>'
													,'<?php echo $listFamily[$i]['families']['occupation'];?>'
													,'<?php echo $listFamily[$i]['families']['position'];?>')"/>
						</td>
						<td style="text-align:center">
							<img src="<?php echo $this->Html->url('/img/icon_del.png');?>" width="16" height="16"
								onclick="deleteFamily('<?php echo $listFamily[$i]['families']['id'];?>')"/>
						</td>
					</tr>
			<?php }
				} ?>
			</tbody>
		</table>
		<button type="button" onclick="openPopupFamily('','','','','','','')">เพิ่มข้อมูล ประวัติครอบครัว</button>
	</div>
</div>
<div class="container">
	<h1>ประวัติการศึกษา</h1>
	<div class="section_content">
		<?php 
			$countListEducation = count($listEducation);
			if( $countListEducation>0 ){
				for($i=0; $i<$countListEducation; $i++){?>
					<table class="table_data_item">
						<tr>
							<td style="width:30%">ระดับ : <?php echo $listEducation[$i]['educations']['edutype'];?></td>
							<td style="width:60%">ชื่อสถาบัน : <?php echo $listEducation[$i]['educations']['name'];?></td>
							<td style="width:10%" class="td_link">
								<img src="<?php echo $this->Html->url('/img/icon_edit.png');?>" width="16" height="16"
									onclick="openPopupEducation('<?php echo $listEducation[$i]['educations']['id'];?>'
																,'<?php echo $listEducation[$i]['educations']['edutype'];?>'
																,'<?php echo $listEducation[$i]['educations']['name'];?>'
																,'<?php echo $listEducation[$i]['educations']['faculty'];?>'
																,'<?php echo $listEducation[$i]['educations']['major'];?>'
																,'<?php echo $listEducation[$i]['educations']['isGraduate'];?>'
																,'<?php echo ( intval($listEducation[$i]['educations']['startyear']) + 543 );?>'
																,'<?php echo ( intval($listEducation[$i]['educations']['endyear']) + 543 );?>'
																,'<?php echo $listEducation[$i]['educations']['gpa'];?>')"/>
								<img src="<?php echo $this->Html->url('/img/icon_del.png');?>" width="16" height="16"
									onclick="deleteEducation('<?php echo $listEducation[$i]['educations']['id'];?>')"/>
							</td>
						</tr>
						<tr>
							<td>คณะ : <?php echo $listEducation[$i]['educations']['faculty'];?></td>
							<td colspan="2">สาขาวิชา : <?php echo ( empty($listEducation[$i]['educations']['major'])?'-':$listEducation[$i]['educations']['major'] );?></td>
						</tr>
						<tr>
							<td>ปีการศึกษา : <?php 
											if($listEducation[$i]['educations']['isGraduate'] == 1){
												echo ( intval($listEducation[$i]['educations']['startyear']) + 543 ).' - '.( intval($listEducation[$i]['educations']['endyear']) + 543 );
											}else{
												echo ( intval($listEducation[$i]['educations']['startyear']) + 543 ).' - '.( intval(date('Y')) + 543 );
											}?></td>
							<td colspan="2">เกรดเฉลี่ย : <?php echo ( empty($listEducation[$i]['educations']['gpa'])?'-':$listEducation[$i]['educations']['gpa'] );?></td>
						</tr>
					</table>
		<?php }
			}else{?>
			<table class="table_data_item">
				<tr style="text-align:center">
					<td>ไม่พบข้อมูล</td>
				</tr>
			</table>
		<?php }?>
		
		<button onclick="openPopupEducation('','','','','','0','','','')">เพิ่มข้อมูล ประวัติการศึกษา</button>
	</div>
</div>
<div class="container">
	<h1>ผลงานวิจัย</h1>
	<div class="section_content">
		<table class="table_data_item">
			<tr>
				<td>ชื่อเรื่อง : dummy</td>
				<td class="td_link">แก้ไข ลบ</td>
			</tr>
			<tr>
				<td colspan="2">ประเภทของงานวิจัย : dummy</td>
			</tr>
			<tr>
				<td>อาจารย์ที่ปรึกษา : dummy</td>
				<td>หน่วยงาน : dummy</td>
			</tr>
			<tr>
				<td>ปีที่เสร็จ : dummy</td>
				<td>การเผยแพร่ : dummy</td>
			</tr>
		</table>
		<button>เพิ่มข้อมูล ผลงานวิจัย</button>
	</div>
</div>
<div class="container">
	<h1>รางวัลที่ได้รับ</h1>
	<div class="section_content">
		<table class="table_data_item">
			<tr>
				<td>ชื่อผลงาน : dummy</td>
				<td class="td_link">แก้ไข ลบ</td>
			</tr>
			<tr>
				<td>ชื่อรางวัล : dummy</td>
				<td>หน่วยงาน : dummy</td>
			</tr>
		</table>
		<button>เพิ่มข้อมูล รางวัลที่ได้รับ</button>
	</div>
</div>
<div class="container">
	<h1>ประวัติการทำงาน</h1>
	<div class="section_content">
		<table class="table_data_item">
			<tr>
				<td>ตำแหน่ง : dummy</td>
				<td>ชื่อสถานที่ทำงาน : dummy</td>
				<td class="td_link">แก้ไข ลบ</td>
			</tr>
			<tr>
				<td>โทรศัพท์ : dummy</td>
				<td>วันที่ทำงาน : dummy</td>
				<td>ถึงวันที่ : dummy</td>
			</tr>
		</table>
		<button>เพิ่มข้อมูล ประวัติการทำงาน</button>
	</div>
</div>
<div class="container">
	<h1>ความคิดเห็น</h1>
	<div class="section_content">
		<table class="table_data_item">
			<tr>
				<td>หัวข้อความคิดเห็นที่ : dummy</td>
				<td class="td_link">แก้ไข ลบ</td>
			</tr>
			<tr>
				<td colspan="2">dummy</td>
			</tr>
			<tr>
				<td colspan="2">โดย dummy เมื่อวันที่ dummy</td>
			</tr>
		</table>
	</div>
	
	<h2>เพิ่มความคิดเห็น</h2>
	<div class="section_content">
		<table class="table_data_item">
			<tr>
				<td style="width: 20%;text-align: right;">หัวข้อ :</td>
				<td style="width: 80%;">
					<input type="text" style="width: 98%;"></input>
				</td>
			</tr>
			<tr>
				<td style="width: 20%;text-align: right;vertical-align: top;">ความคิดเห็น :</td>
				<td style="width: 80%;">
					<textarea type="text" style="width: 98%;height: 100px;"></textarea>
				</td>
			</tr>
		</table>
		<button>เพิ่มข้อมูล ความคิดเห็น</button>
	</div>
</div>
</div>
</div>

<!-- Popup -->
<div id="popup-profile">
	
</div>