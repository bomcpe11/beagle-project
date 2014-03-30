<script>
	function openPopupOtherwork(id
								,name
								,organization
								,isnotfinish
								,yearstart
								,yearfinish){
		var html = '<div id="popup_otherwork_container" style="width:500px;">\
						<table style="width:100%;">\
							<tr>\
								<td style="width:35%; text-align:right;">* ชื่อเรื่อง :</td>\
								<td style="width:65%;">\
									<input id="otherwork_id" type="hidden" value=' + id +'>\
									<input id="otherwork_name" type="text" value=' + name +'>\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">หน่วยงาน :</td>\
								<td>\
									<input id="otherwork_organization" type="text" value=' + organization +'>\
									<br/>\
									<input id="otherwork_isnotfinish" type="checkbox" '+( (isnotfinish==='1')?'checked value="1"':'value="0"' )+'><label>ยังไม่สำเร็จ</label>\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">ปีที่เริ่ม :</td>\
								<td>\
								<input id="otherwork_yearstart" style="width:40px" type="text" maxlength="4" value="'+yearstart+'" '+( (id)?'disabled':'' )+'>\
									<span style="margin: 0 3px;">ปีที่เสร็จ</span>\
									<input id="otherwork_yearfinish" style="width:40px" type="text" maxlength="4" value="'+yearfinish+'" '+( (id)?'disabled':'' )+'>\
									<br>กรุณากรอกเป็นปี พ.ศ.\
								</td>\
							</tr>\
						</table>\
					</div>';
		
		var buttons = [{text: "บันทึก"
						, click: function(){
									if(id){
										editOtherwork();
									}else{
										savedNewOtherwork();
									}
								}
						}];
		
		openPopupHtml('[เพิ่ม][แก้ไข]ผลงานอื่นๆ', html, buttons, 
						function(){ //openFunc
							
						}, 
						function(){ //closeFunc
						}
						);
	}
	/* -------------------------------------------------------------------------------------------------- */
	function savedNewOtherwork(){
		if( validateOtherwork() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/Project/savedNewOtherwork');?>'
				,{'data':{'name':jQuery('#otherwork_name').val()
						,'organization':jQuery('#otherwork_organization').val()
						,'yearstart':jQuery('#otherwork_yearstart').val()
						,'yearfinish':jQuery('#otherwork_yearfinish').val()
						,'isnotfinish':jQuery('#otherwork_isnotfinish').prop('checked')}}
				,function(data){
					unloading();
					
					jAlert(data.msg
							, function(){ 
								if( data.flag===1 ){
									closePopup('#popup_otherwork_container');
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
	function editOtherwork(){
		if( validateOtherwork() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/Project/editOtherwork');?>'
					,{'data':{'id':jQuery('#otherwork_id').val()
							,'name':jQuery('#otherwork_name').val()
							,'organization':jQuery('#otherwork_organization').val()
							,'yearstart':jQuery('#otherwork_yearstart').val()
							,'yearfinish':jQuery('#otherwork_yearfinish').val()
							,'isnotfinish':jQuery('#otherwork_isnotfinish').prop('checked')}}
					,function(data){
						unloading();
						
						jAlert(data.msg
								, function(){ 
									if( data.flag===1 ){
										closePopup('#popup_otherwork_container');
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
	function validateOtherwork(){
		if( jQuery('#otherwork_name').val() ){
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
	function deleteOtherwork(id){
		jConfirm('กรุณายืนยัน เพื่อลบรายการ ', 
				function(){ //okFunc
					loading();
					jQuery.post('<?php echo $this->Html->url('/Project/deleteOtherwork');?>'
						,{'data':{'id':id}}
						,function(data){
							unloading();
							jAlert(data.msg
									, function(){ 
										if( data.flag===1 ){
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
				});
	}
</script>