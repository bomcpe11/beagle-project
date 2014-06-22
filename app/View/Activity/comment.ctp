<script type="text/javascript">
	function addNewComment(){
		if( validateComment() ){
			loading();
			jQuery.post('<?php echo $this->Html->url('/Activity/saveNewComment');?>'
					,{'data':{'commentTitle':jQuery('#comment_title').val()
								,'commentDetial':jQuery('#comment_detial').val()
								,'activityId':'<?php echo $_GET['id']; ?>'}}
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
		if( jQuery('#comment_title').val() && jQuery('#comment_detial').val() ){
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
	/* ------------------------------------------------------------------------------------------------- */
	function deleteComment(id){
		jConfirm('กรุณายืนยัน เพื่อลบความคิดเห็น', 
				function(){ //okFunc
					loading();
					jQuery.post('<?php echo $this->Html->url('/Activity/deleteComment');?>'
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