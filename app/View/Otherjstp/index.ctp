<style type="text/css">
/* 	table-data */
table.table-data, table.table-data th, table.table-data td{
border: 1px solid black;
}
table.table-data{
border-collapse:collapse;
}
table.table-data, table.table-data th, table.table-data td{
border: 1px solid black;
}
table.table-data {
width:100%;
}
table.table-data th{
height:30px;
}
table.table-data td{
text-align:left;
}
table.table-data td{
/* height:50px; */
vertical-align:bottom;
}
table.table-data td{
padding:5px;
}
table.table-data, table.table-data td, table.table-data th{
border:1px solid green;
}
table.table-data th{
background-color:green;
color:white;
}
table.table-data tr{
	cursor:pointer;
}
</style>
<div>
	<table class="section-layout" style="width:50%;">
		<tr>
			<td class="form-label">Key Word :</td>
			<td><input id="key_word" type="text" style="width:95%"/></td>
		</tr>
		<tr>
			<td class="form-label">ค้นหาด้วย :</td>
			<td>
				<input name="search_width" type="checkbox" checked="checked" value="nameth"/><lable>ชื่อ</lable>
				<input name="search_width" type="checkbox" checked="checked" value="lastnameth"/><lable>นามสกุล</lable>
				<input name="search_width" type="checkbox" checked="checked" value="nickname"/><lable>ชื่อเล่น</lable>
				<input name="search_width" type="checkbox" checked="checked" value="login"/><lable>Username</lable><br/>
				<input name="search_width" type="checkbox" value="age"/><lable>อายุ</lable>
				<input name="search_width" type="checkbox" value="generation"/><lable>รุ่น</lable>
				<input name="search_width" type="checkbox" value="activities"/><lable>ชื่อกิจกรรมที่เข้าร่วม</lable>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="button" value="ค้นหา" onclick="searchData()"/></td>
		</tr>
	</table>
	<div id="section_search" style="display:none">
		<h2>ผลการค้นหา</h2>
		<div id="search_result"></div>
	</div>
</div>
<!-- ############################################################################################### -->
<script>
	jQuery(document).ready(function(){
		jQuery('input[type="button"]').button();
	});
	/*	------------------------------------------------------------------------------------------------ */
	function searchData(){
		var keyWord = jQuery('#key_word').val();
		var searchWidth = new Array();
		var flagActivity = -1;	// -1 not have activity, 1 have activity

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
		jQuery.post('<?php echo $this->Html->url('/Otherjstp/searchData');?>'
				,{'data':{'keyWord':keyWord
							,'searchWidth':searchWidth
							,'flagActivity':flagActivity}}
				,function(data){
					var countData = data?data.length:0;
					var html='<table class="table-data">';
					html+='<colgroup>';
					html+='<col style="width:15%">';
					html+='<col style="width:15%">';
					html+='<col style="width:10%">';
					html+='<col style="width:20%">';
					html+='<col style="width:10%">';
					html+='<col style="width:30%">';
					html+='</colgroup>';
					
					html+='<thead>';
					html+='<tr>';
					html+='<th>ชื่อ</th>';
					html+='<th>นามสกุล</th>';
					html+='<th>ชื่อเล่น</th>';
					html+='<th>Username</th>';
					html+='<th>อายุ(ปี)</th>';
					html+='<th>email</th>';
					html+='</tr>';
					html+='</thead>';
					
					html+='<tbody>';
					if( countData>0 ){
						for( var i=0;i<countData;i++ ){
							html+='<tr class="hover" onclick="goProfile(\''+data[i].p.id+'\')">';
							html+='<td>'+data[i].p.nameth+'</td>';
							html+='<td>'+data[i].p.lastnameth+'</td>';
							html+='<td>'+data[i].p.nickname+'</td>';
							html+='<td>'+data[i].p.login+'</td>';
							html+='<td>'+getAge(data[i].p.birthday)+'</td>';
							html+='<td>'+data[i].p.email+'</td>';
							html+='</tr>';
						}
					}else{
						html+='<tr>';
						html+='<td colspan="6" style="text-align:center">ไม่พบข้อมูล</td>';
						html+='</tr>';
					}
					html+='</tbody>';
					html+='</table>';

					jQuery('#search_result').html(html);
					jQuery('#section_search').show();

					unloading();			
				}
				,'json');
	}
	/*	------------------------------------------------------------------------------------------------ */
	function goProfile(id){
		window.location.assign('<?php echo $this->Html->url('/PersonalInfo/index?id='); ?>'+id);
	}
	/*	------------------------------------------------------------------------------------------------ */
	function getAge(birthDay){
		// birth_dat => 2014-01-26
		var splitBirthDay = birthDay.split('-');
		var date = new Date();
		var currentYear = date.getFullYear();	// Ex. 2014

		return currentYear - splitBirthDay[0];
	}
</script>