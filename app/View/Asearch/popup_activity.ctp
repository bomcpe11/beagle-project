<script>
	function open_popup_activity(id){
		var html = '<div id="popup-activity-container" style="width:400px;">\
						<table style="width:100%;">\
							<tr>\
								<td style="width:30%; text-align:right;">*รับหน้าที่เป็น :</td>\
								<td style="width:70%;">\
									<input id="activity-id" type="hidden" value=' + id +'>\
									<input id="activity-position" type="text" value="">\
								</td>\
							</tr>\
						</table>\
					</div>';

		var buttons = [{text:'บันทึก'
					, click: function(){
								save_activity();
							}
					}];
		openPopupHtml('เข้าร่วมกิจกรรม', html, buttons, 
			function(){ //openFunc
			}, 
			function(){ //closeFunc
			}
		);
	}
	function save_activity(){
		if( validate_activity() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/Asearch/saveActivity');?>'
					,{'data':{'activity_id':jQuery('#activity-id').val()
								,'position':jQuery('#activity-position').val()}}
					,function(data){
						unloading();
						jAlert(data.msg
								, function(){ 
									if( data.flg===1 ){
										closePopup('#popup-activity-container');
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
	function validate_activity(){
		if( jQuery('#activity-position').val() ){
			return true;
		}else{
			jAlert('กรุณาระบุ หน้าที่'
					, function(){
					}//okFunc	
					, function(){ 
					}//openFunc
					, function(){ 		
					}//closeFunc
			);
		}
	}
</script>