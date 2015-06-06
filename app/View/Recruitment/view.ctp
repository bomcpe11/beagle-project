<?php
function setSelected($val1, $val2){
	if($val1==$val2) $selected='selected="selected"';
	else $selected='';
	return $selected;
}
function setChecked($val1){
	if(!empty($val1))
		return ' checked="checked" ';
}
?><style type="text/css">
.right{
	text-align:right;
}
</style>
<script type="text/javascript">
<?php 
	/*$tmp_schools = $schools;
	$schools_obj = array();
	$schools = array();
	foreach($tmp_schools as $row){
		array_push($schools, $row['t']['name']);
		//array_push($schools_obj, $row['t']['name']);
		$schools_obj[$row['t']['name']] = $row['t']['id'];
		$schools_obj[$row['t']['id']] = $row['t']['name'];
	}
	
	$recruit = $recruit[0]['recruits'][0]['recruits'];*/

	$tmp_schools = $schools;
	$schools = array();
	foreach($tmp_schools as $row){
		//array_push($schools, $row['t']['name']);
// 		if($row['t']['id']=='11') break;
		array_push($schools, array('id'=>$row['t']['id'], 'text'=>$row['t']['name']));
	}
	
?>
var schools = <?=json_encode($schools)?>;
</script>
<h2 style="padding:10px 0 10px 15px;"><?=$recruit[0]['recruits']['before_name'].' '.$recruit[0]['recruits']['first_name'].' '.$recruit[0]['recruits']['family_name']?></h2>
<form action="<?=$this->Html->url('/Recruitment/save?recruitid='.$_REQUEST['recruitid'])?>" method="post">
	<div class="input">
		<fieldset>
		<legend>ข้อมูลผู้สมัครคัดเลือก</legend>
		<table>
			<tr>
				<td class="right">รหัสประจำตัว : </td>
				<td><input class="required" type="text" id="id_come" name="recruit[id_come]" value="<?=$recruit[0]['recruits']['id_come']?>" /></td>
				<td class="right">หมายเหตุ : </td>
				<td colspan="3"><input type="text" id="ps" name="recruit[ps]" value="<?=$recruit[0]['recruits']['ps']?>" /></td>
			</tr>
			<tr>
				<td class="right">คำนำหน้าชื่อ : </td>
				<td><select id="before_name" name="recruit[before_name]">
					<option value="">--กรุณาเลือก--</option>
				<?php 
					foreach($namePrefixs as $row){
						echo '<option value="'.$row['gvars']['vardesc1'].'" '.setSelected($recruit[0]['recruits']['before_name'], $row['gvars']['vardesc1']).'>'.$row['gvars']['vardesc1'].'</option>';
					}
				?>
				</select></td>
				<td class="right">ชื่อ : </td>
				<td><input class="required" type="text" id="first_name" name="recruit[first_name]" value="<?=$recruit[0]['recruits']['first_name']?>" /></td>
				<td class="right">นามสกุล : </td>
				<td><input class="required" type="text" id="family_name" name="recruit[family_name]" value="<?=$recruit[0]['recruits']['family_name']?>" /></td>
			</tr>
			<tr>
				<td class="right">เลขบัตรประจำตัวประชาชน : </td>
				<td><input class="required" type="text" id="card_id" name="recruit[card_id]" value="<?=$recruit[0]['recruits']['card_id']?>" /></td>
				<td class="right">ชื่อเล่น : </td>
				<td><input class="required" type="text" id="nickname" name="recruit[nickname]" value="<?=$recruit[0]['recruits']['nickname']?>" /></td>
				<td class="right">เพศ : </td>
				<td><select id="sex" name="recruit[sex]">
					<option value="">--กรุณาเลือก--</option>
				<?php 
					foreach($sexs as $row){
						echo '<option value="'.$row['gvars']['vardesc1'].'" '.setSelected($recruit[0]['recruits']['sex'], $row['gvars']['vardesc1']).'>'.$row['gvars']['vardesc1'].'</option>';
					}
				?>
				</select></td>
			</tr>
			<tr>
				<td class="right">วัน/เดือน/ปี เกิด : </td>
				<td><input class="required birthDatePicker" type="text" id="birthday" name="recruit[birthday]" value="<?=$recruit[0]['recruits']['birthday']?>" readonly="readonly" /></td>
				<td class="right">อายุ : </td>
				<td><input type="text" id="year" name="recruit[year]" value="<?=$recruit[0]['recruits']['year']?>" /></td>
			</tr>
			<tr>
				<td class="right">ชื่อ-นามสกุล บิดา : </td>
				<td><input class="required" type="text" id="father" name="recruit[father]" value="<?=$recruit[0]['recruits']['father']?>" /></td>
				<td class="right">อาชีพของบิดา : </td>
				<td colspan="2"><select id="father_career" name="recruit[father_career]">
					<option value="">--กรุณาเลือก--</option>
				<?php 
					foreach($careers as $row){
						echo '<option value="'.$row['gvars']['vardesc1'].'" '.setSelected($recruit[0]['recruits']['father_career'], $row['gvars']['vardesc1']).'>'.$row['gvars']['vardesc1'].'</option>';
					}
				?>
				</select></td>
			</tr>
			<tr>
				<td class="right">ชื่อ-นามสกุล มารดา : </td>
				<td><input class="required" type="text" id="mother" name="recruit[mother]" value="<?=$recruit[0]['recruits']['mother']?>" /></td>
				<td class="right">อาชีพของมารดา : </td>
				<td colspan="2"><select id="mother_career" name="recruit[mother_career]">
					<option value="">--กรุณาเลือก--</option>
				<?php 
					foreach($careers as $row){
						echo '<option value="'.$row['gvars']['vardesc1'].'" '.setSelected($recruit[0]['recruits']['mother_career'], $row['gvars']['vardesc1']).'>'.$row['gvars']['vardesc1'].'</option>';
					}
				?>
				</select></td>
			</tr>
			<tr>
				<td class="right">ที่อยู่ บ้านเลขที่ : </td>
				<td><input class="required" type="text" id="address" name="recruit[address]" value="<?=$recruit[0]['recruits']['address']?>" /></td>
				<td class="right">หมู่ที่ : </td>
				<td><input class="required" type="text" id="address2" name="recruit[address2]" value="<?=$recruit[0]['recruits']['address2']?>" /></td>
				<td class="right">ซอย/ถนน : </td>
				<td><input type="text" id="address3" name="recruit[address3]" value="<?=$recruit[0]['recruits']['address3']?>" /></td>
			</tr>
			<tr>
				<td class="right">ถนน : </td>
				<td><input type="text" id="street" name="recruit[street]" value="<?=$recruit[0]['recruits']['street']?>" /></td>
				<td class="right">ตำบล : </td>
				<td><input class="required" type="text" id="locality" name="recruit[locality]" value="<?=$recruit[0]['recruits']['locality']?>" /></td>
				<td class="right">อำเภอ : </td>
				<td><input class="required" type="text" id="district" name="recruit[district]" value="<?=$recruit[0]['recruits']['district']?>" /></td>
			</tr>
			<tr>
				<td class="right">จังหวัด : </td>
				<td><select class="required" id="province_id" name="recruit[province_id]">
					<option value="">--กรุณาเลือก--</option>
				<?php 
					foreach ($provinces as $row){
						echo '<option value="'.$row['t']['id'].'" '.setSelected($recruit[0]['recruits']['province_id'], $row['t']['id']).'>'.$row['t']['name'].'</option>';
					}
				?>
				</select></td>
				<td class="right">รหัสไปรษณีย์ : </td>
				<td><input class="required" type="text" id="zip_code" name="recruit[zip_code]" value="<?=$recruit[0]['recruits']['zip_code']?>" /></td>
			</tr>
			<tr>
				<td class="right">โทรศัพท์ : </td>
				<td><input type="text" id="telephone" name="recruit[telephone]" value="<?=$recruit[0]['recruits']['telephone']?>" /></td>
				<td class="right">โทรศัพท์มือถือ : </td>
				<td><input class="required" type="text" id="mobilephone" name="recruit[mobilephone]" value="<?=$recruit[0]['recruits']['mobilephone']?>" /></td>
				<td class="right">โทรสาร : </td>
				<td><input type="text" id="fax" name="recruit[fax]" value="<?=$recruit[0]['recruits']['fax']?>" /></td>
			</tr>
			<tr>
				<td class="right">E-mail : </td>
				<td><input class="required" type="text" id="email" name="recruit[email]" value="<?=$recruit[0]['recruits']['email']?>" /></td>
			</tr>
			<tr>
				<td class="right">ผู้ปกครองที่ให้ติดต่อได้ : </td>
				<td><input class="required" type="text" id="contact_parent" name="recruit[contact_parent]" value="<?=$recruit[0]['recruits']['contact_parent']?>" /></td>
				<td class="right">เกี่ยวข้องเป็น : </td>
				<td><input class="required" type="text" id="relation" name="recruit[relation]" value="<?=$recruit[0]['recruits']['relation']?>" /></td>
				<td class="right">โทรศัพท์ที่ติดต่อได้สะดวก<br />(ผู้ปกครอง) : </td>
				<td><input class="required" type="text" id="parent_phone" name="recruit[parent_phone]" value="<?=$recruit[0]['recruits']['parent_phone']?>" /></td>
			</tr>
			<tr>
				<td class="right">ระดับการศึกษา : </td>
				<td><select class="required" id="level_education" name="recruit[level_education]">
					<option value="">--กรุณาเลือก--</option>
				<?php 
					foreach($educations as $row){
						echo '<option value="'.$row['gvars']['vardesc1'].'" '.setSelected($recruit[0]['recruits']['level_education'], $row['gvars']['vardesc1']).'>'.$row['gvars']['vardesc1'].'</option>';
					}
				?>
				</select></td>
				<td class="right">โรงเรียน : </td>
				<td colspan="3">
					<!-- $schools_obj[$recruit[0]['recruits']['school']] -->
					<input type="hidden" id="school" name="recruit[school]" style="width:300px;" />
					<!--input type="text" class="required" id="school" name="recruit[school]" value="<?php echo $schools_obj[$recruit[0]['recruits']['school']]; ?>" style="width:200px;" /-->
				</td>
			</tr>
			<tr>
				<td class="right">โรงเรียนระดับประถมศึกษา : </td>
				<td><input class="required" type="text" id="primary_school" name="recruit[primary_school]" value="<?=$recruit[0]['recruits']['primary_school']?>" /></td>
			</tr>
			<tr>
				<td class="right">หัวข้อโครงการวิทยาศาสตร์ : </td>
				<td><input type="text" id="project" name="recruit[project]" value="<?=$recruit[0]['recruits']['project']?>" /></td>
			</tr>
			<tr>
				<td class="right">เคยสมัครเข้าร่วมโครงการมาก่อน : </td>
				<td><input type="checkbox" id="spply" name="recruit[spply]" value="1" <?=setChecked($recruit[0]['recruits']['spply'])?> /></td>
				<td class="right">สมัคร ปี/ผล : </td>
				<td><input type="text" id="result" name="recruit[result]" value="<?=$recruit[0]['recruits']['result']?>" /></td>
			</tr>
			<tr>
				<td class="right">การได้รับข้อมูล : </td>
				<td><select id="infor" name="recruit[infor]">
					<option value="">--กรุณาเลือก--</option>
				<?php 
					foreach($infors as $row){
						echo '<option value="'.$row['gvars']['vardesc1'].'" '.setSelected($recruit[0]['recruits']['infor'], $row['gvars']['vardesc1']).'>'.$row['gvars']['vardesc1'].'</option>';
					}
				?>
				</select></td>
				<td class="right">ระบุ : </td>
				<td><input type="text" id="infor2" name="recruit[infor2]" value="<?=$recruit[0]['recruits']['infor']?>" /></td>
			</tr>
			<tr>
				<td class="right">ผ่านการคัดเลือก : </td>
				<td><input type="checkbox" value="1" id="status" name="recruit[status]" <?=setChecked($recruit[0]['recruits']['status'])?> /></td>
			</tr>
			<?php if(!empty($recruit[0]['recruits']['status'])){ ?>
			<tr>
				<td class="right"></td>
				<td><a href="<?=$this->Html->url('/PersonalInfo/index?id='.$recruit[0]['recruits']['profileid'])?>">JSTP Personal Info</a></td>
			</tr>
			<?php } ?>
			<tr>
				<td colspan="6" align="center"><input type="button" disabled="disabled" value="บันทึก" /><br /><br />
					<?php if(empty($recruit[0]['recruits']['status'])){ ?>
					<input type="button" onclick="submit_addnewmember('<?=$recruit[0]['recruits']['id']?>')" value="ผ่านการคัดเลือก นำรายชื่อเข้าสู่ระบบ" />
					<?php }else{ ?>
					<input type="button" onclick="submit_unmember('<?=$recruit[0]['recruits']['id']?>', '<?=$recruit[0]['recruits']['profileid']?>')" value="ไม่ผ่านการคัดเลือก นำรายชื่อออกจากระบบ JSTP" />
					<?php } ?>
					<input type="button" disabled="disabled" value="ลบประวัติผู้สมัคร" />
				</td>
			</tr>
		</table>
		</fieldset>
	</div>
