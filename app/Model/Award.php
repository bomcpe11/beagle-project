<?php
class Award extends AppModel {
	/* ------------------------------------------------------------------------------------------------- */
	public function getAwards(){
		$result = $this->query('select * from awards');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function insertData($name
								,$awardname
								,$organization
								,$profile_id
								,$yearaward){
		$flag = false;
		$sql = "INSERT INTO awards 
					(seq
					,name
					,awardname
					,organization
					,profile_id
					,created_at
					,updated_at
					,yearaward)
				VALUES(
					(SELECT ifnull(max(a.seq),-1)+1 AS seq 
							FROM awards a
							WHERE a.profile_id=$profile_id)
					,'$name'
					,'$awardname'
					,'$organization'
					,'$profile_id'
					,now()
					,now()
					,'$yearaward')";
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function updateData($id
								,$name
								,$awardname
								,$organization
								,$yearaward){
		$flag = false;
		$sql = "UPDATE awards
					SET name='$name'
						,awardname='$awardname'
						,organization='$organization'
						,created_at=now()
						,updated_at=now()
						,yearaward='$yearaward'
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
	/* --------------------------------------------------------------------------------------------------- */
	public function updateSeq($id,$seq){
		$flag = false;
		$sql = "UPDATE awards 
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
		$sql = "DELETE FROM awards WHERE id=$id";
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function getDataByProfileId($profile_id){
		$result = null;
		$sql = "SELECT a.*
				FROM awards a
				WHERE a.profile_id=$profile_id
				ORDER BY a.seq ASC";
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