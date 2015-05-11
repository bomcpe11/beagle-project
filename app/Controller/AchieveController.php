<?php
App::import('Vendor', 'php_image_magician');
class AchieveController extends AppController{
	public $names = 'AchieveController';
	public $uses = array('Profile','Award');
// 	public $layout = 'default_new';
	/* ------------------------------------------------------------------------------------------------- */
	public function index(){
		$this->log('---- AchieveController -> index ----');
		
		$get_profile_id = @intval($this->request->query['id']);
		$sssnObjUser = $this->getObjUser();
		$objUser = $this->Profile->getDataById($get_profile_id);
		//$this->log(print_r($objUser, true));
		/*
		 * 	-1 	= not is owner profile
		 * 	1 	= is owner profile
		 */
		$isOwner = '-1';
		$fullNameTh = '';
		$listAward = '';
		
		if( !empty($objUser) ){
			/* owner profile */
			if( $get_profile_id==$sssnObjUser['id'] ){
				$isOwner = '1';
			}
			
			/* fullName */
			if( $objUser[0]['profiles']['position'] ){
				$fullNameTh = $objUser[0]['profiles']['position']
								.$objUser[0]['profiles']['nameth']
								.' '
								.$objUser[0]['profiles']['lastnameth'];
			} else{
				$fullNameTh = $objUser[0]['profiles']['titleth']
								.$objUser[0]['profiles']['nameth']
								.' '
								.$objUser[0]['profiles']['lastnameth']; 
			} 
			
			/* award */
			$listAward = $this->Award->getDataByProfileId($objUser[0]['profiles']['id']);
			//$this->log(print_r($listAward, true));
		}
		
		/* set data to view*/
		$this->set(compact('isOwner'
							,'fullNameTh'
							,'listAward'
							,'get_profile_id'));
	}
/* ------------------------------------------------------------------------------------------------ */
	public function savedNewAward(){
		$this->log('---- AchieveController -> savedNewAward ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$profile_id = $this->request->data['profile_id'];
		$name = $this->request->data['name'];
		$awardname = $this->request->data['awardname'];
		$organization = $this->request->data['organization'];
		$detail = $this->request->data['detail'];
	
		$dataSource = $this->Award->getDataSource();
		if( $this->Award->insertData($name
									,$awardname
									,$organization
									,$profile_id
									,''
									,$detail) ){
			$dataSource->commit();
			$result['msg'] = 'การเพิ่มข้อมูลรางวัลที่ได้รับเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การเพิ่มข้อมูลรางวัลที่ได้รับ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function editAward(){
		$this->log('---- AchieveController -> editAward ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$profile_id = $this->request->data['profile_id'];
		$id = $this->request->data['id'];
		$name = $this->request->data['name'];
		$awardname = $this->request->data['awardname'];
		$organization = $this->request->data['organization'];
		$detail = $this->request->data['detail'];
	
		$dataSource = $this->Award->getDataSource();
		if( $this->Award->updateData($id
									,$name
									,$awardname
									,$organization
									,'0000'
									,$detail) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลรางวัลที่ได้รับเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลรางวัลที่ได้รับ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deleteAward(){
		$this->log('---- AchieveController -> deleteAward ----');
		
		$result = array();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];

		$dataSource = $this->Award->getDataSource();
		if( $this->Award->deleteData($id) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลผลการวิจัยเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลผลการวิจัย กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function uploadFiles(){
		$this->log('Start :: AchieveController :: uploadFiles');
		$objUser = $this->getObjUser();
		$id = $_POST["idUpload"];
		$profile_id = $_GET["id"];
		$uploadfor = $_GET['uploadfor'];
	
// 		if($_FILES["upload"]["size"]>25000000){
// 			$this->redirect(array("controller" => "Achieve", "action" => "?id=".$objUser['id']));
// 			$this->log('Maximum file > 25 MB , not upload!!');
// 			return;
// 		}
	
		switch ($uploadfor){
			case 'award': $uploadfor='award'; break;
		}
		$directory = "files/".$uploadfor."/".$id."/";
		// 		$splitFileName = explode(".", $_FILES["upload"]["name"]);
		// 		$extensionFile = ".".$splitFileName[count($splitFileName)-1];
		// 		$fileName = '2-img-'.time().$extensionFile;
		$fileName = $_FILES["upload"]["name"];
		//echo $_FILES["upload"]["size"]; //24.7 MB = 24710068, limit 25000000
		$this->log('directory = '.$directory.'  fileName = '.$fileName);
		$result = '';
	
		if ( $this->checkDirectory($directory) ) {
			
			//TODO:Check folder limit for 25MB.
			$totalsize = 0;
			if($dir = @opendir($directory)){
				while (($file = readdir($dir)) !== false)
				{
					if(is_file($directory.$file)){
						$totalsize += filesize($directory.$file);
					}
				}
			}
			$totalsize += $_FILES["upload"]["size"];
			
			if($totalsize<=26214400){ //$totalsize<=25MB

				//TODO: Upload Files.
				$this->log('TEMP FILE = '.$_FILES["upload"]["tmp_name"]);
				if ( move_uploaded_file($_FILES["upload"]["tmp_name"]	// temp_file
						, $directory."/".$fileName) ) {	// path file
				} else {
					$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
				}
			}else{
				$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
			}
		} else {
			$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
		}
		$this->redirect(array("controller" => "Achieve", "action" => "?id=".$profile_id));
		$this->log('End :: AchieveController :: uploadFiles');
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function crop(){
	
		$this->log('START :: AchieveController -> crop()');
	
// 		$this->log($this->request->data);
		
		$objUser = $this->getObjUser();
		
		$dataname = $this->request->data["dataname"];
		$dataid = $this->request->data["dataid"];
		$profileid = $this->request->data["profileid"];
		
		$imgPath = '';
		$raw_imgPath = '';
			
		$directory = "";
		switch($dataname){
			case "award" :
				$directory = "img/award";
				break;
			default : 
		}
			
		if(!empty($dataname) && !empty($dataid) && !empty($directory)){
			
			$this->log($_FILES["file_upload"]["name"]);
			
			$splitFileName = explode(".", $_FILES["file_upload"]["name"]);
			$extensionFile = ".".$splitFileName[count($splitFileName)-1];
			$fileName = $dataid.$extensionFile;
			
			if ( $this->checkDirectory($directory) ) {
			
				$tmp1_fileName = $directory."/"."tmp1_".$fileName;
				$tmp2_fileName = $directory."/"."tmp2_".$fileName;
					
				if ( move_uploaded_file($_FILES["file_upload"]["tmp_name"]	// temp_file
						, $tmp1_fileName) ) {
			
					$magicianObj = new imageLib($tmp1_fileName);
					$magicianObj->resizeImage(500, 1, 'landscape');
					$magicianObj->saveImage($tmp2_fileName, 100);
						
					unlink($tmp1_fileName);
			
					$imgPath = $tmp2_fileName;
					$raw_imgPath = base64_encode($imgPath);
			
				}
					
			}				
		}else{
			$this->redirect(array("controller" => "Achieve", "action" => "index?id=".$objUser['id']));
		}
	
		$this->layout='public';
		$this->set(compact('imgPath', 'raw_imgPath', 'dataname', 'dataid', 'profileid'));
	
		$this->log('END :: AchieveController -> crop()');
	
	}
	
	public function ajax_crop(){
		$this->log('START :: AchieveController -> ajax_crop()');
	
		$result = array();
	
		$raw_imgPath = $this->request->data['imgpath'];
		$cropInfo = $this->request->data['cropInfo'];
		$dataname = $this->request->data['dataname'];
		$dataid = $this->request->data['dataid'];
		
		$objUser = $this->getObjUser();
	
		$directory = "";
		$model = "";
		switch($dataname){
			case "award" :
				$directory = "img/award";
				$model = $this->Award;
				break;
			default :
		}
		
		$imgPath = '';
		if(!empty($dataname) && !empty($dataid) && !empty($raw_imgPath)){
			$imgPath = base64_decode($raw_imgPath);
				
			$splitFileName = explode(".", $imgPath);
			$extensionFile = ".".$splitFileName[count($splitFileName)-1];
			$fileName = $dataid.$extensionFile;
				
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
				$magicianObj->resizeImage(100, 1, 'landscape');
				$magicianObj->saveImage($directory."/".$fileName, 100);
	
				unlink($imgPath);
				unlink($tmp3_fileName);
	
				if( $model->updateThumbPath($dataid, $directory."/".$fileName)
					/*TODO: update data to data table, as research, otherwork, award, etc.*/){

					$result['status'] = true;
					$result['message'] = 'อัพโหลดรูปภาพ เรียบร้อย';
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
	
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	
		$this->log('END :: AchieveController -> ajax_crop()');
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function deleteFile(){
		$this->log('Start :: AchieveController :: deleteFile');
		$path = $this->request->data['path'];
		unlink($path);
		$status = 1;
		$message = 'สำเร็จ';
		$this->log('message = '.$message);
		$this->log('status = '.$status);
		$this->layout='ajax';
		$this->set('message', json_encode(array('status'=>$status,'message'=>$message)));
		$this->render('response');
		$this->log('End :: AchieveController :: deleteFile');
	}
	/* --------------------------------------------------------------------------------------------------- */
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
				if ( chmod($directory, 0777) ) {
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
	/* --------------------------------------------------------------------------------------------------- */
	public function updateSortableSeq(){
		$this->log('---- AchieveController -> updateSortableSeq ----');
		
		//$this->log($this->request->data);
		$result = array();
		$flagUpdateData = false;
		$id = $this->request->data['sortable_id'];
		$data = $this->request->data['data'];
		$countData = count($data);
		
		if( $id==='award' ){
			$dataSource = $this->Award->getDataSource();
			$dataSource->begin();
			for( $i=0;$i<$countData;$i++ ){
				$flagUpdateData = $this->Award->updateSeq($data[$i]['id']
																	,$data[$i]['seq']);
				if( !$flagUpdateData ){
					break;
				}
			}
			if( $flagUpdateData ){
				$dataSource->commit();
				$result['flg'] = 1;
				$result['msg'] = 'การแก้ไขลำดับ ข้อมูลผลงานวิจัยเสร็จเรียบร้อย';
			}else{
				$dataSource->rollback();
				$result['flg'] = -1;
				$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขกิจกรรมที่เข้าร่วมเ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			}
		}else{
			$result['flag'] = -1;
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขกิจกรรมที่เข้าร่วมเ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
}