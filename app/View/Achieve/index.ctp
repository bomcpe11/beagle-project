<?php 
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
								</table>
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
	});
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
