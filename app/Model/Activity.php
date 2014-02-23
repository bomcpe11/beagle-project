<?php
class Activity extends AppModel {
	/* ------------------------------------------------------------------------------------------------ */
	public function getActivites(){
		$result = $this->query('select * from activities ');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------ */
// 	public function deleteActivites($idDelete){
// 		$sql = 'delete from activities where id ='.$idDelete;
// 		$result = $this->query($sql);
// 		return $result;
// 	}
	/* ------------------------------------------------------------------------------------------------ */
	public function deleteActivites($idDelete){
		$flag = false;
		$sql = 'delete from activities where id ='.$idDelete;
		$this->log('sql => '.$sql);
	
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
	
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function getDataByStmtSql($stmt_sql){
		$result = null;
		$sql = "SELECT * FROM activities WHERE $stmt_sql";
		$this->log($sql);
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function getDataForAsearch($profile_id,$stmt_sql){
		$result = null;
		$sql = "SELECT * 
					,(SELECT 1 FROM join_activities ja WHERE ja.activity_id=a.id AND ja.profile_id=$profile_id) AS flag_joind_activity
					FROM activities a WHERE $stmt_sql";
		$this->log($sql);
		
		try{
			$result = $this->query($sql);
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function insertActivities(     $name
										, $startdtm
										, $enddtm
										, $location
										, $genname
										, $shortdesc
										, $longdesc) {
		$this->log("START MODEL  insertActivities ");
		$flag = false;
		$strSql = "INSERT INTO activities";
		$strSql .= " (";
		$strSql .= " name";
		$strSql .= " ,startdtm";
		$strSql .= " ,enddtm";
		$strSql .= " ,location";
		$strSql .= " ,genname";
		$strSql .= " ,shortdesc";
		$strSql .= " ,longdesc";
		$strSql .= " ,created_at";
		$strSql .= " ,updated_at";
		$strSql .= " )";
		$strSql .= " VALUES";
		$strSql .= " (";
		$strSql .= " '".$name."'"; 
		$strSql .= " ,'".$startdtm."'"; 
		$strSql .= " ,'".$enddtm."'"; 
		$strSql .= " ,'".$location."'"; 
		$strSql .= " ,'".$genname."'"; 
		$strSql .= " ,'".$shortdesc."'";
		$strSql .= " ,'".$longdesc."'";
		$strSql .= " ,sysdate()"; 
		$strSql .= " ,sysdate()"; 
		$strSql .= " )";
		$strSql .= ";";
		$this->log("strSql => ".$strSql);
		 
		try {
			$this->query($strSql);
	
			$flag = true;
		} catch ( Exception $e ) {
			$this->log("exception => ".$e->getMessage());
		}
		 
		return $flag;
		$this->log("END MODEL  insertActivities ");
	}
	/* ------------------------------------------------------------------------------------------------ */
	public function updateActivity (  $id
									, $name
									, $startdtm
									, $enddtm
									, $location
									, $genname
									, $shortdesc
									, $longdesc) {
		$flag = false;
		$strSql = "UPDATE activities";
		$strSql .= " SET name = '".$name."'";	
		$strSql .= " ,startdtm = '".$startdtm."'";	
		$strSql .= " ,enddtm = '".$enddtm."'";
		$strSql .= " ,location = '".$location."'";	
		$strSql .= " ,genname = '".$genname."'";
		$strSql .= " ,shortdesc = '".$shortdesc."'";
		$strSql .= " ,longdesc = '".$longdesc."'";
		$strSql .= " ,updated_at = sysdate()";		
		$strSql .= " WHERE id = ".$id;
		$strSql .= ";";
		$this->log("strSql => ".$strSql);
	
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