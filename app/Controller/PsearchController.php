<?php
session_start();
class PsearchController extends AppController {

	public $uses = array('Profile');

	public function index(){
		$this->log('---- Psearch->index ----');
		$this->set("page_title","ค้นหาบุคคล");
	}
	public function search_data(){
		$this->log('---- Psearch->search_data ----');
		
		$result = array();
		$search_width = $this->request->data['search_width'];
		
		$result = $this->Profile->searchByStmtSql($search_width);
		$this->log($result);
		
		$this->layout="ajax";
		$this->set("message", json_encode($result));
		$this->render("response");
	}
}
