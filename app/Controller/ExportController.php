<?php
session_start();
class ExportController extends AppController {

	public $uses = array();

	public function index(){
		$this->log('index()');
		$this->set("page_title","Export");
	}

	
}
