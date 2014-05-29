<?php
header('Content-Type: text/html; charset=utf-8');

include "../../Config/database.php";


function retriveProfiles($objConnect){
	$strSQL = "insert into searchkeywords (typeid, dataid, keyword) 
select 1, t.id, 
			concat(ifnull(t.nameth,'')
				,'|',ifnull(t.lastnameth,'')
				,'|',ifnull(t.nameeng,'')
				,'|',ifnull(t.lastnameeng,'')
			) as keyword from profiles t 
		where updforsearchflg=1
on duplicate key update keyword=values(keyword)";

	$result = mysql_query($strSQL);
	if($result){
		
		$strSQL = "update profiles set updforsearchflg=0, searchupddtm=now() where updforsearchflg=1";
		$result = mysql_query($strSQL);
	}
}


$db_config = new DATABASE_CONFIG();

// echo "<pre>"; print_r($db_config->default); echo "</pre>";

$objConnect = mysql_connect($db_config->default['host'],$db_config->default['login'],$db_config->default['password']) or die("Error Connect to Database");

mysql_query("SET character_set_results=utf8", $objConnect);
$objDB = mysql_select_db($db_config->default['database']);
mysql_query("set names 'utf8'",$objConnect);

// $strSQL = "select * from profiles where updforsearchflg=1";

// $objQuery = mysql_query($strSQL) or die ("Error Query : ".mysql_error()."<br />".$strSQL);

retriveProfiles($objConnect);

echo "----END-----";

// while($objResult = mysql_fetch_assoc($objQuery)){
// 	echo "<p><pre>"; print_r($objResult); echo "</pre></p>";
// }


?>