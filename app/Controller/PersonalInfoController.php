<?php
// session_start();
class PersonalInfoController extends AppController {
	/* ------------------------------------------------------------------------------------------------ */
	public $names = 'PersonalInfo';
	public $uses = array('Gvar'
						,'Profile'
						,'Family'
						,'Education'
						,'Workplace'
						,'Comment');
	public $layout = "default_new";
	/* ------------------------------------------------------------------------------------------------ */
	public function index(){
		$this->log('---- PersonalInfoController -> index ----');
		
		$get_profile_id = @intval($this->request->query['id']);
		$sssnObjUser = $this->getObjUser();
		$objUser = $this->Profile->getDataById($get_profile_id);
		//$this->log(print_r($objUser, true));
		$isOwner = false;
		$fullNameTh = null;
		$birthday = null;
		$age = null;
		$namePrefixTh = null;
		$namePrefixEn = null;
		$listFamily = null;
		$listEducation = null;
		$listWorkplace = null;
		$listComment = null;
		
		if( !empty($objUser) ){
			/* owner profile */
			if( $get_profile_id==$sssnObjUser['id'] ){
				$isOwner = true;
			}
			
			/* fullName */
			if( $objUser[0]['profiles']['position'] ){
				$fullNameTh = $objUser[0]['profiles']['position'].$objUser[0]['profiles']['nameth'].' '.$objUser[0]['profiles']['lastnameth'];
			} else{
				$fullNameTh = $objUser[0]['profiles']['titleth'].$objUser[0]['profiles']['nameth'].' '.$objUser[0]['profiles']['lastnameth']; 
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
			
			/* work place */
			$listWorkplace = $this->Workplace->getDataByProfileId($objUser[0]['profiles']['id']);
			$countListWorkplace = count($listWorkplace);
			
			/* comment */
			$listComment = $this->Comment->getDataForProfile($objUser[0]['profiles']['id'],$sssnObjUser['id']);
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
		}
		
		/* set data to view */
		$this->set(compact('isOwner', 'objUser', 'fullNameTh', 'birthday' ,'age', 'namePrefixTh'
							,'namePrefixEn', 'listFamily','listEducation', 'listWorkplace','listComment'));
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function updateProfileAjax() {
		$this->log('---- PersonalInfoController -> updateProfileAjax ----');
		
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
		$position		= $this->request->data["position"];
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
												,$position
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
		$this->log('---- PersonalInfoController -> saveNewFamily ----');
		
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
		$this->log('---- PersonalInfoController -> editFamily ----');
		
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
		$this->log('---- PersonalInfoController -> deleteFamily ----');
		
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
		$this->log('---- PersonalInfoController -> saveNewEducation ----');
		
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
		$this->log('---- PersonalInfoController -> editEducation ----');
		
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
		$this->log('---- PersonalInfoController -> deleteEducation ----');
		
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
	public function savedNewWorkplace(){
		$this->log('---- PersonalInfoController -> savedNewWorkplace ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$name = $this->request->data['name'];
		$telephone = $this->request->data['telephone'];
		$startyear = $this->request->data['startyear'];
		$endyear = $this->request->data['endyear'];
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
		$this->log('---- PersonalInfoController -> editWorkplace ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];
		$name = $this->request->data['name'];
		$telephone = $this->request->data['telephone'];
		$startyear = $this->request->data['startyear'];
		$endyear = $this->request->data['endyear'];
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
		$this->log('---- PersonalInfoController -> deletedWorkplace ----');
		
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
		$this->log('---- PersonalInfoController -> saveNewComment ----');
		
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
	public function deleteComment(){
		$this->log('---- PersonalInfoController -> deleteComment ----');
		
		$result = array();
		//$this->log($this->request->data);
		$id = $this->request->data['id'];

		$dataSource = $this->Comment->getDataSource();
		if( $this->Comment->deleteData($id) ){
			$dataSource->commit();
			$result['flg'] = 1;
			$result['msg'] = 'การแก้ไข ความคิดเห็นเสร็จเรียบร้อย';
		}else{
			$dataSource->rollback();
			$result['flg'] = -1;
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขกิจกรรมที่เข้าร่วมเ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function updateSortableSeq(){
		$this->log('---- PersonalInfoController -> updateSortableSeq ----');
		
		//$this->log($this->request->data);
		$result = array();
		$flagUpdateData = false;
		$id = $this->request->data['sortable_id'];
		$data = $this->request->data['data'];
		$countData = count($data);
		
		if( $id==='family' ){
			$dataSource = $this->Family->getDataSource();
			$dataSource->begin();
			for( $i=0;$i<$countData;$i++ ){
				$flagUpdateData = $this->Family->updateSeq($data[$i]['id']
																	,$data[$i]['seq']);
				if( !$flagUpdateData ){
					break;
				}
			}
			if( $flagUpdateData ){
				$dataSource->commit();
				$result['flg'] = 1;
				$result['msg'] = 'การแก้ไขลำดับ ข้อมูลประวัติครอบครัวเสร็จเรียบร้อย';
			}else{
				$dataSource->rollback();
				$result['flg'] = -1;
				$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขกิจกรรมที่เข้าร่วมเ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			}
		}else if( $id==='education' ){
			$dataSource = $this->Education->getDataSource();
			$dataSource->begin();
			for( $i=0;$i<$countData;$i++ ){
				$flagUpdateData = $this->Education->updateSeq($data[$i]['id']
																,$data[$i]['seq']);
				if( !$flagUpdateData ){
					break;
				}
			}
			if( $flagUpdateData ){
				$dataSource->commit();
				$result['flg'] = 1;
				$result['msg'] = 'การแก้ไขลำดับ ข้อมูลประวัติการศึกษาเสร็จเรียบร้อย';
			}else{
				$dataSource->rollback();
				$result['flg'] = -1;
				$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขกิจกรรมที่เข้าร่วมเ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			}
		}else if( $id==='workplace' ){
			$dataSource = $this->Workplace->getDataSource();
			$dataSource->begin();
			for( $i=0;$i<$countData;$i++ ){
				$flagUpdateData = $this->Workplace->updateSeq($data[$i]['id']
																,$data[$i]['seq']);
				if( !$flagUpdateData ){
					break;
				}
			}
			if( $flagUpdateData ){
				$dataSource->commit();
				$result['flg'] = 1;	
				$result['msg'] = 'การแก้ไขลำดับ ข้อมูลประวัติการทำงานเสร็จเรียบร้อย';
			}else{
				$dataSource->rollback();
				$result['flg'] = -1;
				$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขกิจกรรมที่เข้าร่วมเ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
			}
		}else{
			$result['flag'] = -1;
			$result['msg'] = 'เกิดข้อผิดพลาดใน การแก้ไขกิจกรรมที่เข้าร่วมเ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์';
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
}