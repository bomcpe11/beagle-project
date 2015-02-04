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
</style>
<div>
	<table class="section-layout" style="width:50%;">
		<tr>
			<td class="form-label">KeyWord :</td>
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
			</td>
		</tr>
		<tr>
			<td></td>
			<td><input type="button" value="ค้นหา" onclick="searchData('1', 'nameth', '0');"/></td>
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
		searchData('1', 'nameth', '0');
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
					html+='<col style="width: 15%;">';
					html+='<col style="width: 15%;">';
					html+='<col style="width: 5%;">';
					html+='<col style="width: 5%;">';
					html+='<col>';
					html+='<col style="width: 10%;">';
					html+='<col style="width: 30%;">';
					html+='</colgroup>';
					
					html+='<thead>';
					html+='<tr>';
					html+='<th onclick="searchData(\'1\', \'nameth\', \'2\')">ชื่อ</th>';
					html+='<th onclick="searchData(\'1\', \'lastnameth\', \'2\')">นามสกุล</th>';
					html+='<th onclick="searchData(\'1\', \'nickname\', \'2\')">ชื่อเล่น</th>';
					html+='<th onclick="searchData(\'1\', \'generation\', \'2\')">รุ่นที่</th>';
					html+='<th onclick="searchData(\'1\', \'login\', \'2\')">Username</th>';
					html+='<th onclick="searchData(\'1\', \'birthday\', \'2\')">อายุ(ปี)</th>';
					html+='<th onclick="searchData(\'1\', \'email\', \'2\')">email</th>';
					html+='</tr>';
					html+='</thead>';
					
					html+='<tbody>';
					if( response.total_data>0 ){
						var params = {};
						for( var i=0;i<countData;i++ ){
							params = {
									id: response.data[i].p.id
									,name: response.data[i].p.nameth
									,lastname: response.data[i].p.lastnameth
									,role: response.data[i].p.role
										};
							html+='<tr params="'+escape(JSON.stringify(params))+'">';
							html+='<td class="hover openprofile">'+response.data[i].p.nameth+'</td>';
							html+='<td class="hover openprofile">'+response.data[i].p.lastnameth+'</td>';
							html+='<td class="hover openprofile">'+response.data[i].p.nickname+'</td>';
							html+='<td class="hover openprofile">'+( (response.data[i].p.generation)? response.data[i].p.generation: '' )+'</td>';
							html+='<td class="hover openprofile">'+( (response.data[i].p.login)? response.data[i].p.login: '' )+'</td>';
							html+='<td class="hover openprofile">'+getAge(response.data[i].p.birthday)+'</td>';
							html+='<td class="hover openprofile">'+response.data[i].p.email+'</td>';
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
	
</script>