<?php
header('Content-Type: text/html; charset=utf-8');

include "../../Config/database.php";

//*** Start Transaction ***//
// mysql_query("BEGIN");

//*** Commit Transaction ***//
// mysql_query("COMMIT")

//*** RollBack Tranasction ***//
// mysql_query("ROLLBACK")

function retriveProfiles($objConnect){
	//Combine data with awards, educations, families, otherworks, researches, workplaces
	$strSQL = "select * from profiles where updforsearchflg=1";
	$result = mysql_query($strSQL);
	return $result;
}
function retriveAwards($objConnect, $profileId){
	$strSQL = "select * from awards where profile_id=".$profileId;
	$result = mysql_query($strSQL);
	$arr = array();
	while($row = mysql_fetch_assoc($result)){
		array_push($arr, $row);
	}
	return $arr;
}
function retriveEducations($objConnect, $profileId){
	$strSQL = "select * from educations where profile_id=".$profileId;
	$result = mysql_query($strSQL);
	$arr = array();
	while($row = mysql_fetch_assoc($result)){
		array_push($arr, $row);
	}
	return $arr;
}
function retriveFamilies($objConnect, $profileId){
	$strSQL = "select * from families where profile_id=".$profileId;
	$result = mysql_query($strSQL);
	$arr = array();
	while($row = mysql_fetch_assoc($result)){
		array_push($arr, $row);
	}
	return $arr;
}
function retriveOtherworks($objConnect, $profileId){
	$strSQL = "select * from otherworks where profile_id=".$profileId;
	$result = mysql_query($strSQL);
	$arr = array();
	while($row = mysql_fetch_assoc($result)){
		array_push($arr, $row);
	}
	return $arr;
}
function retriveResearches($objConnect, $profileId){
	$strSQL = "select * from researches where profile_id=".$profileId;
	$result = mysql_query($strSQL);
	$arr = array();
	while($row = mysql_fetch_assoc($result)){
		array_push($arr, $row);
	}
	return $arr;
}
function retriveWorkplaces($objConnect, $profileId){
	$strSQL = "select * from workplaces where profile_id=".$profileId;
	$result = mysql_query($strSQL);
	$arr = array();
	while($row = mysql_fetch_assoc($result)){
		array_push($arr, $row);
	}
	return $arr;
}

function retriveActivities($objConnect){
	$strSQL = "select * from activities where updforsearchflg=1";
	$result = mysql_query($strSQL);
	return $result;
}

function retriveWebboard($objConnect){
	$strSQL = "select * from webboards where updforsearchflg=1";
	$result = mysql_query($strSQL);
	return $result;
}

function insertSearchKeyword($objConnect, $obj){
	$strSQL = "insert into searchkeywords (typeid, dataid, keyword, objdata)
			values (".$obj['typeid'].", ".$obj['dataid'].", '".$obj['keyword']."', '".mysql_escape_string($obj['objdata'])."')";
	mysql_query($strSQL);
}
function updateSearchKeyword($objConnect, $obj){
	$strSQL = "update searchkeywords
			set keyword='".$obj['keyword']."'
				,objdata='".mysql_escape_string($obj['objdata'])."'
			where typeid=".$obj['typeid']." and dataid=".$obj['dataid']."";
	mysql_query($strSQL);
}


$db_config = new DATABASE_CONFIG();

// echo "<pre>"; print_r($db_config->default); echo "</pre>";

$objConnect = mysql_connect($db_config->default['host'],$db_config->default['login'],$db_config->default['password']) or die("Error Connect to Database");

mysql_query("SET character_set_results=utf8", $objConnect);
$objDB = mysql_select_db($db_config->default['database']);
mysql_query("set names 'utf8'",$objConnect);

// $strSQL = "select * from profiles where updforsearchflg=1";

// $objQuery = mysql_query($strSQL) or die ("Error Query : ".mysql_error()."<br />".$strSQL);



$prepareData = array();
$keyword = "";
$isExist = true;

