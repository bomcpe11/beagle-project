<?php
class SearchresultController extends AppController {

	public $names = "SearchresultController";
	public $uses = array('Searchkeyword', 'Gvar');

// 	const VAR_NAME_TYPE_ID = 'SEARCH_ENGINE_TYPE_ID';
	
	public function index(){
		
// 		print_r($this->params['data']);
		
// 		$keyword = trim($this->params['data']['keyword']);
		$keyword = trim($this->request->query['keyword']);
		
		
		//All, not search -> Comment, Email History
		/*
		 All ->	- Profile
				- Activity
				- Webboard
		*/
		
// 		$a = $this->TYPE_ID;
		
		
		$searchResult = $this->Searchkeyword->search($keyword);
		
		$rsSearchType = $this->Gvar->getVarcodeVardesc12ByVarname('SEARCH_ENGINE_TYPE_ID');
		$searchType = array();
		foreach ($rsSearchType as $record){
			$searchType[$record['gvars']['varcode']] = $record['gvars'];
		}
		
		$this->set(compact('searchResult', 'keyword', 'searchType'));
		
	}
}
