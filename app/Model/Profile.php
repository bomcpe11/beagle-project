<?php
class Profile extends AppModel {
	
	public function getProfiles(){
		$result = $this->query('select * from profiles');
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------------- */
	public function insert($cardid
				  		, $cardtype
				  		, $nameth
				  		, $lastnameth
				  		, $nameeng
				 		, $nickname
				  		, $generation
				  		, $birthday
				  		, $nationality
				  		, $religious
				 		, $socialstatus
				 		, $studystatus
				 		, $address
				  		, $telphone
				  		, $celphone
				  		, $email
				 		, $blogaddress
				  		, $image_file
				  		, $image_desc
				  		, $created_at
				  		, $updated_at
				  		, $lastnameeng
				  		, $titleth
				  		, $titleen
				 		, $position
				 		, $login
				  		, $encrypt_password
				  		, $role
				  		, $login_count
				  		, $failed_login_count
				 		, $last_login_at) {
		$flag = false;
		$strSql = "INSERT INTO profiles";
		$strSql .= " (";
 		$strSql .= " cardid";
  		$strSql .= " ,cardtype";
  		$strSql .= " ,nameth";
  		$strSql .= " ,lastnameth";
  		$strSql .= " ,nameeng";
 		$strSql .= " ,nickname";
  		$strSql .= " ,generation";
  		$strSql .= " ,birthday";
  		$strSql .= " ,nationality";
  		$strSql .= " ,religious";
 		$strSql .= " ,socialstatus";
 		$strSql .= " ,studystatus";
 		$strSql .= " ,address";
  		$strSql .= " ,telphone";
  		$strSql .= " ,celphone";
  		$strSql .= " ,email";
 		$strSql .= " ,blogaddress";
  		$strSql .= " ,image_file";
  		$strSql .= " ,image_desc";
  		$strSql .= " ,created_at";
  		$strSql .= " ,updated_at";
  		$strSql .= " ,lastnameeng";
  		$strSql .= " ,titleth";
  		$strSql .= " ,titleen";
 		$strSql .= " ,position";
 		$strSql .= " ,login";
  		$strSql .= " ,encrypt_password";
  		$strSql .= " ,role";
  		$strSql .= " ,login_count";
  		$strSql .= " ,failed_login_count";
 		$strSql .= " ,last_login_at";
		$strSql .= " )";
		$strSql .= " VALUES";
		$strSql .= " (";
  		$strSql .= " ".$cardid; // cardid - IN varchar(20)
 		$strSql .= " ,".$cardtype; // cardtype - IN tinyint(4)
 		$strSql .= " ,'".$nameth."'"; // nameth - IN varchar(255)
  		$strSql .= " ,'".$lastnameth."'"; // lastnameth - IN varchar(255)
  		$strSql .= " ,'".$nameeng."'"; // nameeng - IN varchar(255)
  		$strSql .= " ,'".$nickname."'"; // nickname - IN varchar(255)
  		$strSql .= " ,'".$generation."'"; // generation - IN varchar(255)
  		$strSql .= " ,'".$birthday."'"; // birthday - IN date
  		$strSql .= " ,'".$nationality."'"; // nationality - IN varchar(255)
  		$strSql .= " ,'".$religious."'"; // religious - IN varchar(255)
  		$strSql .= " ,'".$socialstatus."'"; // socialstatus - IN varchar(255)
  		$strSql .= " ,'".$studystatus."'"; // studystatus - IN varchar(255)
  		$strSql .= " ,'".$address."'"; // address - IN varchar(1000)
  		$strSql .= " ,'".$telphone."'"; // telphone - IN varchar(255)
  		$strSql .= " ,'".$celphone."'"; // celphone - IN varchar(255)
  		$strSql .= " ,'".$email."'"; // email - IN varchar(255)
  		$strSql .= " ,'".$blogaddress."'"; // blogaddress - IN varchar(255)
  		$strSql .= " ,'".$image_file."'"; // image_file - IN varchar(255)
  		$strSql .= " ,'".$image_desc."'"; // image_desc - IN varchar(500)
  		$strSql .= " ,sysdate()"; // created_at - IN datetime
  		$strSql .= " ,sysdate()"; // updated_at - IN datetime
  		$strSql .= " ,'".$lastnameeng."'"; // lastnameeng - IN varchar(255)
  		$strSql .= " ,'".$titleth."'"; // titleth - IN varchar(255)
  		$strSql .= " ,'".$titleen."'"; // titleen - IN varchar(255)
  		$strSql .= " ,'".$position."'"; // position - IN varchar(255)
  		$strSql .= " ,'".$login."'"; // login - IN varchar(255)
  		$strSql .= " ,'".$encrypt_password."'"; // encrypt_password - IN varchar(40)
  		$strSql .= " ,'".$role."'"; // role - IN varchar(10)
  		$strSql .= " ,'".$login_count."'"; // login_count - IN int(11)
  		$strSql .= " ,'".$failed_login_count."'"; // failed_login_count - IN int(11)
  		$strSql .= " ,'".$last_login_at."'"; // last_login_at - IN datetime
		$strSql .= " )";
   		$strSql .= ";";
   		//$this->log("strSql => ".$strSql);
   		
   		try {
   			$this->query($strSql);
   			
   			$flag = true;
   		} catch ( Exception $e ) {
   			$this->log("exception => ".$e->getMessage());
   		}// try catch
   		
   		return $flag;
	}// insert
	/* ------------------------------------------------------------------------------------------------------- */
	public function updateProfile($profileId
									,$titleTh
									,$nameTh
									,$lastnameTh
									,$titleEng
									,$nameEng
									,$lastnameEng
									,$nickname
									,$generation
									,$birthday
									,$nationality
									,$religious
									,$socialStatus
									,$studyStatus
									,$address
									,$telPhone
									,$celPhone 
									,$email
									,$blogAddress) {
		$flag = false;
		$strSql = "UPDATE profiles";
		$strSql .= " SET titleth = '".$titleTh."'";	// VARCHAR(255)
		$strSql .= " ,nameth = '".$nameTh."'";	// VARCHAR(255)
		$strSql .= " ,lastnameth = '".$lastnameTh."'";	// VARCHAR(255)
		$strSql .= " ,titleen = '".$titleEng."'";	// VARCHAR(255)
		$strSql .= " ,nameeng = '".$nameEng."'";	// VARCHAR(255)
		$strSql .= " ,lastnameeng = '".$lastnameEng."'";	// VARCHAR(255)
		$strSql .= " ,nickname = '".$nickname."'";	// VARCHAR(255)
		$strSql .= " ,generation = '".$generation."'";	// VARCHAR(255)
		$strSql .= " ,birthday = '".$birthday."'";	// DATE
		$strSql .= " ,nationality = '".$nationality."'";	// VARCHAR(255)
		$strSql .= " ,religious = '".$religious."'";	// VARCHAR(255)
		$strSql .= " ,socialstatus = '".$socialStatus."'";	// VARCHAR(255)
		$strSql .= " ,studystatus = '".$studyStatus."'";	// VARCHAR(255)
		$strSql .= " ,address = '".$address."'";	// VARCHAR(1000)
		$strSql .= " ,telphone = '".$telPhone."'";	// VARCHAR(255)
		$strSql .= " ,celphone = '".$celPhone."'";	// VARCHAR(255)
		$strSql .= " ,email = '".$email."'";	// VARCHAR(255)
		$strSql .= " ,blogaddress = '".$blogAddress."'";	// VARCHAR(255)
		$strSql .= " ,updated_at = sysdate()";	// DATETIME
		$strSql .= " WHERE id = ".$profileId;
		$strSql .= ";";
		//$this->log("strSql => ".$strSql);
		
		try {
			$this->query($strSql);
			
			$flag = true;
		} catch ( Exception $e ) {
			$this->log("Exception => ".$e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------------- */
	public function updateImg($id
								,$image_file
								,$image_desc){
		$flag = false;
		$sql = "UPDATE profiles
					 SET image_file='$image_file'
					 	,image_desc='$image_desc'
					 WHERE id='$id'";
		
		try {
			$this->query($sql);
			$flag = true;
		} catch (Exception $e) {
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	/* ------------------------------------------------------------------------------------------------------- */
	public function updatePassword($newPassword, $username) {
		$flag = false;
		$strSql = "UPDATE profiles";
		$strSql .= " SET encrypt_password = '".$newPassword."'"; // varchar(40)
		$strSql .= " WHERE login = '".$username."'"; // varchar(255)
		$strSql .= ";";
		
		try {
			$this->query($strSql);
			$flag = true;
		} catch ( Exception $e ) {
			$this->log("exception => ".$e->getMessage());
		}// try catch
		
		return $flag;
	}// updatePassword
	/* ------------------------------------------------------------------------------------------------------- */
	public function checkLogin($username) {
		$result = null;
		$strSql = "SELECT * FROM profiles WHERE login = '".$username."';";
		//$this->log("strSql => ".$strSql);
		
		try {
   			$result = $this->query($strSql);
   		} catch ( Exception $e ) {
   			$this->log("exception => ".$e->getMessage());
   		}// try catch
		
		return $result;
	}// checkLogin
	/* ------------------------------------------------------------------------------------------------------- */
	public function checkCardId($cardId) {
		$result = null;
		$strSql = "SELECT cardid FROM profiles WHERE cardid = '".$cardId."';";
		//$this->log("strSql => ".$strSql);
		
		try {
   			$result = $this->query($strSql);
   		} catch ( Exception $e ) {
   			$this->log("exception => ".$e->getMessage());
   		}// try catch
		
		return $result;
	}// checkCardId
	/* ------------------------------------------------------------------------------------------------------- */
	public function checkEmail($email) {
		$result = null;
		$strSql = "SELECT email FROM profiles WHERE email = '".$email."';";
		//$this->log("strSql => ".$strSql);
	
		try {
   			$result = $this->query($strSql);
   		} catch ( Exception $e ) {
   			$this->log("exception => ".$e->getMessage());
   		}// try catch
	
		return $result;
	}// checkEmail
	/* ------------------------------------------------------------------------------------------------------- */
	public function checkNameTh($nameTh, $lastNameTh) {
		$result = null;
		$strSql = "SELECT nameth, lastnameth";
		$strSql .= " FROM profiles";
		$strSql .= " WHERE nameth = '".$nameTh."'";
		$strSql .= " AND lastnameth = '".$lastNameTh."'";
		$strSql .= ";";
		//$this->log("strSql => ".$strSql);
	
		try {
   			$result = $this->query($strSql);
   		} catch ( Exception $e ) {
   			$this->log("exception => ".$e->getMessage());
   		}// try catch
	
		return $result;
	}// checkNameTh
	/* ------------------------------------------------------------------------------------------------------- */
	public function checkNameEng($nameEng, $lastNameEng) {
		$result = null;
		$strSql = "SELECT nameeng, lastnameeng";
		$strSql .= " FROM profiles";
		$strSql .= " WHERE nameeng = '".$nameEng."'";
		$strSql .= " AND lastnameeng = '".$lastNameEng."'";
		$strSql .= ";";
		//$this->log("strSql => ".$strSql);
	
		try {
   			$result = $this->query($strSql);
   		} catch ( Exception $e ) {
   			$this->log("exception => ".$e->getMessage());
   		}// try catch
	
		return $result;
	}// checkNameEng
	/* ------------------------------------------------------------------------------------------------------- */
	public function searchByStmtSql($stmt_sql){
		$result = null;
		$strSql = "SELECT * FROM profiles WHERE $stmt_sql";
		//$this->log("strSql => ".$strSql);
	
		try {
   			$result = $this->query($strSql);
   		} catch ( Exception $e ) {
   			$this->log("exception => ".$e->getMessage());
   		}
	
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------------- */
	public function getDataByIsApprove($is_approve){
		$result = null;
		$strSql = "SELECT * FROM profiles WHERE is_approve='$is_approve'";
		//$this->log("strSql => ".$strSql);
	
		try {
   			$result = $this->query($strSql);
   		} catch ( Exception $e ) {
   			$this->log("exception => ".$e->getMessage());
   		}
	
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------------- */
	public function getDataById($id){
		$result = null;
		$strSql = "SELECT * FROM profiles WHERE id='$id'";
		//$this->log("strSql => ".$strSql);
	
		try {
   			$result = $this->query($strSql);
   		} catch ( Exception $e ) {
   			$this->log("exception => ".$e->getMessage());
   		}
	
		return $result;
	}
	/* ------------------------------------------------------------------------------------------------------- */
	public function updateIsApprove($id,$is_approve){
		$flag = false;
		$strSql = "UPDATE profiles 
					SET is_approve='$is_approve',
					updated_at=now()
					WHERE id='$id'";
		//$this->log("strSql => ".$strSql);
	
		try {
   			$this->query($strSql);
   			
   			$flag = true;
   		} catch ( Exception $e ) {
   			$this->log("exception => ".$e->getMessage());
   		}
	
		return $flag;
	}
}
?>