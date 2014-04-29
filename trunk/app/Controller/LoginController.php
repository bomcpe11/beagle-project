<?php
class LoginController extends AppController {
	/* ------------------------------------------------------------------------------------------------------ */
	public $names = "LoginController";
	public $layout = "public";
	public $uses = array("Gvar", "Profile");
	public $components = array("Cookie");
	/* ------------------------------------------------------------------------------------------------------ */
	function index() {
		$this->log("---- LoginController -> index ----");
		
		$result = array();
		$cookieUsername = $this->Cookie->read("cookieUsername");
		$cookieEncryptPassword = $this->Cookie->read("cookieEncryptPassword");
		$personalIdType = array();
		
		if( !empty($cookieUsername) && !empty($cookieEncryptPassword) ){
			$result = $this->loginFnc($cookieUsername, $cookieEncryptPassword, true);
			
			if( $result['profile_id']!==-1 ){
				$this->redirect( array("controller" => "Mainmenu"));
			}
		}else{
			$personalIdType = $this->Gvar->getVarcodeVardesc1ByVarname("PERSONAL_ID_TYPE");
		}
		
		$this->set("personalIdType", $personalIdType);
		
		$this->render("login");
	}// index
	/* ------------------------------------------------------------------------------------------------------ */
	function loginAjax() {
		$this->log("---- LoginController -> loginAjax ----");
		
		//// local variables ////
		$result = null;
		$username = $this->request->data["username"];
		$password = $this->request->data["password"];
		$rememberMe = $this->request->data["rememberMe"];
		//$this->log($rememberMe);
		
		$result = $this->loginFnc($username, md5($password), $rememberMe);
		
		$this->layout = "ajax_public";
		$this->set("message", json_encode($result));
		$this->render("response");
	}// loginAjax
	/* ------------------------------------------------------------------------------------------------------ */
	private function loginFnc($username, $encryptPassword, $rememberMe) {
		$this->log("---- LoginController -> loginFnc ----");
		
		//// local variables ////
		$result = array();
		$cookieTimeOut = ((3600 * 24) * 30);  // or '1 month'
		
		// check username
		$checkUser = $this->Profile->checkLogin($username);
		if ( count($checkUser)===0 || $checkUser[0]['profiles']['is_approve']==0 ) { // username incorrect
			$result['msg'] = 'ไม่พบ Username นี้';
			$result['profile_id']=-1;
				
			$this->deleteCookie();
		} else if ( count($checkUser) == 1 ) { // username correct
			// check password
			if ( $encryptPassword == $checkUser[0]["profiles"]["encrypt_password"] ) { // password correct
				// update last_login_at
				$this->Profile->getDataSource();
				if( $this->Profile->updateLastLogin($checkUser[0]['profiles']['id']) ){
					$this->Profile->commit();
					
					// get objuser
					$objuser = $this->Profile->getDataById($checkUser[0]['profiles']['id']);
					
					// set SESSION
					$this->Session->write("objuser", $objuser[0]["profiles"]);
					$this->log("write session complete");
			
					// set COOKIE
					if( $rememberMe == "true" ){
						// set cookie
						$this->Cookie->time = $cookieTimeOut;
						$this->Cookie->write("cookieUsername", $username);
						$this->Cookie->write("cookieEncryptPassword", $encryptPassword);
						$this->log("write cookie complete");
					} else {
						$this->deleteCookie();
					}// if else
					
					$result['msg'] = '';
					$result['profile_id']=$objuser[0]['profiles']['id'];
				}else{
					$this->Profile->rollback();
					
					$result['msg'] = "เกิดข้อผิดพลาดใน การเข้าสู่ระบบ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์";
					$result['profile_id']=-1;
				}
			} else {	// password incorrect
				$result['msg'] = 'รหัสผ่านไม่ถูกต้อง';
				$result['profile_id']=-1;
		
				$this->deleteCookie();
			}// if else
		}else{
			$result['msg'] = "เกิดข้อผิดพลาดใน การเข้าสู่ระบบ กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์";
			$result['profile_id']=-1;
		}
		//$this->log($this->Session->read("objuser"));
		
		return $result;
	}// loginFnc
	/* ------------------------------------------------------------------------------------------------------ */
	private function deleteCookie(){
		$this->log("---- LoginController -> deleteCookie ----");
		
		$this->Cookie->delete("cookieUsername");
		$this->Cookie->delete("cookieEncryptPassword");
		$this->log("delete cookie complete");
	}
	
