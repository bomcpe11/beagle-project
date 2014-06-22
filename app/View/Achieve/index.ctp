<?php 
	function genUploadFileForm($action, $idUpload){
		echo '<div class="frm-main">
					<div class="frm frm1">
						<input type="button" style="margin:0px;" value="อัพโหลดไฟล์เพิ่ม" class="frmbtn" frmid="frm2" />
					</div>
					<div class="frm frm2" style="display:none;">
						<form action="'.$action.'" method="post" enctype="multipart/form-data">
							<input type="file" name="upload" />
							<input type="hidden" name="idUpload" value="'.$idUpload.'" /><br />
							* จำกัด 5 ไฟล์ และขนาดรวมไม่เกิน 25 MB
							<input type="submit" style="margin:0px;display:inline;" value="Upload" />
							<input type="button" style="margin:0px;display:inline;" value="Back" class="frmbtn" frmid="frm1" />
						</form>
					</div>
				</div>';
	}
	echo $this->Html->css('personal_info.css');
?>
<!-- ##################################################################################################### -->
<div class="container">
	<h2>รางวัลที่ได้รับ</h2>
	<div class="section-content">
		<ul id="sortable_award">
			<?php 
			$countListAward = count($listAward);
			if( $countListAward>0 ){
				for( $i=0;$i<$countListAward;$i++ ){?>
					<li class="ui-state-default block">
							<input type="hidden" name="award_id" value="<?php echo $listAward[$i]['a']['id'];?>">
							<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
							<div class="data-item-wrapper">
							
								<table><tr>
								<td style="vertical-align:baseline;">
									<div class="thumb1">
										<div class="input-container">
											<input type="hidden" name="dataname" value="award" />
											<input type="hidden" name="dataid" value="<?php echo $listAward[$i]['a']['id']; ?>" />
										</div>
										<div class="overlay"><br /><br /><br />แก้ไข</div>
										
										<?php 
											if(is_file($listAward[$i]['a']['thumbpath'])){
										?>
											<img class="thumb" src="<?php echo $this->Html->url("/".$listAward[$i]['a']['thumbpath']); ?>" />
										<?php }else{ ?>
											<div class="blank">ไม่มีภาพ<?php if($isAdmin || $isOwner=="1"){ ?><br /><a class="link"><img class="thumbchoosefile" alt="อัพโหลดภาพ" title="อัพโหลดภาพ" style="margin: 10px 0 0 0;" src="<?php echo $this->Html->url("/img/plus.png");?>" /></a><?php } ?></div>
										<?php } ?>
									</div>
								</td>
								<td>
								<table class="table-data-item">
									<colgroup>
										<col style="width: 45%;">
										<col style="width: 55%;">
									</colgroup>
									<tr>
										<td><strong>ชื่อผลงาน : </strong><?php echo $listAward[$i]['a']['name']; ?></td>
										<td class="edit-delete">
											<img src="<?php echo $this->Html->url('/img/icon_edit.png'); ?>"
													onclick="openPopupAward('<?php echo $listAward[$i]['a']['id']; ?>'
																			,'<?php echo $listAward[$i]['a']['name']; ?>'
																			,'<?php echo $listAward[$i]['a']['awardname']; ?>'
																			,'<?php echo $listAward[$i]['a']['organization']; ?>'
																			,'<?php echo $listAward[$i]['a']['detail']; ?>')" />
											<img src="<?php echo $this->Html->url('/img/icon_del.png'); ?>"
													onclick="deletedAward('<?php echo $listAward[$i]['a']['id']; ?>')" />
										</td>
									</tr>
									<tr>
										<td><strong>ชื่อรางวัล : </strong><?php echo $listAward[$i]['a']['awardname']; ?></td>
										<td><strong>หน่วยงาน : </strong><?php echo $listAward[$i]['a']['organization']; ?></td>
									</tr>
									<tr>
										<td colspan="2"><strong>รายละเอียด : </strong><?php echo $listAward[$i]['a']['detail']? $listAward[$i]['a']['detail']: '-'; ?></td>
									</tr>
									<tr>
										<td colspan="2">
											<strong>ไฟล์ที่เกียวข้อง : </strong>
											<div style="padding-left:20px;line-height:15px;">
												<?php 
												$path = "files/award/".$listAward[$i]['a']['id'];
												$countFiles = 0;
												$totalsize = 0;
												if($dir = @opendir($path)){
													while (($file = readdir($dir)) !== false)
													{ 
														if(is_file($path."/".$file)){ 
															$totalsize += filesize($path."/".$file);
															?><a href="<?php echo $this->Html->url("/".$path."/".$file);?>" style="color:black;"><?php
															echo $file; ?></a> 
															<?php if($isAdmin || $isOwner=="1"){ ?>
																<img src="<?php echo $this->Html->url('/img/icon_del.png');?>" style="cursor:pointer;" width="10" height="10" title="ลบไฟล์ <?php echo $file; ?> นี้"
																onclick="deleteFile('<?php echo $path."/".$file ?>','<?php echo $listAward[$i]['a']['id'] ?>');" />
															<?php } ?>
															<br /><?php
															$countFiles++;
														}
													}
												}
												@closedir($dir);
												?>
												<?php 
													if(($isAdmin ||$objuser['id']==$_GET['id']) && $countFiles<5){
														?><i>[<?php echo round($totalsize / 1048576, 1); ?>MB/25MB]</i><?php
														genUploadFileForm($this->Html->url('/Achieve/uploadFiles').'?uploadfor=award&id='.$_GET['id'], $listAward[$i]['a']['id']);
													}
												?>
											</div>
										</td>
									</tr>
								</table>
								</td>
								</tr></table>
								
								
							</div>
					</li>
				<?php } 
			} else { ?>	
				<li class="ui-state-default block">
					<div class="data-item-wrapper">
						<table class="table-data-item">
								<tr class="no-found-data">
									<td>ไม่พบข้อมูล</td>
								</tr>
							</table>
					</div>
				</li>
			<?php } ?>
		</ul>
			
		<input type="button" id="button_add_award" value="เพิ่มข้อมูล รางวัลที่ได้รับ" onclick="openPopupAward('','','','','')"/>
	</div>
