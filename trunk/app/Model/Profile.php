<?php
class Profile extends AppModel {
	
	public function getProfiles(){
		$result = $this->query('select * from profiles');
		return $result;
	}
	
	public function getProfilesLimit(){
		$result = $this->query('select * from profiles p limit 0, 200');
		return $result;
	}
	
	public function getProfilesByLimit($start,$end,$orderBy){
		$result = array();
		$sql = 'select * from profiles p';
		if( $orderBy==='birthday' ){
			$order = " order by p.{$orderBy} desc";
		}else{
			$order = " order by p.{$orderBy} asc";
		}
		$limit = " limit $start, $end";
		$this->log($sql.$order.$limit);
		
		try{
			$resultAll = $this->query($sql.$order);
			$resultLimit = $this->query($sql.$order.$limit);
			$result = array('total_data' => count($resultAll),
								'data' => $resultLimit);
			//$this->log($resultAll);
		}catch( Exception $e ){
			$this->log("exception => ".$e->getMessage());
		}
		
		return $result;
	}
	
	public function removeProfile($id){
		$flag = false;
		$strSql = "DELETE FROM profiles ";
		$strSql .= "WHERE id='".$id."'";
		$strSql .= ";";
		//$this->log("strSql => ".$strSql);
			
		try {
			$this->query($strSql);
		
			$flag = true;
		} catch ( Exception $e ) {
			$this->log("exception => ".$e->getMessage());
		}// try catch
			
		return $flag;
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
  		$strSql .= " ".$cardid;
 		$strSql .= " ,".$cardtype;
 		$strSql .= " ,'".$nameth."'";
  		$strSql .= " ,'".$lastnameth."'";
  		$strSql .= " ,'".$nameeng."'";
  		$strSql .= " ,'".$nickname."'";
  		$strSql .= " ,'".$generation."'";
  		$strSql .= " ,'".$birthday."'";
  		$strSql .= " ,'".$nationality."'";
  		$strSql .= " ,'".$religious."'";
  		$strSql .= " ,'".$socialstatus."'";
  		$strSql .= " ,'".$studystatus."'";
  		$strSql .= " ,'".$address."'";
  		$strSql .= " ,'".$telphone."'";
  		$strSql .= " ,'".$celphone."'";
  		$strSql .= " ,'".$email."'";
  		$strSql .= " ,'".$blogaddress."'";
  		$strSql .= " ,'".$image_file."'";
  		$strSql .= " ,'".$image_desc."'";
  		$strSql .= " ,sysdate()";
  		$strSql .= " ,sysdate()";
  		$strSql .= " ,'".$lastnameeng."'";
  		$strSql .= " ,'".$titleth."'";
  		$strSql .= " ,'".$titleen."'";
  		$strSql .= " ,'".$position."'";
  		$strSql .= " ,'".$login."'";
  		$strSql .= " ,'".$encrypt_password."'";
  		$strSql .= " ,'".$role."'";
  		$strSql .= " ,'".$login_count."'";
  		$strSql .= " ,'".$failed_login_count."'";
  		$strSql .= " ,'".$last_login_at."'";
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
	
	public function addnewmember($cardtype, $cardid, $name, $lastname, $birthdate, $email){
		$flag = false;
		$strSql = "INSERT INTO profiles(cardtype, cardid, nameth, lastnameth, birthday, email)";
		$strSql .= "VALUES('".$cardtype."', '".$cardid."', '".$name."', '".$lastname."', '".$birthdate."', '".$email."')";
		$strSql .= ";";
		//$this->log("strSql => ".$strSql);
		 
		try {
			$this->query($strSql);
		
			$flag = true;
		} catch ( Exception $e ) {
			$this->log("exception => ".$e->getMessage());
		}// try catch
		 
		return $flag;
	}//addnewmember
	
	public function checkforsignin($cardtype, $cardid, $name, $lastname, $birthdate, $email){
		$result = null;
		$strSql = "SELECT * FROM profiles WHERE (nameth='".$name."' AND lastnameth='".$lastname."') "
				. "AND (cardid='".$cardid."' OR birthday='".$birthdate."' OR email='".$email."') "
				. "AND NOT is_approve=1";
		$this->log("strSql => ".$strSql);
		
		try {
			$result = $this->query($strSql);
		} catch ( Exception $e ) {
			$this->log("exception => ".$e->getMessage());
		}// try catch
		
		return $result;
	}
	
	public function checkForChangePassword($cardtype, $cardid, $name, $lastname, $birthdate, $email){
		$result = null;
		$strSql = "SELECT p.* FROM profiles p WHERE nameth='".$name."' AND lastnameth='".$lastname."' "
				. "AND cardid='".$cardid."' AND birthday='".$birthdate."' AND email='".$email."' ";
		$this->log("strSql => ".$strSql);
		
		try {
			$result = $this->query($strSql);
		} catch ( Exception $e ) {
			$this->log("exception => ".$e->getMessage());
		}// try catch
		
		return $result;
	}
	
	public function updateAlterKey($alterKey, $id){
		$flg = false;
		$sql = "UPDATE profiles
				SET alterkey='".$alterKey."'
				WHERE id='$id'";
		
		try {
			$this->query($sql);
			$flg = true;
		} catch (Exception $e) {
			$this->log($e->getMessage());
		}
		
		return $flg;
	}
	
	public function signinactivate($id, $cardtype, $cardid, $email, $alterkey){
		$flag = false;
		$sql = "UPDATE profiles
				SET cardtype='".$cardtype."'
				,cardid='".$cardid."'
				,email='".$email."'
				,alterkey='".$alterkey."'
				,is_approve='0'
				,updforsearchflg='1'
				WHERE id='$id'";
		
		try {
			$this->query($sql);
			$flag = true;
		} catch (Exception $e) {
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	
	public function checkAlterKey($id, $alterkey){
		$result = null;
		$strSql = "SELECT * FROM profiles WHERE id='".$id."' AND alterkey='".$alterkey."'";
		$this->log("strSql => ".$strSql);
		
		try {
			$result = $this->query($strSql);
		} catch ( Exception $e ) {
			$this->log("exception => ".$e->getMessage());
		}// try catch
		
		return $result;
	}
	
	public function resetPassword($newPassword, $id) {
		$flg = false;
		$sql = "UPDATE profiles
					 	SET encrypt_password = '$newPassword',
					 	alterkey='',
					 	updated_at=now()
					 WHERE id = '$id'";
		$this->log($sql);
		
		try {
			$this->query($sql);
			$flg = true;
		}catch( Exception $e ){
			$this->log("exception => ".$e->getMessage());
		}
		
		return $flg;
	}
	
	public function setUPactivate($id, $login, $password){
		$flag = false;
		$sql = "UPDATE profiles
				SET login='".$login."'
				,encrypt_password='".$password."'
				,alterkey=''
				,is_approve='1'
				WHERE id='$id'";
		
		try {
			$this->query($sql);
			$flag = true;
		} catch (Exception $e) {
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
	
	public function updateRoleAndRoleAdmin($id, $role, $roleadmin){
		$flag = false;
		$sql = "UPDATE profiles
				SET role='".$role."'
					,role_admin='".$roleadmin."'
				WHERE id='$id'";
		$this->log($sql);
		try {
			$this->query($sql);
			$flag = true;
		} catch (Exception $e) {
			$this->log($e->getMessage());
		}
		
		return $flag;
	}
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
									,$position
									,$blogAddress
									,$status) {
		$flag = false;
		$strSql = "UPDATE profiles";
		$strSql .= " SET titleth = '".$titleTh."'";
		$strSql .= " ,nameth = '".$nameTh."'";
		$strSql .= " ,lastnameth = '".$lastnameTh."'";
		$strSql .= " ,titleen = '".$titleEng."'";
		$strSql .= " ,nameeng = '".$nameEng."'";
		$strSql .= " ,lastnameeng = '".$lastnameEng."'";
		$strSql .= " ,nickname = '".$nickname."'";
		$strSql .= " ,generation = '".$generation."'";
		$strSql .= " ,birthday = '".$birthday."'";
		$strSql .= " ,nationality = '".$nationality."'";
		$strSql .= " ,religious = '".$religious."'";
		$strSql .= " ,socialstatus = '".$socialStatus."'";
		$strSql .= " ,studystatus = '".$studyStatus."'";
		$strSql .= " ,address = '".$address."'";
		$strSql .= " ,telphone = '".$telPhone."'";
		$strSql .= " ,celphone = '".$celPhone."'";
		$strSql .= " ,email = '".$email."'";
		$strSql .= " ,position = '".$position."'";
		$strSql .= " ,blogaddress = '".$blogAddress."'";
		$strSql .= " ,status = '".$status."'";
		$strSql .= " ,updated_at = now()";
		$strSql .= " ,updforsearchflg = '1'";
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
					 	,updforsearchflg='1'
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
	public function updateLastLogin($id){
		$flag = false;
		$sql = "UPDATE profiles
					SET last_login_at=now()
					WHERE id=$id";
		
		try {
			$this->query($sql);
			$flag = true;
		} catch ( Exception $e ) {
			$this->log("exception => ".$e->getMessage());
		}
		
		return $flag;
	}
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
	public function getDataForPsearch($keyWord,
										$searchWidth,
										$flagActivity,
										$start,
										$end,
										$orderBy){
		$result = array();
		$resultAll = array();
		$resultLimit = array();
		$nowYear = date('Y');
		if( $flagActivity==='1' ){
			$sql = "SELECT DISTINCT p.* 
						FROM profiles p, join_activities ja, activities a
						WHERE p.id=ja.profile_id
							AND ja.activity_id=a.id
							AND ";
		}else{
			$sql = "SELECT * 
						FROM profiles p
						WHERE ";
		}
		
		$sqlCondition = "";
		$countSearchWidth = count($searchWidth);
		for( $i=0;$i<$countSearchWidth;$i++ ){
			if( $searchWidth[$i]==='activities' ){
				if( strlen($sqlCondition)===0 ){
					$sqlCondition .= " a.name LIKE '%$keyWord%'";
				}else{
					$sqlCondition .= " OR a.name LIKE '%$keyWord%'";
				}
			}else if( $searchWidth[$i]==='age' ){
				if( is_numeric($keyWord) ){
					if( strlen($sqlCondition)===0 ){
						$sqlCondition .= " YEAR(p.birthday) = $nowYear-$keyWord";
					}else{
						$sqlCondition .= " OR YEAR(p.birthday) = $nowYear-$keyWord";
					}
				}
			}else{
				if( strlen($sqlCondition)===0 ){
					$sqlCondition .= " p.{$searchWidth[$i]} LIKE '%$keyWord%'";
				}else{
					$sqlCondition .= " OR p.{$searchWidth[$i]} LIKE '%$keyWord%'";
				}
			}
		}
		$sql = "$sql ( $sqlCondition )";
		if( $orderBy==='birthday' ){
			$order = " order by p.{$orderBy} desc";
		}else{
			$order = " order by p.{$orderBy} asc";
		}
		$limit = " limit $start, $end";
		$this->log($sql.$order.$limit);
	
		try {
   			$resultAll = $this->query($sql.$order);
   			$resultLimit = $this->query($sql.$order.$limit);
			
			$result = array('total_data' => count($resultAll),
							'data' => $resultLimit);
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