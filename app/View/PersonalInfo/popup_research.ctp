<script type="text/javascript">
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
								<td>\
									<select id="research-researchtype">\
										<option value="-1">---- กรุณาเลือก ----</option>\
										<?php 
											$countListResearchType = count($listResearchType);
											for( $i=0;$i<$countListResearchType;$i++ ){ 
													echo "<option value=\"{$listResearchType[$i]['gvars']['varcode']}\">{$listResearchType[$i]['gvars']['vardesc1']}</option>";
										
											} 
										?>\
									</select>\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">อาจารย์ที่ปรึกษา/ผู้วิจัยร่วม :</td>\
								<td><input id="research-advisor" type="text" value=' + advisor +'></td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">หน่วยงานที่เกี่ยวข้อง :</td>\
								<td>\
									<input id="research-organization" type="text" value=' + organization +'>\
									<br/>\
									<input id="research-isnotfinish" type="checkbox" '+( (isnotfinish==='1')?'checked value="1"':'value="0"' )+'><label>ยังไม่สำเร็จ</label>\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">ปีที่เสร็จ :</td>\
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
										savedNewResearch();
									}
								}
						}];
		openPopupHtml('[เพิ่ม][แก้ไข]ผลงานวิจัย', html, buttons, 
				function(){ //openFunc
					jQuery('#research-researchtype').val(researchtype);
				}, 
				function(){ //closeFunc
				}
			);
	}
	/* -------------------------------------------------------------------------------------------------- */
	function savedNewResearch(){
		if( validateResearch() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/savedNewResearch');?>'
				,{'data':{'name':jQuery('#research-name').val()
						,'researchtype':jQuery('#research-researchtype').val()
						,'advisor':jQuery('#research-advisor').val()
						,'organization':jQuery('#research-organization').val()
						,'isnotfinish':jQuery('#research-isnotfinish').prop('checked')
						,'yearfinish':jQuery('#research-yearfinish').val()
						,'dissemination':jQuery('#research-dissemination').val()}}
				,function(data){
					unloading();
					
					jAlert(data.msg
							, function(){ 
								if( data.flag===1 ){
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
	/* -------------------------------------------------------------------------------------------------- */
	function editResearch(){
		if( validateResearch() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/editResearch');?>'
					,{'data':{'id':jQuery('#research-id').val()
							,'name':jQuery('#research-name').val()
							,'researchtype':jQuery('#research-researchtype').val()
							,'advisor':jQuery('#research-advisor').val()
							,'organization':jQuery('#research-organization').val()
							,'isnotfinish':jQuery('#research-isnotfinish').prop('checked')
							,'yearfinish':jQuery('#research-yearfinish').val()
							,'dissemination':jQuery('#research-dissemination').val()}}
					,function(data){
						unloading();
						
						jAlert(data.msg
								, function(){ 
									if( data.flag===1 ){
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
	/* -------------------------------------------------------------------------------------------------- */
	function validateResearch(){
		if( jQuery('#research-name').val() && jQuery('#research-researchtype').val()!=='-1' ){
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
	function deleteResearch(id){
		jConfirm('กรุณายืนยัน เพื่อลบรายการ ', 
				function(){ //okFunc
					loading();
					jQuery.post('<?php echo $this->Html->url('/PersonalInfo/deleteResearch');?>'
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