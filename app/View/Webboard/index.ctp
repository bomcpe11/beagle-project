<?php 
	//echo $this->Html->css('profile.css');
?>

<script type="text/javascript">
	jQuery(document).ready(function() {
			

	});
	
</script>
<?php

$Per_Page = 10;   // Per Page

// $Page = $_GET["Page"];
// if(!$_GET["Page"])
// {
// 	$Page=1;
// }



//$strSQL .=" order  by QuestionID DESC LIMIT $Page_Start , $Per_Page";
//$objQuery  = mysql_query($strSQL);
?>
<table width="909" border="1">
  <tr>
    <th width="99"> <div align="center">QuestionID</div></th>
    <th width="458"> <div align="center">Question</div></th>
    <th width="90"> <div align="center">Name</div></th>
    <th width="130"> <div align="center">CreateDate</div></th>
    <th width="45"> <div align="center">View</div></th>
    <th width="47"> <div align="center">Reply</div></th>
  </tr>
<?
//while($objResult = mysql_fetch_array($objQuery))
//{
for($i=0; $i<count($webboard_result); $i++){
?>
  <tr>
    <td><div align="center"><?=$webboard_result[$i]['webboards']["QuestionID"];?></div></td>
    <td><a href="ViewWebboard.php?QuestionID=<?=$webboard_result[$i]['webboards']["QuestionID"];?>"><?=$webboard_result[$i]['webboards']["Question"];?></a></td>
    <td><?=$webboard_result[$i]['webboards']["Name"];?></td>
    <td><div align="center"><?=$webboard_result[$i]['webboards']["CreateDate"];?></div></td>
    <td align="right"><?=$webboard_result[$i]['webboards']["View"];?></td>
    <td align="right"><?=$webboard_result[$i]['webboards']["Reply"];?></td>
  </tr>
<?
}
?>
</table>

<br>
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