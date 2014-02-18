<?php
session_start();
class ProfileController extends AppController {
	/* ------------------------------------------------------------------------------------------------ */
	public $names = 'ProfileController';
	public $uses = array('Gvar'
						,'Profile'
						,'Family'
						,'Education'
						,'Research'
						,'Award'
						,'Otherwork'
						,'Workplace'
						,'Comment'
						,'JoinActivity');
	/* ------------------------------------------------------------------------------------------------ */
	public function index(){
		$this->log('---- ProfileController -> index ----');
		
		$get_profile_id = @intval($this->request->query['id']);
		$objUser = $this->Profile->getDataById($get_profile_id);
		//$this->log(print_r($objUser, true));
		$pageTitle='ไม่พบข้อมูล';
		$isOwner = false;
		$fullNameTh = null;
		$birthday = null;
		$age = null;
		$namePrefixTh = null;
		$namePrefixEn = null;
		$listFamily = null;
		$listEducation = null;
		$listResearchType = null;
		$listResearch = null;
		$listAward = null;
		$listOtherwork = null;
		$listWorkplace = null;
		$listComment = null;
		$listActivity = null;
		
		if( !empty($objUser) ){
			/* page title */
			$pageTitle = 'ข้อมูลส่วนตัว - '
						. $objUser[0]['profiles']['titleth'] 
						. ' '
						. $objUser[0]['profiles']['nameth'] 
						. ' '
						. $objUser[0]['profiles']['lastnameth'];
						
			/* owner profile */
			if( $get_profile_id==$this->getObjUser()['id'] ){
				$isOwner = true;
			}
			
			/* fullName */
			if( $objUser[0]['profiles']['position'] ){
				$fullNameTh = $objUser[0]['profiles']['position'].' '.$objUser[0]['profiles']['nameth'].' '.$objUser[0]['profiles']['lastnameth'];
			} else{
				$fullNameTh = $objUser[0]['profiles']['titleth'].' '.$objUser[0]['profiles']['nameth'].' '.$objUser[0]['profiles']['lastnameth']; 
			} 
			
			/* birthday */
			$birthday = $this->DateThai($objUser[0]['profiles']['birthday']);
			/*$arrayBirthday = explode('-', $objUser[0]['profiles']['birthday']);	// <<< Y-m-d
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
			$birthday .= " พ.ศ. " . ( intval($arrayBirthday[0]) + 543 );*/
			
			/* age */
			$now = date('Y-m-d');
			$diffDate = abs(strtotime($now) - strtotime($objUser[0]['profiles']['birthday']));
			$age = floor($diffDate / (365*60*60*24)) . ' ปี';
			
			/* prefix name */
			$namePrefixTh 	= $this->Gvar->getVarcodeVardesc1ByVarname('NAME_PREFIX_TH');
			$namePrefixEn 	= $this->Gvar->getVarcodeVardesc1ByVarname('NAME_PREFIX_EN');
			
			/* families */
			$listFamily = $this->Family->getFamiliesByProfileId($objUser[0]['profiles']['id']);
			//$this->log(print_r($listFamily, true));
			
			/* education */
			$listEducation = $this->Education->getEducationByProfileId($objUser[0]['profiles']['id']);
			//$this->log(print_r($listEducation, true));
			
			/* research */
			$listResearchType = $this->Gvar->getVarcodeVardesc1ByVarname('RESEARCH_TYPE');
			$listResearch = $this->Research->getDataByProfileId($objUser[0]['profiles']['id']);
			//$this->log(print_r($listResearch, true));
			
			/* award */
			$listAward = $this->Award->getDataByProfileId($objUser[0]['profiles']['id']);
			//$this->log(print_r($listAward, true));
			
			/* otherword */
			$listOtherwork = $this->Otherwork->getDataByProfileId($objUser[0]['profiles']['id']);
			
			/* work place */
			$listWorkplace = $this->Workplace->getDataByProfileId($objUser[0]['profiles']['id']);
			$countListWorkplace = count($listWorkplace);
			for( $i=0;$i<$countListWorkplace;$i++ ){
				$listWorkplace[$i]['w']['startyear'] = $this->DateThai($listWorkplace[$i]['w']['startyear']);
				$listWorkplace[$i]['w']['endyear'] = $this->DateThai($listWorkplace[$i]['w']['endyear']);
			}
			
			/* comment */
			$listComment = $this->Comment->getDataForProfile($objUser[0]['profiles']['id'],$this->getObjUser()['id']);
			$countListComment = count($listComment);
			$splitCreatedAt = array();
			$splitUpdatedAt = array();
			for( $i=0;$i<$countListComment;$i++ ){
				// Ex. yyyy-MM-dd hh:mm:ss
				$splitCreatedAt = explode(' ',$listComment[$i]['c']['created_at']);
				$splitUpdatedAt = explode(' ',$listComment[$i]['c']['updated_at']);
				
				$listComment[$i]['c']['created_at'] = $this->DateThai($listComment[$i]['c']['created_at']).' เวลา '.$splitCreatedAt[1].' น.';
				$listComment[$i]['c']['updated_at'] = $this->DateThai($listComment[$i]['c']['updated_at']).' เวลา '.$splitUpdatedAt[1].' น.';
			}
			//$this->log(print_r($listComment, true));
			
			/* activity */
			$listActivity = $this->JoinActivity->getActivityForProfile($objUser[0]['profiles']['id']);
			//$this->log(print_r($listActivity, true));
		}
		
		/* set data to view*/
		$this->setTitle($pageTitle);
		$this->set(compact('isOwner', 'objUser', 'fullNameTh', 'birthday' ,'age', 'namePrefixTh'
							,'namePrefixEn', 'listFamily','listEducation', 'listResearchType'
							,'listResearch', 'listAward','listOtherwork', 'listWorkplace','listComment'
							,'listActivity'));
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function updateProfileAjax() {
		$this->log('---- ProfileController -> updateProfileAjax ----');
		
		$result 		= array();
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
			$result['flg'] = 1;
			$result['msg'] = "การแก้ไขข้อมูลส่วนตัวเสร็จเรียบร้อย";								
		} else {
			$result['flg'] = -1;
			$result['msg'] = "เกิดข้อผิดพลาดใน การแก้ไขข้อมูลส่วนตัว กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์";
		}
		
		$this->layout = "ajax";
		$this->set("message", json_encode($result));
		$this->render("response");
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function saveNewFamily(){
		$this->log('---- ProfileController -> saveNewFamily ----');
		
		$result = array();
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
			
			$result['flg'] = 1;
			$result['msg'] = 'การแก้ไขข้อมูลประวัติครอบครัวเสร็จเรียบร้อย';
		}else{
			$dataSource->rollback();
			
			$result['flg'] = -1;
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติครอบครัว กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function editFamily(){
		$this->log('---- ProfileController -> editFamily ----');
		
		$result = array();
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
			
			$result['flg'] = 1;
			$result['msg'] = 'การแก้ไขข้อมูลประวัติครอบครัวเสร็จเรียบร้อย';
		}else{
			$dataSource->rollback();
			
			$result['flg'] = -1;
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติครอบครัว กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deleteFamily(){
		$this->log('---- ProfileController -> deleteFamily ----');
		
		$result = array();
		$id = $this->request->data['id'];
		
		$dataSource = $this->Family->getDataSource();
		if( $this->Family->deleteFamily($id) ){
			$dataSource->commit();
			
			$result['flg'] = 1;
			$result['msg'] = 'การแก้ไขข้อมูลประวัติครอบครัวเสร็จเรียบร้อย';
		}else{
			
			$dataSource->rollback();
			
			$result['flg'] = -1;
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติครอบครัว กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function saveNewEducation(){
		$this->log('---- ProfileController -> saveNewEducation ----');
		
		$message = '';
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$edutype = $this->request->data['edutype'];
		$name = $this->request->data['name'];
		$faculty = $this->request->data['faculty'];
		$major = $this->request->data['major'];
		$isGraduate = ( ($this->request->data['isGraduate']==='true')?'1':'0' );
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
			$message = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติการศึกษา กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode(array('message'=>$message)));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function editEducation(){
		$this->log('---- ProfileController -> editEducation ----');
		
		$message = '';
		$objUser = $this->getObjUser();
		$this->log($this->request->data);
		$id = $this->request->data['id'];
		$edutype = $this->request->data['edutype'];
		$name = $this->request->data['name'];
		$faculty = $this->request->data['faculty'];
		$major = $this->request->data['major'];
		$isGraduate = ( ($this->request->data['isGraduate']==='true')?'1':'0' );
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
			$message = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติการศึกษา กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode(array('message'=>$message)));
		$this->render('response');
		
		$this->log('END :: ProfileController -> editEducation');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deleteEducation(){
		$this->log('---- ProfileController -> deleteEducation ----');
		
		$result = array();
		$id = $this->request->data['id'];
		
		$dataSource = $this->Education->getDataSource();
		if( $this->Education->deleteEducation($id) ){
			$dataSource->commit();
			
			$result['flg'] = 1;
			$result['msg'] = 'การแก้ไขประวัติการศึกษาเสร็จเรียบร้อย';
		}else{
			$dataSource->rollback();
			
			$result['flg'] = -1;
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขประวัติการศึกษา กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function savedNewResearch(){
		$this->log('---- ProfileController -> savedNewResearch ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$name = $this->request->data['name'];
		$researchtype = $this->request->data['researchtype'];
		$advisor = $this->request->data['advisor'];
		$organization = $this->request->data['organization'];
		$isnotfinish = ( ($this->request->data['isnotfinish']==='true')?'1':'0' );
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
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลผลการวิจัย กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function editResearch(){
		$this->log('---- ProfileController -> editResearch ----');
		
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
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลผลการวิจัย กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deleteResearch(){
		$this->log('---- ProfileController -> deleteResearch ----');
		
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
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลผลการวิจัย กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function savedNewOtherwork(){
		$this->log('---- ProfileController -> savedNewOtherwork ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$name = $this->request->data['name'];
		$organization = $this->request->data['organization'];
		$yearfinish = empty($this->request->data['yearfinish'])?'null':intval($this->request->data['yearfinish'])-543;
		$isnotfinish = ( ($this->request->data['isnotfinish']==='true')?'1':'0' );

		$dataSource = $this->Otherwork->getDataSource();
		if( $this->Otherwork->insertData($name
										,$organization
										,$objUser['id']
										,$yearfinish
										,$isnotfinish) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลรางวัลอื่นๆเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลรางวัลอื่นๆ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function editOtherwork(){
		$this->log('---- ProfileController -> editOtherwork ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];
		$name = $this->request->data['name'];
		$organization = $this->request->data['organization'];
		$yearfinish =  ($this->request->data['yearfinish']==='-')?'null':intval($this->request->data['yearfinish'])-543;
		$isnotfinish = ( ($this->request->data['isnotfinish']==='true')?'1':'0' );
		
		$dataSource = $this->Otherwork->getDataSource();
		if( $this->Otherwork->updateData($id
										,$name
										,$organization
										,$objUser['id']
										,$yearfinish
										,$isnotfinish) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลรางวัลอื่นๆเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลรางวัลอื่นๆ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deleteOtherwork(){
		$this->log('---- ProfileController -> deleteOtherwork ----');
		
		$result = array();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];

		$dataSource = $this->Otherwork->getDataSource();
		if( $this->Otherwork->deleteData($id) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลรางวัลอื่นๆเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลรางวัลอื่นๆ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function savedNewAward(){
		$this->log('---- ProfileController -> savedNewAward ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$name = $this->request->data['name'];
		$awardname = $this->request->data['awardname'];
		$organization = $this->request->data['organization'];
	
		$dataSource = $this->Award->getDataSource();
		if( $this->Award->insertData($name
								,$awardname
								,$organization
								,$objUser['id']
								,'') ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลรางวัลที่ได้รับเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลรางวัลที่ได้รับ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function editAward(){
		$this->log('---- ProfileController -> editAward ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];
		$name = $this->request->data['name'];
		$awardname = $this->request->data['awardname'];
		$organization = $this->request->data['organization'];
	
		$dataSource = $this->Award->getDataSource();
		if( $this->Award->updateData($id
									,$name
									,$awardname
									,$organization
									,'0000') ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลรางวัลที่ได้รับเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลรางวัลที่ได้รับ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deletedAward(){
		$this->log('---- ProfileController -> deletedAward ----');
		
		$result = array();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];

		$dataSource = $this->Award->getDataSource();
		if( $this->Award->deleteData($id) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลผลการวิจัยเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลผลการวิจัย กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function savedNewWorkplace(){
		$this->log('---- ProfileController -> savedNewWorkplace ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$name = $this->request->data['name'];
		$telephone = $this->request->data['telephone'];
		$startyear = $this->changeFormatDate($this->request->data['startyear']);
		$endyear = $this->changeFormatDate($this->request->data['endyear']);
		$position = $this->request->data['position'];
	
		$dataSource = $this->Workplace->getDataSource();
		if( $this->Workplace->insertData($name
								,$telephone
								,$startyear
								,$endyear
								,$position
								,$objUser['id']) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลประวัติการทำงานเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติการทำงาน กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function editWorkplace(){
		$this->log('---- ProfileController -> editWorkplace ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];
		$name = $this->request->data['name'];
		$telephone = $this->request->data['telephone'];
		$startyear = $this->changeFormatDate($this->request->data['startyear']);
		$endyear = $this->changeFormatDate($this->request->data['endyear']);
		$position = $this->request->data['position'];
	
		$dataSource = $this->Workplace->getDataSource();
		if( $this->Workplace->updateData($id
										,$name
										,$telephone
										,$startyear
										,$endyear
										,$position) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลประวัติการทำงานเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติการทำงาน กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deletedWorkplace(){
		$this->log('---- ProfileController -> deletedWorkplace ----');
		
		$result = array();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];

		$dataSource = $this->Workplace->getDataSource();
		if( $this->Workplace->deleteData($id) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขข้อมูลประวัติการทำงานเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขข้อมูลประวัติการทำงาน กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function saveNewComment(){
		$this->log('---- ProfileController -> saveNewComment ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		$commentTitle = $this->request->data['commentTitle'];
		$commentDetial = $this->request->data['commentDetial'];
		$profileId = $this->request->data['profileId'];
		$commentableType = 'Profile';
		
		$dataSource = $this->Comment->getDataSource();
		if( $this->Comment->insertData($commentTitle
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
	public function editActivity(){
		$this->log('---- ProfileController -> editActivity ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		$id = $this->request->data['id'];
		$position = $this->request->data['position'];
		
		$dataSource = $this->JoinActivity->getDataSource();
		if( $this->JoinActivity->updatePosition($objUser['id'], $id, $position) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขกิจกรรมที่เข้าร่วมเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขกิจกรรมที่เข้าร่วม กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deletedActivity(){
		$this->log('---- ProfileController -> deletedActivity ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];

		$dataSource = $this->JoinActivity->getDataSource();
		if( $this->JoinActivity->deleteData($objUser['id'],$id) ){
			$dataSource->commit();
			$result['msg'] = 'การแก้ไขกิจกรรมที่เข้าร่วมเสร็จเรียบร้อย';
			$result['flag'] = 1;
		}else{
			$dataSource->rollback();
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขกิจกรรมที่เข้าร่วมเ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			$result['flag'] = -1;
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
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