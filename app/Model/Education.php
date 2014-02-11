<?php
class Education extends AppModel {
	/* ------------------------------------------------------------------------------------------------- */
	public function getEducations(){
		$result = $this->query('select * from educations');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------- */
	public function getEducationByProfileId($profile_id){
		$sql = "SELECT * FROM educations WHERE profile_id='$profile_id'";
		
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
		$flag = false;
		$sql = "INSERT INTO educations 
					(name
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
					('$name'
					, '$faculty'
					, '$major'
					, '$gpa'
					, STR_TO_DATE('$startyear', '%d,%m,%Y')
					, STR_TO_DATE('$endyear', '%d,%m,%Y')
					, '$edutype'
					, $profile_id
					, now()
					, now()
					, $isGraduate)";
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
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
}
?>