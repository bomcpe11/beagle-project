<?php
// session_start();
class MentorexpertController extends AppController {
	/* ------------------------------------------------------------------------------------------------ */
	public $uses = array('Profile', 'Gvar');
	/* ------------------------------------------------------------------------------------------------ */
	public function index(){
		$this->log('---- Mentorexpert -> index ----');
		
		$accountRole 	= $this->Gvar->getVarcodeVardesc1ByVarnameVardesc2("ACCOUNT_ROLE", "Y");
		
		$this->set(compact("accountRole"));
		$this->setTitle('Mentor & Expert');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function searchData(){
		$this->log('---- Mentorexpert -> searchData ----');
		
		$result = array();
		//$this->log($this->request->data);
		$keyWord= $this->request->data['keyWord'];
		$searchWidth = $this->request->data['searchWidth'];
		$flagActivity = $this->request->data['flagActivity'];
		$currentPage = $this->request->data['currentPage'];
		$orderBy = $this->request->data['orderBy'];
		$recordPerPage = 30;
		$limitStart = $recordPerPage * ($currentPage - 1);
		$limitEnd = $recordPerPage * $currentPage;
		
		$keyWord = trim($keyWord);
// 		if($keyWord=="*"){
			//TODO: Search All, limit 0, 200
			$result = $this->Profile->getProfilesMentorExpertByLimit($limitStart,
															$limitEnd,
															$orderBy);
// 		}else{
// 			$result = $this->Profile->getDataForPsearch($keyWord,
// 														$searchWidth,
// 														$flagActivity,
// 														$limitStart,
// 														$limitEnd,
// 														$orderBy);
// 		}
		$result['record_per_page'] = $recordPerPage;
		//$this->log($result);
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	
}
