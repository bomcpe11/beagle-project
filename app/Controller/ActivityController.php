<?php
class ActivityController extends AppController {
	public $names = "ActivityController";
	public $uses = array('Activity','Profile','JoinActivity');
	
	public function index() {
		$this->setTitle('ข้อมูลกิจกรรม');
		$this->log('Start :: ActivityController :: index');
		
		$objUser = $this->getObjUser();
		$id = $_GET["id"];
		$this->log('ActivityController :: index => ID ='.$id);
		$sql = " id = ".$id;
		
		$result = $this->Activity->getDataByStmtSql($sql);
		$flagJoinActivity = -1;
		$checkJoinActivity = $this->JoinActivity->getDataByProfileIdActivityId($objUser["id"],$id);
		if( count($checkJoinActivity)>0 ){
			$flagJoinActivity = 1;
		}
		
		$this->set("result", $result);
		$this->set("flagJoinActivity", $flagJoinActivity);
		$this->log('ActivityController :: index => Result ='.$result[0]["activities"]["name"]);
		$this->log('End :: ActivityController :: index');
	}
	
	public function addactivity(){
		$this->setTitle('เพิ่มกิจกรรม');
		$this->log('Start :: ActivityController :: addactivity');
		$this->log('END :: ActivityController :: addactivity');
	}
	
