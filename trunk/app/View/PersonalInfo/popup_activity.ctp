<script type="text/javascript">
	function openPopupActivity(activityId
								,position){
		var html = '<div id="popup_activity_container" style="width:400px;">\
			<table style="width:100%;">\
				<tr>\
					<td style="width:30%; text-align:right;">*รับหน้าที่เป็น :</td>\
					<td style="width:70%;">\
						<input id="activity_id" type="hidden" value="' + activityId +'">\
						<input id="activity_position" type="text" value="' + position + '">\
					</td>\
				</tr>\
			</table>\
		</div>';

		var buttons = [{text: "บันทึก"
		, click: function(){
					editActivity();
				}
		}];
		openPopupHtml('[แก้ไข]กิจกรรมที่เข้าร่วม', html, buttons, 
				function(){ //openFunc
				}, 
				function(){ //closeFunc
				}
		);
	}
	/* ------------------------------------------------------------------------------------------------ */
	function editActivity(){
		if( validateActivity() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/editActivity');?>'
					,{'data':{'id':jQuery('#activity_id').val()
								,'position':jQuery('#activity_position').val()}}
					,function(data){
						unloading();

						jAlert(data.msg
								, function(){ 
									if( data.flag===1 ){
										closePopup('#popup_activity_container');
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
	/* ------------------------------------------------------------------------------------------------ */
	function validateActivity(){
		if( jQuery('#activity_position').val() ){
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
	/* ------------------------------------------------------------------------------------------------ */
	function deleteActivity(id){
		jConfirm('กรุณายืนยัน เพื่อลบรายการ ', 
				function(){ //okFunc
					loading();
					jQuery.post('<?php echo $this->Html->url('/PersonalInfo/deletedActivity');?>'
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