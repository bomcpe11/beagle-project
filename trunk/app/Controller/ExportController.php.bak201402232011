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
	function export(){
		$this->log("START :: ExportController -> export()");
		
		$exportType      = $this->request->data["exportType"];
		$mode            = $this->request->data["mode"];
		$stmt            = $this->request->data["stmt"];
		$selectDataName  = $this->request->data["selectDataName"];
		$selectDataNameId = $this->request->data["selectDataNameId"];
		
		if($mode == 1){
			$rs = $this->Queryexport->updateSelectData($selectDataNameId);
		}else{
			$id = $this->Queryexport->getMaxId();
			$rs = $this->Queryexport->insertSelectData($id[0][0]['id'],$selectDataName,$stmt);
		}
		
		$rs = $this->Queryexport->genFileExport($exportType,$mode,$stmt);
		$status['id'] = $rs;

	    // send data to view
	    $this->layout = "ajax";
	    $this->set('message', json_encode(array("status"=>$status)));
	    $this->render("response");
	    
	    $this->log("END :: ExportController -> export()");
		
	}
//-----------------------------------------------------------------------------------------------------	

}
