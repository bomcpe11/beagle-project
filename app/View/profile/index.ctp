<?php 
	echo $this->Html->css('profile.css');
?>
<!-- ##################################################################################################### -->
<?php 
	include 'popup_profile.ctp';
	include 'popup_family.ctp';
	include 'popup_education.ctp';
	include 'popup_research.ctp';
	include 'popup_award.ctp';
	include 'popup_workplace.ctp';
	include 'change_activity.ctp'
?>
<script type="text/javascript">
	jQuery(document).ready(function() {
			jQuery('#tabs').tabs();
			jQuery('input[type="button"]').button();
			<?php 
				if( !$isOwner ){
					echo "jQuery('input[type=\"button\"]').remove();";
					echo "jQuery('.edit-delete').remove();";
				}
			?>
		}
	);
</script>
<!-- ##################################################################################################### -->
<div id="tabs">
	<ul>
	    <li><a href="#profile">ข้อมูลส่วนตัว</a></li>
	    <li><a href="#activity">กิจกรรมที่เข้าร่วม</a></li>
	</ul>
	<div id="profile">
		<div class="container">
			<div class="section_profile">
				<div class="section_picture">
					<div class="picture">
						<img></img>
						<p>Profile Picture Description</p>
					</div>
				</div>
				<div class="section_content">
					<table id="table-profile" class="table_form">
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
										<strong>รุ่น : </strong>
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
										<strong>สถานะภาพ : </strong>
										<span><?php echo $objUser[0]['profiles']['socialstatus'];?></span>
									</td>
									<td>
										<strong>สถานะภาพทางการศึกษา : </strong>
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
									<td colspan="2">
										<strong>อีเมล์ : </strong>
										<span><?php echo $objUser[0]['profiles']['email'];?></span>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<strong>Sosial Media : </strong>
										<span><?php echo $objUser[0]['profiles']['blogaddress'];?></span>
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
					<input type="button" onclick="javascript:edit_profile();" value="แก้ไขข้อมูลส่วนตัว"/>
				</div>
			</div>
		</div>
		<div class="container">
			<h2>ประวัติครอบครัว</h2>
			<div class="section_content">
				<?php 
					$countListFamily = empty($listFamily)?0:count($listFamily);
					if( $countListFamily>0 ){?>
					<table class="table_data">
						<thead>
							<tr>
								<th style="text-align:center;">ความเกี่ยวข้อง</th>
								<th style="text-align:center;">ชื่อ</th>
								<th style="text-align:center;">นามสกุล</th>
								<th style="text-align:center;">วุฒิการศึกษา</th>
								<th style="text-align:center;">อาชีพ</th>
								<th style="text-align:center;">ตำแหนง</th>
								<th style="text-align:center;" class="edit-delete">Edit</th>
								<th style="text-align:center;" class="edit-delete">Delete</th>
							</tr>
						</thead>
						<tbody>
						<?php for($i=0; $i<$countListFamily; $i++){?>
							<tr>
								<td>
									<input id="family_id" type="hidden" value="<?php echo $listFamily[$i]['families']['id'];?>"/>
									<?php echo $listFamily[$i]['families']['relation'];?>
								</td>
								<td><?php echo $listFamily[$i]['families']['name'];?></td>
								<td><?php echo $listFamily[$i]['families']['lastname'];?></td>
								<td><?php echo $listFamily[$i]['families']['education'];?></td>
								<td><?php echo $listFamily[$i]['families']['occupation'];?></td>
								<td><?php echo $listFamily[$i]['families']['position'];?></td>
								<td style="text-align:center" class="edit-delete">
									<img src="<?php echo $this->Html->url('/img/icon_edit.png');?>" width="16" height="16"
										onclick="openPopupFamily('<?php echo $listFamily[$i]['families']['id'];?>'
															,'<?php echo $listFamily[$i]['families']['relation'];?>'
															,'<?php echo $listFamily[$i]['families']['name'];?>'
															,'<?php echo $listFamily[$i]['families']['lastname'];?>'
															,'<?php echo $listFamily[$i]['families']['education'];?>'
															,'<?php echo $listFamily[$i]['families']['occupation'];?>'
															,'<?php echo $listFamily[$i]['families']['position'];?>')"/>
								</td>
								<td style="text-align:center" class="edit-delete">
									<img src="<?php echo $this->Html->url('/img/icon_del.png');?>" width="16" height="16"
										onclick="deleteFamily('<?php echo $listFamily[$i]['families']['id'];?>')"/>
								</td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				<?php }else {?>
						<table class="table_data_item">
							<tr class="no-found-data">
								<td>ไม่พบข้อมูล</td>
							</tr>
						</table>
				<?php }?>
				
				<input type="button" onclick="openPopupFamily('','','','','','','')" value="เพิ่มข้อมูล ประวัติครอบครัว"/>
			</div>
		</div>
		<div class="container">
			<h2>ประวัติการศึกษา</h2>
			<div class="section_content">
				<?php 
					$countListEducation = empty($listEducation)?0:count($listEducation);
					if( $countListEducation>0 ){
						for($i=0; $i<$countListEducation; $i++){?>
							<table class="table_data_item">
								<tr>
									<td style="width:30%">ระดับ : <?php echo $listEducation[$i]['educations']['edutype'];?></td>
									<td style="width:60%">ชื่อสถาบัน : <?php echo $listEducation[$i]['educations']['name'];?></td>
									<td style="width:10%" class="td_link edit-delete">
										<img src="<?php echo $this->Html->url('/img/icon_edit.png');?>" width="16" height="16"
											onclick="openPopupEducation('<?php echo $listEducation[$i]['educations']['id'];?>'
																		,'<?php echo $listEducation[$i]['educations']['edutype'];?>'
																		,'<?php echo $listEducation[$i]['educations']['name'];?>'
																		,'<?php echo $listEducation[$i]['educations']['faculty'];?>'
																		,'<?php echo $listEducation[$i]['educations']['major'];?>'
																		,'<?php echo $listEducation[$i]['educations']['isGraduate'];?>'
																		,'<?php echo ( (empty($listEducation[$i]['educations']['startyear']))?'':intval($listEducation[$i]['educations']['startyear']) + 543 );?>'
																		,'<?php echo ( (empty($listEducation[$i]['educations']['endyear']))?'':intval($listEducation[$i]['educations']['endyear']) + 543 );?>'
																		,'<?php echo $listEducation[$i]['educations']['gpa'];?>')"/>
										<img src="<?php echo $this->Html->url('/img/icon_del.png');?>" width="16" height="16"
											onclick="deleteEducation('<?php echo $listEducation[$i]['educations']['id'];?>')"/>
									</td>
								</tr>
								<tr>
									<td>คณะ : <?php echo $listEducation[$i]['educations']['faculty'];?></td>
									<td colspan="2">สาขาวิชา : <?php echo ( empty($listEducation[$i]['educations']['major'])?'-':$listEducation[$i]['educations']['major'] );?></td>
								</tr>
								<tr>
									<td>ปีการศึกษา : <?php 
													if( !empty($listEducation[$i]['educations']['startyear'])&&!empty($listEducation[$i]['educations']['endyear']) ){
														if($listEducation[$i]['educations']['isGraduate'] == 1){
															echo ( intval($listEducation[$i]['educations']['startyear']) + 543 ).' - '.( intval($listEducation[$i]['educations']['endyear']) + 543 );
														}else{
															echo ( intval($listEducation[$i]['educations']['startyear']) + 543 ).' - '.( intval(date('Y')) + 543 );
														}
													}
													?></td>
									<td colspan="2">เกรดเฉลี่ย : <?php echo ( empty($listEducation[$i]['educations']['gpa'])?'-':$listEducation[$i]['educations']['gpa'] );?></td>
								</tr>
							</table>
				<?php }
					}else{?>
					<table class="table_data_item">
						<tr class="no-found-data">
							<td>ไม่พบข้อมูล</td>
						</tr>
					</table>
				<?php }?>
				
				<input type="button" onclick="openPopupEducation('','','','','','0','','','')" value="เพิ่มข้อมูล ประวัติการศึกษา"/>
			</div>
		</div>
		<div class="container">
			<h2>ผลงานวิจัย</h2>
			<div class="section_content">
				<?php if( !empty($listResearch) ){
						$countListResearch = empty($listResearch)?0:count($listResearch);
						for( $i=0;$i<$countListResearch;$i++ ){?>
							<table class="table_data_item">
								<colgroup>
									<col style="width:45%;"/>
									<col style="width:55%;"/>
								</colgroup>
								<tr>
									<td>ชื่อเรื่อง : <?php echo $listResearch[$i]['r']['name'];?></td>
									<td class="td_link edit-delete">
										<img src="<?php echo $this->Html->url('/img/icon_edit.png');?>" width="16" height="16"
											onclick="openPopupResearch('<?php echo $listResearch[$i]['r']['id'];?>'
																		,'<?php echo $listResearch[$i]['r']['name'];?>'
																		,'<?php echo $listResearch[$i]['r']['researchtype'];?>'
																		,'<?php echo $listResearch[$i]['r']['advisor'];?>'
																		,'<?php echo $listResearch[$i]['r']['organization'];?>'
																		,'<?php echo $listResearch[$i]['r']['isnotfinish'];?>'
																		,'<?php echo $listResearch[$i]['r']['yearfinish'];?>'
																		,'DUMMY')"/>
										<img src="<?php echo $this->Html->url('/img/icon_del.png');?>" width="16" height="16"
											onclick="deletedResearch('<?php echo $listResearch[$i]['r']['id'];?>')"/>
									</td>
								</tr>
								<tr>
									<td colspan="2">ประเภทของงานวิจัย : <?php echo $listResearch[$i][0]['research_type'];?></td>
								</tr>
								<tr>
									<td>อาจารย์ที่ปรึกษา : <?php echo $listResearch[$i]['r']['advisor'];?></td>
									<td>หน่วยงาน : <?php echo $listResearch[$i]['r']['organization'];?></td>
								</tr>
								<tr>
									<td>ปีที่เสร็จ : <?php echo $listResearch[$i]['r']['yearfinish'];?></td>
									<td>การเผยแพร่ : <?php echo $listResearch[$i]['r']['dissemination'];?></td>
								</tr>
							</table>
						<?php }?>
				<?php }else{?>
					<table class="table_data_item">
						<tr class="no-found-data">
							<td>ไม่พบข้อมูล</td>
						</tr>
					</table>
				<?php }?>
					
				<input type="button" onclick="openPopupResearch('','','','','','','','')" value="เพิ่มข้อมูล ผลงานวิจัย"/>
			</div>
		</div>
		<div class="container">
			<h2>ผลงานอื่นๆ</h2>
			<div class="section_content">
				<table class="table_data_item">
					<tr>
						<td>ชื่อผลงาน : dummy</td>
						<td class="td_link">แก้ไข ลบ</td>
					</tr>
				</table>
				
				<input type="button" value="เเพิ่มข้อมูล ผลงานอื่นๆ"/>
			</div>
		</div>
		<div class="container">
			<h2>รางวัลที่ได้รับ</h2>
			<div class="section_content">
				<?php 
					$countListAward = count($listAward);
					if($countListAward>0){
						for( $i=0;$i<$countListAward;$i++ ){
							echo "<table class=\"table_data_item\">
										<tr>
											<td>ชื่อผลงาน : {$listAward[$i]['a']['name']}</td>
											<td class=\"td_link\">
												<img src=\"{$this->Html->url('/img/icon_edit.png')}\" width=\"16\" height=\"16\"
														onclick=\"openPopupAward('{$listAward[$i]['a']['id']}'
																				,'{$listAward[$i]['a']['name']}'
																				,'{$listAward[$i]['a']['awardname']}'
																				,'{$listAward[$i]['a']['organization']}')\" />
												<img src=\"{$this->Html->url('/img/icon_del.png')}\" width=\"16\" height=\"16\"
														onclick=\"deletedAward('{$listAward[$i]['a']['id']}')\" />
											</td>
										</tr>
										<tr>
											<td>ชื่อรางวัล : {$listAward[$i]['a']['awardname']}</td>
											<td>หน่วยงาน : {$listAward[$i]['a']['organization']}</td>
										</tr>
									</table>";
						}
					} else { 	
						echo "<table class=\"table_data_item\">
								<tr class=\"no-found-data\">
									<td>ไม่พบข้อมูล</td>
								</tr>
							</table>";
					}
				?>
				<input type="button" value="เเพิ่มข้อมูล รางวัลที่ได้รับ" onclick="openPopupAward('','','','')"/>
			</div>
		</div>
		<div class="container">
			<h2>ประวัติการทำงาน</h2>
			<div class="section_content">
				<?php 
					$countListWorkplace = count($listWorkplace);
					if( $countListWorkplace>0 ){
						for( $i=0;$i<$countListWorkplace;$i++ ){
							echo "<table class=\"table_data_item\">
									<tr>
										<td>ตำแหน่ง : {$listWorkplace[$i]['w']['position']}</td>
										<td>ชื่อสถานที่ทำงาน : {$listWorkplace[$i]['w']['name']}</td>
										<td class=\"td_link\">
											<img src=\"{$this->Html->url('/img/icon_edit.png')}\" width=\"16\" height=\"16\"
													onclick=\"openPopupAward('{$listAward[$i]['a']['id']}'
																			,'{$listAward[$i]['a']['name']}'
																			,'{$listAward[$i]['a']['awardname']}'
																			,'{$listAward[$i]['a']['organization']}')\" />
											<img src=\"{$this->Html->url('/img/icon_del.png')}\" width=\"16\" height=\"16\"
													onclick=\"deletedAward('{$listAward[$i]['a']['id']}')\" />
										</td>
									</tr>
									<tr>
										<td>โทรศัพท์ : {$listWorkplace[$i]['w']['telephone']}</td>
										<td>วันที่ทำงาน : {$listWorkplace[$i]['w']['startyear']}</td>
										<td>ถึงวันที่ : {$listWorkplace[$i]['w']['endyear']}</td>
									</tr>
								</table>";
						}
					} else { 	
							echo "<table class=\"table_data_item\">
									<tr class=\"no-found-data\">
										<td>ไม่พบข้อมูล</td>
									</tr>
								</table>";
					}
				?>
				
				<input type="button" value="เพิ่มข้อมูล ประวัติการทำงาน" onclick=" openPopupWorkplace('','','','','','','')"/>
			</div>
		</div>
		<div class="container">
			<h2>ความคิดเห็น</h2>
			<div class="section_content">
				<table class="table_data_item">
					<tr>
						<td>หัวข้อความคิดเห็นที่ : dummy</td>
						<td class="td_link">แก้ไข ลบ</td>
					</tr>
					<tr>
						<td colspan="2">dummy</td>
					</tr>
					<tr>
						<td colspan="2">โดย dummy เมื่อวันที่ dummy</td>
					</tr>
				</table>
			</div>
			
			<h2>เพิ่มความคิดเห็น</h2>
			<div class="section_content">
				<?php if( !empty($listComment) ){?>
					<?php $countListComment = count($listComment);
						for( $i=0;$i<$countListComment;$i++ ){ ?>
							<table class="table_data_item">
								<tr>
									<td style="width: 20%;text-align: right;">หัวข้อ :</td>
									<td style="width: 80%;">
										<input type="text" style="width: 98%;" value="'<?php echo $listComment[$i]['comments']['title'];?>'"></input>
									</td>
								</tr>
								<tr>
									<td style="width: 20%;text-align: right;vertical-align: top;">ความคิดเห็น :</td>
									<td style="width: 80%;">
										<textarea type="text" style="width: 98%;height: 100px;"><?php echo $listComment[$i]['comments']['comment'];?></textarea>
									</td>
								</tr>
							</table>
						<?php }?>
				<?php }else{ ?>
					<table class="table_data_item">
						<tr class="no-found-data">
							<td>ไม่พบข้อมูล</td>
						</tr>
					</table>
				<?php } ?>
				
				<input type="button" value="เพิ่มข้อมูล ความคิดเห็น"/>
			</div>
		</div>
		<!-- Popup -->
		<div id="popup-profile">
		</div>
	</div>
	<div id="activity"> 
		<div class="section_content">
			<?php 
				$countListActivity = count($listActivity);	
				if( $countListActivity>0 ) {
					echo "<table class=\"table_data\">
							<thead>
								<tr>
									<th>ชื่อกิจกรรม</th>
									<th>รับหน้าที่</th>
									<th>วันที่กิจกรรม</th>
									<th>สถานที่จัดกิจกกรม</th>
									<th>ชื่อรุ่น</th>
									<th>รายละเอียดอย่างย่อ</th>
									<th>แก้ไข</th>
									<th>ออกจากิจกกรม</th>
								</tr>
							</thead>
							<tbody>";
							for( $i=0;$i<$countListActivity;$i++ ){
								echo "<tr>
										<td>{$listActivity[$i]['a']['name']}</td>
										<td>{$listActivity[$i]['ja']['position']}</td>
										<td>{$listActivity[$i]['a']['startdtm']}</td>
										<td>{$listActivity[$i]['a']['location']}</td>
										<td>{$listActivity[$i]['a']['genname']}</td>
										<td>{$listActivity[$i]['a']['shortdesc']}</td>
										<td>
											<img src=\"{$this->Html->url('/img/icon_edit.png')}\" width=\"16\" height=\"16\"
												onclick=\"edit_activity({$listActivity[$i]['a']['id']})\" />
										</td>
										<td>
											<img src=\"{$this->Html->url('/img/icon_del.png')}\" width=\"16\" height=\"16\"
												onclick=\"delete_activity({$listActivity[$i]['a']['id']})\" />
										</td>
									<tr>";
							}
					echo 	"</tbody>
						</table>";
			} else { 
				echo "<table class=\"table_data\">
						<tr class=\"no-found-data\">
							<td>ไม่พบข้อมูล</td>
						</tr>
					</table>";
			} ?>
		</div>
	</div>
</div>
