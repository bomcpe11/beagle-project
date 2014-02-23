<?php
class WebboardReply extends AppModel {
	public function getWebboardReplies(){
		$result = $this->query('select * from webboard_replies');
		return $result;
	}

	public function getWebboardReplyQuestionId($questionId){
		$result = $this->query("select * from webboard_replies where QuestionID='".$questionId."'");
		return $result;
	}
	
	public function insertData($questionId, $details, $name){
		
		$flag=false;
		
		$sql="INSERT INTO webboard_replies (QuestionID,CreateDate,Details,Name) VALUES ('".$questionId."', now(), '".$details."', '".$name."')";
		
		try{
			$this->query($sql);
			$flag = true;
		}catch(Exception $e){
			$this->log($e->getMessage());
		}
		
		return $flag;
		
	}
}
?>