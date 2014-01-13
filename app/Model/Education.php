<?php
class Education extends AppModel {
	
	public function getEducations(){
		$result = $this->query('select * from educations');
		return $result;
	}
	public function getEducationByProfileId($profile_id){
		$sql = "SELECT * FROM educations WHERE profile_id='$profile_id'";
		$this->log($sql);
		
		$result = $this->query($sql);
		
		return $result;
	}
}
?>