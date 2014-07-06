<?php 
	//echo $this->Html->css('profile.css');
	function toThaiDtm($dtm){
		if(!empty($dtm)){
			$dtmArray=explode(' ',$dtm);
			$dateArray=explode('-',$dtmArray[0]);
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
			return $dateArray[2].' '.$thai_month_arr[$dateArray[1]].' '.substr(($dateArray[0]+543),-2)." ".$dtmArray[1];
		}
	}
?>

<script type="text/javascript">
	jQuery(document).ready(function() {
			

	});
	
</script>
<style type="text/css">
table.webboard th,table.webboard td{
	padding: 0 5px;
}
</style>
<div style="padding:5px;">
<h2 style="margin-bottom: 10px;">Webboard</h2>
<hr />
<a href="<?=$this->Html->url('/Webboard/newTopic')?>">+ New Topic</a>
<hr />
<table class="webboard" border="1" bordercolor="#eeeeee">
  <tr>
    <th> <div align="center">QuestionID</div></th>
    <th> <div align="center">Question</div></th>
    <th> <div align="center">Name</div></th>
    <th> <div align="center">CreateDate</div></th>
    <th> <div align="center">View</div></th>
    <th> <div align="center">Reply</div></th>
  </tr>
<?
for($i=0; $i<count($webboard_result); $i++){
?>
  <tr>
    <td><div align="center"><?=$webboard_result[$i]['webboards']["QuestionID"];?></div></td>
    <td><a href="<?=$this->Html->url('/Webboard/viewWebboard')?>?QuestionID=<?=$webboard_result[$i]['webboards']["QuestionID"];?>"><?=$webboard_result[$i]['webboards']["Question"];?></a></td>
    <td><?=$webboard_result[$i]['webboards']["Name"];?></td>
    <td><div align="center"><?=toThaiDtm($webboard_result[$i]['webboards']["CreateDate"]);?></div></td>
    <td align="center"><?=$webboard_result[$i]['webboards']["View"];?></td>
    <td align="center"><?=$webboard_result[$i]['webboards']["Reply"];?></td>
  </tr>
<?
}
?>
</table>

<br>
<hr />
Total <?= $Num_Rows;?> Record : <?=$Num_Pages;?> Page :
<?
if($Prev_Page)
{
	echo ' <a href="'.$this->Html->url('/Webboard/index').'?Page='.$Prev_Page.'"><< Back</a> ';
}

for($i=1; $i<=$Num_Pages; $i++){
	if($i != $Page)
	{
		echo '[ <a href="'.$this->Html->url('/Webboard/index').'?Page='.$i.'">'.$i.'</a> ]';
	}
	else
	{
		echo '<b> '.$i.' </b>';
	}
}
if($Page!=$Num_Pages)
{
	echo ' <a href ="'.$this->Html->url('/Webboard/index').'?Page='.$Next_Page.'">Next>></a> ';
}
?>
</div>