<?php
class Education extends AppModel {
	/* ------------------------------------------------------------------------------------------------- */
	public function getEducations(){
		$result = $this->query('select * from educations');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function getEducationByProfileId($profile_id){
		$sql = "SELECT * 
				FROM educations 
				WHERE profile_id='$profile_id' 
				ORDER BY seq ASC";
		
		$result = $this->query($sql);
		
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function insertEducation($name
					, $faculty
					, $major
					, $gpa
					, $startyear
					, $endyear
					, $edutype
					, $profile_id
					, $isGraduate){
		
// 		$name = mysql_escape_string($name);
		
		$flag = false;
		$sql = "INSERT INTO educations 
					(seq
					, name
					, faculty
					, major
					, gpa
					, startyear
					, endyear
					, edutype
					, profile_id
					, created_at
					, updated_at
					, isGraduate) 
				VALUES 
					( (SELECT ifnull(max(e.seq),0) + 1 AS seq FROM educations e WHERE e.profile_id=$profile_id)
					,'$name'
					, '$faculty'
					, '$major'
					, '$gpa'
					, ".(empty($startyear)?"NULL":"STR_TO_DATE('$startyear', '%d,%m,%Y')")."
					, ".(empty($endyear)?"NULL":"STR_TO_DATE('$endyear', '%d,%m,%Y')")."
					, '$edutype'
					, $profile_id
					, now()
					, now()
					, $isGraduate)";
		
		try{
			$this->query($sql);
			$flag = true;
			try{
				$this->setProfileUpdSearchFlg($profile_id);
			}catch(Exception $e){
				
			}
		}catch(Exception $e){
			$this->log($e->getMessage());
			$this->log($sql);
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function updateEducation($id
					, $name
					, $faculty
					, $major
					, $gpa
					, $startyear
					, $endyear
					, $edutype
					, $profile_id
					, $isGraduate){
		
// 		$name = mysql_escape_string($name);
		
		$flag = false;
		$sql = "UPDATE educations 
					SET name = '$name'
					, faculty = '$faculty'
					, major = '$major'
					, gpa = '$gpa'
					, startyear = STR_TO_DATE('$startyear', '%d,%m,%Y')
					, endyear = STR_TO_DATE('$endyear', '%d,%m,%Y')
					, edutype = '$edutype'
					, updated_at = now()
					, isGraduate = $isGraduate 
					WHERE id = '$id'";
		
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
	public function updateSeq($id,$seq){
		$flag = false;
		$sql = "UPDATE educations 
					SET seq = $seq
					, updated_at = now()
					WHERE id = '$id'";
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
	public function deleteEducation($id){
		$flag = false;
		$sql = "DELETE FROM educations WHERE id='$id'";
		
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