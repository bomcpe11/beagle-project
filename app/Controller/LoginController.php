<?php
session_start();
class LoginController extends AppController {
	/* ------------------------------------------------------------------------------------------------------ */
	public $names = "LoginController";
	public $uses = array("Profile");
	public $components = array("Cookie");
	/* ------------------------------------------------------------------------------------------------------ */
	function index() {
		$this->log("START :: LoginController -> index()");
		
		// get cookie
		$cookieUsername = $this->Cookie->read("cookieUsername");
		$cookiePassword = $this->Cookie->read("cookiePassword");
		
		// send data to view
		$this->set("cookieUsername", $cookieUsername);
		$this->set("cookiePassword", $cookiePassword);
		
		$this->render("login");
		
		$this->log("END :: LoginController -> index()");
	}// index
	/* ------------------------------------------------------------------------------------------------------ */
	function loginFnc() {
		$this->log("START :: LoginController -> loginFnc()");
		
		//// local variables ////
		$result = null;
		$username = $this->request->data["username"];
		$password = $this->request->data["password"];
		$rememberMe = $this->request->data["rememberMe"];
		$cookieTimeOut = ((3600 * 24) * 30);  // or '1 month'
		//$this->log($rememberMe);
		
		// check login
		// check username
		$objuser = $this->Profile->checkLogin($username);
		if ( count($objuser) == 0 ) { // username incorrect
			$result = "ไม่พบ Username นี้";
			
			// delete cookie
			$this->Cookie->delete("cookieUsername");
			$this->Cookie->delete("cookiePassword");
			$this->log("### delete cookie complete ###");
		} else if ( count($objuser) == 1 ) { // username correct
			// check password
			if ( md5($password) == $objuser[0]["profiles"]["encrypt_password"] ) { // password correct
				$result = "";
			
				// set SESSION
				$this->Session->write("objuser", $objuser);
				
				// set COOKIE
				if ( $rememberMe == "true" ) {
					// set cookie
					$this->Cookie->time = $cookieTimeOut;
					$this->Cookie->write("cookieUsername", $username);
					$this->Cookie->write("cookiePassword", $password);
						
					$this->log("### write cookie complete ###");
				} else {
					// delete cookie
					$this->Cookie->delete("cookieUsername");
					$this->Cookie->delete("cookiePassword");
					$this->log("### delete cookie complete ###");
				}// if else
			} else {	// password incorrect
				$result = "รหัสผ่านไม่ถูกต้อง";
				
				// delete cookie
				$this->Cookie->delete("cookieUsername");
				$this->Cookie->delete("cookiePassword");
				$this->log("### delete cookie complete ###");
			}// if else
		} else if ( count($objuser) == 2 ) { // username incorrect
			$result = "เกิดข้อผิดพลาด กรุณาแจ้งผู้ดูแลเว็บไซต์";
			
			// delete cookie
			$this->Cookie->delete("cookieUsername");
			$this->Cookie->delete("cookiePassword");
			$this->log("### delete cookie complete ###");
		}// if else
		//$this->log($this->Session->read("objuser"));
		
		$this->layout = "ajax";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: LoginController -> loginFnc()");
	}// login
}// LoginController