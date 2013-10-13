<?php
session_start();
class ChangepwdController extends AppController {

	public $uses = array();

	public function index(){
		$this->log('index()');
		$this->set("page_title","ChangepwdCgepicture");
	}

	
}
