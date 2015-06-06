<?php 
	//echo "<pre>"; print_r($objuser); echo "</pre>";
	
// 	$isAdmin = ($objuser['role_admin']==1?true:false);
?>

<h2 style="padding:5px;">Customize</h2>

<div id="frm-menu" class="framecontainer" style="text-align:center;display:block;">
	<?php if($isAdmin){ ?>
		<a class="framebtn" frmid="frm-addnewmember">Add new member</a> <!-- Admin --><br />
		<a class="framebtn" urllink="<?php echo $this->Html->url('/Activitylist'); ?>">Activity Manager</a><br />
		<a class="framebtn" frmid="frm-generationmanager" onclick="display_generationlist();">Generation Manager</a><br />
		<a class="framebtn" frmid="frm-recruitmanager" onclick="display_recruitroundlist();">Member Recruitment Manager</a><br />
	<?php } ?>
	<a class="framebtn" frmid="frm-changepassword">Change password</a><br />
	<a class="framebtn" urllink="<?php echo $this->Html->url('/Changepic'); ?>">Change picture profile</a><br />
	<a class="framebtn" frmid="" onclick="window.location.replace('<?php echo $this->Html->url('/Mainmenu'); ?>');">Back to Main Menu</a><br />
</div>

<?php if($isAdmin){ ?>
<div id="frm-addnewmember" class="framecontainer">
	<div class="input">
		<fieldset>
		<legend>เพิ่มรายชื่อสมาชิก</legend>
		<table>
			<tr>
				<td>ประเภทของบัตร : </td>
				<td>
					<select id="select_cardtype">
						<option value="">---- กรุณาเลือก ----</option>
					<?php for ( $i = 0; $i < count($personalIdType); $i++ ) { ?>
						<option <?php //if($i==0) echo 'selected="selected"'; ?> value="<?php echo $personalIdType[$i]['gvars']['varcode'];?>"><?php echo $personalIdType[$i]['gvars']['vardesc1'];?></option>
					<?php } ?>
					</select>
				</td>
			</tr>
			<tr>
				<td>เลขบัตรประจำตัว : </td>
				<td><input type="text" id="txt_cardid" /></td>
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
				<td><input type="text" id="txt_email" /></td>
			</tr>
			<tr>
				<td colspan="2" align="center"><input type="button" value="เพิ่มรายชื่อ" onclick="submit_addnewmember(this);" /> <input type="button" class="btn-reset" value="ล้าง Input" /></td>
			</tr>
		</table>
<!-- 		<input type="text" name="id" /> -->
		</fieldset>
	</div>
	<a class="framebtn" frmid="frm-menu">Back</a>
</div>
<div id="frm-generationmanager" class="framecontainer">
	<div class="input">
		<fieldset>
		<legend>เพิ่มชื่อ รุ่นที่/ตำแหน่ง</legend>
			<table>
				<tr>
					<td>รุ่นที่/ตำแหน่ง : </td>
					<td><input type="text" id="txt_generation" /> *</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="button" value="เพิ่ม รุ่นที่/ตำแหน่ง" onclick="submit_addgeneration(this);" /> <input type="button" class="btn-reset" value="ล้าง Input" /></td>
				</tr>
			</table>
		</fieldset>
	</div>
	
	<div id="generationlist"></div>
	<a class="framebtn" frmid="frm-menu">Back</a>
</div>
<div id="frm-recruitmanager" class="framecontainer">
	<div class="input">
		<fieldset>
		<legend>Recruitment Manager</legend>
			<table>
				<tr>
					<td>ชื่อรอบการรับสมัคร : </td>
					<td><input type="text" id="txt_recruitround" /> *</td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="button" value="เพิ่ม รอบการรับสมัคร" onclick="submit_addrecruitround(this);" /> <input type="button" class="btn-reset" value="ล้าง Input" /></td>
				</tr>
			</table>
		</fieldset>
	</div>
	
	<div id="recruitroundlist"></div>
	<a class="framebtn" frmid="frm-menu">Back</a>
</div>
<script type="text/javascript">
function submit_addnewmember(t){
	
	var input_container = jQuery(t).closest("div.input");

	var select_cardtype = input_container.find('#select_cardtype').val();
	var txt_cardid = jQuery.trim(input_container.find('#txt_cardid').val());
	var txt_name = jQuery.trim(input_container.find('#txt_name').val());
	var txt_surname = jQuery.trim(input_container.find('#txt_surname').val());
	var txt_birthdate = input_container.find('#txt_birthdate').val();
	var txt_email = jQuery.trim(input_container.find('#txt_email').val());

	// validate field *
	if ( !txt_name 
		|| !txt_surname
		|| !txt_birthdate  ) {
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
	
	if(txt_cardid!="" && select_cardtype==""){
		jAlert("กรุณาระบุประเภทของบัตร"
				, function(){ 
				}//okFunc	
				, function(){ 
				}//openFunc
				, function(){ 		
				}//closeFunc
		);// jAlert
		
		return false;
	}
	
	var data = {select_cardtype: select_cardtype,
				txt_cardid: txt_cardid,
				txt_name: txt_name,
				txt_surname: txt_surname,
				txt_birthdate: txt_birthdate,
				txt_email: txt_email
			};
//		console.log(data);
	loading();
	jQuery.post("<?php echo $this->Html->url('/Customize/addnewmember_submit');?>", 
			data,
			function(data) {
				if ( data.result.status ) {
					jAlert(data.result.message
							, function(){ 
								input_container.find('input.btn-reset').click();
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
				jAlert('Ajax Error : add new member');
				unloading();
			}// function()
	);// jQuery.post
}
function display_generationlist(){
	loading();
	jQuery.post("<?php echo $this->Html->url('/Customize/getGenerationList');?>", 
			{},
			function(data) {
				unloading();

				var html = '<table class="tabledata" style="margin:5px 20px;">'
							+'<tr>'
							+'	<th>รุ่นที่/ตำแหน่ง</th>'
							+'	<th></th>'
							+'</tr>';

				if(data.result.length>0){
					for(var i=0; i<data.result.length; i++){
						html += '<tr>'
								+'	<td>'+data.result[i].generations.name+'</td>'
								+'	<td><img src="<?php echo $this->Html->url('/img/icon_del.png'); ?>" style="cursor:pointer;" onclick="remove_generation(\''+data.result[i].generations.id+'\', \''+data.result[i].generations.name+'\')" /></td>'
								+'</tr>';
					}
				}else{
					html += '<tr>'
							+'	<td colspan="2">ไม่มีข้อมูล</td>'
							+'</tr>';
				}

				html += '</table>';

				jQuery('#generationlist').html(html);
				
			}// function(data)
			, "json").error(function() {
				jAlert('Ajax Error : get generation list');
				unloading();
			}// function()
	);// jQuery.post
}
function submit_addgeneration(t){
	
	var input_container = jQuery(t).closest("div.input");

	var txt_generation = jQuery.trim(input_container.find('#txt_generation').val());

	// validate field *
	if ( !txt_generation ) {
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
	
	var data = {txt_generation: txt_generation};
//		console.log(data);
	loading();
	jQuery.post("<?php echo $this->Html->url('/Customize/addgeneration_submit');?>", 
			data,
			function(data) {
				if ( data.result.status ) {
					display_generationlist();
					jAlert(data.result.message
							, function(){ 
								input_container.find('input.btn-reset').click();
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
				jAlert('Ajax Error : add generation');
				unloading();
			}// function()
	);// jQuery.post
}
function remove_generation(id, name){
	jConfirm('ต้องการลบ "'+name+'" ?', 
		function(){ //okFunc

		var data = {generationid: id};

		jQuery.post("<?php echo $this->Html->url('/Customize/remove_generation');?>", data,
			function(data) {
					if ( data.result.status ) {
						display_generationlist();
						jAlert(data.result.message
								, function(){ 
								}//okFunc	
								, function(){ 
								}//openFunc
								, function(){ 		
								}//closeFunc
						);// jAlert
					}//if else
					else{
						jAlert(data.result.message
								, function(){ 
									
								}//okFunc	
								, function(){ 
								}//openFunc
								, function(){ 		
								}//closeFunc
						);// jAlert
					}

					unloading();
				}// function(data)
				, "json").error(function() {
				}// function()
			);// jQuery.post
		}, 
		function(){ //cancelFunc
		}, 
		function(){ //openFunc
		}, 
		function(){ //closeFunc
		}
	);
}

/*--- Start Recruitment Manager ----*/

function display_recruitroundlist(){
	loading();
	jQuery.post("<?php echo $this->Html->url('/Customize/getRecruitRoundList');?>", 
			{},
			function(data) {
				unloading();

				var html = '<table class="tabledata" style="margin:5px 20px;">'
							+'<tr>'
							+'	<th>รอบการรับสมัคร</th>'
							+'	<th></th>'
							+'</tr>';

				if(data.result.length>0){
					for(var i=0; i<data.result.length; i++){
						html += '<tr>'
								+'	<td><a style="color:blue;" href="<?php echo $this->Html->url('/Recruitment?recruitroundid='); ?>'+data.result[i].recruit_rounds.id+'&roundname='+data.result[i].recruit_rounds.name+'">'+data.result[i].recruit_rounds.name+'</a></td>'
								+'	<td><img src="<?php echo $this->Html->url('/img/icon_del.png'); ?>" style="cursor:pointer;" onclick="remove_recruitround(\''+data.result[i].recruit_rounds.id+'\', \''+data.result[i].recruit_rounds.name+'\')" /></td>'
								+'</tr>';
					}
				}else{
					html += '<tr>'
							+'	<td colspan="2">ไม่มีข้อมูล</td>'
							+'</tr>';
				}

				html += '</table>';

				jQuery('#recruitroundlist').html(html);
				
			}// function(data)
			, "json").error(function() {
				jAlert('Ajax Error : get recruitround list');
				unloading();
			}// function()
	);// jQuery.post
}
function submit_addrecruitround(t){
	
	var input_container = jQuery(t).closest("div.input");

	var txt_recruitround = jQuery.trim(input_container.find('#txt_recruitround').val());

	// validate field *
	if ( !txt_recruitround ) {
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
	
	var data = {txt_recruitround: txt_recruitround};
//		console.log(data);
	loading();
	jQuery.post("<?php echo $this->Html->url('/Customize/addrecruitround_submit');?>", 
			data,
			function(data) {
				if ( data.result.status ) {
					display_recruitroundlist();
					jAlert(data.result.message
							, function(){ 
								input_container.find('input.btn-reset').click();
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
				jAlert('Ajax Error : add recruitround');
				unloading();
			}// function()
	);// jQuery.post
}
function remove_recruitround(id, name){
	jConfirm('ต้องการลบ "'+name+'" ?', 
		function(){ //okFunc

		var data = {recruitroundid: id};

		jQuery.post("<?php echo $this->Html->url('/Customize/remove_recruitround');?>", data,
			function(data) {
					if ( data.result.status ) {
						display_recruitroundlist();
						jAlert(data.result.message
								, function(){ 
								}//okFunc	
								, function(){ 
								}//openFunc
								, function(){ 		
								}//closeFunc
						);// jAlert
					}//if else
					else{
						jAlert(data.result.message
								, function(){ 
									
								}//okFunc	
								, function(){ 
								}//openFunc
								, function(){ 		
								}//closeFunc
						);// jAlert
					}

					unloading();
				}// function(data)
				, "json").error(function() {
				}// function()
			);// jQuery.post
		}, 
		function(){ //cancelFunc
		}, 
		function(){ //openFunc
		}, 
		function(){ //closeFunc
		}
	);
}

/*--- End Recruitment Manager ----*/

</script>
<?php } ?>
<!-- ########################################## Change Password ##################################### -->
<div id="frm-changepassword" class="framecontainer">
	<div class="input">
		<fieldset>
		<legend>Change Password</legend>
		<table>
			<tr>
				<td class="td_label">รหัสผ่านเดิม : </td>
				<td class="td_data">
					<input type="password" id="old_password" size="24"/> *</td>
			</tr>
			<tr>
				<td class="td_label">รหัสผ่านใหม่ : </td>
				<td class="td_data">
					<input type="password" id="new_password" size="24"/> *</td>
			</tr>
			<tr>
				<td class="td_label">ยืนยันรหัสผ่านใหม่ : </td>
				<td class="td_data">
					<input type="password" id="confirm_new_password" size="24"/> *</td>
			</tr>
			<tr>
				<td></td>
				<td style="text-aling: center;">
					<input type="button" id="button_submit" value="ยืนยันการแก้ไขรหัสผ่าน" onclick="updatePassword()"/>
				</td>
			</tr>
		</table>
		</fieldset>
	</div>
	<a class="framebtn" frmid="frm-menu">Back</a>
</div>
<script type="text/javascript">
	function updatePassword() {
		var oldPassword = jQuery('#frm-changepassword').find("#old_password").val();
		var newPassword = jQuery('#frm-changepassword').find("#new_password").val();
		var confirmNewPassword = jQuery('#frm-changepassword').find("#confirm_new_password").val();

		// validate data
		if ( !oldPassword || !newPassword || !confirmNewPassword ) {
			jAlert('กรุณากรอกข้อมูลช่องที่ * ให้ครบ'
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
		jQuery.post('<?php echo $this->Html->url('/Customize/updatePassword');?>',
				{'data':{'oldPassword':oldPassword,
						'newPassword':newPassword,
						'confirmNewPassword':confirmNewPassword}},
				function(data){
						jAlert(data.msg
								,function(){
									if( data.flg==='1' ){
										// logout
										jQuery.post('<?php echo $this->Html->url('/logout/logoutAjax');?>',
												{},
												function(data){
													if( data.status ){	// logout success
														// redirect
														window.location.assign('<?php echo $this->Html->url('Login/index'); ?>');
													}else{
														jAlert('ระบบขัดข้อง กรุณาติดต่อผู้ดูแลระบบ'
																, function(){ 
																}//okFunc	
																, function(){ 
																	unloading();
																}//openFunc
																, function(){ 		
																}//closeFunc
														);
													}
												},'json').error(function() {}
										);
									}
								}//okFunc	
								,function(){ 
									unloading();
								}//openFunc
								, function(){ 		
								}//closeFunc
						);
				},'json').error(function(){}
		);
	}
</script>
<!-- #################################################################################################### -->
<script type="text/javascript">
	jQuery('a.framebtn[frmid!=""]').click(function(){
		//alert('AAA');
// 		jQuery('div.framecontainer').hide();

// 		jQuery('div#'+jQuery(this).attr('frmid')).show();

		var urllink = jQuery.trim(jQuery(this).attr('urllink'));

		if(urllink!=''){
			window.location.replace(urllink);
		}else{
			frame_display(jQuery(this).attr('frmid'));
		}
	});
	jQuery('a.framebtn').button();

	setBirthDatePicker(".birthDatePicker");

	jQuery('div.input input.btn-reset').click(function(){
// 		alert('BBB');
// 		console.log(jQuery(this).closest("div.input"));
		var input_container = jQuery(this).closest("div.input");

		input_container.find('input:text').val('');
		input_container.find('select').val('');
	});

	function frame_display(frmid){
		var frm = jQuery('div#'+frmid);
		if(frm.length>0){
			jQuery('div.framecontainer').hide();
			jQuery('div#'+frmid).show();
		}
	}

	<?php 
		if(!empty($_GET['frmid'])){
			echo "frame_display('".$_GET['frmid']."')";
		}
	?>
</script>


<div>
</div>

