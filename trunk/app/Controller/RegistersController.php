<?php
@header("content-type:text/html;charset=utf-8");
session_start();
class RegistersController extends AppController {
	/* ------------------------------------------------------------------------------------------------------ */
	public $names = "RegistersController";
	public $uses = array("Gvar"
						, "Profile");
	/* ------------------------------------------------------------------------------------------------------ */
	function index() {
		$this->log("START :: RegistersController -> index()");
	
		//// local variables ////
		$personalIdType = $this->Gvar->getVarcodeVardesc1ByVarname("PERSONAL_ID_TYPE");
		$namePrefixTh = $this->Gvar->getVarcodeVardesc1ByVarname("NAME_PREFIX_TH");
		$namePrefixEn = $this->Gvar->getVarcodeVardesc1ByVarname("NAME_PREFIX_EN");
		
		// send data to view
		$this->set("personalIdType", $personalIdType);
		$this->set("namePrefixTh", $namePrefixTh);
		$this->set("namePrefixEn", $namePrefixEn);
		
		$this->render("register");
	
		$this->log("END :: RegistersController -> index()");
	}// index
	/* ------------------------------------------------------------------------------------------------------ */
	function insertFnc() {
		$this->log("START :: RegistersController -> insertFnc()");
		
		//// local variables ////
		$result = "";
		/* request data */
		$cardtype = $this->request->data["cardtype"];
		$cardid = $this->request->data["cardid"];
		$titleth = $this->request->data["titleth"];
		$nameth = $this->request->data["nameth"];
		$lastnameth = $this->request->data["lastnameth"];
		$titleen = $this->request->data["titleen"];
		$nameeng = $this->request->data["nameeng"];
		$lastnameeng = $this->request->data["lastnameeng"];
		$nickname = $this->request->data["nickname"];
		$generation = $this->request->data["generation"];
		$birthday = $this->request->data["birthday"];
		$nationality = $this->request->data["nationality"];
		$religious = $this->request->data["religious"];
		$socialstatus = $this->request->data["socialstatus"];
		$studystatus = $this->request->data["studystatus"];
		$address = $this->request->data["address"];
		$telphone = $this->request->data["telphone"];
		$celphone = $this->request->data["celphone"];
		$email = $this->request->data["email"];
		$position = $this->request->data["position"];
		$blogaddress = $this->request->data["blogaddress"];
		$username = $this->request->data["username"];
		$password = $this->request->data["password"];
		$captcha_code = $this->request->data["captcha_code"];
		/* session */
		$sessionCaptchaCode = $this->Session->read("random_number");
		
		// check $captcha_code
		$this->log("### session captcha => ".$sessionCaptchaCode." ###");
		$this->log("### user captcha => ".$captcha_code." ###");
		if ( $captcha_code == $sessionCaptchaCode ) {
			$this->log("### captcha correct ###");
			$this->Profile->begin();
			// insert data
			if ( $this->Profile-> insert($cardid // $cardid
				  		, $cardtype	// $cardtype
				  		, $nameth	// $nameth
				  		, $lastnameth	// $lastnameth
				  		, $nameeng	// $nameeng
				 		, $nickname // $nickname
				  		, $generation	// $generation
				  		, $this->changeFormatDate($birthday)	// $birthday
				  		, $nationality	// $nationality
				  		, $religious	// $religious
				 		, $socialstatus	// $socialstatus
				 		, $studystatus	// $studystatus
				 		, $address	// $address
				  		, $telphone	// $telphone
				  		, $celphone	// $celphone
				  		, $email	// $email
				 		, $blogaddress	// $blogaddress
				  		, ""	// $image_file
				  		, ""	// $image_desc
				  		, ""	// $created_at
				  		, ""	// $updated_at
				  		, $lastnameeng	// $lastnameeng
				  		, $titleth	// $titleth
				  		, $titleen	// $titleen
				 		, $position	// $position
				 		, $username	// $login
				  		, md5($password)	// $encrypt_password
				  		, ""	// $role
				  		, ""	// $login_count
				  		, ""	// $failed_login_count
				 		, "") ) {	// $last_login_at
				$this->Profile->commit();
				
				$result = "";
			} else {
				$this->Profile->rollback();
			}// if else
		} else {
			$this->log("### captcha incorrect ###");
			
			$result = "captcha ไม่ถูกต้อง";
		}// if else
		
		// send data to view
		$this->layout = "ajax";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("START :: RegistersController -> insertFnc()");
	}// insertFnc
	/* ------------------------------------------------------------------------------------------------------ */
	public function changeFormatDate($data) {
		/*
		 * index of $explodeDate
		 * [0] = day
		 * [1] = month
		 * [2] = year(2013)
		 */
		$explodeDate = explode("/", $data);
		
		return ($explodeDate[2] - 543)."/".$explodeDate[1]."/".$explodeDate[0];
	}// changeFormatDate
}// RegistersController