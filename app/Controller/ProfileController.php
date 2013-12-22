<?php
session_start();
class ProfileController extends AppController {

	public $names = "ProfileController";
	public $uses = array("Gvar"
						,"Profile");

	public function index() {
		$this->log("START :: ProfileController -> index()");
		
		$objUser = $this->getObjUser();
		$fullNameTh = null;
		$birthday = null;
		$age = null;
		
		/* fullName */
		if ( $objUser["position"] ) $fullNameTh = $objUser["position"]." ".$objUser["nameth"]." ".$objUser["lastnameth"]; 
		else $fullNameTh = $objUser["titleth"]." ".$objUser["nameth"]." ".$objUser["lastnameth"]; 
		
		/* birthday */
		$arrayBirthday = explode("-", $objUser["birthday"]);	// <<< Y-m-d
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
		$now = date("Y-m-d");
		$diffDate = abs(strtotime($now) - strtotime($objUser["birthday"]));
		$age = floor($diffDate / (365*60*60*24)) . " ปี";
		
		/* prefix name */
		$namePrefixTh 	= $this->Gvar->getVarcodeVardesc1ByVarname("NAME_PREFIX_TH");
		$namePrefixEn 	= $this->Gvar->getVarcodeVardesc1ByVarname("NAME_PREFIX_EN");
		
		$this->set(compact("fullNameTh", "birthday", "age", "namePrefixTh", "namePrefixEn"));
		
		$this->set("page_title","ข้อมูลส่วนตัว - " . $objUser["titleth"] . " " . $objUser["nameth"] . " " . $objUser["lastnameth"]);
		
		$this->log("END :: ProfileController -> index()");
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