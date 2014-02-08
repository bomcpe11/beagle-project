<script>
	function openPopupWorkplace(id
							,name
							,position
							,telephone
							,startyear
							,endyear){
		var html = '<div id="popup-workplace-container" style="width:500px;">\
			<table style="width:100%;">\
				<tr>\
					<td style="width:35%; text-align:right;">* ชื่อที่ทำงาน :</td>\
					<td style="width:65%;">\
						<input id="workplace-id" type="hidden" value=' + id +'>\
						<input id="workplace-name" type="text" value=' + name +'>\
					</td>\
				</tr>\
				<tr>\
					<td style="text-align:right;">* ตำแหน่ง :</td>\
					<td>\
						<input id="workplace-position" type="text" value=' + position +'>\
					</td>\
				</tr>\
				<tr>\
					<td style="text-align:right;">* โทรศัพท์ :</td>\
					<td>\
						<input id="workplace-telephone" type="text" value=' + telephone +'>\
					</td>\
				</tr>\
				<tr>\
					<td style="text-align:right;">* วันทึ่เริ่มทำงาน :</td>\
					<td>\
						<input id="workplace-startyear" class="birthDatePicker" type="text" value=' + startyear +'>\
					</td>\
				</tr>\
				<tr>\
					<td style="text-align:right;">* ถึงวันที่ :</td>\
					<td>\
						<input id="workplace-endyear" class="birthDatePicker" type="text" value=' + endyear +'>\
					</td>\
				</tr>\
			</table>\
		</div>';
		
		var buttons = [{text: "บันทึก"
			, click: function(){
						if(id){
							editWorkplace();
						}else{
							saveNewWorkplace();
						}
					}
			}];
		openPopupHtml('[เพิ่ม][แก้ไข] ประวัติการทำงาน', html, buttons, 
			function(){ //openFunc
				setBirthDatePicker(".birthDatePicker");
			}, 
			function(){ //closeFunc
			}
		);
	}
	/* -------------------------------------------------------------------------------------------------- */
	function saveNewWorkplace(){
		loading();
		jQuery.post('<?php echo $this->Html->url('/Profile/savedNewWorkplace');?>'
					,{'data':{'name':jQuery('#workplace-name').val()
							,'position':jQuery('#workplace-position').val()
							,'telephone':jQuery('#workplace-telephone').val()
							,'startyear':jQuery('#workplace-startyear').val()
							,'endyear':jQuery('#workplace-endyear').val()}}
					,function(data){
						unloading();
						
						jAlert(data.msg
								, function(){ 
									if( data.flag===1 ){
										closePopup('#popup-workplace-container');
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
	/* -------------------------------------------------------------------------------------------------- */
	function editWorkplace(){
	}
</script>