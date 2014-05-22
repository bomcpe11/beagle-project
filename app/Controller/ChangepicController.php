<?php
App::import('Vendor', 'php_image_magician');
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
		$eduStep = -1;
		$imgDtm = $this->request->data["text_imgdtm"];
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
			// Format => Untitled.png
			$splitFileName = explode(".", $_FILES["file_upload"]["name"]);
			$extensionFile = ".".$splitFileName[count($splitFileName)-1];
			$fileName = $lastInsertId[0][0]["last_index_id"].$extensionFile;
			
			//*** upload file
			if ( $this->checkDirectory($directory) ) {

				$tmp1_fileName = $directory."/"."tmp1_".$fileName;
// 				$tmp2_fileName = $directory."/"."tmp2_".$fileName;

				if ( move_uploaded_file($_FILES["file_upload"]["tmp_name"]	// temp_file
						, $tmp1_fileName) ) {	// path file
					//*** update data(imgPath)
					

					$this->log('###After Resize....');

					$magicianObj = new imageLib($tmp1_fileName);
					$magicianObj->resizeImage(700, 700, 'portrait');
					$magicianObj->saveImage($tmp2_fileName, 100);
					
// 					unlink($tmp1_fileName);

					$this->log('###Before Resize....');
					
					
					$result = "บันทึกข้อมูล เรียบร้อย";
					
// 					if ( $this->ProfilePic->updateImgPathById($directory."/".$fileName	// $imgPath
// 									, $lastInsertId[0][0]["last_index_id"]) ) {	// $byId
// 						$objUser = $this->getObjUser();
// 						if( $this->Profile->updateImg($objUser['id']
// 									,$directory."/".$fileName
// 									,$imgDesc) ){
// 							$result = "บันทึกข้อมูล เรียบร้อย";
// 						}else{
// 							$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
// 						}
// 					} else {
// 						$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
// 					}// if else
	
					
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
// 			$dataSource->commit();
			
			$this->redirect(array("controller" => "Changepic",
					"action" => "crop",
					"imgPath" => base64_encode($tmp1_fileName)));
			
			//Update new session
// 			$newObjUser = $this->Profile->getDataById($objUser['id']);
// 			$this->Session->delete('objuser');
// 			$this->Session->write('objuser',$newObjUser[0]["profiles"]);
		} else {
			$dataSource->rollback();
		}// if else
		
		$this->prepareDataFnc($result);
		$this->render("index");
		
		$this->log("END :: ChangepicController -> submitDataFnc()");
	}// submitDataFnc
	
	public function crop(){
		
		
// 		$imgPath = '/img/profiles/17/20.jpg';

// 		$this->log($this->params);
		
		$raw_imgPath = $this->params['named']['imgPath'];
		$imgPath = '';
		if(!empty($raw_imgPath)){
			$imgPath = base64_decode($raw_imgPath);
			
			$this->log($imgPath);
// 			$imgPath = 'img/profiles/17/tmp1_35.jpg';
// // 			$imgPath = '/Applications/MAMP/htdocs/jstphub/app/webroot/img/profiles/17/tmp1_35.jpg';
			
// 			$this->log('###After Resize....');

// 			$magicianObj = new imageLib($imgPath);
// // 			$magicianObj->resizeImage(700, 700, 'portrait');
// // 			$magicianObj->saveImage($imgPath, 100);
	
// // 			unlink($tmp1_fileName);

// 			$this->log('###Before Resize....');
			
		}else{
			$this->redirect(array("controller" => "Changepic", "action" => "index"));
		}

		$this->layout='public';
		$this->set(compact('imgPath'));
		
	}
	
	/* ------------------------------------------------------------------------------------------------- */
	public function deletePic(){
		$this->log('START :: ChangepicController -> deletePic()');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->query);
		$id = $this->request->query['id'];
		$dataProfilePic = $this->ProfilePic->getDataById($id);
		
		$dataSource = $this->ProfilePic->getdatasource();
		$dataSource->begin();
		if( $this->ProfilePic->deleteById($id) ){
			if( unlink($dataProfilePic[0]['pp']['imgpath']) ){
				$dataSource->commit();
				
				$result['flg'] = '1';
				$result['msg'] = 'ลบรูปโปรไฟล์ เสร็จเรียบร้อย';
				
				//reset session
				$newObjUser = $this->Profile->getDataById($objUser['id']);
				$this->Session->delete('objuser');
				$this->Session->write('objuser',$newObjUser[0]["profiles"]);
			}else{
				$result['flg'] = '0';
				$result['msg'] = 'เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ';
			}
		}else{
			$dataSource->rollback();
			
			$result['flg'] = '0';
			$result['msg'] = 'เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ';
		}
		
		$this->log('END :: ChangepicController -> deletePic()');
		
		$this->prepareDataFnc($result['msg']);
		$this->render("index");
	}
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
