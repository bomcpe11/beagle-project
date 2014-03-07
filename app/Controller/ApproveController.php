<?php
class ApproveController extends AppController{
	public $name='Approve';
	public $uses=array('Profile');
	
	function beforeFilter(){
		parent::beforeFilter();
		$this->log('Start # ApproveController -> beforeFilter()');
		
		$dataProfile =  parent::getObjUser();
// 		$this->log($dataProfile['role']);

		$role = $dataProfile['role'];
		if($role && $role=='1'){
			
		}else{
			$this->redirect(array("controller" => "Login", "action" => "index"));
		}
		
	}
	
	public function index(){
		$this->log('---- Approve->index() ----');
		
		$this->setTitle('Approve');
		$is_approve = 0;
		$dataList = $this->Profile-> getDataByIsApprove($is_approve);
		$countData = count($dataList);
		for( $i=0;$i<$countData;$i++ ){
			$dataList[$i]['profiles']['age'] = $this->getAge($dataList[$i]['profiles']['birthday']);
		}
		//$this->log(print_r($dataList,true));
		
		$this->set(compact('dataList', 'age'));
	}
	public function goApprove(){
		$this->log('---- Approve->goApprvoe() ----');
		
		$this->setTitle('ข้อมูลสมาชิก');
		//$this->log(print_r($this->request,true));
		$profile_id = $this->request->query['profile_id'];
		$dataProfile = $this->Profile->getDataById($profile_id);
		//$this->log(print_r($dataProfile,true));
		
		$birthday = $this->DateThai($dataProfile[0]['profiles']['birthday']);
		$age = $this->getAge($dataProfile[0]['profiles']['birthday']);
		
		$this->set(compact('dataProfile', 'birthday', 'age'));
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
		//$this->log(print_r($result,true));
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
}