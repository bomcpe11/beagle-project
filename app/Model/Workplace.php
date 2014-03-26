<?php
class Workplace extends AppModel {
	
	public function getWorkplaces(){
		$result = $this->query('select * from workplaces');
		return $result;
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function insertData($name
								,$telephone
								,$startyear
								,$endyear
								,$position
								,$profile_id){
		$flag = false;
		$sql = "INSERT INTO workplaces 
				(seq
				,name
				,telephone
				,startyear
				,endyear
				,position
				,profile_id
				,created_at
				,updated_at)
				VALUES
				((SELECT ifnull(max(w.seq),0)+1 AS seq FROM workplaces w WHERE w.profile_id=$profile_id)
				,'$name'
				,'$telephone'
				,'$startyear'
				,'$endyear'
				,'$position'
				,'$profile_id'
				,now()
				,now())";
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function updateData($id
								,$name
								,$telephone
								,$startyear
								,$endyear
								,$position){
		$flag = false;
		$sql = "UPDATE workplaces 
				 SET name='$name'
					 ,telephone='$telephone'
					 ,startyear='$startyear'
					 ,endyear='$endyear'
					 ,position='$position'
					 ,updated_at=now()
				 WHERE id=$id";
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function updateSeq($id,$seq){
		$flag = false;
		$sql = "UPDATE workplaces 
				 SET seq=$seq
					 ,updated_at=now()
				 WHERE id=$id";
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
	public function deleteData($id){
		$flag = false;
		$sql = "DELETE FROM workplaces WHERE id=$id";
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* -------------------------------------------------------------------------------------------------- */
	public function getDataByProfileId($profile_id){
		$result = null;
		$sql = "SELECT w.*
				FROM workplaces w
				WHERE w.profile_id='$profile_id'
				ORDER BY seq";
		//$this->log($sql);
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
}
?>