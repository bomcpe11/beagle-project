<?php
session_start();
class ProfileController extends AppController {

	public $uses = array();

	public function index(){
		$this->log('index()');
		$this->set("page_title","Profile");
	}

	
}
