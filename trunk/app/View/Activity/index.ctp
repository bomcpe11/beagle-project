<?php 
	echo $this->Html->css('personal_info.css');
?>
<?php 
	//include 'popup_join_activity.ctp';
	include 'comment.ctp';
?>
<?php 
	$isAllowUploadFile = $isAdmin;
?>
<script type="text/javascript">
    function addFile(){
		jQuery('#uploadFile').css("display","block");
	}
	function cancel(){
		jQuery('#uploadFile').css("display","none");
	}

	function activityAdd(){
		window.location.replace("<?php echo $this->webroot;?>Activity/addactivity");
	}
	
	function activityEdit(id){
		window.location.replace("<?php echo $this->webroot;?>Activity/editactivity?id="+id);
	}

	<?php if($isAdmin){ ?>
	function deleteData(id){
		jConfirm('ท่านต้องการลบข้อมูลกิจกรรมนี้ใช่หรือไม่?', 
			function(){ //okFunc
				loading();
				jQuery.ajax({
					type: "POST",
					dataType: 'json',
					url: '<?php echo $this->Html->url('/Activitylist/deleteActivity');?>',
					data: {id:id},
					success: function(data){
						unloading();
						if ( data.status ) {
							jAlert(data.message, 
								function(){
									window.location.replace("<?php echo $this->webroot;?>Activitylist/index");
								}
							);
						} else {
							jAlert(data.message);
						}
					}
				});
			}
		);
	}
	function activityChangeToCurrent(id){
		loading();
		jQuery.ajax({
			type: "POST",
			dataType: 'json',
			url: '<?php echo $this->Html->url('/Activity/updateToCurrentActivity');?>',
			data: {activity_id:id},
			success: function(data){
				unloading();
				if ( data.status ) {
					window.location.reload();
				} else {
					jAlert(data.msg);
				}
			}
		});
	}
	<?php } ?>

	<?php if($isAllowUploadFile){ ?>
	function deleteFile(path,id){
		jConfirm('ท่านต้องการลบไฟล์นี้?', 
			function(){ //okFunc
				loading();
				jQuery.ajax({
					type: "POST",
					dataType: 'json',
					url: '<?php echo $this->Html->url('/Activity/deleteFile');?>',
					data: {path:path},
					success: function(data){
						unloading();
						if ( data.status ) {
							jAlert(data.message, 
								function(){
									window.location.replace("<?php echo $this->webroot;?>Activity?id=" + id);
								}
							);
						} else {
							jAlert(data.message);
						}
					}
				});
			}
		);
	}
	<?php } ?>
</script>
<style type="text/css">
#activity-longdesc, #activity-longdesc p, #activity-longdesc td, #activity-longdesc th, #activity-longdesc span, #activity-longdesc div{
	color: black;
}
#activity-longdesc h1, #activity-longdesc h2, #activity-longdesc h3, #activity-longdesc h4, #activity-longdesc h5{
	color: black;
}
#activity-longdesc{
	border:1px solid black;
	border-radius:5px;
	background-color: #FDFDFE;
	padding:2px;
}
#activity-summary, #activity-summary p, #activity-summary td, #activity-summary th, #activity-summary span, #activity-summary div{
	color: black;
}
#activity-summary h1, #activity-summary h2, #activity-summary h3, #activity-summary h4, #activity-summary h5{
	color: black;
}
#activity-summary{
	border:1px solid black;
	border-radius:5px;
	background-color: #FDFDFE;
	padding:2px;
}
</style>
<?php 	
	if($result[0]["activities"]["startdtm"] != "" and  $result[0]["activities"]["enddtm"] != ""){
		$startdtm = $result[0]["activities"]["startdtm"];
		$enddtm = $result[0]["activities"]["enddtm"];
		$dateArray=explode('-',$startdtm);
		$enddateArray=explode('-',$enddtm);
		$thai_month_arr=array(  "00"=>"",  
							    "01"=>"มกราคม",  
							    "02"=>"กุมภาพันธ์",  
							    "03"=>"มีนาคม.",  
							    "04"=>"เมษายน.",  
							    "05"=>"พฤษภาคม",  
							    "06"=>"มิถุนายน",   
							    "07"=>"กรกฎาคม",  
							    "08"=>"สิงหาคม",  
							    "09"=>"กันยายน",  
							    "10"=>"ตุลาคม",  
							    "11"=>"พฤศจิกายน",  
							    "12"=>"ธันวาคม");   
		$startdtm = $dateArray[2].' '.$thai_month_arr[$dateArray[1]].' '.($dateArray[0]+543);
		$enddtm = $enddateArray[2].' '.$thai_month_arr[$enddateArray[1]].' '.($enddateArray[0]+543);
	}else{
		$startdtm = "";
		$enddtm = "";
	}
