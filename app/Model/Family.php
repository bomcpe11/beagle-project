<?php
class Family extends AppModel {
	
	public function getFamilies(){
		$result = $this->query('select * from families');
		return $result;
	}
}
?>