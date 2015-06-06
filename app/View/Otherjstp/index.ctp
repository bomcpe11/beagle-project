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
				<input name="search_width" type="checkbox" value="generation"/><lable>รุ่น</lable>
				<input name="search_width" type="checkbox" value="activities" style="display:none;"/><lable style="display:none;">ชื่อกิจกรรมที่เข้าร่วม</lable>
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
                
<div style="display:none;">
<?php if($isAdmin){ ?>
<div id="user-custom">
	<div class="lblmembername" style="padding:7px 0 7px 0;"></div>
	<input type="hidden" class="params" value="" />
	<table>
	<tr>
		<td>สิทธิ์ในการใช้งานเว็บ : </td>
		<td><select name="role">
			<?php for ( $i = 0; $i < count($accountRole); $i++ ) { ?>
				<option value="<?php echo $accountRole[$i]['gvars']['varcode'];?>"><?php echo $accountRole[$i]['gvars']['vardesc1'];?></option>
			<?php } ?>
		</select></td>
	</tr>
	<tr>
		<td>สิทธิ์ Admin : </td>
		<td><select name="roleadmin"><option value="0">ไม่ใช่</option><option value="1">Admin</option>
			<?php if($isSuperAdmin){ ?><option value="2">Super Admin</option><?php } ?>
			</select></td>
	</tr>
	<tr>
		<td>ลบสมาชิก : </td>
		<td><input type="button" class="btnremovemember" value="ลบ" /></td>
	</tr>
	</table>
</div>
<?php } ?>
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
		jQuery.post('<?php echo $this->Html->url('/Otherjstp/searchData');?>'
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
					<?php if($isAdmin){ ?>html+='<col>';<?php } ?>
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
					<?php if($isAdmin){ ?>html+='<th>Admin</th>';<?php } ?>
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
									<?php if($isAdmin){ ?>
									,role_admin: response.data[i].p.role_admin
									<?php } ?>
										};
							html+='<tr params="'+escape(JSON.stringify(params))+'">';
							html+='<td class="hover openprofile">'+response.data[i].p.nameth+'</td>';
							html+='<td class="hover openprofile">'+response.data[i].p.lastnameth+'</td>';
							html+='<td class="hover openprofile">'+response.data[i].p.nickname+'</td>';
							html+='<td class="hover openprofile">'+( (response.data[i].p.generation)? response.data[i].p.generation: '' )+'</td>';
							html+='<td class="hover openprofile">'+( (response.data[i].p.login)? response.data[i].p.login: '' )+'</td>';
							html+='<td class="hover openprofile">'+getAge(response.data[i].p.birthday)+'</td>';
							html+='<td class="hover openprofile">'+response.data[i].p.email+'</td>';
							<?php if($isAdmin){ ?>html+='<td style="text-align:center;"><img src="<?php echo $this->webroot; ?>img/custom.png" class="btncustom" style="cursor:pointer;" /></td>';<?php } ?>
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
						html+='<td colspan="<?php echo $isAdmin?'8':7; ?>" style="text-align:center">ไม่พบข้อมูล</td>';
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
					<?php if($isAdmin){ ?>
					jQuery('.btncustom').unbind('click').click(function(){
						customize_openpopup(this);
					});
					jQuery('.btnremovemember').unbind('click').click(function(){
						remove_member();
					});
					<?php } ?>
			
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
        var win = window.open('<?php echo $this->Html->url('/PersonalInfo/index?id='); ?>'+params.id, '_blank');
        win.focus();
	}
	<?php if($isAdmin){ ?>
	function customize_openpopup(t){
		var _params = jQuery(t).closest('tr').attr('params');
		var params = jQuery.parseJSON(unescape(_params));
		
		var html = '#user-custom';
		var buttons = [
		   			{text: "Save", click: function(){
			   				var container = jQuery('#user-custom');
			   				var params = jQuery.parseJSON(unescape(container.find('input.params').val()));
			   				var data = {profileid: params.id,
					   				profilerole: container.find('select[name="role"]').val(),
					   				profileroleadmin: container.find('select[name="roleadmin"]').val()};

// 							console.log(params);
// 							console.log(data);
// 							return;
			   				
			   				loading();
			   				jQuery.post("<?php echo $this->Html->url('/Otherjstp/admin_updateCustomize');?>", data,
		   						function(data) {
									if ( data.result.status ) {
										searchData();
										jAlert(data.result.message
												, function(){ 
													jQuery('#user-custom').dialog("close");
												}//okFunc	
												, function(){ 
												}//openFunc
												, function(){ 		
												}//closeFunc
										);// jAlert
									}//if else
									else{
										jAlert(data.result.message
												, function(){ 
													
												}//okFunc	
												, function(){ 
												}//openFunc
												, function(){ 		
												}//closeFunc
										);// jAlert
									}
	
									unloading();
								}// function(data)
								, "json").error(function() {
								}// function()
							);// jQuery.post
			   				
// 			   				console.log(data);
			   			}}
		];
		jQuery(html).css('width', '400px').find('input.params').val(_params);
		jQuery(html).find('.lblmembername').html('<h3>'+params.name+' '+params.lastname+'</h3>');
		openPopupHtml('Member Customize', html, buttons, 
				function(){ //openFunc
					//TODO: set default role, role_admin
					var container = jQuery('#user-custom');
					var params = jQuery.parseJSON(unescape(container.find('input.params').val()));
// 					alert(params.role);
					//role, roleadmin
					container.find('select[name="role"]').val(params.role);
					//console.log(parseInt(params.role_admin, 10));
					if(parseInt(params.role_admin, 10)==2){
						container.find('select[name="roleadmin"]').val('2');
					}else if(parseInt(params.role_admin, 10)==1){
						container.find('select[name="roleadmin"]').val('1');
					}else{
						container.find('select[name="roleadmin"]').val('0');
					}
				}, 
				function(){ //closeFunc
// 					alert('closed');
					var container = jQuery('#user-custom');
					container.find('input.params').val('');
					container.find('.lblmembername').html('');
				}
		);
		// Example to close with script ==> closePopup('#jdialog1-container');
	}
	function remove_member(){

		jConfirm('ต้องการลบสมาชิกคนนี้ ?', 
				function(){ //okFunc
				var container = jQuery('#user-custom');
				var params = jQuery.parseJSON(unescape(container.find('input.params').val()));
	
				var data = {profileid: params.id};
	
				jQuery.post("<?php echo $this->Html->url('/Otherjstp/admin_removeProfile');?>", data,
					function(data) {
							if ( data.result.status ) {
								searchData();
								jAlert(data.result.message
										, function(){ 
											jQuery('#user-custom').dialog("close");
										}//okFunc	
										, function(){ 
										}//openFunc
										, function(){ 		
										}//closeFunc
								);// jAlert
							}//if else
							else{
								jAlert(data.result.message
										, function(){ 
											
										}//okFunc	
										, function(){ 
										}//openFunc
										, function(){ 		
										}//closeFunc
								);// jAlert
							}
		
							unloading();
						}// function(data)
						, "json").error(function() {
						}// function()
					);// jQuery.post
				}, 
				function(){ //cancelFunc
				}, 
				function(){ //openFunc
				}, 
				function(){ //closeFunc
				}
			);
// 		});

		
	}
	<?php } ?>
</script>