	public function signinmember_submit(){
		$this->log("START :: LoginController -> signinmember_submit()");
		
		$result['status'] = false;
		$result['message'] = '';
		
		$select_cardtype = $this->request->data["select_cardtype"];
		$txt_cardid = $this->request->data["txt_cardid"];
		$txt_name = $this->request->data["txt_name"];
		$txt_surname = $this->request->data["txt_surname"];
		$txt_birthdate = $this->request->data["txt_birthdate"];
		$txt_email = $this->request->data["txt_email"];
		$txt_username = $this->request->data["txt_username"];
		$txt_password = $this->request->data["txt_password"];
		
		//TODO: check data
		//TODO: check is_approve != 1 (Inactive)
		$data = $this->Profile->checkforsignin($select_cardtype, $txt_cardid, $txt_name, $txt_surname, $this->changeFormatDate($txt_birthdate), $txt_email);
// 		$this->log('checkforsignin : '.print_r($data, true));
		if(count($data)==1){ //Found data.
			$this->Profile->signinactivate($data[0]['profiles']['id'], $select_cardtype, $txt_cardid, $txt_email, $txt_username, $txt_password);
			$this->loginFnc($txt_username, md5($txt_password), "false");
			$result['status'] = true;
			$result['message'] = "ลงทะเบียนเรียบร้อย";
		}else if(count($data)>1){
			$result['message']='พบข้อมูลซ้ำซ้อน กรุณาติดต่อผู้ดูแลเว็บไซต์';
		}else{
			//Not found data.
			$result['message']='ไม่พบข้อมูลนี้';
		}
		
		
		//TODO: Insert db
		
// 		if(!empty($txt_cardid)){ $checkCardId = $this->Profile->checkCardId($txt_cardid); }
// 		if(!empty($txt_email)){ $checkEmail	= $this->Profile->checkEmail($txt_email); }
// 		$checkNameTh = $this->Profile->checkNameTh($txt_name, $txt_surname);
		
// 		if ( !empty($txt_cardid) && count($checkCardId) == 1 ) {
// 			$result['message'] = "เลขบัตรประจำตัว นี้มีข้อมูลแล้ว";
// 		} else if ( count($checkNameTh) == 1 ) {
// 			$result['message'] = "ชื่อ และ นามสกุล นี้มีข้อมูลแล้ว";
// 		} else if ( !empty($txt_email) && count($checkEmail) == 1 ) {
// 			$result['message'] = "อีเมล์ นี้มีข้อมูลแล้ว";
// 		} else{
// 			//TODO: Insert Data.
// 			$this->Profile->addnewmember($select_cardtype, $txt_cardid, $txt_name, $txt_surname, $this->changeFormatDate($txt_birthdate), $txt_email);
// 			$result['status'] = true;
// 			$result['message'] = "ลงทะเบียนเรียบร้อย";
// 		}
		
		$this->layout = "ajax_public";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: LoginController -> signinmember_submit()");
	}
	
	private function changeFormatDate($data) {
		/*
		 * index of $explodeDate
		* [0] = day
		* [1] = month
		* [2] = year(2013)
		*/
		$explodeDate = explode("/", $data);
	
		return ($explodeDate[2] - 543)."/".$explodeDate[1]."/".$explodeDate[0];
	}// changeFormatDate
}// LoginController