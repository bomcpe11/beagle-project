<style type="text/css">
table.table-data, table.table-data th, table.table-data td{
	border: 1px solid black;
	/* border:1px solid green; */
}
table.table-data{
	border-collapse:collapse;
	width:100%;
}
table.table-data th{
	height:30px;
	background-color:green;
	color:white;
	cursor: pointer;
}
table.table-data td{
	text-align:left;
	vertical-align:bottom;
	padding:5px;
}
td.hover{
	cursor:pointer;
}
.right{
	text-align:right;
}
</style>
<div style="display:none;">
	<div id="popupForm" style="width:1000px;" >
		<div class="input">
			<fieldset>
			<legend>ข้อมูลผู้สมัครคัดเลือก</legend>
			<table>
				<tr>
					<td class="right">รหัสประจำตัว : </td>
					<td><input type="text" id="id_come" name="comming[id_come]" /></td>
					<td class="right">หมายเหตุ : </td>
					<td colspan="3"><input type="text" id="ps" name="comming[ps]" /></td>
				</tr>
				<tr>
					<td class="right">คำนำหน้าชื่อ : </td>
					<td><input type="text" id="before_name" name="comming[before_name]" /></td>
					<td class="right">ชื่อ : </td>
					<td><input type="text" id="first_name" name="comming[first_name]" /></td>
					<td class="right">นามสกุล : </td>
					<td><input type="text" id="family_name" name="comming[family_name]" /></td>
				</tr>
				<tr>
					<td class="right">เลขบัตรประจำตัวประชาชน : </td>
					<td><input type="text" id="card_id" name="comming[card_id]" /></td>
					<td class="right">ชื่อเล่น : </td>
					<td><input type="text" id="nickname" name="comming[nickname]" /></td>
					<td class="right">เพศ : </td>
					<td><input type="text" id="sex" name="comming[sex]" /></td>
				</tr>
				<tr>
					<td class="right">วัน/เดือน/ปี เกิด : </td>
					<td><input type="text" id="birthday" name="comming[birthday]" class="birthDatePicker" /></td>
					<td class="right">อายุ : </td>
					<td><input type="text" id="year" name="comming[year]" /></td>
				</tr>
				<tr>
					<td class="right">ชื่อ-นามสกุล บิดา : </td>
					<td><input type="text" id="father" name="comming[father]" /></td>
					<td class="right">อาชีพของบิดา : </td>
					<td><input type="text" id="father_career" name="comming[father_career]" /></td>
				</tr>
				<tr>
					<td class="right">ชื่อ-นามสกุล มารดา : </td>
					<td><input type="text" id="mother" name="comming[mother]" /></td>
					<td class="right">อาชีพของมารดา : </td>
					<td><input type="text" id="mother_career" name="comming[mother_career]" /></td>
				</tr>
				<tr>
					<td class="right">ที่อยู่ บ้านเลขที่ : </td>
					<td><input type="text" id="address" name="comming[address]" /></td>
					<td class="right">หมู่ที่ : </td>
					<td><input type="text" id="address2" name="comming[address2]" /></td>
					<td class="right">ซอย/ถนน : </td>
					<td><input type="text" id="address3" name="comming[address3]" /></td>
				</tr>
				<tr>
					<td class="right">ถนน : </td>
					<td><input type="text" id="street" name="comming[street]" /></td>
					<td class="right">ตำบล : </td>
					<td><input type="text" id="locality" name="comming[locality]" /></td>
					<td class="right">อำเภอ : </td>
					<td><input type="text" id="district" name="comming[district]" /></td>
				</tr>
				<tr>
					<td class="right">จังหวัด : </td>
					<td><input type="text" id="province_id" name="comming[province_id]" /></td>
					<td class="right">รหัสไปรษณีย์ : </td>
					<td><input type="text" id="zip_code" name="comming[zip_code]" /></td>
				</tr>
				<tr>
					<td class="right">โทรศัพท์ : </td>
					<td><input type="text" id="telephone" name="comming[telephone]" /></td>
					<td class="right">โทรศัพท์มือถือ : </td>
					<td><input type="text" id="mobilephone" name="comming[mobilephone]" /></td>
					<td class="right">โทรสาร : </td>
					<td><input type="text" id="fax" name="comming[fax]" /></td>
				</tr>
				<tr>
					<td class="right">E-mail : </td>
					<td><input type="text" id="email" name="comming[email]" /></td>
				</tr>
				<tr>
					<td class="right">ผู้ปกครองที่ให้ติดต่อได้ : </td>
					<td><input type="text" id="contact_parent" name="comming[contact_parent]" /></td>
					<td class="right">เกี่ยวข้องเป็น : </td>
					<td><input type="text" id="relation" name="comming[relation]" /></td>
					<td class="right">โทรศัพท์ที่ติดต่อได้สะดวก<br />(ผู้ปกครอง) : </td>
					<td><input type="text" id="parent_phone" name="comming[parent_phone]" /></td>
				</tr>
				<tr>
					<td class="right">ระดับการศึกษา : </td>
					<td><input type="text" id="level_education" name="comming[level_education]" /></td>
					<td class="right">โรงเรียน : </td>
					<td><input type="text" id="school" name="comming[school]" /></td>
				</tr>
				<tr>
					<td class="right">โรงเรียนระดับประถมศึกษา : </td>
					<td><input type="text" id="primary_school" name="comming[primary_school]" /></td>
				</tr>
				<tr>
					<td class="right">หัวข้อโครงการวิทยาศาสตร์ : </td>
					<td><input type="text" id="project" name="comming[project]" /></td>
				</tr>
				<tr>
					<td class="right">เคยสมัครเข้าร่วมโครงการมาก่อน : </td>
					<td><input type="text" id="spply" name="comming[spply]" /></td>
					<td class="right">สมัคร ปี/ผล : </td>
					<td><input type="text" id="result" name="comming[result]" /></td>
				</tr>
				<tr>
					<td class="right">การได้รับข้อมูล : </td>
					<td><input type="text" id="infor" name="comming[infor]" /></td>
					<td class="right">ระบุ : </td>
					<td><input type="text" id="infor2" name="comming[infor2]" /></td>
				</tr>
				<tr>
					<td colspan="2" align="center"><input type="button" value="เพิ่มรายชื่อ" onclick="submit_addnewrecruit(this);" /> 
					<input type="button" onclick="clearForm(this);" value="ล้าง Input" /></td>
				</tr>
			</table>
			</fieldset>
		</div>
	</div>
