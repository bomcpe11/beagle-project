<?php
session_start();
class ProfileController extends AppController {

	public $uses = array();

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
		
		$this->set(compact("fullNameTh", "birthday", "age"));
		
		$this->set("page_title","ข้อมูลส่วนตัว - " . $objUser["titleth"] . " " . $objUser["nameth"] . " " . $objUser["lastnameth"]);
		
		$this->log("END :: ProfileController -> index()");
	}// index

	
}// ProfileController