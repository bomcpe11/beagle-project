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
		
		//$this->log($this->request->query, 'debug');
		$orderBy = empty($this->request->query['orderBy'])? 'name': $this->request->query['orderBy'];
		$sort = empty($this->request->query['sort'])? 'ASC': $this->request->query['sort'];
		$currentPage = empty($this->request->query['currentPage'])? '1': $this->request->query['currentPage'];
		$recordPerPage = 30;
		$start = $recordPerPage * ($currentPage - 1);
		$totalRecord = 0;
		$resultQuery = array();
		$result = array();
		
		$resultQuery = $this->Activity->getActivitesPagination($start, $recordPerPage, $orderBy, $sort);
		//$this->log($resultQuery, 'debug');
		$result = $resultQuery['data'];
		$totalRecord = $resultQuery['total_data'];
		$this->set(compact('result', 
							'totalRecord', 
							'orderBy', 
							'sort', 
							'currentPage', 
							'recordPerPage', 
							'start', 
							'totalRecord',
							'orderBy',
							'sort'));
		 
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