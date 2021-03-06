<style type="text/css">
table.tableLayout, table.tableLayout th, table.tableLayout td{
border: 1px solid black;
}
table.tableLayout{
border-collapse:collapse;
width:100%;
}
table.tableLayout th{
height:30px;
background-color:green;
color:white;
cursor: pointer;
}
table.tableLayout td{
text-align:left;
vertical-align:bottom;
padding:5px;
}
td.hover{
	cursor:pointer;
}
</style>

<?php

?>
<div style="padding:20px;">
	<table class="tableLayout">
		<tr align="center" style="">
			<th width="15%" onclick="chagePage('name', 1)">ชื่อกิจกรรม</th>
			<th width="15%" onclick="chagePage('startdtm', 1)">วันที่จัดกิจกรรม</th>
			<th width="20%" onclick="chagePage('location', 1)">สถานที่จัดกิจกรรม</th>
			<th width="38%" onclick="chagePage('shortdesc', 1)">รายละเอียดอย่างย่อ</th>
			<?php if($isAdmin){ ?>
			<th>แก้ไข</th>
			<th>ลบกิจกรรม</th>
			<?php } ?>
		</tr>
		<?php 
			$countResult = count($result);
			for($i=0; $i<$countResult; $i++){ ?>
		<tr align="center">
			<td><a style="cursor: pointer;" href="<?php echo $this->Html->url('/Activity?id='.$result[$i]["activities"]["id"]);?>" ><?php echo $result[$i]["activities"]["name"] ?></a></td>
			<td>
			<?php 
			if($result[$i]["activities"]["startdtm"] != "" and  $result[$i]["activities"]["enddtm"] != ""){
			$startdtm = $result[$i]["activities"]["startdtm"];
			$enddtm = $result[$i]["activities"]["enddtm"];
			$dateArray=explode('-',$startdtm);
			$enddateArray=explode('-',$enddtm);
			$thai_month_arr=array(  "00"=>"",  
								    "01"=>"ม.ค.",  
								    "02"=>"ก.พ.",  
								    "03"=>"มี.ค.",  
								    "04"=>"เม.ย.",  
								    "05"=>"พ.ค.",  
								    "06"=>"มิ.ย.",   
								    "07"=>"ก.ค.",  
								    "08"=>"ส.ค.",  
								    "09"=>"ก.ย.",  
								    "10"=>"ต.ค.",  
								    "11"=>"พ.ย.",  
								    "12"=>"ธ.ค."                    
								);  
		    echo $dateArray[2].' '.$thai_month_arr[$dateArray[1]].' '.substr(($dateArray[0]+543),-2).'-<br />'.$enddateArray[2].' '.$thai_month_arr[$enddateArray[1]].' '.substr(($enddateArray[0]+543),-2)
		    
			?><?php } ?>
			</td>
			<td><?php echo $result[$i]["activities"]["location"] ?></td>
			<td><?php echo $result[$i]["activities"]["shortdesc"] ?></td>
			<?php if($isAdmin){ ?>
			<td style="text-align:center;"><img style="cursor: pointer; cursor: hand;" onclick="activityEdit('<?php echo $result[$i]["activities"]["id"] ?>');" src="<?php echo $this->Html->url('/img/icon_edit.png'); ?>" width="16" height="16" /></td>
			<td style="text-align:center;">
			<img style="cursor: pointer; cursor: hand;" onclick="deleteData('<?php echo $result[$i]["activities"]["id"] ?>');" src="<?php echo $this->Html->url('/img/icon_del.png'); ?>" width="16" height="16" />
			<input type="hidden" id="idDelete" value="<?php echo $result[$i]["activities"]["id"] ?>"/>
			</td>
			<?php } ?>
		</tr>
		<?php } ?>
		<tr>
			<td colspan="6">
					<div id="pagination" style="margin: auto;"></div>
			</td>
		</tr>
		<tr><td colspan="7"  style="text-align:center;"><input type="button" id="addActivity" onClick="activityAdd();" value="เพิ่มกิจกรรม"  /></td></tr>
	</table>
</div>
<script type="text/javascript">

	jQuery(document).ready(function(){
		/* pagination */
		//jQuery('#pagination').show();
		jQuery('#pagination').smartpaginator({totalrecords: '<?php echo $totalRecord; ?>', 
												recordsperpage: '<?php echo $recordPerPage; ?>', 
												datacontainer: 'divs', 
												dataelement: 'div', 
												initval: '<?php echo $currentPage; ?>', 
												next: 'Next', 
												prev: 'Prev', 
												first: 'First', 
												last: 'Last', 
												theme: 'black',
												onchange: function(newPageValue){
													chagePage('', newPageValue);
												}
											});
	});

	function chagePage(orderBy, currentPage){
		var sort = '';
		var oldOrderBy = '<?php echo $orderBy; ?>';
		var oldSort = '<?php echo $sort; ?>';
		var url = '<?php echo $this->webroot.$this->params['controller']; ?>';
		
		if( orderBy ){
			if( oldOrderBy===orderBy ){
				if( oldSort==='ASC' ){
					sort = 'DESC';
				}else{
					sort = 'ASC';
				}
			}
		}else{
			orderBy = oldOrderBy;
			sort = oldSort;
		}
		url += '?orderBy='+orderBy
				+'&sort='+sort
				+'&currentPage='+currentPage;
		console.log(url);

		window.location.href = url;
	}


	<?php if($isAdmin){ ?>
	function deleteData(id){
		jConfirm('ท่านต้องการลบข้อมูลกิจกรรมนี้ใช่หรือไม่?', 
			function(){ //okFunc
				loading();
				jQuery.ajax({
					type: "POST",
					dataType: 'json',
					url: '<?php echo $this->Html->url('/Activitylist/deleteActivity');?>',
					data: {id:id},
					success: function(data){
						unloading();
						if ( data.status ) {
							jAlert(data.message, 
								function(){
									window.location.replace("<?php echo $this->webroot;?>Activitylist/index");
								}
							);
						} else {
							jAlert(data.message);
						}
					}
				});
			}
		);
	}
		

	function activityAdd(){
		window.location.replace("<?php echo $this->webroot;?>Activity/addactivity");
	}

	function activityEdit(id){
		window.location.replace("<?php echo $this->webroot;?>Activity/editactivity?id="+id);
	}

	<?php } ?>
		
</script>

