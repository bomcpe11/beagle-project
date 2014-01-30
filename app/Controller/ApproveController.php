<?php
class ApproveController extends AppController{
	public $name='Approve';
	public $uses=array('Profile');
	
	public function index(){
		$this->log('---- Approve->index() ----');
		
		$this->setTitle('Approve');
		$is_approve = 0;
		$dataList = $this->Profile-> getDataByIsApprove($is_approve);
		//$this->log(print_r($dataList,true));
		
		$this->set(compact('dataList'));
	}
	public function goApprove(){
		$this->log('---- Approve->goApprvoe() ----');
		
		$this->setTitle('ข้อมูลสมาชิก');
		//$this->log(print_r($this->request,true));
		$profile_id = $this->request->query['profile_id'];
		$dataProfile = $this->Profile->getDataById($profile_id);
		
		$this->set(compact('dataProfile'));
		$this->render('go_approve');
	}
	public function doApprove(){
		$this->log('---- Approve->doApprove() ----');
		
		$result = array();
		$profile_id = $this->request['data']['profile_id'];
		$is_approve = '1';
		$dataSource = $this->Profile->getDataSource();
		
		if( $this->Profile->updateIsApprove($profile_id,$is_approve) ){
			$dataSource->commit();
			
			$result['flg'] = 1;
			$result['msg'] = 'ยืนยันข้อมูล เรียบร้อย';
		}else{
			$dataSource->rollback();
			
			$result['flg'] = -1;
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลส่วนตัว กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
}