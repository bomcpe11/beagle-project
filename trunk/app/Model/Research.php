<?php
class Research extends AppModel {
	/* ------------------------------------------------------------------------------------------------ */
	public function getResearches(){
		$result = $this->query('select * from researches');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function getDataByProfileId($profile_id){
		$result=null;
		$sql="SELECT r.*
				,(SELECT vardesc1 FROM gvars g WHERE g.varname='RESEARCH_TYPE' AND g.varcode=r.researchtype) research_type
				FROM researches r 
				WHERE r.profile_id='$profile_id'
				ORDER BY r.seq ASC";
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function insertData($name
								,$researchtype
								,$advisor
								,$organization
								,$profile_id
								,$isnotfinish
								,$yearstart
								,$yearfinish
								,$dissemination
								,$detail){
		$flag=false;
		$sql="INSERT INTO researches (
							seq
							,name
							,researchtype
							,advisor
							,organization
							,profile_id
							,created_at
							,updated_at
							,isnotfinish
							,yearstart
							,yearfinish
							,dissemination
							,detail)
					VALUES(
							(SELECT ifnull(max(r.seq),-1)+1 AS seq 
								FROM researches r 
								WHERE r.profile_id=$profile_id)
							,'$name'
							,'$researchtype'
							,'$advisor'
							,'$organization'
							,$profile_id
							,now()
							,now()
							,$isnotfinish
							,$yearstart
							,$yearfinish
							,'$dissemination'
							,'$detail')";
		//$this->log($sql);
		
		try{
			$this->query($sql);
			$flag = true;
			try{
				$this->setProfileUpdSearchFlg($id);
			}catch(Exception $e){
				
			}
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function updateData($id
								,$name
								,$researchtype
								,$advisor
								,$organization
								,$profile_id
								,$isnotfinish
								,$yearstart
								,$yearfinish
								,$dissemination
								,$detail){
		$flag=false;
		$sql="UPDATE researches
				SET name='$name'
					,researchtype='$researchtype'
					,advisor='$advisor'
					,organization='$organization'
					,profile_id=$profile_id
					,updated_at=now()
					,isnotfinish=$isnotfinish
					,yearstart=$yearstart
					,yearfinish=$yearfinish
					,dissemination='$dissemination'
					,detail='$detail'
				WHERE id=$id";
		//$this->log($sql);
		
		try{
			$this->query($sql);
			$flag = true;
			try{
				$this->setProfileUpdSearchFlg($id);
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
		$sql="UPDATE researches
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
		$sql = "UPDATE researches 
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
		$sql="DELETE FROM researches WHERE id='$id'";
		//$this->log($sql);
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
		
	}
	
	public function setProfileUpdSearchFlg($id) {
		$flag = false;
		$strSql = "UPDATE profiles SET updforsearchflg=1 WHERE id=(select profile_id from researches where id=".$id.")";
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