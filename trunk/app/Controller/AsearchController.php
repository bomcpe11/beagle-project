<?php
class AsearchController extends AppController{
	public $uses = array('Activity');
	
	public function index(){
		$this->log('---- Asearch->index ----');
		$this->set('page_title', 'ค้นหากิจกรรม');
	}
}