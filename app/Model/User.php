<?php
class User extends AppModel {
	
	public function getUsers(){
		$result = $this->query('select * from users');
		return $result;
	}
}
?>