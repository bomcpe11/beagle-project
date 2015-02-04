<?php
class Comming extends AppModel {
	
	private $fields = ' id_come, before_name, first_name, family_name, nickname, sex, year, province_id, spply ';
	
	public function getProfiles(){
		$result = $this->query('select * from commings');
		return $result;
	}
	
	public function getProfilesLimit(){
		$result = $this->query('select * from commings p limit 0, 200');
		return $result;
	}
	
	public function getProfilesByLimit($start,$recordPerPage,$orderBy, $sort){
		$result = array();
		$sql = 'select '.$fields.' from commings p';
		if( $orderBy==='birthday' ){
			$order = " order by p.{$orderBy} $sort";
		}else{
			$order = " order by p.{$orderBy} $sort";
		}
		$limit = " limit $start, $recordPerPage";
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
		$strSql = "DELETE FROM commings ";
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
	public function insert($id_come,
							$ps,
							$before_name,
							$first_name,
							$family_name,
							$card_id,
							$nickname,
							$sex,
							$birthday,
							$year,
							$father,
							$father_career,
							$mother,
							$mother_carrer,
							$address,
							$address2,
							$address3,
							$street,
							$locality,
							$district,
							$province_id,
							$zip_code,
							$telephone,
							$mobilephone,
							$fax,
							$email,
							$contact_parent,
							$relation,
							$parent_phone,
							$level_education,
							$school,
							$primary_school,
							$project,
							$spply,
							$result,
							$infor,
							$infor2) {
		$flag = false;
		$strSql = "INSERT INTO commings";
		$strSql .= " (id_come, ps, before_name, first_name, family_name, card_id, nickname, sex, birthday, year, father, father_career, mother, mother_carrer, address, address2, address3, street, locality, district, province_id, zip_code, telephone, mobilephone, fax, email, contact_parent, relation, parent_phone, level_education, school, primary_school, project, spply, result, infor, infor2) ";
		$strSql .= " VALUES";
		$strSql .= " (";
		$strSql .= " '".$id_come."',";		//$strSql .= " '1',";
		$strSql .= " '".$ps."',";			//$strSql .= " 'ggg',";
		$strSql .= " '".$before_name."',";	//$strSql .= " 'นาย',";
		$strSql .= " '".$first_name."',";	//$strSql .= " 'ชินวัตร',";
		$strSql .= " '".$family_name."',";	//$strSql .= " 'บุญขันธ์',";
		$strSql .= " '".$card_id."',";		//$strSql .= " '1451000107633',";
		$strSql .= " '".$nickname."',";		//$strSql .= " 'บอม',";
		$strSql .= " '".$sex."',";			//$strSql .= " 'ชาย',";
		$strSql .= " '".$birthday."',";		//$strSql .= " '1987-10-04',";
		$strSql .= " '".$year."',";			//$strSql .= " '27',";
		$strSql .= " '".$father."',";		//$strSql .= " 'สุระ บุญขันธ์',";
		$strSql .= " '".$father_career."',";	//$strSql .= " 'รับราชการ',";
		$strSql .= " '".$mother."',";		//$strSql .= " 'พิกุล บุญขันธ์',";
		$strSql .= " '".$mother_carrer."',";	//$strSql .= " 'รับราชการ',";
		$strSql .= " '".$address."',";	//$strSql .= " '159/1',";
		$strSql .= " '".$address2."',";	//$strSql .= " '11',";
		$strSql .= " '".$address3."',";	//$strSql .= " '[address3]',";
		$strSql .= " '".$street."',";	//$strSql .= " '[street]',";
		$strSql .= " '".$locality."',";	//$strSql .= " 'ภูเงิน',";
		$strSql .= " '".$district."',";	//$strSql .= " 'เสลภูมิ',";
		$strSql .= " '".$province_id."',";	//$strSql .= " '45',";
		$strSql .= " '".$zip_code."',";		//$strSql .= " '45120',";
		$strSql .= " '".$telephone."',";	//$strSql .= " '[telephone]',";
		$strSql .= " '".$mobilephone."',";	//$strSql .= " '0850046972',";
		$strSql .= " '".$fax."',";		//$strSql .= " '[fax]',";
		$strSql .= " '".$email."',";	//$strSql .= " 'bomcpe11@gmail.com',";
		$strSql .= " '".$contact_parent."',";	//$strSql .= " 'นางพิกุล บุญขันธ์',";
		$strSql .= " '".$relation."',";		//$strSql .= " 'มารดา',";
		$strSql .= " '".$parent_phone."',";		//$strSql .= " '0895767574',";
		$strSql .= " '".$level_education."',";		//$strSql .= " 'ปริญญาตรี',";
		$strSql .= " '".$school."',";		//$strSql .= " 'มหาวิทยาลัยเทคโนโลยีสุรนารี',";
		$strSql .= " '".$primary_school."',";		//$strSql .= " 'โรงเรียนศรีอรุณวิทย์ เสลภูมิ',";
		$strSql .= " '".$project."',";		//$strSql .= " '[project]',";
		$strSql .= " '".$spply."',";		//$strSql .= " '1',";
		$strSql .= " '".$result."',";		//$strSql .= " '[result]',";
		$strSql .= " '".$infor."',";		//$strSql .= " '[infor]',";
		$strSql .= " '".$infor2."',";		//$strSql .= " '[infor2]'";
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
	
	/* ------------------------------------------------------------------------------------------------------- */
	public function getDataForPsearch($keyWord,
										$searchWidth,
										$flagActivity,
										$start,
										$recordPerPage,
										$orderBy,
										$sort){
		$result = array();
		$resultAll = array();
		$resultLimit = array();
		$nowYear = date('Y');

		$sql = "SELECT * 
					FROM commings p
					WHERE ";
		
		$sqlCondition = "";
		$countSearchWidth = count($searchWidth);
		for( $i=0;$i<$countSearchWidth;$i++ ){
			if( $searchWidth[$i]==='age' ){
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
			$order = " order by p.{$orderBy} $sort";
		}else{
			$order = " order by p.{$orderBy} $sort";
		}
		$limit = " limit $start, $recordPerPage";
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