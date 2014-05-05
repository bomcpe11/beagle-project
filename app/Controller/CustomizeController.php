<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class CustomizeController extends AppController {

	public $names = "CustomizeController";
	public $uses = array("Gvar", "Profile", "Generation");

	public function index(){
		
		$this->setTitle('Customize');
		
		$personalIdType = $this->Gvar->getVarcodeVardesc1ByVarname("PERSONAL_ID_TYPE");

		$this->set(compact("personalIdType"));
	}
	
	public function addnewmember_submit(){
		if(!$this->isAdmin){
			return;
		}
		$this->log("START :: CustomizeController -> addnewmember_submit()");
		
		$result['status'] = false;
		$result['message'] = '';
		
		$select_cardtype = $this->request->data["select_cardtype"];
		$txt_cardid = $this->request->data["txt_cardid"];
		$txt_name = $this->request->data["txt_name"];
		$txt_surname = $this->request->data["txt_surname"];
		$txt_birthdate = $this->request->data["txt_birthdate"];
		$txt_email = $this->request->data["txt_email"];
		
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
			$this->Profile->addnewmember($select_cardtype, $txt_cardid, $txt_name, $txt_surname, $this->changeFormatDate($txt_birthdate), $txt_email);
			$result['status'] = true;
			$result['message'] = "ลงทะเบียนเรียบร้อย";
		}
		
		$this->layout = "ajax_admin";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: CustomizeController -> addnewmember_submit()");
	}
	
	public function addgeneration_submit(){
		if(!$this->isAdmin){
			return;
		}
		$this->log("START :: CustomizeController -> addgeneration_submit()");
		
		$result['status'] = false;
		$result['message'] = '';
		
		$txt_generation = $this->request->data["txt_generation"];
		
		//TODO: Insert Data.
		if($this->Generation->insert($txt_generation)){
			$result['status'] = true;
			$result['message'] = "เพิ่ม รุ่นที่/ตำแหน่ง เรียบร้อย";
		}
		
		$this->layout = "ajax_admin";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: CustomizeController -> addgeneration_submit()");
	}
	
	public function remove_generation(){
		if(!$this->isAdmin){
			return;
		}
		$this->log("START :: CustomizeController -> remove_generation()");
		
		$result['status'] = false;
		$result['message'] = '';
		
		$generationid = $this->request->data["generationid"];
		
		//TODO: Insert Data.
		if($this->Generation->remove($generationid)){
			$result['status'] = true;
			$result['message'] = "ลบข้อมูล เรียบร้อย";
		}
		
		$this->layout = "ajax_admin";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: CustomizeController -> remove_generation()");
	}
	
	public function getGenerationList(){
		
		$result = $this->Generation->getAll();
		
		$this->layout = "ajax";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
	}
	
	private function changeFormatDate($data) {
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
