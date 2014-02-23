<div>
	<table class="section-layout" style="width:80%;">
		<tr>
			<td class="form-label">Key Word :</td>
			<td><input id="key_word" type="text" style="width:95%"/></td>
		</tr>
		<tr>
			<td class="form-label">ค้นหาด้วย :</td>
			<td>
				<input name="search_width" type="checkbox" value="name"/><lable>ชื่อกิจกรรม</lable>
				<input name="search_width" type="checkbox" value="genname"/><lable>ชื่อรุ่น</lable>
				<input name="search_width" type="checkbox" value="location"/><lable>สถานที่จัดกิจกรรม</lable>
				<input name="search_width" type="checkbox" value="startdtm"/><lable>วันที่จัดกิจกกรม</lable>
				<input name="search_width" type="checkbox" value="shortdesc"/><lable>ข้อความในรายละเอียดกิจกรรม</lable>
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
					serach_width = 'a.'+jQuery(this).val()+' LIKE \'%'+key_word+'%\'';
				}else{
					serach_width += ' OR a.'+jQuery(this).val()+' LIKE \'%'+key_word+'%\'';
				}
			}
		});
		//console.log(serach_width);
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
		jQuery.post('<?php echo $this->Html->url('/Asearch/search');?>'
				,{'data':{'search_width':serach_width}}
				,function(data){
					var count_data = data?data.length:0;
					var html='<table class="table-data">';
					html+='<col style="width:24%">';
					html+='<col style="width:11%">';
					html+='<col style="width:20%">';
					html+='<col style="width:5%">';
					html+='<col style="width:25%">';
					html+='<col style="width:15%">';
					html+='<thead>';
					html+='<tr>';
					html+='<th>ชื่อกิจกรรม</th>';
					html+='<th>วันที่จัดกิจกรรม</th>';
					html+='<th>สถานที่จัดกิจกรรม</th>';
					html+='<th>ชื่อรุ่น</th>';
					html+='<th>รายละเอียดอย่างย่อ</th>';
					html+='<th></th>';
					html+='</tr>';
					html+='</thead>';
					
					html+='<tbody>';
					if( count_data>0 ){
						for( var i=0;i<count_data;i++ ){
							html+='<tr>';
							html+='<td><a href="<?php echo $this->Html->url('/Activity/index'); ?>?id='+data[i].a.id+'">'+data[i].a.name+'<a></td>';
							html+='<td>'+( (data[i].a.startdtm && data[i].a.enddtm)?data[i].a.startdtm+'\n-'+data[i].a.enddtm:'-')+'</td>';
							html+='<td>'+( data[i].a.location?data[i].a.location:'-' )+'</td>';
							html+='<td>'+( data[i].a.ganname?data[i].a.ganname:'-' )+'</td>';
							html+='<td>'+( data[i].a.shortdesc?data[i].a.shortdesc:'-' )+'</td>';
							if( data[i][0].flag_joind_activity ){
								html+='<td><input disabled id="btn_join_activity'+data[i].a.id+'" type="button" value="เข้าร่วมกิจกรรมนี้" onclick="open_popup_activity('+data[i].a.id+')"/></td>';
							}else{
								html+='<td><input id="btn_join_activity'+data[i].a.id+'" type="button" value="เข้าร่วมกิจกรรมนี้" onclick="open_popup_activity('+data[i].a.id+')"/></td>';
							}
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

					jQuery('input[type="button"]').button();
					
					unloading();			
				}
				,'json');
	}
	function change_format_date_db(date){
		// yyyy-mm-dd
		var split_date = date?date.split('-'):'';
		
		return split_date.length===3?split_date[2]+'/'+split_date[1]+'/'+(parseInt(split_date[0])+543):'-';
	}
</script>
<?php 
	include 'popup_activity.ctp';
?>