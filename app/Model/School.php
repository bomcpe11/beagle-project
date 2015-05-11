<?php
class School extends AppModel {
	
	public function getAlls(){
		$result = $this->query('select * from schools t');
		return $result;
	}

	public function getForDDL(){
		$result = $this->query('select id, name from schools t');
		return $result;
	}
	
	public function getRecord($id){
		$result = $this->query('select * from schools t where id='.$id);
		return $result;
	}
}
?>