	public function insertActivity(){
		$this->log('Start :: ActivityController :: insertActivity');
		$activityName = $this->request->data['activityName'];
		$startDate = $this->request->data['startDate'];
		$endDate = $this->request->data['endDate'];
		$location = $this->request->data['location'];
		$shortdesc = $this->request->data['shortdesc'];
		$genname = $this->request->data['genname']; 
		$longdesc = $this->request->data['longdesc'];
		
		$this->log('activityName => '.$activityName);
		$arr = explode("/", $startDate);
		$startDate = ($arr[2]-543)."-".$arr[1]."-".$arr[0];
		$arrEnddate = explode("/", $endDate);
		$endDate = ($arrEnddate[2]-543)."-".$arrEnddate[1]."-".$arrEnddate[0];
		$this->log('startDate => '.$startDate);
		$this->log('endDate => '.$endDate);
		$this->log('location => '.$location);
		$this->log('shortdesc => '.$shortdesc);
		$this->log('genname => '.$genname);
		$this->log('longdesc => '.$longdesc);
		
		$dataSource = $this->Activity->getDataSource();
		if( $this->Activity->insertActivities($activityName,
													  $startDate,
						                              $endDate,
													  $location,
													  $shortdesc,
													  $genname,
													  $longdesc) ){
			$dataSource->commit();
			$status = 1;
			$message = 'บันทึกข้อมูล สำเร็จ';
		}else{
			$dataSource->rollback();
			$status = -1;
			$message = 'เกิดข้อผิดพลาดใน การบันทึกข้อมูลกิจกรรม กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		$this->log('message = '.$message);
		$this->log('status = '.$status);
		$this->layout='ajax';
		$this->set('message', json_encode(array('status'=>$status,'message'=>$message)));
		$this->render('response');
		$this->log('END :: ActivityController :: insertActivity');
	}
	
	public function editactivity(){
		$this->setTitle('แก้ไขกิจกรรม');
		$this->log('Start :: ActivityController :: editactivity');
		$id = $_GET["id"];
		$this->log('ActivityController :: index => ID ='.$id);
		$sql = " id = ".$id;
		$result = $this->Activity->getDataByStmtSql($sql);
		$this->set("result", $result);
		$this->log('ActivityController :: index => Result ='.$result[0]["activities"]["name"]);
		$this->log('End :: ActivityController :: editactivity');
	}
	
	public function updateActivity(){
		$this->log('Start :: ActivityController :: editActivity');
		$id = $this->request->data['id'];
		$activityName = $this->request->data['activityName'];
		$startDate = $this->request->data['startDate'];
		$endDate = $this->request->data['endDate'];
		$location = $this->request->data['location'];
		$shortdesc = $this->request->data['shortdesc'];
		$genname = $this->request->data['genname'];
		$longdesc = $this->request->data['longdesc'];
	
		$this->log('id => '.$id);
		$this->log('activityName => '.$activityName);
		$arr = explode("/", $startDate);
		$startDate = ($arr[2]-543)."-".$arr[1]."-".$arr[0];
		$arrEnddate = explode("/", $endDate);
		$endDate = ($arrEnddate[2]-543)."-".$arrEnddate[1]."-".$arrEnddate[0];
		$this->log('startDate => '.$startDate);
		$this->log('endDate => '.$endDate);
		$this->log('location => '.$location);
		$this->log('shortdesc => '.$shortdesc);
		$this->log('genname => '.$genname);
		$this->log('longdesc => '.$longdesc);
	
		if( $this->Activity->updateActivity($id,
											$activityName,
											$startDate,
											$endDate,
											$location,
											$genname,
											$shortdesc,
											$longdesc) ){
			$status = 1;
			$message = 'บันทึกข้อมูล สำเร็จ';
		}else{
			$status = -1;
			$message = 'เกิดข้อผิดพลาดใน การบันทึกข้อมูลกิจกรรม กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		$this->log('message = '.$message);
		$this->log('status = '.$status);
		$this->layout='ajax';
		$this->set('message', json_encode(array('status'=>$status,'message'=>$message)));
		$this->render('response');
		$this->log('END :: ActivityController :: editActivity');
	}
	
	public function uploadImages(){
		$this->log('Start :: ActivityController :: uploadImages');
		
		$objUser = $this->getObjUser();
		
		//$this->log($_REQUEST);
// 		$this->log($_FILES);
// 		$this->log($this->webroot);
		$callback = $this->request->query['CKEditorFuncNum'];
		
		//TODO: Upload image file to /img/activities/
		
		// gen directory
		$directory = "img/activities/".$objUser["id"];
		
		$splitFileName = explode(".", $_FILES["upload"]["name"]);
		$extensionFile = ".".$splitFileName[count($splitFileName)-1];
		$fileName = $objUser["id"].'-img-'.time().$extensionFile;
		
		$result = '';
		//*** upload file
		if ( $this->checkDirectory($directory) ) {
			if ( move_uploaded_file($_FILES["upload"]["tmp_name"]	// temp_file
					, $directory."/".$fileName) ) {	// path file
			} else {
				$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
			}// if else
		} else {
			$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
		}// if
		
// 		$url='/jstphub/app/webroot/img/profiles/'.$objUser['id'].'/'.$objUser['id'].'-xxxx.jpg';
		$url=$this->webroot."app/webroot/".$directory."/".$fileName;
		$msg='';
		$this->log('End :: ActivityController :: uploadImages');
		//$this->set('message', json_encode(array('status'=>'1','message'=>'Success')));
		$output = '<html><body><script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$callback.', "'.$url.'","'.$msg.'");</script></body></html>';
		$this->set('message', $output);
		$this->layout='ajax';
		$this->render('response');
	}
	
	public function uploadFiles(){
		$this->log('Start :: ActivityController :: uploadFiles');
	
		//$objUser = $this->getObjUser();
	
		//$this->log($_REQUEST);
		// 		$this->log($_FILES);
		// 		$this->log($this->webroot);
		//$callback = $this->request->query['CKEditorFuncNum'];
	
		//TODO: Upload image file to /img/activities/
	
		// gen directory
		$directory = "files/activities/2/2"; //$objUser["id"];
	
		$splitFileName = explode(".", $_FILES["upload"]["name"]);
		//$extensionFile = ".".$splitFileName[count($splitFileName)-1];
		$fileName = '2-img-'.time();//.$extensionFile;
	
		$result = '';
		//*** upload file
		if ( $this->checkDirectory($directory) ) {
			if ( move_uploaded_file($_FILES["upload"]["tmp_name"]	// temp_file
					, $directory."/".$fileName) ) {	// path file
			} else {
				$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
			}// if else
		} else {
			$result = "บันทึกข้อมูล ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
		}// if
	
		// 		$url='/jstphub/app/webroot/img/profiles/'.$objUser['id'].'/'.$objUser['id'].'-xxxx.jpg';
		$url=$this->webroot."app/webroot/".$directory."/".$fileName;
		$msg='';
		$this->log('End :: ActivityController :: uploadImages');
		//$this->set('message', json_encode(array('status'=>'1','message'=>'Success')));
		$output = '<html><body><script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$callback.', "'.$url.'","'.$msg.'");</script></body></html>';
		$this->set('message', $output);
		$this->layout='ajax';
		$this->render('response');
	}
	
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
	
	public function saveNewActivity(){
		$this->log('---- Activity -> saveNewActivity ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$activity_id = $this->request->data['activity_id'];
		$position = $this->request->data['position'];
		
		$checkActivity = $this->JoinActivity->getDataByProfileIdActivityId($objUser['id'],$activity_id);
		if( empty($checkActivity) ){
			$dataSource = $this->JoinActivity->getDataSource();
			if( $this->JoinActivity->insertData($objUser['id'], $activity_id, $position)){
				$dataSource->commit();
				
				$result['flg'] = 1;
				$result['msg'] = 'บันทึกการเข้าร่วมกิจกรรม สำเร็จ';
			}else{
				$dataSource->rollback();
				
				$result['flg'] = -1;
				$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลส่วนตัว กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			}
		}else{
			$result['flg'] = 0;
			$result['msg'] = 'คุณได้เข้าร่วมกิจกรรมนี้แล้ว';
		}
		
		//$this->log(print_r($result,true));
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
}