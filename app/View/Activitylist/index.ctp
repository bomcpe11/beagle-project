<?php

?>

<input type="button" id="jdialog1" value="open Popup" />
</p>
<script type="text/javascript">
	/*Syntax : void openPopupHtml(String title, String html, ObjectArray buttons, function openFunc, function closeFunc, boolean isPutCloseBtn=true)*/
		jQuery('#jdialog1').click(function(){
			var html = '';
			var buttons = '';
			var i=0;
		    jQuery.post("<?php echo $this->Html->url('/Activitylist/getActivitylist');?>"
				, {}
				, function(data) {
					//jAlert(data.result[0].activities.name);
					html += '<div id="jdialog1-container" style="width:900px;">\
										<div class="popup1">\
											<table class="tableLayout" border="1" bordercolor="#eeeeee" width="100%">\
												<tr align="center" style="font-weight: bold;">\
													<td width="15%" >ชื่อกิจกรรม</td>\
													<td width="15%">วันที่จัดกิจกรรม</td>\
													<td width="20%">สถานที่จัดกิจกรรม</td>\
													<td width="15%">ชื่อเรื่อง</td>\
													<td width="20%">รายละเอียดอย่างย่อ</td>\
													<td width="5%">แก้ไข</td>\
													<td width="10%">ลบกิจกรรม</td>\
												</tr>';
				    for(i=0; i<data.result.length; i++){
				    //jAlert(data.result[i].activities.name);
				    html +=					    '<tr align="center">\
													<td width="15%">'+ data.result[i].activities.name +'</td>\
													<td width="15%">'+ data.result[i].activities.startdtm +'-'+data.result[i].activities.enddtm +'</td>\
													<td width="20%">'+ data.result[i].activities.location +'</td>\
													<td width="15%">'+ data.result[i].activities.genname +'</td>\
													<td width="20%">'+ data.result[i].activities.shortdesc +'</td>\
													<td width="5%">/</td>\
													<td width="10%"><a onclick="test('+data.result[i].activities.id+');">X</a>\
													<input type="hidden" id="id" value="'+data.result[i].activities.id+'">\
													</td>\
												</tr>';
					}
					html += '</table></div></div>';
					buttons = [
			   			{text: "เพิ่มกิจกรรม", click: function(){่jAlert('เพิ่มกิจกรรม');}}
					];
					openPopupHtml('ข้อมูลกิจกรรม', html, buttons, 
							function(){ //openFunc
								//jQuery('.popup1').append(' TEST AFTER');
								//alert('opened');
							}, 
							function(){ //closeFunc
								//alert('closed');
							}
					);
				}
				, "json").error(function() {}
			);																														
		});
		
		function test(id){
			jAlert(id);
			jQuery.post("<?php echo $this->Html->url('/Activitylist/deleteActivity');?>", {"id":id}
			, function(data) {
				
				/*if(data.status.id==1) {	
					jAlert('ดำเนินการเรียบร้อย!', function(){
						                        jQuery(window.location).attr('href',G_WEB_ROOT+"data.csv");
						                  }
	                                   ,function(){}
	                                   ,function(){});
				}else{
					jAlert('เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ!', function(){},function(){},function(){});
			    }*/
			},"json").error(function() {
			}
			);
		}
</script>

