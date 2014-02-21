<?php 
	//echo $this->Html->css('profile.css');
?>

<script type="text/javascript">
	jQuery(document).ready(function() {
			

	});
	
</script>
[WEBBOARD]
<?php

$Per_Page = 10;   // Per Page

// $Page = $_GET["Page"];
// if(!$_GET["Page"])
// {
// 	$Page=1;
// }

$Prev_Page = $Page-1;
$Next_Page = $Page+1;

$Page_Start = (($Per_Page*$Page)-$Per_Page);
if($Num_Rows<=$Per_Page)
{
	$Num_Pages =1;
}
else if(($Num_Rows % $Per_Page)==0)
{
	$Num_Pages =($Num_Rows/$Per_Page) ;
}
else
{
	$Num_Pages =($Num_Rows/$Per_Page)+1;
	$Num_Pages = (int)$Num_Pages;
}

$strSQL .=" order  by QuestionID DESC LIMIT $Page_Start , $Per_Page";
$objQuery  = mysql_query($strSQL);
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
while($objResult = mysql_fetch_array($objQuery))
{
?>
  <tr>
    <td><div align="center"><?=$objResult["QuestionID"];?></div></td>
    <td><a href="ViewWebboard.php?QuestionID=<?=$objResult["QuestionID"];?>"><?=$objResult["Question"];?></a></td>
    <td><?=$objResult["Name"];?></td>
    <td><div align="center"><?=$objResult["CreateDate"];?></div></td>
    <td align="right"><?=$objResult["View"];?></td>
    <td align="right"><?=$objResult["Reply"];?></td>
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
	echo " <a href='$_SERVER[SCRIPT_NAME]?Page=$Prev_Page'><< Back</a> ";
}

for($i=1; $i<=$Num_Pages; $i++){
	if($i != $Page)
	{
		echo "[ <a href='$_SERVER[SCRIPT_NAME]?Page=$i'>$i</a> ]";
	}
	else
	{
		echo "<b> $i </b>";
	}
}
if($Page!=$Num_Pages)
{
	echo " <a href ='$_SERVER[SCRIPT_NAME]?Page=$Next_Page'>Next>></a> ";
}