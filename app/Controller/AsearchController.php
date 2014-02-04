<?php
session_start();
class AsearchController extends AppController{
	public $names = 'Asearch';
	public $uses = array('Activity','JoinActivity');
	
	public function index(){
		$this->log('---- Asearch->index() ----');
		$this->set('page_title', 'ค้นหากิจกรรม');
	}
	public function search(){
		$this->log('---- Asearch->search() ----');
		
		$result = array();
		$search_width = $this->request->data['search_width'];
		
		$result = $this->Activity->getDataByStmtSql($search_width);
		$countData = count($result);
		for( $i=0;$i<$countData;$i++ ){
			if( !empty($result[$i]['activities']['startdtm']) ){
				$result[$i]['activities']['startdtm'] = $this->DateThai($result[$i]['activities']['startdtm']);
			}else{
				$result[$i]['activities']['startdtm']='';
			}
		}
		//$this->log(print_r($result,true));
		
		$this->layout="ajax";
		$this->set("message", json_encode($result));
		$this->render("response");
	}
	public function saveActivity(){
		$this->log('---- Asearch->saveActivity() ----');
		
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