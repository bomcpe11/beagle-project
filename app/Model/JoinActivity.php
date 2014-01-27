<?php
class JoinActivity extends AppModel{
	public $names = 'JoinActivity';
	
	public function getAll(){
		$result = $this->query('select * from activities ');
		return $result;
	}
	public function getDataByProfileIdActivityId($profile_id, $activity_id){
		$result = null;
		$sql = "SELECT * FROM join_activities WHERE profile_id='$profile_id' AND activity_id='$activity_id'";
		//$this->log($sql);
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
	public function insertData($profile_id, $activity_id, $position){
		$flag = false;
		$sql = "INSERT INTO join_activities VALUES('$profile_id', '$activity_id', '$position')";
		//$this->log($sql);
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
}