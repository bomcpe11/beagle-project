<?php
class Family extends AppModel {
	/* ------------------------------------------------------------------------------------------------- */
	public function getFamilies(){
		$result = $this->query('select * from families');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function getFamiliesByProfileId($profile_id){
		$result = null;
		$sql = "SELECT *
				 FROM families 
				 WHERE profile_id = '$profile_id'
				 ORDER BY family_seq ASC";
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function insertFamily($profile_id, $relation, $name, $lastname, $education, $occupation, $position){
		$flag = false;
		$sql = "INSERT INTO families 
				(profile_id
				,family_seq
				,relation
				,name, lastname
				,education
				,occupation
				,position
				,created_at
				,updated_at) 
				VALUES
				('$profile_id'
				,(SELECT ifnull(max(f.family_seq),0) + 1 as profile_seq 
						FROM families f 
						WHERE f.profile_id=$profile_id)
				,'$relation'
				,'$name'
				,'$lastname'
				,'$education'
				,'$occupation'
				,'$position'
				,sysdate()
				,sysdate())";
		//$this->log($sql);
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------- */
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
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function updateFamilySeq($family_id, $family_seq){
		$flag = false;
		$sql = "UPDATE families 
				SET family_seq=$family_seq
				WHERE id=$family_id";
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function deleteFamily($id){
		$flag = false;
		$sql = "DELETE FROM families WHERE id='$id'";
		
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