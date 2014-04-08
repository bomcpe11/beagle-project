<script type="text/javascript">
	function openPopupEmailHistory(id){
		loading();
		jQuery.post('<?php echo $this->Html->url('/Emailsender/getEmailById'); ?>'
				,{'data':{'id':id}}
				,function(data){
					unloading();
					
					var html = '<div id="popup_email_history_container" style="width: 800px;">\
						<table class="popup-table-layout">\
							<tr>\
								<td style="width:10%;" class="right label">Send to :</td>\
								<td style="width:80%;">'+ data[0].eh.recipient +'</td>\
							</tr>\
							<tr>\
								<td class="right label">Subject :</td>\
								<td>'+ data[0].eh.subject +'</td>\
							</tr>\
							<tr>\
								<td class="right label">Text :</td>\
								<td class="content-block">'+ data[0].eh.content +'</td>\
							</tr>\
						</table>\
					</div>';
					var buttons = [];
					
					openPopupHtml('Email History Detail', html, buttons,
							function(){ //openFunc
								
							}, 
							function(){ //closeFunc
							}
						);
				}
				,'json');
	}
</script>