?>
<div style="padding:20px;">
<h2 style="margin: 0 0 10px 0;"><?php echo $result[0]["activities"]["name"] ?></h2>
<?php if($isAllowUploadFile){ ?>
<form id="form_data" name="form_data" method="post" action="<?php echo $this->webroot;?>Activity/uploadFiles" enctype="multipart/form-data">
<?php } ?>
<input type="hidden" name="idUpload" value="<?php echo $result[0]["activities"]["id"] ?>" />
<table class="tableLayout" width="100%" border="0" style="border-spacing: 10px;border-collapse: separate;">
	<tr>
		<th align="right" width="170">ชื่อกิจกรรม : 
		<input type="hidden" id="AcId" value="<?php echo $result[0]["activities"]["id"] ?>"/>
		</th>
		<td><?php echo $result[0]["activities"]["name"] ?></td>
	</tr>
	<tr>
		<th align="right">วันเริ่มต้น : </th>
		<td><?php echo $startdtm; ?></td>
	</tr>
	<tr>
		<th align="right">วันสิ้นสุด : </th>
		<td><?php echo $enddtm; ?></td>
	</tr>
	<tr>
		<th align="right">สถานที่จัดกิจกรรม : </th>
		<td><?php echo $result[0]["activities"]["location"] ?></td>
	</tr>
	<tr>
		<th align="right">รายละเอียดกิจกรรม(ย่อ) : </th><td></td>
	</tr>
	<tr>
		<td colspan="2"><div style="padding-left:50px;"><?php echo $result[0]["activities"]["shortdesc"] ?></div></td>
	</tr>
	<?php if( $isAdmin ){ ?>
		<tr>
			<th align="right">สรุปกิจกรรม : </th>
		</tr>
		<tr>
			<td colspan="2"><div id="activity-summary"><?php echo $result[0]["activities"]["summary"]; ?></div></td>
		</tr>
	<?php } ?>
	<tr>
		<th align="right">รายละเอียดกิจกรรม : </th><td></td>
	</tr>
	<tr>
		<td colspan="2"><div id="activity-longdesc"><?php echo $result[0]["activities"]["longdesc"] ?></div></td>
	</tr>
	<tr>
		<td colspan="2" align="right">
			<!--input type="button" id="Edit" onclick="activityEdit('<?php echo $result[0]["activities"]["id"] ?>');" value="แก้ไขรายละเอียดของกิจกรรมนี้"/-->
		</td>
	</tr>
</table>
<br/>
<table class="tableLayout" width="100%" style="display:block;">
	<tr align="left" >
		<th colspan="2"> ไฟล์แนบ</th>
	</tr>
	<tr>
		<th align="left" width="40%">ชื่อไฟล์</th>
		<?php if($isAllowUploadFile){ ?><th align="right" width="40%">ลบไฟล์</th><?php } ?>
	</tr>
	<?php
			$path = "files/activities/".$result[0]["activities"]["id"];
			if($dir = @opendir($path)){
				$dir = opendir("files/activities/".$result[0]["activities"]["id"]);
				while (($file = readdir($dir)) !== false)
				{ 
	?>
				<?php if(is_file("files/activities/".$result[0]["activities"]["id"]."/"."$file")){ ?>
				<tr>
					<td align="left">
						<a href="<?php echo $this->Html->url("/".$path."/".$file);?>" style="color:black;"><?php echo $file; ?></a> 
					</td>
						<?php if($isAllowUploadFile){ ?>
						<td align="right">
						<img style="cursor: pointer; cursor: hand;" 
						onclick="deleteFile('<?php echo  "files/activities/".$result[0]["activities"]["id"]."/"."$file" ?>','<?php echo $result[0]["activities"]["id"] ?>');"
						src="<?php echo $this->Html->url('/img/icon_del.png'); ?>" width="16" height="16" />
						</td>
						<?php }?>
				</tr>
				<?php } ?>
		<?php   }
			}
			@closedir($dir);
			?> 
	<?php if($isAllowUploadFile){ ?>
	<tr align="left" >
		<th colspan="4"><input type="button" id="AddFile" onclick="addFile();" value="อัพโหลดไฟล์เพิ่ม"/></th>
	</tr>
	<?php } ?>
