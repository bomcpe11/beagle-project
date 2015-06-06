<?php
class LogoutController extends AppController {

	public $uses = array();
	public $components = array("Cookie");

	public function index(){
		$this->fncLogout();
		$this->redirect(array('controller' => 'login'));
	}
	
	public function logoutAjax() {
		$this->log("START :: LogoutController -> logoutAjax()");
	
		$result = $this->fncLogout();
	
		$this->layout = "ajax_public";
		$this->set("message", json_encode(array("status" => $result)));
		$this->render("response");
	
		$this->log("END :: LogoutController -> logoutAjax()");
	}
	
	private function fncLogout(){
		$this->Session->delete('objuser');
		
		$this->Cookie->delete('cookieUsername');
		$this->Cookie->delete('cookieEncryptPassword');
			
		$this->log('Logout successful');
		return true;
	}
}
