<?php
App::uses('CakeEmail', 'Network/Email');
class EmailsenderController extends AppController{
	/* -------------------------------------------------------------------------------------------------- */
	public $names = 'EmailsenderController';
	public $uses = array('Profile','EmailHistory');
	public $layout = 'default_new';
	/* -------------------------------------------------------------------------------------------------- */
	public function index(){
		$this->log('---- EmailsenderController -> index ----');
		
		$objUser = $this->getObjUser();
		
		$emailHistory = $this->EmailHistory->getDataByProfileId($objUser['id']);
		//$this->log($emailHistory);
		
		$this->set(compact('emailHistory'));
	}
	/* -------------------------------------------------------------------------------------------------- */
	public function sendEmail(){
		$this->log('---- EmailsenderController -> sendEmail ----');
		
		$result = array();
		$objUser = $this->getObjUser();
		//$this->log($this->request['data']);
		$recipient = $this->request['data']['email_send_to'];
		$subject = $this->request['data']['email_subject'];
		//$content = substr(trim($this->request['data']['email_text']), 3, -4);	// delete whitespace and <p></p>
		$content = trim($this->request['data']['email_text']);	// delete whitespace
		
		$db = $this->EmailHistory->getDataSource();
		$db->begin();
		if( $this->EmailHistory->insert($objUser['id'],
											$recipient,
											$subject,
											$content) ){
			try{
				$email = new CakeEmail();
				$email->config('jstphubEmail');
				$email->template('jstphub_email', 'jstphub_email');
				$email->emailFormat('html');
		        $email->from($objUser['email']);
		        $email->to($recipient);
		        $email->subject($subject);
		        $email->send($content);
		        
		        $result['flg'] = '1';
		        $result['msg'] = 'ดำเนินการส่ง Email เสร็จเรียบร้อย';
			}catch(Exception $e){
				$this->log($e->getMessage());
				
				$result['flg'] = '-1';
		        $result['msg'] = 'เกิดข้อผิดพลาดในการส่ง Email กรุณาติดต่อผู้ดูแลระบบ';
			}
		}else{
			$result['flg'] = '-1';
			$result['msg'] = 'เกิดข้อผิดพลาดในการส่ง Email กรุณาติดต่อผู้ดูแลระบบ';
		}
		
		if( $result['flg']==='1' ){
			$db->commit();
		}else{
			$db->rollback();
		}
		
		$this->redirect(
							array('action' => 'index',
									'?' => array('flg' => $result['flg']))
						);
	}
	/* -------------------------------------------------------------------------------------------------- */
	/**
	 * Ajax function
	 */
	public function getEmailById(){
		$this->log('---- EmailsenderController -> getEmailById ----');
		
		$id = $this->request->data['id'];
		$result = $this->EmailHistory->getDataById($id);
		
		$this->layout = 'ajax';
		$this->set('message',json_encode($result));
		$this->render('response');
	}
}