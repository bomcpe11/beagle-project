<?php
class Activity extends AppModel {
	
	public function getActivites(){
		$result = $this->query('select * from activities');
		return $result;
	}
}
?>