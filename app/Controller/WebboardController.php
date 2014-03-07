<?php
class WebboardController extends AppController {
	/*
	 * REFERENCE : http://www.thaicreate.com/free-web-script/php-create-webboard-mysql.html
	 */
	/* ------------------------------------------------------------------------------------------------ */
	public $names = 'WebboardController';
	public $uses = array('Webboard', 'WebboardReply');
	/* ------------------------------------------------------------------------------------------------ */
	public function index(){
		$this->log('---- WebboardController -> index ----');
		$this->setTitle('Webboard');
		
		$Per_Page = 10;
		$Page = @$this->request->query['Page'];
		if(!$Page){
			$Page=1;
		}
		//$xxx = 'xxx';
		
		$Prev_Page = $Page-1;
		$Next_Page = $Page+1;
		$Num_Rows=$this->Webboard->countAllRecord();
		
		$Page_Start = (($Per_Page*$Page)-$Per_Page);
		if($Num_Rows<=$Per_Page)
		{
			$Num_Pages =1;
		}
		else if(($Num_Rows % $Per_Page)==0)
		{
			$Num_Pages =($Num_Rows/$Per_Page) ;
		}
		else
		{
			$Num_Pages =($Num_Rows/$Per_Page)+1;
			$Num_Pages = (int)$Num_Pages;
		}
		
		
		$webboard_result = $this->Webboard->getWebboardsLimit($Page_Start , $Per_Page);
		//$this->log($webboard_result);

		$this->set('webboard_result', $webboard_result);
		$this->set('Prev_Page', $Prev_Page);
		$this->set('Next_Page', $Next_Page);
		$this->set('Num_Pages', $Num_Pages);
		$this->set('Num_Rows', $Num_Rows);
		$this->set('Page', $Page);
	}
	
	public function newTopic(){
		$this->log('---- WebboardController -> newTopic ----');
		$this->setTitle('Webboard - New Topic');
		
	}
	
	public function viewWebboard(){
		$this->log('---- WebboardController -> viewWebboard ----');
		$this->setTitle('Webboard - View');
		
		$questionId = @$this->request->query['QuestionID'];
		$webboard = array();
		$replies = array();
		
		if($questionId){
			$webboard = $this->Webboard->getWebboard($questionId);
			$this->Webboard->incrementView($questionId);
			$replies = $this->WebboardReply->getWebboardReplyQuestionId($questionId);
		}else{
			//When not find QuestionID
		}
		
		$this->set('webboard', $webboard);
		$this->set('replies', $replies);
	}
	
	public function ajaxSubmitNewTopic(){
		$this->log('---- WebboardController -> ajaxSubmitNewTopic ----');
		
		$txtQuestion = $this->request->data['txtQuestion'];
		$txtDetails = $this->request->data['txtDetails'];
		$txtName = $this->request->data['txtName'];
		
		$result = array();
		
		if($this->Webboard->insertData($txtQuestion, $txtDetails, $txtName)){
			$result['flg'] = 1;
			$result['msg'] = "Complete";
		} else {
			$result['flg'] = -1;
			$result['msg'] = "เกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์";
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	
	public function ajaxSubmitReply(){
		$this->log('---- WebboardController -> ajaxSubmitReply ----');
		
// 		$this->log($this->request->data);
		$hidQuestionID = $this->request->data['hidQuestionID'];
		$txtDetails = $this->request->data['txtDetails'];
		$txtName = $this->request->data['txtName'];
		
		$result = array();
		
		if($this->WebboardReply->insertData($hidQuestionID, $txtDetails, $txtName)){
			$this->Webboard->incrementReply($hidQuestionID);
			$result['flg'] = 1;
			$result['msg'] = "Complete";								
		} else {
			$result['flg'] = -1;
			$result['msg'] = "เกิดข้อผิดพลาด กรุณาติดต่อเจ้าหน้าที่ดูแลเว็บไซต์";
		}
		
		$this->layout='ajax';
		$this->set('message', json_encode($result));
		$this->render('response');
	}
	
}// WebboardController