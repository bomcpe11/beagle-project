<div>
	<table class="section-layout" style="width:50%;">
		<tr>
			<td class="form-label">Key Word :</td>
			<td><input id="key_word" type="text" style="width:95%"/></td>
		</tr>
		<tr>
			<td class="form-label">ค้นหาด้วย :</td>
			<td>
				<input name="search_width" type="checkbox" value="nameth"/><lable>ชื่อ</lable>
				<input name="search_width" type="checkbox" value="lastnameth"/><lable>นามสกุล</lable>
				<input name="search_width" type="checkbox" value="nickname"/><lable>ชื่อเล่น</lable>
				<input name="search_width" type="checkbox" value="login"/><lable>Username</lable><br/>
				<input name="search_width" type="checkbox" value="age"/><lable>อายุ</lable>
				<input name="search_width" type="checkbox" value="generation"/><lable>รุ่น</lable>
				<input name="search_width" type="checkbox" value="activities"/><lable>ชื่อกิจกรรมที่เข้าร่วม</lable>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="button" value="ค้นหา" onclick="search_data()"/></td>
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
	function search_data(){
		var key_word = jQuery('#key_word').val();
		var serach_width = '';
		var date = new Date();
		var current_year = date.getFullYear();

		jQuery('input[name="search_width"]').each(function(index,value){
			if( jQuery(this).is(':checked') ){
				if( !serach_width ){
					if( jQuery(this).val()==='age'){
						serach_width = 'YEAR(birthday) = YEAR('+( isNaN(key_word)?0:(current_year-key_word) )+')';
					}else{
						serach_width = ''+jQuery(this).val()+' LIKE \'%'+key_word+'%\'';
					}
				}else{
					if( jQuery(this).val()==='age'){
						serach_width += ' AND YEAR(birthday) = YEAR('+( isNaN(key_word)?0:(current_year-key_word) )+')';
					}else{
						serach_width += ' AND '+jQuery(this).val()+' LIKE \'%'+key_word+'%\'';
					}
				}
			}
		});
		console.log(serach_width);
		if( !key_word ){
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
		if( !serach_width ){
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
		jQuery.post('<?php echo $this->Html->url('/Psearch/search_data');?>'
				,{'data':{'search_width':serach_width}}
				,function(data){
					var count_data = data?data.length:0;
					var html='<table class="table-data">';
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
					if( count_data>0 ){
						for( var i=0;i<count_data;i++ ){
							html+='<tr onclick="go_profile(\''+data[i].profiles.id+'\')">';
							html+='<td>'+data[i].profiles.nameth+'</td>';
							html+='<td>'+data[i].profiles.lastnameth+'</td>';
							html+='<td>'+data[i].profiles.nickname+'</td>';
							html+='<td>'+data[i].profiles.login+'</td>';
							html+='<td>'+get_age(data[i].profiles.birthday)+'</td>';
							html+='<td>'+data[i].profiles.email+'</td>';
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
	function go_profile(id){
		window.location.assign('../Profile/index?id='+id);
	}
	function get_age(birth_day){
		// birth_dat => 2014-01-26
		var split_birth_day = birth_day.split('-');
		var date = new Date();
		var current_year = date.getFullYear();	// Ex. 2014

		return current_year - split_birth_day[0];
	}
</script>