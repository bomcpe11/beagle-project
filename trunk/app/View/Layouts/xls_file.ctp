<?php 
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="'.(empty($file_name)?'file_export':$file_name).'.xls"');#ชื่อไฟล์

echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"
					xmlns:x="urn:schemas-microsoft-com:office:excel"
					xmlns="http://www.w3.org/TR/REC-html40">
				<HTML>
				<HEAD>
					<meta http-equiv="Content-type" content="text/html;charset=UTF-8" />
				</HEAD>';

echo $this->fetch('content'); 

echo '<HTML>';
?>
