<?php 
	echo $this->Html->css('personal_info.css');
?>
<!-- ##################################################################################################### -->
<div class="container">
	<h2>ผลงานวิจัย</h2>
	<div class="section-content">
		<ul id="sortable_research">
			<?php if( !empty($listResearch) ){
					$countListResearch = empty($listResearch)?0:count($listResearch);
					for( $i=0;$i<$countListResearch;$i++ ){?>
						<li class="ui-state-default block">
							<input type="hidden" name="research_id" value="<?php echo $listResearch[$i]['r']['id'];?>">
							<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
							<div class="data-item-wrapper">
								<table class="table-data-item">
									<colgroup>
										<col style="width:45%;"/>
										<col style="width:55%;"/>
									</colgroup>
									<tr>
										<td><strong>ชื่อเรื่อง : </strong><?php echo $listResearch[$i]['r']['name'];?></td>
										<td class="edit-delete">
											<img src="<?php echo $this->Html->url('/img/icon_edit.png');?>"
												onclick="openPopupResearch('<?php echo $listResearch[$i]['r']['id']; ?>'
																			,'<?php echo $listResearch[$i]['r']['name']; ?>'
																			,'<?php echo $listResearch[$i]['r']['researchtype']; ?>'
																			,'<?php echo $listResearch[$i]['r']['advisor']; ?>'
																			,'<?php echo $listResearch[$i]['r']['organization']; ?>'
																			,'<?php echo $listResearch[$i]['r']['isnotfinish']; ?>'
																			,'<?php echo empty($listResearch[$i]['r']['yearstart'])?'':intval($listResearch[$i]['r']['yearstart'])+543; ?>'
																			,'<?php echo empty($listResearch[$i]['r']['yearfinish'])?'':intval($listResearch[$i]['r']['yearfinish'])+543; ?>'
																			,'<?php echo $listResearch[$i]['r']['dissemination']; ?>'
																			,'<?php echo $listResearch[$i]['r']['detail']; ?>')"/>
											<img src="<?php echo $this->Html->url('/img/icon_del.png');?>"
												onclick="deleteResearch('<?php echo $listResearch[$i]['r']['id'];?>')"/>
										</td>
									</tr>
									<tr>
										<td colspan="2"><strong>ประเภทของงานวิจัย : </strong><?php echo $listResearch[$i][0]['research_type'];?></td>
									</tr>
									<tr>
										<td><strong>อาจารย์ที่ปรึกษา/ผู้ร่วมวิจัย : </strong><?php echo $listResearch[$i]['r']['advisor']?$listResearch[$i]['r']['advisor']:'-';?></td>
										<td><strong>หน่วยงานที่เกี่ยวข้อง : </strong><?php echo $listResearch[$i]['r']['organization']?$listResearch[$i]['r']['organization']:'-';?></td>
									</tr>
									<tr>
										<td>
											<strong>ปีที่เริ่ม - ปีที่เสร็จ : </strong>
											<?php echo $listResearch[$i]['r']['yearstart']?intval($listResearch[$i]['r']['yearstart'])+543:'-'; ?>
											<?php echo $listResearch[$i]['r']['yearfinish']?' - '.(intval($listResearch[$i]['r']['yearfinish'])+543):''; ?>
										</td>
										<td><strong>การเผยแพร่ : </strong><?php echo $listResearch[$i]['r']['dissemination']?$listResearch[$i]['r']['dissemination']:'-';?></td>
									</tr>
									<tr>
										<td colspan="2">
											<strong>รายละเอียด : </strong>
											<?php echo $listResearch[$i]['r']['detail']? $listResearch[$i]['r']['detail']: '-'; ?>
										</td>
									</tr>
								</table>
							</div>
						</li>
					<?php }?>
			<?php }else{?>
				<li class="ui-state-default block">
					<div class="data-item-wrapper">
						<table class="table-data-item">
							<tr class="no-found-data">
								<td>ไม่พบข้อมูล</td>
							</tr>
						</table>
					<data>
				</li>
			<?php }?>
		</ul>
			
		<input type="button" id="button_add_research" onclick="openPopupResearch('','','-1','','','','','','','')" value="เพิ่มข้อมูล ผลงานวิจัย"/>
	</div>
