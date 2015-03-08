<?php
// session_start();
class RecruitmentController extends AppController {
	/* ------------------------------------------------------------------------------------------------ */
	public $uses = array('Recruit', 'Province', 'School', 'Gvar');
	/* ------------------------------------------------------------------------------------------------ */
	public function index(){
		$this->log('---- RecruitmentController -> index ----');
		
		$namePrefixs 	= $this->Gvar->getVarcodeVardesc1ByVarname("NAME_PREFIX_TH");
		$sexs			= $this->Gvar->getVarcodeVardesc1ByVarname("SEX_TH");
		$careers		= $this->Gvar->getVarcodeVardesc1ByVarname("CAREER_TH");
		$educations		= $this->Gvar->getVarcodeVardesc1ByVarname("EDUCATION_STEP");
		$infors			= $this->Gvar->getVarcodeVardesc1ByVarname("INFOR_TH");
		
		$provinces = $this->Province->getForDDL();
		$schools = $this->School->getForDDL();
		
		$this->set(compact('provinces', 'schools', 'namePrefixs', 'sexs', 'careers', 'educations', 'infors'));
		$this->setTitle('Member Recruitment Manager');
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
		$orderBy = $this->request->data['orderBy'];
		$sort = $this->request->data['sort'];
		$recordPerPage = 30;
		$start = $recordPerPage * ($currentPage - 1);
		
		$keyWord = trim($keyWord);
		if($keyWord=="*"){
			//TODO: Search All, limit 0, 200
			$result = $this->Recruit->getProfilesByLimit($start,
															$recordPerPage,
															$orderBy,
															$sort);
		}else{
			$result = $this->Recruit->getDataForPsearch($keyWord,
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
	
	public function save(){
		
		$result['status'] = false;
		$result['message'] = '';
		
		$recruit = $this->request->data['recruit'];
		//print_r($recruit);
		
		if($this->Recruit->insert($recruit)){
			$result['status'] = true;
			$result['message'] = 'บันทึกข้อมูลเรียบร้อย';
		}else{
			$result['message'] = 'เกิดข้อผิดพลาดในการบันทึกข้อมูล กรุณาติดต่อผู้ดูแลระบบ';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	
	public function view(){
		$this->log('---- RecruitmentController -> view ----');
		
		$id = $this->request->query['id'];
		
		if(!empty($id)){
		
			$recruit = $this->Recruit->getDataById($id);
			
			$namePrefixs 	= $this->Gvar->getVarcodeVardesc1ByVarname("NAME_PREFIX_TH");
			$sexs			= $this->Gvar->getVarcodeVardesc1ByVarname("SEX_TH");
			$careers		= $this->Gvar->getVarcodeVardesc1ByVarname("CAREER_TH");
			$educations		= $this->Gvar->getVarcodeVardesc1ByVarname("EDUCATION_STEP");
			$infors			= $this->Gvar->getVarcodeVardesc1ByVarname("INFOR_TH");
			
			$provinces = $this->Province->getForDDL();
			$schools = $this->School->getForDDL();
			
			$this->set(compact('recruit', 'provinces', 'schools', 'namePrefixs', 'sexs', 'careers', 'educations', 'infors'));
			
			$this->setTitle('Member Recruitment Manager');
		}else{
			//TODO: redirect to home
		}
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
