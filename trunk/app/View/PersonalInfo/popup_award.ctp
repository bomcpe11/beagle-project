<script type="text/javascript">
	function openPopupAward(id
							,name
							,awardname
							,organization){
		var html = '<div id="popup-award-container" style="width:500px;">\
						<table style="width:100%;">\
							<tr>\
								<td style="width:35%; text-align:right;">* ชื่อผลงาน :</td>\
								<td style="width:65%;">\
									<input id="award-id" type="hidden" value=' + id +'>\
									<input id="award-name" type="text" value=' + name +'>\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">* ชื่อรางวัล :</td>\
								<td>\
									<input id="award-awardname" type="text" value=' + awardname +'>\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">หน่วยงาน :</td>\
								<td><input id="award-organization" type="text" value=' + organization +'></td>\
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
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/savedNewAward');?>'
						,{'data':{'name':jQuery('#award-name').val()
									,'awardname':jQuery('#award-awardname').val()
									,'organization':jQuery('#award-organization').val()}}
						,function(data){
							unloading();
							
							jAlert(data.msg
									, function(){ 
										if( data.flag===1 ){
											closePopup('#popup-award-container');
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
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/editAward');?>'
						,{'data':{'id':jQuery('#award-id').val()
									,'name':jQuery('#award-name').val()
									,'awardname':jQuery('#award-awardname').val()
									,'organization':jQuery('#award-organization').val()}}
						,function(data){
							unloading();
							
							jAlert(data.msg
									, function(){ 
										if( data.flag===1 ){
											closePopup('#popup-award-container');
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
					jQuery.post('<?php echo $this->Html->url('/PersonalInfo/deletedAward');?>'
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
		if( jQuery('#award-name').val() 
			&& jQuery('#award-awardname').val() 
			&& jQuery('#award-organization').val() ){
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