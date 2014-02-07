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
		$rs = "1111";
		$message = "Test";
		$this->log('message='.$message);
		$this->layout='ajax';
		$this->set('message', json_encode(array('status'=>$rs,'message'=>$message)));
		$this->render('response');
	}
	
	public function editactivity(){
		$this->setTitle('แก้ไขกิจกรรม');
	}
}