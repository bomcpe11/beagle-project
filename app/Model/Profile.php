<?php
class Profile extends AppModel {
	
	public function getProfiles(){
		$result = $this->query('select * from profiles');
		return $result;
	}
}
?>