</form>

<form action="<?=$this->Html->url('/Recruitment/savecomment?recruitid='.$_REQUEST['recruitid'])?>" method="post">
	<div class="input">
		<fieldset>
		<legend>ความคิดเห็น</legend>
		<table width="80%">
			<tr>
				<td style="text-align: right;width:100px;">หัวข้อ :</td>
				<td>
					<input type="text" id="comment_title" style="width: 98%;" value=""></input>
					<input type="hidden" name="comment_recruitid" value="<?=$_REQUEST['recruitid']?>" />
				</td>
			</tr>
			<tr>
				<td style="text-align: right;vertical-align: top;">ความคิดเห็น :</td>
				<td>
					<textarea type="text" id="comment_detial" style="width: 98%;height: 100px;"></textarea>
				</td>
			</tr>
			<tr>
				<td colspan="2"><input type="button" disabled="disabled" value="เพิ่มความคิดเห็น" /></td>
			</tr>
		</table>
		</fieldset>
	</div>
</form>


<script type="text/javascript">
jQuery(document).ready(function(){

	setRequiredField();
	
	jQuery('.birthDatePicker').width('100px');
	setBirthDatePicker(".birthDatePicker");

	jQuery('#school').select2({data:schools,placeholder:"ค้นหาชื่อโรงเรียน"});

});

