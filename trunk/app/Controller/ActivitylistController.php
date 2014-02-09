<?php
class ActivitylistController extends AppController {
	public $names = "ActivitylistController";
	public $uses = array('Activity','Profile');
	
	public function index() {
		$this->setTitle('ข้อมูลกิจกรรม');
		$this->getActivitylist();
	}
	
	function getActivitylist(){
		$this->log('Start :: ActivitylistController :: getActivitylist');
		$result = $this->Activity->getActivites();
		$this->log($result[0]["activities"]["name"]);
		$this->set("result", $result);
		 
		$this->log("END :: ActivitylistController :: getActivitylist");
		
	}

	function deleteActivity(){
		$this->log('START :: ActivitylistController -> deleteActivity');
		
		$rs;
		$message = '';
		$id = $this->request->data['id'];
		
		$dataSource = $this->Activity->getDataSource();
		if( $rs = $this->Activity->deleteActivites($id) ){
			$dataSource->commit();
			$message = 'ลบข้อมูล สำเร็จ';
		}else{
			$dataSource->rollback();
			$message = 'เกิดข้อผิดพลาดใน การลบข้อมูลกิจกรรม กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		$this->log('message='.$message);
		$this->layout='ajax';
		$this->set('message', json_encode(array('status'=>$rs,'message'=>$message)));
		$this->render('response');
		$this->log('END :: ActivitylistController -> deleteActivity');
	}
}