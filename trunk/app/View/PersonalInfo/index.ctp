<?php 
	echo $this->Html->css('personal_info.css');
?>
<!-- ##################################################################################################### -->
<div id="personal_info" style="padding: 0.25em;">
	<div class="container">
		<div class="section_profile">
			<div class="section_picture">
				<div class="picture">
					<?php 
						if( !empty($objUser[0]['profiles']['image_file']) && !empty($objUser[0]['profiles']['image_file'])  ){
							echo "<img src=\"$this->webroot{$objUser[0]['profiles']['image_file']}\"></img>
									<p>{$objUser[0]['profiles']['image_desc']}</p>";
						}else{
							echo "<img src=\"\"></img>
									<p>ไม่พบขอ้มูล</p>";
						}
					?>
					
				</div>
			</div>
			<div class="section-content">
				<table id="table-profile" class="table_form">
					<colgroup>
						<col style="width: 50%;">
						<col style="width: 50%;">
					</colgroup>
					<?php 
						if( !empty($objUser) ){?>			
							<tr>
								<td colspan="2">
									<strong>ชื่อ-นามสกุล : </strong>
									<span><?php echo $fullNameTh;?></span>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<strong>Name : </strong>
									<span><?php echo $objUser[0]['profiles']['titleen']." ".$objUser[0]['profiles']['nameeng']." ".$objUser[0]['profiles']['lastnameeng'];?></span>
								</td>
							</tr>
							<tr>
								<td>
									<strong>ชื่อเล่น : </strong>
									<span><?php echo $objUser[0]['profiles']['nickname'];?></span>
								</td>
								<td>
									<strong>รุ่นที่/ตำแหน่ง : </strong>
									<span><?php echo $objUser[0]['profiles']['generation'];?></span>
								</td>
							</tr>
							<tr>
								<td>
									<strong>วันเกิด : </strong>
									<span><?php echo $birthday;?></span>
								</td>
								<td>
									<strong>อายุ : </strong>
									<span><?php echo $age;?></span>
								</td>
							</tr>
							<tr>
								<td>
									<strong>สัญชาติ : </strong>
									<span><?php echo $objUser[0]['profiles']['nationality'];?></span>
								</td>
								<td>
									<strong>ศาสนา : </strong>
									<span><?php echo $objUser[0]['profiles']['religious'];?></span>
								</td>
							</tr>
							<tr>
								<td>
									<strong>สถานภาพ : </strong>
									<span><?php echo $objUser[0]['profiles']['socialstatus'];?></span>
								</td>
								<td>
									<strong>สถานภาพทางการศึกษา : </strong>
									<span><?php echo $objUser[0]['profiles']['studystatus'];?></span>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<strong>ที่อยู่ : </strong>
									<span><?php echo $objUser[0]['profiles']['address'];?></span>
								</td>
							</tr>
							<tr>
								<td>
									<strong>โทรศัพท์ : </strong>
									<span><?php echo $objUser[0]['profiles']['telphone'];?></span>
								</td>
								<td>
									<strong>โทรศัพท์มือถือ : </strong>
									<span><?php echo $objUser[0]['profiles']['celphone'];?></span>
								</td>
							</tr>
							<tr>
								<td>
									<strong>อีเมล์ : </strong>
									<span><?php echo $objUser[0]['profiles']['email'];?></span>
								</td>
								<td>
									<strong>ตำแหน่งทางวิชาการ(ถ้ามี) : </strong>
									<span><?php echo $objUser[0]['profiles']['position'];?></span>
								</td>
							</tr>
							<tr>
								<td>
									<strong>Social Network : </strong>
									<span><?php echo $objUser[0]['profiles']['blogaddress'];?></span>
								</td>
								<td>
									<span>สถานะ</span>
								</td>
							</tr>
					<?php }else{?>
						<tr class="no-found-data">
							<td colspan="2">
								ไม่พบข้อมูล
							</td>
						</tr>
					<?php }?>
				</table>
			</div>
		</div>
		<table style="width:100%;"><tr>
		<td align="center">
			<input type="button" id="button_edit_profile" onclick="javascript:edit_profile();" value="แก้ไขข้อมูลส่วนตัว"/>
		</td>
		</tr></table>
	</div>
	<div class="container">
		<h2>ประวัติครอบครัว</h2>
		<div class="section-content">
			<ul id="sortable_family">
				<?php 
					$countListFamily = empty($listFamily)?0:count($listFamily);
					if( $countListFamily>0 ){
						for($i=0; $i<$countListFamily; $i++){
							echo "<li class=\"ui-state-default block\">
									<input type=\"hidden\" name=\"family_id\" value=\"{$listFamily[$i]['families']['id']}\">
									<span class=\"ui-icon ui-icon-arrowthick-2-n-s\"></span>
									<div class=\"data-item-wrapper\">
										<table class=\"table-data-item\">
											<colgroup>
												<col style=\"width:30%;\">
												<col style=\"width:40%;\">
												<col style=\"width:30%;\">
											</colgroup>
											<tr>
												<td><strong>ความเกี่ยวข้อง : </strong>
													{$listFamily[$i]['families']['relation']}
												</td>
												<td>
													<strong>ชื่อ-นามสกุล : </strong>
													{$listFamily[$i]['families']['name']} {$listFamily[$i]['families']['lastname']}
												</td>
												<td class='edit-delete'>
													<img src=\"{$this->Html->url('/img/icon_edit.png')}\"
														onclick=\"openPopupFamily('{$listFamily[$i]['families']['id']}'
																			,'{$listFamily[$i]['families']['relation']}'
																			,'{$listFamily[$i]['families']['name']}'
																			,'{$listFamily[$i]['families']['lastname']}'
																			,'{$listFamily[$i]['families']['education']}'
																			,'{$listFamily[$i]['families']['occupation']}'
																			,'{$listFamily[$i]['families']['position']}')\"/>
													<img src=\"{$this->Html->url('/img/icon_del.png')}\"
														onclick=\"deleteFamily('{$listFamily[$i]['families']['id']}')\"/>
												</td>
											</tr>
											<tr>
												<td><strong>วุฒิการศึกษา : </strong>{$listFamily[$i]['families']['education']}</td>
												<td><strong>อาชีพ : </strong>{$listFamily[$i]['families']['occupation']}</td>
												<td><strong>ตำแหน่ง : </strong>{$listFamily[$i]['families']['position']}</td>
											</tr>
									</table>
								</div>
							</li>";
						}
					 }else {
						echo "<li class=\"ui-state-default block\">
								<div class=\"data-item-wrapper\">
									<table class=\"table-data-item\">
										<tr class=\"no-found-data\">
											<td>ไม่พบข้อมูล</td>
										</tr>
									</table>
								</div>
							</li>";
				}?>
			</ul>
			
			<input type="button" id="button_add_family" onclick="openPopupFamily('','','','','','','')" value="เพิ่มข้อมูล ประวัติครอบครัว"/>
		</div>
	</div>
	<div class="container">
		<h2>ประวัติการศึกษา</h2>
		<div class="section-content">
			<ul id="sortable_education">
				<?php 
					$countListEducation = empty($listEducation)?0:count($listEducation);
					if( $countListEducation>0 ){
						for($i=0; $i<$countListEducation; $i++){?>
							<li class="ui-state-default block">
								<input type="hidden" name="education_id" value="<?php echo $listEducation[$i]['educations']['id'];?>">
								<span class="ui-icon ui-icon-arrowthick-2-n-s"></span>
								<div class="data-item-wrapper">
									<table class="table-data-item">
										<tr>
											<td style="width:30%"><strong>ระดับ : </strong><?php echo $listEducation[$i]['educations']['edutype'];?></td>
											<td style="width:40%"><strong>ชื่อสถาบัน : </strong><?php echo $listEducation[$i]['educations']['name'];?></td>
											<td style="width:30%" class="edit-delete">
												<img src="<?php echo $this->Html->url('/img/icon_edit.png');?>"
													onclick="openPopupEducation('<?php echo $listEducation[$i]['educations']['id'];?>'
																				,'<?php echo $listEducation[$i]['educations']['edutype'];?>'
																				,'<?php echo $listEducation[$i]['educations']['name'];?>'
																				,'<?php echo $listEducation[$i]['educations']['faculty'];?>'
																				,'<?php echo $listEducation[$i]['educations']['major'];?>'
																				,'<?php echo $listEducation[$i]['educations']['isGraduate'];?>'
																				,'<?php echo ( (empty($listEducation[$i]['educations']['startyear']))?'':intval($listEducation[$i]['educations']['startyear']) + 543 );?>'
																				,'<?php echo ( (empty($listEducation[$i]['educations']['endyear']))?'':intval($listEducation[$i]['educations']['endyear']) + 543 );?>'
																				,'<?php echo $listEducation[$i]['educations']['gpa'];?>')"/>
												<img src="<?php echo $this->Html->url('/img/icon_del.png');?>"
													onclick="deleteEducation('<?php echo $listEducation[$i]['educations']['id'];?>')"/>
											</td>
										</tr>
										<tr>
											<td><strong>คณะ : </strong><?php echo $listEducation[$i]['educations']['faculty'];?></td>
											<td colspan="2"><strong>สาขาวิชา : </strong><?php echo ( empty($listEducation[$i]['educations']['major'])?'-':$listEducation[$i]['educations']['major'] );?></td>
										</tr>
										<tr>
											<td><strong>ปีการศึกษา : </strong><?php 
															if( !empty($listEducation[$i]['educations']['startyear'])&&!empty($listEducation[$i]['educations']['endyear']) ){
																if($listEducation[$i]['educations']['isGraduate'] == 1){
																	echo ( intval($listEducation[$i]['educations']['startyear']) + 543 ).' - '.( intval($listEducation[$i]['educations']['endyear']) + 543 );
																}else{
																	echo ( intval($listEducation[$i]['educations']['startyear']) + 543 ).' - '.( intval(date('Y')) + 543 );
																}
															}else{
																echo "-";
															}
															?></td>
											<td colspan="2"><strong>เกรดเฉลี่ย : </strong><?php echo ( empty($listEducation[$i]['educations']['gpa'])?'-':$listEducation[$i]['educations']['gpa'] );?></td>
										</tr>
									</table>
								</div>
							</li>
				<?php }
					}else{?>
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
			
			<input type="button" id="button_add_education" onclick="openPopupEducation('','','','','','0','','','')" value="เพิ่มข้อมูล ประวัติการศึกษา"/>
		</div>
	</div>
	<div class="container">
		<h2>ประวัติการทำงาน</h2>
		<div class="section-content">
			<ul id="sortable_workplace">
				<?php 
					$countListWorkplace = count($listWorkplace);
					if( $countListWorkplace>0 ){
						for( $i=0;$i<$countListWorkplace;$i++ ){
							$temp_start_year = $listWorkplace[$i]['w']['startyear']? $listWorkplace[$i]['w']['startyear']: '-';
							$temp_end_year = $listWorkplace[$i]['w']['endyear']? $listWorkplace[$i]['w']['endyear']: '-';
							
							echo "<li class=\"ui-state-default block\">
									<input type=\"hidden\" name=\"workplace_id\" value=\"{$listWorkplace[$i]['w']['id']}\">
									<span class=\"ui-icon ui-icon-arrowthick-2-n-s\"></span>
									<div class=\"data-item-wrapper\">
										<table class=\"table-data-item\">
											<colgroup>
												<col style=\"width:30%;\">
												<col style=\"width:40%;\">
												<col style=\"width:30%;\">
											</colgroup>
											<tr>
												<td><strong>ตำแหน่ง : </strong>{$listWorkplace[$i]['w']['position']}</td>
												<td><strong>ชื่อสถานที่ทำงาน : </strong>{$listWorkplace[$i]['w']['name']}</td>
												<td class=\"edit-delete\">
													<img src=\"{$this->Html->url('/img/icon_edit.png')}\" width=\"16\" height=\"16\"
															onclick=\"openPopupWorkplace('{$listWorkplace[$i]['w']['id']}'
																							,'{$listWorkplace[$i]['w']['name']}'
																							,'{$listWorkplace[$i]['w']['position']}'
																							,'{$listWorkplace[$i]['w']['telephone']}'
																							,'{$listWorkplace[$i]['w']['startyear']}'
																							,'{$listWorkplace[$i]['w']['endyear']}')\" />
													<img src=\"{$this->Html->url('/img/icon_del.png')}\" width=\"16\" height=\"16\"
															onclick=\"deletedWorkplace('{$listWorkplace[$i]['w']['id']}')\" />
												</td>
											</tr>
											<tr>
												<td><strong>โทรศัพท์ : </strong>{$listWorkplace[$i]['w']['telephone']}</td>
												<td>
													<strong>ปีที่เริ่มงาน : </strong>$temp_start_year
													<strong style=\"padding-left: 3px;padding-right: 3px;\"> ถึง  </strong>$temp_end_year
												</td>
											</tr>
										</table>
									</div>
								</li>";
						}
					} else { 	
							echo "<li class=\"ui-state-default block\">
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
				
				<input type="button" id="button_add_workplace" value="เพิ่มข้อมูล ประวัติการทำงาน" onclick=" openPopupWorkplace('','','','','','','')"/>
			</div>
		</ul>
	</div>
	<div class="container">
		<h2>ความคิดเห็น</h2>
		<div class="section-content">
			<?php 
				$countListComment = count($listComment);
				if( $countListComment>0 ){
					for( $i=0;$i<$countListComment;$i++ ){
						echo  "<table class=\"table-data-item\">
								<tr>
									<td><strong>หัวข้อ : {$listComment[$i]['c']['title']}</strong></td>
									<td class=\"edit-delete\">
										<img src=\"{$this->Html->url('/img/icon_del.png')}\" width=\"16\" height=\"16\"
											onclick=\"deleteComment('{$listComment[$i]['c']['id']}')\" />
									</td>
								</tr>
								<tr>
									<td colspan=\"2\" class=\"comment\">{$listComment[$i]['c']['comment']}</td>
								</tr>
								<tr>
									<td colspan=\"2\">โดย {$listComment[$i][0]['commentator']} เมื่อวันที่ {$listComment[$i]['c']['created_at']}</td>
								</tr>
							</table>";
					}
				}else{
					echo "<table class=\"table-data-item\">
								<tr class=\"no-found-data\">
									<td>ไม่พบข้อมูล</td>
								</tr>
							</table>";
				}
			?>
		</div>
		
		<?php if( $objuser['role']!=='10' && $objuser['role']!=='30' ){ //นักเรียน,นักศึกษา,วิทยากร ?>
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
		<?php }?>
	</div>
	<!-- Popup -->
	<div id="popup-profile">
	</div>
</div>
<!-- ##################################################################################################### -->
<?php 
	include 'popup_profile.ctp';
	include 'popup_family.ctp';
	include 'popup_education.ctp';
	include 'popup_workplace.ctp';
	include 'comment.ctp';
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
			<?php 
				if( $isOwner || $objuser['role']==='1' ){
					echo "jQuery('#sortable_family"
								.",#sortable_education"
								.",#sortable_workplace').sortable({
								update: function(event, ui) {
									// format => sortable_xxxx
									var sortable_id = ui.item.parent('ul').prop('id').replace(/sortable_/gi,'');
									//console.log(sortable_id);
									
									updateSortableSeq(sortable_id);
							    }
							});";
				}else{
					echo "jQuery('#button_edit_profile"
									.",#button_add_family"
									.",#button_add_education"
									.",#button_add_workplace').remove();";
					
					echo "jQuery('.edit-delete').remove();";
				}
			?>
		}
	);
	/* -------------------------------------------------------------------------------------------------- */
	function updateSortableSeq(sortable_id){
		var data = new Array();
		
		jQuery('#sortable_'+sortable_id).find('li').each(function(i,e){
			data.push({'id':jQuery(e).find('input[name="'+sortable_id+'_id"]').val()
					 ,'seq':i});
		});

		loading();
		jQuery.post('<?php echo $this->Html->url('/PersonalInfo/updateSortableSeq');?>'
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
	/* -------------------------------------------------------------------------------------------------- */
	function setFormatForDatePicker(strDate){
		// Ex. 9 ก.พ. 2557
		var splitDate = strDate.split(' ');
		var result = '';
		
		if( splitDate.length===3 ){
			result = splitDate[0]+'/';
			
			switch(splitDate[1]){
			case 'ม.ค.':
				result += '01';
				break;
			case 'ก.พ.':
				result += '02';
				break;
			case 'มี.ค.':
				result += '03';
				break;
			case 'เม.ย.':
				result += '04';
				break;
			case 'พ.ค.':
				result += '05';
				break;
			case 'มิ.ย.':
				result += '06';
				break;
			case 'ก.ค.':
				result += '07';
				break;
			case 'ส.ค.':
				result += '08';
				break;
			case 'ก.ย.':
				result += '09';
				break;
			case 'ต.ค.':
				result += '10';
				break;
			case 'พ.ย.':
				result += '11';
				break;
			case 'ธ.ค.':
				result += '12';
				break;
				default:
				result += '';
				break;
			}

			result += '/'+splitDate[2];
		}
		
		return result;
	}
</script>
