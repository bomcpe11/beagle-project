<?php
session_start();
class ChangepicController extends AppController {

	public $uses = array();

	public function index(){
		$this->log('index()');
		$this->set("page_title","Changepicture");
	}

	
}
