<script type="text/javascript">
	function openPopupEmailHistory(createdAt
										,recipient
										,subject
										,text){
		var html = '<div id="popup_email_history_container" style="width: 800px;">\
						<table class="popup-table-layout">\
							<tr>\
								<td style="width:10%;" class="right label">Send to :</td>\
								<td style="width:80%;">' + recipient +'</td>\
							</tr>\
							<tr>\
								<td class="right label">Subject :</td>\
								<td>' + subject + '</td>\
							</tr>\
							<tr>\
								<td class="right label">Text :</td>\
								<td class="content-block">' + text + '</td>\
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
</script>