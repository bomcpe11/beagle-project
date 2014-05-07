<script type="text/javascript">
	function openPopupWorkplace(id
							,name
							,position
							,telephone
							,startyear
							,endyear){
		var html = '<div id="popup-workplace-container" style="width:500px;">\
			<table style="width:100%;">\
				<colgroup>\
					<col style="width: 35%;">\
					<col style="width: 65%;">\
				</colgroup>\
				<tr>\
					<td style="text-align: right;">* ชื่อที่ทำงาน :</td>\
					<td>\
						<input id="workplace-id" type="hidden" value="' + id +'">\
						<input id="workplace-name" type="text" value="' + name +'">\
					</td>\
				</tr>\
				<tr>\
					<td style="text-align: right;">* ตำแหน่ง :</td>\
					<td>\
						<input id="workplace-position" type="text" value="' + position +'">\
					</td>\
				</tr>\
				<tr>\
					<td style="text-align: right;">* โทรศัพท์ :</td>\
					<td>\
						<input id="workplace-telephone" type="text" maxlength="10" value="' + telephone +'">\
					</td>\
				</tr>\
				<tr>\
					<td style="text-align: right;">ปีที่เริ่มทำงาน :</td>\
					<td>\
						<input id="workplace-startyear" type="text" style="width:40px;" maxlength="4" value="' + startyear +'">\
						<span style="padding-left: 3px;padding-right: 3px;">ถึง</span>\
						<input id="workplace-endyear" type="text" style="width:40px;" maxlength="4" value="' + endyear +'">\
						<br>\
						<span>กรุณากรอกเป็นปี พ.ศ.</span>\
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
				setDatePicker('.datePicker');
			}, 
			function(){ //closeFunc
			}
		);
	}
	/* -------------------------------------------------------------------------------------------------- */
	function saveNewWorkplace(){
		if( validateWorkplace() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/savedNewWorkplace');?>'
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
	}
	/* -------------------------------------------------------------------------------------------------- */
	function editWorkplace(){
		if( validateWorkplace() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/editWorkplace');?>'
						,{'data':{'id':jQuery('#workplace-id').val()
								,'name':jQuery('#workplace-name').val()
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
	}
	/* -------------------------------------------------------------------------------------------------- */
	function validateWorkplace(){
		if( jQuery('#workplace-name').val() 
				&& jQuery('#workplace-position').val()
				&& jQuery('#workplace-telephone').val() ){
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
	function deletedWorkplace(id){
		jConfirm('กรุณายืนยัน เพื่อลบรายการ ', 
				function(){ //okFunc
					loading();
					jQuery.post('<?php echo $this->Html->url('/PersonalInfo/deletedWorkplace');?>'
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