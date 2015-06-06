<script type="text/javascript">
	function openPopupComment(action_container_selector){

		var jContainer = jQuery(action_container_selector);
// 		console.log(jContainer.find('input:hidden.comment_id').val());
// 		console.log(jContainer.find('input:hidden.title').val());
// 		console.log(jContainer.find('td.comment').html());
		
		var html = '<div id="popup-comment-container" style="width:850px;">\
		<table style="width:100%;">\
			<colgroup>\
				<col style="width: 13%;">\
				<col style="width: 87%;">\
			</colgroup>\
			<tr>\
				<td style="text-align: right;">* หัวข้อ :</td>\
				<td>\
					<input id="popup-comment-id" type="hidden" value="'+jContainer.find('input:hidden.comment_id').val()+'">\
					<input id="popup-comment-title" type="text" style="width: 98%;" value="'+jContainer.find('input:hidden.title').val()+'">\
				</td>\
			</tr>\
			<tr>\
				<td style="text-align: right;vertical-align: top;">* ความคิดเห็น :</td>\
				<td>\
				<textarea type="text" id="popup_comment_detail" style="width: 98%;height: 100px;">'+jContainer.find('td.comment').html()+'</textarea>\
				</td>\
			</tr>\
		</table>\
		</div>';
		
		var buttons = [{text: "บันทึก" 
			, click: function(){
				editComment(jQuery('#popup-comment-id').val(), jQuery('#popup-comment-title').val(), CKEDITOR.instances.popup_comment_detail.getData());
			}
		}];
		
		openPopupHtml('[เพิ่ม][แก้ไข] ความคิดเห็น', html, buttons, 
			function(){ //openFunc
				CKEDITOR.replace( 'popup_comment_detail', {toolbar: [
					                                       		{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
					                                    		[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
					                                    		'/',																					// Line break - next group will be placed in new line.
					                                    		{ name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'FontSize', 'TextColor', 'BGColor' ] },
					                                    	]});

            	
			}, 
			function(){ //closeFunc
				
			}
		);
	}
	/* -------------------------------------------------------------------------------------------------- */
	function addNewComment(){
		if( validateComment() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/saveNewComment');?>'
					,{'data':{'commentTitle':jQuery('#comment_title').val()
								,'commentDetial':CKEDITOR.instances.comment_detial.getData()//jQuery('#comment_detial').val()
								,'profileId':'<?php echo $objUser[0]['profiles']['id'];?>'}}
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
		}
	}
	/* ------------------------------------------------------------------------------------------------- */
	function validateComment(){
		if( jQuery('#comment_title').val() && CKEDITOR.instances.comment_detial.getData() ){
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
	function editComment(id, title, comment){
			
		if( title && comment ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/PersonalInfo/editComment');?>'
						,{'data':{'id':id
									,'title':title
									,'comment':comment}}
						,function(data){
							unloading();
							jAlert(data.msg
									, function(){ 
										if( data.flag===1 ){
											window.location.reload();
										}else{
											
										}
									}//okFunc	
									, function(){ 
									}//openFunc
									, function(){ 		
									}//closeFunc
							);
						}
						,'json');
		}else{
			jAlert('คุณกรอกข้อมูล ไม่ครบ');
		}
	}
	/* ------------------------------------------------------------------------------------------------- */
	function deleteComment(id){
		jConfirm('กรุณายืนยัน เพื่อลบความคิดเห็น', 
				function(){ //okFunc
					loading();
					jQuery.post('<?php echo $this->Html->url('/PersonalInfo/deleteComment');?>'
							,{'data':{'id':id}}
							,function(data){
								unloading();
								jAlert(data.msg
										, function(){ 
											if( data.flg===1 ){
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
				}
			);
	}
</script>