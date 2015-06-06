<?php
// session_start();
class OtherjstpController extends AppController {
	/* ------------------------------------------------------------------------------------------------ */
	public $uses = array('Profile', 'Gvar', 'Recruit');
	/* ------------------------------------------------------------------------------------------------ */
	public function index(){
		$this->log('---- Psearch -> index ----');
		
		$accountRole 	= $this->Gvar->getVarcodeVardesc1ByVarnameVardesc2("ACCOUNT_ROLE", "Y");
		
		$this->set(compact("accountRole"));
		$this->setTitle('ค้นหาบุคคล');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function searchData(){
		$this->log('---- Psearch -> searchData ----');
		
		$result = array();
		//$this->log($this->request->data);
		$keyWord= $this->request->data['keyWord'];
		$searchWidth = $this->request->data['searchWidth'];
		$flagActivity = $this->request->data['flagActivity'];
		$currentPage = $this->request->data['currentPage'];
		if(empty($currentPage)) $currentPage=1;
		$orderBy = $this->request->data['orderBy'];
		$sort = $this->request->data['sort'];
		$recordPerPage = 30;
		$start = $recordPerPage * ($currentPage - 1);
		
		$keyWord = trim($keyWord);
		if($keyWord=="*"){
			//TODO: Search All, limit 0, 200
			$result = $this->Profile->getProfilesByLimit($start,
															$recordPerPage,
															$orderBy,
															$sort);
		}else{
			$result = $this->Profile->getDataForPsearch($keyWord,
														$searchWidth,
														$flagActivity,
														$start,
														$recordPerPage,
														$orderBy,
														$sort);
		}
		$result['record_per_page'] = $recordPerPage;
		//$this->log($result);
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	
	public function admin_updateCustomize(){
		if(!$this->isAdmin){
			return;
		}
		$this->log("START :: OtherjstpController -> admin_updateCustomize()");
		
		$result['status'] = false;
		$result['message'] = '';

		$profileid = $this->request->data["profileid"];
		$profilerole = $this->request->data["profilerole"];
		$profileroleadmin = $this->request->data["profileroleadmin"];
		
		//TODO: update DB.
		if($this->Profile->updateRoleAndRoleAdmin($profileid, $profilerole, $profileroleadmin)){
			$result['status'] = true;
			$result['message'] = 'อัพเดทข้อมูลเรียบร้อย';
		}else{
			$result['message'] = 'เกิดข้อผิดพลาดในการอัพเดทข้อมูล กรุณาติดต่อผู้ดูแลระบบ';
		}

		$this->layout = "ajax_admin";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: OtherjstpController -> admin_updateCustomize()");
	}
	
	public function admin_removeProfile(){
		if(!$this->isAdmin){
			return;
		}
		$this->log("START :: OtherjstpController -> admin_removeProfile()");
		
		$result['status'] = false;
		$result['message'] = '';
		
		$profileid = $this->request->data["profileid"];
		
		//TODO: update DB.
		if($this->Profile->removeProfile($profileid)){
			$this->Recruit->unMemberProfile($profileid);
			$result['status'] = true;
			$result['message'] = 'ลบสมาชิกเรียบร้อย';
		}else{
			$result['message'] = 'เกิดข้อผิดพลาดในการลบสมาชิก กรุณาติดต่อผู้ดูแลระบบ';
		}
		
		$this->layout = "ajax_admin";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: OtherjstpController -> admin_removeProfile()");
	}
}
