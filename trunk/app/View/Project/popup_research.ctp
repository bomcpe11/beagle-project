<script type="text/javascript">
	function openPopupResearch(id
								,name
								,researchtype
								,advisor
								,organization
								,isnotfinish
								,yearstart
								,yearfinish
								,dissemination
								,detail){
		var html = '<div id="popup_research_container" style="width:600px;">\
						<table style="width:100%;">\
							<tr>\
								<td style="width:30%; text-align:right;">* ชื่อเรื่อง :</td>\
								<td style="width:60%;">\
									<input id="research_id" type="hidden" value=' + id +'>\
									<input id="research_name" type="text" value=' + name +'>\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">* ประเภทของงานวิจัย :</td>\
								<td>\
									<select id="research_researchtype">\
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
								<td style="text-align:right;">อาจารย์ที่ปรึกษา/ผู้ร่วมวิจัย :</td>\
								<td><input id="research_advisor" type="text" value=' + advisor +'></td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">หน่วยงานที่เกี่ยวข้อง :</td>\
								<td>\
									<input id="research_organization" type="text" value=' + organization +'>\
									<br/>\
									<input id="research_isnotfinish" type="checkbox" '+( (isnotfinish==='1')?'checked value="1"':'value="0"' )+'><label>ยังไม่สำเร็จ</label>\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">ปีที่เริ่ม :</td>\
								<td>\
									<input id="research_yearstart" style="width:40px" type="text" maxlength="4" value="'+yearstart+'" '+( (id)?'disabled':'' )+'>\
									<span style="margig:0 3px">ปีที่เสร็จ</span>\
									<input id="research_yearfinish" style="width:40px" type="text" maxlength="4" value="'+yearfinish+'" '+( (id)?'disabled':'' )+'>\
									<br>กรุณากรอกเป็นปี พ.ศ.\
								</td>\
							</tr>\
							<tr>\
								<td style="text-align:right;">การเผยแพร่ :</td>\
								<td><input id="research_dissemination" type="text" value="'+dissemination+'" '+( (id)?'disabled':'' )+'></td>\
							</tr>\
							<tr>\
								<td style="text-align: right;vertical-align: top;">รายละเอียด :</td>\
								<td><textarea id="research_detail" class="popup-textarea"></textarea></td>\
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
					jQuery('#research_researchtype').val(researchtype);
				}, 
				function(){ //closeFunc
				}
			);
	}
	/* -------------------------------------------------------------------------------------------------- */
	function savedNewResearch(){
		if( validateResearch() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/Project/savedNewResearch');?>'
				,{'data':{'name':jQuery('#research_name').val()
						,'researchtype':jQuery('#research_researchtype').val()
						,'advisor':jQuery('#research_advisor').val()
						,'organization':jQuery('#research_organization').val()
						,'isnotfinish':jQuery('#research_isnotfinish').prop('checked')
						,'yearstart':jQuery('#research_yearstart').val()
						,'yearfinish':jQuery('#research_yearfinish').val()
						,'dissemination':jQuery('#research_dissemination').val()
						,'detail':jQuery('#research_detail').val()}}
				,function(data){
					unloading();
					
					jAlert(data.msg
							, function(){ 
								if( data.flag===1 ){
									closePopup('#popup_research_container');
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
			jQuery.post('<?php echo $this->Html->url('/Project/editResearch');?>'
					,{'data':{'id':jQuery('#research_id').val()
							,'name':jQuery('#research_name').val()
							,'researchtype':jQuery('#research_researchtype').val()
							,'advisor':jQuery('#research_advisor').val()
							,'organization':jQuery('#research_organization').val()
							,'isnotfinish':jQuery('#research_isnotfinish').prop('checked')
							,'yearstart':jQuery('#research_yearstart').val()
							,'yearfinish':jQuery('#research_yearfinish').val()
							,'dissemination':jQuery('#research_dissemination').val()
							,'detail':jQuery('#research_detail').val()}}
					,function(data){
						unloading();
						
						jAlert(data.msg
								, function(){ 
									if( data.flag===1 ){
										closePopup('#popup_research_container');
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
		if( jQuery('#research_name').val() && jQuery('#research_researchtype').val()!=='-1' ){
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
					jQuery.post('<?php echo $this->Html->url('/Project/deleteResearch');?>'
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