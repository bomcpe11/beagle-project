<?php
App::import('Vendor', '/MPDF57/mpdf');
class RecruitmentController extends AppController {
	/* ------------------------------------------------------------------------------------------------ */
	public $uses = array('Recruit', 'Province', 'School', 'RecruitComment', 'Gvar', 'Profile', 'Family', 'Education');
	/* ------------------------------------------------------------------------------------------------ */
	public function index(){
		$this->log('---- RecruitmentController -> index ----');
		
		$namePrefixs 	= $this->Gvar->getVarcodeVardesc1ByVarname("NAME_PREFIX_TH");
		$sexs			= $this->Gvar->getVarcodeVardesc1ByVarname("SEX_TH");
		$careers		= $this->Gvar->getVarcodeVardesc1ByVarname("CAREER_TH");
		$educations		= $this->Gvar->getVarcodeVardesc1ByVarname("LEVEL_EDUCATION");
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
		$recruitroundid= $this->request->data['recruitroundid'];
		$keyWord= $this->request->data['keyWord'];
		$searchWidth = $this->request->data['searchWidth'];
		$flagActivity = $this->request->data['flagActivity'];
		$currentPage = $this->request->data['currentPage'];
		$orderBy = $this->request->data['orderBy'];
		$sort = $this->request->data['sort'];
		$recordPerPage = 150;
		$start = $recordPerPage * ($currentPage - 1);
		
		$keyWord = trim($keyWord);
		if($keyWord=="*"){
			//TODO: Search All, limit 0, 200
			$result = $this->Recruit->getProfilesByLimit($recruitroundid,
															$start,
															$recordPerPage,
															$orderBy,
															$sort);
		}else{
			$result = $this->Recruit->getDataForPsearch($recruitroundid,
														$keyWord,
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
		
		$id = $this->request->query['recruitid'];
		
		if(!empty($id)){
		
			$recruit = $this->Recruit->getDataById($id);
// 			$this->log($recruit);
			
			$namePrefixs 	= $this->Gvar->getVarcodeVardesc1ByVarname("NAME_PREFIX_TH");
			$sexs			= $this->Gvar->getVarcodeVardesc1ByVarname("SEX_TH");
			$careers		= $this->Gvar->getVarcodeVardesc1ByVarname("CAREER_TH");
			$educations		= $this->Gvar->getVarcodeVardesc1ByVarname("LEVEL_EDUCATION");
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
	/* ------------------------------------------------------------------------------------------------ */
	public function saveNewComment(){
		$this->log('---- RecruitmentController -> saveNewComment ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		$commentTitle = $this->request->data['commentTitle'];
		$commentDetial = $this->request->data['commentDetial'];
		$profileId = $this->request->data['profileId'];
		$commentableType = 'Profile';
		
		$dataSource = $this->RecruitComment->getDataSource();
		if( $this->RecruitComment->insertData($commentTitle
										,$commentDetial
										,$objUser['id']
										,$commentableType
										,$profileId) ){
			$dataSource->commit();
			$result['msg'] = 'เพิ่มความคิดเห็นเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การเพิ่มความคิดเห็น กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deleteComment(){
		$this->log('---- RecruitmentController -> deleteComment ----');
		
		$result = array();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];

		$dataSource = $this->RecruitComment->getDataSource();
		if( $this->RecruitComment->deleteData($id) ){
			$dataSource->commit();
			$result['flg'] = 1;
			$result['msg'] = 'ลบความคิดเห็นเสร็จเรียบร้อย';
		}else{
			$dataSource->rollback();
			$result['flg'] = -1;
			$result['msg'] = 'เกิดข้อผิดพลาดใน การลบความคิดเห็น กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	
	public function recruitexport(){
		if(!$this->getIsAdmin()){$this->redirect(array('controller' => 'Mainmenu'));}
		$recruits = $this->request->data['recruit'];
		
		$result = $this->Recruit->getProfilesByFields($recruits);
		
		
// 		echo '<pre>'; print_r($result[0]); echo '</pre>'; exit();
		
		$this->layout = "xls_file";
// 		$this->layout = "ajax_public";

		$this->set('result', $result);
	}
	
	public function addnewmember_submit(){
		if(!$this->isAdmin){
			return;
		}
		$this->log("START :: RecruitmentController -> addnewmember_submit()");
	
		$result['status'] = false;
		$result['message'] = '';
	
		$id = $this->request->data["id"];
		
		if(!empty($id)){
		
			$recruit = $this->Recruit->getDataById($id);
			$recruit = $recruit[0]['recruits'];
			
			$card_id = $recruit["card_id"];
			$first_name = $recruit["first_name"];
			$family_name = $recruit["family_name"];
			$birthday = $recruit["birthday"];
			$email = $recruit["email"];
			
			$province = $this->Province->getByID($recruit['province_id']);
			$province_name = $province[0]['provinces']['name'];

			$nickname = $recruit['nickname'];
			$address = 'บ้านเลขที่ '.$recruit['address']
						.' หมู่ที่ '.$recruit['address2']
						.' ซอย/ถนน '.$recruit['address3']
						.' ถนน '.$recruit['street']
						.' ตำบล/แขวง '.$recruit['locality']
						.' อำเภอ/เขต '.$recruit['district']
						.' จังหวัด '.$province_name
						.' '.$recruit['zip_code'];
			$telphone = $recruit['telphone'];
			$celphone = $recruit['celphone'];
			$titleth = $recruit['titleth'];
			
			if(!empty($txt_cardid)){ $checkCardId = $this->Profile->checkCardId($txt_cardid); }
			if(!empty($txt_email)){ $checkEmail	= $this->Profile->checkEmail($txt_email); }
			$checkNameTh = $this->Profile->checkNameTh($txt_name, $txt_surname);
			
			if ( !empty($txt_cardid) && count($checkCardId) == 1 ) {
				$result['message'] = "เลขบัตรประจำตัว นี้มีข้อมูลแล้ว";
			} else if ( count($checkNameTh) == 1 ) {
				$result['message'] = "ชื่อ และ นามสกุล นี้มีข้อมูลแล้ว";
			} else if ( !empty($txt_email) && count($checkEmail) == 1 ) {
				$result['message'] = "อีเมล์ นี้มีข้อมูลแล้ว";
			} else{
				//TODO: Insert Data.
				$this->Profile->addnewmemberrecruit('1', $card_id, $first_name, $family_name, $birthday, $email, $nickname, $address, $telphone, $celphone, $titleth);
				$profile = $this->Profile->getProfilesByCardID($card_id);
				$profile = $profile[0]['profiles'];
				$this->Recruit->updateJstpmember($recruit['id'], $profile['id']);
				
				//Insert Family data from recruit.
				$this->saveFamily($profile, $recruit);
				
				//Insert Education data from recruit.
				$this->saveEducation($profile, $recruit);
				
				$result['status'] = true;
				$result['message'] = "ลงทะเบียนสมาชิกเรียบร้อย";
			}
		}else{
			$result['status'] = false;
			$result['message'] = "ไม่พบข้อมูล กรุณาติดต่อผู้ดูแลระบบ";
		}
		
		$this->layout = "ajax_admin";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
	
		$this->log("END :: RecruitmentController -> addnewmember_submit()");
	}
	
	public function unmember_submit(){
		
		if(!$this->isAdmin){
			return;
		}
		
		$this->log("START :: RecruitmentController -> unmember_submit()");
		
		$result['status'] = false;
		$result['message'] = '';
		
		$id = $this->request->data["id"];
		$profileid = $this->request->data["profileid"];
		
		$this->Recruit->unMember($id);
		$this->Profile->removeProfile($profileid);
		
		$result['status'] = true;
		$result['message'] = 'นำรายชื่อออกจากระบบ JSTP เรียบร้อย';
		
		$this->layout = "ajax_admin";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: RecruitmentController -> unmember_submit()");
	}
	
	public function export(){
		if(!$this->getIsAdmin()){$this->redirect(array('controller' => 'Mainmenu'));}
		$recruitids = $this->request->data['recruitid'];
		
		$recruits = $this->Recruit->getDataInIds($recruitids);

		$mpdf=new mPDF('UTF-8', 'A4-L');
		$mpdf->SetAutoFont();
		
		/* Page 1 */
		$page1 = '
				<style>
					body{
						font-size: 14px;
					}
					h1,h2,h3,h4,h5,h6,hr,table{
						margin: 0;
						padding: 0;
					}
					h1{
						font-size: 44px;
					}
					h2{
						font-size: 40px;
					}
					h3{
						font-size: 36px;
					}
					h4{
						font-size: 32px;
					}
					h5{
						font-size: 28px;
					}
					h6{
						font-size: 24px;
					}
					p{
						text-indent: 10px;
					}
					img{
					}
					.page{
						width: 29.7cm;
						height: 21cm;
					}
					.table-data{
						width: 100%;
						color: #3D991F;
						table-layout: fixed;
					}
					.table-data-border{
						width: 100%;
						border-collapse: collapse;
					}
					.table-data-border tr:nth-child(even){
						background-color: #E5EFC6;
					}
					.table-data-border th{
						background-color: #A7C942;
					}
					.table-data-border th, .table-data-border td{
						border: 1px solid #98bf21;
					}
					.underline{
						height: 5px;
						margin-bottom: 10px;
						color: #3D991F;
					}
				</style>
				<body>
					<table border="1">
						'.$this->interviewRowsGenerator($recruits).'
					</table>
				</body>';
		
		$mpdf->WriteHTML($page1);
// 		$mpdf->AddPage('L');
		
		
		$mpdf->Output();
		
		$this->layout = "ajax_public";
// 		$this->set('file_name', 'InterviewForm');
// 		$this->set('mpdf', $mpdf);
// 		$this->set('recruits', $recruits);
// 		$this->layout = "ajax_public";
		$this->render("interviewexport");
	}
	
	private function saveFamily($profile, $recruit){
		$father = $this->explodeByWhiteSpace($recruit['father']);
		$father_career = $recruit['father_career'];
		$mother = $this->explodeByWhiteSpace($recruit['mother']);
		$mother_career = $recruit['$recruit'];
		
		if(!empty($father[0])){
			$this->Family->insertFamily($profile['id']
										,'บิดา'
										,$father[0]
										,$father[1]
										,''
										,$father_career
										,''
										,'1');
		}
		
		if(!empty($mother[0])){
			$this->Family->insertFamily($profile['id']
										,'มารดา'
										,$mother[0]
										,$mother[1]
										,''
										,$mother_career
										,''
										,'1');
		}
	}
	
	private function saveEducation($profile, $recruit){
		
		$schoolid = $recruit['school'];
		$school = $this->School->getRecord($schoolid);
		$level_education = $recruit['level_education'];
		
		if(!empty($school)){
			$this->Education->insertEducation($school[0]['name']
					, ''
					, ''
					, ''
					, ''
					, ''
					, $level_education
					, $profile['id']
					, '0');
		}
		
		$primary_school = $recruit['primary_school'];
		if(!empty($primary_school)){
			$this->Education->insertEducation($primary_school
					, ''
					, ''
					, ''
					, ''
					, ''
					, 'ประถมศึกษา'
					, $profile['id']
					, '1');
		}
		
	}
	
	private function explodeByWhiteSpace($str){
		$parts = preg_split('/\s+/', $str);
		return $parts;
	}
	
	private function interviewRowsGenerator($recruits){
		$content = '';
		foreach($recruits as $recruit){
			$content .= '<TR>
				<TD colspan="2">ชื่อผู้ประเมิน............................................................................. หน่วยงาน............................................................................... วันที่สัมภาษณ์............................................ เวลา..................</TD>
			</TR>
			<TR>
				<TD colspan="2">รายชื่อผู้ร่วมประเมิน.................................................................................................................................................................................................................................................................</TD>
			</TR>
			<TR>
				<TD colspan="2">ชื่อ-สกุล <u>'.$recruit['p']['before_name'].' '.$recruit['p']['first_name'].' '.$recruit['p']['family_name'].'</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				ระดับการศึกษา <u>'.$recruit['p']['level_education'].'</u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				โรงเรียน <u>'.$recruit['p2']['name'].'</u></TD>
			</TR>
			<TR >
				<TD valign="top" width="500" height="100">ความเห็นของผู้ประเมิน</TD>
				<TD valign="top">ผลการสัมภาษณ์</TD>
			</TR>';
		}
		return $content;
	}
}