//TODO: Prepare Data.
$result = retriveProfiles($objConnect);
while($objResult = mysql_fetch_assoc($result)){
	//echo "<p><pre>"; print_r($objResult); echo "</pre></p>";
	mysql_query("BEGIN");
	$keyword = $objResult['nameth']
				.'|'.$objResult['lastnameth']
				.'|'.$objResult['nameeng']
				.'|'.$objResult['lastnameeng'];
	
	$strSQL = "select count(1) from searchkeywords where typeid=1 and dataid=".$objResult['id'];
	$rsCheckExist = mysql_query($strSQL);
	$rowCheckExist = mysql_fetch_row($rsCheckExist);
	$rowCount = intval($rowCheckExist[0]);
	
	$isExist = ($rowCount>0?true:false);
	
	$objResult['awards'] = retriveAwards($objConnect, $objResult['id']);
	foreach ($objResult['awards'] as $value){
		$keyword .= '|'.$value['name']
					.'|'.$value['awardname']
					.'|'.$value['organization'];
	}
	
	$objResult['educations'] = retriveEducations($objConnect, $objResult['id']);
	foreach ($objResult['educations'] as $value){
		$keyword .= '|'.$value['name']
					.'|'.$value['faculty']
					.'|'.$value['major'];
	}
	
	$objResult['families'] = retriveFamilies($objConnect, $objResult['id']);
	foreach ($objResult['families'] as $value){
		$keyword .= '|'.$value['name']
					.'|'.$value['lastname']
					.'|'.$value['education']
					.'|'.$value['occupation']
					.'|'.$value['position'];
	}
	
	$objResult['otherworks'] = retriveOtherworks($objConnect, $objResult['id']);
	foreach ($objResult['otherworks'] as $value){
// 		echo "<p><pre>"; print_r($value); echo "</pre></p>";
		$keyword .= '|'.$value['name']
					.'|'.$value['organization']
					.'|'.$value['detail'];
	}
	
	$objResult['researches'] = retriveResearches($objConnect, $objResult['id']);
	foreach ($objResult['researches'] as $value){
		$keyword .= '|'.$value['name']
					.'|'.$value['advisor']
					.'|'.$value['organization']
					.'|'.$value['dissemination']
					.'|'.$value['detail'];
	}
	
	$objResult['workplaces'] = retriveWorkplaces($objConnect, $objResult['id']);
	foreach ($objResult['workplaces'] as $value){
		$keyword .= '|'.$value['name']
					.'|'.$value['telephone']
					.'|'.$value['position'];
	}
	
	$objData = array("isExist"=>$isExist, "typeid"=>"1", "dataid"=>$objResult['id'], "keyword"=>$keyword, "objdata"=>json_encode($objResult));
	if($isExist){
		updateSearchKeyword($objConnect, $objData);
		echo "Update : profileId=".$objResult['id']." : Success<br />";
	}else{
		insertSearchKeyword($objConnect, $objData);
		echo "Insert : profileId=".$objResult['id']." : Success<br />";
	}
	$strSQL = "update profiles set updforsearchflg=0, searchupddtm=now() where id=".$objResult['id'];
	mysql_query($strSQL);
	mysql_query("COMMIT");
}


$result = retriveActivities($objConnect);
while($objResult = mysql_fetch_assoc($result)){
	//echo "<p><pre>"; print_r($objResult); echo "</pre></p>";
	mysql_query("BEGIN");
	$keyword = $objResult['name']
	.'|'.$objResult['location']
	.'|'.strip_tags($objResult['shortdesc'])
	.'|'.strip_tags($objResult['longdesc'])
	.'|'.strip_tags($objResult['summary']);

	$strSQL = "select count(1) from searchkeywords where typeid=2 and dataid=".$objResult['id'];
	$rsCheckExist = mysql_query($strSQL);
	$rowCheckExist = mysql_fetch_row($rsCheckExist);
	$rowCount = intval($rowCheckExist[0]);

	$isExist = ($rowCount>0?true:false);

	$objData = array("isExist"=>$isExist, "typeid"=>"2", "dataid"=>$objResult['id'], "keyword"=>$keyword, "objdata"=>json_encode($objResult));
	if($isExist){
		updateSearchKeyword($objConnect, $objData);
		echo "Update : activityId=".$objResult['id']." : Success<br />";
	}else{
		insertSearchKeyword($objConnect, $objData);
		echo "Insert : activityId=".$objResult['id']." : Success<br />";
	}
	$strSQL = "update activities set updforsearchflg=0, searchupddtm=now() where id=".$objResult['id'];
	mysql_query($strSQL);
	mysql_query("COMMIT");
}

// echo "<p><pre>"; print_r($prepareData); echo "</pre></p>";

//TODO: Update & Insert.


echo "----END-----";
?>