</table>
<?php if($isAllowUploadFile){ ?>
<table class="tableLayout" id="uploadFile" width="100%" style="display:none;">
	<tr>
		<td class="td_label">ไฟล์แนบ : </td>
		<td class="td_data"><input type="file"  id="upload" name="upload"></td>
	</tr>
	<tr>
		<td><input value="Submit" type="submit"  ></td>
		<td><input value="Cancel" type="button" onclick="cancel();"></td>
	</tr>
</table>
<?php } ?>
<table class="tableLayout" width="100%">
	<tr style="text-align:center">
		<td>
		<?php if( $isAdmin ){ ?>
			<input type="button" id="Edit" onclick="activityEdit('<?php echo $result[0]["activities"]["id"] ?>');" value="แก้ไขกิจกรรมนี้"/>
			<input type="button" <?php echo ($result[0]["activities"]["currentflg"]?'disabled="disabled"':''); ?> id="ChangeCurrent" onclick="activityChangeToCurrent('<?php echo $result[0]["activities"]["id"] ?>');" value="ตั้งค่าให้แสดงในกิจกรรมล่าสุด"/>
			<input type="button" id="Delete" onclick="deleteData('<?php echo $result[0]["activities"]["id"] ?>');" value="ลบกิจกรรมนี้"/>
		<?php } ?>
		<input type="button" onclick="history.back();" value="กลับ"/>
		</td>
	</tr>
</table>
<?php if($isAllowUploadFile){ ?></form><?php } ?>
<!-- ####################################################### Comments ############################################# -->
<div class="container">
	<h2>ความคิดเห็น</h2>
	<div class="section-content">
		<ul id="sortable_actcomments">
			<?php 
				$countListComment = count($listComment);
				if( $countListComment>0 ){
					for( $i=0;$i<$countListComment;$i++ ){
 						//echo $listComment[$i]['ac']['commentable_id'].'|'.$objuser['id'];
						echo "<li class=\"ui-state-default block\">
								<input type=\"hidden\" name=\"actcomments_id\" value=\"{$listComment[$i]['ac']['id']}\">
								<span class=\"ui-icon ui-icon-arrowthick-2-n-s\"></span>
								<div class=\"data-item-wrapper\">
									<table class=\"table-data-item\">
										<tr>
											<td><strong>หัวข้อ : {$listComment[$i]['ac']['title']}</strong></td>
											<td class=\"edit-delete\">";
						
						if( $objuser['id']===$listComment[$i]['ac']['commentable_id'] ){
							echo "				<img src=\"{$this->Html->url('/img/icon_del.png')}\" width=\"16\" height=\"16\"
													onclick=\"deleteComment('{$listComment[$i]['ac']['id']}')\" />";
						}
						echo "				</td>
										</tr>
										<tr>
											<td colspan=\"2\" class=\"comment\">{$listComment[$i]['ac']['comment']}</td>
										</tr>
										<tr>
											<td colspan=\"2\">โดย {$listComment[$i][0]['commentator']} เมื่อวันที่ {$listComment[$i]['ac']['created_at']}</td>
										</tr>
									</table>
								</div>
							</il>";
					}
				}else{
					echo "<il class=\"ui-state-default block\">
							<div class=\"data-item-wrapper\">
								<table class=\"table-data-item\">
									<tr class=\"no-found-data\">
										<td>ไม่พบข้อมูล</td>
									</tr>
								</table>
							</div>
						</li>";
				}
			?>
		</ul>
	</div>
	<div class="section-content">
		<table class="table-data-item">
			<colgroup>
				<col style="width:20%;">
				<col style="width:80%;">
			</colgroup>
			<tr>
				<td colspan="2"><h3>เพิ่มความคิดเห็น</h3></td>
			</tr>
			<tr>
				<td style="text-align: right;"><b>หัวข้อ :</b></td>
				<td>
					<input type="text" id="comment_title" style="width: 98%;" value=""></input>
				</td>
			</tr>
			<tr>
				<td style="text-align: right;vertical-align: top;"><b>ความคิดเห็น :</b></td>
				<td>
					<textarea type="text" id="comment_detial" style="width: 98%;height: 100px;"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<input type="button" id="button_add_comment" value="เพิ่มข้อมูล ความคิดเห็น" onclick="addNewComment()"/>
				</td>
			</tr>
		</table>
	</div>
</div>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		<?php 
			if( $isAdmin ){
				echo "jQuery('#sortable_actcomments').sortable({
							update: function(event, ui) {
								// format => sortable_xxxx
								var sortable_id = ui.item.parent('ul').prop('id').replace(/sortable_/gi,'');
								//console.log(sortable_id);
								
								updateSortableSeq(sortable_id);
						    }
						});";
			}
		?>
	});
	/* -------------------------------------------------------------------------------------------------- */
	function updateSortableSeq(sortable_id){
		var data = new Array();
		
		jQuery('#sortable_'+sortable_id).find('li').each(function(i,e){
			data.push({'id':jQuery(e).find('input[name="'+sortable_id+'_id"]').val()
					 ,'seq':i});
		});

		loading();
		jQuery.post('<?php echo $this->Html->url('/Activity/updateSortableSeq');?>'
				,{'data':{'sortable_id':sortable_id
							,'data':data}}
				,function(data){
					unloading();
					jAlert(data.msg, 
							function(){ //okFunc
							}, 
							function(){ //openFunc
							}, 
							function(){ //closeFunc
							}
							);
				}
				,'json');
	}
</script>