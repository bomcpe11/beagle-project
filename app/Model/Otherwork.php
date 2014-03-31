<?php
class Otherwork extends AppModel{
	/* ------------------------------------------------------------------------------------------------- */
	public function getDataByProfileId($profile_id){
		$result=null;
		$sql = "SELECT o.* 
					FROM otherworks o 
					WHERE o.profile_id=$profile_id
					ORDER BY o.seq ASC";
		
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
								,$yearstart
								,$yearfinish
								,$isnotfinish
								,$detail){
		$flag=false;
		$sql="INSERT INTO otherworks (
							seq
							,name
							,organization
							,profile_id
							,created_at
							,updated_at
							,yearstart
							,yearfinish
							,isnotfinish
							,detail)
					VALUES(
							(SELECT ifnull(max(o.seq),-1)+1 AS seq 
								FROM otherworks o 
								WHERE o.profile_id=$profile_id)
							,'$name'
							,'$organization'
							,'$profile_id'
							,now()
							,now()
							,$yearstart
							,$yearfinish
							,$isnotfinish
							,'$detail')";
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
								,$yearstart
								,$yearfinish
								,$isnotfinish
								,$detail){
		$flag=false;
		$sql="UPDATE otherworks
				SET name='$name'
					,organization='$organization'
					,profile_id='$profile_id'
					,updated_at=now()
					,yearstart=$yearstart
					,yearfinish=$yearfinish
					,isnotfinish=$isnotfinish
					,detail='$detail'
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
	/* --------------------------------------------------------------------------------------------------- */
	public function updateSeq($id,$seq){
		$flag = false;
		$sql = "UPDATE otherworks 
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