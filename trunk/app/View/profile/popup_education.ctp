<script>
	function openPopupEducation(id
								,edutype
								,name
								,faculty
								,major
								,startyear
								,endyear
								,gpa){
		var html = '<div id="popup-education-container" style="width:400px;">\
						<table style="width:100%;">\
							<tr>\
								<td style="width:30%; text-align:right;">* ระดับ :</td>\
								<td style="width:70%;">\
									<input id="family-id" type="hidden" value=' + id +'>\
									<input id="family-relation" type="text" value=' + edutype +'>\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">* ชื่อสถาบัน :</td>\
								<td><input id="family-name" type="text" value=' + name +'></td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">* คณะ :</td>\
								<td><input id="family-lastname" type="text" value=' + faculty +'></td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">สาขาวิชา :</td>\
								<td><input id="family-education" type="text" value=' + major +'></td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">*ปีการศึกษา :</td>\
								<td><input id="family-occupation" type="text" value=' + startyear +'></td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">เกรดเฉลี้ย :</td>\
								<td><input id="family-position" type="text" value=' + gpa +'></td>\
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
			openPopupHtml('[เพิ่ม][แก้ไข]ข้อมูลส่วนตัว', html, buttons, 
				function(){ //openFunc
				}, 
				function(){ //closeFunc
				}
			);
	}
	function saveNewEducation(){
		alert('บันทึก นะแจ๊ะ');
	}
	function editEducation(id){
		alert('แก้ไข นะแจ๊ะ');
	}
	function deleteEducation(id){
		jConfirm('กรุณายืนยัน เพื่อลบรายการ  [ ระดับ ] [ คณะ ]', 
				function(){ //okFunc
					alert('ลบ นะแจ๊ะ => ' + id);
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