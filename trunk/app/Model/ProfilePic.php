<?php
class ProfilePic extends AppModel {
	
	public function getProfiles(){
		$result = $this->query('select * from profile_pics');
		return $result;
	}
	/*	---------------------------------------------------------------------------------- */
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
}// ProfilePic