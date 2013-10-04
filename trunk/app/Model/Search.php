<?php
class Search extends AppModel {
	
	public function getSearches(){
		$result = $this->query('select * from searches');
		return $result;
	}
}
?>