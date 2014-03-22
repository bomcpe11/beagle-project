<?php
class ProfilePic extends AppModel {
	
	public function getProfiles(){
		$result = $this->query('select * from profile_pics');
		return $result;
	}
	/* ---------------------------------------------------------------------------------- */
	public function insertAll($proflieid
								, $imgpath
								, $imgdesc
								, $edustep
								, $imgdtm
								, $uploaddtm) {
		$flag = false;
		$strSql = "INSERT INTO profile_pics";
		$strSql .= " (";
  		$strSql .= " proflieid";
  		$strSql .= " ,imgpath";
  		$strSql .= " ,imgdesc";
  		$strSql .= " ,edustep";
  		$strSql .= " ,imgdtm";
  		$strSql .= " ,uploaddtm";
		$strSql .= " )";
		$strSql .= " VALUES";
		$strSql .= " (";
  		$strSql .= " ".$proflieid; // proflieid - IN int(11)
  		$strSql .= " ,'".$imgpath."'"; // imgpath - IN varchar(255)
  		$strSql .= " ,'".$imgdesc."'"; // imgdesc - IN varchar(1000)
  		$strSql .= " ,".$edustep; // edustep - IN tinyint(4)
  		$strSql .= " ,'".$imgdtm."'"; // imgdtm - IN datetime
  		$strSql .= " ,CURRENT_TIMESTAMP"; // uploaddtm - IN datetime
		$strSql .= " )";
		$strSql .= ";";
		$this->log("strSql => ".$strSql);
		
		try {
			$this->query($strSql);
			
			$flag = true;
		} catch ( Exception $e ) {
			$this->log("Exception => ".$e.getMessage());
		}// try catch
		
		return $flag;
	}// insert
	/* ---------------------------------------------------------------------------------- */
	public function updateImgPathById($imgPath, $byId) {
		$flag = false;
		$strSql = "UPDATE profile_pics";
		$strSql .= " SET";
  		$strSql .= " imgpath = '".$imgPath."'"; // varchar(255)
		$strSql .= " WHERE id = ".$byId; // int(11)"
		$this->log("strSql => ".$strSql);
		
		try {
			$this->query($strSql);
			
			$flag = true;
		} catch ( Exception $e ) {
			$this->log("Exception => ".$e.getMessage());
		}// try catch
		
		return $flag;
	}// updateImgPathById
	/* ---------------------------------------------------------------------------------- */
	public function getLastInsert() {
		$result = null;
		$strSql = "SELECT LAST_INSERT_ID() AS last_index_id;";
		$this->log("strSql => ".$strSql);
		
		try {
			$result = $this->query($strSql);
		} catch ( Exception $e ) {
			$this->log("Exception => ".$e.getMessage());
		}// try catch
		
		return $result;
	}// getLastInsert
	/* ---------------------------------------------------------------------------------- */
	public function getStarByProfileId($byProfileId) {
		$result = null;
		$strSql = "SELECT * FROM profile_pics WHERE proflieid = '".$byProfileId."';";
		$this->log("strSql => ".$strSql);
	
		try {
			$result = $this->query($strSql);
		} catch ( Exception $e ) {
			$this->log("Exception => ".$e.getMessage());
		}// try catch
	
		return $result;
	}// getStarByProfileId
}// ProfilePic