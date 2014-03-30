<script>
	function openPopupAward(id
							,name
							,awardname
							,organization){
		var html = '<div id="popup_award_container" style="width:500px;">\
						<table style="width:100%;">\
							<tr>\
								<td style="width:35%; text-align:right;">* ชื่อผลงาน :</td>\
								<td style="width:65%;">\
									<input id="award_id" type="hidden" value=' + id +'>\
									<input id="award_name" type="text" value=' + name +'>\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">* ชื่อรางวัล :</td>\
								<td>\
									<input id="award_awardname" type="text" value=' + awardname +'>\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">* หน่วยงาน :</td>\
								<td><input id="award_organization" type="text" value=' + organization +'></td>\
							</tr>\
						</table>\
					</div>';
		
		var buttons = [{text: "บันทึก"
						, click: function(){
									if(id){
										editAward();
									}else{
										saveNewAward();
									}
								}
						}];
		openPopupHtml('[เพิ่ม][แก้ไข] รางวัลที่ได้รับ', html, buttons, 
				function(){ //openFunc
					
				}, 
				function(){ //closeFunc
				}
			);
	}
	/* ------------------------------------------------------------------------------------------------- */
	function saveNewAward(){
		if( validateAward() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/Achieve/savedNewAward');?>'
						,{'data':{'name':jQuery('#award_name').val()
									,'awardname':jQuery('#award_awardname').val()
									,'organization':jQuery('#award_organization').val()}}
						,function(data){
							unloading();
							
							jAlert(data.msg
									, function(){ 
										if( data.flag===1 ){
											closePopup('#popup_award_container');
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
	/* ------------------------------------------------------------------------------------------------- */
	function editAward(){
		if( validateAward() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/Achieve/editAward');?>'
						,{'data':{'id':jQuery('#award_id').val()
									,'name':jQuery('#award_name').val()
									,'awardname':jQuery('#award_awardname').val()
									,'organization':jQuery('#award_organization').val()}}
						,function(data){
							unloading();
							
							jAlert(data.msg
									, function(){ 
										if( data.flag===1 ){
											closePopup('#popup_award_container');
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
	/* ------------------------------------------------------------------------------------------------- */
	function deletedAward(id){
		jConfirm('กรุณายืนยัน เพื่อลบรายการ ', 
				function(){ //okFunc
					loading();
					jQuery.post('<?php echo $this->Html->url('/Achieve/deleteAward');?>'
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
	/* ------------------------------------------------------------------------------------------------- */
	function validateAward(){
		if( jQuery('#award_name').val() 
			&& jQuery('#award_awardname').val() 
			&& jQuery('#award_organization').val() ){
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
</script>