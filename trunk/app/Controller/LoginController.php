<?php
class LoginController extends AppController {
	/* ------------------------------------------------------------------------------------------------------ */
	public $names = "LoginController";
	public $layout = "public";
	public $uses = array("Profile");
	public $components = array("Cookie");
	/* ------------------------------------------------------------------------------------------------------ */
	function index() {
		$this->log("START :: LoginController -> index()");
		
		//// local variables ////
		$result = "-1";
		$cookieUsername = $this->Cookie->read("cookieUsername");
		$cookieEncryptPassword = $this->Cookie->read("cookieEncryptPassword");
		
		// login
		if ( $cookieUsername && $cookieEncryptPassword ) {
			$result = $this->loginFnc($cookieUsername, $cookieEncryptPassword, true);	
		}// if
		
		// check $result
		if ( strlen($result) == 0 ) {
			$this->redirect(array("controller" => "profile", "action" => "index"));
		} else {
			$this->render("login");
		}// if else
		
		$this->log("END :: LoginController -> index()");
	}// index
	/* ------------------------------------------------------------------------------------------------------ */
	function loginAjax() {
		$this->log("START :: LoginController -> loginAjax()");
		
		//// local variables ////
		$result = null;
		$username = $this->request->data["username"];
		$password = $this->request->data["password"];
		$rememberMe = $this->request->data["rememberMe"];
		//$this->log($rememberMe);
		
		$result = $this->loginFnc($username, md5($password), $rememberMe);
		
		$this->layout = "ajax";
		$this->set("message", json_encode($result));
		$this->render("response");
		
		$this->log("END :: LoginController -> loginAjax()");
	}// loginAjax
	/* ------------------------------------------------------------------------------------------------------ */
	private function loginFnc($username, $encryptPassword, $rememberMe) {
		//// local variables ////
		$result = array();
		$cookieTimeOut = ((3600 * 24) * 30);  // or '1 month'
		
		// check username
		$objuser = $this->Profile->checkLogin($username);
		if ( count($objuser)===0||$objuser[0]['profiles']['is_approve']==0 ) { // username incorrect
			$result['msg'] = 'ไม่พบ Username นี้';
			$result['profile_id']=-1;
				
			// delete cookie
			$this->Cookie->delete("cookieUsername");
			$this->Cookie->delete("cookieEncryptPassword");
			$this->log("delete cookie complete");
		} else if ( count($objuser) == 1 ) { // username correct
			// check password
			if ( $encryptPassword == $objuser[0]["profiles"]["encrypt_password"] ) { // password correct
				// set SESSION
				$this->Session->write("objuser", $objuser[0]["profiles"]);
				$this->log("write session complete");
		
				// set COOKIE
				if ( $rememberMe == "true" ) {
					// set cookie
					$this->Cookie->time = $cookieTimeOut;
					$this->Cookie->write("cookieUsername", $username);
					$this->Cookie->write("cookieEncryptPassword", $encryptPassword);
					$this->log("write cookie complete");
				} else {
					// delete cookie
					$this->Cookie->delete("cookieUsername");
					$this->Cookie->delete("cookieEncryptPassword");
					$this->log("delete cookie complete");
				}// if else
				
				$result['msg'] = '';
				$result['profile_id']=$objuser[0]['profiles']['id'];
			} else {	// password incorrect
				$result['msg'] = 'รหัสผ่านไม่ถูกต้อง';
				$result['profile_id']=-1;
		
				// delete cookie
				$this->Cookie->delete("cookieUsername");
				$this->Cookie->delete("cookieEncryptPassword");
				$this->log("delete cookie complete");
			}// if else
		} else if ( count($objuser)>1 ) { // username incorrect
			$result['msg'] = "เกิดข้อผิดพลาด กรุณาแจ้งผู้ดูแลเว็บไซต์";
			$result['profile_id']=-1;
				
			// delete cookie
			$this->Cookie->delete("cookieUsername");
			$this->Cookie->delete("cookieEncryptPassword");
			$this->log("delete cookie complete");
		}// if else
		//$this->log($this->Session->read("objuser"));
		
		return $result;
	}// loginFnc
}// LoginController