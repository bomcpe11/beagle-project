<?php
class Profile extends AppModel {
	
	public function getProfiles(){
		$result = $this->query('select * from profiles');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------------- */
	public function checkUsername($username) {
		$strSql = "SELECT * FROM profiles WHERE login = '".$username."';";
		$this->log($strSql, LOG_DEBUG);
		
		$result = $this->query($strSql);
		
		return $result;
	}// checkUsername
	/* ------------------------------------------------------------------------------------------------------- */
	public function checkPassword($password) {
		$strSql = "SELECT * FROM profiles WHERE encrypt_password = '".$password."';";
		$this->log($strSql, LOG_DEBUG);
	
		$result = $this->query($strSql);
	
		return $result;
	}// checkUsername
}
?>