<?php
class SearchresultController extends AppController {

	public $names = "SearchresultController";
	public $uses = array('Searchkeyword', 'Gvar');

	const VAR_NAME_TYPE_ID = 'SEARCH_ENGINE_TYPE_ID';
	
	public function index(){
		
// 		print_r($this->params['data']);
		
		$keyword = trim($this->params['data']['keyword']);
		
		
		//All, not search -> Comment, Email History
		/*
		 All ->	- Profile
				- Activity
				- Webboard
		*/
		
// 		$a = $this->TYPE_ID;
		
		
		$searchResult = $this->Searchkeyword->search($keyword);
		
		$searchType = $this->Gvar->getVarcodeVardesc1ByVarname($this->VAR_NAME_TYPE_ID);
		
		$this->set(compact('searchResult', 'keyword', 'searchType'));
		
	}
}
