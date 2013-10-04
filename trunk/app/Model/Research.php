<?php
class Research extends AppModel {
	
	public function getResearches(){
		$result = $this->query('select * from researches');
		return $result;
	}
}
?>