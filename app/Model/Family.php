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
				 ORDER BY seq ASC";
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function insertFamily($profile_id
									,$relation
									,$name
									,$lastname
									,$education
									,$occupation
									,$position
									,$status){
		$flag = false;
		$sql = "INSERT INTO families 
				(seq
				,profile_id
				,relation
				,name, lastname
				,education
				,occupation
				,position
				,status
				,created_at
				,updated_at) 
				VALUES
				((SELECT ifnull(max(f.seq),0) + 1 as seq 
						FROM families f 
						WHERE f.profile_id=$profile_id)
				,'$profile_id'
				,'$relation'
				,'$name'
				,'$lastname'
				,'$education'
				,'$occupation'
				,'$position'
				,'$status'
				,sysdate()
				,sysdate())";
		//$this->log($sql);
		
		try{
			$this->query($sql);
			$flag = true;
			try{
				$this->setProfileUpdSearchFlg($profile_id);
			}catch(Exception $e){
				
			}
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function updateFamily($profile_id
									,$relation
									,$name
									,$lastname
									,$education
									,$occupation
									,$position
									,$family_id
									,$status){
		$flag = false;
		$sql = "UPDATE families 
				SET profile_id='$profile_id'
				,relation='$relation'
				,name='$name'
				,lastname='$lastname'
				,education='$education'
				,occupation='$occupation'
				,position='$position'
				,status='$status'
				,updated_at=sysdate()
				WHERE id='$family_id'";
		
		try{
			$this->query($sql);
			$flag = true;
			try{
				$this->setProfileUpdSearchFlg($profile_id);
			}catch(Exception $e){
				
			}
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function updateSeq($id, $seq){
		$flag = false;
		$sql = "UPDATE families 
				SET seq=$seq
				WHERE id=$id";
		
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
	
	public function setProfileUpdSearchFlg($profile_id) {
		$flag = false;
		$strSql = "UPDATE profiles SET updforsearchflg=1 WHERE id=$profile_id";
		// 			$this->log($strSql);
		try {
			$this->query($strSql);
			$flag = true;
		} catch ( Exception $e ) {
			$this->log("Exception => ".$e->getMessage());
		}
	
		return $flag;
	}
}
?>