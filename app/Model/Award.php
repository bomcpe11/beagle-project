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
								,$yearaward
								,$detail){
		$flag = false;
		$sql = "INSERT INTO awards 
					(seq
					,name
					,awardname
					,organization
					,profile_id
					,created_at
					,updated_at
					,yearaward
					,detail)
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
					,'$yearaward'
					,'$detail')";
		
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
	public function updateData($id
								,$name
								,$awardname
								,$organization
								,$yearaward
								,$detail){
		$flag = false;
		$sql = "UPDATE awards
					SET name='$name'
						,awardname='$awardname'
						,organization='$organization'
						,created_at=now()
						,updated_at=now()
						,yearaward='$yearaward'
						,detail='$detail'
					WHERE id=$id";
// 		$this->log($sql);
		
		try{
			$this->query($sql);
			$flag = true;
			try{
				$this->setProfileUpdSearchFlg("(select profile_id from awards where id=".$id.")");
			}catch(Exception $e){
				
			}
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* --------------------------------------------------------------------------------------------------- */
	public function updateThumbPath($id, $imgPath){
		$flag=false;
		$sql="UPDATE awards
				SET thumbpath='$imgPath'
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