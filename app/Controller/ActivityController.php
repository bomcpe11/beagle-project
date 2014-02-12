<?php
class ActivityController extends AppController {
	public $names = "ActivityController";
	public $uses = array('Activity','Profile');
	
	public function index() {
		$this->setTitle('ข้อมูลกิจกรรม');
		$this->log('Start :: ActivityController :: index');
		$id = $_GET["id"];
		$this->log('ActivityController :: index => ID ='.$id);
		$sql = " id = ".$id;
		$result = $this->Activity->getDataByStmtSql($sql);
		$this->set("result", $result);
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
		
		$dataSource = $this->Activity->getDataSource();
		if( $this->Activity->insertActivities($activityName,
													  $startDate,
						                              $endDate,
													  $location,
													  $shortdesc,
													  $genname) ){
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
	
		if( $this->Activity->updateActivity($id,
											$activityName,
											$startDate,
											$endDate,
											$location,
											$shortdesc,
											$genname) ){
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
		//$this->log($_REQUEST);
		//$this->log($_FILES);
		$callback = $this->request->query['CKEditorFuncNum'];
		
		//TODO: Upload image file to /img/activities/
		
		$url='/jstphub/app/webroot/img/profiles/1/1.jpg';
		$msg='';
		$this->log('End :: ActivityController :: uploadImages');
		//$this->set('message', json_encode(array('status'=>'1','message'=>'Success')));
		$output = '<html><body><script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$callback.', "'.$url.'","'.$msg.'");</script></body></html>';
		$this->set('message', $output);
		$this->layout='ajax';
		$this->render('response');
	}
}