<style type="text/css">
.right{
	text-align:right;
}
</style>
<script type="text/javascript">
<?php 
	$tmp_schools = $schools;
	$schools = array();
	foreach($tmp_schools as $row){
		array_push($schools, $row['t']['name']);
	}
?>
var schools = <?=json_encode($schools)?>;
</script>
<div style="display:none;">
	<div id="popupForm" >
		<div class="input">
			<fieldset>
			<legend>ข้อมูลผู้สมัครคัดเลือก</legend>
			<table>
				<tr>
					<td class="right">รหัสประจำตัว : </td>
					<td><input class="required" type="text" id="id_come" name="recruit[id_come]" /></td>
					<td class="right">หมายเหตุ : </td>
					<td colspan="3"><input type="text" id="ps" name="recruit[ps]" /></td>
				</tr>
				<tr>
					<td class="right">คำนำหน้าชื่อ : </td>
					<td><select id="before_name" name="recruit[before_name]">
						<option value="">--กรุณาเลือก--</option>
					<?php 
						foreach($namePrefixs as $row){
							echo '<option value="'.$row['gvars']['varcode'].'">'.$row['gvars']['vardesc1'].'</option>';
						}
					?>
					</select></td>
					<td class="right">ชื่อ : </td>
					<td><input class="required" type="text" id="first_name" name="recruit[first_name]" /></td>
					<td class="right">นามสกุล : </td>
					<td><input class="required" type="text" id="family_name" name="recruit[family_name]" /></td>
				</tr>
				<tr>
					<td class="right">เลขบัตรประจำตัวประชาชน : </td>
					<td><input class="required" type="text" id="card_id" name="recruit[card_id]" /></td>
					<td class="right">ชื่อเล่น : </td>
					<td><input class="required" type="text" id="nickname" name="recruit[nickname]" /></td>
					<td class="right">เพศ : </td>
					<td><select id="sex" name="recruit[sex]">
						<option value="">--กรุณาเลือก--</option>
					<?php 
						foreach($sexs as $row){
							echo '<option value="'.$row['gvars']['varcode'].'">'.$row['gvars']['vardesc1'].'</option>';
						}
					?>
					</select></td>
				</tr>
				<tr>
					<td class="right">วัน/เดือน/ปี เกิด : </td>
					<td><input class="required birthDatePicker" type="text" id="birthday" name="recruit[birthday]" readonly="readonly" /></td>
					<td class="right">อายุ : </td>
					<td><input type="text" id="year" name="recruit[year]" /></td>
				</tr>
				<tr>
					<td class="right">ชื่อ-นามสกุล บิดา : </td>
					<td><input class="required" type="text" id="father" name="recruit[father]" /></td>
					<td class="right">อาชีพของบิดา : </td>
					<td><select id="father_career" name="recruit[father_career]">
						<option value="">--กรุณาเลือก--</option>
					<?php 
						foreach($careers as $row){
							echo '<option value="'.$row['gvars']['varcode'].'">'.$row['gvars']['vardesc1'].'</option>';
						}
					?>
					</select></td>
				</tr>
				<tr>
					<td class="right">ชื่อ-นามสกุล มารดา : </td>
					<td><input class="required" type="text" id="mother" name="recruit[mother]" /></td>
					<td class="right">อาชีพของมารดา : </td>
					<td><select id="mother_career" name="recruit[mother_career]">
						<option value="">--กรุณาเลือก--</option>
					<?php 
						foreach($careers as $row){
							echo '<option value="'.$row['gvars']['varcode'].'">'.$row['gvars']['vardesc1'].'</option>';
						}
					?>
					</select></td>
				</tr>
				<tr>
					<td class="right">ที่อยู่ บ้านเลขที่ : </td>
					<td><input class="required" type="text" id="address" name="recruit[address]" /></td>
					<td class="right">หมู่ที่ : </td>
					<td><input class="required" type="text" id="address2" name="recruit[address2]" /></td>
					<td class="right">ซอย/ถนน : </td>
					<td><input type="text" id="address3" name="recruit[address3]" /></td>
				</tr>
				<tr>
					<td class="right">ถนน : </td>
					<td><input type="text" id="street" name="recruit[street]" /></td>
					<td class="right">ตำบล : </td>
					<td><input class="required" type="text" id="locality" name="recruit[locality]" /></td>
					<td class="right">อำเภอ : </td>
					<td><input class="required" type="text" id="district" name="recruit[district]" /></td>
				</tr>
				<tr>
					<td class="right">จังหวัด : </td>
					<td><select class="required" id="province_id" name="recruit[province_id]">
						<option value="">--กรุณาเลือก--</option>
					<?php 
						foreach ($provinces as $row){
							echo '<option value="'.$row['t']['id'].'">'.$row['t']['name'].'</option>';
						}
					?>
					</select></td>
					<td class="right">รหัสไปรษณีย์ : </td>
					<td><input class="required" type="text" id="zip_code" name="recruit[zip_code]" /></td>
				</tr>
				<tr>
					<td class="right">โทรศัพท์ : </td>
					<td><input type="text" id="telephone" name="recruit[telephone]" /></td>
					<td class="right">โทรศัพท์มือถือ : </td>
					<td><input class="required" type="text" id="mobilephone" name="recruit[mobilephone]" /></td>
					<td class="right">โทรสาร : </td>
					<td><input type="text" id="fax" name="recruit[fax]" /></td>
				</tr>
				<tr>
					<td class="right">E-mail : </td>
					<td><input class="required" type="text" id="email" name="recruit[email]" /></td>
				</tr>
				<tr>
					<td class="right">ผู้ปกครองที่ให้ติดต่อได้ : </td>
					<td><input class="required" type="text" id="contact_parent" name="recruit[contact_parent]" /></td>
					<td class="right">เกี่ยวข้องเป็น : </td>
					<td><input class="required" type="text" id="relation" name="recruit[relation]" /></td>
					<td class="right">โทรศัพท์ที่ติดต่อได้สะดวก<br />(ผู้ปกครอง) : </td>
					<td><input class="required" type="text" id="parent_phone" name="recruit[parent_phone]" /></td>
				</tr>
				<tr>
					<td class="right">ระดับการศึกษา : </td>
					<td><select class="required" id="level_education" name="recruit[level_education]">
						<option value="">--กรุณาเลือก--</option>
					<?php 
						foreach($educations as $row){
							echo '<option value="'.$row['gvars']['varcode'].'">'.$row['gvars']['vardesc1'].'</option>';
						}
					?>
					</select></td>
					<td class="right">โรงเรียน : </td>
					<td colspan="3"><input type="text" class="required" id="school" name="recruit[school]" style="width:300px;" /></td>
				</tr>
				<tr>
					<td class="right">โรงเรียนระดับประถมศึกษา : </td>
					<td><input class="required" type="text" id="primary_school" name="recruit[primary_school]" /></td>
				</tr>
				<tr>
					<td class="right">หัวข้อโครงการวิทยาศาสตร์ : </td>
					<td><input type="text" id="project" name="recruit[project]" /></td>
				</tr>
				<tr>
					<td class="right">เคยสมัครเข้าร่วมโครงการมาก่อน : </td>
					<td><input type="checkbox" id="spply" name="recruit[spply]" value="1" /></td>
					<td class="right">สมัคร ปี/ผล : </td>
					<td><input type="text" id="result" name="recruit[result]" /></td>
				</tr>
				<tr>
					<td class="right">การได้รับข้อมูล : </td>
					<td><select id="infor" name="recruit[infor]">
						<option value="">--กรุณาเลือก--</option>
					<?php 
						foreach($infors as $row){
							echo '<option value="'.$row['gvars']['varcode'].'">'.$row['gvars']['vardesc1'].'</option>';
						}
					?>
					</select></td>
					<td class="right">ระบุ : </td>
					<td><input type="text" id="infor2" name="recruit[infor2]" /></td>
				</tr>
			</table>
			</fieldset>
		</div>
	</div>
</div>

<pre><?php 
print_r($recruit);
?></pre>