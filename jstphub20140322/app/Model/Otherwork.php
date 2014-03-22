<?php
class Otherwork extends AppModel{
	/* ------------------------------------------------------------------------------------------------- */
	public function getDataByProfileId($profile_id){
		$result=null;
		$sql = "SELECT * FROM otherworks o WHERE profile_id='$profile_id'";
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function insertData($name
								,$organization
								,$profile_id
								,$yearfinish
								,$isnotfinish){
		$flag=false;
		$sql="INSERT INTO otherworks (
							name
							,organization
							,profile_id
							,created_at
							,updated_at
							,yearfinish
							,isnotfinish)
					VALUES('$name'
							,'$organization'
							,'$profile_id'
							,now()
							,now()
							,$yearfinish
							,$isnotfinish)";
		//$this->log($sql);
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function updateData($id
								,$name
								,$organization
								,$profile_id
								,$yearfinish
								,$isnotfinish){
		$flag=false;
		$sql="UPDATE otherworks
				SET name='$name'
					,organization='$organization'
					,profile_id='$profile_id'
					,updated_at=now()
					,yearfinish=$yearfinish
					,isnotfinish=$isnotfinish
				WHERE id='$id'";
		//$this->log($sql);
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deleteData($id){
		$flag=false;
		$sql="DELETE FROM otherworks WHERE id='$id'";
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