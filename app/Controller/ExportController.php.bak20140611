<?php
class ExportController extends AppController {

	public $names = "ExportController";
	public $uses = array("Gvar","Queryexport");

//-----------------------------------------------------------------------------------------------------
	public function index(){
		$this->log("START :: ExportController -> index()");
		
		$this->set("page_title","Export");
		
		//--Drop Down ExportTypeList
		$exportTypeList     = $this->Gvar->getVarcodeVardesc1ByVarname("EXPORT_FILE_TYPE");
        $this->set("exportTypeList", $exportTypeList);
        
        //--Drop Down SelectDataNameList
        $selectDataNameList = $this->Queryexport->getSelectDataName();
        $this->set("selectDataNameList", $selectDataNameList);
		
		$this->log("END :: ExportController -> index()");
	}
//-----------------------------------------------------------------------------------------------------
	function isSQLInjection($sql){
		if (strpos($sql, '--') !== FALSE)
			return true;
		else
			return false;
	}
//-----------------------------------------------------------------------------------------------------
	function export(){
		$this->log("START :: ExportController -> export()");
		
// 		$this->log($this->request->data);
		
		$datas      = $this->request->data["datas"];
// 		$mode            = $this->request->data["mode"];
// 		$stmt            = $this->request->data["stmt"];
// 		$selectDataName  = $this->request->data["selectDataName"];
// 		$selectDataNameId = $this->request->data["selectDataNameId"];
		
// 		if($mode == 1){
// 			$rs = $this->Queryexport->updateSelectData($selectDataNameId);
// 		}else{
// 			$id = $this->Queryexport->getMaxId();
// 			$rs = $this->Queryexport->insertSelectData($id[0][0]['id'],$selectDataName,$stmt);
// 		}

		header('Content-type: application/csv charset=utf-8');
		header('Content-Disposition: attachment; filename="data.csv"');
		header("Content-Encoding: utf-8");
		
		
// 			echo $key.'<br>';
// 		}
		
		
		if(count($datas)==1){
			$stmt = "select ";
			foreach ($datas as $key => $value){
// 				$key = key($datas);
				if($this->isSQLInjection($key)) break;
				for($i=0; $i<count($value); $i++){
					if($this->isSQLInjection($value[$i])) break;
					$stmt .= ($i==0?'':',').$value[$i];
				}
				$stmt .= " from ".$key;
// 				next($datas);
				break;
			}
			
		}else{
			$stmt = "select * from profiles";
		}
		
// 		$this->log("stmt=".$stmt);
		
		$result = $this->Queryexport->query($stmt);
// 		$status['id'] = $rs;

		// The column headings of your .csv file
		$header_row = array();
		$data_row = array();
		
		// Print the column names as the headers of a table
		for($i = 0; $i < mysql_num_fields($result); $i++) {
			$field_info = mysql_fetch_field($result, $i);
// 			$header_row[] = $field_info->name;
			echo ($i==0?'':',').$field_info->name;
		}
		
		echo "\n";
		
// 		fputcsv($csv_file,$header_row,',','"');
		
		// Print the data
		while($row = mysql_fetch_row($result)) {
			$i=0;
			foreach($row as $_column) {
// 				$data_row[] = $_column;
				echo ($i==0?'':',').$_column;
				$i++;
			}
// 			fputcsv($csv_file,$data_row,',','"');
// 			$data_row = array();
			echo "\n";
		}
		//fputcsv($csv_file,$data_row,',','"');
// 		if(mysql_query($sql)){
// 			$rs = 1;
// 		}else{
// 			$rs = 0;
// 		}
		
// 		mysql_close($dbLink);
		
	    // send data to view
	    $this->layout = "ajax";
// 	    $this->set('message', json_encode(array("status"=>$status)));
	    $this->render("exportfile");
	    
	    $this->log("END :: ExportController -> export()");
		
	}
//-----------------------------------------------------------------------------------------------------	

}