</div>
<div style="display:none;">
	
	<div id="frmthumbuploader">
		<form action="<?php echo $this->Html->url('/Achieve/crop'); ?>" method="post" enctype="multipart/form-data">
			<fieldset style="width: 300px;margin: 5px auto;">
			<legend>อัพโหลดภาพ</legend>
				<table>
					<tr>
						<td>
							<input type="file" name="file_upload" />
							<input type="hidden" name="dataname" />
							<input type="hidden" name="dataid" />
							<input type="hidden" name="profileid" />
						</td>
					</tr>
				</table>
			</fieldset>
		</form>
		
	</div>

</div>
<!-- ##################################################################################################### -->
<?php 
	include 'popup_award.ctp';
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		var isOwner = '<?php echo $isOwner; ?>';

		if( isOwner==='1' || '<?php echo $isAdmin; ?>' ){
			jQuery('#sortable_award').sortable({
				update: function(event, ui){
					// format => sortable_xxxx
					var sortable_id = ui.item.parent('ul').prop('id').replace(/sortable_/gi,'');
					//console.log(sortable_id);
					
					updateSortableSeq(sortable_id);
			    }
			});
		}else{
			jQuery('input[type="button"]').remove();
			jQuery('.edit-delete').remove();
		}

		jQuery('input:button.frmbtn').click(function(){
			var input_container = jQuery(this).closest("div.frm-main");
			input_container.find('div.frm').hide();
			input_container.find('div.'+jQuery(this).attr('frmid')).show();
		});
		
		<?php if($isAdmin || $isOwner=="1"){ ?>
		jQuery('div.thumb1 .thumb').mouseover(function(){
			var thumb_container = jQuery(this).closest("div.thumb1");
			thumb_container.find('.overlay').show();
		});
		jQuery('div.thumb1 .overlay').mouseout(function(){
// 			alert('AA');
			var thumb_container = jQuery(this).closest("div.thumb1");
			thumb_container.find('.overlay').hide();
		});
		jQuery('.thumbchoosefile, div.overlay').click(function() {
			
			//TODO: Set all parameter value.
			var input_container = jQuery(this).closest("div.thumb1").find('.input-container');
// 			console.log(input_container);
			var dataname = input_container.find('input[name="dataname"]').val();
			var dataid = input_container.find('input[name="dataid"]').val();
			
			var frmContainer = jQuery('#frmthumbuploader');
			frmContainer.find('input[name="dataname"]').val(dataname);
			frmContainer.find('input[name="dataid"]').val(dataid);
			frmContainer.find('input[name="profileid"]').val('<?php echo $get_profile_id; ?>');
			
			frmContainer.css('width', '500px');
			var buttons = [
	   			{text: "Upload", click: function(){
	   				jQuery('#frmthumbuploader').find('form')[0].submit();
		   		}}
			];
			openPopupHtml('Upload Thumbnail', '#frmthumbuploader', buttons, 
					function(){ //openFunc
					}, 
					function(){ //closeFunc
						jQuery('#frmthumbuploader').find('form')[0].reset();
					}
			);
		});
		<?php } ?>
		
	});
	/* -------------------------------------------------------------------------------------------------- */
	<?php if($isAdmin || $isOwner=="1"){ ?>
		function deleteFile(path,id){
			jConfirm('ท่านต้องการลบไฟล์นี้?', 
				function(){ //okFunc
					loading();
					jQuery.ajax({
						type: "POST",
						dataType: 'json',
						url: '<?php echo $this->Html->url('/Project/deleteFile');?>',
						data: {path:path},
						success: function(data){
							unloading();
							if ( data.status ) {
								jAlert(data.message, 
									function(){
										//window.location.replace("<?php echo $this->webroot;?>Project?id=" + id);
										window.location.reload();
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
	/* -------------------------------------------------------------------------------------------------- */
	function updateSortableSeq(sortable_id){
		var data = new Array();
		
		jQuery('#sortable_'+sortable_id).find('li').each(function(i,e){
			data.push({'id':jQuery(e).find('input[name="'+sortable_id+'_id"]').val()
					 ,'seq':i});
		});

		loading();
		jQuery.post('<?php echo $this->Html->url('/Achieve/updateSortableSeq');?>'
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
