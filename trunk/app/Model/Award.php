<?php
class Award extends AppModel {
	
	public function getAwards(){
		$result = $this->query('select * from awards');
		return $result;
	}
}
?>