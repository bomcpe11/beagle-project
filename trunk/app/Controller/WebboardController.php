<?php
class WebboardController extends AppController {
	/* ------------------------------------------------------------------------------------------------ */
	public $names = 'WebboardController';
	public $uses = array();
	/* ------------------------------------------------------------------------------------------------ */
	public function index(){
		$this->log('---- WebboardController -> index ----');
		$this->setTitle('Webboard');
		
		$Page = $this->request->query['Page'];
		
		$this->set('Page', 0);
	}
	
}// WebboardController