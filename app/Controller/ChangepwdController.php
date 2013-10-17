<?php
session_start();
class ChangepwdController extends AppController {
	/* -------------------------------------------------------------------------------- */
	public $names = "ChangepwdController";
	public $uses = array("Profile");
	public $components = array("Cookie");
	/* -------------------------------------------------------------------------------- */
	public function index(){
		$this->log("START :: ChangepwdController -> index()");
		
		$this->set("page_title","แก้ไขรหัสผ่าน");
		
		$this->log("END :: ChangepwdController -> index()");
	}// index
	/* -------------------------------------------------------------------------------- */
	public function updatePasswordFnc() {
		$this->log("START :: ChangepwdController -> updatePasswordFnc()");
		
		$result = null;
		//$this->log($objUser);
		$oldPassword = $this->request->data["oldPassword"];
		$newPassword = $this->request->data["newPassword"];
		$cookieTimeOut = (3600 * 24) * 30;  // or '1 month'
		
		// check oldPassword
		if ( md5($oldPassword) != $this->getObjUser()["encrypt_password"] ) {
			$result = "รหัสผ่านเดิม ไม่ถูกต้อง";
		} else {
			if ( $this->Profile->updatePassword(md5($newPassword) // $newPassword
											, $this->getObjUser()["login"]) ) {	// $username
				$result = "แก้ไขรหัสผ่าน เรียบร้อย";
				
				// set cookie
				$this->Cookie->time = $cookieTimeOut;
				$this->Cookie->write("cookieEncryptPassword", md5($newPassword));
				$this->log("### write cookie complete ###");
			} else {
				$result = "แก้ไขรหัสผ่าน ผิดพลาด กรุณาติดต่อผู้ดูแลระบบ";
			}
		}// if else
		
		$this->layout = "ajax";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: ChangepwdController -> updatePasswordFnc()");
	}// updatePasswordFnc
}// ChangepwdController
