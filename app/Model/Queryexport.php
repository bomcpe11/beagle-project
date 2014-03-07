<?php
App::Import('ConnectionManager');
class Queryexport extends AppModel {
	var $name = 'Queryexport';
	
	function genFileExport($iExportType,$iMode,$iStmt){
		$this->log("START :: Queryexport -> genFileExport()");
		 
		$ds = ConnectionManager::getDataSource('default');
		$dsc = $ds->config;
	
		$dbLink = mysql_connect($dsc['host'], $dsc['login'], $dsc['password']);
		mysql_select_db($dsc['database'], $dbLink);
	
		mysql_query("SET character_set_results=utf8");
		mysql_query("SET character_set_client=utf8");
		mysql_query("SET character_set_connection=utf8");
	
		$sql = $iStmt;
		$result = mysql_query($sql) or die(mysql_error());
	
	
		//increase max_execution_time to 10 min if data set is very large
		ini_set('max_execution_time', 600);
	
		//create a file
		$filename = "data.csv";
		$csv_file = fopen($filename, 'w');
	
		header('Content-type: application/csv charset=utf-8');
		header('Content-Disposition: attachment; filename="'.$filename.'"');
		header("Content-Encoding: utf-8");
	
		// The column headings of your .csv file
		$header_row = array();
		$data_row = array();
	
		// Print the column names as the headers of a table
		for($i = 0; $i < mysql_num_fields($result); $i++) {
			$field_info = mysql_fetch_field($result, $i);
			$header_row[] = $field_info->name;
		}
	
		fputcsv($csv_file,$header_row,',','"');
	
		// Print the data
		while($row = mysql_fetch_row($result)) {
			foreach($row as $_column) {
				$data_row[] = $_column;
			}
			fputcsv($csv_file,$data_row,',','"');
			$data_row = array();
		}
		//fputcsv($csv_file,$data_row,',','"');
		if(mysql_query($sql)){
			$rs = 1;
		}else{
			$rs = 0;
		}
	
		mysql_close($dbLink);
		fclose($csv_file);
		
	
		$this->log("END :: Queryexport -> genFileExport()");
	
		return $rs;
	}
//-----------------------------------------------------------------------------------------------------	
	function query($sql){
		$this->log("START :: Queryexport -> genFileExport()");
			
		$ds = ConnectionManager::getDataSource('default');
		$dsc = $ds->config;
	
		$dbLink = mysql_connect($dsc['host'], $dsc['login'], $dsc['password']);
		mysql_select_db($dsc['database'], $dbLink);
	
		mysql_query("SET character_set_results=utf8");
		mysql_query("SET character_set_client=utf8");
		mysql_query("SET character_set_connection=utf8");
	
		$result = mysql_query($sql) or die(mysql_error());
	
		//increase max_execution_time to 10 min if data set is very large
		ini_set('max_execution_time', 600);
		
		return $result;
	}
//-----------------------------------------------------------------------------------------------------	
	function insertSelectData($id,$name,$strquery) {
		$this->log("START :: Queryexport -> insertSelectData()");
		
		$strSql = "INSERT INTO queryexports";
		$strSql .= " (";
		$strSql .= " id,";
		$strSql .= " name,";
		$strSql .= " strquery,";
		$strSql .= " createddtm,";
		$strSql .= " lastusedtm";
		$strSql .= " )";
		$strSql .= " VALUES";
		$strSql .= " (";
		$strSql .= " ".$id.",";
		$strSql .= " '".$name."',";
		$strSql .= " '".$strquery."',";
		$strSql .= " '".date("Y-m-d H:i:s")."',";
		$strSql .= " '".date("Y-m-d H:i:s")."'";
		$strSql .= " )";
		$strSql .= ";";
		
		$this->log("strSql => ".$strSql);
		 
		try {
			$this->query($strSql);
			$flag = true;
		} catch ( Exception $e ) {
			$this->log("exception => ".$e->getMessage());
		}

		$this->log("END :: Queryexport -> insertSelectData()");
		return $flag;
	}	
//-----------------------------------------------------------------------------------------------------	
	function getSelectDataName(){
		$this->log("START :: Queryexport -> getSelectDataName()");
		$result = $this->query('select id, name, strquery from queryexports');
		$this->log("END :: Queryexport -> getSelectDataName()");
		return $result;
	}
//-----------------------------------------------------------------------------------------------------	
	function getMaxId(){
		$this->log("START :: Queryexport -> getMaxId()");
		$result = $this->query('select max(id) + 1 as id from queryexports');
		$this->log("END :: Queryexport -> getMaxId()");
		return $result;
	}
//-----------------------------------------------------------------------------------------------------	
	function updateSelectData($id){
		$this->log("START :: Queryexport -> updateSelectData()");
		$result = $this->query("update queryexports set lastusedtm = '".date("Y-m-d H:i:s")."' where id =".$id);
		$this->log("END :: Queryexport -> updateSelectData()");
		return $result;
	}
//-----------------------------------------------------------------------------------------------------

}
?>