<?php
session_start();
class ChangepicController extends AppController {
	/* ------------------------------------------------------------------------------------------------- */
	public $names = "ChangepicController";
	public $uses = array('Gvar','ProfilePic','Profile');
	var $components = array('Session');
	/* ------------------------------------------------------------------------------------------------- */
	public function index(){
		$this->log("START :: ChangepicController -> index()");
		
		$this->prepareDataFnc("");	// $flagUploadFile
		
		$this->log("END :: ChangepicController -> index()");
	}// index
	/* ------------------------------------------------------------------------------------------------- */
	public function submitDataFnc() {
		$this->log("START :: ChangepicController -> submitDataFnc()");
		
		//// local variables ////
		$result = null;
		$objUser = $this->getObjUser();
		$eduStep = $this->request->data["select_edustep"];
		$imgDtm = $this->setFormatDate($this->request->data["text_imgdtm"]);
		$imgDesc = $this->request->data["textarea_imgdesc"];
		
		//*** insert data
		$dataSource = $this->ProfilePic->getdatasource();
		$dataSource->begin();
		if ( $this->ProfilePic->insertAll($objUser["id"]
				, ""
				, $imgDesc
				, $eduStep
				, $imgDtm
				, "") ) {
			// gen directory
			$directory = "img/profiles/".$objUser["id"];
			// gen fileName
			$lastInsertId = $this->ProfilePic->getLastInsert();
			$extensionFile = ".".explode(".", $_FILES["file_upload"]["name"])[1];
			$fileName = $lastInsertId[0][0]["last_index_id"].$extensionFile;
			
			//*** upload file
			if ( $this->checkDirectory($directory) ) {
				if ( move_uploaded_file($_FILES["file_upload"]["tmp_name"]	// temp_file
						, $directory."/".$fileName) ) {	// path file
					//*** update data(imgPath)
					if ( $this->ProfilePic->updateImgPathById($directory."/".$fileName	// $imgPath
									, $lastInsertId[0][0]["last_index_id"]) ) {	// $byId
						$result = "บันทึกข้อมูล เรียบร้อย";
					} else {
						$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
					}// if else
				} else {
					$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
				}// if else
			} else {
				$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
			}// if
		} else {
			$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
		}// if else
			
		// close transaction
		if ( $result == "บันทึกข้อมูล เรียบร้อย" ) {
			$dataSource->commit();
		} else {
			$dataSource->rollback();
		}// if else
		
		$this->prepareDataFnc($result);
		$this->render("index");
		
		$this->log("END :: ChangepicController -> submitDataFnc()");
	}// submitDataFnc
	/* ------------------------------------------------------------------------------------------------- */
	private function prepareDataFnc($flagUploadFile) {
		$objUser = $this->getObjUser();
		
		// page title
		$this->setTitle('เปลี่ยนรูปประจำตัว');
		
		// image
		$pathImage = $this->ProfilePic->getStarByProfileId($objUser["id"]);	// $byProfileId
		$this->set("pathImage", $pathImage);
		
		// eduStep
		$eduStep = $this->Gvar->getVarcodeVardesc1ByVarname("EDUCATION_STEP");	// $byVarName
		$this->set("eduStep", $eduStep);
		
		$this->set("flagUploadFile", $flagUploadFile);
	}// prepareDataFnc
	/* ------------------------------------------------------------------------------------------------- */
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
	/* ------------------------------------------------------------------------------------------------- */
	private function checkDirectory($directory) {
		$flag = false;
		
		// check directory existing
		if ( is_dir($directory) ) {
			$flag = true;
		} else {
			$this->log("not have directory");
				
			if ( mkdir($directory) ) {
				$this->log("make directory complete");
				
				#Ref : http://php.net/manual/en/function.chmod.php
				// Changes file mode
				// Read and write for owner, read for everybody else
				if ( chmod($directory, 0744) ) {
					$this->log("set permission complete");
					
					$flag = true;
				} else {
					$this->log("set permission fail");
				}// if else
			} else {
				$this->log("make directory fail");
			}// if else
		}// if else
		
		return $flag;
	}// checkDirectory
	/* ------------------------------------------------------------------------------------------------- */
	public function updateImgProfile(){
		$this->log('---- updateImgProfile ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		$imgpath = $this->request->data['imgpath'];
		$imgdesc = $this->request->data['imgdesc'];
		$dataSource = $this->Profile->getDataSource();
		
		if( $this->Profile->updateImg($objUser['id']
								,$imgpath
								,$imgdesc) ){
			$dataSource->commit();
			
			$newObjUser = $this->Profile->getDataById($objUser['id']);
			$this->Session->delete('objuser');
			$this->Session->write('objuser',$newObjUser[0]["profiles"]);
			
			$result['msg'] = 'การแก้ไขรูปภาพโปรไฟล์เสร็จเรียบร้อย';
			$result['flg'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติการศึกษา กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต';
			$result['flg'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
}// ChangepicController
