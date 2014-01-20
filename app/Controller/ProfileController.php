<?php
session_start();
class ProfileController extends AppController {

	public $names = 'ProfileController';
	public $uses = array('Gvar'
						,'Profile'
						,'Family'
						,'Education'
						,'Research'
						,'Comment');

	public function index(){
		$this->log('---- ProfileController -> index ----');
		
		$objUser = $this->getObjUser();
		//$this->log(print_r($objUser, true));
		$fullNameTh = null;
		$birthday = null;
		$age = null;
		
		/* fullName */
		if( $objUser['position'] ){
			$fullNameTh = $objUser['position'].' '.$objUser['nameth'].' '.$objUser['lastnameth'];
		} else{
			$fullNameTh = $objUser['titleth'].' '.$objUser['nameth'].' '.$objUser['lastnameth']; 
		} 
		
		/* birthday */
		$arrayBirthday = explode('-', $objUser['birthday']);	// <<< Y-m-d
		$birthday .= $arrayBirthday[2];
		switch ($arrayBirthday[1]) {
			case "01":	$birthday .= " มกราคม"; break;
			case "02":	$birthday .= " กุมภาพันธ์"; break;
			case "03":	$birthday .= " มีนาคม"; break;
			case "04":	$birthday .= " เมษายน"; break;
			case "05":	$birthday .= " พฤษภาคม"; break;
			case "06":	$birthday .= " มิถุนายน"; break;
			case "07":	$birthday .= " กรกฏาคม"; break;
			case "08":	$birthday .= " สิงหาคม"; break;
			case "09":	$birthday .= " กันยายน"; break;
			case "10":	$birthday .= " ตุลาคม"; break;
			case "11":	$birthday .= " พฤศจิกายน"; break;
			case "12":	$birthday .= " ธันวาคม"; break;
		}// switch
		$birthday .= " พ.ศ. " . ( intval($arrayBirthday[0]) + 543 );
		
		/* age */
		$now = date('Y-m-d');
		$diffDate = abs(strtotime($now) - strtotime($objUser['birthday']));
		$age = floor($diffDate / (365*60*60*24)) . ' ปี';
		
		/* prefix name */
		$namePrefixTh 	= $this->Gvar->getVarcodeVardesc1ByVarname('NAME_PREFIX_TH');
		$namePrefixEn 	= $this->Gvar->getVarcodeVardesc1ByVarname('NAME_PREFIX_EN');
		
		/* families */
		$listFamily = $this->Family->getFamiliesByProfileId($objUser['id']);
		//$this->log(print_r($listFamily, true));
		
		/* education */
		$listEducation = $this->Education->getEducationByProfileId($objUser['id']);
		//$this->log(print_r($listEducation, true));
		
		/* research */
		$listResearch = $this->Research->getDataByProfileId('9');
		
		/* comment */
		$listComment = $this->Comment->getDataByProfileId('1');
		
		/* set data to view*/
		$this->set(compact('fullNameTh', 'birthday'
							,'age', 'namePrefixTh'
							,'namePrefixEn', 'listFamily'
							,'listEducation', 'listResearch'
							,'listComment'));
		$this->set("page_title","ข้อมูลส่วนตัว - " . $objUser["titleth"] . " " . $objUser["nameth"] . " " . $objUser["lastnameth"]);
	}
	/* ------------------------------------------------------------------------------------------------------- */
	public function updateProfileAjax() {
		$this->log("START :: ProfileController -> updateProfileAjax()");
		
		$result 		= "";
		$titleTh 		= $this->request->data["titleTh"];
		$nameTh 		= $this->request->data["nameTh"];
		$lastnameTh 	= $this->request->data["lastnameTh"];
		$titleEng 		= $this->request->data["titleEng"];
		$nameEng 		= $this->request->data["nameEng"];
		$lastnameEng 	= $this->request->data["lastnameEng"];
		$nickname 		= $this->request->data["nickname"];
		$generation 	= $this->request->data["generation"];
		$birthday 		= $this->request->data["birthday"];
		$nationality 	= $this->request->data["nationality"];
		$religious 		= $this->request->data["religious"];
		$socialStatus 	= $this->request->data["socialStatus"];
		$studyStatus 	= $this->request->data["studyStatus"];
		$address 		= $this->request->data["address"];
		$telPhone 		= $this->request->data["telPhone"];
		$celPhone	 	= $this->request->data["celPhone"];
		$email 			= $this->request->data["email"];
		$blogAddress 	= $this->request->data["blogAddress"];
		$profileId 		= $this->request->data["profileId"];
		
		if ( $this->Profile->updateProfile($profileId
												,$titleTh
												,$nameTh
												,$lastnameTh
												,$titleEng
												,$nameEng
												,$lastnameEng
												,$nickname
												,$generation
												,$this->changeFormatDate($birthday)
												,$nationality
												,$religious
												,$socialStatus
												,$studyStatus
												,$address
												,$telPhone
												,$celPhone 
												,$email
												,$blogAddress) ) {
			$result = "การแก้ไขข้อมูลส่วนตัวเสร็จเรียบร้อย";								
		} else {
			$result = "เกิดข้อผิดพลาดใน การแก้ไขข้อมูลส่วนตัว กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์";
		}
		
		$this->layout = "ajax";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
												
		$this->log("END :: ProfileController -> updateProfileAjax()");
	}
	public function saveNewFamily(){
		$this->log('START :: ProfileController -> saveNewFamily');
		
		$message = '';
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$relation = $this->request->data['relation'];
		$name = $this->request->data['name'];
		$lastname = $this->request->data['lastname'];
		$education = $this->request->data['education'];
		$occupation = $this->request->data['occupation'];
		$position = $this->request->data['position'];
		
		$dataSource = $this->Family->getDataSource();
		if( $this->Family->insertFamily($objUser['id'], $relation, $name
										, $lastname, $education, $occupation, $position) ){
			$dataSource->commit();
			$message = 'บันทึกข้อมูล สำเร็จ';
		}else{
			$dataSource->rollback();
			$message = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลส่วนตัว กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode(array('message'=>$message)));
		$this->render('response');
		
		$this->log('END :: ProfileController -> saveNewFamily');
	}
	public function editFamily(){
		$this->log('START :: ProfileController -> editFamily');
		
		$message = '';
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$family_id = $this->request->data['id'];
		$relation = $this->request->data['relation'];
		$name = $this->request->data['name'];
		$lastname = $this->request->data['lastname'];
		$education = $this->request->data['education'];
		$occupation = $this->request->data['occupation'];
		$position = $this->request->data['position'];
		
		$dataSource = $this->Family->getDataSource();
		if( $this->Family->updateFamily($objUser['id'], $relation
										, $name, $lastname
										, $education, $occupation
										, $position, $family_id) ){
			$dataSource->commit();
			$message = 'แก้ไขข้อมูล สำเร็จ';
		}else{
			$dataSource->rollback();
			$message = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลส่วนตัว กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode(array('message'=>$message)));
		$this->render('response');
		
		$this->log('END :: ProfileController -> editFamily');
	}
	public function deleteFamily(){
		$this->log('START :: ProfileController -> deleteFamily');
		
		$message = '';
		$id = $this->request->data['id'];
		
		$dataSource = $this->Family->getDataSource();
		if( $this->Family->deleteFamily($id) ){
			$dataSource->commit();
			$message = 'ลบข้อมูล สำเร็จ';
		}else{
			$dataSource->rollback();
			$message = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลส่วนตัว กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode(array('message'=>$message)));
		$this->render('response');
		
		$this->log('END :: ProfileController -> deleteFamily');
	}
	public function saveNewEducation(){
		$this->log('START :: ProfileController -> saveNewEducation');
		
		$message = '';
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$edutype = $this->request->data['edutype'];
		$name = $this->request->data['name'];
		$faculty = $this->request->data['faculty'];
		$major = $this->request->data['major'];
		$isGraduate = ( ($this->request->data['isGraduate']=='true')?'1':'0' );
		$startyear = empty($this->request->data['startyear'])?'null':intval($this->request->data['startyear'])-543;
		$endyear = empty($this->request->data['endyear'])?'null':intval($this->request->data['endyear'])-543;
		$gpa = $this->request->data['gpa'];
		
		$dataSource = $this->Education->getDataSource();
		if( $this->Education->insertEducation($name
								, $faculty
								, $major
								, $gpa
								, '00,00,'.$startyear
								, '00,00,'.$endyear
								, $edutype
								, $objUser['id']
								, $isGraduate) ){
			$dataSource->commit();
			$message = 'การแก้ไขข้อมูลประวัติการศึกษาเสร็จเรียบร้อย';
		}else{
			$dataSource->rollback();
			$message = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติการศึกษา กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode(array('message'=>$message)));
		$this->render('response');
		
		$this->log('END :: ProfileController -> saveNewEducation');
	}
	public function editEducation(){
		$this->log('START :: ProfileController -> editEducation');
		
		$message = '';
		$objUser = $this->getObjUser();
		$this->log($this->request->data);
		$id = $this->request->data['id'];
		$edutype = $this->request->data['edutype'];
		$name = $this->request->data['name'];
		$faculty = $this->request->data['faculty'];
		$major = $this->request->data['major'];
		$isGraduate = ( ($this->request->data['isGraduate']=='true')?'1':'0' );
		$startyear = empty($this->request->data['startyear'])?'null':intval($this->request->data['startyear'])-543;
		$endyear = empty($this->request->data['endyear'])?'null':intval($this->request->data['endyear'])-543;
		$gpa = $this->request->data['gpa'];
		
		$dataSource = $this->Education->getDataSource();
		if( $this->Education->updateEducation($id
												, $name
												, $faculty
												, $major
												, $gpa
												, '00,00,'.$startyear
												, '00,00,'.$endyear
												, $edutype
												, $objUser['id']
												, $isGraduate) ){
			$dataSource->commit();
			$message = 'การแก้ไขข้อมูลประวัติการศึกษาเสร็จเรียบร้อย';
		}else{
			$dataSource->rollback();
			$message = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติการศึกษา กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode(array('message'=>$message)));
		$this->render('response');
		
		$this->log('END :: ProfileController -> editEducation');
	}
	public function deleteEducation(){
		$this->log('START :: ProfileController -> deleteEducation');
		
		$message = '';
		$id = $this->request->data['id'];
		
		$dataSource = $this->Education->getDataSource();
		if( $this->Education->deleteEducation($id) ){
			$dataSource->commit();
			$message = 'ลบข้อมูล สำเร็จ';
		}else{
			$dataSource->rollback();
			$message = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลส่วนตัว กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode(array('message'=>$message)));
		$this->render('response');
		
		$this->log('END :: ProfileController -> deleteEducation');
	}
	public function savedNewResearch(){
		$this->log('---- savedNewResearch ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$name = $this->request->data['name'];
		$researchtype = $this->request->data['researchtype'];
		$advisor = $this->request->data['advisor'];
		$organization = $this->request->data['organization'];
		$isnotfinish = ( ($this->request->data['isnotfinish']=='true')?'1':'0' );
		$yearfinish = empty($this->request->data['yearfinish'])?'null':intval($this->request->data['yearfinish'])-543;
		$dissemination = $this->request->data['dissemination'];

		$dataSource = $this->Research->getDataSource();
		if( $this->Research->insertData($name
										,$researchtype
										,$advisor
										,$organization
										,$objUser['id']
										,$isnotfinish
										,$yearfinish
										,$dissemination) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลผลการวิจัยเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติการศึกษา กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	public function editResearch(){
		$this->log('---- editResearch ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];
		$name = $this->request->data['name'];
		$researchtype = $this->request->data['researchtype'];
		$advisor = $this->request->data['advisor'];
		$organization = $this->request->data['organization'];
		$isnotfinish = ( ($this->request->data['isnotfinish']=='true')?'1':'0' );
		$yearfinish = empty($this->request->data['yearfinish'])?'null':intval($this->request->data['yearfinish'])-543;
		$dissemination = $this->request->data['dissemination'];

		$dataSource = $this->Research->getDataSource();
		if( $this->Research->updateData($id
										,$name
										,$researchtype
										,$advisor
										,$organization
										,$objUser['id']
										,$isnotfinish
										,$yearfinish
										,$dissemination) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลผลการวิจัยเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติการศึกษา กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	public function deletedResearch(){
		$this->log('---- deletedResearch ----');
		
		$result = array();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];

		$dataSource = $this->Research->getDataSource();
		if( $this->Research->deleteData($id) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลผลการวิจัยเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติการศึกษา กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------------ */
	public function changeFormatDate($data) {
		/*
		 * index of $explodeDate
		 * [0] = day
		 * [1] = month
		 * [2] = year(2013)
		 */
		$explodeDate = explode("/", $data);
		
		return ($explodeDate[2] - 543)."/".$explodeDate[1]."/".$explodeDate[0];
	}// changeFormatDate
}// ProfileController