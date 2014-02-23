<script>
	/* ------------------------------------------------------------------------------------------------ */
	function open_popup_activity(activity_id){
		var html = '<div id="popup_activity_container" style="width:400px;">\
						<table style="width:100%;">\
							<tr>\
								<td style="width:30%; text-align:right;">*รับหน้าที่เป็น :</td>\
								<td style="width:70%;">\
									<input id="activity_id" type="hidden" value=' + activity_id +'>\
									<input id="activity_position" type="text" value="">\
								</td>\
							</tr>\
						</table>\
					</div>';

		var buttons = [{text:'บันทึก'
					, click: function(){
								save_activity(activity_id);
							}
					}];
		openPopupHtml('เข้าร่วมกิจกรรม', html, buttons, 
			function(){ //openFunc
			}, 
			function(){ //closeFunc
			}
		);
	}
	/* ------------------------------------------------------------------------------------------------ */
	function save_activity(activity_id){
		if( validate_activity() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/Asearch/saveActivity');?>'
					,{'data':{'activity_id':jQuery('#activity_id').val()
								,'position':jQuery('#activity_position').val()}}
					,function(data){
						unloading();
						jAlert(data.msg
								, function(){ 
									if( data.flg===1 ){
										jQuery('#btn_join_activity'+activity_id).addClass('ui-button-disabled ui-state-disabled');
										closePopup('#popup_activity_container');
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
	function validate_activity(){
		if( jQuery('#activity_position').val() ){
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