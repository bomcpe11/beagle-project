<?php
class Education extends AppModel {
	
	public function getEducations(){
		$result = $this->query('select * from educations');
		return $result;
	}
}
?>