function setRequiredField(){
	var input_container = jQuery("div.input");
	var required_inputs = input_container.find('.required');

	required_inputs.closest("td").prev().prepend('*');
	
}

function submit_addnewmember(id){
	
	var data = {id: id};
	loading();
	jQuery.post("<?=$this->Html->url('/Recruitment/addnewmember_submit')?>", 
			data,
			function(data) {
				if ( data.result.status ) {
					jAlert(data.result.message
							, function(){ 
								loading();
								window.location.reload();
							}//okFunc	
							, function(){ 
							}//openFunc
							, function(){ 		
							}//closeFunc
					);// jAlert
				}else{
					jAlert(data.result.message
							, function(){ 
							}//okFunc	
							, function(){ 
							}//openFunc
							, function(){ 		
							}//closeFunc
					);
				}
	
				unloading();
			}// function(data)
			, "json").error(function() {
				jAlert('Ajax Error : add new member');
				unloading();
			}// function()
	);// jQuery.post
}

function submit_unmember(id, profileid){
	
	var data = {id: id, profileid: profileid};
	loading();
	jQuery.post("<?=$this->Html->url('/Recruitment/unmember_submit')?>", 
			data,
			function(data) {
				if ( data.result.status ) {
					jAlert(data.result.message
							, function(){ 
								loading();
								window.location.reload();
							}//okFunc	
							, function(){ 
							}//openFunc
							, function(){ 		
							}//closeFunc
					);// jAlert
				}else{
					jAlert(data.result.message
							, function(){ 
							}//okFunc	
							, function(){ 
							}//openFunc
							, function(){ 		
							}//closeFunc
					);
				}
	
				unloading();
			}// function(data)
			, "json").error(function() {
				jAlert('Ajax Error : un member');
				unloading();
			}// function()
	);// jQuery.post
}


</script>