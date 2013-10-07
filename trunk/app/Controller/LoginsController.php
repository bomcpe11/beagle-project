<?php
class LoginsController extends AppController {
	/* ------------------------------------------------------------------------------------------------------ */
	public $names = "LoginsController";
	public $uses = array("Profile");
	public $components = array("Cookie");
	/* ------------------------------------------------------------------------------------------------------ */
	function index() {
		$this->log("START :: LoginsController -> index()");
		
		// get cookie
		$cookieUsername = $this->Cookie->read("cookieUsername");
		$cookiePassword = $this->Cookie->read("cookiePassword");
		
		// send data to view
		$this->set("cookieUsername", $cookieUsername);
		$this->set("cookiePassword", $cookiePassword);
		
		$this->render("login");
		
		$this->log("END :: LoginsController -> index()");
	}// index
	/* ------------------------------------------------------------------------------------------------------ */
	function loginFnc() {
		$this->log("START :: LoginsController -> loginFnc()");
		
		
		$result = null;
		$username = $this->request->data["username"];
		$password = $this->request->data["password"];
		$rememberMe = $this->request->data["rememberMe"];
		$cookieTimeOut = ((3600 * 24) * 30);  // or '1 month'
		//$this->log($rememberMe);
		
		// check rememberMe
		if ( $rememberMe == "true" ) {
			// set cookie
			$this->Cookie->time = $cookieTimeOut;
			$this->Cookie->write("cookieUsername", $username);
			$this->Cookie->write("cookiePassword", $password);
			
			$this->log("### write cookie complete ###");
			$this->log($this->Cookie->read("cookieUsername"));
			$this->log($this->Cookie->read("cookiePassword"));
		} else {
			// delete cookie
			$this->Cookie->delete("cookieUsername");
			$this->Cookie->delete("cookiePassword");
			
			$this->log("### delete cookie complete ###");
		}// if else
		
		// check login
		$checkUsername = $this->Profile->checkUsername($username);
		if ( !empty($checkUsername) ) {
			$this->log("username correct");
			$checkPassword = $this->Profile->checkPassword(md5($password));
			if ( !empty($checkPassword) ) {
				$this->log("password correct");
				
				$result = "";
				
				// set SESSION
				$this->Session->write("objuser", $checkPassword);
			} else {
				$this->log("password incorrect");
				
				$result = "Password ไม่ถูกต้อง";
			}// if else
		} else {
			$this->log("username incorrect");
			
			$result = "Username ไม่ถูกต้อง";
		}// if else
		//$this->log($this->Session->read("objuser"));
		
		$this->layout = "ajax";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: LoginsController -> loginFnc()");
	}// login
}// LoginsController