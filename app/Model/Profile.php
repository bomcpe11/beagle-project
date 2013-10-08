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
   		$this->log($strSql);
   		
   		$flag = $this->query($strSql);
   		
   		return $flag;
	}// insert
	/* ------------------------------------------------------------------------------------------------------- */
	public function checkUsername($username) {
		$strSql = "SELECT * FROM profiles WHERE login = '".$username."';";
		$this->log($strSql);
		
		$result = $this->query($strSql);
		
		return $result;
	}// checkUsername
	/* ------------------------------------------------------------------------------------------------------- */
	public function checkPassword($password) {
		$strSql = "SELECT * FROM profiles WHERE encrypt_password = '".$password."';";
		$this->log($strSql);
	
		$result = $this->query($strSql);
	
		return $result;
	}// checkUsername
}
?>