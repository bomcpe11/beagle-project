<?php
session_start();
class PsearchController extends AppController {
	/* ------------------------------------------------------------------------------------------------ */
	public $uses = array('Profile');
	/* ------------------------------------------------------------------------------------------------ */
	public function index(){
		$this->log('---- Psearch -> index ----');
		
		$this->setTitle('ค้นหาบุคคล');
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function searchData(){
		$this->log('---- Psearch -> searchData ----');
		
		$result = array();
		//$this->log($this->request->data);
		$keyWord= $this->request->data['keyWord'];
		$searchWidth = $this->request->data['searchWidth'];
		$flagActivity = $this->request->data['flagActivity'];
		
		$result = $this->Profile->getDataForPsearch($keyWord,$searchWidth,$flagActivity);
		//$this->log($result);
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
}
