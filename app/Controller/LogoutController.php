<?php
class LogoutController extends AppController {

	public $uses = array();

	public function index(){
		$this->fncLogout();
		$this->redirect(array('controller' => 'login'));
	}
	
	public function logoutAjax() {
		$this->log("START :: LogoutController -> logoutAjax()");
	
		$result = $this->fncLogout();
	
		$this->layout = "ajax";
		$this->set("message", json_encode(array("status" => $result)));
		$this->render("response");
	
		$this->log("END :: LogoutController -> logoutAjax()");
	}
	
	private function fncLogout(){
		$this->Session->delete('objuser');
		$this->log('Logout successful');
		return true;
	}
}