</div>
<div class="container">
	<h2>ผลงานอื่นๆ</h2>
	<div class="section-content">
		<ul id="sortable_otherwork">
			<?php 
				$countListOtherwork = count($listOtherwork);
				if( $countListOtherwork>0 ){
					for( $i=0;$i<$countListOtherwork;$i++ ){ ?>
						<li class="ui-state-default block">
							<input type="hidden" name="otherwork_id" value="<?php echo $listOtherwork[$i]['o']['id'];?>">
							<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
							<div class="data-item-wrapper">
								<table class="table-data-item">
									<colgroup>
										<col style="width:45%">
										<col style="width:55%">
									</colgroup>
									<tr>
										<td><strong>ชื่อเรื่อง : </strong><?php echo $listOtherwork[$i]['o']['name']; ?></td>
										<td class="edit-delete">
											<img src="<?php echo $this->Html->url('/img/icon_edit.png'); ?>"
													onclick="openPopupOtherwork('<?php echo $listOtherwork[$i]['o']['id']; ?>'
																				,'<?php echo $listOtherwork[$i]['o']['name']; ?>'
																				,'<?php echo $listOtherwork[$i]['o']['organization']; ?>'
																				,'<?php echo $listOtherwork[$i]['o']['isnotfinish']; ?>'
																				,'<?php echo $listOtherwork[$i]['o']['yearstart']?(intval($listOtherwork[$i]['o']['yearstart']) + 543):''; ?>'
																				,'<?php echo $listOtherwork[$i]['o']['yearfinish']?(intval($listOtherwork[$i]['o']['yearfinish']) + 543):''; ?>'
																				,'<?php echo $listOtherwork[$i]['o']['detail']; ?>')">
											<img src="<?php echo $this->Html->url('/img/icon_del.png'); ?>"
													onclick="deleteOtherwork('<?php echo $listOtherwork[$i]['o']['id']; ?>')">
										</td>
									</tr>
									<tr>
										<td><strong>หนว่ยงาน : </strong><?php echo empty($listOtherwork[$i]['o']['organization'])?'-':$listOtherwork[$i]['o']['organization']; ?></td>
										<td>
											<strong>ปีที่เริ่ม - ปีที่เสร็จ : </strong>
											<?php echo $listOtherwork[$i]['o']['yearstart']? intval($listOtherwork[$i]['o']['yearstart']) + 543: '-'; ?>
											<?php echo $listOtherwork[$i]['o']['yearfinish']? ' - '.(intval($listOtherwork[$i]['o']['yearfinish']) + 543): ''; ?>
										</td>
									</tr>
									<tr>
										<td colspan="2"><strong>รายละเอียด : </strong>
											<?php echo $listOtherwork[$i]['o']['detail']? $listOtherwork[$i]['o']['detail']: '-'; ?>
										</td>
									</tr>
								</table>
							</div>
						</li>
					<?php }?>
				<?php }else{?>
					<li class="ui-state-default block">
						<div class="data-item-wrapper">
							<table class="table-data-item">
								<tr class="no-found-data">
									<td>ไม่พบข้อมูล</td>
								</tr>
							</table>
						</div>
					</li>
				<?php }?>
		</ul>
		
		<input type="button" id="button_add_otherwork" value="เพิ่มข้อมูล ผลงานอื่นๆ" onclick="openPopupOtherwork('','','','','','','')"/>
	</div>
</div>
<!-- ##################################################################################################### -->
<?php 
	include 'popup_research.ctp';
	include 'popup_otherwork.ctp';
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
		var isOwner = '<?php echo $isOwner; ?>';

		if( isOwner==='1' ){
			jQuery('#sortable_research, #sortable_otherwork').sortable({
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
	});
	/* -------------------------------------------------------------------------------------------------- */
	function updateSortableSeq(sortable_id){
		var data = new Array();
		
		jQuery('#sortable_'+sortable_id).find('li').each(function(i,e){
			data.push({'id':jQuery(e).find('input[name="'+sortable_id+'_id"]').val()
					 ,'seq':i});
		});

		loading();
		jQuery.post('<?php echo $this->Html->url('/Project/updateSortableSeq');?>'
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
