<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */

class ExportController extends AppController {

	public $names = "ExportController";
	public $uses = array("Queryexport");

	public function index(){
		
		$this->setTitle('Export');
		
	}
	
	public function allPersonalInfoes(){
		$this->log("START :: ExportController -> allPersonalInfoes()");
		
// 		header('Content-type: application/csv charset=utf-8');
// 		header('Content-Disposition: attachment; filename="personal-info-data.csv"');
// 		header("Content-Encoding: utf-8");
		
// 		$stmt = "select * from profiles p
// left join awards a on (a.profile_id=p.id)
// left join educations e on (e.profile_id=p.id)
// left join families f on (f.profile_id=p.id)";
		
		$stmt = "select * from profiles";
		
		$result = $this->Queryexport->query($stmt);
		
		$this->exportXLS('personal-info-data', $result);
		
// 		// The column headings of your .csv file
// 		$header_row = array();
// 		$data_row = array();
		
// 		// Print the column names as the headers of a table
// 		for($i = 0; $i < mysql_num_fields($result); $i++) {
// 			$field_info = mysql_fetch_field($result, $i);
// 			echo ($i==0?'':',').$field_info->name;
// 		}
		
// 		echo "\n";
		
// 		// Print the data
// 		while($row = mysql_fetch_row($result)) {
// 			$i=0;
// 			foreach($row as $_column) {
// 				echo ($i==0?'':',').$_column;
// 				$i++;
// 			}
// 			echo "\n";
// 		}
		
// 		// send data to view
// 		$this->layout = "ajax";
// 		$this->render("exportfile");
			
		$this->log("END :: ExportController -> allPersonalInfoes()");
	}
	
	public function allActivities(){
		$this->log("START :: ExportController -> allActivities()");
		
// 		header('Content-type: application/csv charset=utf-8');
// 		header('Content-Disposition: attachment; filename="activities-data.csv"');
// 		header("Content-Encoding: utf-8");
		
		// 		$stmt = "select * from profiles p
		// left join awards a on (a.profile_id=p.id)
		// left join educations e on (e.profile_id=p.id)
		// left join families f on (f.profile_id=p.id)";
		
		$stmt = "select * from activities";
		
		$result = $this->Queryexport->query($stmt);
		
		$this->exportXLS('activities-data', $result);
		
		// The column headings of your .csv file
// 		$header_row = array();
// 		$data_row = array();
		
// 		// Print the column names as the headers of a table
// 		for($i = 0; $i < mysql_num_fields($result); $i++) {
// 			$field_info = mysql_fetch_field($result, $i);
// 			echo ($i==0?'':',').$field_info->name;
// 		}
		
// 		echo "\n";
		
// 		// Print the data
// 		while($row = mysql_fetch_row($result)) {
// 			$i=0;
// 			foreach($row as $_column) {
// 				echo ($i==0?'':',').$_column;
// 				$i++;
// 			}
// 			echo "\n";
// 		}
		
// 		// send data to view
// 		$this->layout = "ajax";
// 		$this->render("exportfile");
			
		$this->log("END :: ExportController -> allActivities()");
	}
	
	private function ExampleExport(){
		$this->log("START :: ExportController -> ExampleExport()");
	
		header('Content-type: application/csv charset=utf-8');
		header('Content-Disposition: attachment; filename="data.csv"');
		header("Content-Encoding: utf-8");
	
		$stmt = "select * from profiles";
	
		$result = $this->Queryexport->query($stmt);
	
		// The column headings of your .csv file
		$header_row = array();
		$data_row = array();
	
		// Print the column names as the headers of a table
		for($i = 0; $i < mysql_num_fields($result); $i++) {
			$field_info = mysql_fetch_field($result, $i);
			echo ($i==0?'':',').$field_info->name;
		}
	
		echo "\n";
	
		// Print the data
		while($row = mysql_fetch_row($result)) {
			$i=0;
			foreach($row as $_column) {
				echo ($i==0?'':',').$_column;
				$i++;
			}
			echo "\n";
		}
	
		// send data to view
		$this->layout = "ajax";
		$this->render("exportfile");
		 
		$this->log("END :: ExportController -> ExampleExport()");
	
	}
	
	private function changeFormatDate($data) {
		/*
		 * index of $explodeDate
		* [0] = day
		* [1] = month
		* [2] = year(2013)
		*/
		$explodeDate = explode("/", $data);
	
		return ($explodeDate[2] - 543)."/".$explodeDate[1]."/".$explodeDate[0];
	}// changeFormatDate
	
	public function exportXLS($filename, $result){
		
		header("Content-Type: application/vnd.ms-excel");
		header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
		header("Content-Encoding: utf-8");
		
		global $header,$header_flag;
		$header_flag = 'Y';
		$index = 0;
		//*if there is reference code more than 0 record then retrieve ID from its
		if(mysql_num_rows($result) > 0){
			echo
				'<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel"
				xmlns="http://www.w3.org/TR/REC-html40">
				<head>
					<meta http-equiv="Content-type" content="text/html; charset=UTF-8"/>
				</head>';
				
					while($row = mysql_fetch_assoc($result)){
						$index++ ;
						$data_list.='<TR>';
						
						foreach ($row as $key => $value)  {
							$data_list .= $this->data_colum($key,$value,$index);
						}
						
						$data_list.='</TR>';
					}
					echo '<TABLE  x:str BORDER="1" >
				<TR bgcolor= "#6d7b8d">
					'.$header.'
				</TR>'.$data_list .'
			  </TABLE>';
		}
		
		
		$this->layout = "ajax";
		$this->render("exportfile");
	}
	
	private function add_colum($value,$color)
	{
		if($color = 'Y')
		{
			$value = "<td><font color='FFFFFF'> ".$value."</font></td>";
		}else
		{
			$value = "<td>".$this->replace_word($value)."</td>";
		}
	
		return $value ;
	}
	private function data_colum($header_title,$value,$row)
	{
		global $header,$header_flag;
		if($header_flag == 'Y' && $row == 1 )
		{
			$header.= $this->add_colum($header_title,'Y' );
		}else
		{
			$header_flag = 'N';
		}
		if(!$value || $value == ' ' )
		{
			$value = "&#32;";
		}
		if((strtoupper($value) == 'NULL') || (strtoupper($value)== 'NA') || $value == '01/01/1900' )
		{
			$value = "&#32;";
		}
		if(($row%2)== 0)
		{
			$value = "<td bgcolor='#EBDDE2'>".$value."</td>";
		}else
		{
			$value = "<td >".$value."</td>";
		}
	
		return  $value ;
	}
	private function replace_word($word)
	{
		$word = str_replace(',',' ',$word);
		return $word ;
	}
}
