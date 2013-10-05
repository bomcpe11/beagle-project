<?php
class Gvar extends AppModel {
	
	public function getGvars(){
		$result = $this->query('select * from gvars');
		return $result;
	}
}
?>