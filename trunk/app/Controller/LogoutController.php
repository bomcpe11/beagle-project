<?php
class LogoutController extends AppController {

	public $uses = array();

	public function index(){
		
		$this->log('Logout successful');
		
		$this->Session->delete('objuser');
		$this->redirect(array('controller' => 'login'));
	}
}
