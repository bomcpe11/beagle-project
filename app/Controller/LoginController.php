<?php
App::uses('CakeEmail', 'Network/Email');

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
		$alterkey = md5('MyJSTP_'.$txt_name.'_'.$txt_surname.'_'.time());
// 		$txt_username = $this->request->data["txt_username"];
// 		$txt_password = $this->request->data["txt_password"];
		
		//TODO: check data
		//TODO: check is_approve != 1 (Inactive)
		$data = $this->Profile->checkforsignin($select_cardtype, $txt_cardid, $txt_name, $txt_surname, $this->changeFormatDate($txt_birthdate), $txt_email);
// 		$this->log('checkforsignin : '.print_r($data, true));
		if(count($data)==1){ //Found data.
			$this->Profile->signinactivate($data[0]['profiles']['id'], $select_cardtype, $txt_cardid, $txt_email, $alterkey);
// 			$this->loginFnc($txt_username, md5($txt_password), "false");
			//TODO: Send Email
			$rs_email = $this->sendEmail($txt_email, $data[0]['profiles']['id'], $alterkey);
			$this->log($rs_email);
			if($rs_email['status']){
				$result['status'] = true;
				$result['message'] = "ลงทะเบียนเรียบร้อย<br />กรุณาตรวจสอบอีเมล์เพื่อกำหนด Username, Passsword ในขั้นตอนต่อไป";
			}else{
				$result['message']='ไม่สามารถส่งออกอีเมล์ได้ กรุณาติดต่อผู้ดูแลเว็บไซต์';
			}
		}else if(count($data)>1){
			$result['message']='พบข้อมูลซ้ำซ้อน กรุณาติดต่อผู้ดูแลเว็บไซต์';
		}else{
			//Not found data.
			$result['message']='ไม่พบข้อมูลนี้';
		}
		
		$this->layout = "ajax_public";
		$this->set("message", json_encode(array("result" => $result)));
		$this->render("response");
		
		$this->log("END :: LoginController -> signinmember_submit()");
	}
	
	public function forgotPassword(){
		$this->log("START :: LoginController -> forgotPassword()");
		
		$result['flg'] = '0';
		$result['msg'] = 'เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ';
		//$this->log($this->request->data);
		$card_type = $this->request->data['card_type'];
		$card_id = $this->request->data['card_id'];
		$name = $this->request->data['name'];
		$surname = $this->request->data['surname'];
		$birthdate = $this->changeFormatDate($this->request->data['birthdate']);
		$email = $this->request->data['email'];
		
		$dataProfile = $this->Profile->checkForChangePassword($card_type, 
																$card_id, 
																$name, 
																$surname, 
																$birthdate, 
																$email);
		if( count($dataProfile)===1 ){
			try{
				$alterkey = md5('MyJSTP_'.$name.'_'.$surname.'_'.time());
				
				$db = $this->Profile->getDataSource();
				$db->begin();
				if( $this->Profile->updateAlterKey($alterkey, $dataProfile[0]['p']['id']) ){
					$db->commit();
					
					// $reglink = 'http://www.myjstp.org/Register?id='.$id.'&key='.$alterkey.'';
					$link = Router::url('/Login/resetPassword?id='.$dataProfile[0]['p']['id']
											.'&key='.$alterkey, true);
					$content = "<b>MyJSTP Register, Please click this link</b><br/>"
								."<a href=\"$link\" target=\"_blank\">$link</a>";
					//$this->log($content);
					
					$cakeEmail = new CakeEmail('jstpEmail');
					$cakeEmail->template('jstphub_email', 'jstphub_email');
					$cakeEmail->emailFormat('html');
					$cakeEmail->from(array('admin-noreply@myjstp.org' => 'MyJSTP Administrator'));
					$cakeEmail->to($email);
			        $cakeEmail->subject('MyJSTP : Reset Password');
			        $cakeEmail->send($content);
			        
			        $result['flg'] = '1';
					$result['msg'] = 'ระบบได้ส่งลิงค์สำหรับเปลี่ยนรหัสผ่าน ไปยังอีเมล์ของคุณ เรียบร้อยแล้ว';	
				}else{
					$db->rollback();
					
					$result['flg'] = '0';
		       	 	$result['msg'] = 'ไม่สามารถส่งออกอีเมล์ได้ กรุณาติดต่อผู้ดูแลเว็บไซต์';
				}
			}catch(Exception $e){
				$this->log($e->getMessage());
				
				$result['flg'] = '0';
		        $result['msg'] = 'เกิดข้อผิดพลาด กรุณาติดต่อผู้ดูแลระบบ';
			}
												
		}else{
			$result['flg'] = '0';
			$result['msg'] = 'ข้อมูลที่คุณกรอก ไม่ถูกต้อง';
		}
		//$this->log($result);
		
		$this->layout = 'ajax_public';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	
	public function resetPassword(){
		$this->log("START :: LoginController -> resetPassword()");
		
		$id = $this->request->query['id'];
		$key = $this->request->query['key'];
		
		$dataProfile = $this->Profile->checkAlterKey($id, $key);
		if( count($dataProfile)===1 ){
			$this->set(compact('dataProfile'));
			$this->render('reset_password');
		}else{
			$this->redirect(array('controller' => 'Login',
									'action' => 'index'));
		}
	}
	
	public function submitResetPassword(){
		$this->log("START :: LoginController -> submitResetPassword()");
		
		$result['flg'] = '0';
		$result['msg'] = 'เกิดข้อผิดผลาด กรุณาติดต่อผู้ดูแลระบบ';
		//$this->log($this->request->data);
		$id = $this->request->data['id'];
		$username = $this->request->data['username'];
		$password = $this->request->data['password'];
		$rePassword = $this->request->data['rePassword'];
		
		$db = $this->Profile->getDataSource();
		$db->begin();
		if( $this->Profile->resetPassword(md5($password), $id) ){
			$db->commit();
			
			$result['flg'] = '1';
			$result['msg'] = 'แก้ไขรหัสผ่าน สำเร็จ';
		}else{
			$db->rollback();
			
			$result['flg'] = '0';
			$result['msg'] = 'เกิดข้อผิดผลาด กรุณาติดต่อผู้ดูแลระบบ';
		}
		//$this->log($result);
		
		$this->layout = 'ajax_public';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	
	private function sendEmail($recipient, $id, $alterkey){
		$this->log('---- LoginController -> sendEmail ----');
	
		$result = array();
		$result['status'] = false;
// 		$objUser = $this->getObjUser();
// 		//$this->log($objUser);
// 		/* fullName */
// 		if( $objUser['position'] ){
// 			$fullNameTh = $objUser['position'].$objUser['nameth'].' '.$objUser['lastnameth'];
// 		} else{
// 			$fullNameTh = $objUser['titleth'].$objUser['nameth'].' '.$objUser['lastnameth'];
// 		}

// 		$reglink = 'http://www.myjstp.org/Register?id='.$id.'&key='.$alterkey.'';
		$reglink = Router::url('/Register?id='.$id.'&key='.$alterkey, true);
		
// 		$recipient = $this->request['data']['email_send_to'];
		$subject = 'MyJSTP : REGISTER';
		//$content = substr(trim($this->request['data']['email_text']), 3, -4);	// delete whitespace and <p></p>
		$content = '<b>MyJSTP Register, Please click this link</b><br />'
				.'<a href="'.$reglink.'">'.$reglink.'</a>';
	
// 		$db = $this->EmailHistory->getDataSource();
// 		$db->begin();
// 		if( $this->EmailHistory->insert($objUser['id'],
// 				$recipient,
// 				$subject,
// 				$content) ){
			try{
				$email = new CakeEmail('jstpEmail');
				$email->template('jstphub_email', 'jstphub_email');
				$email->emailFormat('html');
				$email->from(array('admin-noreply@myjstp.org' => 'MyJSTP Administrator'));
				$email->to($recipient);
				$email->subject($subject);
				$email->send($content);
	
// 				$result['flg'] = '1';
				$result['status'] = true;
				$result['msg'] = 'ดำเนินการส่ง Email เสร็จเรียบร้อย';
			}catch(Exception $e){
				$this->log($e->getMessage());
	
				$result['status'] = false;
				$result['msg'] = 'เกิดข้อผิดพลาดในการส่ง Email กรุณาติดต่อผู้ดูแลระบบ';
			}
// 		}else{
// 			$result['flg'] = '2';
// 			$result['msg'] = 'เกิดข้อผิดพลาดในการส่ง Email กรุณาติดต่อผู้ดูแลระบบ';
// 		}
	
// 		if( $result['flg']==='1' ){
// 			$db->commit();
// 		}else{
// 			$db->rollback();
// 		}
	
// 		$this->redirect(
// 				array('controller' => 'emailsender',
// 						'action' => 'index',
// 						'?' => array('flg' => $result['flg']))
// 		);
		return $result;
	}
	
	/*private function genKey(){
		$reuslt = '';
		$charecter = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		
		try{
			for( $i=0;$i<8;$i++ ){
				$reuslt .= $charecter[mt_rand(0, strlen($charecter)-1)];
			}
		}catch(Exception $e){
			throw new Exception($e);
		}
		
		return $reuslt;
	}*/
	
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