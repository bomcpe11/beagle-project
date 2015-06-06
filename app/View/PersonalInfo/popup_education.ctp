<script type="text/javascript">
	function openPopupEducation(id
								,edutype
								,name
								,faculty
								,major
								,isGraduate
								,startyear
								,endyear
								,gpa){
		var html = '<div id="popup-education-container" style="width:500px;">\
						<table style="width:100%;">\
							<tr>\
								<td style="width:30%; text-align:right;">* ระดับ :</td>\
								<td style="width:70%;">\
									<input id="education-id" type="hidden" value="'+ id +'">\
									<input id="education-edutype" type="text" value="'+ edutype +'">\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">* ชื่อสถาบัน :</td>\
								<td><input id="education-name" style="width:300px" type="text" value="'+ name +'"></td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">คณะ :</td>\
								<td><input id="education-faculty" type="text" value="'+ faculty +'"></td>\
							</tr>\
							<tr>\
								<td style="text-align: right;vertical-align: top;padding-top: 3px;">สาขาวิชา :</td>\
								<td>\
									<input id="education-major" type="text" value="'+ major +'">\
									<br/>\
									<input id="education-is-graduate" type="checkbox" '+( (isGraduate==='1')?'checked value="1"':'value="0"' )+'><label>สำเร็จการศึกษาแล้ว</label>\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align: right;vertical-align: top;padding-top: 3px;">ปีการศึกษา :</td>\
								<td><input id="education-startyear" style="width:40px" type="text"  maxlength="4" value="' + startyear +'">\
									<span>ถึง</span>\
									<input id="education-endyear" style="width:40px" type="text"  maxlength="4" value="' + endyear +'">\
									<br/>\
									กรุณากรอกเป็นปี พ.ศ.\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">เกรดเฉลี่ย :</td>\
								<td><input id="education-gpa" type="text" value="'+ gpa +'"></td>\
							</tr>\
						</table>\
					</div>';
			
			var buttons = [{text: "บันทึก"
						, click: function(){
									if(id){
										editEducation();
									}else{
										saveNewEducation();
									}
								}
						}];
			openPopupHtml('[เพิ่ม][แก้ไข] ประวัติการศึกษา', html, buttons, 
				function(){ //openFunc
				}, 
				function(){ //closeFunc
				}
			);
	}
	/* -------------------------------------------------------------------------------------------------- */
	function saveNewEducation(){
		if( validateEducation() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/saveNewEducation');?>'
					,{'data':{'profile_id':'<?php echo $this->request->query['id']; ?>'
								,'edutype':jQuery('#education-edutype').val()
								,'name':jQuery('#education-name').val()
								,'faculty':jQuery('#education-faculty').val()
								,'major':jQuery('#education-major').val()
								,'isGraduate':jQuery('#education-is-graduate').prop('checked')
								,'startyear':jQuery('#education-startyear').val()
								,'endyear':jQuery('#education-endyear').val()
								,'gpa':jQuery('#education-gpa').val()}}
					,function(data){
						unloading();

						jAlert(data.msg
								, function(){ 
									if( data.flg==='1' ){
										closePopup('#popup-education-container');
										window.location.reload();
									}
								}//okFunc	
								, function(){ 
								}//openFunc
								, function(){ 		
								}//closeFunc
						);
					}
					,'json');
		}
	}
	/* -------------------------------------------------------------------------------------------------- */
	function editEducation(){
		if( validateEducation() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/editEducation');?>'
					,{'data':{'profile_id':'<?php echo $this->request->query['id']; ?>'
								,'id':jQuery('#education-id').val()
								,'edutype':jQuery('#education-edutype').val()
								,'name':jQuery('#education-name').val()
								,'faculty':jQuery('#education-faculty').val()
								,'major':jQuery('#education-major').val()
								,'isGraduate':jQuery('#education-is-graduate').prop('checked')
								,'startyear':jQuery('#education-startyear').val()
								,'endyear':jQuery('#education-endyear').val()
								,'gpa':jQuery('#education-gpa').val()}}
					,function(data){
						unloading();

						jAlert(data.msg
								, function(){ 
									if( data.flg==='1' ){
										closePopup('#popup-education-container');
										window.location.reload();
									}
								}//okFunc	
								, function(){ 
								}//openFunc
								, function(){ 		
								}//closeFunc
						);
					}
					,'json');
		}
	}
	/* -------------------------------------------------------------------------------------------------- */
	function validateEducation(){
		if( jQuery('#education-edutype').val()
				&& jQuery('#education-name').val() ){
			return true;
		}else{
			jAlert('คุณกรอกข้อมูล ไม่ครบ', 
					function(){ //okFunc
					}, 
					function(){ //openFunc
					}, 
					function(){ //closeFunc
					}
			);
			
			return false;
		}
	}
	/* -------------------------------------------------------------------------------------------------- */
	function deleteEducation(id){
		jConfirm('กรุณายืนยัน เพื่อลบรายการ  [ระดับ] [คณะ]', 
				function(){ //okFunc
					loading();
					jQuery.post('<?php echo $this->Html->url('/PersonalInfo/deleteEducation');?>'
							,{'data':{'id':id}}
							,function(data){
								unloading();
								jAlert(data.msg
										, function(){ 
											if( data.flg===1 ){
												window.location.reload();
											}
										}//okFunc	
										, function(){ 
										}//openFunc
										, function(){ 		
										}//closeFunc
								);
							}
							,'json');
				}, 
				function(){ //cancelFunc
				}, 
				function(){ //openFunc
				}, 
				function(){ //closeFunc
				}
			);
	}
</script>