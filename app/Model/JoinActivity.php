<?php
class JoinActivity extends AppModel{
	public $names = 'JoinActivity';
	/* ------------------------------------------------------------------------------------------------ */
	public function insertData($profile_id, $activity_id, $position){
		$flag = false;
		$sql = "INSERT INTO join_activities VALUES('$profile_id', '$activity_id', '$position')";
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function updatePosition($profile_id, $activity_id, $position){
		$flag = false;
		$sql = "UPDATE join_activities 
					SET position='$position'
					WHERE profile_id=$profile_id
						AND activity_id=$activity_id";
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deleteData($profile_id, $activity_id){
		$flag = false;
		$sql = "DELETE FROM join_activities 
					WHERE profile_id=$profile_id
						AND activity_id=$activity_id";
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function getAll(){
		$result = $this->query('select * from activities ');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function getActivityForProfile($profile_id){
		$result = null;
		$sql = "SELECT ja.*, a.*
				FROM join_activities ja, activities a
				WHERE ja.activity_id = a.id
					AND ja.profile_id='$profile_id'";
		//$this->log($sql);
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------ */
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
	/* ------------------------------------------------------------------------------------------------ */
}