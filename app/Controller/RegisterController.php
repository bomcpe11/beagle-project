<?php
//session_start();
class RegisterController extends AppController {
	/* ------------------------------------------------------------------------------------------------------ */
	public $names = "RegisterController";
	public $layout = "public";
	public $components = array("Cookie");
	public $uses = array("Gvar"
						, "Profile");
	/* ------------------------------------------------------------------------------------------------------ */
	function index(){
		$this->log("START :: RegisterController -> index()");
// 		echo "<pre>"; print_r($this->request); echo "</pre>";

		$id = @$this->request->query['id'];
		$alterkey = @$this->request->query['key'];
		
		//TODO: check profileid & alterkey
		$rs_chkalterkey = $this->Profile->checkAlterKey($id, $alterkey);
// 		$this->log($rs_chkalterkey);
		if(count($rs_chkalterkey)>0 && $rs_chkalterkey[0]['profiles']['id']==$id && $rs_chkalterkey[0]['profiles']['alterkey']==$alterkey){
			
		}else{
			$this->redirect(array('controller' => 'Login'));
		}
		
		$this->log("END :: RegisterController -> index()");
	}
	
	function setUP(){
		$this->log("START :: RegisterController -> setUP()");
		
		$result['status'] = false;
		$result['message'] = '';
		
		$username 		= $this->request->data["username"];
		$password 		= $this->request->data["password"];
		$id 			= $this->request->data["profileid"];
		$alterkey 		= $this->request->data["profilekey"];
		
		$cookieTimeOut = (3600 * 24) * 30;  // or '1 month'
		
		//TODO: check profileid & alterkey again
		$rs_chkalterkey = $this->Profile->checkAlterKey($id, $alterkey);
		if($rs_chkalterkey[0]['profiles']['id']==$id && $rs_chkalterkey[0]['profiles']['alterkey']==$alterkey){

			//TODO: update DB
			
			if($this->Profile->setUPactivate($rs_chkalterkey[0]['profiles']['id'], $username, md5($password))){

				// set cookie
				$this->Cookie->time = $cookieTimeOut;
				$this->Cookie->write("cookieUsername", $username);
				$this->Cookie->write("cookieEncryptPassword", md5($password));
				$this->log("### write cookie complete ###");
				
				
				$result['status'] = true;
				$result['message'] = 'ยินดีต้อนรับสู่ MyJSTP';
				
			}else{
				$result['status'] = false;
				$result['message'] = 'ไม่สามารถลงทะเบียนได้ กรุณาติดผู้ดูแลระบบ';
			}
					
		}else{
			$result['status'] = false;
			$result['message'] = 'ตรวจสอบ Key ไม่ถูกต้อง กรุณาติดผู้ดูแลระบบ';
		}
		
		$this->layout = "ajax_public";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: RegisterController -> setUP()");
	}
	
	function index_bak20140502() {
		$this->log("START :: RegisterController -> index()");
	
		//// local variables ////
		$accountRole 	= $this->Gvar->getVarcodeVardesc1ByVarnameVardesc2("ACCOUNT_ROLE", "Y");
		$personalIdType = $this->Gvar->getVarcodeVardesc1ByVarname("PERSONAL_ID_TYPE");
		$namePrefixTh 	= $this->Gvar->getVarcodeVardesc1ByVarname("NAME_PREFIX_TH");
		$namePrefixEn 	= $this->Gvar->getVarcodeVardesc1ByVarname("NAME_PREFIX_EN");
		
		// send data to view
		$this->set(compact("accountRole", "personalIdType", "namePrefixTh", "namePrefixEn"));
		
		$this->log("END :: RegisterController -> index()");
	}// index
	/* ------------------------------------------------------------------------------------------------------ */
	function insertFnc() {
		$this->log("START :: RegisterController -> insertFnc()");
		
		//// local variables ////
		$result = "";
		/* request data */
		$accountRole 	= $this->request->data["accountRole"];
		$cardtype 		= $this->request->data["cardtype"];
		$cardid 		= $this->request->data["cardid"];
		$titleth 		= $this->request->data["titleth"];
		$nameth 		= $this->request->data["nameth"];
		$lastnameth 	= $this->request->data["lastnameth"];
		$titleen 		= $this->request->data["titleen"];
		$nameeng 		= $this->request->data["nameeng"];
		$lastnameeng 	= $this->request->data["lastnameeng"];
		$nickname 		= $this->request->data["nickname"];
		$generation 	= $this->request->data["generation"];
		$birthday 		= $this->request->data["birthday"];
		$nationality 	= $this->request->data["nationality"];
		$religious 		= $this->request->data["religious"];
		$socialstatus 	= $this->request->data["socialstatus"];
		$studystatus 	= $this->request->data["studystatus"];
		$address 		= $this->request->data["address"];
		$telphone 		= $this->request->data["telphone"];
		$celphone 		= $this->request->data["celphone"];
		$email 			= $this->request->data["email"];
		$position 		= $this->request->data["position"];
		$blogaddress 	= $this->request->data["blogaddress"];
		$username 		= $this->request->data["username"];
		$password 		= $this->request->data["password"];
		$captcha_code 	= $this->request->data["captcha_code"];
		/* session */
		$sessionCaptchaCode = $this->Session->read("random_number");
		/* cookie */
		$cookieTimeOut = (3600 * 24) * 30;  // or '1 month'
		
		// validate data
		$checkCardId = $this->Profile->checkCardId($cardid);
		$checkEmail	= $this->Profile->checkEmail($email);
		$checkNameTh = $this->Profile->checkNameTh($nameth, $lastnameth);
		$checkNameEn = $this->Profile->checkNameEng($nameeng, $lastnameeng);
		$checkUsername = $this->Profile->checkLogin($username);
		if ( count($checkCardId) == 1 ) {
			$result = "เลขบัตรประจำตัวประชาชน ซ้ำ";
		} else if ( count($checkEmail) == 1 ) {
			$result = "อีเมล์ ซ้ำ";
		} else if ( count($checkNameTh) == 1 ) {
			$result = "ชื่อ นามสกุล ภาษาไทย ซ้ำ";
		} else if ( count($checkNameEn) == 1 ) {
			$result = "ชื่อ นามสกุล ภาษาอังกฤษ ซ้ำ";
		} else if ( count($checkUsername) == 1 ) {
			$result = "username ซ้ำ";
		} else {
			// validate captcha
			$this->log("### session captcha => ".$sessionCaptchaCode." ###");
			$this->log("### user captcha => ".$captcha_code." ###");
			if ( $captcha_code == $sessionCaptchaCode ) {
				$this->log("### captcha correct ###");
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
				  		, $accountRole	// $role
				  		, ""	// $login_count
				  		, ""	// $failed_login_count
				 		, "") ) {
				 	$result = "ลงทะเบียนเรียบร้อย";
				 	
				 	// set cookie
				 	$this->Cookie->time = $cookieTimeOut;
				 	$this->Cookie->write("cookieUsername", $username);
				 	$this->Cookie->write("cookieEncryptPassword", md5($password));
				 	$this->log("### write cookie complete ###");
				} else {
					$result = "ไม่สามารถลงทะเบียนได้ กรุณาติดต่อผู้ดูแลระบบ";
				}// if else
			} else {
				$result = "captcha ไม่ถูกต้อง";
			}// if else
		}// if
		
		// send data to view
		$this->layout = "ajax";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: RegisterController -> insertFnc()");
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
}// RegisterController