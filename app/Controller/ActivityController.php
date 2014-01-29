<?php
class ActivityController extends AppController {
	public $names = "ActivityController";
	public $uses = array('Activity','Profile');
	
	public function index() {
		$this->setTitle('ข้อมูลกิจกรรม');
	}
	
	public function addactivity(){
		$this->setTitle('เพิ่มกิจกรรม');
	}
	
	public function editactivity(){
		$this->setTitle('แก้ไขกิจกรรม');
	}
}