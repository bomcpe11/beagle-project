<?php
class Workplace extends AppModel {
	
	public function getWorkplaces(){
		$result = $this->query('select * from workplaces');
		return $result;
	}
}
?>