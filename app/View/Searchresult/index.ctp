<?php 

function toThaiDate($dtm){
	if(empty($dtm)) return "-";
	$dateArray=explode('-',$dtm);
	$thai_month_arr=array(  "00"=>"",
			"01"=>"มกราคม",
			"02"=>"กุมภาพันธ์",
			"03"=>"มีนาคม",
			"04"=>"เมษายน",
			"05"=>"พฤษภาคม",
			"06"=>"มิถุนายน",
			"07"=>"กรกฎาคม",
			"08"=>"สิงหาคม",
			"09"=>"กันยายน",
			"10"=>"ตุลาคม",
			"11"=>"พฤศจิกายน",
			"12"=>"ธันวาคม");
	return $dateArray[2].' '.$thai_month_arr[$dateArray[1]].' '.($dateArray[0]+543);
}

?>
<style type="text/css">
.result{
	margin: 10px 0  5px 15px;
}
.result h3{
	margin: 2px 0;
}
</style>

<div style="padding:10px;">
<h3 style="margin-bottom: 10px;">Search Results</h3>
<hr style="" />
<?php 
$header = "";
$content = "";
$id = "";
foreach ($searchResult as $record){

	$objdata = json_decode($record['searchkeywords']['objdata']);
// 	echo "<pre>"; print_r($objdata); echo "</pre>";
	switch($record['searchkeywords']['typeid']){
		case 1 :
			$header = $objdata->nameth." ".$objdata->lastnameth;
			$content = "ชื่อภาษาอังกฤษ : ".$objdata->nameeng." ".$objdata->lastnameeng.", ชื่อเล่น : ".$objdata->nickname.", วันเกิด : ".toThaiDate($objdata->birthday)."";
			$id = $objdata->id;
			break;
		case 2 :
			$header = $objdata->name;
			$content = "วันที่จัดกิจกรรม ".toThaiDate($objdata->startdtm)." ถึง ".toThaiDate($objdata->enddtm).", รายละเอียดอย่างย่อ : ".$objdata->shortdesc."";
			$id = $objdata->id;
			break;
		default :
			$header = "ไม่ทราบประเภท";
			$content = "-";
			$id = "";
			
	}
	$href = $this->Html->url($searchType[$record['searchkeywords']['typeid']]['vardesc2'].$id);
?>
<div class="result">
	<a href="<?php echo $href; ?>">
		<h3><?php echo $header; ?></h3>
		<div style="margin-left:10px;"><?php echo $content; ?></div>
	</a>
</div>

<?php } ?>
</div>