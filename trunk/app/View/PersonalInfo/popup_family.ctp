<script type="text/javascript">
	function openPopupFamily(id
							,relation
							,name
							,lastname
							,education
							,occupation
							,position
							,status){
		var html = '<div id="popup-family-container" style="width:400px;">\
						<table style="width:100%;">\
							<tr>\
								<td style="width:30%; text-align:right;">* ความเกี่ยวข้อง :</td>\
								<td style="width:70%;">\
									<input id="family-id" type="hidden" value="'+ id +'">\
									<input id="family-relation" type="text" value="'+ relation +'">\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">* ชื่อ :</td>\
								<td><input id="family-name" type="text" value="'+ name +'"></td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">* นามสกุล :</td>\
								<td><input id="family-lastname" type="text" value="'+ lastname +'"></td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">วุฒิการศึกษา :</td>\
								<td><input id="family-education" type="text" value="'+ education +'"></td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">*อาชีพ :</td>\
								<td><input id="family-occupation" type="text" value="'+ occupation +'"></td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">ตำแหนง :</td>\
								<td><input id="family-position" type="text" value="'+ position +'"></td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">ถึงแก่กรรม :</td>\
								<td>\
									<input id="family-status" type="checkbox">\
								</td>\
							</tr>\
						</table>\
					</div>';

		var buttons = [{text: "บันทึก"
						, click: function(){
									if(id){
										editFamily();
									}else{
										saveNewFamaily();
									}
								}
						}];
		openPopupHtml('[เพิ่ม][แก้ไข]ข้อมูลส่วนตัว', html, buttons, 
				function(){ //openFunc
					if( status==='0' ){
						jQuery('#family-status').prop('checked', true);
					}
				}, 
				function(){ //closeFunc
				}
		);
	}
	/* -------------------------------------------------------------------------------------------------- */
	function saveNewFamaily(){
		if( validateFamily() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/saveNewFamily');?>'
					,{'data':{'profile_id':'<?php echo $this->request->query['id']; ?>'
								,'relation':jQuery('#family-relation').val()
								,'name':jQuery('#family-name').val()
								,'lastname':jQuery('#family-lastname').val()
								,'education':jQuery('#family-education').val()
								,'occupation':jQuery('#family-occupation').val()
								,'position':jQuery('#family-position').val()
								,'status':jQuery('#family-status').prop('checked')
							}}
					,function(data){
						unloading();
						jAlert(data.msg
								, function(){ 
									if( data.flg===1 ){
										closePopup('#popup-family-container');
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
	function editFamily(){
		if( validateFamily() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/editFamily');?>'
					,{'data':{'profile_id':'<?php echo $this->request->query['id']; ?>'
								,'id':jQuery('#family-id').val()
								,'relation':jQuery('#family-relation').val()
								,'name':jQuery('#family-name').val()
								,'lastname':jQuery('#family-lastname').val()
								,'education':jQuery('#family-education').val()
								,'occupation':jQuery('#family-occupation').val()
								,'position':jQuery('#family-position').val()
								,'status':jQuery('#family-status').prop('checked')
							}}
					,function(data){
						unloading();
						jAlert(data.msg
								, function(){ 
									if( data.flg===1 ){
										closePopup('#popup-family-container');
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
	function validateFamily(){
		if( jQuery('#family-relation').val() && jQuery('#family-name').val() && jQuery('#family-lastname').val() 
				&& jQuery('#family-occupation').val() ){
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
	function deleteFamily(family_id){
		jConfirm('กรุณายืนยัน เพื่อลบรายการ  [ชื่อ] [นามสกุล]', 
				function(){ //okFunc
					loading();
					jQuery.post('<?php echo $this->Html->url('/PersonalInfo/deleteFamily');?>'
							,{'data':{'id':family_id}}
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
