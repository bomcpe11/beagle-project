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
	$strSQL = "select * from profiles where updforsearchflg=1";
	$result = mysql_query($strSQL);
	return $result;
	
}


$db_config = new DATABASE_CONFIG();

// echo "<pre>"; print_r($db_config->default); echo "</pre>";

$objConnect = mysql_connect($db_config->default['host'],$db_config->default['login'],$db_config->default['password']) or die("Error Connect to Database");

mysql_query("SET character_set_results=utf8", $objConnect);
$objDB = mysql_select_db($db_config->default['database']);
mysql_query("set names 'utf8'",$objConnect);

// $strSQL = "select * from profiles where updforsearchflg=1";

// $objQuery = mysql_query($strSQL) or die ("Error Query : ".mysql_error()."<br />".$strSQL);

$result = retriveProfiles($objConnect);


$prepareData = array();
$keyword = "";

//TODO: Prepare Data.
while($objResult = mysql_fetch_assoc($result)){
	//echo "<p><pre>"; print_r($objResult); echo "</pre></p>";
	$keyword = $objResult['nameth']
				.'|'.$objResult['lastnameth']
				.'|'.$objResult['nameeng']
				.'|'.$objResult['lastnameeng'];
	array_push($prepareData, array("isExist"=>true, "typeid"=>"1", "dataid"=>$objResult['id'], "keyword"=>$keyword, "objdata"=>json_encode($objResult)));
}

echo "<p><pre>"; print_r($prepareData); echo "</pre></p>";

//TODO: Update & Insert.


echo "----END-----";
?>