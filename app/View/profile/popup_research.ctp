<script>
	function openPopupResearch(id
								,name
								,researchtype
								,advisor
								,organization
								,isnotfinish
								,yearfinish
								,dissemination){
		var html = '<div id="popup-research-container" style="width:500px;">\
		<table style="width:100%;">\
			<tr>\
				<td style="width:35%; text-align:right;">* ชื่อเรื่อง :</td>\
				<td style="width:65%;">\
					<input id="research-id" type="hidden" value=' + id +'>\
					<input id="research-name" type="text" value=' + name +'>\
				</td>\
			</tr>\
			<tr>\
				<td style="text-align:right;">* ประเภทของงานวิจัย :</td>\
				<td><select id="research-researchtype"><optio>---- กรุณาเลือก ----</option></select></td>\
			</tr>\
			<tr>\
				<td style="text-align:right;">อาจารย์ที่ปรึกษา :</td>\
				<td><input id="research-advisor" type="text" value=' + advisor +'></td>\
			</tr>\
			<tr>\
				<td style="text-align:right; vertical-align:top;">หน่วยงาน :</td>\
				<td>\
					<input id="research-organization" type="text" value=' + organization +'>\
					<br/>\
					<input id="research-isnotfinish" type="checkbox" '+( (isnotfinish==='1')?'checked value="1"':'value="0"' )+'><label>ยังไม่สำเร็จ</label>\
				</td>\
			</tr>\
			<tr>\
				<td style="text-align:right; vertical-align:top;">ปีที่เสร็จ :</td>\
				<td><input id="research-yearfinish" style="width:40px" type="text" maxlength="4" value="'+yearfinish+'" '+( (id)?'disabled':'' )+'> กรุณากรอกเป็นปี พ.ศ.\
				</td>\
			</tr>\
			<tr>\
				<td style="text-align:right;">การเผยแพร่ :</td>\
				<td><input id="research-dissemination" type="text" value="'+dissemination+'" '+( (id)?'disabled':'' )+'></td>\
			</tr>\
		</table>\
		</div>';
		
		var buttons = [{text: "บันทึก"
						, click: function(){
									if(id){
										editResearch();
									}else{
										savedResearch();
									}
								}
						}];
		openPopupHtml('[เพิ่ม][แก้ไข]ผลงานวิจัย', html, buttons, 
				function(){ //openFunc
				}, 
				function(){ //closeFunc
				}
			);
	}
	function savedNewResearch(){
		if( validateResearch() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/Profile/savedNewResearch');?>'
				,{'data':{'name':jQuery('#research-name').val()
						,'researchtype':jQuery('#research-researchtype').val()
						,'advisor':jQuery('#research-advisor').val()
						,'organization':jQuery('#research-organization').val()
						,'isnotfinish':jQuery('#research-isnotfinish').val()
						,'yearfinish':jQuery('#research-yearfinish').val()
						,'dissemination':jQuery('#research-dissemination').val()}}
				,function(data){
					unloading();
					
					jAlert(data.msg
							, function(){ 
								if( data.flag === '1' ){
									closePopup('#popup-research-container');
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
	function editResearch(){
		if( validateEducation() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/Profile/editResearch');?>'
					,{'data':{'id':jQuery('#research-id').val()
							,'name':jQuery('#research-name').val()
							,'researchtype':jQuery('#research-researchtype').val()
							,'advisor':jQuery('#research-advisor').val()
							,'organization':jQuery('#research-organization').val()
							,'isnotfinish':jQuery('#research-isnotfinish').val()
							,'yearfinish':jQuery('#research-yearfinish').val()
							,'dissemination':jQuery('#research-dissemination').val()}}
					,function(data){
						unloading();
						
						jAlert(data.msg
								, function(){ 
									if( data.flag === '1' ){
										closePopup('#popup-research-container');
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
	function validateResearch(){
		if( jQuery('#research-name').val() && jQuery('#research-researchtype').val() ){
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
	function deletedResearch(id){
		jConfirm('กรุณายืนยัน เพื่อลบรายการ ', 
				function(){ //okFunc
					loading();
					jQuery.post('<?php echo $this->Html->url('/Profile/deletedResearch');?>'
						,{'data':{'id':id}}
						,function(data){
							unloading();
							jAlert(data.msg
									, function(){ 
										if( data.flag==='1' ){
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