</div>


<div>
	<table class="section-layout" style="width:50%;">
		<tr>
			<td class="form-label">KeyWord :</td>
			<td><input id="key_word" type="text" style="width:95%"/></td>
		</tr>
		<tr>
			<td class="form-label">ค้นหาด้วย :</td>
			<td>
				<input name="search_width" type="checkbox" checked="checked" value="first_name"/><lable>ชื่อ</lable>
				<input name="search_width" type="checkbox" checked="checked" value="family_name"/><lable>นามสกุล</lable>
				<input name="search_width" type="checkbox" checked="checked" value="nickname"/><lable>ชื่อเล่น</lable>
				<input name="search_width" type="checkbox" value="year"/><lable>อายุ</lable>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="button" value="ค้นหา" onclick="searchData('1', 'first_name', '0');"/></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td></td>
			<td><input type="button" value="เพิ่มรายชื่อผุ้สมัคร" onclick="popup_open('#popupForm');"/></td>
		</tr>
	</table>
	<div id="section_search">
		<h2>ผลการค้นหา</h2>
		<div id="search_result"></div>
		
		<div id="pagination" style="margin: auto;">
        </div>
	</div>

</div>
<!-- ############################################################################################### -->

<script type="text/javascript">
	var g_orderByOld = '';
	var g_sortOld = '';
	jQuery(document).ready(function(){
		jQuery('input[type="button"]').button();

		jQuery('#key_word').val('*');
		searchData('1', 'first_name', '0');
	});
	/*	------------------------------------------------------------------------------------------------ */
	function searchData(currentPage, orderBy, typeSearch){
		var keyWord = jQuery('#key_word').val();
		var searchWidth = new Array();
		var flagActivity = -1;	// -1 not have activity, 1 have activity
		var sort = '';
		/**
		* *** toggle order by ***
		* typeSearch, 
		* [0] = click main search
		* [1] = click pagginh
		* [2] = click <th> for order by 
		*/
		if( typeSearch==='0' ){
			sort = 'ASC';
			
			g_orderByOld = orderBy;
			g_sortOld = sort;
		}else if( typeSearch==='1' ){
			sort = g_sortOld;
		}else if( typeSearch==='2' ){
			if( g_orderByOld===orderBy ){
				sort = 'DESC';
				if( g_sortOld===sort ){ // inverse value
					sort = 'ASC';
				}else{
					sort = 'DESC';
				}
			}else{
				sort = 'ASC';
			}
			
			g_orderByOld = orderBy;
			g_sortOld = sort;
		}
		
		// inverse where ordery by birthday
		if( orderBy==='birthday' ){
			if( sort==='ASC' ){
				sort = 'DESC';
			}else{
				sort = 'ASC';
			}
		}
		
		
		
		jQuery('input[name="search_width"]').each(function(i,e){
			if( jQuery(e).prop('checked') ){
				searchWidth.push(jQuery(e).val());
				if( jQuery(e).val()==='activities' ){
					flagActivity = 1;
				}
			}
		});
		//console.log(serach_width);
		
		if( !keyWord ){
			jAlert('กรุณาระบุ Key Word', 
					function(){ //okFunc
					}, 
					function(){ //openFunc
					}, 
					function(){ //closeFunc
					}
					);

			return;
		}
		if( !searchWidth ){
			jAlert('กรุณาเลือก วิธีการค้นหา', 
					function(){ //okFunc
					}, 
					function(){ //openFunc
					}, 
					function(){ //closeFunc
					}
					);

			return;
		}
		

		loading();
		jQuery.post('<?php echo $this->Html->url('/Recruitment/searchData');?>'
				,{'data':{'keyWord':keyWord
							,'searchWidth':searchWidth
							,'flagActivity':flagActivity
							,'currentPage':currentPage
							,'orderBy':orderBy
							,'sort':sort}}
				,function(response){
					/* var countData = data?data.length:0; */
					var countData = response.data.length;
					var html='<table class="table-data">';
					html+='<colgroup>';
					html+='<col style="width: 8%;">';
					html+='<col style="width: 25%;">';
					html+='<col style="width: 25%;">';
					html+='<col style="width: 5%;">';
					html+='<col style="width: 7%;">';
					html+='<col style="width: 15%;">';
					html+='<col style="width: 15%;">';
					html+='</colgroup>';
					
					html+='<thead>';
					html+='<tr>';
					html+='<th onclick="searchData(\'1\', \'before_name\', \'2\')">คำนำหน้า</th>';
					html+='<th onclick="searchData(\'1\', \'first_name\', \'2\')">ชื่อ</th>';
					html+='<th onclick="searchData(\'1\', \'family_name\', \'2\')">นามสกุล</th>';
					html+='<th onclick="searchData(\'1\', \'nickname\', \'2\')">ชื่อเล่น</th>';
					html+='<th onclick="searchData(\'1\', \'year\', \'2\')">อายุ(ปี)</th>';
					html+='<th >จังหวัด</th>';
					html+='<th onclick="searchData(\'1\', \'spply\', \'2\')">เคยสมัครเข้าร่วมโครงการ</th>';
					html+='</tr>';
					html+='</thead>';
					
					html+='<tbody>';
					if( response.total_data>0 ){
						var params = {};
						for( var i=0;i<countData;i++ ){
							params = {
									id: response.data[i].p.id
									,name: response.data[i].p.first_name
									,lastname: response.data[i].p.family_name
										};
							html+='<tr params="'+escape(JSON.stringify(params))+'">';
							html+='<td class="hover openprofile" style="text-align:center">'+response.data[i].p.before_name+'</td>';
							html+='<td class="hover openprofile">'+response.data[i].p.first_name+'</td>';
							html+='<td class="hover openprofile">'+response.data[i].p.family_name+'</td>';
							html+='<td class="hover openprofile" style="text-align:center">'+response.data[i].p.nickname+'</td>';
							html+='<td class="hover openprofile" style="text-align:center">'+response.data[i].p.year+'</td>';
							html+='<td class="hover openprofile" style="text-align:center">'+response.data[i].p.province_id+'</td>';
							html+='<td class="hover openprofile" style="text-align:center">'+response.data[i].p.spply+'</td>';
							html+='</tr>';
						}

						/* pagination */
						jQuery('#pagination').show();
						jQuery('#pagination').smartpaginator({totalrecords: response.total_data, 
																recordsperpage: response.record_per_page, 
																datacontainer: 'divs', 
																dataelement: 'div', 
																initval: currentPage, 
																next: 'Next', 
																prev: 'Prev', 
																first: 'First', 
																last: 'Last', 
																theme: 'black',
																onchange: function(newPageValue){
																	searchData(newPageValue, orderBy, '1');
																} 
															});
					}else{
						html+='<tr>';
						html+='<td colspan="7" style="text-align:center">ไม่พบข้อมูล</td>';
						html+='</tr>';

						/* pagination */
						jQuery('#pagination').hide();
					}
					html+='</tbody>';
					html+='</table>';

					jQuery('#search_result').html(html);

					jQuery('.openprofile').unbind('click');
					jQuery('.openprofile').click(function(){
						gotoProfile(this);
					});
			
					jQuery('#section_search').show();

					unloading();			
				}
				,'json');
	}

	/*	------------------------------------------------------------------------------------------------ */
	function getAge(birthDay){
		// birth_dat => 2014-01-26
		var splitBirthDay = birthDay.split('-');
		var date = new Date();
		var currentYear = date.getFullYear();	// Ex. 2014

		return currentYear - splitBirthDay[0];
	}
	function gotoProfile(t){
		var params = jQuery.parseJSON(unescape(jQuery(t).closest('tr').attr('params')));
// 		console.log(params);
        var win = window.open('<?php echo $this->Html->url('/Recruitment/view?id='); ?>'+params.id, '_blank');
        win.focus();
	}

	function clearForm(t){
		var input_container = jQuery(t).closest("div.input");

		input_container.find('input:text').val('');
		input_container.find('select').val('');
	}

	function popup_open(id){
		var buttons = [
		               {
			               text: "บันทึก", click: function() {
			            	   editProfile();
			               }
		               }
		       		];

		openPopupHtml("แก้ไขข้อมูลส่วนตัว", id, buttons, 
				function(){ //openFunc
					setBirthDatePicker(".birthDatePicker");
				}, 
				function(){ //closeFunc
				}
		);
	}
	
	function submit_addnewrecruit(t){
		var input_container = jQuery(t).closest("div.input");
		var params = input_container.find('input, select').serializeArray();

		jQuery.post( "<?php echo $this->Html->url('/Recruitment/save'); ?>", params, function(data){ console.log(data); }, 'json');
	}
	
</script>