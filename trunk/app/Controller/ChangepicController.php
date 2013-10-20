<?php
session_start();
class ChangepicController extends AppController {
	/* --------------------------------------------------------------------------------- */
	public $names = "ChangepicController";
	public $uses = array("Gvar", "ProfilePic");
	/* --------------------------------------------------------------------------------- */
	public function index(){
		$this->log("START :: ChangepicController -> index()");
		
		$this->prepareDataFnc("");
		
		$this->log("END :: ChangepicController -> index()");
	}// index
	/* --------------------------------------------------------------------------------- */
	public function submitDataFnc() {
		$this->log("START :: ChangepicController -> submitDataFnc()");
		
		//// local variables ////
		$result = null;
		$fileName = $_FILES["file_upload"]["name"];
		$pathFile = "files/";
		$eduStep = $this->request->data["select_edustep"];
		$imgDtm = $this->setFormatDate($this->request->data["text_imgdtm"]);
		$imgDesc = $this->request->data["textarea_imgdesc"];

		// check duplicate file
		if ( file_exists($pathFile.$fileName) ) {
			$result = "ชื่อไฟล์ ซ้ำ";
		} else {
			//*** upload file
			if ( move_uploaded_file($_FILES["file_upload"]["tmp_name"]	// temp_file
									, $pathFile.$fileName) ) {	// path file
				//*** insert data
				if ( $this->ProfilePic->insertAll($this->getObjUser()["id"]	// $proflieid
												, $pathFile.$fileName	// $imgpath
												, $imgDesc	// $imgdesc
												, $eduStep	// $edustep
												, $imgDtm	// $imgdtm
												, "") ) {	// $uploaddtm
					$result = "อัพโหลดไฟล์ เรียบร้อย";
				} else {
					$result = "อัพโหลดไฟล์ ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
				}// if else
			} else {
				$result = "อัพโหลดไฟล์ ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
			}// if else
		}// if else
		
		$this->prepareDataFnc($result);
		$this->render("index");
		
		$this->log("END :: ChangepicController -> submitDataFnc()");
	}// submitDataFnc
	/* --------------------------------------------------------------------------------- */
	private function prepareDataFnc($flagUploadFile) {
		$this->set("page_title","Picture profile uploader");
		$eduStep = $this->Gvar->getVarcodeVardesc1ByVarname("EDUCATION_STEP");	// $byVarName
		$this->set("eduStep", $eduStep);
		$this->set("flagUploadFile", $flagUploadFile);
	}// prepareDataFnc
	/* --------------------------------------------------------------------------------- */
	private function setFormatDate($data) {
		/*
		 * index of explode
		 * [0] = day
		 * [1] = month
		 * [2] = year
		 */
		$result = explode("/", $data);
		
		return ($result[2] - 543)."/".$result[1]."/".$result[0];
	}// setFormatDate
}// ChangepicController
