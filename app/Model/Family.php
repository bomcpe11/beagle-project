<?php
class Family extends AppModel {
	
	public function getFamilies(){
		$result = $this->query('select * from families');
		return $result;
	}
	public function getFamiliesByProfileId($profile_id){
		$result = null;
		$sql = "SELECT *
				 FROM families 
				 WHERE profile_id = '$profile_id'";
		$this->log('sql => '.$sql);
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
	public function insertFamily($profile_id, $relation, $name, $lastname, $education, $occupation, $position){
		$flag = false;
		$sql = "INSERT INTO families 
				(profile_id, relation
				, name, lastname
				, education, occupation
				, position, created_at
				, updated_at) 
				VALUES
				('$profile_id', '$relation'
				, '$name', '$lastname'
				, '$education', '$occupation'
				, '$position', sysdate()
				, sysdate())";
		$this->log('sql => '.$sql);
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	public function updateFamily($profile_id, $relation
								, $name, $lastname
								, $education, $occupation
								, $position, $family_id){
		$flag = false;
		$sql = "UPDATE families 
				SET profile_id='$profile_id'
				, relation='$relation'
				, name='$name'
				, lastname='$lastname'
				, education='$education'
				, occupation='$occupation'
				, position='$position'
				, updated_at=sysdate()
				WHERE id='$family_id'";
		$this->log('sql => '.$sql);
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	public function deleteFamily($id){
		$flag = false;
		$sql = "DELETE FROM families WHERE id='$id'";
		$this->log('sql => '.$sql);
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
}
?>