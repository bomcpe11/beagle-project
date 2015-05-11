<?php 
function DateThai($strDate)
{
	$strYear = date("Y",strtotime($strDate))+543;
	$strMonth= date("n",strtotime($strDate));
	$strDay= date("j",strtotime($strDate));
	$strHour= date("H",strtotime($strDate));
	$strMinute= date("i",strtotime($strDate));
	$strSeconds= date("s",strtotime($strDate));
	$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	$strMonthThai=$strMonthCut[$strMonth];
	return "$strDay $strMonthThai $strYear";
}

?>
<TABLE x:str width="891">
<TR>
	<?php 
		foreach($result[0]['recruits'] as $key=>$value){
			echo '<td bgcolor="#EBDDE2">'.$key.'</td>';
			if($key=='อำเภอ') echo '<td bgcolor="#EBDDE2">จังหวัด</td>';
			if($key=='ระดับการศึกษา') echo '<td bgcolor="#EBDDE2">โรงเรียน</td>';
		}
	?>
</TR>
<?php foreach($result as $row){ ?>
<TR>
	<?php 
		foreach($row['recruits'] as $key=>$value){ 
			if($key=='วัน/เดือน/ปี เกิด') $value = DateThai($value);
			echo '<td>'.$value.'</td>';
			if($key=='อำเภอ') echo '<td>'.$row['provinces']['name'].'</td>';
			if($key=='ระดับการศึกษา') echo '<td>'.$row['schools']['name'].'</td>';
		} 
	?>
</TR>
<?php } ?>
</TABLE>