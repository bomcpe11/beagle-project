<?php
class Activity extends AppModel {
	
	public function getActivites(){
		$result = $this->query('select * from activities ');
		return $result;
	}
	
	public function deleteActivites($idDelete){
		$sql = 'delete from activities where id ='.$idDelete;
		$result = $this->query($sql);
		return $result;
	}
}
?>