<?php
App::import('Vendor', 'php_image_magician');
class ChangepicController extends AppController {
	/* ------------------------------------------------------------------------------------------------- */
	public $names = "ChangepicController";
	public $uses = array('Gvar','ProfilePic','Profile','Sequence');
	var $components = array('Session');
	/* ------------------------------------------------------------------------------------------------- */
	public function index(){
		$this->log("START :: ChangepicController -> index()");
		
		$get_profile_id = @intval($this->request->query['id']);
		$sssnObjUser = $this->getObjUser();
		$objUser = $this->Profile->getDataById($get_profile_id);
		$isOwner = false;
		
		if( !empty($objUser) ){
			/* owner profile */
			if( $get_profile_id==$sssnObjUser['id'] ){
				$isOwner = true;
			}else if(!$this->getIsAdmin()){
				//TODO: Redirect to Mainmenu.
				$this->redirect(array("controller" => "Mainmenu"));
			}
		}
		if(empty($get_profile_id)) $isOwner = true;
		
		if(!$this->getIsAdmin() && !$isOwner){
			$this->redirect(array("controller" => "Mainmenu"));
		}
		
		$this->prepareDataFnc("");	// $flagUploadFile
		
		$this->set('isOwner', $isOwner);
		
		$this->log("END :: ChangepicController -> index()");
	}// index
	/* ------------------------------------------------------------------------------------------------- */
	public function submitDataFnc() {
		$this->log("START :: ChangepicController -> submitDataFnc()");
		
		//// local variables ////
		$result = null;
		$objUser = $this->getObjUser();
		$eduStep = -1;

		$profileId = '';
		if(empty($this->request->query['id'])){
			$profileId = $objUser["id"];
		}else{
			$profileId = $this->request->query['id'];
		}
		$this->log("id=".$profileId);
		
// 		$imgDtm = $this->request->data["text_imgdtm"];
// 		$imgDesc = $this->request->data["textarea_imgdesc"];
		
		//*** insert data
// 		$dataSource = $this->ProfilePic->getdatasource();
// 		$dataSource->begin();
// 		if ( $this->ProfilePic->insertAll($objUser["id"]
// 				, ""
// 				, $imgDesc
// 				, $eduStep
// 				, $imgDtm
// 				, "") ) {
			// gen directory
			$directory = "img/profiles/".$profileId;
			// gen fileName
			$pictureId = $this->Sequence->next_val('PROFILEPICTURE');
// 			$lastInsertId = 
			// Format => Untitled.png
			$splitFileName = explode(".", $_FILES["file_upload"]["name"]);
			$extensionFile = ".".$splitFileName[count($splitFileName)-1];
			$fileName = $pictureId.$extensionFile;
			
			//*** upload file
			if ( $this->checkDirectory($directory) ) {

				$tmp1_fileName = $directory."/"."tmp1_".$fileName;
				$tmp2_fileName = $directory."/"."tmp2_".$fileName;

				if ( move_uploaded_file($_FILES["file_upload"]["tmp_name"]	// temp_file
						, $tmp1_fileName) ) {	// path file
					//*** update data(imgPath)
					

// 					$this->log('###After Resize....');

					$magicianObj = new imageLib($tmp1_fileName);
					$magicianObj->resizeImage(1100, 1, 'landscape');
					$magicianObj->saveImage($tmp2_fileName, 100);
					
					unlink($tmp1_fileName);

// 					$this->log('###Before Resize....');
					
					
					$result = true;
					
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
					$result = false;
				}// if else
					
				
				
			} else {
				$result = false;
			}// if
// 		} else {
// 			$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
// 		}// if else
			
		// close transaction
		if ( $result ) {
// 			$dataSource->commit();
			
			$this->redirect(array("controller" => "Changepic",
					"action" => "crop",
					"imgPath" => base64_encode($tmp2_fileName),
					"pictureId" => $pictureId,
					"profileId" => $profileId
					));
			
			//Update new session
// 			$newObjUser = $this->Profile->getDataById($objUser['id']);
// 			$this->Session->delete('objuser');
// 			$this->Session->write('objuser',$newObjUser[0]["profiles"]);
		} else {
// 			$dataSource->rollback();
		}// if else
		
		$this->prepareDataFnc($result);
		$this->render("index");
		
		$this->log("END :: ChangepicController -> submitDataFnc()");
	}// submitDataFnc
	
	public function crop(){
		
		$this->log('START :: ChangepicController -> crop()');
		
// 		$imgPath = '/img/profiles/17/20.jpg';

// 		$this->log($this->params);
		
		$raw_imgPath = $this->params['named']['imgPath'];
		$pictureId = $this->params['named']['pictureId'];
		$profileId = $this->params['named']['profileId'];
		$imgPath = '';
		if(!empty($raw_imgPath) && !empty($pictureId) && !empty($profileId)){
			$imgPath = base64_decode($raw_imgPath);
			
		}else{
			$this->redirect(array("controller" => "Changepic", "action" => "index"));
		}

		$this->layout='public';
		$this->set(compact('imgPath', 'raw_imgPath', 'pictureId', 'profileId'));
		
		$this->log('END :: ChangepicController -> crop()');
		
	}
	
