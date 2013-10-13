<?php
session_start();
class PsearchController extends AppController {

	public $uses = array();

	public function index(){
		$this->log('index()');
		$this->set("page_title","Psearch");
	}

	
}