	public function ajax_crop(){
		$this->log('START :: ChangepicController -> ajax_crop()');
		
		$result = array();

		$raw_imgPath = $this->request->data['imgpath'];
		$imgDtm = $this->request->data['imgdtm'];
		$imgDesc = $this->request->data['imgdesc'];
		$pictureId = $this->request->data['pictureId'];
		$profileId = $this->request->data['profileId'];
		$cropInfo = $this->request->data['cropInfo'];
		
		$objUser = $this->getObjUser();

		/* Insert Database */
		$dataSource = $this->ProfilePic->getdatasource();
		$dataSource->begin();
		
		$imgPath = '';
		if(!empty($raw_imgPath) && !empty($pictureId) && !empty($profileId)){
			$imgPath = base64_decode($raw_imgPath);
			
			
			$directory = "img/profiles/".$profileId;
			$splitFileName = explode(".", $imgPath);
			$extensionFile = ".".$splitFileName[count($splitFileName)-1];
			$fileName = $pictureId.$extensionFile;
			
			if ( $this->checkDirectory($directory) ) {
			
				$tmp3_fileName = $directory."/"."tmp3_".$fileName;
				
				$cropposX = $cropInfo['x1']; 
				$cropposY = $cropInfo['y1']; 
				$cropWidth = $cropInfo['width']; 
				$cropHeight = $cropInfo['height']; 
				
				$magicianObj = new imageLib($imgPath);
				$this->log('Crop->'.$cropposX.'x'.$cropposY);
				$this->log('Crop->Width:'.$cropWidth);
				$this->log('Crop->Height:'.$cropHeight);
				$magicianObj->cropImage($cropWidth, $cropHeight, $cropposX.'x'.$cropposY);
				$magicianObj->saveImage($tmp3_fileName, 100);
				//TODO: -> SAVE
				$magicianObj = new imageLib($tmp3_fileName);
				$magicianObj->resizeImage(230, 1, 'landscape');
				$magicianObj->saveImage($directory."/".$fileName, 100);
				
				unlink($imgPath);
				unlink($tmp3_fileName);

				
				/* Insert Database */
				if ( $this->ProfilePic->insertAll($pictureId,
						$profileId
						, $directory."/".$fileName
						, $imgDesc
						, 0
						, $imgDtm
						, "") ) {

					if( $this->Profile->updateImg($profileId
								,$directory."/".$fileName
								,$imgDesc) ){


						$result['status'] = true;
						$result['message'] = 'เพิ่มรูปภาพส่วนตัว เรียบร้อย';
						
						
					}else{
						$result['status'] = false;
						$result['message'] = 'บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ';
					}
					
				}else{
					$result['status'] = false;
					$result['message'] = 'บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ';
				}
				
			}else{
				$result['status'] = false;
				$result['message'] = 'บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ';
			}
		}else{
			$result['status'] = false;
			$result['message'] = 'บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ';
		}
		
		if($result['status']){
			$dataSource->commit();
			
			//Update new session
			$newObjUser = $this->Profile->getDataById($objUser['id']);
			$this->Session->delete('objuser');
			$this->Session->write('objuser',$newObjUser[0]["profiles"]);
		}else{
			$dataSource->rollback();
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
		
		$this->log('END :: ChangepicController -> ajax_crop()');
	}
	
	/* ------------------------------------------------------------------------------------------------- */
	public function deletePic(){
		$this->log('START :: ChangepicController -> deletePic()');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->query);
		$profileId = $this->request->query['profileId'];
		$id = $this->request->query['id'];
		$dataProfilePic = $this->ProfilePic->getDataById($id);
		
		$dataSource = $this->ProfilePic->getdatasource();
		$dataSource->begin();
		if( $this->ProfilePic->deleteById($id) ){
// 			if( unlink($dataProfilePic[0]['pp']['imgpath']) ){
			unlink($dataProfilePic[0]['pp']['imgpath']);
			$dataSource->commit();
			
			$result['flg'] = '1';
			$result['msg'] = 'ลบรูปโปรไฟล์ เสร็จเรียบร้อย';
			
			//reset session
			$newObjUser = $this->Profile->getDataById($objUser['id']);
			$this->Session->delete('objuser');
			$this->Session->write('objuser',$newObjUser[0]["profiles"]);
// 			}else{
// 				$result['flg'] = '0';
// 				$result['msg'] = 'เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ';
// 			}
		}else{
			$dataSource->rollback();
			
			$result['flg'] = '0';
			$result['msg'] = 'เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ';
		}
		
		$this->log('END :: ChangepicController -> deletePic()');
		
		$this->prepareDataFnc($result['msg']);
		$redirectparam = (empty($profileId)?'':'?id='.$profileId);
		//$this->render("index");
		
		$this->redirect(array("controller" => "Changepic",
				"action" => "index".$redirectparam
		));
	}
	/* ------------------------------------------------------------------------------------------------- */
	private function prepareDataFnc($flagUploadFile) {
		$objUser = $this->getObjUser();
		
		$profileId = '';
		if(empty($this->request->query['id'])){
			$profileId = $objUser["id"];
		}else{
			$profileId = $this->request->query['id'];
		}
		$this->log("id=".$profileId);
		
		// page title
		$this->setTitle('เปลี่ยนรูปประจำตัว');
		
		// image
		$pathImage = $this->ProfilePic->getStarByProfileId($profileId);	// $byProfileId
		$this->set("pathImage", $pathImage);
		
		// eduStep
// 		$eduStep = $this->Gvar->getVarcodeVardesc1ByVarname("EDUCATION_STEP");	// $byVarName
// 		$this->set("eduStep", $eduStep);
		
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
				chmod($directory, 0777);
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
